<?php

class Reg_Model extends Model {

    function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    function user() {
        return $user = new User();
    }

    public function account_setup() {
        //register user
        $date = date('Y-m-d H:i:s');
        $salt = Hash::salt(32);

        try {
            $this->db->insert('users', array(
                'username' => Input::get('username'),
                'password' => Hash::make(Input::get('password'), $salt),
                'salt' => $salt,
                'chapter_id' => 0,
                'joined' => $date,
                'user_perms_id' => 1, //regular user
                'user_status' => 1 //still registering
            ));

            self::cleanUP();


            list($last_id) = $this->db->last_insert_id();
            if ($last_id) {
                $_SESSION['user_id'] = $last_id;
                Session::put('loggedIn', true);
            }
            Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
            Redirect::to(URL . 'reg/member/step-2');
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            $message = 'The user could not be created. Contact Webmaster';
            //die($e->getMessage());
        }
    }

    public function personal_info($path, $dob) {

        try {
            $this->db->insert('info_personal', array(
                'user_id' => $_SESSION['user_id'],
                'surname' => Input::get('surname'),
                'firstname' => Input::get('firstname'),
                'othername' => Input::get('othernames'),
                'sex' => Input::get('sex'),
                'dob' => $dob,
                'marital_status' => Input::get('marital_status'),
                'place_of_birth' => Input::get('place_of_birth'),
                'state_of_birth' => Input::get('state_of_birth'),
                'state_of_origin' => Input::get('state_of_origin'),
                'lga' => Input::get('lga'),
                'nationality' => Input::get('nationality'),
                'residential_address' => Input::get('residential_address'),
                'state_of_residence' => Input::get('state_of_residence'),
                'phone_no' => Input::get('phone'),
                'email' => Input::get('email'),
                'postal_address' => Input::get('post_box'),
                'postal_state' => Input::get('postal_state'),
                'bio_data' => Input::get('citation'),
                'hobbies' => Input::get('hobbies'),
                'profile_picture' => $path,
                'agreement_2_terms' => "Yes"
            ));
            self::cleanUP();

            Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
            Redirect::to(URL . 'reg/member/step-3');
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }

    public function educational($path, $admission, $graduation) {

        try {
            $this->db->insert('info_educational', array(
                'user_id' => $_SESSION['user_id'],
                'institution' => Input::get('institute'),
                'program' => Input::get('program'),
                'course' => Input::get('course'),
                'faculty' => Input::get('faculty'),
                'admission_date' => $admission,
                'graduation_date' => $graduation,
                'hod_supevisor' => Input::get('hod'),
                'upload_certification' => $path,
                'school_address' => Input::get('sch_address'),
                'school_postal' => Input::get('sch_postal'),
                'school_phone' => Input::get('sch_phone'),
            ));
            self::cleanUP();

            if (isset($_POST['add_new'])) {
                Session::flash('home', 'Information successfully saved, you may now add another one!');
                Redirect::to(URL . 'reg/member/step-3');
            } else {
                Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
                Redirect::to(URL . 'reg/member/step-4');
            }
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }

    public function professional($employ_date, $retire_date) {

        try {
            $this->db->insert('info_professional', array(
                'user_id' => $_SESSION['user_id'],
                'organization' => Input::get('organization'),
                'division' => Input::get('division'),
                'specialization' => Input::get('specialization'),
                'position' => Input::get('position'),
                'employment_year' => $employ_date,
                'retirement_year' => $retire_date,
                'business_phone' => Input::get('biz_phone'),
                'business_email' => Input::get('biz_email'),
                'business_address' => Input::get('biz_address'),
                'business_postal' => Input::get('biz_postal'),
            ));

            self::cleanUP();

            if (isset($_POST['add_new'])) {
                Session::flash('home', 'Information successfully saved, you may now add another one!');
                Redirect::to(URL . 'reg/member/step-4');
            } else {
                Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
                Redirect::to(URL . 'reg/member/step-5');
            }
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }

    public function membership($path, $nse_reg_date, $coren_reg_date, $nieee_reg_date) {

        try {
            $this->db->insert('info_membership', array(
                'user_id' => $_SESSION['user_id'],
                'nse_reg_no' => Input::get('nse_no'),
                'nse_date_of_reg' => $nse_reg_date,
                'coren_reg_no' => Input::get('coren_no'),
                'coren_date_of_reg' => $coren_reg_date,
                'nse_membership_cadre' => Input::get('nse_cadre'),
                'nieee_membership_cadre' => Input::get('nieee_cadre'),
                'nieee_date_of_reg' => $nieee_reg_date,
                'receipt_teller_no' => Input::get('teller_no'),
                'evidence_of_payment' => $path,
                'my_chapter' => Input::get('nieee_chapter'),
            ));
            $this->db->update('users', array(
                'chapter_id' => Input::get('nieee_chapter'),
                    ), 'id', $_SESSION['user_id']);

            $this->db->update('info_personal', array(
                'chapter_id' => Input::get('nieee_chapter'),
                    ), 'user_id', $_SESSION['user_id']);

            $_SESSION['my_chapter'] = Input::get('nieee_chapter');


            self::cleanUP();

            Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
            Redirect::to(URL . 'reg/member/step-6');
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }

    public function membership_fees($admission, $next_renewal) {

        try {
            $this->db->insert('pay_membership', array(
                'user_id' => $_SESSION['user_id'],
                'teller_no' => Input::get('pay_no'),
                'amount' => Input::get('total'),
                'cart_at_checkout' => "many things in cart", //Input::get('cart'),
                'date_of_pay' => $admission,
                'next_renewal_date' => $next_renewal,
                'bank_used' => Input::get('bank'),
            ));

            self::cleanUP();
            Session::flash('home', 'Information successfully saved, You may proceed with the registration!');

            Redirect::to(URL . 'reg/member/step-7');
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }

    public function web_access() {
        //finish  user registration process
        try {
            $this->db->update('users', array(
                'nieee_email' => toAscii(Input::get('nieee_email'), '', '.'),
                'nieee_url' => toAscii(Input::get('nieee_url')),
                'user_status' => 0 //done registering
                    ), 'id', $_SESSION['user_id']);

            $_SESSION['slug_url'] = Input::get('nieee_url');

            self::cleanUP();
            $message = '
<h2>Welcome to your Dash Board! </br> You are in-charge from here! Take care... bye!</h2>
<p><a href="' . URL . 'wall">Your Wall</a>  is for your personal discussions, you may add people to your <a href="' . URL . 'wall/conversation">conversation list</a> as you wish, they will get any update you post. You may also wish to upload your documents there</p>
<p><a href="' . URL . 'chapter">Your Chapter</a> and <a href="' . URL . 'national">National</a> are for discussions on the various scopes, happenings, events, minutes of meetings, excos etc</p>
';
            Session::put('home', $message);
            Redirect::to(URL . 'profile/member/' . $_SESSION['slug_url']);
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }

    public static function cleanUP() {
        //clears out my session variables on success. Thanks
        foreach ($_POST as $item => $thing) {
            Session::delete($item);
        }
    }

}
