<?php

class About extends Controller {

    function __construct() {
        parent::__construct();

        $this->view->generalJS = array('custom/js/ajax.js');
    }


    function index(){

        $this->view->js = array('index/js/main.js','index/js/default.js');
        $this->view->title = "About School Education";
        $this->view->about = $this->model->get_about();

        $model = $this->reMapRouteToModel('blog');
        $this->view->latest10 = $this->blog->get_all_blog_titles(false, 5);
        $this->view->last = $this->blog->get_last_post();


        $this->view->render('index/about');
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

    /*_--------------------------- ACTION GROUP  -------------------------------------------------     */

    function run_about() {
        if (Input::exists()) {
            if (Token::check(Input::get('token'))) {

                $validate = new Validate();
                $validation = $validate->check($_POST, array(
                    'name' => array(
                        'name' => 'Full Names',
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
                if ($validation->passed() && recaptcha(TRUE) && $this->model->run_about()) {
                    echo('success');
                    exit();


                } else {
                    echo('bad_validation');
                    exit();

                }
            }
        }
    }



	

}