<?php

class Profile extends Controller {

    function __construct() {
        parent::__construct();


        $logged = Session::get('loggedIn');
        $role = Session::get('role');
        if ($logged == false) {

            Redirect::to(URL.'login');
        }
        $this->view->generalJS = array('custom/js/ajax.js');


    }

    function index() {
        $this->view->title = 'Someones profile';
        $this->view->js = array('profile/js/default.js');
        $this->view->render('profile/profile', 'member');
    }

    public function member($slug){
        $member = $this->model->member($slug);
        $this->view->title = $member['firstname'] .' - Profile';//'Profile - '.ucwords(str_replace('-',' ',$slug));
        $this->view->js = array('profile/js/friendship.js');

        //$this->view->posts = $this->model->get_two_chat($_SESSION['user_id'],Session::get('receiver_id'));
        //$this->view->conversation = $this->model->get_conversation();
        $this->view->member = $member;
        $this->view->isFriend = $this->model->friend_system(Session::get('user_id'),$member['user_id']);
        //$this->view->isFriend = $this->model->friend_system(3,1);
        //$this->view->isBlocked = $this->model->member($slug);
        if (Session::get('loggedIn') == false) {
            $this->view->render('profile/profile');
        }else{
            $this->view->render('profile/profile_insider', 'member');
        }

    }

    public function friends($slug = null){
        if($slug){
            $member = $this->model->member($slug);
            $title = 'Friends of - '.$member['firstname'];
            $this->view->member = $member;
            $this->view->myFriends = $this->model->get_my_friends($member['user_id']);

        }else{
            $title = 'Your Friends';
            $this->view->member = $this->model->get_person();
            $this->view->myFriends = $this->model->get_my_friends();
        }
        $this->view->title = $title;

        $this->view->render('profile/friends', 'member');



    }

    public function request_friendship(){
        $this->model->request_friendship();
    }
    public function friendship_response(){
        $this->model->friendship_response();
    }


}
