<?php

class Webmaster extends Controller {

    function __construct() {
        parent::__construct();

        if(!isset($_SESSION['maxfiles'])){
            $_SESSION['maxfiles'] = ini_get('max_file_uploads');
            $_SESSION['postmax'] = Upload::convertToBytes(ini_get('post_max_size'));
            $_SESSION['displaymax'] = Upload::convertFromBytes($_SESSION['postmax']);
        }
        /*
        $logged = Session::get('loggedIn');
        if ($logged == false || Session::get('role') !== 'webmaster') {
            Redirect::to(URL.'login');
        }
         */
        $this->view->generalJS = array('custom/js/ajax.js');



    }

    /*_--------------------------- PAGE LOADERS  -------------------------------------------------     */
    function index(){
        list($this->view->student,$this->view->subject,$this->view->class,$this->view->result) = $this->model->get_summary();

        $role = (Session::exists('role'))? Session::get('role'): 'School Admin';
        $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
        $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
        $this->view->js = array('admin/js/ui.js');

        $this->view->title = 'Webmaster Board';
        $this->view->render('webmaster/index', 'admin');
    }

    function about($action = null, $id = null){

        if($action && $id){
            switch($action){
                case 'update':
                    list($this->view->about, $this->view->count) = $this->model->get_about($id);
                    break;
                case 'hide':
                    $this->model->hide_about('hide',$id);
                    $this->view->about = $this->model->get_about();
                    break;
                case 'show':
                    $this->model->hide_about('show',$id);
                    $this->view->about = $this->model->get_about();
                    break;
                case 'delete':
                    $this->model->hide_about('delete',$id);
                    $this->view->about = $this->model->get_about();
                    break;
            }

        }else{
            $this->view->about = $this->model->get_about();

        }
        $page = ($action === 'update')? 'update_about': 'about';
                //$this->view->js = array('workbench/js/'.$page.'.js');

        $this->view->title = 'Webmaster - About School';
        $this->view->render('webmaster/'.$page, 'admin');
    }

    function add_about($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'subject' => array(
                        'name' => 'Subject',
                        'required' => true,
                    ),
                    'position' => array(
                        'name' => 'Position',
                        'required' => true,
                    ),
                    'visible' => array(
                        'name' => 'Visible',
                        'required' => true,
                    ),
                    'content' => array(
                        'name' => 'content',
                        'required' => true,
                    ),
                ));

                if ($validation->passed()) {
                    $this->model->add_about($update);

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
        Redirect::to(URL . 'webmaster/about');
    }

    function contact($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'update':
                    list($this->view->about, $this->view->count) = $this->model->get_contact($id);
                    break;
                case 'delete':
                    $this->model->delete_contact($id);
                    $this->view->about = $this->model->get_contact();
                    break;
            }

        }else{
            $this->view->about = $this->model->get_contact();

        }
        $page = ($action === 'update')? 'update_contact': 'contact';
        //$this->view->js = array('workbench/js/'.$page.'.js');

        $this->view->title = 'Webmaster - School Contact';
        $this->view->render('webmaster/'.$page, 'admin');
    }

    function add_contact($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'type' => array(
                        'name' => 'Type',
                        'required' => true,
                    ),
                    'details' => array(
                        'name' => 'Details',
                        'required' => true,
                    ),
                ));

                if ($validation->passed()) {
                    $this->model->add_contact($update);

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
        Redirect::to(URL . 'webmaster/contact');
    }

    function enquiry($action = null, $id = null){
        switch($action){
            case 'forward':
            case 'reply':
                $this->view->action = $action;

                list($this->view->read, $this->view->count, $this->view->new) = $this->model->get_enquiry($id);
                $action = 'compose';
                break;
            case 'delete':
                $this->model->delete_enquiry($id);
                Redirect::to(URL . 'webmaster/enquiry');
                break;
            case 'read':
                list($this->view->read, $this->view->count) = $this->model->get_enquiry($id);
                break;

            default:
                $this->view->action = isset($action) ? $action: null;
                list($this->view->enquiry, $this->view->count, $this->view->new) = $this->model->get_enquiry();
                break;

        }

        $page = ( isset($action))? $action: 'index';
        if($action === 'compose'){
            $this->view->jsPlugin = array('bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');
            $this->view->cssPlugin = array('bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');
            $this->view->js = array('webmaster/enquiry/js/main.js');
        }

        //$this->view->js = array('workbench/js/'.$page.'.js');

        $this->view->title = 'Webmaster - Enquiries';
        $this->view->render('webmaster/enquiry/'.$page, 'admin');
    }

    function enquiry_actions($action = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'to' => array(
                        'name' => 'TO',
                        'required' => true,
                    ),
                    'subject' => array(
                        'name' => 'Subject',
                        'required' => true,
                    ),
                    'msg' => array(
                        'name' => 'Message',
                        'required' => true,
                    ),
                ));

                if ($validation->passed()) {
                    $this->model->enquiry_actions($action);

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
        Redirect::to(URL . 'webmaster/enquiry');
    }

    function event($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'update':
                    list($this->view->about, $this->view->count) = $this->model->get_event($id);
                    break;
                case 'delete':
                    $this->model->delete_event($id);
                    $this->view->about = $this->model->get_event();
                    break;
            }

        }else{
            $this->view->about = $this->model->get_event();

        }
        $page = ($action === 'update')? 'update_event': 'event';
        $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
        $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
        $this->view->js = array('webmaster/js/ui.js');

        $this->view->title = 'Webmaster - Event ';
        $this->view->render('webmaster/'.$page, 'admin');
    }


    function add_event($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'title' => array(
                        'name' => 'Title',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'Description',
                        'required' => true,
                    ),
                    'datepicker' => array(
                        'name' => 'Date',
                        'required' => true,
                    ),
                    'timepicker' => array(
                        'name' => 'Time',
                        'required' => true,
                    ),
                ));

                if ($validation->passed()) {
                    $this->model->add_event($update);

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
        Redirect::to(URL . 'webmaster/event');
    }

    function clearance($action = null, $id = null){
        $action = (isset($action))? $action: 'Students';

        $this->view->clear_type = $action;
        if($action){
            switch($action){
                case 'Students':
                    $perms = 1;
                    $table = 'info_personal';
                    break;
                case 'Parents':
                    $perms = 2;
                    $table = 'info_personal';
                    break;
                case 'Staff':
                    $perms = 3;
                    $table = 'info_staff';
                    break;
                case 'Portal':
                    $perms = 3;
                    $table = 'users';
                    break;
                case 'activate':
                case 'deactivate':
                    $this->view->people = $this->model->account_activity($action,$id);
                    break;
                case 'register':
                    $this->view->people = $this->model->academic_register($id);
                    break;

            }

        }else{
            Redirect::to(URL.'webmaster');
            return false;
        }

        if (Input::exists()) {
            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'description' => array(
                    'name' => 'Search Item',
                    'required' => true,
                ),
            ));
            if ($validation->passed()){
                $this->view->people = $this->model->clearance($table,$perms);
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

        //$page = ($action === 'update')? 'update_contact': 'contact';
        //$this->view->js = array('workbench/js/'.$page.'.js');

        $this->view->title = 'Webmaster - School Contact';
        $this->view->render('webmaster/clearance/index', 'admin');
    }

    function settings(){

        $this->view->js = array('admin/js/upload_check.js');

        $this->view->title = 'School System';
        $this->view->render('webmaster/settings', 'admin');
    }

    function gallery($action = null, $id = null){
        $this->view->js = array('admin/js/upload_check.js');
        if($action && $id){
            switch($action){
                case 'update':
                    $this->view->perform_update = true;
                    $this->view->gallery = $this->model->gallery();

                    list($this->view->about, $this->view->count) = $this->model->gallery($id);
                    break;
                case 'delete':
                    $this->model->delete_gallery($id);
                    Redirect::to(URL.'webmaster/gallery');
                    return false;
                    break;
            }

        }else{
            $this->view->about = null; $this->view->count= null;
            $this->view->gallery = $this->model->gallery();

        }

        $this->view->title = 'Photo Gallery';
        $this->view->render('webmaster/gallery', 'admin');
    }

    function add_gallery($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'description' => array(
                        'name' => 'Description',
                        'required' => true,
                    ),
                ));

                if ($validation->passed()) {
                    $upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'photo_gallery\\', 'webmaster/gallery');
                    if ($upload) {
                        $this->model->add_gallery($update, $upload);
                    } else {
                        $this->model->add_gallery($update, Input::get('previous_upload'));
                        Session::put('home', 'No Image was Uploaded.');
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
            }
        }
        Redirect::to(URL . 'webmaster/gallery');
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
            //Session::put('error', $output);
            //Redirect::to(URL.$step);

            return null;
        } else {
            $resize = new Resize($destination.$path);
            $resize->resizeImage(450, 300, 'exact');
            $resize->saveImage($destination.$path, 100);
            return $path;
        }
    }

    function account(){
        $this->view->account = $this->model->account();
        //$this->view->personnel_rank = $this->model->personnel_rank();

        $this->view->generalJS = array('upload_check.js');

        $this->view->title = 'My Account';
        $this->view->render('webmaster/account', 'admin');
    }


    function account_update() {
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
                    'marital_status' => array(
                        'name' => 'Marital Status',
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
                    'about' => array(
                        'name' => 'Professional Bio Data',
                        'required' => true,
                    ),
                ));

                $agree = (Input::get('agree') === 'yes') ? true : false;
                if ($validation->passed() && $agree) {
                    //die(' every thing is ok');
                    $upload = $this->upload(Input::get('MAX_FILE_SIZE'), 'profile-pictures\\', 'webmaster/account');
                    if ($this->model->account_update($upload)) {
                        //enter data to db
                        //die(($upload).' every thing is ok');
                    } else {
                        //we have a server error
                        Session::put('error', 'Please contact webmaster');
                        //out error
                    }
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "There was 1 error in the form.";
                    } else {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    if (!$agree) {
                        $message .= "You have to agree to the terms and conditions.";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
        }
        Redirect::to(URL.'webmaster/account');
    }


    function admissions($action = null, $id = null){
        if($action){
            $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
            $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
            $model = $this->reMapRouteToModel('admin');
            $this->view->class = $this->admin->get_class();
            $this->view->js = array('admin/js/ui.js');
            $page = 'interview';


            switch($action){
                case 'interview':
                    $this->view->admissions = $this->model->admission_interview();
                    break;
                case 'activate':
                case 'deactivate':
                    $this->model->interview_actions($action,$id);
                    $this->view->admissions = $this->model->admission_interview();
                break;
                case 'update':
                     $this->view->details = $this->model->admission_interview($id);
                    $page = 'update';
                    break;
                case 'view':
                    $this->view->admissions = $this->model->admitted('view', $id);
                    $page = 'view';
                    break;
                case 'accept':
                case 'decline':
                    $page = 'index';
                    $this->model->admitted($action, $id);
                $this->view->admissions = $this->model->get_admissions();

                break;
            }

        }else{
            $this->view->admissions = $this->model->get_admissions();
            $page = 'index';

        }
        //$this->view->js = array('workbench/js/'.$page.'.js');

        $this->view->title = 'Webmaster - Admissions';
        $this->view->render('webmaster/admission/'.$page, 'admin');
    }

    function add_interview($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();

                $validation = $validate->check($_POST, array(
                    'academic_session' => array(
                        'name' => 'Academic Session',
                        'required' => true,
                    ),
                    'academic_term' => array(
                        'name' => 'Admission/Entry Term',
                        'required' => true,
                    ),
                    'academic_class' => array(
                        'name' => 'Admission/Entry Class',
                        'required' => true,
                    ),
                    'interview_date' => array(
                        'name' => 'Date',
                        'required' => true,
                    ),
                    'interview_time' => array(
                        'name' => 'Time',
                        'required' => true,
                    ),
                    'venue' => array(
                        'name' => 'Venue',
                        'required' => true,
                    ),
                    'requirements' => array(
                        'name' => 'Venue',
                        'required' => true,
                    ),
                    'other_details' => array(
                        'name' => 'Venue',
                        'required' => true,
                    ),
                ));

                if ($validation->passed()) {
                    $this->model->add_interview($update);


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
        Redirect::to(URL . 'webmaster/admissions/interview');
    }







}