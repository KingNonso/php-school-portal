<?php

class Links extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->generalJS = array('custom/js/ajax.js');
    }


    function index(){
        $this->view->js = array('index/js/main.js','index/js/default.js');
        $this->view->render('links/index');

    }

    function check(){
        //;&& Token::check(Input::get('token'))
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'student_id' => array(
                    'name' => 'Student Registration ID',
                    'required' => true,
                ),
                'student_pin' => array(
                    'name' => 'PIN',
                    'min' => 6,
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $pin = $this->model->check_pin()) {
                if($pin != 'stale'){
                    //die('not stale');
                    list($this->view->name,$this->view->result) = $pin;
                    $this->view->render('links/result');
                    exit;
                }
            } else {
                if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                Session::put('error', $message);
            }
            Redirect::to(backToSender());

        }
    }


    /*
         function result($id = null){
        if(Session::exists('pin_approved') && $id){
            list($this->view->name,$this->view->result) = $this->model->check_result(Session::get('pin_result'),$id);
            $this->view->render('links/result');
        }else{
            Redirect::to(URL.'links');
        }

    }

     */
    function logout() {
        Session::delete('pin_approved');
        Session::delete('pin_result');
        Cookie::delete('hash');
        session_destroy();

        //thanks for destroying, now lets begin anew
        session_start();
        Session::flash('home', 'You have been successfully logged out!');

        Redirect::to(URL . 'links');
    }



    function step($step = Null) {
        if($step == 'parent-web' || $step == 'teacher-web'){
            $this->view->generalCSS = array('custom/phone/css/intlTelInput.css');
            $this->view->generalJS = array('custom/phone/js/intlTelInput.js','custom/js/ajax.js');
            $this->view->js = array('admission/js/activate_intlTelInput.js','links/js/person_search.js');
        }else{
            $this->view->generalJS = array('custom/js/upload_check.js');

        }

        $step = (isset($step)) ? $step : 'index';
        $this->view->title = 'APPLICATION ' ;
        $this->view->render('links/' . $step, TRUE);
    }

    function work(){
        $this->view->title = 'About Winners Chapel Ifite';
        $this->view->render('index/work', 'member');
    }

    function search_for_person($str){
        $this->model->search_for_person($str);
    }

    function make_executive($person){
        $this->model->make_executive($person);
    }


    function staff_personal() {
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
                    'phone' => array(
                        'name' => 'Phone Number',
                        'required' => true,
                    ),
                    'email' => array(
                        'name' => 'Email',
                        'required' => true,
                    ),
                    'level' => array(
                        'name' => ' Level',
                        'required' => true,
                    ),
                    'appointment' => array(
                        'name' => 'Appointment',
                        'required' => true,
                    ),
                    'title' => array(
                        'name' => 'Title',
                        'required' => true,
                    ),
                    'department' => array(
                        'name' => 'Department',
                        'required' => true,
                    ),
                    'citation' => array(
                        'name' => 'Professional Bio Data',
                        'required' => true,
                    ),
                ));

                $day = Input::get('day');
                $month = Input::get('month');
                $year = Input::get('year');
                $goodDate = checkdate($month, $day, $year) ? true : false;

                if ($validation->passed() && $goodDate) {
                    $date = new DateTime("$year-$month-$day");
                    $dob = $date->format('Y-m-d');

                    $upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'profile-pictures\\', 'links/step/teacher');
                    if ($upload && $this->model->staff_personal($upload, $dob)) {
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
                    Session::put('error', $message);
                }
            }
        }
        Redirect::to(URL . 'links/step/teacher');

    }


    function web_access() {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'email' => array(
                        'name' => 'email',
                        'required' => true,
                        'unique' => 'users'
                    ),
                    'password' => array(
                        'name' => 'Password',
                        'required' => true,
                        'min' => 6,
                    ),
                    'password_again' => array(
                        'name' => 'password_again',
                        'required' => true,
                        'matches' => 'password'
                    ),
                    'phone_number' => array(
                        'name' => 'phone_number',
                    ),
                    'owner_is' => array(
                        'name' => 'owner_is',
                        'required' => true,
                    ),
                    /*
                     *                     'account_is' => array(
                        'required' => true,
                        'name' => 'account_is',
                    ),

                     */
                ));


                if ($validation->passed()) {
                    $this->model->account_setup();
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
        Redirect::to(URL . 'links/step/teacher-web');
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