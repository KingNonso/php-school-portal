<?php

    class Admission_Model extends Model {

        function __construct() {
            parent::__construct();
            $this->user = new User();
        }

        function user() {
            return $user = new User();
        }

        public function account_setup() {
            //register user
            $salt = Hash::salt(32);

            try {
                $this->db->insert('users', array(
                    'username' => Input::get('username'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'chapter_id' => 0,
                    'joined' => $this->today,
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
            $record = Hash::unique();
            Session::put('record_tracker',$record);

            try {
                $guide = $this->db->fetch_exact('info_personal','record_tracker',$_SESSION['record_tracker']);
                if(!empty($guide['record_tracker'])){
                    $this->db->update('info_personal', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
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
                        'agreement_2_terms' => "Yes",
                        'date_created' => $this->today
                    ),'person_id',$guide['person_id']);


                }else{
                    $this->db->insert('info_personal', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
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
                        'agreement_2_terms' => "Yes",
                        'date_created' => $this->today
                    ));

                }

                self::cleanUP();

                Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
                Redirect::to(URL . 'admission/step/two');
                exit();
            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }

        public function educational($path, $admission, $graduation) {
            try {
                $guide = $this->db->fetch_exact('info_educational','record_tracker',$_SESSION['record_tracker']);
                if(!empty($guide['record_tracker'])){
                    $this->db->update('info_educational', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'institution' => Input::get('institute'),
                        'program' => Input::get('program'),
                        'course' => Input::get('course'),
                        'faculty' => Input::get('faculty'),
                        'admission_date' => $admission,
                        'graduation_date' => $graduation,
                        //'hod_supevisor' => Input::get('hod'),
                        'upload_certification' => $path,
                        'school_address' => Input::get('sch_address'),
                        'school_postal' => Input::get('sch_postal'),
                        'school_phone' => Input::get('sch_phone'),
                        'date' => $this->today

                    ),'edu_id',$guide['edu_id']);


                }else{
                    $this->db->insert('info_educational', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'institution' => Input::get('institute'),
                        'program' => Input::get('program'),
                        'course' => Input::get('course'),
                        'faculty' => Input::get('faculty'),
                        'admission_date' => $admission,
                        'graduation_date' => $graduation,
                        //'hod_supevisor' => Input::get('hod'),
                        'upload_certification' => $path,
                        'school_address' => Input::get('sch_address'),
                        'school_postal' => Input::get('sch_postal'),
                        'school_phone' => Input::get('sch_phone'),
                        'date' => $this->today

                    ));

                }

                self::cleanUP();

                Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
                Redirect::to(URL . 'admission/step/three');

            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }

        public function info_parents() {
            try {
                $guide = $this->db->fetch_exact('info_parents','record_tracker',$_SESSION['record_tracker']);
                if(!empty($guide['record_tracker'])){
                    $this->db->update('info_parents', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'parents_name' => Input::get('parents_name'),
                        'relationship' => Input::get('relationship'),
                        'parents_phone' => Input::get('parents_phone'),
                        'parents_email' => Input::get('parents_email'),
                        'parents_occupation' => Input::get('parents_occupation'),
                        'biz_address' => Input::get('biz_address'),
                        'home_address' => Input::get('home_address'),
                        'date' => $this->today
                    ),'parents_id',$guide['parents_id']);

                }else{
                    $this->db->insert('info_parents', array(
                        //'user_id' => $_SESSION['user_id'],
                        'record_tracker' => $_SESSION['record_tracker'],
                        'parents_name' => Input::get('parents_name'),
                        'relationship' => Input::get('relationship'),
                        'parents_phone' => Input::get('parents_phone'),
                        'parents_email' => Input::get('parents_email'),
                        'parents_occupation' => Input::get('parents_occupation'),
                        'biz_address' => Input::get('biz_address'),
                        'home_address' => Input::get('home_address'),
                        'date' => $this->today
                    ));
                }


                self::cleanUP();

                Session::flash('home', 'Information successfully saved, Your Application was successfully saved. DONE!');
                Redirect::to(URL . 'admission/step/web');
            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }

        public function admission() {
            try {
                $guide = $this->db->fetch_exact('admission_applications','record_tracker',$_SESSION['record_tracker']);
                if(!empty($guide['record_tracker'])){
                    $this->db->update('admission_applications', array(
                        'record_tracker' => $_SESSION['record_tracker'],
                        'exam_no' => Input::get('exam_taken'),
                        'exam_score' => Input::get('exam_score'),
                        'entry_class' => Input::get('entry_class'),
                        'entry_term' => Input::get('entry_term'),
                        'entry_session' => Input::get('entry_session'),
                        'date_inserted' => $this->today
                    ),'adm_app_id',$guide['adm_app_id']);

                }else{
                    $this->db->insert('admission_applications', array(
                        'record_tracker' => $_SESSION['record_tracker'],
                        'exam_no' => Input::get('exam_taken'),
                        'exam_score' => Input::get('exam_score'),
                        'entry_class' => Input::get('entry_class'),
                        'entry_term' => Input::get('entry_term'),
                        'entry_session' => Input::get('entry_session'),
                        'date_inserted' => $this->today
                    ));
                }


                self::cleanUP();

                Session::flash('home', 'Information successfully saved, Your Application was successfully saved. DONE!');
                Redirect::to(URL . 'admission/step/parent');
            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }


        public function check_admission_status() {
            try {
                $admission = $this->db->fetch_exact('admission_applications', 'exam_no',Input::get('exam_id'));
                if($admission){
                    Session::put('person_admitted',true);
                    //check the scratch card, etc
                    //print out record
                    Session::flash('home', 'We searched everywhere... And we found it. Admission granted!');
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
                }else{
                    Session::flash('error', 'We searched everywhere... Admission in process. Try again some other time!');
                    return false;
                }

            } catch (Exception $e) {
                //redirect user to specific page saying oops
                return false;
            }
        }

        public function admitted_actions($action, $id) {
            try {
                $admission = $this->db->fetch_exact('admission_applications', 'adm_app_id',$id);
                $personal =  $this->db->fetch_exact('info_personal', 'record_tracker',$admission['record_tracker']);
                $educational =  $this->db->fetch_exact('info_educational', 'record_tracker', $admission['record_tracker']);
                $parent =  $this->db->fetch_exact('info_parents', 'record_tracker',$admission['record_tracker']);
                $admitted_class =  $this->db->fetch_exact('academic_classes', 'class_name',$admission['entry_class']);

                switch($action){
                    case 'accept':
                        $this->db->update('admission_applications', array(
                            'accepted' => 'yes',
                            'date_inserted' => $this->today
                        ),'adm_app_id',$id);
                        $this->db->insert('academic_students', array(
                            'record_tracker' => $admission['record_tracker'],
                            'info_personal_id' => $personal['person_id'],
                            'info_parent_id' => $parent['parents_id'],
                            'info_educational_id' => $educational['edu_id'],
                            'admissions_id' => $admission['adm_app_id'],
                            'student_reg_no' => time(),
                            'admitted_class' => $admitted_class['class_id'],
                            'date' => $this->today
                        ));
                        $data = array(
                            'adm_app_id' => $admission['adm_app_id'],
                            'class_name' => $admitted_class['class_name'],
                            'parent_class' => $admitted_class['parent_class'],
                            'class_desc' => $admitted_class['class_desc'],

                            'student_reg_no' => time(),
                            'name' => $personal['surname'].' '.$personal['firstname'].' '.$personal['othername'],

                            'sex' => $personal['sex'],
                            'profile_picture' => $personal['profile_picture'],
                            'marital_status' => $personal['marital_status'],
                            'place_of_birth' => $personal['place_of_birth'],
                            'state_of_birth' => $personal['state_of_birth'],
                            'state_of_origin' => $personal['state_of_origin'],
                            'lga' => $personal['lga'],
                            'nationality' => $personal['nationality'],
                            'phone_no' => $personal['phone_no'],
                        );

                        return $data;
                        break;
                    case 'decline':
                        $this->db->update('admission_applications', array(
                            'accepted' => 'no',
                            'date_inserted' => $this->today
                        ),'adm_app_id',$id);
                        break;
                }

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
