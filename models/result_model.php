<?php

class Result_Model extends Model {

    function __construct() {
        parent::__construct();

    }

    public function find_school($name = null) {
        $data =  $this->db->get('schools')->first(); //,array('slug','=',$name)
        if($data){
            return $data;
        }else{
            return false;
        }

    }

    public function started_sessions($sch_id = null) {
        $data =  $this->db->get('academic_sessions')->results(); //,array('school_id','=',$sch_id)
        $ses = array();
        $echo = '<option value="0">Select Session</option>';
        foreach($data as $d){
            $ses[] = ($d->session_name);
            $echo .= '<option  value="'.$d->session_id.'"';
            $echo .= '>'.$d->session_name.'</option>';

        }
        return $echo;
    }

    public function started_classes($sch_id = null) {
        $data =  $this->db->get('academic_classes')->results(); //,array('school_id','=',$sch_id)

        $echo = '<option value="0">Select Class</option>';
        foreach($data as $d){
            $echo .= '<option  value="'.$d->class_id.'"';
            $echo .= '>'.$d->class_name.'</option>';

        }
        return $echo;
    }

    public function started_terms($sch_id = null) {
        $data =  $this->db->get('academic_terms')->results(); //,array('school_id','=',$sch_id)
        $ses = array();
        $echo = '<option value="0">Select Session/Term</option>';
        foreach($data as $d){
            $ses[] = ($d->session_id);
            $echo .= '<option  value="'.$d->session_id.'"';
            $echo .= '>'.$d->session_id.' '.$d->term.'</option>';

        }
        return $echo;
    }

    function retrieve($action){
        $echo = '';
        switch ($action) {
            case "term":
                $data =  $this->db->get('academic_terms',array('session_id','=',Input::get('entry_session')))->results();
                $echo = '<option value="0">Select Term</option>';
                foreach($data as $d){
                    $echo .= '<option  value="'.$d->term_id.'"';
                    $echo .= '>'.$d->term.'</option>';

                }

                break;
            case "class":

                $data =  $this->db->get('result_students',array('current_class','=',Input::get('find_class'),'current_session','=',Input::get('find_session')))->results();
                $echo = '<option value="0">Select Name</option>';
                foreach($data as $d){
                    $echo .= '<option  value="'.$d->student_id.'"';
                    $echo .= '>'.$d->surname.', '.$d->othername.'</option>';

                }

                break;

            case "name":
                $data = $this->db->fetch_exact('result_students','student_id',Input::get('name_id'));
                $echo = $data['reg_no'];
                break;

        }
        echo($echo);
    }
    public function check_pin(){
        $data = $this->db->fetch_exact('result_pins','code',Input::get('student_pin'));
        $used_reg_no = trim(Input::get('student_id'));
        $time = Input::get('entry_term');
        $session = Input::get('entry_session');

        if($data['card_id']){
            $times_used = (empty($data['times_used']))? 0 : $data['times_used'];
            $times_used = $times_used +1;
            if(empty($data['used_reg_no'])){ //map to a reg no
                $this->db->update('result_pins', array(
                    'times_used' => $times_used,
                    'used_reg_no' => $used_reg_no,
                    'used_season' => $session,
                    'date_last_used' => $this->today,
                ), 'card_id', $data['card_id']);
                Session::put('pin_approved',$data['card_id']);
                Session::put('pin_result',$used_reg_no);
                $result = $this->check_result($used_reg_no,$time);
                return $result;

            }else{
                if($data['used_reg_no'] == $used_reg_no && $session == $data['used_season']){
                    if(($data['times_used'] >= 0) && ($data['times_used'] <= 10) ){
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
                        Session::flash('error','This PIN cannot be used again. Maximum Viewing Limit has been reached!');
                    }
                }else{
                    Session::flash('error','This PIN can only be used for all terms in a particular session and for a single Student ID/ Record!');
                }
            }
        }else{
            Session::flash('error','The PIN does not exist or is incorrect');
        }
        //Redirect::to(backToSender());
        return 'stale';




    }

	public function fake_check_pin(){
        $data = $this->db->fetch_exact('result_pins','code',Input::get('student_pin'));
        $used_reg_no = trim(Input::get('student_id'));
        $time = Input::get('entry_term');
		$session = Input::get('entry_session');
		
		$result = $this->check_result($used_reg_no,$time);
		return $result;


    }

    function progress_bar($v){
        if($v >= 70){
            $bg = 'success';
        }elseif($v >= 60){
            $bg = 'primary';
        }elseif($v >= 50){
            $bg = 'info';
        }elseif($v >= 40){
            $bg = 'warning';
        }elseif($v < 40){
            $bg = 'danger';
        }

        return $bg;

    }


    public function check_result($reg_no = null,$time = null){

        $reg = $this->db->fetch_exact('result_students','reg_no',$reg_no);

        $data = $this->db->get('results_per_subject_per_student',array('student_id','=',$reg['student_id'],'term_id','=',$time),'total')->results();

        $folder = $this->db->fetch_exact_two('result_per_term_per_student','term_id',$time,'student_id',$reg['student_id']);
        //set the session, term and class
        $class_ave = $this->db->fetch_exact_two('result_per_class_per_term','class_id',$reg['current_class'],'term_id',$time);

        if($folder){
            $result = array();

            $echo = '';
            $echo .= '<tr>';
            $echo .= '<th>S/N</th>';
            $echo .= '<th>Subject</th>';
            $echo .= '<th>CA</th>';
            $echo .= '<th>Exam</th>';
            $echo .= '<th>Total</th>';
            $echo .= '<th>GP</th>';
            $echo .= '<th>Class Lowest</th>';
            $echo .= '<th>Class Highest</th>';
            $echo .= '<th>Class Average</th>';
            $echo .= '<th>Position</th>';
            $echo .= '<th>Remark</th>';
            $echo .= '<th>Progress</th>';
            $echo .= '</tr>';

            $echo .= '<tr>';
            $x = 1;
            foreach($data as $d){
                $class = $this->db->fetch_exact('academic_classes', 'class_id',$d->class_id);
                Session::put('result_class',$class['class_name']);
                $subject = $this->db->fetch_exact('academic_subjects', 'subject_id',$d->subject_id);
                $term = $this->db->fetch_exact('academic_terms', 'term_id',$time);
                Session::put('result_term',$term['term']);
                $session = $this->db->fetch_exact('academic_sessions', 'session_id',$term['session_id']);
                Session::put('result_session',$session['session_name']);

                $low_high_ave = $this->db->get('results_per_subject_highest_lowest', array('class_id','=',$d->class_id,'subject_id','=',$d->subject_id,'term_id','=',$d->term_id));
                $low_high_ave = $this->db->first();
                if(empty($d->total)){continue; }//exclude empty results

                //build table for result
                $echo .= '<td>'.$x.'</td>';
                $x++;

                $echo .= '<td>'.$subject['subject_name'].'</td>';
                $echo .= '<td>'.$d->ca.'</td>';
                $echo .= '<td>'.$d->exam.'</td>';
                $echo .= '<td>'.$d->total.'</td>';
                $echo .= '<td>'.$d->grade.'</td>';
                $echo .= '<td>'.$low_high_ave->lowest.'</td>';
                $echo .= '<td>'.$low_high_ave->highest.'</td>';
                $echo .= '<td>'.$low_high_ave->average.'</td>';
                $echo .= '<td>'.$d->position.'</td>';
                $echo .= '<td>'.$d->remark.'</td>';
                $bg = $this->progress_bar($d->total);
                $echo .= '<td><div class="progress progress-xs"><div class="progress-bar progress-bar-'.$bg.'" style="width:'.$d->total.'%"></div></div></td>';

                $echo .= '</tr>';

                $result[] = array(
                    'parent_class' => $class['parent_class'],
                    'class' => $class['class_name'],
                    'session_name' => $session['session_name'],
                    'term' => $term['term'],
                    'subject_name' => $subject['subject_name'],
                    'score' => $d->total,
                    'total_score' => $d->total,
                    'record_id' => $d->record_id,
                    'term_id' => $d->term_id,
                    'class_id' => $d->class_id,
                    'student_id' => $d->student_id,
                );
            }
            $echo .= '</table><br/>';
            $echo .= '<tr>';
            $echo .= '<table class="table table-bordered">';
            $echo .= '<tr>';
            $echo .= '<th class="text-right">Total</th>';
            $echo .= '<th class="text-left">'.$folder['total'].'</th>';
            $echo .= '<th class="text-right">Student Average</th>';
            $echo .= '<th class="text-left">'.$folder['average'].'</th>';
            $echo .= '<th class="text-right">Class Average</th>';
            $echo .= '<th class="text-left">'.$class_ave['class_average'].'</th>';
            $echo .= '<th class="text-right">Position</th>';
            $echo .= '<th class="text-left">'.$folder['position'].' out of   '.$class_ave['class_total_students'].'</th>';
            $echo .= '</tr>';
            Session::put('result_summary_outline',$folder['comment']);

            $reg = array(
                'student_name' => $reg['surname'].' '.$reg['othername'],
                'student_reg_no' => $reg['reg_no'],
                'student_id' => $reg['student_id'],
            );

            return array($reg, $echo,$folder);
        }else{
            Session::flash('error','No record found for this person at this time');
            Redirect::to(backToSender());
            return false;
        }



    }


}
