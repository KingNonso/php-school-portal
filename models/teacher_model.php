<?php

    class Teacher_Model extends Model {
        //private  $_data;

        function __construct() {
            parent::__construct();
        }

        function get_summary(){
            $students = $this->db->get('result_students');
            $students = $this->db->count();

            $subject = $this->db->get('academic_subjects');
            $subject = $this->db->count();

            $classes = $this->db->get('academic_classes');
            $classes = $this->db->count();

            $result = $this->db->get('acad_result_folder');
            $result = $this->db->count();

            return array($students,$subject,$classes,$result);
        }

        public function get_school($id = null) {
            if($id){

                $data =  $this->db->fetch_exact('schools', 'school_id',$id);
                $all =  $this->db->getAll_assoc('schools');
                $count = $this->db->count_assoc();

                return array($data,$count);
            }else{
                $data =  $this->db->getAll_assoc('schools')->results_assoc();
                return $data;
            }
        }


        function get_class($id = null){
            if(isset($id)){
                $data = $this->db->fetch_exact('academic_classes', 'class_id',$id);
                return $data;

            }else{
                $data = $this->db->get('academic_classes',null,'class_name','ASC')->results();
                $result = array();
                foreach($data as $d){

                    $result[] = array(
                        'class_name' => $d->class_name,
                        //'name' => $names,
                        'super_class' => $d->super_class,
                        'parent_class' => $d->parent_class,
                        'class_id' => $d->class_id,
                    );

                }

                return $result;


            }


        }

        function active_tabs($id = null){
            if($id){
                $subjects = $this->db->get('academic_subjects',array('subject_for','=',Session::get('academic_class_id')))->results();

            }else{
                $subjects = $this->db->get('academic_subjects',array('subject_for','=',Session::get('academic_class_id')))->results();
            }
            return $subjects;
        }



        function get_subject($id = null,$just_name = false){
            if(isset($id)){
                $data = $this->db->fetch_exact('academic_subjects', 'subject_id',$id);
                if($just_name){
                    return $data['subject_name'];
                }
                return $data;

            }else{
                $subjects = $this->db->get('academic_subjects',null,'subject_for','ASC')->results();

                $result = array();
                $hold_names = array();
                foreach($subjects as $s){
                    if(in_array($s->subject_name,$hold_names)){
                        continue;
                    }else{
                        if($s->subject_for == 'ALL' || $s->subject_for == 'JSS' || $s->subject_for == 'SS'){
                            $hold_names[] = $s->subject_name;
                            $for = $s->subject_for;

                        }else{
                            //get all classes for this subject
                            $for = '';
                            $hold_names[] = $s->subject_name;
                            $custom = $this->db->get('academic_subjects',array('subject_name','=',$s->subject_name),'class_id','ASC')->results();
                            foreach($custom as $c){
                                $class = $this->db->fetch_exact('academic_classes', 'class_id',$c->class_id);
                                if(isset($class['class_name'])){
                                    $for .= $class['class_name'].', '; // array offset
                                }

                            }
                            $for = chop($for,', ');


                        }
                    }


                    $result[] = array(
                        'subject_for' => $for,
                        'subject_name' => $s->subject_name,
                        'description' => $s->description,
                        'lab_enabled' => $s->lab_enabled,
                        'prerequisite' => $s->prerequisite,
                        'subject_id' => $s->subject_id,
                        //'name' => $names,
                    );

                }
                return $result;

            }


        }

        function get_subject_per_class($id = null){
            if($id){
                $subjects = $this->db->get('academic_subjects',array('subject_id','=',$id),'subject_for','ASC')->results();
            }else{
                $subjects = $this->db->get('academic_subjects',null,'subject_for','ASC')->results();

            }

            $result = array();
            foreach($subjects as $s){
                $class = $this->db->fetch_exact('academic_classes', 'class_id',$s->class_id);
                $for = '';
                if(isset($class['class_name'])){
                    $for = $class['class_name']; // array offset
                }

                $result[] = array(
                    'subject_for' => $for,
                    'subject_name' => $s->subject_name,
                    'description' => $s->description,
                    'lab_enabled' => $s->lab_enabled,
                    'prerequisite' => $s->prerequisite,
                    'subject_id' => $s->subject_id,
                    //'name' => $names,
                );

            }
            return $result;


        }

        function retrieveClassSubjects($id){
            $data = $this->db->get('academic_subjects',array('class_id','=',$id),'subject_for','ASC')->results();
            $echo = '<option value="0">Select Subject</option>';
            foreach($data as $d){
                $echo .= '<option  value="'.$d->subject_id.'"';
                $echo .= '>'.$d->subject_name.' ('.$d->subject_for.')</option>';

            }
            echo($echo);


        }


        function student_search($whr, $id = null){
            $id = '%'.$id.'%';
            $data = $this->db->get_assoc('academic_students',array($whr,'LIKE',$id))->results_assoc();
            $echo ='<ul class="list-group">';
            foreach($data as $d){
                $echo .= '<li  onclick="set_item(\''.$d['student_name'].'\',\''.$d['student_reg_no'].'\',\''.$d['student_id'].'\')" class="list-group-item" style="cursor:pointer;">';
                $echo .= ' '.$d['student_reg_no'].' :: '.$d['student_name'];
                $echo .= '</li>';

            }
            $echo .='</ul>';
            echo($echo);

        }

        function search_for_person($str){
            $search = $this->user->search_box($str, 'members');
            $search_count = $this->user->count();

            if($search_count != 0){

                foreach($search as $suggestion){
                    $name = $suggestion['firstname']. ' '.$suggestion['surname'].' '.$suggestion['othername'];
                    if(!empty($suggestion['profile_picture'])){
                        $source = URL.'public/uploads/profile-pictures/'. $suggestion['profile_picture'];
                    }else{
                        $source = URL.'public/custom/img/avatar.png';
                    }

                    //$echo = '<img class="img-circle" src="'.$source.'" width="30" height="30">';
                    //$echo .= '<a href="'.URL.'profile/member/'.($suggestion['slug']).'">  '.$name.'</a>';
                    // $chapter = $this->user->get_person_chapter($suggestion['chapter_id']);
                    //$echo .= '<p>Chapter: '. $chapter['chapter_name'];
                    $echo = '';
                    $echo .= '<div class="row">
                        <div class="col-sm-2">';

                    $echo .= '<img src="'.$source.'" class="img-circle" height="51px" width="51px"  alt="'.$name.'">';
                    $echo .= '</div>
                        <div class="col-sm-10 text-left text-holder">';

                    $echo .= '<a href="'.URL.'profile/member/'.$suggestion['slug'].'" class="poster-name text-left">'.$name.'</a>';

                    $echo .= '<input type="hidden" name="record_tracker" id="record_tracker" value="'.$suggestion['record_tracker'].'" />';
                    $echo .= '<input type="hidden" name="user_id" id="user_id" value="'.$suggestion['user_id'].'" />';

                    $echo .= '</div>';
                    $echo .= '</div>';
                    $echo .= '<br/>';
                    $echo .= '';




                    echo($echo);
                }


            }else {
                echo "No suggestion";
            }

        }

        function get_sch_sessions($id){
            //SELECT ``, ``, ``, `input_by`, `date` FROM `` WHERE 1
            $data = $this->db->fetch_exact('academic_sessions', 'session_id',$id);
            Session::put('academic_session_id',$data['session_id']);
            Session::put('academic_session_name',$data['session_name']);
            //Session::put('school_id',Session::get('school_id'));

            return $data;
        }

        function set_active(){
            $data = $this->db->fetch_exact('academic_sessions', 'session_id',Input::get('entry_session'));
            Session::put('academic_session_id',$data['session_id']);
            Session::put('academic_session_name',$data['session_name']);
            $data = $this->db->fetch_exact('academic_terms', 'term_id',Input::get('entry_term'));
            Session::put('academic_term_id',$data['term_id']);
            Session::put('academic_term_name',$data['term']);

            Session::put('home','Active Session - '.Session::get('academic_session_name').'<br/> Active Term - '.Session::get('academic_term_name'));
            return true;
        }

        function printer($with = false){
            if($with){

                $data = $this->db->get('result_per_term_per_student', array('term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')),'total')->results();
                Session::put('total_students',$this->db->count());
                // gets the total subjects & subject score per term

                $echo = '';
                $x = 1;
                $subject = $this->get_subject_for_class(Session::get('academic_class_id'));
                $subj = count($subject);
                Session::put('total_subjects',$subj);

                $echo .= '<thead>';
                $echo .= ' <tr>';
                $echo .= '<th rowspan="2">S/N</th>';
                $echo .= '<th rowspan="2" width="80" align="center">Name</th>';
                $echo .= '<th rowspan="2" width="30" align="center">ID</th>';
                foreach($subject as $s){
                    $echo .= '<th colspan="3" class="text-center">'.$s['subject_name'].'</th>';

                }
                $echo .= '<th rowspan="2">Total</th>';
                $echo .= '<th rowspan="2">Ave</th>';
                $echo .= '<th rowspan="2">Pos</th>';
                $echo .= '</tr>';


                $echo .= '<tr>';

                for($j=1; $j<= $subj; $j++){
                    $echo .= '<td>40%</td><td>60%</td><td>100%</td>';
                }
                $echo .= '</tr>';
                $echo .= '</thead>';

                $header = $echo;

                foreach($data as $d){
                    $person = $this->db->fetch_exact('result_students', 'student_id',$d->student_id);

                    $echo .= ' <tr nobr="true">';
                    $echo .= '<td>'.$x.'</td>';
                    $echo .= '<td width="80">'.$person['surname'].' '.$person['othername'].'</td>';
                    $echo .= '<td width="30">'.$person['reg_no'].'</td>';

                    foreach($subject as $s){ // get according to the subjects
    
                        $record = $this->db->get('results_per_subject_per_student',array('student_id','=',$d->student_id,'term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id'), 'subject_id', '=', $s['subject_id']))->results();
    
                        if($record){
                            foreach($record as $r){
                                if($r){ //&& in_array($r->subject_id, $subject_ids)
                                    $echo .= '<td>'.$r->ca.'</td>';
                                    $echo .= '<td>'.$r->exam.'</td>';
                                    $echo .= '<td>'.$r->total.'</td>';
                                }else{
                                    $echo .= '<td>-</td>';
                                }
                            }
                        }else{
                                $echo .= '<td>-</td>';
                                $echo .= '<td>-</td>';
                                $echo .= '<td>-</td>';
    
                        }
                    }
    
                    $echo .= '<td>'.$d->total.'</td>';
                    $echo .= '<td>'.$d->average.'</td>';
                    $echo .= '<td>'.$d->position.'</td>';

                    $echo .= '</tr>';
                    $x++;

                }

            }else{
                $data = $this->db->get('result_per_term_per_student', array('term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')))->results();
                Session::put('total_students',$this->db->count());

                $echo = '';
                $x = 1;
                $subject = $this->get_subject_for_class(Session::get('academic_class_id'));
                $subj = count($subject);
                Session::put('total_subjects',$subj);

                $echo .= '<thead>';
                $echo .= ' <tr>';
                $echo .= '<th rowspan="2">S/N</th>';
                $echo .= '<th rowspan="2" width="80" align="center">Name</th>';
                $echo .= '<th rowspan="2" width="30" align="center">ID</th>';
                foreach($subject as $s){
                    $echo .= '<th colspan="3" class="text-center">'.$s['subject_name'].'</th>';
                    //$echo .= '<th class="text-center">'.$s['subject_alias'].'</th>';
                }
                $echo .= '<th rowspan="2">Total</th>';
                $echo .= '<th rowspan="2">Ave</th>';
                $echo .= '<th rowspan="2">Pos</th>';
                $echo .= '</tr>';

                /*

                 */
                $echo .= '<tr>';

                for($j=1; $j<= $subj; $j++){
                    $echo .= '<th>40%</th><th>60%</th><th>100%</th>';
                    //$echo .= '<th></th>';
                }
                $echo .= '</tr>';
                $echo .= '</thead>';
                $header = $echo;

                foreach($data as $d){
                    $person = $this->db->fetch_exact('result_students', 'student_id',$d->student_id);
                    $record = $this->db->get('results_per_subject_per_student',array('student_id','=',$d->student_id,'term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')))->results();

                    $echo .= ' <tr nobr="true">';
                    $echo .= '<td>'.$x.'</td>';
                    $echo .= '<td width="80" align="center">'.$person['surname'].' '.$person['othername'].'</td>';
                    $echo .= '<td width="30" align="center">'.$person['reg_no'].'</td>';

                    foreach($record as $r){
                        $echo .= '<td>'.'</td>';
                        $echo .= '<td>'.'</td>';
                        $echo .= '<td>'.'</td>';
                    }
                    $echo .= '<td>'.'</td>';
                    $echo .= '<td>'.'</td>';
                    $echo .= '<td>'.'</td>';
                    $echo .= '</tr>';
                    $x++;


                }

            }

            return $echo;
        }

        function annual($with = false){
            if($with){
                $class = Session::get('academic_class_id');
                $data = $this->db->get('result_per_annual_per_student', array('session_id','=',Session::get('academic_session_id'),'class_id','=',Session::get('academic_class_id')),'total')->results();
                Session::put('total_students',$this->db->count());

                $echo = '';
                $x = 1;
                $subject = $this->get_subject_for_class($class);
                $sub_array = array();
                foreach($subject as $s){
                    $sub_array[] = $s['subject_id'];
                }

                $subj = count($subject);
                Session::put('total_subjects',$subj);

                $echo .= '<thead>';
                $echo .= ' <tr>';
                $echo .= '<th rowspan="2">S/N</th>';
                $echo .= '<th rowspan="2" width="80" align="center">Name</th>';
                $echo .= '<th rowspan="2" width="30" align="center">ID</th>';
                foreach($subject as $s){
                    //$echo .= '<th colspan="9" class="text-center">'.$s['subject_name'].'</th>';
                    $echo .= '<th colspan="3" class="text-center">'.$s['subject_name'].'</th>';

                }
                $echo .= '<th rowspan="2">Total</th>';
                $echo .= '<th rowspan="2">Ave</th>';
                $echo .= '<th rowspan="2">Pos</th>';
                $echo .= '</tr>';


                $echo .= '<tr class="text-center">';

                for($j=1; $j<= $subj; $j++){
                    //$echo .= '<td colspan="3">1st Term</td><td colspan="3">2nd Term</td><td colspan="3">3rd Term</td>';
                    $echo .= '<td>1st Term</td><td>2nd Term</td><td>3rd Term</td>';
                    //$echo .= '<td></td>';
                }
                $echo .= '</tr>';
                //$echo .= '<tr>';

                /*
                for($j=1; $j<= $subj; $j++){
                    for($q=1; $q <= 3; $q++){
                        $echo .= '<td>40%</td><td>60%</td><td>100%</td>';
                    }
                }
                */
                //$echo .= '</tr>';
                $echo .= '</thead>';


                //get all the results for a class. ordered by position from cumulative per subject

                foreach($data as $d){
                    $person = $this->db->fetch_exact('result_students', 'student_id',$d->student_id);
                    $echo .= ' <tr nobr="true">';
                    $echo .= '<td>'.$x.'</td>';
                    $echo .= '<td width="80">'.$person['surname'].' '.$person['othername'].'</td>';
                    $echo .= '<td width="30">'.$person['reg_no'].'</td>';

                    $term = $this->db->get('academic_terms', array('session_id','=',$d->session_id),'term','ASC')->results();
                    foreach($subject as $s){
                        foreach($term as $t){
                            $record = $this->db->get('results_per_subject_per_student',array('student_id','=',$person['student_id'],'term_id','=',$t->term_id,'subject_id','=',$s['subject_id']),'total')->results();
                            if($record){
                                foreach($record as $r){
                                    //$echo .= '<td>'.$r->ca.'</td>';
                                    //$echo .= '<td>'.$r->exam.'</td>';
                                    $echo .= '<td>'.$r->total.'</td>';
                                }
                            }else{
                                $echo .= '<td>-</td>';
                            }

                        }
                    }

                    $echo .= '<td>'.$d->total.'</td>';
                    $echo .= '<td>'.$d->average.'</td>';
                    $echo .= '<td>'.$d->position.'</td>';

                    $echo .= '</tr>';
                    $x++;

                }

            }else{
                $data = $this->db->get('acad_result_folder', array('term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')))->results();
                Session::put('total_students',$this->db->count());

                $echo = '';
                $x = 1;
                $subject = $this->get_subject_for_class(Session::get('academic_class_id'));
                $subj = count($subject);
                Session::put('total_subjects',$subj);

                $echo .= '<thead>';
                $echo .= ' <tr>';
                $echo .= '<th rowspan="2">S/N</th>';
                $echo .= '<th rowspan="2" width="80" align="center">Name</th>';
                $echo .= '<th rowspan="2" width="30" align="center">ID</th>';
                foreach($subject as $s){
                    $echo .= '<th colspan="3" class="text-center">'.$s['subject_name'].'</th>';
                    //$echo .= '<th class="text-center">'.$s['subject_alias'].'</th>';
                }
                $echo .= '<th rowspan="2">Total</th>';
                $echo .= '<th rowspan="2">Ave</th>';
                $echo .= '<th rowspan="2">Pos</th>';
                $echo .= '</tr>';

                /*

                 */
                $echo .= '<tr>';

                for($j=1; $j<= $subj; $j++){
                    $echo .= '<th>40%</th><th>60%</th><th>100%</th>';
                    //$echo .= '<th></th>';
                }
                $echo .= '</tr>';
                $echo .= '</thead>';
                $header = $echo;

                foreach($data as $d){
                    $person = $this->db->fetch_exact('academic_students', 'student_id',$d->student_id);
                    $record = $this->db->get('academic_records',array('student_id','=',$d->student_id))->results();

                    $echo .= ' <tr>';
                    $echo .= '<td>'.$x.'</td>';
                    $echo .= '<td width="80" align="center">'.$person['student_name'].'</td>';
                    $echo .= '<td width="30" align="center">'.$person['student_reg_no'].'</td>';

                    $i = 1;
                    foreach($record as $r){
                        //$slip .= $subject['subject_name'].': '.$r->score.', ';
                        $echo .= '<td>'.'</td>';
                        $echo .= '<td>'.'</td>';
                        $echo .= '<td>'.'</td>';
                        $i++;
                    }
                    for($i; $i <= $subj; $i++){
                        $echo .= '<td>'.'</td>';
                    }
                    $echo .= '<td>'.'</td>';
                    $echo .= '<td>'.'</td>';
                    $echo .= '<td>'.'</td>';
                    $echo .= '</tr>';
                    $x++;


                }

            }

            return $echo;
        }


        function excel_doc($with = false){
            if($with){

                /** Error reporting */
                error_reporting(E_ALL);
                ini_set('display_errors', TRUE);
                ini_set('display_startup_errors', TRUE);
                date_default_timezone_set('Africa/Lagos');

                if (PHP_SAPI == 'cli')
                    die('This example should only be run from a Web Browser');

                /** Include PHPExcel */
                require_once 'public/PHPExcel/Classes/PHPExcel.php';


// Create new PHPExcel object
                $objPHPExcel = new PHPExcel();

// Set document properties
                $objPHPExcel->getProperties()->setCreator("Move Up Limited")
                    ->setLastModifiedBy("Move Up Limited")
                    ->setTitle("Academic Report Sheet")
                    ->setSubject("Academic Report Sheet")
                    ->setDescription("Academic Report Sheet")
                    ->setKeywords("Academic Report Sheet")
                    ->setCategory("Test result file");


                $data = $this->db->get('acad_result_folder', array('term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')))->results();
                Session::put('total_students',$this->db->count());
                $subject = $this->get_subject_for_class(Session::get('academic_class_id'));
                $subj = count($subject);
                Session::put('total_subjects',$subj);

// Rename worksheet
                $objPHPExcel->getActiveSheet()->setTitle('Acad Report Sheet');


                $objPHPExcel->getActiveSheet()->setCellValue('A1', 'S/N')
                    ->setCellValue('B1', 'Name')
                    ->setCellValue('C1', 'ID');
                $header = array('D1','E1','F1','G1','H1','I1','J1','K1','L1','M1','N1','O1','P1');
                $i = count($header);
                $y=0;

                foreach($subject as $s){
                    $objRichText = new PHPExcel_RichText();
                    $objRichText->createText(html_entity_decode($s['subject_name']));


                    $objPHPExcel->getActiveSheet()->setCellValue($header[$y], $objRichText);
                    $y++;

                }
                $objPHPExcel->getActiveSheet()->setCellValue($header[$y], 'Total');
                $objPHPExcel->getActiveSheet()->setCellValue($header[$y+1], 'Ave');
                $objPHPExcel->getActiveSheet()->setCellValue($header[$y+2], 'Pos');

                $letter = array('D','E','F','G','H','I','J','K','L','M','N','O','P');

                for ($a = 0; $a <=$y-1 ; $a++) {
                    $objPHPExcel->getActiveSheet()->setCellValue($letter[$a].'2', ' 40|60|100');
                }
                $x = 3;
                $y = 1;
                foreach($data as $d){
                    $person = $this->db->fetch_exact('academic_students', 'student_id',$d->student_id);
                    $record = $this->db->get('academic_records',array('folder_id','=',$d->id))->results();
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$x, $y);
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$x, $person['student_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$x, $person['student_reg_no']);
                    $b = 0;
                    foreach($record as $r){
                        $letter = array('D','E','F','G','H','I','J','K','L','M','N','O','P');

                        $score = strpos($r->score,',');
                        $echo = '';
                        if($score){
                            $catch = explode(',',$r->score);
                            for($i=0; $i<count($catch); $i++){
                                $echo .= ''.$catch[$i].'|';
                            }
                            $echo = chop($echo,'|');
                            $objPHPExcel->getActiveSheet()->setCellValue($letter[$b].$x, $echo);
                            $b++;

                        }else{
                            $objPHPExcel->getActiveSheet()->setCellValue($letter[$b].$x, $r->score);
                            $b++;
                        }


                    }
                    $objPHPExcel->getActiveSheet()->setCellValue($letter[$b].$x, $d->total);
                    $objPHPExcel->getActiveSheet()->setCellValue($letter[$b+1].$x, $d->average);
                    $objPHPExcel->getActiveSheet()->setCellValue($letter[$b+2].$x, $d->position);
                    $x++;
                    $y++;

                }
                // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(0);
                $name = Session::get('academic_class_name').' '.Session::get('academic_session_name').' :  '.Session::get('academic_term_name').'  Term ';
                $name = preg_replace('/[\s]+/', '_', $name);
                $name = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $name);



// Redirect output to a client’s web browser (Excel2007)
                header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
                header('Content-Disposition: attachment;filename="'.$name.'.xlsx"');
                header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0

                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
                exit;






            }else{
                $data = $this->db->get('acad_result_folder', array('term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')))->results();
                Session::put('total_students',$this->db->count());

                $echo = '';
                $x = 1;
                $subject = $this->get_subject_for_class(Session::get('academic_class_id'));
                $subj = count($subject);
                Session::put('total_subjects',$subj);

                $echo .= '<thead>';
                $echo .= ' <tr>';
                $echo .= '<th rowspan="2">S/N</th>';
                $echo .= '<th rowspan="2" width="80" align="center">Name</th>';
                $echo .= '<th rowspan="2" width="30" align="center">ID</th>';
                foreach($subject as $s){
                    $echo .= '<th colspan="3" class="text-center">'.$s['subject_name'].'</th>';
                    //$echo .= '<th class="text-center">'.$s['subject_alias'].'</th>';
                }
                $echo .= '<th rowspan="2">Total</th>';
                $echo .= '<th rowspan="2">Ave</th>';
                $echo .= '<th rowspan="2">Pos</th>';
                $echo .= '</tr>';

                /*

                 */
                $echo .= '<tr>';

                for($j=1; $j<= $subj; $j++){
                    $echo .= '<th>40%</th><th>60%</th><th>100%</th>';
                    //$echo .= '<th></th>';
                }
                $echo .= '</tr>';
                $echo .= '</thead>';
                $header = $echo;

                foreach($data as $d){
                    $person = $this->db->fetch_exact('academic_students', 'student_id',$d->student_id);
                    $record = $this->db->get('academic_records',array('student_id','=',$d->student_id))->results();

                    $echo .= ' <tr>';
                    $echo .= '<td>'.$x.'</td>';
                    $echo .= '<td width="80" align="center">'.$person['student_name'].'</td>';
                    $echo .= '<td width="30" align="center">'.$person['student_reg_no'].'</td>';

                    $i = 1;
                    foreach($record as $r){
                        //$slip .= $subject['subject_name'].': '.$r->score.', ';
                        $echo .= '<td>'.'</td>';
                        $echo .= '<td>'.'</td>';
                        $echo .= '<td>'.'</td>';
                        $i++;
                    }
                    for($i; $i <= $subj; $i++){
                        $echo .= '<td>'.'</td>';
                    }
                    $echo .= '<td>'.'</td>';
                    $echo .= '<td>'.'</td>';
                    $echo .= '<td>'.'</td>';
                    $echo .= '</tr>';
                    $x++;


                }

            }

            return $echo;
        }



        function get_academic_sessions($id = null){
            if(isset($id)){
                $data = $this->db->fetch_exact('academic_sessions', 'session_id',$id);
                Session::put('session_name',$data['session_name']);
                Session::put('session_id',$data['session_id']);
                $school = $this->db->fetch_exact('schools', 'school_id',$data['school_id']);
                Session::put('school_name',$school['school_name']);
                Session::put('school_id',$school['school_id']);

                $term = $this->db->get('academic_terms', array('session_id','=',$data['session_id']))->results();
                $result = array();
                $terms = array('1st','2nd','3rd');
                $arrived = array();

                foreach($term as $t){
                    if(in_array($t->term,$terms)){
                        $arrived[] = $t->term;
                    }else{

                    }
                    $result[] = array(
                        'term_id' => $t->term_id,
                        'term' => $t->term,
                        'term_starts' => $t->term_starts,
                        'term_ends' => $t->term_ends,
                        'details' => $t->details,
                    );
                }
                $diff = array_diff($terms,$arrived);

                return array($result,$diff);

            }else{
                $result = array();
                $session =  $this->db->get('academic_sessions')->results();
                foreach($session as $s){
                    //get school
                    $school = $this->db->fetch_exact('schools', 'school_id',$s->school_id);
                    //get term
                    $term = $this->db->get('academic_terms', array('session_id','=',$s->session_id))->results();
                    $active_terms = '';
                    foreach($term as $t){
                        $active_terms .= $t->term .', ';
                    }
                    $active_terms = chop($active_terms,', ');

                    $result[] = array(
                        'session_id' => $s->session_id,
                        'session_name' => $s->session_name,
                        'school' => $school['school_name'],
                        'terms' => $active_terms,
                    );
                }

                return $result;


            }


        }



        public function add_student_record($update = null) {
            $reg = $this->db->fetch_last('result_students','student_id');
            if($reg){
                $i = explode('/',$reg['reg_no']);
                $no = $i[1]+1;
                switch(strlen($no)){ //generate good serial no
                    case 1:
                        $no = "000$no";
                        break;
                    case 2:
                        $no = "00$no";
                        break;
                    case 3:
                        $no = "0$no";
                        break;
                    default:
                        $no = "$no";
                        break;
                }

                $no = 'AGSS/'.$no;
            }else{
                $no = 'AGSS/0001';
            }
            try {
                if($update){
                    $this->db->update('academic_students', array(
                        'student_name' => trim(Input::get('student_name')),
                        'student_reg_no' => trim(Input::get('student_reg_id')),
                        'current_class' => Input::get('select_class'),

                        'details' => trim(Input::get('description')),
                        'date' => $this->today,
                    ), 'student_id', $update);
                }else{
                    $this->db->insert('academic_students', array(
                        'student_name' => trim(Input::get('student_name')),
                        'student_reg_no' => $no,
                        'sex' => trim(Input::get('select_sex')),
                        'phone_no' => trim(Input::get('phone_no')),
                        'start_class' => Session::get('academic_class_id'),
                        'current_class' => Session::get('academic_class_id'),
                        'start_term' => Session::get('academic_term_id'),
                        'current_term' => Session::get('academic_term_id'),
                        'start_session' => (Session::get('academic_session_id')),
                        'current_session' => (Session::get('academic_session_id')),
                        'details' => trim(Input::get('description')),
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

        function get_student_in_class($id = null){
            $class = $this->get_class($id);
            Session::put('academic_class_name',$class['class_name']);
            Session::put('academic_class_id',$class['class_id']);
            $data = $this->db->get('result_students',array('current_class','=',$id),'surname','ASC')->results();
            return $data;

        }
        function get_subject_for_class($id = null){
            $class = $this->get_class($id);
            Session::put('academic_class_name',$class['class_name']);
            Session::put('academic_class_id',$class['class_id']);
            $data = $this->db->get_assoc('academic_subjects',array('class_id','=',$id))->results_assoc();
            return $data;

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


        public function get_student_record($id = null) {
            if($id){
                $data = $this->db->fetch_exact('academic_students', 'student_id',$id);

            }else{
                $data = $this->db->get('academic_students',array('start_class','=',Session::get('academic_class_id')))->results();
            }
            return $data;

        }

        public function resumption($id = null) {
            $result = array();
            $data = $this->db->get('resumption',null,'date')->results();
            foreach($data as $d){
                $session = $this->db->fetch_exact('academic_sessions', 'session_id',$d->session_id);
                $term = $this->db->fetch_exact('academic_terms', 'term_id',$d->term_id);
                if(strpos($d->class_id,',')){
                    $class = '';
                    $all = explode(',',$d->class_id);
                    for($i=0; $i<count($all); $i++){
                        $class_id = $this->db->fetch_exact('academic_classes', 'class_id',$all[$i]);
                        $class .= $class_id['class_name'].', ';

                    }
                    $class = chop($class,', ');
                }else{
                    $class = "All Students";
                }
                $date = new DateTime($d->date);
                $dob = $date->format('D, d M, Y ');//h:i a
                $result[] = array(
                    'date' => $dob,
                    'session' => $session['session_name'].' - '.$term['term'] ,
                    'class' => $class,
                    'note' => $d->note,
                    'id' => $d->id,
                );
            }

            return $result;

        }

        function delete_resumption($id){
            $this->db->delete('resumption',array('id','=',$id));
            Session::flash('home','Done!');
            return true;
        }

        function delete_school_fees($id){
            $this->db->delete('school_fees',array('id','=',$id));
            Session::flash('home','Done!');
            return true;
        }

        public function school_fees($id = null) {
            $result = array();
            $data = $this->db->get('school_fees')->results();
            foreach($data as $d){
                $session = $this->db->fetch_exact('academic_sessions', 'session_id',$d->session_id);
                $term = $this->db->fetch_exact('academic_terms', 'term_id',$d->term_id);
                if(strpos($d->class_id,',')){
                    $class = '';
                    $all = explode(',',$d->class_id);
                    for($i=0; $i<count($all); $i++){
                        $class_id = $this->db->fetch_exact('academic_classes', 'class_id',$all[$i]);
                        $class .= $class_id['class_name'].', ';

                    }
                    $class = chop($class,', ');
                }else{
                    $class = "All Students";
                }
                $result[] = array(
                    'amount' => $d->amount,
                    'session' => $session['session_name'].' - '.$term['term'] ,
                    'class' => $class,
                    'note' => $d->note,
                    'id' => $d->id,
                );
            }

            return $result;

        }


        public function create_subject($update = null) {
            try {
                if($update){
                    $this->db->update('academic_subjects', array(
                        //'school_id' => trim(Session::get('school_id')),
                        'class_id' => Input::get('subject_for'),
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
                        //'school_id' => trim(Session::get('school_id')),
                        'class_id' => Input::get('subject_for'),
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

        public function classSubjectCreator($how){
            $subject = trim(Input::get('subject_name'));
            $alias = trim(Input::get('subject_alias'));
            switch($how){
                case 'ALL':
                    $classes = $this->db->get('academic_classes')->results();
                    foreach($classes as $c){
                        $this->db->insert('academic_subjects', array(
                            //'school_id' => trim(Session::get('school_id')),
                            'class_id' => $c->class_id,
                            'subject_name' => $subject,
                            'subject_alias' => $alias,
                            'subject_for' => $how,
                            'date' => $this->today,
                        ));

                    }
                    break;

                case 'JSS':
                    $classes = $this->db->get('academic_classes',array('parent_class','=','JSS'))->results();
                    foreach($classes as $c){
                        $this->db->insert('academic_subjects', array(
                            //'school_id' => trim(Session::get('school_id')),
                            'class_id' => $c->class_id,
                            'subject_name' => $subject,
                            'subject_alias' => $alias,
                            'subject_for' => $how,
                            'date' => $this->today,
                        ));

                    }
                    break;

                case 'SS':
                    $classes = $this->db->get('academic_classes',array('parent_class','=','SS'))->results();
                    foreach($classes as $c){
                        $this->db->insert('academic_subjects', array(
                            //'school_id' => trim(Session::get('school_id')),
                            'class_id' => $c->class_id,
                            'subject_name' => $subject,
                            'subject_alias' => $alias,
                            'subject_for' => $how,
                            'date' => $this->today,
                        ));

                    }
                    break;

                case 'class':
                    $classes = explode(',',Input::get('classes'));
                    $j = count($classes)-1;
                    for($i=0; $i <= $j; $i++){
                        $this->db->insert('academic_subjects', array(
                            //'school_id' => trim(Session::get('school_id')),
                            'class_id' => $classes[$i],
                            'subject_name' => $subject,
                            'subject_alias' => $alias,
                            'subject_for' => $how,
                            'date' => $this->today,
                        ));
                    }
            }

            return true;
        }


        public function classSubjectUpdate($classType, $class_id){
            $hold_names = array();

            if($classType != 'class'){
                $subjects = $this->db->get('academic_subjects',array('subject_for','=',$classType))->results();
                foreach($subjects as $c){
                    if(in_array($c->subject_name,$hold_names)){
                        continue;
                    }else{
                        $hold_names[] = $c->subject_name;

                        $this->db->insert('academic_subjects', array(
                            //'school_id' => trim(Session::get('school_id')),
                            'class_id' => $class_id,
                            'subject_name' => $c->subject_name,
                            'subject_alias' => $c->subject_alias,
                            'subject_for' => $c->subject_for,
                            'date' => $this->today,
                        ));

                    }

                }

                // for all: subjects that apply globally
                $subjects = $this->db->get('academic_subjects',array('subject_for','=','ALL'))->results();
                foreach($subjects as $c){
                    if(in_array($c->subject_name,$hold_names)){
                        continue;
                    }else{
                        $hold_names[] = $c->subject_name;

                        $this->db->insert('academic_subjects', array(
                            //'school_id' => trim(Session::get('school_id')),
                            'class_id' => $class_id,
                            'subject_name' => $c->subject_name,
                            'subject_alias' => $c->subject_alias,
                            'subject_for' => $c->subject_for,
                            'date' => $this->today,
                        ));

                    }

                }

            }
            Session::put('home', 'Subjects that pertain to this class was successfully applied!');
            return true;
        }

        public function create_class($update = null){
            $classType = Input::get('classType');
            $class_name = $classType.' '.Input::get('class_name');
            $sub_class = explode(',',chop(Input::get('sub_class'),','));

            try {
                foreach($sub_class as $s){
                    if($s){
                        $class = $class_name.' '.ucwords($s);
                        if($update){
                            $this->db->update('academic_classes', array(
                                'school_id' => 1,
                                'class_name' => trim($class),
                                'super_class' => trim($class_name),
                                'parent_class' => $classType,
                                'date' => $this->today,
                            ), 'class_id', $update);
                            $class_id = $update;
                        }else{
                            $this->db->insert('academic_classes', array(
                                'school_id' => 1,
                                'class_name' => trim($class),
                                'super_class' => trim($class_name),
                                'parent_class' => $classType,
                                'date' => $this->today,
                            ));
                            $class_id = $this->db->last_insert_id();

                        }

                    }else{
                        $this->db->insert('academic_classes', array(
                            'school_id' => 1,
                            'class_name' => trim($class_name),
                            'super_class' => trim($class_name),
                            'parent_class' => $classType,
                            'date' => $this->today,
                        ));
                        $class_id = $this->db->last_insert_id();

                    }
                    //update subjects for that class
                    $this->classSubjectUpdate($classType, $class_id);

                }
                cleanUP();
                Session::put('home', 'Class was successfully created!');

                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function add_result($update = null) {//$all = null,

            try {
                if($update){
                    $folder = $this->db->fetch_exact('acad_result_folder','id',$update);

                    $this->db->update('acad_result_folder', array(
                        'position' => trim(Input::get('position')),
                        'total' => trim(Input::get('total')),
                        'average' => trim(Input::get('average')),

                        'date' => $this->today,
                    ), 'id', $update);

                    $data = $this->db->get('academic_records',array('folder_id','=',$update))->results();
                    foreach($data as $act){
                        $record = Input::get('subject_id_'.$act->record_id);

                        $this->db->update('academic_records', array(
                            //'student_id' => trim(Input::get('student_id')),
                            //'subject_id' => trim($act->subject_id),
                            //'school_id' => Session::get('school_id'),
                            //'session_id' => Session::get('academic_session_id'),
                            //'class_id' => trim(Session::get('academic_class_id')),

                            'score' => trim($record),
                            'entered_by' => trim(Session::get('user_id')),
                            'date' => $this->today,
                        ), 'record_id', $act->record_id);

                    }
                    Session::flash('home', 'Information successfully Updated!');


                }else{
                    $student_id = Input::get('student_id');
                    if(!$student_id){
                        Session::flash('error','Please Re-select the student or enter a new student detail');
                        return false;
                    }
                    //SELECT `id`, `session_id`, `term_id`, `class_id`, `student_id`, `position`, `total`, `average`, `pass_fail`, `promoted`, `date` FROM `` WHERE 1
                    $folder = $this->db->fetch_exact_two('acad_result_folder','student_id',$student_id,'term_id',Session::get('academic_term_id'));
                    if($folder){
                        Session::flash('error', 'Record already exist for this student, for this term in this session. Please edit that one!');
                    }else{
                        $this->db->insert('acad_result_folder', array(
                            'session_id' => Session::get('academic_session_id'),
                            'term_id' => Session::get('academic_term_id'),
                            'class_id' => trim(Session::get('academic_class_id')),
                            'student_id' => trim($student_id),

                            'position' => trim(Input::get('position')),
                            'total' => trim(Input::get('total')),
                            'average' => trim(Input::get('average')),

                            //'entered_by' => trim(Session::get('user_id')),
                            'date' => $this->today,
                        ));
                        $deal = $this->db->last_insert_id();
                        $active_tabs = $this->active_tabs('all');

                        foreach($active_tabs as $act){
                            $this->db->insert('academic_records', array(
                                'student_id' => trim($student_id),
                                'subject_id' => trim($act->subject_id),
                                'folder_id' => $deal,
                                'session_id' => Session::get('academic_session_id'),
                                'term_id' => Session::get('academic_term_id'),
                                'class_id' => trim(Session::get('academic_class_id')),

                                'score' => trim(Input::get('subject_id_'.$act->subject_id)),

                                'entered_by' => trim(Session::get('user_id')),
                                'date' => $this->today,
                            ));

                        }


                        cleanUP();
                        Session::flash('home', 'Information successfully saved!');
                    }
                }

                return true;
            } catch (Exception $e) {
                return false;
            }
        }


        function termly_report_sheet($class){
            $all_students = $this->db->get('result_students', array('current_class','=',$class,'current_session','=',Session::get('academic_session_id')))->results();

            $total_subjects = $this->db->get('academic_subjects', array('class_id','=',$class))->count();

            $classroom = $this->db->fetch_exact('academic_classes', 'class_id',$class);
            switch($classroom['super_class']){
               case 'SS 1':
					$total_subjects = 17;
					break;
			   case 'SS 2':
                    $total_subjects = 12;
                    break;
				case 'SS 3':
                    $total_subjects = 9;
                    break;
				case 'JSS 1':
                    $total_subjects = 11;
                    break;
				case 'JSS 2':
                    $total_subjects = 11;
                    break;
                default:
                    $total_subjects = 10;
                    break;
            }

            foreach($all_students as $s){
                $totalled = array();
                $subject_ids = '';
                $subject_scores = '';

                $results = $this->db->get('results_per_subject_per_student',array('student_id', '=', $s->student_id,'term_id','=', Session::get('academic_term_id'),'class_id','=', ($class)),'total')->results();

                foreach($results as $r){
                    $totalled[] = $r->total;
                    $subject_ids .= $r->subject_id.', ';
                    $subject_scores .= $r->total.', ';
                }
                $subject_ids = chop($subject_ids,', ');
                $subject_scores = chop($subject_scores,', ');

                $totally = round(array_sum($totalled),2);
                $average = round($totally/$total_subjects,2);

                $comment = $this->comment_generator($totalled,$subject_ids);

                // delete if already exist before insert
                $exist = $this->db->get('result_per_term_per_student',array('student_id', '=', $s->student_id,'term_id','=', Session::get('academic_term_id'),'class_id','=', ($class)))->results();
                if($exist){
                    $this->db->delete('result_per_term_per_student',array('student_id', '=', $s->student_id,'term_id','=', Session::get('academic_term_id'),'class_id','=', ($class)));
                }

                $this->db->insert('result_per_term_per_student',array(
                    'student_id' => $s->student_id,
                    'session_id' => Session::get('academic_session_id'),
                    'term_id' => Session::get('academic_term_id'),
                    'class_id' => trim($class),

                    'total' => $totally,
                    'position' => null,
                    'average' => $average,
                    'subjects' => $subject_ids,
                    'subject_scores' => $subject_scores,
                    'comment' => $comment,

                    'date' => $this->today,
                ));
            }
            //now assign position to all of them
            $position = $this->update_term_position($class,Session::get('academic_term_id'));

            Session::put('home','Termly Computation Done');

            return true;

        }

        function createNewRecord($surname,$othername,$ca,$exam,$total){
            $position = '';
            $grade = '';
            $remark = '';
            $term = '';
            $no = $this->regNoGenerator();
            $this->db->insert('result_students', array(
                'surname' => $surname,
                'othername' => $othername,
                'reg_no' => $no,
                'sex' => 'null',
                'phone_no' => 'null',
                'start_class' => Session::get('academic_class_id'),
                'current_class' => Session::get('academic_class_id'),
                'start_term' => Session::get('academic_term_id'),
                'current_term' => Session::get('academic_term_id'),
                'start_session' => (Session::get('academic_session_id')),
                'current_session' => (Session::get('academic_session_id')),
                'details' => 'null',
                'date' => $this->today,

                'input_by' => trim(Session::get('user_id')),
            ));


            $student_id = $this->db->last_insert_id();

            if($ca || $exam || $total){
                list($grade, $remark) = $this->grading($total);
                $this->db->insert('results_per_subject_per_student',array(
                    'student_id' => $student_id,
                    'subject_id' => Session::get('academic_subject_id'),
                    'folder_id' => 1,
                    'session_id' => Session::get('academic_session_id'),
                    'term_id' => Session::get('academic_term_id'),
                    'class_id' => trim(Session::get('academic_class_id')),

                    'ca' => $ca,
                    'exam' => $exam,
                    'total' => $total,
                    'grade' => $grade,
                    'remark' => $remark,

                    'entered_by' => trim(Session::get('user_id')),
                    'date' => $this->today,
                ));
                $record_id = $this->db->last_insert_id();

                $position = $this->updateSubjectPosition(Session::get('academic_class_id'),Session::get('academic_subject_id'),$student_id,Session::get('academic_term_id'));

            }


            //echo results
            $echo = '<tr>
                        <td id="record_'.$student_id.'_surname" ondblclick="editable('.$student_id.',\'surname\',\'text\')">'.$surname.'</td>
                        <td id="record_'.$student_id.'_othername" ondblclick="editable('.$student_id.',\'othername\',\'text\')">'.$othername.'</td>';

            if($ca){
                $echo .= '  <td id="record_'.$student_id.'_ca" ondblclick="editable('.$student_id.',\'ca\',\'number\')">'.$ca.'</td>';
            }else{
                $echo .= '  <td><input type="text" class="form-control" name="record_'.$student_id.'_ca" id="record_'.$student_id.'_ca" placeholder="CA" onkeyup="autoEditTotal('.$student_id.')" onblur="createAcadRecord('.$student_id.',\'ca\',\'number\')"> </td>';
            }

            if($exam){
                $echo .= '  <td id="record_'.$student_id.'_exam" ondblclick="editable('.$student_id.',\'exam\',\'number\')">'.$exam.'</td>';
            }else{
                $echo .= '  <td><input type="text" class="form-control" name="record_'.$student_id.'_exam" id="record_'.$student_id.'_exam" placeholder="Exam" onkeyup="autoEditTotal('.$student_id.')" onblur="createAcadRecord('.$student_id.',\'exam\',\'number\')"> </td>';
            }

            $echo .= '  <td id="record_'.$student_id.'_total">'.$total.'</td>';
            $echo .= '  <td id="record_'.$student_id.'_grade">'.$grade.'</td>';
            $echo .= '  <td id="record_'.$student_id.'_remark">'.$remark.'</td>';
            $echo .= '  <td id="record_'.$student_id.'_position" class="sortPost">'.$position.'</a> </td>
            <td><a href="'.URL.'teacher/delete_student_subject_result/'.$student_id.'" class="btn btn-danger" onclick="return confirm(\'This would delete all the record and the Name of the Student associated with this record\')">Delete</a> </td>
                    </tr>';

            echo($echo);

        }

        function UpdateAcadRecord($field,$what,$input,$total){
            list($grade, $remark) = $this->grading($total);

            $this->db->pumpUpdate('results_per_subject_per_student',array(
                // => ,
                $what => $input,
                'total' => $total,
                'grade' => $grade,
                'remark' => $remark,
                'entered_by' => trim(Session::get('user_id')),
                'date' => $this->today,
            ), array('student_id','=',$field,'subject_id','=',Session::get('academic_subject_id'),'term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')));

            $position = $this->updateSubjectPosition(Session::get('academic_class_id'),Session::get('academic_subject_id'),$field,Session::get('academic_term_id'));

            echo("Successfully Updated the field - New ".$what." = ".$input.' and Total = '.$total.' || '.$position.' || '.$grade.' || '.$remark);
        }

        function updateSubjectPosition($class,$subject_id,$record_id, $term_id){
            $update = $this->db->get('results_per_subject_per_student',array('class_id','=',$class,'subject_id','=',$subject_id,'term_id','=',$term_id),'total')->results();
            $i = 1;
            $highest = $this->db->first()->total;
            $lowest = $this->db->last()->total;
            $average = array();
            $wanted = '';
            $last_total = '';
            $last_ordinate = '';
            foreach($update as $jet){
                $average[] = $jet->total;
                // allow more than 2 people to be first
                if($jet->total == $last_total){
                    $sql = $this->db->pumpUpdate('results_per_subject_per_student',array(
                        'position' => $last_ordinate,
                    ),array('student_id','=',$jet->student_id,'class_id','=',$class,'subject_id','=',$subject_id,'term_id','=',$term_id));
                    if($jet->student_id == $record_id){
                        $wanted = $last_ordinate;
                    }
                }else{
                    $last_total = $jet->total;
                    $ordinate = $this->addOrdinalNumberSuffix($i);
                    $sql = $this->db->pumpUpdate('results_per_subject_per_student',array(
                        'position' => $ordinate,
                    ),array('student_id','=',$jet->student_id,'class_id','=',$class,'subject_id','=',$subject_id,'term_id','=',$term_id));
                    $last_ordinate = $ordinate;
                    if($jet->student_id == $record_id){
                        $wanted = $ordinate;
                    }
                }
                $i++;

            }

            $average = round(array_sum($average)/count($average),1);

            $check = $this->db->get('results_per_subject_highest_lowest',array('class_id','=',$class,'subject_id','=',$subject_id,'term_id','=',$term_id))->results();
            if($check){
                $sql = $this->db->pumpUpdate('results_per_subject_highest_lowest',array(
                    'highest' => $highest,
                    'lowest' => $lowest,
                    'average' => $average,
                    'entered_by' => (Session::get('user_id')),
                    'date' => $this->today,
                ),array('class_id','=',$class,'subject_id','=',$subject_id,'term_id','=',$term_id));
            }else{
                $this->db->insert('results_per_subject_highest_lowest',array(
                    'subject_id' => $subject_id,
                    'session_id' => Session::get('academic_session_id'),
                    'term_id' => $term_id,
                    'class_id' => $class,
                    'highest' => $highest,
                    'lowest' => $lowest,
                    'average' => $average,
                    'entered_by' => (Session::get('user_id')),
                    'date' => $this->today,
                ));

            }

            return $wanted;
        }


        function update_term_position($class, $term_id){
            $update = $this->db->get('result_per_term_per_student',array('class_id','=',$class,'term_id','=',$term_id),'average')->results();

            $total_students = $this->db->count();

            $first = $this->db->first()->student_id;
            $first_score = $this->db->first()->average;
            $second = $this->db->second()->student_id;
            $second_score = $this->db->second()->average;
            $third = $this->db->third()->student_id;
            $third_score = $this->db->third()->average;
            $average = array();

            $i = 1;
            $last_total = '';
            $last_ordinate = '';
            foreach($update as $jet){
                $average[] = $jet->average;
                // allow more than 2 people to be first
                if($jet->total == $last_total){
                    $sql = $this->db->pumpUpdate('result_per_term_per_student',array(
                        'position' => $last_ordinate,
                    ),array('student_id','=',$jet->student_id,'class_id','=',$class,'term_id','=',$term_id));
                }else{
                    $last_total = $jet->total;
                    $ordinate = $this->addOrdinalNumberSuffix($i);
                    $sql = $this->db->pumpUpdate('result_per_term_per_student',array(
                        'position' => $ordinate,
                    ),array('student_id','=',$jet->student_id,'class_id','=',$class,'term_id','=',$term_id));
                    $last_ordinate = $ordinate;
                }
                $i++;

            }

            $average = round(array_sum($average)/count($average),1);
            $check = $this->db->get('result_per_class_per_term',array('class_id','=',$class,'term_id','=',$term_id))->results();
            if($check){
                $sql = $this->db->pumpUpdate('result_per_class_per_term',array(
                    'top1_student' => $first,
                    'top1_score' => $first_score,
                    'top2_student' => $second,
                    'top2_score' => $second_score,
                    'top3_student' => $third,
                    'top3_score' => $third_score,
                    'class_average' => $average,
                    'class_total_students' => $total_students,
                    'date' => $this->today,
                ),array('class_id','=',$class,'term_id','=',$term_id));
            }else{
                $this->db->insert('result_per_class_per_term',array(
                    'session_id' => Session::get('academic_session_id'),
                    'term_id' => $term_id,
                    'class_id' => $class,
                    'top1_student' => $first,
                    'top1_score' => $first_score,
                    'top2_student' => $second,
                    'top2_score' => $second_score,
                    'top3_student' => $third,
                    'top3_score' => $third_score,
                    'class_average' => $average,
                    'class_total_students' => $total_students,
                    'date' => $this->today,
                ));

            }

            Session::put('home','Position Was Successfully assigned to results');

            return true;
        }

        function update_annual_position($class, $term_id){
            $update = $this->db->get('result_per_annual_per_student',array('class_id','=',$class,'session_id','=',$term_id),'total')->results();
            $total_students = $this->db->count();

            $first = $this->db->first()->student_id;
            $first_score = $this->db->first()->average;
            $second = $this->db->second()->student_id;
            $second_score = $this->db->second()->average;
            $third = $this->db->third()->student_id;
            $third_score = $this->db->third()->average;
            $average = array();

            $i = 1;
            $last_total = '';
            $last_ordinate = '';
            foreach($update as $jet){
                $average[] = $jet->average;
                // allow more than 2 people to be first
                if($jet->total == $last_total){
                    $sql = $this->db->pumpUpdate('result_per_annual_per_student',array(
                        'position' => $last_ordinate,
                    ),array('student_id','=',$jet->student_id,'class_id','=',$class,'session_id','=',$term_id));
                }else{
                    $last_total = $jet->total;
                    $ordinate = $this->addOrdinalNumberSuffix($i);
                    $sql = $this->db->pumpUpdate('result_per_annual_per_student',array(
                        'position' => $ordinate,
                    ),array('student_id','=',$jet->student_id,'class_id','=',$class,'session_id','=',$term_id));
                    $last_ordinate = $ordinate;
                }
                $i++;

            }


            $average = round(array_sum($average)/count($average),1);
            $check = $this->db->get('result_per_class_per_annual',array('class_id','=',$class,'session_id','=',$term_id))->results();
            if($check){
                $sql = $this->db->pumpUpdate('result_per_class_per_annual',array(
                    'top1_student' => $first,
                    'top1_score' => $first_score,
                    'top2_student' => $second,
                    'top2_score' => $second_score,
                    'top3_student' => $third,
                    'top3_score' => $third_score,
                    'class_average' => $average,
                    'class_total_students' => $total_students,
                    'date' => $this->today,
                ),array('class_id','=',$class,'session_id','=',$term_id));
            }else{
                $this->db->insert('result_per_class_per_annual',array(
                    'session_id' => Session::get('academic_session_id'),
                    'class_id' => $class,
                    'top1_student' => $first,
                    'top1_score' => $first_score,
                    'top2_student' => $second,
                    'top2_score' => $second_score,
                    'top3_student' => $third,
                    'top3_score' => $third_score,
                    'class_average' => $average,
                    'class_total_students' => $total_students,
                    'date' => $this->today,
                ));

            }

            Session::put('home','Position Was Successfully assigned to results');

            return true;
        }

        function createAcadRecord($field,$what,$input,$total){
            $check = $this->db->get('results_per_subject_per_student',array('student_id','=', $field,'subject_id','=',Session::get('academic_subject_id'),'term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')));
            list($grade, $remark) = $this->grading($total);

            if($this->db->count()){ //student already has a record

                $this->db->pumpUpdate('results_per_subject_per_student',array(
                    $what => $input,
                    'total' => $total,
                    'grade' => $grade,
                    'remark' => $remark,
                    'entered_by' => trim(Session::get('user_id')),
                    'date' => $this->today,
                ), array('student_id','=',$field,'subject_id','=',Session::get('academic_subject_id'),'term_id','=',Session::get('academic_term_id'),'class_id','=',Session::get('academic_class_id')));

            }else{
                $this->db->insert('results_per_subject_per_student',array(
                    'student_id' => $field,
                    'subject_id' => Session::get('academic_subject_id'),
                    'folder_id' => 1,
                    'session_id' => Session::get('academic_session_id'),
                    'term_id' => Session::get('academic_term_id'),
                    'class_id' => trim(Session::get('academic_class_id')),

                    $what => $input,
                    'total' => $total,
                    'grade' => $grade,
                    'remark' => $remark,
                    'entered_by' => trim(Session::get('user_id')),
                    'date' => $this->today,
                ));

            }
            $position = $this->updateSubjectPosition(Session::get('academic_class_id'),Session::get('academic_subject_id'),$field,Session::get('academic_term_id'));


            echo("Successfully Added the field - ".$what." = ".$input.' and Total = '.$total.' || '.$position.' || '.$grade.' || '.$remark);
        }


        public function student_records_per_subject($subject= 1, $class = 1, $term = 1) {
            $students = $this->db->get('result_students',array('current_class','=',$class,'current_session','=',Session::get('academic_session_id')))->results();

            $results = $this->db->get('results_per_subject_per_student',array('class_id','=',$class,'term_id','=',$term,'subject_id','=',$subject),'total')->results();

            $echo = '';
            $those_with_results = array();
            foreach($results as $r){
                $student = $this->db->fetch_exact('result_students','student_id', $r->student_id);

                $those_with_results[] = $r->student_id;

                $echo .= ' <tr>';
                $echo .= '<td id="record_'.$r->student_id.'_surname" ondblclick="editable('.$r->student_id.',\'surname\',\'text\')">'.$student['surname'].'</td>';
                $echo .= '<td id="record_'.$r->student_id.'_othername" ondblclick="editable('.$r->student_id.',\'othername\',\'text\')">'.$student['othername'].'</td>';
                if($r->ca){
                    $echo .= '  <td id="record_'.$r->student_id.'_ca" ondblclick="editable('.$r->student_id.',\'ca\',\'number\')">'.$r->ca.'</td>';
                }else{
                    $echo .= '  <td><input type="text" class="form-control" name="record_'.$r->student_id.'_ca" id="record_'.$r->student_id.'_ca" placeholder="CA" onkeyup="autoEditTotal('.$r->student_id.')" onblur="createAcadRecord('.$r->student_id.',\'ca\',\'number\')"> </td>';
                }
                if($r->exam){
                    $echo .= '  <td id="record_'.$r->student_id.'_exam" ondblclick="editable('.$r->student_id.',\'exam\',\'number\')">'.$r->exam.'</td>';
                }else{
                    $echo .= '  <td><input type="text" class="form-control" name="record_'.$r->student_id.'_exam" id="record_'.$r->student_id.'_exam" placeholder="Exam" onkeyup="autoEditTotal('.$r->student_id.')" onblur="createAcadRecord('.$r->student_id.',\'exam\',\'number\')"> </td>';
                }
                $echo .= '  <td id="record_'.$r->student_id.'_total">'.$r->total.'</td>';
                $echo .= '  <td id="record_'.$r->student_id.'_grade">'.$r->grade.'</td>';
                $echo .= '  <td id="record_'.$r->student_id.'_remark">'.$r->remark.'</td>';
                $echo .= '  <td id="record_'.$r->student_id.'_position" class="sortPost">'.$r->position.'</td>';
                $echo .= ' <td><a href="'.URL.'teacher/delete_student_subject_result/'.$r->student_id.'" class="btn btn-danger" onclick="return confirm(\'This would delete all the record and the Name of the Student associated with this record\')">Delete</a> </td>';
                $echo .= '</tr>';


            }

            foreach($students as $r){
                if(in_array($r->student_id,$those_with_results)){
                    continue;
                }
                $student = $this->db->fetch_exact('result_students','student_id', $r->student_id);
                $those_with_results[] = $r->student_id;

                $echo .= ' <tr>';
                $echo .= '<td id="record_'.$r->student_id.'_surname" ondblclick="editable('.$r->student_id.',\'surname\',\'text\')">'.$student['surname'].'</td>';
                $echo .= '<td id="record_'.$r->student_id.'_othername" ondblclick="editable('.$r->student_id.',\'othername\',\'text\')">'.$student['othername'].'</td>';
                $echo .= '  <td><input type="text" class="form-control" name="record_'.$r->student_id.'_ca" id="record_'.$r->student_id.'_ca" placeholder="CA" onkeyup="autoEditTotal('.$r->student_id.')" onblur="createAcadRecord('.$r->student_id.',\'ca\',\'number\')"> </td>';

                $echo .= '  <td><input type="text" class="form-control" name="record_'.$r->student_id.'_exam" id="record_'.$r->student_id.'_exam" placeholder="Exam" onkeyup="autoEditTotal('.$r->student_id.')" onblur="createAcadRecord('.$r->student_id.',\'exam\',\'number\')"> </td>';

                $echo .= '  <td id="record_'.$r->student_id.'_total"></td>';
                $echo .= '  <td id="record_'.$r->student_id.'_grade"></td>';
                $echo .= '  <td id="record_'.$r->student_id.'_remark"></td>';

                $echo .= '  <td id="record_'.$r->student_id.'_position" class="sortPost"></td>';
                $echo .= ' <td><a href="'.URL.'teacher/delete_student_subject_result/'.$r->student_id.'" class="btn btn-danger" onclick="return confirm(\'This would delete all the record and the Name of the Student associated with this record\')">Delete</a> </td>';
                $echo .= '</tr>';


            }

            return array($echo, count($students));

        }


        function UpdateNameRecord($field,$what,$input){

            $this->db->update('result_students',array(
                $what => $input,

                'input_by' => trim(Session::get('user_id')),
                'date' => $this->today,
            ),'student_id',$field);


            echo("Successfully Updated the field - New ".$what." = ".$input);
        }

        public function delete_student_subject_result($student_id, $subject, $class, $term) {
            $students = $this->db->get('results_per_subject_per_student',array('student_id','=',$student_id,'class_id','=',$class,'term_id','=',$term,'subject_id','=',$subject))->results();
            $id = $this->db->first();

            $data = $this->db->delete('results_per_subject_per_student',array('record_id','=',$id->record_id));

            $position = $this->updateSubjectPosition(Session::get('academic_class_id'),Session::get('academic_subject_id'),$student_id,Session::get('academic_term_id'));
            Session::put('home','Student Record Deleted Successfully');

        }

        function delete_student($student){
            $data = $this->db->delete('result_students',array('student_id','=',$student));
            $students = $this->db->get('results_per_subject_per_student',array('student_id','=',$student))->results();
            foreach($students as $s){
                $data = $this->db->delete('results_per_subject_per_student',array('record_id','=',$s->record_id));
                $position = $this->updateSubjectPosition(Session::get('academic_class_id'),Session::get('academic_subject_id'),$s->record_id,Session::get('academic_term_id'));

            }
            Session::put('home','Student Record Deleted Successfully');
        }

        function regNoGenerator(){
            $reg = $this->db->fetch_last('result_students','student_id');
            if($reg){
                $i = explode('/',$reg['reg_no']);
                $no = $i[1]+1;
                switch(strlen($no)){ //generate good serial no
                    case 1:
                        $no = "000$no";
                        break;
                    case 2:
                        $no = "00$no";
                        break;
                    case 3:
                        $no = "0$no";
                        break;
                    default:
                        $no = "$no";
                        break;
                }

                $no = 'AGSS/'.$no;
            }else{
                $no = 'AGSS/0001';
            }

            return $no;

        }

        function  add_new_student($student_reg_no,$student_name){
            $no = $this->regNoGenerator();

            $this->db->insert('academic_students', array(
                //'school_id' => 1,
                'student_name' => $student_name,
                'student_reg_no' => $no,
                'sex' => 'male',
                'phone_no' => 'null',
                'start_class' => Session::get('academic_class_id'),
                'current_class' => Session::get('academic_class_id'),
                'start_term' => Session::get('academic_term_id'),
                'current_term' => Session::get('academic_term_id'),
                'start_session' => (Session::get('academic_session_id')),
                'current_session' => (Session::get('academic_session_id')),
                'details' => 'null',
                'date' => $this->today,
                'record_tracker' => Hash::unique(),

                'input_by' => trim(Session::get('user_id')),
            ));


            $student_id = $this->db->last_insert_id();

            Session::put('home','New Student Record was saved successfully');
            Session::put('student_reg_no',$no);
            Session::put('student_name',$student_name);
            Session::put('student_id',$student_id);

            return true;

        }

        function result_folder(){
            $session = Input::get('entry_session');
            $term = Input::get('entry_term');
            //SELECT `id`, ``, ``, ``, `` FROM `` WHERE 1
            $fetch = $this->db->fetch_exact_two('acad_result_folder','session_id',$session,'term_id',$term);
            if($fetch){
                Session::put('active_record_table',$fetch['table_name']);
            }else{
                $table = 'acad_result_'.$session.'_'.$term;
                Session::put('active_record_table',$table);
                try{
                    $this->db->insert('active_record_table', array(
                        'session_id' => $session,
                        'term_id' => $term,
                        'table_name' => $table,
                        'date' => $this->today,
                    ));
                    $default = $this->db->last_insert_id();
                    //create a table


                        $sql = "
                    CREATE TABLE IF NOT EXISTS `{$table}` (
                      `record_id` int(255) NOT NULL AUTO_INCREMENT,
                      `student_id` int(255) NOT NULL,
                      `subject_id` int(255) NOT NULL,
                      `active_record_id` int(255) NOT NULL DEFAULT  '{$default}',
                      `term_id` int(255) NOT NULL,
                      `class_id` int(255) NOT NULL,
                      `exam_score` int(255) NOT NULL,
                      `total_score` int(255) NOT NULL,
                      `grade` varchar(255) NOT NULL,
                      `comment` varchar(255) NULL,
                      `entered_by` varchar(255) NULL,
                      `date` date NOT NULL,
                      PRIMARY KEY (`record_id`)
                    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1
                    ";
                        $this->db->create($sql);

                }catch (Exception $e){

                }
            }
        }

        public function get_result($how= null, $id = null, $season = null) {
            switch($how){
                case 'subject':
                    //$data = $this->db->get('academic_records',array('class_id','=',$id,'term_id','=',$season))->results();
                    $data = $this->db->get('acad_result_folder',array('class_id','=',$id,'term_id','=',$season))->results();

                    $students = array();
                    $echo = '';
                    foreach($data as $d){
                        if(in_array($d->student_id,$students)){
                            continue;
                        }else{
                            $students[] = $d->student_id;
                            $student = $this->db->fetch_exact('academic_students','student_id', $d->student_id);
                            $record = $this->db->get('academic_records',array('folder_id','=',$d->id))->results();
                            //$slip = '';
                            $echo .= ' <tr>';
                            $echo .= '<td>'.$student['student_name'].' <a href="'.URL.'teacher/record/edit/'.$student['student_id'].'" class="text-danger">[Edit]</a></td>';
                            $echo .= '<td>'.$student['student_reg_no'].'</td>';
                            $subject = $this->get_subject_for_class($id);
                            $subj = count($subject);
                            $i = 1;
                            foreach($record as $r){
                                //$slip .= $subject['subject_name'].': '.$r->score.', ';
                                $echo .= '<td>'.$r->score.'</td>';
                                $i++;
                            }
                            for($i; $i == $subj; $i++){
                                $echo .= '<td>'.null.'</td>';
                            }
                            //$slip = chop($slip,', ');
                            //$details = $slip;//'Score: '.$d->score.' / '.$d->total_score;//' 1st: '.$d->cat_1.' 2nd: '.$d->cat_2.' 3rd: '.$d->cat_3.' <br/>

                            $echo .= '<td> <a href="'.URL.'teacher/result/edit/'.$d->id.'" class="btn btn-info btn-flat">Edit</a></td>';
                            $echo .= '<td> <a href="'.URL.'teacher/result/delete/'.$d->id.'" class="btn btn-danger btn-flat" onclick="return confirm(\'This action cannot be undone... PROCEED?\')">Delete</a></td>';
                            $echo .= '</tr>';
                        }


                    }
                    return array($echo,$students);

                    break;
                case 'delete':
                    $data = $this->db->delete('acad_result_folder',array('id','=',$id));
                    $data = $this->db->delete('academic_records',array('folder_id','=',$id));
                    Session::put('home','Student Record Deleted Successfully');
                    Redirect::to(backToSender());
                    return false;

                    break;
                case 'record':
                    $folder = $this->db->fetch_exact('acad_result_folder','id',$id);

                    $student = $this->db->fetch_exact('academic_students','student_id', $folder['student_id']);

                    $tabs = $this->get_subject_for_class($folder['class_id']);
                    $echo = array();
                    foreach($tabs as $d){
                        $score = $this->db->fetch_exact_two('academic_records','subject_id',$d['subject_id'],'folder_id',$id);
                        if($score){
                            $echo[] = array(
                                'subject_id' => $d['subject_id'],
                                'subject_name' => $d['subject_name'],
                                'subject_score' => $score['score'],
                                'record_id' => $score['record_id'],
                            );

                        }else{
                            $this->db->insert('academic_records',array(
                                'student_id' => trim($folder['student_id']),
                                'subject_id' => trim($d['subject_id']),
                                'folder_id' => $id,
                                'session_id' => Session::get('academic_session_id'),
                                'term_id' => Session::get('academic_term_id'),
                                'class_id' => trim(Session::get('academic_class_id')),

                                'score' => null,

                                'entered_by' => trim(Session::get('user_id')),
                                'date' => $this->today,
                            ));
                            $last = $this->db->last_insert_id();
                            $echo[] = array(
                                'subject_id' => $d['subject_id'],
                                'subject_name' => $d['subject_name'],
                                'subject_score' => null,
                                'record_id' => $last,
                            );
                        }
                    }


                    return array($echo, $student, $folder);

                    break;

                default:
                    $data = $this->db->fetch_exact('academic_records', 'student_id',$id);
                    break;
            }

            return $data;

        }

        public function session_term_start($update = null) {
            $school_id = trim(Input::get('school'));
            try {
                if($update){
                    $this->db->update('academic_sessions', array(
                        'session_name' => trim(Input::get('session_name')),
                        'term' => Input::get('entry_term'),
                        'term_starts' => Input::get('starts'),
                        'term_ends' => trim(Input::get('ends')),
                        'details' => trim(Input::get('details')),
                        'input_by' => trim(Session::get('user_id')),
                        'date' => $this->today,
                    ), 'session_id', $update);
                }else{
                    $this->db->insert('academic_sessions', array(
                        //'school_id' => $school_id,
                        'session_name' => trim(Input::get('session_name')),
                        'input_by' => trim(Session::get('user_id')),
                        'date' => $this->today,
                    ));
                    $session_id = $this->db->last_insert_id();
                    if($session_id){
                        //SELECT `term_id`, ``, ``, `term`, `term_starts`, `term_ends`, `details`, `active`, `input_by`, `date` FROM `` WHERE 1
                        $this->db->insert('academic_terms', array(
                            //'school_id' => $school_id,
                            'session_id' => $session_id,
                            'term' => Input::get('entry_term'),
                            'term_starts' => Input::get('starts'),
                            'term_ends' => trim(Input::get('ends')),
                            'details' => trim(Input::get('details')),
                            'input_by' => trim(Session::get('user_id')),
                            'date' => $this->today,
                        ));
                    }
                }
                cleanUP();
                Session::flash('home', 'Information successfully saved!');

                return true;
            } catch (Exception $e) {
                return false;
            }
        }

        public function add_term_only($update = null) {
            $school_id = trim(Input::get('school'));
            try {
                if($update){
                    $this->db->update('academic_terms', array(
                        //'school_id' => $school_id,
                        'session_id' => Input::get('entry_session'),
                        'term' => Input::get('entry_term'),
                        'term_starts' => Input::get('starts'),
                        'term_ends' => trim(Input::get('ends')),
                        'details' => trim(Input::get('details')),
                        'input_by' => trim(Session::get('user_id')),
                        'date' => $this->today,
                    ), 'term_id', $update);
                }else{
                    $this->db->insert('academic_terms', array(
                        //'school_id' => $school_id,
                        'session_id' => Input::get('entry_session'),
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

        function grading($v){
            $bg = '';
            $remark = '';
            if($v >= 75){
                $bg = 'A';
                $remark = 'Excellent';
            }elseif($v >= 60){
                $bg = 'C';
                $remark = 'V. Good';
            }elseif($v >= 50){
                $bg = 'P';
                $remark = 'Good';
            }elseif($v >= 45){
                $bg = 'P';
                $remark = 'Average';
            }elseif($v >= 40){
                $bg = 'F';
                $remark = 'Fair';
            }elseif($v < 40){
                $bg = 'F';
                $remark = 'Fail';
            }

            return array($bg, $remark);

        }


        public function cumulative_test($reg_no = null,$time = null){
            $time = isset($time)?$time: Session::get('academic_session_id');

            $reg = $this->db->fetch_exact('academic_students','student_id',$reg_no);
            $class = $this->db->fetch_exact('academic_classes', 'class_id',$reg['current_class']);
            Session::put('result_class',$class['class_name']);


            $term = $this->db->get('academic_terms', array('session_id','=',$time),'term','ASC')->results();
            $session = $this->db->fetch_exact('academic_sessions', 'session_id',$time);
            Session::put('result_session',$session['session_name']);

            $all_terms = array();
            $collected = array();

            foreach($term as $t){

                $term_data = $this->db->get('academic_records',array('student_id','=',$reg['student_id'],'term_id','=',$t->term_id))->results();

                if(!$term_data){
                    $subject = $this->db->get('academic_subjects', array('class_id','=',$reg['start_class']))->results();
                    foreach($subject as $s){
                        $all_terms[$s->subject_id][] = array(
                            'student_id' => $reg['student_id'],
                            'subject_id' => $s->subject_id,
                            'session_id' => $time,
                            'term_id' => $t->term_id,
                            'class_id' => $s->class_id,
                            'score' => '',
                        );
                    }
                }
                foreach($term_data as $da){
                    if(empty($da->score)){////exclude empty results
                        if(!in_array($da->subject_id,$collected)){
                            $collected[] = $da->subject_id;
                        }
                        continue;
                    }

                    $all_terms[$da->subject_id][] = array(
                        'student_id' => $da->student_id,
                        'subject_id' => $da->subject_id,
                        'session_id' => $da->session_id,
                        'term_id' => $da->term_id,
                        'class_id' => $da->class_id,
                        'score' => $da->score,
                    );

                }

            }
            foreach($collected as $k => $v){ //remove resultless subjects
                unset($all_terms[$v]);
            }

            //output the result
            $result = array();
            $echo = '';
            $echo .= '<tr>';
            $echo .= '<th rowspan="2" style="width: 10px">#</th>';
            $echo .= '<th rowspan="2" style="text-align: center">Subject</th>';
            $echo .= '<th colspan="3" style="text-align: center">1st Term</th>';
            $echo .= '<th colspan="3" style="text-align: center">2nd Term</th>';
            $echo .= '<th colspan="3" style="text-align: center">3rd Term</th>';
            $echo .= '<th rowspan="2">Total</th>';
            $echo .= '<th rowspan="2">Average</th>';
            $echo .= '<th rowspan="2">Position</th>';
            $echo .= '<th rowspan="2">Grade</th>';
            $echo .= '</tr>';
            $echo .= '<tr>';
            $echo .= '<th>CA</th>';
            $echo .= '<th>Exam</th>';
            $echo .= '<th>Total</th>';
            $echo .= '<th>CA</th>';
            $echo .= '<th>Exam</th>';
            $echo .= '<th>Total</th>';
            $echo .= '<th>CA</th>';
            $echo .= '<th>Exam</th>';
            $echo .= '<th>Total</th>';
            $echo .= '</tr>';
            $echo .= '';
            $x = 1;

            $total_sum = 0;
            foreach($all_terms as $key => $value){
                $subject = $this->db->fetch_exact('academic_subjects', 'subject_id',$key);

                $echo .= '<tr>';
                $echo .= '<td>'.$x.'</td>';
                $x++;
                $echo .= '<td>'.$subject['subject_name'].'</td>';

                $sum = 0;
                foreach($value as $val => $v){
                    $score = strpos($v['score'],',');
                    if($score){
                        $catch = explode(',',$v['score']);
                        $score = '';
                        for($i=0;$i<count($catch)-2;$i++){
                            $echo .= '<td>'.$catch[$i].'</td>';
                        }
                        $echo .= '<td>'.$catch[count($catch)-2].'</td>';
                        $echo .= '<td>'.$catch[count($catch)-1].'</td>';
                        $sum += $catch[count($catch)-1];

                    }else{
                        $echo .= '<td></td>';
                        $echo .= '<td></td>';
                        $echo .= '<td>'.$v['score'].'</td>';
                    }
                }
                $echo .= '<td>'.$sum.'</td>';
                $average = floor($sum/3);
                $echo .= '<td>'.$average.'</td>';
                $total_sum += $average;
                //get position per subject
                $position_subject = $this->db->get('cumulative_per_subject',array('class_id','=',$class['class_id'],'subject_id','=',$subject['subject_id'],'student_id','=',$reg_no))->results();
                $pos = ($this->db->first());

                $echo .= '<td>'.$pos->subject_position.'</td>';
                $echo .= '<td>'.$this->grading($average).'</td>';
                $echo .= '</tr>';

            }
            //get if class is jss or ss divide by 9 or 8 respectively
            if($class['parent_class'] == 'JSS'){
                $divisor = 10;
            }else{
                $divisor = 11;
            }
            //count total no of students in the class
            $students = $this->db->get('academic_students',array('current_class','=',$reg['current_class']));
            $stud = $this->db->count();

            $total_average = floor($total_sum/$divisor);
            $echo .= '<tfoot>';
            $echo .= '<tr>';
            $echo .= '<th colspan="12" class="text-right">Grand Total</th>';
            $echo .= '<th colspan="3" class="text-left">'.$total_sum.'</th>';
            $echo .= '</tr>';
            $echo .= '<tr>';
            $echo .= '<th colspan="12" class="text-right">Total Average</th>';
            $echo .= '<th colspan="3" class="text-left">'.$total_average.'</th>';
            $echo .= '</tr>';
            $echo .= '<tr>';
            $echo .= '<th colspan="5" class="text-right">Total Number of Student\'s in Class</th>';
            $echo .= '<th colspan="3" class="text-left">'.$stud.'</th>';
            $echo .= '<th colspan="4" class="text-right">Overall Position</th>';
            $session_position = $this->db->get('cumulative_per_session',array('class_id','=',$class['class_id'],'student_id','=',$reg_no))->results();
            $post = ($this->db->first());

            $echo .= '<th colspan="3" class="text-left">'.$post->class_position.'</th>';
            $echo .= '</tr>';
            $echo .= '<tr>';
            $echo .= '<th colspan="12" class="text-right">Remark</th>';
            //promotion criteria
            if($total_average > 50){
                $promotion = "Promoted";
            }else{
                $promotion = "Not Promoted";
            }
            $echo .= '<th colspan="3" class="text-left">'.$promotion.'</th>';
            $echo .= '</tr>';
            $echo .= '</tfoot>';
            $echo .= '';

            $folder = '';
            return array($reg, $echo, $folder);

        }



        function addOrdinalNumberSuffix($num) {
            if (!in_array(($num % 100),array(11,12,13))){
                switch ($num % 10) {
                    // Handle 1st, 2nd, 3rd
                    case 1:  return $num.'st';
                    case 2:  return $num.'nd';
                    case 3:  return $num.'rd';
                }
            }
            return $num.'th';
        }

        function annual_result($class){
            $all_students = $this->db->get('result_students', array('current_class','=',$class,'current_session','=',Session::get('academic_session_id')))->results();
            $total_subjects = $this->db->get('academic_subjects', array('class_id','=',$class))->results();
            // compute subject total
            foreach($all_students as $s){
                $totalled = array();

                $results = $this->db->get('results_per_subject_per_student',array('student_id', '=', $s->student_id,'session_id','=', Session::get('academic_session_id'),'class_id','=', ($class)),'total')->results();
                foreach($results as $r){
                    $totalled[$r->subject_id][] = $r->total;
                }
                foreach($totalled as $key => $val){
                    $totally = round(array_sum($totalled[$key]),2);
                    $average = round($totally/3,2);

                    $grade = $this->grading($totally/3);

                    // delete if already exist before insert
                    $exist = $this->db->get('result_per_annual_subject_per_student',array('student_id', '=', $s->student_id,'session_id','=', Session::get('academic_session_id'),'class_id','=', ($class),'subject_id', '=', $key))->results();
                    if($exist){
                        $this->db->delete('result_per_annual_subject_per_student',array('student_id', '=', $s->student_id,'session_id','=', Session::get('academic_session_id'),'class_id','=', ($class),'subject_id', '=', $key));
                    }
                    // get parent class
                    $parent = $this->db->get('academic_classes',array('class_id','=',$class))->first()->super_class;

                    $this->db->insert('result_per_annual_subject_per_student',array(
                        'subject_id' => $key,
                        'student_id' => $s->student_id,
                        'session_id' => Session::get('academic_session_id'),
                        'class_id' => trim($class),
                        'average' => $average,
                        'total' => $totally,
                        'grade' => $grade[0],
                        'remark' => $grade[1],
                        'parent_class' => $parent,

                        'position' => null,
                    ));
                }
            }
            // assign positions to all the students with regards to subjects
            foreach($total_subjects as $t){
                $update = $this->db->get('result_per_annual_subject_per_student',array('class_id','=',$class,'subject_id','=',$t->subject_id,'session_id','=',Session::get('academic_session_id')),'average')->results();
                $session_id = Session::get('academic_session_id');
                $subject_id = $t->subject_id;
                $i = 1;
                $highest = $this->db->first()->average;
                $lowest = $this->db->last()->average;
                $average = array();
                $wanted = '';
                $last_total = '';
                $last_ordinate = '';
                foreach($update as $jet){
                    $average[] = $jet->average;
                    // allow more than 2 people to be first
                    if($jet->average == $last_total){
                        $sql = $this->db->pumpUpdate('result_per_annual_subject_per_student',array(
                            'position' => $last_ordinate,
                        ),array('student_id','=',$jet->student_id,'class_id','=',$class,'subject_id','=',$subject_id,'session_id','=',$session_id));
                    }else{
                        $last_total = $jet->average;
                        $ordinate = $this->addOrdinalNumberSuffix($i);
                        $sql = $this->db->pumpUpdate('result_per_annual_subject_per_student',array(
                            'position' => $ordinate,
                        ),array('student_id','=',$jet->student_id,'class_id','=',$class,'subject_id','=',$subject_id,'session_id','=',$session_id));
                        $last_ordinate = $ordinate;
                    }
                    $i++;

                }

                $average = round(array_sum($average)/count($average),1);

                $check = $this->db->get('results_per_annual_subject_highest_lowest',array('class_id','=',$class,'subject_id','=',$subject_id,'session_id','=',$session_id))->results();
                if($check){
                    $sql = $this->db->pumpUpdate('results_per_annual_subject_highest_lowest',array(
                        'highest' => $highest,
                        'lowest' => $lowest,
                        'average' => $average,
                        'entered_by' => (Session::get('user_id')),
                        'date' => $this->today,
                    ),array('class_id','=',$class,'subject_id','=',$subject_id,'session_id','=',$session_id));
                }else{
                    $this->db->insert('results_per_annual_subject_highest_lowest',array(
                        'subject_id' => $subject_id,
                        'session_id' => Session::get('academic_session_id'),
                        'class_id' => $class,
                        'highest' => $highest,
                        'lowest' => $lowest,
                        'average' => $average,
                        'entered_by' => (Session::get('user_id')),
                        'date' => $this->today,
                    ));

                }

            }
            // compute annual for student
            foreach($all_students as $s){
                $totalled = array();
                $subject_ids = '';
                $subject_scores = '';

                $results = $this->db->get('result_per_annual_subject_per_student',array('student_id', '=', $s->student_id,'session_id','=', Session::get('academic_session_id'),'class_id','=', ($class)))->results();
                foreach($results as $r){
                    $totalled[] = $r->average;
                    $subject_ids .= $r->subject_id.', ';
                    $subject_scores .= $r->average.', ';
                }
                $subject_ids = chop($subject_ids,', ');
                $subject_scores = chop($subject_scores,', ');

                $super_class = $this->db->fetch_exact('academic_classes', 'class_id',$class);
                //get if class is jss or ss divide by 9 or 8 respectively
                if($super_class['parent_class'] == 'JSS'){
                    $divisor = 10;
                }else{
                    $divisor = 11;
                }
                $totally = round((array_sum($totalled)),2);
                $average = round($totally/$divisor,2);

                $comment = $this->comment_generator($totalled,$subject_ids);

                // delete if already exist before insert
                $exist = $this->db->get('result_per_annual_per_student',array('student_id', '=', $s->student_id,'session_id','=', Session::get('academic_session_id'),'class_id','=', ($class)))->results();
                if($exist){
                    $this->db->delete('result_per_annual_per_student',array('student_id', '=', $s->student_id,'session_id','=', Session::get('academic_session_id'),'class_id','=', ($class)));
                }
                $this->db->insert('result_per_annual_per_student',array(
                    'student_id' => $s->student_id,
                    'session_id' => Session::get('academic_session_id'),
                    'class_id' => trim($class),

                    'total' => $totally,
                    'position' => null,
                    'average' => $average,
                    'subjects' => $subject_ids,
                    'subject_scores' => $subject_scores,
                    'comment' => $comment,

                    'date' => $this->today,
                ));


            }
            //now assign annual position to all of them
            $position = $this->update_annual_position($class,Session::get('academic_session_id'));

            Session::put('home','Successfully carried out Annual Result Computation');

            return true;

        }

        public function cumulative_compute($reg_no = null,$time = null){
            $time = isset($time)? $time : Session::get('academic_session_id');

            $reg = $this->db->fetch_exact('academic_students','student_id',$reg_no);
            $class = $this->db->fetch_exact('academic_classes', 'class_id',$reg['current_class']);

            $term = $this->db->get('academic_terms', array('session_id','=',$time),'term','ASC')->results();

            $all_terms = array();
            $collected = array();

            foreach($term as $t){

                $term_data = $this->db->get('academic_records',array('student_id','=',$reg['student_id'],'term_id','=',$t->term_id))->results();

                if(!$term_data){
                    $subject = $this->db->get('academic_subjects', array('class_id','=',$reg['start_class']))->results();
                    foreach($subject as $s){
                        $all_terms[$s->subject_id][] = array(
                            'student_id' => $reg['student_id'],
                            'subject_id' => $s->subject_id,
                            'session_id' => $time,
                            'term_id' => $t->term_id,
                            'class_id' => $s->class_id,
                            'score' => '',
                        );
                    }
                }
                foreach($term_data as $da){
                    if(empty($da->score)){////exclude empty results
                        if(!in_array($da->subject_id,$collected)){
                            $collected[] = $da->subject_id;
                        }
                        continue;
                    }

                    $all_terms[$da->subject_id][] = array(
                        'student_id' => $da->student_id,
                        'subject_id' => $da->subject_id,
                        'session_id' => $da->session_id,
                        'term_id' => $da->term_id,
                        'class_id' => $da->class_id,
                        'score' => $da->score,
                    );

                }

            }
            foreach($collected as $k => $v){ //remove resultless subjects
                unset($all_terms[$v]);
            }


            $final = array();
            $total_sum = 0;
            $student_id = '';
            foreach($all_terms as $key => $value){
                $subject = $this->db->fetch_exact('academic_subjects', 'subject_id',$key);

                $subject_id = $subject['subject_id'];
                $subject_name = $subject['subject_name'];

                $sum = 0;
                $i = 1;
                foreach($value as $val => $v){
                    $student_id = $v['student_id'];
                    $term[$i] = isset($v['score']) ? $v['score'] : 0;
                    $score = strpos($v['score'],',');
                    if($score){
                        $catch = explode(',',$v['score']);
                        $sum += is_numeric($catch[count($catch)-1]) ? $catch[count($catch)-1]: 0;
                    }else{
                        $term[$i] = 0;

                    }
                    $i++;
                }
                $g = count($value);
                for($g; $g <= 3;$g++){
                    $term[$g] = 0;

                };

                $average = floor($sum/3);
                $total_sum += $average;
                $grading = $this->grading($average);

                $final[$key][] = array(
                    'session_id' => $time,
                    'student_id' => $student_id,
                    'subject_id' => $subject_id,
                    'subject_name' => $subject_name,
                    'first_term' => $term[1],
                    'second_term' => $term[2],
                    'third_term' => $term[3],
                    'sum' => $sum,
                    'average' => $average,
                    'grading' => $grading,
                );
            }


            //get if class is jss or ss divide by 9 or 8 respectively
            if($class['parent_class'] == 'JSS'){
                $divisor = 10;
            }else{
                $divisor = 11;
            }

            $total_average = floor($total_sum/$divisor);
            //promotion criteria
            if($total_average > 50){
                $promotion = "Promoted";
            }else{
                $promotion = "Not Promoted";
            }

            $cumulative = array(
                'session_id' => $time,
                'student_id' => $student_id,
                'total' => $total_sum,
                'average' => $total_average,
                'promoted' => $promotion,
            );

            return array($final, $cumulative);

        }

        public function run_cumulative($class){
            //get all students of the classes
            $classes = $this->db->get('academic_students',array('current_class','=',$class))->results();
            //run each student through the cumulative compute
            $result = array();
            $cumulative = array();
            foreach($classes as $c){
                list($result[], $cumulative[]) = $this->cumulative_compute($c->student_id);

            }
            foreach($result as $rest){
                foreach($rest as $r){

                    $sql = $this->db->insert('cumulative_per_subject',array(
                        'session_id' => $r[0]['session_id'],
                        'student_id' => $r[0]['student_id'],
                        'subject_id' => $r[0]['subject_id'],
                        'subject_name' => $r[0]['subject_name'],
                        'first_term' => $r[0]['first_term'],
                        'second_term' => $r[0]['second_term'],
                        'third_term' => $r[0]['third_term'],
                        'sum' => $r[0]['sum'],
                        'average' => $r[0]['average'],
                        'grading' => $r[0]['grading'],
                        'class_id' => $class,
                        //'parent_class' => $r['parent_class'],
                    ));

                }
            }
            foreach($cumulative as $cum){
                $sql = $this->db->insert('cumulative_per_session',array(
                    'class_id' => $class,
                    'session_id' => $cum['session_id'],
                    'student_id' => $cum['student_id'],
                    //'parent_class' => $cum['parent_class'],
                    'total' => $cum['total'],
                    'average' => $cum['average'],
                    'promoted' => $cum['promoted'],
                ));
            }
            //assign position per session
            //set maximum execution time
            ini_set('max_execution_time',300); //300 seconds == 5 minutes
            $session = $this->db->get('cumulative_per_session',array('class_id','=',$class),'average')->results();
            $i = 1;
            foreach($session as $s){
                $ordinal = $this->addOrdinalNumberSuffix($i);
                $sql = $this->db->update('cumulative_per_session',array(
                    'class_position' => $ordinal,
                ),'student_id',$s->student_id);
                $i++;
            }

            $sub = $this->db->get('academic_subjects', array('class_id','=',$class))->results();
            foreach($sub as $s){
                $subject = $this->db->get('cumulative_per_subject',array('class_id','=',$class,'subject_id','=',$s->subject_id),'average')->results();
                $i = 1;
                foreach($subject as $jet){
                    $ordinate = $this->addOrdinalNumberSuffix($i);
                    $sql = $this->db->pumpUpdate('cumulative_per_subject',array(
                        'subject_position' => $ordinate,
                    ),array('student_id','=',$jet->student_id,'subject_id','=',$s->subject_id));
                    $i++;
                }
            }

            return true;

        }



        public function cumulative_result($reg_no = null,$time = null){
            $time = isset($time)?$time: Session::get('academic_session_id');

            $reg = $this->db->fetch_exact('academic_students','student_id',$reg_no);


            $term = $this->db->get('academic_terms', array('session_id','=',$time),'term','ASC')->results();

            //check if cumulative for that session of the student is available
            $available = $this->db->get('academic_terms', array('session_id','=',$time),'term','ASC')->results();

            if($available){
                $result = array();
                $echo = '';
                $echo .= ' <tr>';
                $echo .= '<th rowspan="2" style="width: 10px">#</th>';
                $echo .= '<th rowspan="2" style="text-align: center">Subject</th>>';
                $echo .= '<th colspan="3" style="text-align: center">1st Term</th>';
                $echo .= '<th colspan="3" style="text-align: center">2nd Term</th>';
                $echo .= '<th colspan="3" style="text-align: center">3rd Term</th>';
                $echo .= '<th rowspan="2">Total</th>';
                $echo .= '<th rowspan="2">Average</th>';
                $echo .= '<th rowspan="2">Position</th>';
                $echo .= '<th rowspan="2">Grade</th>';
                $echo .= '<th style="text-align: center">Highest </th>';
                $echo .= '<th style="text-align: center">Lowest </th>';
                $echo .= '</tr>';
                $echo .= '<tr>';
                $echo .= '<th>CA(40)</th>';
                $echo .= '<th>Exam</th>';
                $echo .= '<th>Total</th>';
                $echo .= '<th>CA(40)</th>';
                $echo .= '<th>Exam</th>';
                $echo .= '<th>Total</th>';
                $echo .= '<th>CA(40)</th>';
                $echo .= '<th>Exam</th>';
                $echo .= '<th>Total</th>';
                $echo .= '<th>Score</th>';
                $echo .= '<th>Score</th>';
                $echo .= '</tr>';
                $echo .= '';
                $x = 1;
                foreach($term as $t){
                    $folder = $this->db->fetch_exact_two('acad_result_folder','term_id',$t->term_id,'student_id',$reg['student_id']);
                    //echo('<pre>');
                    //print_r($term);
                    //die();


                    $data = $this->db->get('academic_records',array('student_id','=',$reg['student_id'],'term_id','=',$t->term_id))->results();
                    $echo .= '<tr>';
                    foreach($data as $d){
                        $class = $this->db->fetch_exact('academic_classes', 'class_id',$d->class_id);
                        Session::put('result_class',$class['class_name']);
                        $subject = $this->db->fetch_exact('academic_subjects', 'subject_id',$d->subject_id);
                        $term = $this->db->fetch_exact('academic_terms', 'term_id',$time);
                        Session::put('result_term',$term['term']);
                        $session = $this->db->fetch_exact('academic_sessions', 'session_id',$term['session_id']);
                        Session::put('result_session',$session['session_name']);

                        if(empty($d->score)){continue; }//exclude empty results

                        //build table for result
                        $echo .= '<td>'.$x.'</td>';
                        $x++;

                        $echo .= '<td>'.$subject['subject_name'].'</td>';

                        $score = strpos($d->score,',');
                        if($score){
                            $catch = explode(',',$d->score);
                            $score = '';
                            for($i=0;$i<count($catch)-2;$i++){
                                $echo .= '<td>'.$catch[$i].'</td>';
                            }
                            $echo .= '<td>'.$catch[count($catch)-2].'</td>';
                            $echo .= '<td>'.$catch[count($catch)-1].'</td>';
                        }else{
                            $echo .= '<td></td>';
                            $echo .= '<td></td>';
                            $echo .= '<td>'.$d->score.'</td>';
                        }
                        $echo .= '</tr>';

                        $result[] = array(
                            'parent_class' => $class['parent_class'],
                            'class' => $class['class_name'],
                            'session_name' => $session['session_name'],
                            'term' => $term['term'],
                            'subject_name' => $subject['subject_name'],
                            'score' => $score,
                            'total_score' => $d->total_score,
                            'record_id' => $d->record_id,
                            'term_id' => $d->term_id,
                            'class_id' => $d->class_id,
                            'student_id' => $d->student_id,
                        );
                    }

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
                $echo .= '<th class="text-left">'.$folder['average'].'</th>';
                $echo .= '<th class="text-right">Position</th>';
                $echo .= '<th class="text-left">'.$folder['position'].'</th>';
                $echo .= '<th class="text-right">Promoted</th>';
                $echo .= '<th class="text-left">'.$folder['promoted'].'</th>';
                $echo .= '</tr>';

                return array($reg, $echo, $folder);
            }else{
                Session::flash('error','No record found for this person at this time');
                Redirect::to(backToSender());
                return false;
            }



        }

        function resumptionCreator($class = 0){
            $this->db->insert('resumption', array(
                'session_id' => Input::get('entry_session'),
                'term_id' => Input::get('entry_term'),
                'date' => Input::get('datepicker'),
                'class_id' => $class,
                'note' => Input::get('note'),
            ));
        }

        function schoolFeesCreator($class = 0){
            $this->db->insert('school_fees', array(
                'session_id' => Input::get('entry_session'),
                'term_id' => Input::get('entry_term'),
                'amount' => Input::get('amount'),
                'class_id' => $class,
                'note' => Input::get('note'),
            ));
        }

        public function comment_generator($scores = array(), $subject_id){
            $count = count($scores);
            $comment = '';
            $subject_id = explode(',',$subject_id);
            $a = array();
            $b = array();
            $c = array();
            $d = array();
            $e = array();

            for($i=0; $i <= ($count-1); $i++){
                if($scores[$i] >= 70){
                    $a[] = $subject_id[$i];
                }elseif($scores[$i] >= 60 && $scores[$i] < 70){
                    $b[] = $subject_id[$i];
                }elseif($scores[$i] >= 50 && $scores[$i] < 60){
                    $c[] = $subject_id[$i];
                }elseif($scores[$i] >= 40 && $scores[$i] < 50){
                    $d[] = $subject_id[$i];
                }elseif($scores[$i] < 40){
                    $e[] = $subject_id[$i];
                }
            }
            $f = (count($e)+count($d));
            // the mediums
            if(count($c) >= ($count/2)){
                $comment = 'Average Overall performance.'."\n";
            }elseif(count($b) > 2 && !count($a) && !$f){
                $comment = 'Nice, above average performance.'."\n";
            }elseif(count($c)){
                $comment .= ' Average Performance in '.$this->get_subject($c[0],1);
                if(count($c) > 1){
                    $comment .= ' and '.$this->get_subject($c[1],1);
                }
                $comment .= '.'."\n";
            }
            // the negatives
            if($f >= ($count/2) && !count($a) && !count($b)){
                $comment = 'Fair Overall performance.'."\n";
            }elseif($f >= 2){
                $comment = 'Below Average Performance, you have got more work to do.'."\n";
            }elseif(count($d) && !count($e)){
                $comment .= ' Below Average Performance in '.$this->get_subject($d[0],1);
                if(count($d) > 1){
                    $comment .= ' and '.$this->get_subject($d[1],1);
                }
                $comment .= '.'."\n";
            }elseif(count($e)){
                $comment .= ' Fair Performance in '.$this->get_subject($e[0],1);
                if(count($e) > 1){
                    $comment .= ' and '.$this->get_subject($e[1],1);
                }
                $comment .= '.'."\n";
            }
            // the positives
            if(count($a) >= ($count/2)){
                $previous = (!empty($comment))? ' Otherwise, ':' ';
                $comment .= $previous.'Fantastic Overall Performance. KEEP IT UP!'."\n";
            }elseif(count($a) > 2 && !count($d) && !count($e)){
                $comment .= 'Excellent Performance! Bring on more...'."\n";
            }elseif(count($a)){
                $comment .= 'Excellent Performance in '.$this->get_subject($a[0],1);
                if(count($a) > 1){
                    $comment .= ' and '.$this->get_subject($a[1],1);
                }
                $comment .= '.'."\n";
            }

            if((empty($comment) || count($c) || count($b))){
                $comment .= ' Well done, but there\'s still room for improvement';
            }

            return $comment;
        }


        public function check_result($reg_no = null,$time = null){
            $time = isset($time)?$time: Session::get('academic_term_id');

            $reg = $this->db->fetch_exact('result_students','student_id',$reg_no);

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

        public function check_cumulative($reg_no = null,$time = null){
            $time = isset($time)?$time: Session::get('academic_session_id');

            $reg = $this->db->fetch_exact('result_students','student_id',$reg_no);

            $data = $this->db->get('result_per_annual_subject_per_student',array('student_id','=',$reg['student_id'],'session_id','=',$time),'total')->results();

            $folder = $this->db->fetch_exact_two('result_per_annual_per_student','session_id',$time,'student_id',$reg['student_id']);
            //set the session, session and class
            $class_ave = $this->db->fetch_exact_two('result_per_class_per_annual','class_id',$reg['current_class'],'session_id',$time);

            if($folder){
                $result = array();

                $echo = '';
                $echo .= '<tr>';
                $echo .= '<th rowspan="2" style="width: 10px">#</th>';
                $echo .= '<th rowspan="2" style="text-align: center">Subject</th>';
                $echo .= '<th colspan="3" style="text-align: center">1st Term</th>';
                $echo .= '<th colspan="3" style="text-align: center">2nd Term</th>';
                $echo .= '<th colspan="3" style="text-align: center">3rd Term</th>';
                $echo .= '<th rowspan="2">Total</th>';
                $echo .= '<th rowspan="2">Average</th>';
                $echo .= '<th rowspan="2">Position</th>';
                $echo .= '<th rowspan="2">GP</th>';
                $echo .= '<th rowspan="2">Remark</th>';
                //$echo .= '<th rowspan="2">Class Lowest</th>';
                //$echo .= '<th rowspan="2">Class Highest</th>';
                //$echo .= '<th rowspan="2">Class Average</th>';
                $echo .= '</tr>';
                $echo .= '<tr>';
                $echo .= '<th>CA</th>';
                $echo .= '<th>Exam</th>';
                $echo .= '<th>Total</th>';
                $echo .= '<th>CA</th>';
                $echo .= '<th>Exam</th>';
                $echo .= '<th>Total</th>';
                $echo .= '<th>CA</th>';
                $echo .= '<th>Exam</th>';
                $echo .= '<th>Total</th>';
                $echo .= '</tr>';
                $echo .= '';

                $echo .= '<tr>';
                $x = 1;
                foreach($data as $d){
                    $class = $this->db->fetch_exact('academic_classes', 'class_id',$d->class_id);
                    Session::put('result_class',$class['class_name']);
                    $subject = $this->db->fetch_exact('academic_subjects', 'subject_id',$d->subject_id);
                    //$term = $this->db->fetch_exact('academic_terms', 'term_id',$time);
                    //Session::put('result_term',$term['term']);
                    $session = $this->db->fetch_exact('academic_sessions', 'session_id',$time);
                    Session::put('result_session',$session['session_name']);

                    $low_high_ave = $this->db->get('results_per_annual_subject_highest_lowest', array('class_id','=',$d->class_id,'subject_id','=',$d->subject_id,'session_id','=',$d->session_id));
                    $low_high_ave = $this->db->first();
                    if(empty($d->total)){continue; }//exclude empty results

                    //build table for result
                    $echo .= '<td>'.$x.'</td>';
                    $x++;

                    $echo .= '<td>'.$subject['subject_name'].'</td>';
                    //get individual termly result here
                    $term = $this->db->get('academic_terms', array('session_id','=',$time),'term','ASC')->results();
                    foreach($term as $t){
                        $term_data = $this->db->get('results_per_subject_per_student',array('student_id','=',$reg['student_id'],'term_id','=',$t->term_id,'class_id','=',$d->class_id,'subject_id','=',$d->subject_id))->results();
                        foreach($term_data as $da){
                            if(empty($da->total)){////exclude empty results
                                $echo .= '<td></td>';
                                $echo .= '<td></td>';
                                $echo .= '<td></td>';
                            }else{
                                $echo .= '<td>'.$da->ca.'</td>';
                                $echo .= '<td>'.$da->exam.'</td>';
                                $echo .= '<td>'.$da->total.'</td>';
                            }
                        }

                    }

                    $echo .= '<td>'.$d->total.'</td>';
                    $echo .= '<td>'.$d->average.'</td>';
                    $echo .= '<td>'.$d->position.'</td>';
                    $echo .= '<td>'.$d->grade.'</td>';
                    $echo .= '<td>'.$d->remark.'</td>';
                    //$echo .= '<td>'.$low_high_ave->lowest.'</td>';
                    //$echo .= '<td>'.$low_high_ave->highest.'</td>';
                    //$echo .= '<td>'.$low_high_ave->average.'</td>';

                    $echo .= '</tr>';

                    $result[] = array(
                        'parent_class' => $class['parent_class'],
                        'class' => $class['class_name'],
                        'session_name' => $session['session_name'],
                        'subject_name' => $subject['subject_name'],
                        'score' => $d->total,
                        'total_score' => $d->total,
                        'record_id' => $d->id,
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
                $echo .= '<th class="text-right">Overall Position</th>';
                $echo .= '<th class="text-left">'.$folder['position'].' out of   '.$class_ave['class_total_students'].'</th>';
                $echo .= '</tr>';
                $echo .= '<tr>';
                $echo .= '<th colspan="7" class="text-right">Promotion Status</th>';
                //promotion criteria
                if($folder['average'] > 50){
                    $promotion = "Promoted";
                }else{
                    $promotion = "Not Promoted";
                }
                $echo .= '<th class="text-left">'.$promotion.'</th>';
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

        function generate_pins($id){
            $pdf = '';
            switch(strlen($id)){ //generate good serial no
                case 1:
                    $id = "000$id";
                    break;
                case 2:
                    $id = "00$id";
                    break;
                case 3:
                    $id = "0$id";
                    break;
                default:
                    $id = "$id";
                    break;
            }
            for($i=1; $i<101; $i++){
                $card = Hash::randomDigits(6);

                $data = $this->db->fetch_exact('result_pins', 'code',$card);
                if($data){
                    //do nothing
                }else{
                    $serial = $id.'/'.time().'/'.$i;
                    $order = time();

                    $this->db->insert('result_pins', array(
                        'code' => trim($card),
                        'order_no' => ($order),
                        'serial_no' => ($serial),
                        'date_created' => $this->today,
                    ));
                    //after insert, add to pdf array
                    //$pdf .= array($card,$order,$serial);
                    $pdf .= '<ul><li  class="pin"> PIN:  '.$card.'</li><li> S/N: '.$serial.'</li><li>Ord: '.$order.'</li></ul>';
                }

            }

            return $pdf;
        }

        public function account(){
            $data = $this->db->fetch_exact('info_staff','user_id', Session::get('user_id'));
            return $data;
        }

        public function add_school($update = null,$upload = null) {
            $slug = Input::get('slug');
            $ca = Input::get('no_of_ca');

            try {
                if($update){
                    $data =  $this->db->fetch_exact('schools', 'school_id',$update);

                    $this->db->update('schools', array(
                        'school_name' => trim(Input::get('sch_name')),
                        'details' => trim(Input::get('details')),
                        'slug' => $slug,
                        'no_of_ca' => $ca,
                        'state_located' => Input::get('state_located'),
                        'inputed_by' => Session::get('user_id'),
                        'address' => trim(Input::get('address')),
                        'date' => $this->today,
                        'logo' => $upload,
                    ), 'school_id', $update);


                }else{
                    $this->db->insert('schools', array(
                        'school_name' => trim(Input::get('sch_name')),
                        'details' => trim(Input::get('details')),
                        'slug' => $slug,
                        'no_of_ca' => $ca,
                        'state_located' => Input::get('state_located'),
                        'inputed_by' => Session::get('user_id'),
                        'address' => trim(Input::get('address')),
                        'date' => $this->today,
                        'logo' => $upload,
                    ));

                }



                cleanUP();
                Session::flash('home', 'Information successfully saved!');

                return true;
            } catch (Exception $e) {
                return false;

                //redirect user to specific page saying oops
                //die($e->getMessage());
            }
        }



    }
