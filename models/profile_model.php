<?php

class Profile_Model extends Model {
    private  $_data;

    function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    public function data() {
        return $this->_data;
    }

    public function get_person(){
        $data =  $this->db->fetch_exact('info_personal','user_id',Session::get('user'));
        $data[] = $this->db->fetch_last('member_status','status_id','member_id',$data['person_id']);

        return($data);
    }


    public function member($name_slug) {
        $personal = $this->db->fetch_exact('info_personal', 'slug', $name_slug);
        $personal[] = $this->db->fetch_last('member_status','status_id','member_id',$personal['person_id']);

        return $personal;
    }

    public function friend_system($viewer, $owner){
        if($viewer == $owner){
            return 'owner';

        }
        //check if friendship has been requested by either
        //note user1 is the requester
        // user2 is the acceptor
        $is_friend = $this->db->get('friends',array('user1_id','=',$viewer,'user2_id','=',$owner))->first() ? $this->db->get('friends',array('user1_id','=',$viewer,'user2_id','=',$owner))->first() : $this->db->get('friends',array('user1_id','=',$owner,'user2_id','=',$viewer))->first();
        $is_friend_count = $this->db->count();
        if($is_friend_count){
            if($is_friend->accepted){
                return 'friends';
            }
            elseif($is_friend->accepted == 0){
                if($is_friend->user2_id == $viewer){
                    return $is_friend->id;
                }
                return 'pending';
            }
        }else{
            return 'not-yet';
        }


    }

    public function request_friendship(){
        try{
            $this->db->insert('friends',array(
                'datemade' => $this->today,
                'user1_id' => Input::get('viewer'),
                'user2_id' => Input::get('owner'),
                'accepted' => 0

            ));
            return true;

        }catch (Exception $e){
            return false;
        }

    }

    public function friendship_response(){
        try{
            if(Input::get('response') == 1){
                $this->db->update('friends',array(
                    'datemade' => $this->today,
                    'accepted' => 1

                ),'id',Input::get('match'));
                return true;
            }else{
                $this->db->delete('friends',array('id','=',Input::get('match')));
                echo 'declined';
                exit();
            }

        }catch (Exception $e){
            return false;
        }

    }

    public function get_my_friends($user_id = null){
        $my_friends = array();
        $user_id = isset($user_id) ? $user_id :Session::get('user_id');
        $is_friend = $this->db->get('friends',array('user1_id','=',$user_id))->results() ;
        $is_friend_count = $this->db->count();
        if($is_friend_count){
            foreach($is_friend as $f){
                if($f->accepted == 1)
                    $my_friends[] = $f->user2_id;
            }
        }
        $is_friend = $this->db->get('friends',array('user2_id','=',$user_id))->results() ;
        $is_friend_count = $this->db->count();
        if($is_friend_count){
            foreach($is_friend as $f){
                if($f->accepted == 1)
                    $my_friends[] = $f->user1_id;
            }
        }

        return(($my_friends)) ;



    }














}
