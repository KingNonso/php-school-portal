<?php

class Index_Model extends Model {

    function __construct() {
        parent::__construct();
    }
    public function get_settings() {
        $data = $this->db->fetch_exact('settings', 'id',1);
        if($data){
            return $data;
        }else{
            //call error
            return false;
        }
    }
    public function gallery() {
        $data =  $this->db->getAll_assoc('photo_gallery')->results_assoc();
        return lastFive($data);
    }

    public function run_about() {
        try{
            $this->db->insert('enquiries', array(
                'name' => Input::get('name'),
                'phone_no' => Input::get('phone_no'),
                'email' => Input::get('email'),
                'address' => Input::get('address'),
                'message' => Input::get('message'),
                'subject' => Input::get('subject'),
                'date' => $this->today,
                'status' => "new",//new, replied to or seen
            ));
            cleanUP();

            return true;


            $message = "Thank You. You will hear from us soon.";
            Session::flash('home',$message);
            Redirect::to(URL.'index/about');
        }catch(Exception $e){
            return false;
            //redirect user to specific page saying oops
            die($e->getMessage());
        }


    }

    public function last_post(){
         //get latest project that is last in db
        //I'm going to need this function in displaying the last result of a blog
        $result = $this->db->fetch_last('blog_post','post_id','post_status', 'publish');
        die(print_r($result));
    }

    public function all_blog_titles(){
            return $this->db->get_assoc('blog_post',array('post_status','=','publish'),'post_id')->results_assoc();

    }


}
