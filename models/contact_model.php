<?php

class Contact_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function get_contact($first = false) {
        if($first){

            $d =  $this->db->get('contact_us',array('type', '=', 'Address'));
            $data = $this->db->first();
            return $data;
        }else{
            $data =  $this->db->get('contact_us')->results();
            return $data;
        }
    }


    public function new_enquiry() {
        try{
            $this->db->insert('contact_enquiry', array(
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

            $message = "Thank You! Your message has been received. You will hear from us soon.";
            Session::flash('home',$message);
            return true;


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
