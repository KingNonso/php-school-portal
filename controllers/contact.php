<?php

class Contact extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->generalJS = array('custom/js/ajax.js');
    }


    function index(){

        $this->view->js = array('index/js/main.js','index/js/default.js');
        $this->view->title = "School Contact Info";
        $this->view->contact = $this->model->get_contact();


        $this->view->render('index/contact');
    }





    function about(){
        $this->view->js = array('index/js/default.js');
        $model = $this->reMapRouteToModel('blog');

        $this->view->latest10 = $this->reMappedRoute->get_all_blog_titles(false, 5);
        $this->view->last = $this->reMappedRoute->get_last_post();
        $this->view->title = 'About Winners Chapel Ifite';
        $this->view->render('index/index2', 'none');
    }

    function work(){
        $this->view->title = 'About Winners Chapel Ifite';
        $this->view->render('index/work', 'member');
    }


    function new_enquiry() {
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'name' => 'Full Name',
                        'required' => true),
                    'phone_no' => array(
                        'name' => 'Phone Number'),
                    'email' => array(
                        'name' => 'Email',
                        'required' => true),
                    'address' => array(
                        'name' => 'Contact Address'),
                    'message' => array(
                        'name' => 'Message',
                        'required' => true),
                    'subject' => array(
                        'name' => 'Subject',
                        )
                ));
                if ($validation->passed()) {
                    $this->model->new_enquiry();

                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
                Redirect::to(URL . 'contact#contact-form');
            }
        }
    }



	

}