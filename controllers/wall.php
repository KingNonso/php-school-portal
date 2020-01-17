<?php

class Wall extends Controller {

    function __construct() {
        parent::__construct();

        if (!isset($_SESSION['maxfiles'])) {
            $_SESSION['maxfiles'] = ini_get('max_file_uploads');
            $_SESSION['postmax'] = Upload::convertToBytes(ini_get('post_max_size'));
            $_SESSION['displaymax'] = Upload::convertFromBytes($_SESSION['postmax']);
        }


        $logged = Session::get('loggedIn');
        //$role = Session::get('role');
        if ($logged == false) {

            Redirect::to(URL.'login');
        }
        $this->view->generalJS = array('custom/js/upload_check.js','custom/js/ajax.js','custom/js/post_loader.js');


    }

    function index() {
        $this->view->js = array('wall/js/default.js','wall/js/wall_pic_post.js','wall/js/friendship.js');

        $person = $this->model->get_person();
        $this->view->person = $person;
        $this->view->title = 'Winners - '.ucwords(str_replace('-',' ',$person['firstname'])).'\'s wall';

        $this->view->wall_post = $this->model->wall_post();
        $this->view->friendship_requested = $this->model->friendship_request($person['user_id']);

        $this->view->myFriends = $this->model->get_my_friends();

        //$this->view->likes = $this->model->get_user_likes($_SESSION['user_id']);
        $this->view->render('wall/index', 'member');
    }

    function load_more_wall_post(){
        $this->model->load_more_wall_post();
    }


    function first(){
        $this->view->js = array('wall/js/first.js');
        $this->view->person = $this->model->get_person();
        $this->view->title = "First Login: Setup Account";
        $this->view->render('wall/first', 'member');
    }

    function member_status() {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'person_state' => array(
                    'name' => 'person_state',
                ),
                'person_slug' => array(
                    'name' => 'person_slug',
                ),
            ));
            if ($validation->passed() && $this->model->member_status()) {
            } else {
                if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                echo('error');
                exit();
            }
        }
    }

    function photo_status($value) {
        if( $image = $this->ajax_upload()){
            $this->model->member_status($image,$value);

        }

    }

    function ajax_upload(){
        $max = Input::get('max');
        $folder = 'profile-pictures\\';

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
            $path = NULL;
            $output = "<p class=\"errors\"> ";
            $output .= "Please review the following fields: <br />";
            foreach ($result as $error) {
                $output .= " - " . $error . "<br />";
            }
            $output .= "</p>";
            echo($output);
            return false;
        } else {
            return($path);
        }
        //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
        /*
          else{
          $resize = new Resize($destination.$path);
          $resize->resizeImage(120, 90, 'exact');
          $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
          } */
    }

    function search_for_person($str, $for = null){
        $this->model->search_for_person($str, $for);
    }

    function post() {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'message' => array(
                    'name' => 'message',
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $this->model->post()) {

                //do nothing
            }
        }
    }

    function picturePost(){
        $max = Input::get('max');
        $folder = 'wall\\';

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
            $path = NULL;
            $output = "<p class=\"errors\"> ";
            $output .= "Please review the following fields: <br />";
            foreach ($result as $error) {
                $output .= " - " . $error . "<br />";
            }
            $output .= "</p>";
            echo($output);
            return false;
        } else {
            echo($path);
            exit();
        }
        //Do not resize, do not save any resized image. Responsive system automatically adjust to fit screen size
        /*
          else{
          $resize = new Resize($destination.$path);
          $resize->resizeImage(120, 90, 'exact');
          $resize->saveImage($destination.'/'.$id_key.'/'.$path, 100);
          } */
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
            Redirect::to(URL . $step);
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

    public function like($post, $id){
        $this->model->like($post, $id);
    }
    public function unlike($post, $id){
        $this->model->unlike($post, $id);
    }

    function comment() {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'txtmessage' => array(
                    'name' => 'message',
                    'required' => true,
                ),
                'post_id' => array(
                    'name' => 'post_id',
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $this->model->comment()) {

                //do nothing
            }
        }
        return false;
    }

    function react() {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'txtmessage' => array(
                    'name' => 'message',
                    'required' => true,
                ),
                'reply_id' => array(
                    'name' => 'reply_id',
                    'required' => true,
                ),
            ));
            if ($validation->passed() && $this->model->react()) {

                //do nothing
            }
        }
        return false;
    }


    function delete($type, $id) {
        $this->model->delete($type, $id);
    }




}
