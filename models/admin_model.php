<?php

class Admin_Model extends Model {
    //private  $_data;

    function __construct() {
        parent::__construct();
    }

    function get_class($id = null){
        if(isset($id)){
            $data = $this->db->fetch_exact('academic_classes', 'class_id',$id);
            return $data;

        }else{
            $data = $this->db->getAll_assoc('academic_classes')->results_assoc();
            $result = array();
            foreach($data as $d){
                $subject = $this->db->get_assoc('academic_adviser', array('class_id','=',$d['class_id']))->results_assoc();
                $names = '';
                foreach($subject as $p){
                    $person = $this->db->fetch_exact('info_staff', 'person_id',$p['adviser']);
                    $names .= $person['surname'].' '.$person['firstname'].' '.$person['othername'].' // '     ;
                }
                $names = chop($names,' // ');
                $result[] = array(
                    'class_name' => $d['class_name'],
                    'name' => $names,

                    'parent_class' => $d['parent_class'],
                    'class_desc' => $d['class_desc'],
                    'requirement' => $d['requirement'],
                    'class_id' => $d['class_id'],
                );




            }
            return $result;


        }


    }

    public function create_class($update = null) {
        try {
            if($update){
                $this->db->update('academic_classes', array(
                    'class_name' => trim(Input::get('class_name')),
                    'parent_class' => Input::get('parent_class'),
                    'class_desc' => Input::get('class_desc'),
                    'requirement' => trim(Input::get('requirement')),
                    'visible' => '1',
                    'date' => $this->today,
                ), 'class_id', $update);
            }else{
                $this->db->insert('academic_classes', array(
                    'class_name' => trim(Input::get('class_name')),
                    'parent_class' => Input::get('parent_class'),
                    'class_desc' => Input::get('class_desc'),
                    'requirement' => trim(Input::get('requirement')),
                    'visible' => '1',
                    'date' => $this->today,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function session_term_start($update = null) {
        try {
            if($update){
                $this->db->update('academic_sessions', array(
                    'session_name' => trim(Input::get('entry_session')),
                    'term' => Input::get('entry_term'),
                    'term_starts' => Input::get('starts'),
                    'term_ends' => trim(Input::get('ends')),
                    'details' => trim(Input::get('details')),
                    'input_by' => trim(Session::get('user_id')),
                    'date' => $this->today,
                ), 'session_id', $update);
            }else{
                $this->db->insert('academic_sessions', array(
                    'session_name' => trim(Input::get('entry_session')),
                    'term' => Input::get('entry_term'),
                    'term_starts' => Input::get('starts'),
                    'term_ends' => trim(Input::get('ends')),
                    'details' => trim(Input::get('details')),
                    'input_by' => trim(Session::get('user_id')),
                    'date' => $this->today,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function get_event($id = null) {
        if($id){

            $data =  $this->db->fetch_exact('academic_calender', 'id',$id);
            $all =  $this->db->getAll_assoc('academic_calender');
            $count = $this->db->count_assoc();

            return array($data,$count);
        }else{
            $data =  $this->db->getAll_assoc('academic_calender')->results_assoc();
            return $data;
        }
    }

    function get_academic_sessions($id = null){
        if(isset($id)){
            $data = $this->db->fetch_exact('academic_sessions', 'session_id',$id);
            return $data;

        }else{
            return $this->db->getAll_assoc('academic_sessions')->results_assoc();

        }


    }

    function get_academic_calender($id = null){
        if(isset($id)){
            $data = $this->db->fetch_exact('academic_sessions', 'session_id',$id);

        }else{
            $data = $this->db->fetch_exact('academic_sessions', 'active',1);

        }
        $main = $this->db->get_assoc('academic_calender',array('session_id','=',$data['session_id']))->results_assoc();
        return array($main, $data);



    }

    public function add_event($update = null) {

        $view = Input::get('show_academic');

        try {
            if($update){
                $this->db->update( 'academic_calender', array(
                    'session_id' => ($view),
                    'description' => (Input::get('description')),
                    'title' => (Input::get('title')),
                    'date' => (Input::get('datepicker')),
                    'time' => (Input::get('timepicker')),
                ), 'id', $update);

            }else{
                $this->db->insert('academic_calender', array(
                    'session_id' => ($view),
                    'title' => trim(Input::get('title')),
                    'description' => trim(Input::get('description')),
                    'date' => trim(Input::get('datepicker')),
                    'time' => trim(Input::get('timepicker')),
                ));
            }

            cleanUP();
            Session::flash('home', 'Information successfully saved!');
            Redirect::to(URL . 'admin/event/view/'.$view);
            exit;
        } catch (Exception $e) {
            return false;

            //redirect user to specific page saying oops
            //;
        }
    }

    function adviser_search($id = null){
        if(!$id){
            if (Input::exists()) {
                $search = $this->user->search_box(Input::get('staff_search'), 'staff');
                $search_count = $this->user->count();

                if($search_count > 0){
                    $result = array();
                    foreach($search as $d){
                        $person = $this->db->get('academic_adviser',array('adviser','=',$d['person_id']) )->results();
                        if($person){
                            foreach($person as $mod){
                                if($d['person_id'] == $mod->adviser){
                                    $date = new DateTime($mod->effective_date);
                                    $dob = $date->format('d M, Y ');//h:i a
                                    $class = $this->db->fetch_exact('academic_classes', 'class_id',$mod->class_id);
                                    $session = $this->db->fetch_exact('academic_sessions', 'session_id',$mod->session_term);
                                    $detail = $class['class_name'].' || '.$session['session_name'].' '.$session['term'].' || '.$dob;

                                    $result[] = array(
                                        'adviser_id' => $mod->adviser_id,
                                        'detail' => $detail,
                                        'name' => $d['surname'].' '.$d['firstname'].' '.$d['othername'],
                                        'person_id' => $d['person_id'],
                                        'phone_no' => $d['phone_no'],
                                    );
                                }
                            }
                        }else{

                            $result[] = array(
                                'detail' => null,
                                'name' => $d['surname'].' '.$d['firstname'].' '.$d['othername'],
                                'person_id' => $d['person_id'],
                                'phone_no' => $d['phone_no'],
                                'adviser_id' => null,

                            );
                        }

                    }
                    return $result;
                }else {
                    Session::flash('error', 'Oops! Nothing was found. Try again');

                    return null;
                }

            }
            else{
                $data = $this->db->get('academic_adviser')->results();
                $result = array();
                foreach($data as $d){

                    $date = new DateTime($d->effective_date);
                    $dob = $date->format('d M, Y ');//h:i a
                    $class = $this->db->fetch_exact('academic_classes', 'class_id',$d->class_id);
                    $mod = $this->db->fetch_exact('info_staff', 'person_id',$d->adviser);
                    $session = $this->db->fetch_exact('academic_sessions', 'session_id',$d->session_term);
                    $detail = $class['class_name'].' || '.$session['session_name'].' '.$session['term'].' || '.$dob;
                    $result[] = array(
                        'detail' => $detail,
                        'name' => $mod['surname'].' '.$mod['firstname'].' '.$mod['othername'],
                        'person_id' => $mod['person_id'],
                        'phone_no' => $mod['phone_no'],
                        'adviser_id' => $d->adviser_id,
                         );

                }
                return $result;
            }

        }else{
            $search = $this->db->fetch_exact('info_staff', 'person_id',$id);
            $person = $this->db->get('academic_adviser',array('adviser','=',$search['person_id']) )->results();
            $name = $search['surname'].' '.$search['firstname'].' '.$search['othername'];
            $detail = null;
            if($person){
                $detail = '';
                foreach($person as $mod){
                    $class = $this->db->fetch_exact('academic_classes', 'class_id',$mod->class_id);
                    $session = $this->db->fetch_exact('academic_sessions', 'session_id',$mod->session_term);
                    $detail .= $class['class_name'].' -> '.$session['session_name'].' '.$session['term'].' <br/>';

                }

            }
            return array($search['person_id'], $name, $detail);
        }

    }

    function add_adviser($delete = null){
       // $data = $this->db->fetch_exact('info_staff', 'person_id',$who);
        try {
            if($delete){
                $this->db->delete('academic_adviser', array('adviser_id','=', $delete));
                Session::flash('home', 'Information successfully Deleted!');
            }else{
                $this->db->insert('academic_adviser', array(
                    'class_id' => trim(Input::get('entry_class')),
                    'adviser' => Input::get('adviser'),
                    'session_term' => Input::get('show_academic'),
                    'effective_date' => trim(Input::get('datepicker')),
                    'description' => trim(Input::get('description')),
                    'input_by' => trim(Session::get('user_id')),
                    'date' => $this->today,
                ));
                Session::flash('home', 'Information successfully saved!');
            }
            cleanUP();

            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    function get_subject($id = null){
        if(isset($id)){
            $data = $this->db->fetch_exact('academic_subjects', 'subject_id',$id);
            return $data;

        }else{
            $data = $this->db->get('academic_subjects')->results();
            $result = array();
            foreach($data as $d){
                $class = $this->db->fetch_exact('academic_classes', 'class_id',$d->subject_for);

                $subject = $this->db->get_assoc('academic_subject_teachers', array('subject_id','=',$d->subject_id))->results_assoc();

                $names = '';
                 foreach($subject as $p){
                    $person = $this->db->fetch_exact('info_staff', 'person_id',$p['teacher']);
                    $names .= $person['surname'].' '.$person['firstname'].' '.$person['othername'].' // '     ;
                 }
                $names = chop($names,' // ');
                $result[] = array(
                    'subject_for' => $class['class_name'],
                    'subject_name' => $d->subject_name,
                    'description' => $d->description,
                    'lab_enabled' => $d->lab_enabled,
                    'prerequisite' => $d->prerequisite,
                    'subject_id' => $d->subject_id,
                    'name' => $names,
                );



            }
            return $result;

        }


    }

    public function create_subject($update = null) {
        try {
            if($update){
                $this->db->update('academic_subjects', array(
                    'subject_name' => trim(Input::get('subject_name')),
                    'subject_alias' => Input::get('subject_alias'),
                    'subject_for' => Input::get('subject_for'),
                    'description' => trim(Input::get('description')),
                    'prerequisite' => trim(Input::get('prerequisite')),
                    'text_books' => trim(Input::get('text_books')),
                    'tools' => trim(Input::get('tools')),
                    'lab_enabled' => trim(Input::get('visible')),
                    'date' => $this->today,
                ), 'subject_id', $update);
            }else{
                $this->db->insert('academic_subjects', array(
                    'subject_name' => trim(Input::get('subject_name')),
                    'subject_alias' => Input::get('subject_alias'),
                    'subject_for' => Input::get('subject_for'),
                    'description' => trim(Input::get('description')),
                    'prerequisite' => trim(Input::get('prerequisite')),
                    'text_books' => trim(Input::get('text_books')),
                    'tools' => trim(Input::get('tools')),
                    'lab_enabled' => trim(Input::get('visible')),
                    'date' => $this->today,
                ));
            }
            cleanUP();
            Session::flash('home', 'Information successfully saved!');

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    function teacher_subject($id = null){
        if(!$id){
            if (Input::exists()) {
                $search = $this->user->search_box(Input::get('staff_search'), 'staff');
                $search_count = $this->user->count();

                if($search_count > 0){
                    $result = array();
                    foreach($search as $d){
                        $person = $this->db->get('academic_subject_teachers',array('teacher','=',$d['person_id']) )->results();
                        if($person){
                            foreach($person as $mod){
                                if($d['person_id'] == $mod->teacher){
                                    $date = new DateTime($mod->effective_date);
                                    $dob = $date->format('d M, Y ');//h:i a
                                    $class = $this->db->fetch_exact('academic_subjects', 'subject_id',$mod->subject_id);
                                    $for = $this->db->fetch_exact('academic_classes', 'class_id',$class['subject_for']);

                                    $session = $this->db->fetch_exact('academic_sessions', 'session_id',$mod->session_term);
                                    $detail = $class['subject_name'].' '.$for['class_name'].' || '.$session['session_name'].' '.$session['term'].' || '.$dob;

                                    $result[] = array(
                                        'teacher_id' => $mod->teacher_id,
                                        'detail' => $detail,
                                        'name' => $d['surname'].' '.$d['firstname'].' '.$d['othername'],
                                        'person_id' => $d['person_id'],
                                        'phone_no' => $d['phone_no'],
                                    );
                                }
                            }
                        }else{

                            $result[] = array(
                                'detail' => null,
                                'name' => $d['surname'].' '.$d['firstname'].' '.$d['othername'],
                                'person_id' => $d['person_id'],
                                'phone_no' => $d['phone_no'],
                                'teacher_id' => null,

                            );
                        }

                    }
                    return $result;
                }else {
                    Session::flash('error', 'Oops! Nothing was found. Try again');

                    return null;
                }

            }
            else{
                $data = $this->db->get('academic_subject_teachers')->results();
                $result = array();
                foreach($data as $d){

                    $date = new DateTime($d->effective_date);
                    $dob = $date->format('d M, Y ');//h:i a
                    $class = $this->db->fetch_exact('academic_subjects', 'subject_id',$d->subject_id);
                    $for = $this->db->fetch_exact('academic_classes', 'class_id',$class['subject_for']);

                    $mod = $this->db->fetch_exact('info_staff', 'person_id',$d->teacher);
                    $session = $this->db->fetch_exact('academic_sessions', 'session_id',$d->session_term);
                    $detail = $class['subject_name'].' '.$for['class_name'].' || '.$session['session_name'].' '.$session['term'].' || '.$dob;
                    $result[] = array(
                        'detail' => $detail,
                        'name' => $mod['surname'].' '.$mod['firstname'].' '.$mod['othername'],
                        'person_id' => $mod['person_id'],
                        'phone_no' => $mod['phone_no'],
                        'teacher_id' => $d->teacher_id,
                    );

                }
                return $result;
            }

        }else{
            $search = $this->db->fetch_exact('info_staff', 'person_id',$id);
            $person = $this->db->get('academic_subject_teachers',array('teacher','=',$search['person_id']) )->results();
            $name = $search['surname'].' '.$search['firstname'].' '.$search['othername'];
            $detail = null;
            if($person){
                $detail = '';
                foreach($person as $mod){
                    $class = $this->db->fetch_exact('academic_subjects', 'subject_id',$mod->subject_id);
                    $for = $this->db->fetch_exact('academic_classes', 'class_id',$class['subject_for']);

                    $session = $this->db->fetch_exact('academic_sessions', 'session_id',$mod->session_term);
                    $detail .= $class['subject_name'].' -> '.$for['class_name'].' '.$session['session_name'].' '.$session['term'].' <br/>';

                }

            }
            return array($search['person_id'], $name, $detail);
        }

    }

    function add_teacher($delete = null){
        // $data = $this->db->fetch_exact('info_staff', 'person_id',$who);
        try {
            if($delete){
                $this->db->delete('academic_subject_teachers', array('teacher_id','=', $delete));
                Session::flash('home', 'Information successfully Deleted!');
            }else{
                $this->db->insert('academic_subject_teachers', array(
                    'subject_id' => trim(Input::get('entry_class')),
                    'teacher' => Input::get('teacher'),
                    'session_term' => Input::get('show_academic'),
                    'effective_date' => trim(Input::get('datepicker')),
                    'description' => trim(Input::get('description')),
                    'input_by' => trim(Session::get('user_id')),
                    'date' => $this->today,
                ));
                Session::flash('home', 'Information successfully saved!');
            }
            cleanUP();

            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    function view_something($action = null, $id = null){
        switch($action){
            case 'advisers':
                $person = $this->db->get('academic_adviser',array('class_id','=',$id) )->results();
                if($person){
                    foreach($person as $mod){
                        $date = new DateTime($mod->effective_date);
                        $dob = $date->format('d M, Y ');//h:i a
                        $class = $this->db->fetch_exact('academic_classes', 'class_id',$mod->class_id);
                        $d = $this->db->fetch_exact('info_staff', 'person_id',$mod->adviser);
                        $session = $this->db->fetch_exact('academic_sessions', 'session_id',$mod->session_term);

                        $result[] = array(
                            'adviser_id' => $mod->adviser_id,
                            'class_name' => $class['class_name'],
                            'session_name' => $session['session_name'],
                            'term' => $session['term'],
                            'date' => $dob,
                            'name' => $d['surname'].' '.$d['firstname'].' '.$d['othername'],
                            'person_id' => $d['person_id'],
                            'phone_no' => $d['phone_no'],
                        );
                    }
                }

                break;
            case 'teachers':
                $person = $this->db->get('academic_subject_teachers',array('subject_id','=',$id) )->results();
                if($person){
                    foreach($person as $mod){
                        $date = new DateTime($mod->effective_date);
                        $dob = $date->format('d M, Y ');//h:i a
                        $session = $this->db->fetch_exact('academic_sessions', 'session_id',$mod->session_term);
                        $subject = $this->db->fetch_exact('academic_subjects', 'subject_id',$mod->subject_id);

                        $class = $this->db->fetch_exact('academic_classes', 'class_id',$subject['subject_for']);
                        $d = $this->db->fetch_exact('info_staff', 'person_id',$mod->teacher);

                        $result[] = array(
                            'subject_for' => $class['class_name'],
                            'subject_name' => $subject['subject_name'],
                            'description' => $mod->description,
                            'teacher_id' => $mod->teacher_id,
                            'lab_enabled' => $subject['lab_enabled'],
                            'prerequisite' => $subject['prerequisite'],
                            'subject_id' => $subject['subject_id'],
                            'session_name' => $session['session_name'],
                            'term' => $session['term'],
                            'date' => $dob,
                            'name' => $d['surname'].' '.$d['firstname'].' '.$d['othername'],
                            'person_id' => $d['person_id'],
                            'phone_no' => $d['phone_no'],
                        );
                    }
                }
                break;
        }
        return $result;

    }








}
