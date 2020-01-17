<?php

class Login extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->generalJS = array('custom/js/ajax.js');
    }

    function index() {
        $this->view->js = array('login/js/main.js');
        $this->model->check_status(); //checks login status
        $this->view->title = 'Login Here';
        $this->view->render('login/index');
    }

    function recovery(){
        $this->view->js = array('login/js/pass_recover.js');

        $this->view->title = "Password Recovery";
        $this->view->render('login/password_recovery');
    }

    function recaptcha(){
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'email' => array(
                    'name' => 'email',
                    'required' => true,
                ),
            ));
            if ($validation->passed()) {
                $email = Input::get('email');
                $url_string = $this->model->recovery($email);
                if($url_string){
                    $secret = '6LeWVSgTAAAAADzVfX5VQ9vRbfW_UO3w3_k-savs';
                    $response = $_POST['recaptcha'];
                    $userIP = $_SERVER['REMOTE_ADDR'];

                    $url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$userIP");

                    $result = json_decode($url, true);

                    if(isset($result) && $result['success']==1){

                        // Email the user their activation link
                        $to = $email;
                        $from = "nonso@frogfreezone.com"; //
                        $subject = 'Password Reset on Winners Family';
                        $message = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Winners Family Worldwide</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:20px; background:#f4511e; font-size:24px; color:#fff;">Living Faith Church International: '. date('D, d F, Y ')." at " .date(' h:i:s a').'</div><div style="padding:24px; font-size:17px;">Hello, <h1>Password Reset Request</h1><br />This is an automatically generated email, it was sent to you because you have requested a password reset.<br />Your Password for this account: '.$email.' has been reset.<br /><br /><b><a href="http://localhost/www/doing/mandate/login/reset/'.$email.'/'.$url_string.'">Click here to Start a new Session now</a></b><br /><br />Please ignore this mail if you did not request it. Thanks</div></body></html>';
                        $headers = "From: $from\n";
                        $headers .= "MIME-Version: 1.0\n";
                        $headers .= "Content-type: text/html; charset=iso-8859-1\n";
                        $headers .= 'Cc: nonso@frogfreezone.com' . "\r\n";
                        //$headers .= 'Bcc: nonso@frogfreezone.com' . "\r\n";
                        $headers .= 'Reply-To: '.$from.'' . "\r\n";
                        if(!mail($to, $subject, $message, $headers)){
                            echo 'Oops Something went wrong';
                            exit();
                        }else{
                            echo "success";
                            exit();
                        }

                    }


                }

            }else{
                echo "bad_validation";
                exit();
            }
        }


    }


    function run() {
        echo('success');
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'login_email' => array(
                    'name' => 'Email',
                    'required' => true),
                'login_pwd' => array(
                    'name' => 'Password',
                    'required' => true)
            ));
            if ($validate->passed()) {
                $remember = (Input::get('login_me') === 'remember') ? true : false;

                if ($this->model->login(Input::get('login_email'), Input::get('login_pwd'), $remember)) {
                    echo('success');
                    exit();
                    //log user in
                } else {
                    //failed
                    echo "no_match";
                    exit();
                }
            } else {
                echo "f";
                exit();

            }
                /*
                 * if (count($validation->errors()) == 1) {
                    $message = "There was 1 error in the form.";
                } else {
                    $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                }
                $message .= $validate->display_errors();
                $this->view->error = $message;
            }
            $this->index();
                 */
        }
    }

    function update_pass(){
        $this->model->update_pass();
        Redirect::to(backToSender());

    }

    function login() {
        if (Input::exists()) {
            $validate = new Validate();
            $validation = $validate->check($_POST, array(
                'email' => array(
                    'name' => 'email',
                    'required' => true),
                'password' => array(
                    'name' => 'Password',
                    'required' => true),
            ));

            if ($validate->passed()) {
                //log user in
                $remember = (Input::checkbox('login_me')) ? true : false;

                if ($this->model->login(Input::get('email'), Input::get('password'), $remember)) {
                    exit();
                } else {
                    //die(error_get_last())
                    //failed
                    $message = "Username/password incorrect.";
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
            Redirect::to(URL . "login");
        }
    }

    function check_details($detail){
        $this->model->check_details($detail);
    }

    function register() {
        //$this->view->js = array('login/js/main.js');

        //$this->model->check_status(); //checks login status
        $this->view->title = 'New Portal Register';
        $this->view->render('login/register', 'none');
    }



    function account_setup() {
        //@Task: Do your error checking
        if (Input::exists()) {

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
                    'new_again' => array(
                        'name' => 'Password Confirmation',
                        'required' => true,
                        'matches' => 'password'
                    ),
                    'phone_number' => array(
                        'name' => 'phone_number',
                        'required' => true,
                    ),
                    'surname' => array(
                        'name' => 'surname',
                        'required' => true,
                    ),
                    'firstname' => array(
                        'name' => 'first name',
                        'required' => true,
                    ),
                ));
                $send_pass = (Input::get('agree') === 'yes') ? true : false;
            if ($validation->passed() && $send_pass) {
                    if($this->model->account_setup()){
                        Redirect::to(URL.'login');
                        exit;
                    }
                } else {
                    $message = "";
                    if (count($validation->errors()) == 1) {
                        $message .= "There was 1 error in the form.";
                    } else {
                        $message .= "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }

                    if(!$send_pass){
                        $message .= "You must accept the terms and conditions to proceed.";
                    }

                    $message .= $validate->display_errors();
                Session::put('error', $message);
            }

        }
        Redirect::to(backToSender());
    }


    function logout() {

        $this->view->title = 'Logout';
        //$this->view->render('login/index');

        Session::delete('loggedIn');
        Session::delete('role');
        Cookie::delete('hash');
        session_destroy();

        //thanks for destroying, now lets begin anew
        session_start();
        Session::flash('home', 'You have been successfully logged out!');

        Redirect::to(URL . 'login');
    }

    function reset($email, $url){

    }

}
