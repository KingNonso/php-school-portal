<?php

class Admin extends Controller {

    function __construct() {
        parent::__construct();

        if(!isset($_SESSION['maxfiles'])){
            $_SESSION['maxfiles'] = ini_get('max_file_uploads');
            $_SESSION['postmax'] = Upload::convertToBytes(ini_get('post_max_size'));
            $_SESSION['displaymax'] = Upload::convertFromBytes($_SESSION['postmax']);
        }

        $logged = Session::get('loggedIn');
        if ($logged == false || Session::get('role') !== 'administrator') {
            Redirect::to(URL.'login');
        }
        $this->view->generalJS = array('custom/js/ajax.js');



    }

    /*_--------------------------- PAGE LOADERS  -------------------------------------------------     */
    function index(){
         $role = (Session::exists('role'))? Session::get('role'): 'School Admin';
        $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
        $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
        $this->view->js = array('admin/js/ui.js');

        $this->view->title = 'School Board - '.$role;
        $this->view->render('admin/index', 'admin');
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
            Redirect::to(URL.'admin/account');

            return false;
        } else {
            $resize = new Resize($destination.$path);
            $resize->resizeImage(215, 215, 'exact');
            $resize->saveImage($destination.$path, 100);
            return $path;
        }
    }

    function classes($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'update':
                    $this->view->classes = $this->model->get_class($id);
                    break;
            }
        }
        $this->view->class = $this->model->get_class();

        $page = ($action === 'update')? 'update_class': 'class';
        $this->view->js = array('webmaster/js/ui.js');

        $this->view->title = 'Administrator - Classes';
        $this->view->render('admin/'.$page, 'admin');
    }

    function create_class($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'class_name' => array(
                        'name' => 'Class Name',
                        'required' => true,
                        'min' => 3,
                        'unique' => 'academic_classes'
                    ),
                    'class_desc' => array(
                        'name' => 'Class Description',
                        'required' => true,
                    ),
                    'parent_class' => array(
                        'name' => 'Parent Class',
                    ),
                    'requirement' => array(
                        'name' => 'Requirements',
                    ),
                ));
                if ($validation->passed() && $this->model->create_class($update)) {
                    //proceed to step 2
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
        Redirect::to(URL . 'admin/classes');
        //$this->view->render('reg/member/step-1', true);
    }

    function session_term_start() {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'entry_session' => array(
                        'name' => 'Session',
                        'required' => true,
                    ),
                    'entry_term' => array(
                        'name' => 'Term Description',
                        'required' => true,
                    ),
                    'starts' => array(
                        'name' => 'Starts',
                        'required' => true,
                    ),
                    'ends' => array(
                        'name' => 'Ends',
                        'required' => true,
                    ),
                    'details' => array(
                        'name' => 'Details',
                    ),
                ));
                if ($validation->passed() && $this->model->session_term_start()) {
                    //proceed to step 2
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
        Redirect::to(URL . 'admin/index');
        //$this->view->render('reg/member/step-1', true);
    }

    function event($action = null, $id = null){

        $this->view->academics = $this->model->get_academic_sessions();
        if($action && $id){
            switch($action){
                case 'update':
                    list($this->view->about, $this->view->count) = $this->model->get_event($id);
                    break;
                case 'delete':
                    $this->model->delete_event($id);
                    $this->view->about = $this->model->get_event();
                    break;
                case 'view':
                    list($this->view->about,$this->view->headers) = $this->model->get_academic_calender($id);
                    break;
            }

        }else{
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'show_academic' => array(
                        'name' => 'Search Item',
                        'required' => true,
                    ),
                ));
                if ($validation->passed()){
                    list($this->view->about,$this->view->headers) = $this->model->get_academic_calender(Input::get('show_academic'));
                }

            }else{
                list($this->view->about,$this->view->headers) = $this->model->get_academic_calender();
            }


        }

        $page = ($action === 'update')? 'update_event': 'event';
        $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
        $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
        $this->view->js = array('webmaster/js/ui.js');

        $this->view->title = 'Administrator - Calender ';
        $this->view->render('admin/'.$page, 'admin');
    }


    function add_event($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'show_academic' => array(
                        'name' => 'Add Event to',
                        'required' => true,
                    ),
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
                    $this->view->about = $this->model->add_event($update);

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
        Redirect::to(URL . 'admin/event/view');
    }

    function adviser($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'class':
                    list($this->view->person_id,$this->view->person,$this->view->detail) = $this->model->adviser_search($id);
                    break;
                case 'delete':
                    $this->model->add_adviser($id);
                    break;
            }
        }else{
            $this->view->adviser = $this->model->adviser_search();

            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'staff_search' => array(
                        'name' => 'Enter Staff Name',
                        'required' => true,
                    ),
                ));
                if ($validation->passed()) {
                    $this->view->adviser = $this->model->adviser_search();
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
        $this->view->class = $this->model->get_class();
        $this->view->academics = $this->model->get_academic_sessions();

        $page = ($action === 'update')? 'update_about': 'adviser';
        $this->view->js = array('webmaster/js/ui.js');

        $this->view->title = 'Administrator - adviser';
        $this->view->render('admin/'.$page, 'admin');
    }

    function add_adviser() {
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'adviser' => array(
                        'name' => 'Staff Selection ',
                        'required' => true,
                    ),
                    'entry_class' => array(
                        'name' => 'Add Adviser to',
                        'required' => true,
                    ),
                    'show_academic' => array(
                        'name' => 'Effective From',
                        'required' => true,
                    ),
                    'datepicker' => array(
                        'name' => 'Effective Date',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'Description',
                    ),
                ));
                if ($validation->passed() && $this->model->add_adviser()) {
                    //proceed to step 2
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
        Redirect::to(URL . 'admin/adviser');
    }

    function subject($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'update':
                    $this->view->subject = $this->model->get_subject($id);
                    $this->view->class = $this->model->get_class();
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
            $this->view->subject = $this->model->get_subject();
            $this->view->class = $this->model->get_class();

        }
        $page = ($action === 'update')? 'update_subject': 'subject';
        //$this->view->js = array('workbench/js/'.$page.'.js');

        $this->view->title = 'Administrator - subject';
        $this->view->render('admin/'.$page, 'admin');
    }

    function create_subject($update = null) {
        //@Task: Do your error checking
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'subject_name' => array(
                        'name' => 'Subject Name',
                        'required' => true,
                    ),
                    'subject_alias' => array(
                        'name' => 'Subject Alias',
                        'min' => 3,
                        'required' => true,
                    ),
                    'subject_for' => array(
                        'name' => 'Subject Class',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'Subject description',
                    ),
                    'prerequisite' => array(
                        'name' => 'Subject prerequisite',
                    ),
                    'text_books' => array(
                        'name' => 'Subject text books',
                    ),
                    'tools' => array(
                        'name' => 'Subject tools',
                    ),
                ));
                if ($validation->passed() && $this->model->create_subject($update)) {
                    //proceed to step 2
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
        Redirect::to(URL . 'admin/subject');
    }

    function teacher($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'subject':
                    list($this->view->person_id,$this->view->person,$this->view->detail) = $this->model->teacher_subject($id);
                    break;
                case 'delete':
                    $this->model->add_teacher($id);
                    break;
            }
        }else{
            $this->view->adviser = $this->model->teacher_subject();

            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'staff_search' => array(
                        'name' => 'Enter Staff Name',
                        'required' => true,
                    ),
                ));
                if ($validation->passed()) {
                    $this->view->adviser = $this->model->teacher_subject();
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
        $this->view->subject = $this->model->get_subject();
        $this->view->academics = $this->model->get_academic_sessions();

        $page = ($action === 'update')? 'update_teacher': 'teacher';
        $this->view->js = array('webmaster/js/ui.js');

        $this->view->title = 'Administrator - Teacher';
        $this->view->render('admin/'.$page, 'admin');
    }

    function add_teacher() {
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'teacher' => array(
                        'name' => 'Staff Selection ',
                        'required' => true,
                    ),
                    'entry_class' => array(
                        'name' => 'Add teacher to',
                        'required' => true,
                    ),
                    'show_academic' => array(
                        'name' => 'Effective From',
                        'required' => true,
                    ),
                    'datepicker' => array(
                        'name' => 'Effective Date',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'Description',
                    ),
                ));
                if ($validation->passed() && $this->model->add_teacher()) {
                    //proceed to step 2
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
        Redirect::to(URL . 'admin/teacher');
    }

    function view($action = null, $id = null){
        if($action && $id){
            switch($action){
                case 'advisers':
                    $this->view->advisers = $this->model->view_something($action, $id);

                    break;
                case 'teachers':
                    $this->view->teachers = $this->model->view_something($action, $id);
                    break;
                default:
                    Redirect::to(URL.'admin');
                    break;
            }
        }else{
            Redirect::to(URL.'admin');
        }

        $this->view->js = array('webmaster/js/ui.js');
        $this->view->action = $action;
        $this->view->title = 'Administrator - '.$action;
        $this->view->render('admin/view_details', 'admin');
    }






}