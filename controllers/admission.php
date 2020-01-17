<?php

    class Admission extends Controller {

        function __construct() {
            parent::__construct();

            if (!isset($_SESSION['maxfiles'])) {
                $_SESSION['maxfiles'] = ini_get('max_file_uploads');
                $_SESSION['postmax'] = Upload::convertToBytes(ini_get('post_max_size'));
                $_SESSION['displaymax'] = Upload::convertFromBytes($_SESSION['postmax']);
            }

            $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js');

            //$this->view->js = array('upload_check.js');

            $this->view->navigation = array(
                'one' => array( //Account Information
                    'name' => 'Step 1: Personal Information',
                    'href' => 'some file',
                ),
                'two' => array(
                    'name' => 'Step 2: Educational Information',
                ),
                'three' => array(
                    'name' => 'Step 3: Admission Information',
                ),
                'parent' => array(
                    'name' => 'Step 4: Parents Information',
                ),
                'web' => array(
                    'name' => 'Step 5: Set Up Web Access Account',
                ),
                /*
                  *
                  *                 'fees' => array(
                     'name' => 'Step 4: Fees & Payment Information',
                 ),

                  */
            );

        }

        function index(){

            //$this->view->js = array('index/js/main.js','index/js/default.js');
            $this->view->title = "Admissions";

            $this->view->render('admission/index');
        }

        function step($step = Null) {
            if($step == 'done'){
                $step = 'done';
            }elseif (!isset($_SESSION['record_tracker']) || !isset($step)){
                $step = 'one';
            }

            $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js');
            if($step === 'web'){
                $this->view->generalCSS = array('custom/phone/css/intlTelInput.css');
                $this->view->generalJS = array('custom/phone/js/intlTelInput.js','custom/js/ajax.js');
                $this->view->js = array('admission/js/activate_intlTelInput.js');
            }
            if($step == 'three'){
                $model = $this->reMapRouteToModel('admin');
                $this->view->class = $this->admin->get_class();

            }

            $this->view->title = 'Admissions Application ' ;
            $this->view->render('admission/' . $step, TRUE);
        }

        function status($action = null, $id = null){
            if($action && $id && Session::get('person_admitted')){
                Session::delete('person_admitted');
                $this->view->admissions = $this->model->admitted_actions($action, $id);
                $this->view->title = 'Admissions '. $action;
                $this->view->render('admission/accepted', TRUE);
                exit;

            }

            $this->view->title = 'Admissions Status ' ;
            $this->view->render('admission/status', TRUE);
        }

        function check_admission_status() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {

                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'exam_id' => array(
                            'name' => 'Examination ID',
                            'required' => true,
                        ),
                        'scratch_card' => array(
                            'name' => 'Password',
                            'required' => true,
                        ),
                    ));
                    if ($validation->passed()) {
                        if ($this->view->admissions = $this->model->check_admission_status()) {
                            $this->view->render('admission/success');
                            exit;
                        }else{
                            Redirect::to(URL . 'admission/status');
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'admission/status');
        }

        function account_setup() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {

                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'username' => array(
                            'name' => 'Username',
                            'required' => true,
                            'min' => 6,
                            'max' => 30,
                            'unique' => 'users'
                        ),
                        'password' => array(
                            'name' => 'Password',
                            'required' => true,
                            'min' => 6,
                        ),
                        'password_again' => array(
                            'name' => 'Password Confirmation',
                            'required' => true,
                            'matches' => 'password'
                        ),
                        'agreement_2_terms' => array(
                            'name' => 'Agreement to Terms',
                            'required' => true,
                        ),
                    ));
                    if ($validation->passed() && $this->model->account_setup()) {
                        //proceed to step 2
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'reg/member/step-1');
            //$this->view->render('reg/member/step-1', true);
        }


        function personal() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'surname' => array(
                            'name' => 'Surname',
                            'required' => true,
                        ),
                        'firstname' => array(
                            'name' => 'First name',
                            'required' => true,
                        ),
                        'othernames' => array(
                            'name' => 'Other name(s)',
                        ),
                        'sex' => array(
                            'name' => 'Sex',
                            'required' => true,
                        ),
                        'day' => array(
                            'name' => 'Date of Birth - Day',
                            'required' => true,
                        ),
                        'month' => array(
                            'name' => 'Date of Birth - Month',
                            'required' => true,
                        ),
                        'year' => array(
                            'name' => 'Date of Birth - Year',
                            'required' => true,
                        ),
                        'marital_status' => array(
                            'name' => 'Marital Status',
                            'required' => true,
                        ),
                        'state_of_birth' => array(
                            'name' => 'State of Birth',
                        ),
                        'place_of_birth' => array(
                            'name' => 'Place of Birth',
                        ),
                        'nationality' => array(
                            'name' => 'Nationality',
                            'required' => true,
                        ),
                        'state_of_origin' => array(
                            'name' => 'State of Origin',
                            'required' => true,
                        ),
                        'lga' => array(
                            'name' => 'LGA',
                            'required' => true,
                        ),
                        'residential_address' => array(
                            'name' => 'Permanent Home Address',
                            'required' => true,
                        ),
                        'state_of_residence' => array(
                            'name' => 'State of Residence',
                            'required' => true,
                        ),
                        'post_box' => array(
                            'name' => 'Postal Address',
                        ),
                        'postal_state' => array(
                            'name' => 'Postal State',
                        ),
                        'citation' => array(
                            'name' => ' Bio Data',
                        ),
                        'hobbies' => array(
                            'name' => 'Hobbies',
                        ),
                    ));

                    $day = Input::get('day');
                    $month = Input::get('month');
                    $year = Input::get('year');
                    $goodDate = checkdate($month, $day, $year) ? true : false;

                    if ($validation->passed() && $goodDate) {
                        $date = new DateTime("$year-$month-$day");
                        $dob = $date->format('Y-m-d');

                        $upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'profile-pictures\\', 'admission/step/one');
                        if ($upload && $this->model->personal_info($upload, $dob)) {
                            //enter data to db
                            //die(($upload).' every thing is ok');
                        } else {
                            //we have a server error
                            Session::put('error', 'Please contact webmaster');
                            //out error
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        if (!$goodDate) {
                            $message .= "Please check your date format. Day - Month - Year combination";
                        }
                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'admission/step/one');

            //$this->view->render('reg/member/step-2', true);
        }

        function educational() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'institute' => array(
                            'name' => 'Name of Institution',
                            'required' => true,
                        ),
                        'program' => array(
                            'name' => 'Highest  Qualification',
                            'required' => true,
                        ),
                        'course' => array(
                            'name' => 'Examination Taken',
                            'required' => true,
                        ),
                        'faculty' => array(
                            'name' => 'Examining Board',
                        ),
                        'adm_day' => array(
                            'name' => 'Admission Date - Day',
                            'required' => true,
                        ),
                        'adm_month' => array(
                            'name' => 'Admission Date - Month',
                            'required' => true,
                        ),
                        'adm_year' => array(
                            'name' => 'Admission Date - Year',
                            'required' => true,
                        ),
                        'grad_day' => array(
                            'name' => 'Graduation Date - Day',
                        ),
                        'grad_month' => array(
                            'name' => 'Graduation Date - Month',
                        ),
                        'grad_year' => array(
                            'name' => 'Graduation Date - Year',
                        ),
                        'sch_address' => array(
                            'name' => 'Full School Address',
                            'required' => true,
                        ),
                        'sch_phone' => array(
                            'name' => 'School Contact Phone No',
                        ),
                        'sch_postal' => array(
                            'name' => 'School Postal Address',
                        ),
                    ));

                    $adm_day = Input::get('adm_day');
                    $adm_month = Input::get('adm_month');
                    $adm_year = Input::get('adm_year');
                    $gooddate1 = checkdate($adm_month, $adm_day, $adm_year) ? true : false;

                    $grad_day = Input::get('grad_day');
                    $grad_month = Input::get('grad_month');
                    $grad_year = Input::get('grad_year');
                    $gooddate2 = checkdate($grad_month, $grad_day, $grad_year) ? true : false;
                    if ($gooddate1) {
                        $date = new DateTime("$adm_year-$adm_month-$adm_day");
                        $admission = $date->format('Y-m-d');
                        $goodDate = true;

                        if ($gooddate2) {
                            $date = new DateTime("$grad_year-$grad_month-$grad_day");
                            $graduation = $date->format('Y-m-d');
                        } else {
                            $graduation = NULL;
                        }
                    }
                    if ($validation->passed() && $goodDate) {
                        //$upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'certificates\\', 'step-3');
                        $upload = null;
                        if ($this->model->educational($upload, $admission, $graduation)) {
                            //enter data to db
                            //die(($upload).' every thing is ok');
                        } else {
                            //we have a server error
                            Session::put('error', 'Please contact webmaster');
                            //out error
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        if (!$goodDate) {
                            $message .= "Please check your date format. Day - Month - Year combination";
                        }
                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'admission/step/two');

        }

        function admission(){
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'entry_session' => array(
                            'name' => 'Admission/Entry Session',
                            'required' => true,
                        ),
                        'entry_term' => array(
                            'name' => 'Admission/Entry Term',
                            'required' => true,
                        ),
                        'entry_class' => array(
                            'name' => 'Admission/Entry Class',
                            'required' => true,
                        ),
                        'exam_taken' => array(
                            'name' => 'Exam Number',
                        ),
                        'exam_score' => array(
                            'name' => 'Exam Score',
                        ),
                    ));


                    if ($validation->passed() && $this->model->admission()) {

                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        Session::put('error', $message);
                    }
                }
            }
            Redirect::to(URL . 'admission/step/three');
        }

        function professional() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'organization' => array(
                            'name' => 'Name of Organization',
                            'required' => true,
                        ),
                        'division' => array(
                            'name' => 'Division',
                        ),
                        'position' => array(
                            'name' => 'Position',
                            'required' => true,
                        ),
                        'specialization' => array(
                            'name' => 'Specialization',
                        ),
                        'biz_phone' => array(
                            'name' => 'Business Phone Number',
                        ),
                        'biz_email' => array(
                            'name' => 'Business Email Address',
                        ),
                        'employ_day' => array(
                            'name' => 'Employment/Entry Date - Day',
                            'required' => true,
                        ),
                        'employ_month' => array(
                            'name' => 'Employment/Entry Date - Month',
                            'required' => true,
                        ),
                        'employ_year' => array(
                            'name' => 'Employment/Entry Date - Year',
                            'required' => true,
                        ),
                        'exit_day' => array(
                            'name' => 'Retirement/ Exit Date - Day',
                        ),
                        'exit_month' => array(
                            'name' => 'Retirement/ Exit Date - Month',
                        ),
                        'exit_year' => array(
                            'name' => 'Retirement/ Exit Date - Year',
                        ),
                        'biz_address' => array(
                            'name' => 'Full Business Address',
                            'required' => true,
                        ),
                        'biz_postal' => array(
                            'name' => 'Business Postal Address',
                        ),
                    ));

                    $adm_day = Input::get('employ_day');
                    $adm_month = Input::get('employ_month');
                    $adm_year = Input::get('employ_year');
                    $gooddate1 = checkdate($adm_month, $adm_day, $adm_year) ? true : false;

                    $grad_day = Input::get('exit_day');
                    $grad_month = Input::get('exit_month');
                    $grad_year = Input::get('exit_year');
                    $gooddate2 = checkdate($grad_month, $grad_day, $grad_year) ? true : false;

                    if ($gooddate1) {
                        $date = new DateTime("$adm_year-$adm_month-$adm_day");
                        $employ_date = $date->format('Y-m-d');
                        $goodDate = true;

                        if ($gooddate2) {
                            $date = new DateTime("$grad_year-$grad_month-$grad_day");
                            $retire_date = $date->format('Y-m-d');
                        } else {
                            $retire_date = NULL;
                        }
                    }
                    if ($validation->passed() && $goodDate) {

                        if ($this->model->professional($employ_date, $retire_date)) {
                            //enter data to db
                            //die(($upload).' every thing is ok');
                        } else {
                            //we have a server error
                            Session::put('error', 'Please contact webmaster');
                            //out error
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();
                        if (!$goodDate) {
                            $message .= "Please check your date format. Day - Month - Year combination";
                        }
                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'reg/member/step-4');

            //$this->view->render('reg/member/step-3', true);
        }

        function parents_info() {
            //@Task: Do your error checking
            if (Input::exists()) {
                if (Token::check(Input::get('token'))) {
                    $validate = new Validate();
                    //validate input
                    $validation = $validate->check($_POST, array(
                        'parents_name' => array(
                            'name' => 'Name of Sponsor',
                            'required' => true,
                        ),
                        'relationship' => array(
                            'name' => 'Relationship',
                            'required' => true,
                        ),
                        'parents_phone' => array(
                            'name' => 'Phone Number of Parent/ Guardian',
                            'required' => true,
                        ),
                        'parents_email' => array(
                            'name' => 'Email of Parent/ Guardian',
                            'required' => true,
                        ),
                        'parents_occupation' => array(
                            'name' => 'Occupation of Parent',
                            'required' => true,
                        ),
                        'biz_address' => array(
                            'name' => 'Full Business/ Office Address',
                            'required' => true,
                        ),
                        'home_address' => array(
                            'name' => 'Home/ Residence Address',
                            'required' => true,
                        ),
                    ));

                    if ($validation->passed()) {

                        //$upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'payments\\', 'step-5');
                        if ($this->model->info_parents()) {
                            //enter data to db
                            //die(($upload).' every thing is ok');
                        } else {
                            //we have a server error
                            Session::put('error', 'Please contact webmaster');
                            //out error
                        }
                    } else {
                        if (count($validation->errors()) == 1) {
                            $message = "There was 1 error in the form.";
                        } else {
                            $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                        }
                        $message .= $validate->display_errors();

                    }
                    Session::put('error', $message);
                }
            }
            Redirect::to(URL . 'admission/step/parents');

        }


        function upload($max, $folder, $step) {
            //echo($max);
            $result = array();

            //upload
            $destination = UPLOAD_PATH . $folder;
            $upload = new Upload($destination);
            $upload->setMaxSize($max);
            $upload->allowAllTypes();
            $upload->upload();
            foreach ($upload->getMessages() as $msg) {
                $result[] = $msg;
            }
            //if the sub-folder doesn't exist yet create it
            if (!is_dir($destination)) {
                mkdir($destination);
            }
            $path = $upload->fileName();

            if (!isset($path)) {
                $result[] = "Please Upload an Image file";
                $path = NULL;
                $output = "<p class=\"errors\"> ";
                $output .= "Please review the following fields: <br />";
                foreach ($result as $error) {
                    $output .= " - " . $error . "<br />";
                }
                $output .= "</p>";
                Session::put('error', $output);
                Redirect::to(URL . 'reg/member/' . $step);
                //$this->view->render('reg/member/'.$step, true);

                return false;
            } else {
                return $path;
            }
            //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
            /*
              else{
              $resize = new Resize($destination.$path);
              $resize->resizeImage(120, 90, 'exact');
              $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
              } */
        }


    }
