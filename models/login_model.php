<?php

class Login_Model extends Model {
    private  $_data;

    function __construct() {
        parent::__construct();
    }
    function check_status(){
      if($status = parent::check_status()){
           if($user = $this->find($status)){
             $this->run();
            }
        }
        return false;
    }

    public function find($user = null) {
        if ($user) {
            $field = (is_numeric($user)) ? 'id' : 'email';
            $data = $this->db->get('users', array($field, '=', $user));

            if ($this->db->count()) {
                $this->_data = $this->db->first();
                return true;
            }
        }
        return false;
    }

    function hasPermission() {

        $role = $this->db->get('user_permissions',array('id', '=',$this->data()->user_perms_id));
        if ($this->db->count()) {
            $permissions = json_decode($this->db->first()->permissions, true);
            Session::put('role',$permissions['role']);
            Session::put('role_id',$this->data()->user_perms_id);
            Session::put('role_name',$this->db->first()->name);
            Redirect::to(URL.$this->db->first()->default_page);
            exit;
        }
        return false;
    }

    public function data() {
        return $this->_data;
    }

    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }

    public function login($username = null, $password = null, $remember = false) {
        if (!$username && !$password && $this->exists()) {
            //log user in
            Session::put($this->_sessionName, $this->data()->id);
        } else {
            $user = $this->find($username);

            if ($user) {
                print_r($this->data()->id);
                echo '<br/>';
                print_r($this->data()->password);
                echo '<br/>';
                print_r(Hash::make($password, $this->data()->salt));
                // die();
                if ($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    if($this->data()->verified === 'yes'){
                        Session::put($this->_sessionName, $this->data()->id);
                        //	return true;
                        if ($remember) {
                            $hash = Hash::unique();
                            $hashCheck = $this->db->get('user_sessions', array('user_id', '=', $this->data()->id));
                            if (!$this->db->count()) {
                                $this->db->insert('user_sessions', array(
                                    'user_id' => $this->data()->id,
                                    'hash' => $hash
                                ));
                            } else {
                                $hash = $this->db->first()->hash;
                            }

                            Cookie::put($this->_cookieName, $hash, Config::get('remember/cookie_expiry'));
                        }
                        $this->run();

                    }else{//user is not verified
                        Redirect::to(URL.'admission/step/done');
                    }

                }
            }
        }
        return false;
    }


    public function run() {
        cleanUP();
        $school = $this->db->fetch_last('schools', 'school_id');
        Session::put('school_name',$school['school_name']);
        Session::put('school_id',$school['school_id']);

        $data = $this->db->fetch_last('academic_sessions', 'session_id');
        Session::put('academic_session_name',$data['session_name']);
        Session::put('academic_session_id',$data['session_id']);

        $_SESSION['user_id'] = $this->data()->id;
        $_SESSION['email'] = $this->data()->email;
        Session::put('loggedIn',true);

            //activate my duties tab
        $duty = $this->data()->user_perms_id;
        if ($duty > 3) {
            $data =  $this->db->fetch_exact('info_staff','user_id',$this->data()->id);
            $me = $data['firstname'].' '.$data['surname'].' '.$data['othername'];
            Session::put('logged_in_user_name',$me);
            Session::put('logged_in_user_slug',$data['slug']);

            //$stat = $this->db->fetch_last('member_status','status_id','member_id',$data['person_id']);
            $photo = $data['profile_picture'];
            if(!empty($photo)){
                $myPhoto = URL.'public/uploads/profile-pictures/'.$photo;

            }else{
                if($data['sex']== 'male'){
                    $myPhoto = URL.'public/images/avatar-male.png';
                }else{
                    $myPhoto = URL.'public/images/avatar-female.png';
                }
            }
            Session::put('logged_in_user_photo',$myPhoto);
            //Session::put('logged_in_user_status',$stat['status']);

            $this->hasPermission();
            //return true;
        }elseif ($duty == 3) {

            Session::put('logged_in_user_name',$this->data()->portal_name);
            Session::put('logged_in_user_slug',$this->data()->portal_name);

            $myPhoto = URL.'public/images/education.jpg';
            Session::put('logged_in_user_photo',$myPhoto);

            $this->hasPermission();
            //return true;
        }else{
            $data =  $this->db->fetch_exact('info_personal','user_id',$this->data()->id);
            $me = $data['firstname'].' '.$data['surname'].' '.$data['othername'];
            Session::put('logged_in_user_name',$me);
            Session::put('logged_in_user_slug',$data['slug']);

            //$stat = $this->db->fetch_last('member_status','status_id','member_id',$data['person_id']);
            $photo = $data['profile_picture'];
            if(!empty($photo)){
                $myPhoto = URL.'public/uploads/profile-pictures/'.$photo;

            }else{
                if($data['sex']== 'male'){
                    $myPhoto = URL.'public/images/avatar-male.png';
                }else{
                    $myPhoto = URL.'public/images/avatar-female.png';
                }
            }
            Session::put('logged_in_user_photo',$myPhoto);
            //Session::put('logged_in_user_status',$stat['status']);
            if($duty == 2){
                Redirect::to(URL . "parent");
                exit;
            }else{
                Redirect::to(URL . "wall");
                exit;
            }
        }
    }

    public function check_details($detail){
        if($detail === 'code'){
            $data = $this->db->get('user_options', array('phone', '=', trim(Input::get($detail)),'user_id','=',Session::get('user_id')));

            if ($this->db->first()) {
                Session::put('code_verified',true);
                echo('detail_ok');
                exit();
            }else{
                echo('detail_exists');
                exit();
            }
        }else{
            $data = $this->db->get('users', array($detail, '=', trim(Input::get($detail))));

            if (!$this->db->count()) {
                echo('detail_ok');
                exit();
            }else{
                echo('detail_exists');
                exit();
            }

        }

    }


    public function recovery($email){
        //check whether email exist
        $user = $this->find($email);
        if($user){
            $hash = Hash::unique();
            try{
                $this->db->insert('user_options', array(
                    'email' => $email,
                    'date' => $this->today,
                    'temp_pass' => Hash::make($email, $hash),
                ));
                return urlencode($hash);
            }catch (Exception $e){
                return false;
            }
        }else{
            echo "not_found";
            exit();

        }
    }

    public function account_setup() {
        $salt = Hash::salt(32);
        $hash = Hash::unique();

        try {
            $this->db->insert('users', array(
                'email' => Input::get('email'),
                'phone_number' => Input::get('phone_number'),
                'portal_name' => Input::get('firstname').' '.Input::get('surname'),
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'joined' => $this->today,
                'verified' => 'yes',
                'lastLogin' => $this->today,
                'record_tracker' => $hash,
                'user_perms_id' => 1,

            ));


            cleanUP();

            Session::put('flash','Registration is successful');


            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function update_pass() {

        //find user using existing session
        $user = $this->db->fetch_exact('users','id', Session::get('user_id'));
        //check if current pass is correct
        $salt = Hash::salt(32);

        //replace current pass with new pass
        try {
            $this->db->update('users', array(
                'email' => Input::get('login_email'),
                'password' => Hash::make(Input::get('new_pass'), $salt),
                'salt' => $salt,
            ), 'id', Session::get('user_id'));

            $_SESSION['email'] = Input::get('login_email');

            Session::flash('home', 'Account Password successfully updated!');
            return true;
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
}

    function verify_phone(){
        $salt = Hash::randomDigits(12);
        return $salt;
        // Simple SMS send function
        function sendSMS($to, $message = null, $originator = 'School Edu',$key= '8ec7d31e9a2774') {
            $salt = Hash::salt(8);

            $message = 'Here is your verification/ activation code. <br/> '.$salt.'<br/> Please follow <a href="www.schooledu.com.ng">www.school.com</a> to complete your registration';
            $URL = "https://smstube.ng/api/sms/send?key=" . $key . "&to=" . $to;
            $URL .= "&text=".urlencode($message).'&from='.urlencode($originator);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $URL);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $output = curl_exec($ch);
            $info = curl_getinfo($ch);
            curl_close($ch);
            echo $output;
            return $output;
        }
        // Example of use
        /*
         For multiple destinations use sms/bulk instead of sms/send:
http(s)://smstube.ng/api/sms/bulk/key=yourkey&from=senderid&text=smstext&to[]=MOB1&to[]=MOB2&to[]=.....&to[]=MOBX

        *
         */
        // Simple SMS send function
        // Example of use
        $response = sendSMS(Input::get('phone_number'));
        echo $response;
        return $response;




    }

    function verify_email(){
        $salt = Hash::randomString(24);
        urlencode($salt);
        return $salt;

        // Email the user their activation link
        $email = Input::get('email');
        $to = $email;
        $from = "info@frogfreezone.com";
        $subject = 'School Education - Account Verification/ Activation';
        $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>School Education - Account Verification/ Activation</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;">
<div style="padding:10px; background:#333; font-size:24px; color:#CCC;">School Education - Account Verification/ Activation Details: '. date('D, d F, Y ')." at " .date(' h:i:s a').'</div><div style="padding:24px; font-size:17px;">
  <p>Hello dear, <br /><br />
    You have  recently applied to create an account on   <a href="http://judidaily.com.ng/">School Education</a><br />
  <br />
  This mail was sent to you in response to that request.</p>
  <p>You may please copy and paste the link below to continue your application or you may just click on it.</p>
  <p><br />
    <a href="http://localhost/www/doing/school_app/login/verify/'.urlencode($email).'/'.urlencode($salt).'">Click here to Proceed with your application now</a><br /><br />
    <b>Do not reply this mail. It is a system response from the application on <a href="http://judidaily.com.ng">School Education</a></b></p>
  <b>
  <p>Finally:</p> Please ignore this mail if you did not request it. Thanks</b></div></body></html>';
        $headers = "From: $from\n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
        //$headers .= 'Cc: nonso@frogfreezone.com' . "\r\n";
        //$headers .= 'Bcc: nonso@frogfreezone.com' . "\r\n";
        $headers .= 'Reply-To: '.$from.'' . "\r\n";
        if(!mail($to, $subject, $message, $headers)){
            return false;
        }else{
            return $salt;

        }
    }

}
