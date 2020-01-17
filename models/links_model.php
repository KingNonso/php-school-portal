<?php

class Links_Model extends Model {

    function __construct() {
        parent::__construct();

    }

    function search_for_person($str){
        $search = $this->user->search_box($str, 'members');
        $search_count = $this->user->count();
        //$friends = $user->find_friends($user_id);
        if($search_count != 0){

            foreach($search as $suggestion){
                $name = $suggestion['firstname']. ' '.$suggestion['surname'].' '.$suggestion['othername'];
                //$pix = $this->user->get_profile_pic($suggestion['person_id']);
                if(!empty($suggestion['profile_picture'])){
                    $source = URL.'public/uploads/profile-pictures/'. $suggestion['profile_picture'];
                }else{
                    $source = URL.'public/custom/img/avatar.png';
                }

                //$echo = '<li  onclick="set_item(\''.$suggestion['user_id'].'\')" id="setter" style="cursor:pointer; list-style:none"><h6><img class="w3-circle" src="'.$source.'" width="30" height="30">';
                $echo = '<a href="javascript:void(0);" class="list-group-item" onclick="set_item(\''.$suggestion['user_id'].'\',\''.$name.'\')" id="setter" >';
                $echo .= '<div class="row">
                        <div class="col-sm-2">';

                $echo .= '<img src="'.$source.'" class="img-circle" height="35px" width="35px"  alt="'.$name.'">';
                $echo .= '</div>
                        <div class="col-sm-10 text-left text-holder">';
                $echo .= '<h4 class="list-group-item-heading">';

                $echo .= ''.$name.'';
                $echo .= '</h4>';
                $echo .= '<p class="list-group-item-text">List Group Item Text</p>';

                $echo .= '</div>';
                $echo .= '</div>';

                $echo .= '</a>';
                //$echo .= '<li  style="cursor:pointer; list-style:none"><h6><img class="w3-circle" src="'.$source.'" width="30" height="30">';
                //$echo .= ' '.$name.' :: '.$suggestion['phone_no'];
                ///$chapter = $this->user->get_person_chapter($suggestion['chapter_id']);
                // $echo .= ' :: Chapter: '. $chapter['chapter_name'];
                //$echo .= '</h6></li>';


                echo($echo);
            }


        }else {
            echo "No suggestion";
        }

    }

    function make_executive($person){
        try {
            $guide = $this->db->fetch_exact('info_personal','person_id',$person);
            list($name, $source, $slug) = $this->user->get_person_name($person);
            $echo = '<br/>';
            $echo .= '<div class="alert alert-success alert-dismissible">';
            $echo .= '<button type="button" class="close" data-dismiss="alert" aria-hidden="true" onClick="RemoveExecutive('. $person.')" >&times;</button>';
            $echo .= '<h4><i class="icon fa fa-check"></i> Alert! Beginning Registration</h4>';
            $echo .= '<div class="row">
                        <div class="col-sm-2">';

            $echo .= '<img src="'.$source.'" class="img-circle" height="35px" width="35px"  alt="'.$name.'">';
            $echo .= '</div>
                        <div class="col-sm-10 text-left text-holder">';
            $echo .= '<h4 class="list-group-item-heading">';

            $echo .= ''.$name.'';
            $echo .= '</h4>';
            $echo .= '<p class="list-group-item-text">List Group Item Text</p>';

            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '<input type="hidden" name="record_tracker" id="record_tracker" value="'.$guide['record_tracker'].'" />';
            $echo .= '';
            $echo .= '';

            echo($echo);


        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    public function staff_personal($path, $dob) {
        $record = Hash::unique();
        Session::put('record_tracker',$record);

        try {
            $guide = $this->db->fetch_exact('info_staff','record_tracker',$_SESSION['record_tracker']);
            if(!empty($guide['record_tracker'])){
                $this->db->update('info_staff', array(
                    //'user_id' => $_SESSION['user_id'],
                    'record_tracker' => $_SESSION['record_tracker'],
                    'surname' => Input::get('surname'),
                    'firstname' => Input::get('firstname'),
                    'othername' => Input::get('othernames'),
                    'sex' => Input::get('sex'),
                    'dob' => $dob,
                    'marital_status' => Input::get('marital_status'),
                    'place_of_birth' => Input::get('place_of_birth'),
                    'state_of_birth' => Input::get('state_of_birth'),
                    'state_of_origin' => Input::get('state_of_origin'),
                    'lga' => Input::get('lga'),
                    'nationality' => Input::get('nationality'),
                    'residential_address' => Input::get('residential_address'),
                    'state_of_residence' => Input::get('state_of_residence'),
                    'phone_no' => Input::get('phone'),
                    'email' => Input::get('email'),
                    'level' => Input::get('level'),
                    'appointment' => Input::get('appointment'),
                    'bio_data' => Input::get('citation'),
                    'title' => Input::get('title'),
                    'department' => Input::get('department'),
                    'profile_picture' => $path,
                    'agreement_2_terms' => "Yes",
                    'date_created' => $this->today
                ),'person_id',$guide['person_id']);


            }else{
                $this->db->insert('info_staff', array(
                    //'user_id' => $_SESSION['user_id'],
                    'record_tracker' => $_SESSION['record_tracker'],
                    'surname' => Input::get('surname'),
                    'firstname' => Input::get('firstname'),
                    'othername' => Input::get('othernames'),
                    'sex' => Input::get('sex'),
                    'dob' => $dob,
                    'marital_status' => Input::get('marital_status'),
                    'place_of_birth' => Input::get('place_of_birth'),
                    'state_of_birth' => Input::get('state_of_birth'),
                    'state_of_origin' => Input::get('state_of_origin'),
                    'lga' => Input::get('lga'),
                    'nationality' => Input::get('nationality'),
                    'residential_address' => Input::get('residential_address'),
                    'state_of_residence' => Input::get('state_of_residence'),
                    'phone_no' => Input::get('phone'),
                    'email' => Input::get('email'),
                    'level' => Input::get('level'),
                    'appointment' => Input::get('appointment'),
                    'bio_data' => Input::get('citation'),
                    'title' => Input::get('title'),
                    'department' => Input::get('department'),
                    'profile_picture' => $path,
                    'agreement_2_terms' => "Yes",
                    'date_created' => $this->today
                ));

            }

            cleanUP();

            Session::flash('home', 'Information successfully saved, You may proceed with the registration!');
            Redirect::to(URL . 'links/step/teacher-web');
            exit();
        } catch (Exception $e) {
            //redirect user to specific page saying oops
            return false;
        }
    }

    public function account_setup() {
            //register user
            $salt = Hash::salt(32);
            $hash = Hash::unique();

            try {
                $this->db->insert('users', array(
                    'record_tracker' => $_SESSION['record_tracker'],
                    'email' => Input::get('email'),
                    'phone_number' => Input::get('phone_number'),
                    'password' => Hash::make(Input::get('password'), $salt),
                    'salt' => $salt,
                    'joined' => $this->today,
                    'verified' => 'no',
                    'lastLogin' => $this->today,
                    'record_tracker' => Input::get('record_tracker'),
                    'user_perms_id' => Input::get('owner_is'),

                ));
                list($last_id) = $this->db->last_insert_id();
                if ($last_id) {
                    $_SESSION['user_id'] = $last_id;

                    $guide = $this->db->fetch_exact('info_staff','record_tracker',Session::get('record_tracker'));

                    $this->db->update('info_staff', array(
                        'user_id' => $_SESSION['user_id'],
                    ),'record_tracker',$guide['record_tracker']);


                }

                cleanUP();



                Redirect::to(URL . 'links/step/done');
            } catch (Exception $e) {
                return false;
            }


    }

    public function check_pin(){
        $data = $this->db->fetch_exact('result_pins','code',Input::get('student_pin'));
        $used_reg_no = trim(Input::get('student_id'));
        $time = Input::get('entry_term');

        if($data['card_id']){
            $times_used = (empty($data['times_used']))? 0 : $data['times_used'];
            $times_used = $times_used +1;
            if(empty($data['used_reg_no'])){ //map to a reg no
                $this->db->update('result_pins', array(
                    'times_used' => $times_used,
                    'used_reg_no' => $used_reg_no,
                    'used_season' => $time,
                    'date_last_used' => $this->today,
                ), 'card_id', $data['card_id']);
                Session::put('pin_approved',$data['card_id']);
                Session::put('pin_result',$used_reg_no);
                $result = $this->check_result($used_reg_no,$time);
                return $result;

            }else{
                if($data['used_reg_no'] == $used_reg_no && $time == $data['used_season']){
                    if(($data['times_used'] >= 0) && ($data['times_used'] <= 5) ){
                        $this->db->update('result_pins', array(
                            'times_used' => $times_used,
                            //'used_reg_no' => $used_reg_no,

                            'date_last_used' => $this->today,
                        ), 'card_id', $data['card_id']);
                        Session::put('pin_approved',$data['card_id']);
                        Session::put('pin_result',$used_reg_no);
                        //Redirect::to(URL.'links/result/'.$data['used_season']);

                        $result = $this->check_result($used_reg_no,$time);
                        return $result;

                    }else{
                        Session::flash('error','This PIN cannot be used again. Maximum Viewing Limit Exceeded!');
                    }
                }else{
                    Session::flash('error','This PIN is already associated with a particular Student ID/ Record!');
                }
            }
        }else{
            Session::flash('error','The PIN does not exist or is incorrect');
        }
        //Redirect::to(backToSender());
        return 'stale';




    }

    public function check_result($reg_no = null,$time = null){

        $reg = $this->db->fetch_exact('academic_students','student_reg_no',$reg_no);

        $data = $this->db->get('academic_records',array('student_id','=',$reg['student_id'],'session_id','=',$time))->results();

        if($this->db->count()){
            $result = array();

            foreach($data as $d){
                $class = $this->db->fetch_exact('academic_classes', 'class_id',$d->class_id);
                $subject = $this->db->fetch_exact('academic_subjects', 'subject_id',$d->subject_id);
                $term = $this->db->fetch_exact('academic_terms', 'term_id',$time);
                $session = $this->db->fetch_exact('academic_sessions', 'session_id',$term['session_id']);
                $score = strpos($d->score,',');
                if($score){
                    $catch = explode(',',$d->score);
                    //print_r($catch);
                    //die();

                    $score = '';
                    for($i=0;$i<count($catch)-1;$i++){
                        $ca = $i+1;
                        $score .= 'CA '.$ca.' - '.$catch[$i].', ';

                    }
                    $score .= 'Exam - '.$catch[count($catch)-1];
                }else{
                    $score = $d->score;
                }
                $result[] = array(
                    'parent_class' => $class['parent_class'],
                    'class' => $class['class_name'],
                    'session_name' => $session['session_name'],
                    'term' => $term['term'],
                    'subject_name' => $subject['subject_name'],
                    'score' => $score,
                    'total_score' => $d->total_score,
                    'record_id' => $d->record_id,
                    'school_id' => $d->school_id,
                    'term_id' => $d->term_id,
                    'class_id' => $d->class_id,
                    'student_id' => $d->student_id,
                );
            }
            return array($reg, $result);
        }else{
            Session::flash('error','No record found for this person at this time');
            Redirect::to(backToSender());
            return false;
        }



    }




}
