<?php

class About_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function get_about($first = false) {
        if($first){
            $data =  $this->db->fetch_exact_two('about_us', 'visible',1, 'position',1);
            return $data;
        }else{
            $data =  $this->db->get('about_us',array('visible','=',1),'position')->results();
            return $data;
        }
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
