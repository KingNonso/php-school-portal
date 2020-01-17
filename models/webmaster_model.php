<?php

class Webmaster_Model extends Model {
    //private  $_data;

    function __construct() {
        parent::__construct();
    }

    function get_summary(){
        $students = $this->db->get('users',array('user_perms_id','=',3));
        $students = $this->db->count();

        $subject = $this->db->get('result_pins');
        $subject = $this->db->count();

        $classes = $this->db->get('academic_terms');
        $classes = $this->db->count();

        $result = $this->db->get('academic_sessions');
        $result = $this->db->count();

        return array($students,$subject,$classes,$result);
    }


    public function get_about($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('about_us', 'id',$id);
            $all =  $this->db->getAll_assoc('about_us');
            $count = $this->db->count_assoc();

            return array($data,$count);
        }else{
            $data =  $this->db->getAll_assoc('about_us')->results_assoc();
            return $data;
        }
    }

    public function hide_about($action, $id) {

        try {
            if($action === 'hide'){
                $this->db->update('about_us', array(
                    'visible' => 0,
                ), 'id', $id);
            }elseif($action === 'show'){
                $this->db->update('about_us', array(
                    'visible' => 1,
                ), 'id', $id);
            }elseif($action === 'delete'){

                $this->db->delete('about_us',array('id', '=',$id) );
            }

            cleanUP();

            Session::flash('home', 'Information successfully saved!');
            return true;

        } catch (Exception $e) {
            //redirect user to specific page saying oops
            $message = 'The user could not be created. Contact Webmaster';
            //die($e->getMessage());
            return false;
        }
    }


    public function add_about($update = null) {

        try {
            if($update){
                $this->db->update('about_us', array(
                    'menu_name' => trim(Input::get('subject')),
                    'position' => Input::get('position'),
                    'visible' => Input::get('visible'),
                    'content' => trim(Input::get('content')),
                    'date' => $this->today,
                ), 'id', $update);
            }else{
                $this->db->insert('about_us', array(
                    'menu_name' => trim(Input::get('subject')),
                    'position' => Input::get('position'),
                    'visible' => Input::get('visible'),
                    'content' => trim(Input::get('content')),
                    'date' => $this->today,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //die($e->getMessage());
        }
    }
    public function get_contact($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('contact_us', 'id',$id);
            $all =  $this->db->getAll_assoc('contact_us');
            $count = $this->db->count_assoc();

            return array($data,$count);
        }else{
            $data =  $this->db->getAll_assoc('contact_us')->results_assoc();
            return $data;
        }
    }

    public function delete_contact($id) {

        try {
            $this->db->delete('contact_us',array('id', '=',$id) );


            cleanUP();

            Session::flash('home', 'Information successfully deleted!');
            return true;

        } catch (Exception $e) {
            return false;
        }
    }


    public function add_contact($update = null) {

        try {
            if($update){
                $this->db->update('contact_us', array(
                    'type' => trim(Input::get('type')),
                    'details' => trim(Input::get('details')),
                    'date' => $this->today,
                ), 'id', $update);
            }else{
                $this->db->insert('contact_us', array(
                    'type' => trim(Input::get('type')),
                    'details' => trim(Input::get('details')),
                    'date' => $this->today,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //die($e->getMessage());
        }
    }

    public function get_enquiry($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('contact_enquiry', 'enquiry_id',$id);
            $this->db->update('contact_enquiry', array(
                'status' => 'seen',
            ), 'enquiry_id', $id);

        }else{
            $data =  $this->db->getAll_assoc('contact_enquiry','enquiry_id')->results_assoc();
        }
        $all =  $this->db->getAll_assoc('contact_enquiry');
        $count = $this->db->count_assoc();
        $new = $this->db->get('contact_enquiry',array('status','=','new'));
        $new_guys = $this->db->count();

        return array($data,$count,$new_guys);

    }

    public function delete_enquiry($id) {

        try {
            $this->db->delete('contact_enquiry',array('enquiry_id', '=',$id) );


            cleanUP();

            Session::flash('home', 'Information successfully deleted!');
            return true;

        } catch (Exception $e) {
            return false;
        }
    }

    public function get_event($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('events', 'id',$id);
            $all =  $this->db->getAll_assoc('events');
            $count = $this->db->count_assoc();

            return array($data,$count);
        }else{
            $data =  $this->db->getAll_assoc('events')->results_assoc();
            return $data;
        }
    }

    public function add_event($update = null) {


        try {
            if($update){
                $this->db->update( 'events', array(
                    'description' => (Input::get('description')),
                    'title' => (Input::get('title')),
                    'date' => (Input::get('datepicker')),
                    'time' => (Input::get('timepicker')),
                ), 'id', $update);

            }else{
                $this->db->insert('events', array(
                    'title' => trim(Input::get('title')),
                    'description' => trim(Input::get('description')),
                    'date' => trim(Input::get('datepicker')),
                    'time' => trim(Input::get('timepicker')),
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }

    public function delete_event($id) {
        try {
            $this->db->delete('events',array('id', '=',$id) );
            cleanUP();
            Session::flash('home', 'Information successfully deleted!');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function gallery($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('photo_gallery', 'id',$id);
            $all =  $this->db->getAll_assoc('photo_gallery');
            $count = $this->db->count_assoc();

            return array($data,$count);
        }else{
            $data =  $this->db->getAll_assoc('photo_gallery')->results_assoc();
            return $data;
        }
    }

    public function add_gallery($update = null, $upload= null) {


        try {
            if($update){
                $this->db->update( 'photo_gallery', array(
                    'head' => (Input::get('head')),
                    'description' => (Input::get('description')),
                    'image' => $upload,
                    'date' => $this->today,
                ), 'id', $update);

            }else{
                $this->db->insert('photo_gallery', array(
                    'head' => (Input::get('head')),
                    'description' => (Input::get('description')),
                    'image' => $upload,
                    'date' => $this->today,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }

    public function delete_gallery($id) {
        try {
            $this->db->delete('photo_gallery',array('id', '=',$id) );
            cleanUP();
            Session::flash('home', 'Information successfully deleted!');
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function account(){
        $data = $this->db->fetch_exact('info_staff','user_id', Session::get('user_id'));
        return $data;
    }

    public function personnel_rank(){
        $rank_id = $this->db->fetch_exact('personnel_rank_board','person_id', Session::get('user_id'));
        $persons_rank = $this->db->fetch_exact('personnel_ranks','id', $rank_id['rank_id']);
        return array($persons_rank['rank'],$persons_rank['position'],$persons_rank['title'],$rank_id['department']);
    }


    public function account_update($path = null) {
        $guide = $this->db->fetch_exact('info_staff','user_id', $_SESSION['user_id']);
        $path = (isset($path))? $path : $guide['profile_picture'];

        try {
            $this->db->update('info_staff', array(
                'surname' => Input::get('surname'),
                'firstname' => Input::get('firstname'),
                'othername' => Input::get('othernames'),
                'marital_status' => Input::get('marital_status'),
                'residential_address' => Input::get('residential_address'),
                'state_of_residence' => Input::get('state_of_residence'),
                'phone_no' => Input::get('phone'),
                'email' => Input::get('email'),
                'bio_data' => Input::get('citation'),
                'profile_picture' => $path,
            ), 'user_id', $_SESSION['user_id']);

            Session::put('logged_in_user_name',Input::get('firstname').' '.Input::get('surname').' '.Input::get('othername'));
            if(!empty($path)){
                $myPhoto = URL.'public/uploads/profile-pictures/'.$path;

            }else{
                if($guide['sex']== 'male'){
                    $myPhoto = URL.'public/images/avatar-male.png';
                }else{
                    $myPhoto = URL.'public/images/avatar-female.png';
                }
            }
            Session::put('logged_in_user_photo',$myPhoto);

            cleanUP();

            Session::flash('home', 'Account was successfully updated!');
            return true;
            //Redirect::to(URL.'admin/account');
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }


    public function update_pass() {
        //find user using existing session
        $user = $this->db->fetch_exact('users','id', Session::get('user_id'));
        //check if current pass is correct
        if ($user['password'] === Hash::make(Input::get('old_pass'), $user['salt'])) {
            $salt = Hash::salt(32);
            //replace current pass with new pass
            try {
                $this->db->update('users', array(
                    'email' => Input::get('login_email'),
                    'password' => Hash::make(Input::get('new_pass'), $salt),
                    'salt' => $salt,
                ), 'id', $_SESSION['user_id']);

                $_SESSION['email'] = Input::get('login_email');
                cleanUP();

                Session::flash('home', 'Account Password successfully updated!');
                return true;
            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }
    }

    public function get_admissions($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('admission_applications', 'record_tracker',$id);
            $all =  $this->db->getAll_assoc('admission_applications');
            $count = $this->db->count_assoc();

            return array($data,$count);
        }else{
            $data =  $this->db->getAll_assoc('admission_applications')->results_assoc();
            return $data;
        }
    }
    public function admission_interview($id = null) {
        if($id){
            $data =  $this->db->fetch_exact('admission_interview', 'adm_int_id',$id);

            return $data;
        }else{
            $data =  $this->db->getAll_assoc('admission_interview','adm_int_id')->results_assoc();
            return $data;
        }
    }

    public function admitted($case= null, $id = null) {
        switch($case){
            case 'view':
                $admission =  $this->db->fetch_exact('admission_applications', 'adm_app_id',$id);
                //die(print_r($admission));
                $personal =  $this->db->fetch_exact('info_personal', 'record_tracker',$admission['record_tracker']);
                $educational =  $this->db->fetch_exact('info_educational', 'record_tracker', $admission['record_tracker']);

                $admission_date = new DateTime($educational['admission_date']);
                $admission_date = $admission_date->format('d M, Y ');//h:i a
                $graduation_date = new DateTime($educational['graduation_date']);
                $graduation_date = $graduation_date->format('d M, Y ');//h:i a
                $dob = new DateTime($educational['admission_date']);
                $dob = $dob->format('d M, Y ');//h:i a
                $date_inserted = new DateTime($admission['date_inserted']);
                $date_inserted = $date_inserted->format('d M, Y ');//h:i a

                $data = array(
                    'adm_app_id' => $admission['adm_app_id'],
                    'date' => $date_inserted,
                    'institution' => $educational['institution'],
                    'program' => $educational['program'],
                    'course' => $educational['course'],
                    'faculty' => $educational['faculty'],
                    'admission_date' => $admission_date,
                    'graduation_date' => $graduation_date,
                    'school_address' => $educational['school_address'],
                    'school_phone' => $educational['school_phone'],
                    'name' => $personal['surname'].' '.$personal['firstname'].' '.$personal['othername'],

                    'sex' => $personal['sex'],
                    'dob' => $dob,
                    'marital_status' => $personal['marital_status'],
                    'place_of_birth' => $personal['place_of_birth'],
                    'state_of_birth' => $personal['state_of_birth'],
                    'state_of_origin' => $personal['state_of_origin'],
                    'lga' => $personal['lga'],
                    'nationality' => $personal['nationality'],
                    'phone_no' => $personal['phone_no'],
                    'postal_address' => $personal['postal_address'],
                    'postal_state' => $personal['postal_state'],
                    'email' => $personal['email'],
                    'residential_address' => $personal['residential_address'],
                    'state_of_residence' => $personal['state_of_residence'],
                );

                return $data;
                break;
            case 'accept':
                $this->db->update( 'admission_applications', array(
                    'admitted' => 'yes',
                    'approving_officer_name' => (Session::get('logged_in_user_name')),
                    'approving_officer_id' => (Session::get('user_id')),
                    'date_approved' => $this->today,
                ), 'adm_app_id', $id);
                return true;
                break;
            case 'decline':
                $this->db->update( 'admission_applications', array(
                    'admitted' => 'no',
                    'approving_officer_name' => (Session::get('logged_in_user_name')),
                    'approving_officer_id' => (Session::get('user_id')),
                    'date_approved' => $this->today,
                ), 'adm_app_id', $id);
                return true;
                break;
        }

    }

    public function add_interview($update = null) {


        try {
            if($update){
                $this->db->update( 'admission_interview', array(
                    'academic_session' => (Input::get('academic_session')),
                    'academic_term' => (Input::get('academic_term')),
                    'academic_class' => (Input::get('academic_class')),
                    'interview_date' => (Input::get('interview_date')),
                    'interview_time' => (Input::get('interview_time')),
                    'other_details' => (Input::get('other_details')),
                    'venue' => (Input::get('venue')),
                    'active' => Input::get('visible'),
                    'requirements' => (Input::get('requirements')),
                    'input_by' => (Session::get('user_id')),
                    'date' => $this->today,
                ), 'adm_int_id', $update);

            }else{
                $this->db->insert('admission_interview', array(
                    'academic_session' => (Input::get('academic_session')),
                    'academic_term' => (Input::get('academic_term')),
                    'academic_class' => (Input::get('academic_class')),
                    'interview_date' => (Input::get('interview_date')),
                    'interview_time' => (Input::get('interview_time')),
                    'other_details' => (Input::get('other_details')),
                    'venue' => (Input::get('venue')),
                    'active' => Input::get('visible'),
                    'requirements' => (Input::get('requirements')),
                    'input_by' => (Session::get('user_id')),
                    'date' => $this->today,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }

    public function interview_actions($action, $id) {
        $action = ($action == 'activate')? 1 : 0;
        if($action){
            $data =  $this->db->fetch_exact('admission_interview', 'adm_int_id',$id);
            if($data['interview_date'] < date('Y-m-d')){
                Session::flash('error', 'Could not be Activated!');
                return false;
            }
        }
        $this->db->update( 'admission_interview', array(
            'active' => $action,
            'input_by' => (Session::get('user_id')),
            'date' => $this->today,
        ), 'adm_int_id', $id);

        Session::flash('home', 'Successfully Done!');
        return true;

    }

    public function clearance($table, $perms) {
        $search = "%".Input::get('description')."%";

        $data = $this->db->get('users', array('email','LIKE',$search))->results();
        $count = $this->db->count();
        if($count > 0){
            $result = array();
            foreach($data as $d){
                $result[] = array(
                    'email' => $d->email,
                    'verified' => $d->verified,
                    'id' => $d->id,
                    'user_perms_id' => $d->user_perms_id,
                    'phone_number'=>$d->phone_number,
                    'portal_name'=>$d->portal_name
                );
            }
            return $result;

        }else{
            Session::flash('error', 'Oops! Nothing was found. Try again');

            return null;
        }

    }

    public function account_activity($action, $id) {
        $action = ($action == 'activate')? 'yes': 'no';
        if($action){
            $this->db->update('users', array(
                'verified' => $action,
            ),'id', $id);
        }
        $data =  $this->db->fetch_exact('users', 'id',$id);
        //do other things with that record

        switch($data['user_perms_id']){
            case 1: $page = 'Students';break;
            case 2: $page = 'Parents';break;
            case 3: $page = 'Staff';break;
        }
        Session::flash('home', 'Successfully Done!');
        Redirect::to(URL.'webmaster/clearance/'.$page);
        return true;

    }

    public function academic_register($id){
        //get user data
        $data =  $this->db->fetch_exact('users', 'id',$id);
        //get active session
        $active = $this->db->fetch_exact('academic_sessions', 'active',1);
        //fetch student details from admitted table
        $student = $this->db->fetch_exact('admitted_students', 'record_tracker',$data['record_tracker']);
        //check if user was promoted from last class
        $promoted = $this->db->fetch_last('academic_register','register_id', 'student_reg_no',$student['student_reg_no']);
        $promoted = (!empty($promoted['promoted']))? $promoted['promoted_to'] : $promoted['current_class'];

        //check if a record exists for that record
        $check = $this->db->get('academic_register',array('student_reg_no','=',$student['student_reg_no'],'session_id','=',$active['session_id']));
        if($this->db->first()){
            Session::put('home','This user has already been registered for the given session/ term');

        }else{
            $this->db->insert('academic_register', array(
                'session_id' => $active['session_id'],
                'student_id' => ($student['admitted_id']),
                'student_reg_no' => ($student['student_reg_no']),
                'current_class' => ($promoted),
                'active' => (1),
                'activated_by' => ($id),
                'record_tracker' => $data['record_tracker'],
                'input_by' => (Session::get('user_id')),
                'date' => $this->today,
            ));

        }
        switch($data['user_perms_id']){
            case 1: $page = 'Students';break;
            case 2: $page = 'Parents';break;
            case 3: $page = 'Staff';break;
        }
        Session::flash('home', 'Successfully Done!');
        Redirect::to(URL.'webmaster/clearance/'.$page);
        exit;

    }


}
