<?php

    class Teacher extends Controller {

        function __construct() {
            parent::__construct();

            if(!isset($_SESSION['maxfiles'])){
                $_SESSION['maxfiles'] = ini_get('max_file_uploads');
                $_SESSION['postmax'] = Upload::convertToBytes(ini_get('post_max_size'));
                $_SESSION['displaymax'] = Upload::convertFromBytes($_SESSION['postmax']);
            }
            $logged = Session::get('loggedIn');
            if ($logged == false || Session::get('role') !== 'teacher') {
                Redirect::to(URL.'login');
            }
            $this->view->generalJS = array('custom/js/ajax.js');



        }

        function index(){
            list($this->view->student,$this->view->subject,$this->view->class,$this->view->result) = $this->model->get_summary();

            $role = (Session::exists('role'))? Session::get('role'): 'School Admin';
            //$this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
            //$this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
            //$this->view->js = array('teacher/js/ui.js');
            $this->view->js = array('teacher/js/slug_gen.js','result/js/school.js');
            $this->view->generalJS = array('ajax.js','upload_check.js');

            $this->view->sessions = $this->model->started_sessions(1);

            $this->view->title = 'School Board ';
            $this->view->render('teacher/index', 'admin');
        }

        function set_active(){
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'entry_session' => array(
                        'name' => 'Session',
                        'required' => true,
                    ),
                    'entry_term' => array(
                        'name' => 'Term',
                        'required' => true,
                    ),
                ));
                if ($validation->passed()) {
                    $this->model->set_active();
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
            Redirect::to(backToSender());
        }

        function add_students($class = null){
            $this->view->students = $this->model->get_student_in_class($class);
            //check if cumulative has been computed
            $this->view->students = $this->model->get_student_in_class($class);
            $this->view->title = 'Student Record';
            $this->view->render('teacher/student_entry', 'admin');
        }
        function add_subjects($class = null){
            $this->view->subject = $this->model->get_subject_for_class($class);
            $this->view->title = 'Student Record';
            $this->view->render('teacher/subject_per_class', 'admin');
        }

        function preview($class = null){
            $this->view->students = $this->model->printer($class); 
            $this->view->url = $class;
            $this->view->title = 'Preview Record';
            $this->view->render('teacher/preview', 'admin');
        }

        function annual($class = 1){
            $this->view->students = $this->model->annual($class);
            $this->view->url = $class;
            $this->view->title = 'Preview Annual';
            $this->view->render('teacher/preview_annual', 'admin');
        }
        function print_annual($class = 1){
            $this->view->students = $this->model->annual($class);
            $this->view->url = $class;
            $this->view->title = 'Preview Record';
            $this->view->render('teacher/print_annual', 'none');
        }


        function printer($class = null){
            $this->view->students = $this->model->printer($class);

            $this->view->title = 'Student Academic Record';
            $this->view->render('teacher/print', 'none');
        }
        function excel_doc($class = null){
            $this->view->students = $this->model->excel_doc($class);

            $this->view->title = 'Student Academic Record';
            $this->view->render('teacher/print', 'none');
        }

        function generate_pdf($class = null){
            $data = $this->model->printer($class, true);
            $this->convert_to_pdf($data);
            $this->view->students = $data;

            $this->view->title = 'Student Academic Record';
            $this->view->render('teacher/print', 'none');
        }

        function generate_annual_pdf($class = null){
            $data = $this->model->annual($class);
            $this->convert_to_pdf($data, true);
            $this->view->students = $data;

            $this->view->title = 'Student Academic Record';
            $this->view->render('teacher/print', 'none');
        }


        function convert_to_pdf($data, $annual = false){
            // Include the main TCPDF library (search for installation path).
            if($annual){
                include('public/TCPDF-master/annualpdf.php');
            }else{
                include('public/TCPDF-master/mypdf.php');
            }

            // create new PDF document
            $pdf = new MYPDF('L', PDF_UNIT, 'A3', true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('School Portal');
            $pdf->SetTitle('School Education Omni bus/ Data sheet');
            $pdf->SetSubject('Result Publication');
            $pdf->SetKeywords('School, Education, result, test, exam');

            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 048', PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
    
            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

            // ---------------------------------------------------------

            // set font
            $pdf->SetFont('helvetica', 'B', 20);

            // add a page
            $pdf->AddPage();

            $pdf->Write(0, "Anglican Girl's Secondary School Nnewi", '', 0, 'L', true, 0, false, false, 0);

            $pdf->SetFont('helvetica', '', 8);

            // -----------------------------------------------------------------------------

            $subjects = Session::get('total_subjects');
            $students = Session::get('total_students');

            $html = '<h2>Report Summary:</h2><hr/>
                    <table border="1" cellspacing="3" cellpadding="4">
                        <tr>
                            <th colspan="2">  Instruction Methods:</th>
                            <th colspan="2">  Summary:</th>
                        </tr>
                        <tr>
                            <td colspan="2" rowspan="2">Form Teacher Name/ Phone No:</td>
                            <th>Broadsheet:</th>
                            <td>'.$subjects.' Subjects</td>
                        </tr>

                        <tr>
                            <th>Total:</th>
                            <td>'.$students.' Students</td>
                        </tr>
                        <tr>
                            <td colspan="4">Signature</td>
                        </tr>
                    </table>';
            $tbl = <<<EOD
                <table border="1" nobr="true" align="center">$data</table>
                $html

EOD;

            $pdf->writeHTML($tbl, true, false, false, false, '');

// -----------------------------------------------------------------------------


//Close and output PDF document
            $name = Session::get('academic_class_name').' '.Session::get('academic_session_name').' :  '.Session::get('academic_term_name').'  Term ';

            $pdf->Output($name.'omnibus_for_class.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

        }

        function design(){
            $this->view->title = "Cumulative Statement of Result - School Portal";
            $this->view->render('result/cumulative','none');
        }
        function settings($page = 'index'){
            switch($page){
                case 'resumption':
                    $this->view->resumption = $this->model->resumption();
                    break;
                case 'fees':
                    $this->view->fees = $this->model->school_fees();
                    break;
            }
            $this->view->sessions = $this->model->started_sessions(1);
            $this->view->terms = $this->model->started_terms(1);
            $this->view->class = $this->model->get_class();

            $this->view->title = "School Wide settings";
            $this->view->cssPlugin = array('select2/select2.min.css');
            $this->view->jsPlugin = array('select2/select2.full.min.js');
            $this->view->js = array('teacher/js/settings.js');
            $this->view->render('teacher/settings/'.$page,'admin');
        }

        function delete_setting($page, $id){
            switch($page){
                case 'resumption':
                    $this->model->delete_resumption($id);
                    break;
                case 'fees':
                    $this->model->delete_school_fees($id);
                    break;
            }
            Redirect::to(backToSender());
        }

        function resumptionCreator($how){
            if(Input::exists()){
                $this->model->resumptionCreator(Input::get('classes'));
            }
        }

        function schoolFeesCreator($how){
            if(Input::exists()){
                $this->model->schoolFeesCreator(Input::get('classes'));
            }
        }

        function check_result($id = null){
            list($this->view->name,$this->view->result,$this->view->folder) = $this->model->check_result($id);;
            $this->view->resumption = $this->model->resumption();
            $this->view->school_fees = $this->model->school_fees();
            $this->view->title = "Statement of Result - School Portal";
            $this->view->render('result/result','none');

        }

        function cumulative_result($id = null){
            list($this->view->name,$this->view->result,$this->view->folder) = $this->model->check_cumulative($id);
            $this->view->resumption = $this->model->resumption();
            $this->view->school_fees = $this->model->school_fees();
            $this->view->title = "Cumulative Statement of Result - School Portal";
            $this->view->render('result/result_cum','none');

        }

        function run_cumulative($id = null){
            list($this->view->name,$this->view->result,$this->view->folder) = $this->model->annual_result($id);
            $this->view->title = "Cumulative Statement of Result - School Portal";
            Redirect::to(backToSender());
            //$this->view->render('result/cumulative_ran','none');

        }


        function student($action = null, $id = null){
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'student_name' => array(
                        'name' => 'Full Name of Student',
                        'required' => true,
                    ),
                    'phone_no' => array(
                        'name' => 'Phone Number',
                    ),
                    'select_sex' => array(
                        'name' => 'Sex',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'Details',
                    ),
                ));
                if ($validation->passed()) {
                    $this->model->add_student_record();
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
            $this->view->students = $this->model->get_student_record();

            //$page = (isset($action))? 'student_entry': 'new_student_entry';
            $this->view->js = array('teacher/js/search.js');
            $this->view->title = 'Teacher - Student Record';
            $this->view->render('teacher/student_entry', 'admin');
        }


        function upload($max, $folder, $step) {
            //echo($max);
            $result = array();

            //upload
            $destination = UPLOAD_PATH . $folder;
            $upload = new Upload($destination);
            $upload->setMaxSize($max);
            $upload->allowAllTypes();
            $upload->upload();
            foreach ($upload->getMessages() as $msg) {
                $result[] = $msg;
            }
            //if the sub-folder doesn't exist yet create it
            if (!is_dir($destination)) {
                mkdir($destination);
            }
            $path = $upload->fileName();

            if (!isset($path)) {
                $result[] = "Please Upload an Image file";
                $path = NULL;
                $output = "<p class=\"errors\"> ";
                $output .= "Please review the following fields: <br />";
                foreach ($result as $error) {
                    $output .= " - " . $error . "<br />";
                }
                $output .= "</p>";
                Session::put('error', $output);
                Redirect::to(URL.'teacher/account');

                return false;
            } else {
                $resize = new Resize($destination.$path);
                $resize->resizeImage(215, 215, 'exact');
                $resize->saveImage($destination.$path, 100);
                return $path;
            }
        }

        function subject($action = null, $id = null){
            if($action && $id){
                switch($action){
                    case 'update':
                        $this->view->subject = $this->model->get_subject($id);
                        $this->view->class = $this->model->get_class();
                        break;
                    case 'hide':
                        $this->model->hide_about('hide',$id);
                        $this->view->about = $this->model->get_about();
                        break;
                    case 'show':
                        $this->model->hide_about('show',$id);
                        $this->view->about = $this->model->get_about();
                        break;
                    case 'delete':
                        $this->model->hide_about('delete',$id);
                        $this->view->about = $this->model->get_about();
                        break;
                }
            }else{
                $this->view->subject = $this->model->get_subject();
                $this->view->class = $this->model->get_class();

            }

            $page = ($action === 'update')? 'update_subject': 'subject_create';
            $this->view->cssPlugin = array('select2/select2.min.css');

            $this->view->jsPlugin = array('select2/select2.full.min.js');
            $this->view->js = array('teacher/js/creator.js');

            $this->view->title = 'Teacher - Subjects';
            $this->view->render('teacher/'.$page, 'admin');
        }

        function classSubjectCreator($how){
            if(Input::exists()){
                $this->model->classSubjectCreator($how);
            }
        }

        function classes($action = null, $id = null){
            if($action && $id){
                switch($action){
                    case 'update':
                        $this->view->classes = $this->model->get_class($id);
                        break;
                }
            }
            $this->view->class = $this->model->get_class();

            $page = ($action === 'update')? 'update_class': 'class_create';
            $this->view->js = array('teacher/js/creator.js');

            $this->view->title = 'Teacher - Classes';
            $this->view->render('teacher/'.$page, 'admin');
        }

        function create_class($update = null) {
            //@Task: Do your error checking
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'class_name' => array(
                        'name' => 'Class Name',
                        'required' => true,
                    ),
                    'classType' => array(
                        'name' => 'Class Description',
                        'required' => true,
                    ),
                    'sub_class' => array(
                        'name' => 'Sub Class ',
                    ),
                ));
                if ($validation->passed() && $this->model->create_class($update)) {
                    //proceed to step 2
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }

            }
            Redirect::to(URL . 'teacher/classes');
        }

        function active_school() {
            //@Task: Do your error checking
            if (Input::exists()) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'class_name' => array(
                        'name' => 'Class Name',
                        'required' => true,
                        'min' => 3,
                    ),
                    'class_desc' => array(
                        'name' => 'Class Description',
                    ),
                    'parent_class' => array(
                        'name' => 'Parent Class',
                    ),
                    'requirement' => array(
                        'name' => 'Requirements',
                    ),
                ));
                if ($validation->passed() && $this->model->create_class()) {
                    //proceed to step 2
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
            Redirect::to(backToSender());
        }

        function result_folder(){
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'entry_session' => array(
                        'name' => 'Session',
                        'required' => true,
                    ),
                    'entry_term' => array(
                        'name' => ' Term',
                        'required' => true,
                    ),
                    'select_subject' => array(
                        'name' => 'Select Subject',
                        //'required' => true,
                    ),
                ));
                if ($validation->passed()) {
                    $session = $this->model->result_folder();


                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }
            Redirect::to(backToSender());

        }

        function start_record(){
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'entry_session' => array(
                        'name' => 'Session',
                        'required' => true,
                    ),
                    'entry_term' => array(
                        'name' => 'Term',
                        'required' => true,
                    ),
                    'select_class' => array(
                        'name' => 'Class',
                        'required' => true,
                    ),
                    'select_subject' => array(
                        'name' => 'Subject',
                        //'required' => true,
                    ),
                ));
                if ($validation->passed()) {
                    Session::put('academic_term_id',Input::get('entry_term'));

                    if(Input::get('select_subject') == 0){
                        Session::put('academic_subject_id',0);
                        Session::put('academic_subject_name','All Subjects');
                    }else{
                        $subject = $this->model->get_subject(Input::get('select_subject'));
                        Session::put('academic_subject_id',$subject['subject_id']);
                        Session::put('academic_subject_name',$subject['subject_name']);
                    }
                    $class = $this->model->get_class(Input::get('select_class'));
                    Session::put('academic_class_id',$class['class_id']);
                    Session::put('academic_class_name',$class['class_name']);

                    $session = $this->model->get_sch_sessions(Input::get('entry_session'));



                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                    Redirect::to(backToSender());
                    return false;
                }
            }

            if(Session::get('academic_subject_id') == 0){
                //get all subjects
                $tabs = $this->model->active_tabs('all');
                $this->view->active_tabs = $tabs;
                $headers = '';
                foreach($tabs as $t){
                    $headers .= "<th>".$t->subject_name."</th>";
                }
                $this->view->headers = $headers;

            }else{
                //get particular subject
            }

           // $this->view->students = $this->model->get_result('subject',Session::get('academic_class_id'),Session::get('academic_term_id'));
            list($this->view->students,$this->view->total) = $this->model->student_records_per_subject();

            $this->view->js = array('teacher/js/search.js','teacher/js/excel_system.js');
            $this->view->title = 'Teacher - Result Entry';
            $this->view->render('teacher/result_entry', 'admin');


        }

        function delete_student_subject_result($student_id){
            $this->model->delete_student_subject_result($student_id,Session::get('academic_subject_id'),Session::get('academic_class_id'),Session::get('academic_term_id'));
            list($this->view->students,$this->view->total) = $this->model->student_records_per_subject(Session::get('academic_subject_id'),Session::get('academic_class_id'),Session::get('academic_term_id'));

            Redirect::to(backToSender());

        }

        function add_new_student(){
            if (Input::exists()) {
                $this->model->add_new_student(Input::get('student_reg_no'),Input::get('student_name'));

            }
            Redirect::to(backToSender());
        }

        function createNewRecord(){
            if (Input::exists()) {
                $this->model->createNewRecord(Input::get('surname'),Input::get('othername'),Input::get('ca'),Input::get('exam'),Input::get('total'));

            }
        }

        function UpdateRecord($what,$field){
            if (Input::exists()) {
                if($what == 'ca' || $what == 'exam'){
                    $this->model->UpdateAcadRecord($field, $what, Input::get($what),Input::get('total'));
                }else{
                    $this->model->UpdateNameRecord($field, $what, Input::get($what));

                }



            }
        }

        function createAcadRecord($what,$field){
            if (Input::exists()) {
                $this->model->createAcadRecord($field, $what, Input::get($what),Input::get('total'));
            }
        }

        function termly_report_sheet($class){
            $this->model->termly_report_sheet($class);
            Redirect::to(backToSender());
        }


        function result($action = null, $id = null){
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                if(Session::get('academic_subject_id') == 0){
                    //get all subjects
                    $this->model->add_result($id);

                    //$validation = $validate->check($_POST, $items);

                }else{
                    //get particular subject
                    $validation = $validate->check($_POST, array(
                        'student_id' => array(
                            'name' => 'Search Student Number',
                            'required' => true,
                        ),
                    ));
                }
                if (1) {//$validation->passed()
                    Redirect::to(backToSender());
                    return false;
                    //no validation
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }
            }

            if($action && $id){
                switch($action){
                    case 'edit':
                        list($this->view->records,$this->view->students,$this->view->folder) = $this->model->get_result('record',$id);
                       // $this->view->headers= $this->model->get_subject_for_class($id);

                        break;
                    case 'delete':
                        $this->model->get_result('delete',$id);
                        $this->view->students = $this->model->get_result('subject',Session::get('academic_subject_id'));
                        break;
                }
            }else{
                $this->view->students = $this->model->get_result('subject',Session::get('academic_subject_id'),Session::get('academic_session_id'));
            }


            $page = ($action === 'edit')? 'edit_result_entry': 'result_entry';


            $this->view->js = array('teacher/js/search.js');
            $this->view->title = 'Teacher - Result Entry';
            $this->view->render('teacher/'.$page, 'admin');
        }



        function search_for_person($whr, $str){
            $this->model->student_search($whr, $str);
        }

        function add_result($using = 'class', $id = null){
            $this->view->sessions = $this->model->started_sessions(1);
            $this->view->terms = $this->model->started_terms(1);
            $this->view->using = $using;
            $this->view->using_id = $id;
            switch($using){
                case 'class':
                    $this->view->subject = $this->model->get_subject_per_class();
                    break;
                case 'subject':
                    break;
            }
            $page = 'new_result_entry';
            $this->view->js = array('teacher/js/retrieve_term.js');
            $this->view->render('teacher/'.$page, 'admin');
        }

        function start_here(){
            $this->view->sessions = $this->model->started_sessions(1);
            $this->view->terms = $this->model->started_terms(1);

            $this->view->subject = $this->model->get_subject_per_class();
            $this->view->class = $this->model->get_class();

            $page = 'start_result_entry';
            $this->view->js = array('teacher/js/retrieve_term.js');
            $this->view->render('teacher/'.$page, 'admin');
        }

        function retrieveClassSubjects(){
            if(Input::exists()){
                $this->model->retrieveClassSubjects(Input::get('class'));
            }
        }

        function start_recording(){
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'entry_session' => array(
                        'name' => 'Session',
                        'required' => true,
                    ),
                    'entry_term' => array(
                        'name' => 'Term',
                        'required' => true,
                    ),
                    'select_class' => array(
                        'name' => 'Class',
                        'required' => true,
                    ),
                    'select_subject' => array(
                        'name' => 'Subject',
                        'required' => true,
                    ),
                ));
                if ($validation->passed()) {
                    $this->model->set_active();

                    $subject = $this->model->get_subject(Input::get('select_subject'));
                    Session::put('academic_subject_id',$subject['subject_id']);
                    Session::put('academic_subject_name',$subject['subject_name']);

                    $class = $this->model->get_class(Input::get('select_class'));
                    Session::put('academic_class_id',$class['class_id']);
                    Session::put('academic_class_name',$class['class_name']);

                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                    Redirect::to(backToSender());
                    return false;
                }
            }

            list($this->view->students,$this->view->total) = $this->model->student_records_per_subject(Session::get('academic_subject_id'),Session::get('academic_class_id'),Session::get('academic_term_id'));

            $this->view->js = array('teacher/js/search.js','teacher/js/excel_system.js');
            $this->view->title = 'Teacher - Result Entry';
            $this->view->render('teacher/result_entry', 'admin');


        }



        function entry($action = null){

            switch($action){
                case 'student':
                    if (Input::exists()) {
                        $validate = new Validate();
                        //validate input
                        $validation = $validate->check($_POST, array(
                            'select_session' => array(
                                'name' => 'Select Session',
                                'required' => true,
                            ),
                            'select_class' => array(
                                'name' => 'Select Class',
                                'required' => true,
                            ),
                        ));
                        if ($validation->passed()) {
                            $class = $this->model->get_class(Input::get('select_class'));
                            $session = $this->model->get_academic_sessions(Input::get('select_session'));
                            if($class && $session ){
                                Session::put('academic_session_id',$session['session_id']);
                                Session::put('academic_session_name',$session['session_name']);
                                Session::put('academic_class_id',$class['class_id']);
                                Session::put('academic_class_name',$class['class_name']);
                                Redirect::to(URL.'teacher/student');
                                exit;



                            }else{
                                die('Contact Web Developer on 0703-660-9386');
                            }
                        } else {
                            if (count($validation->errors()) == 1) {
                                $message = "There was 1 error in the form.";
                            } else {
                                $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                            }
                            $message .= $validate->display_errors();
                            Session::put('error', $message);
                            Redirect::to(backToSender());
                        }
                    }

                    $page = 'new_student_entry';

                    break;

                case 'result':

                    $page = 'new_result_entry';
                    $this->view->subject = $this->model->get_subject();
                    break;

            }
            $this->view->class = $this->model->get_class();
            $this->view->academics = $this->model->get_academic_sessions();

            $this->view->render('teacher/'.$page, 'admin');

        }


        function record($action = null, $id = null){
            switch($action){
                case 'edit':
                    $this->view->students = $this->model->get_student_record($id);

                    break;
                case 'update':
                    if (Input::exists()) {
                        $validate = new Validate();
                        //validate input
                        $validation = $validate->check($_POST, array(
                            'student_name' => array(
                                'name' => 'Full Name of Student',
                                'required' => true,
                            ),
                            'student_reg_id' => array(
                                'name' => 'Registration Number/ I.D of Student',
                                'required' => true,
                            ),
                            'select_sex' => array(
                                'name' => 'Sex',
                                'required' => true,
                            ),
                            'select_class' => array(
                                'name' => 'Class',
                                'required' => true,
                            ),
                            'description' => array(
                                'name' => 'Details',
                            ),
                        ));
                        if ($validation->passed() && $this->model->add_student_record($id)) {
                            Redirect::to(backToSender());
                        } else {
                            if (count($validation->errors()) == 1) {
                                $message = "There was 1 error in the form.";
                            } else {
                                $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                            }
                            $message .= $validate->display_errors();
                            Session::put('error', $message);
                        }
                    }

                    break;
                case 'delete':
                    $this->model->delete_student($id);
                    Redirect::to(backToSender());
                    break;
            }
            $this->view->class = $this->model->get_class();
            $this->view->title = 'Update Student Record ';
            $this->view->render('teacher/update_student_entry', 'admin');

        }

        function create_subject($update = null) {
            //@Task: Do your error checking
            if (Input::exists()) {

                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'subject_name' => array(
                        'name' => 'Subject Name',
                        'required' => true,
                    ),
                    'subject_alias' => array(
                        'name' => 'Subject Alias',
                        'min' => 3,
                        'required' => true,
                    ),
                    'subject_for' => array(
                        'name' => 'Subject Class',
                        'required' => true,
                    ),
                    'description' => array(
                        'name' => 'Subject description',
                    ),
                    'prerequisite' => array(
                        'name' => 'Subject prerequisite',
                    ),
                    'text_books' => array(
                        'name' => 'Subject text books',
                    ),
                    'tools' => array(
                        'name' => 'Subject tools',
                    ),
                ));
                if ($validation->passed() && $this->model->create_subject($update)) {
                    //proceed to step 2
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }

            }
            Redirect::to(backToSender());
        }

        function session_term_start() {

            //@Task: Do your error checking
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'session_name' => array(
                        'name' => 'Session',
                        'required' => true,
                        'unique' => 'academic_sessions',
                    ),
                    'entry_term' => array(
                        'name' => 'Term Description',
                        'required' => true,
                    ),
                    'starts' => array(
                        'name' => 'Starts',
                    ),
                    'ends' => array(
                        'name' => 'Ends',
                    ),
                    'details' => array(
                        'name' => 'Details',
                    ),
                ));
                if ($validation->passed() && $this->model->session_term_start()) {
                    //proceed to step 2
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }

            }
            Redirect::to(backToSender());
        }

        function add_term_only() {

            //@Task: Do your error checking
            if (Input::exists()) {
                $validate = new Validate();
                //validate input
                $validation = $validate->check($_POST, array(
                    'entry_session' => array(
                        'name' => 'Session',
                        'required' => true,
                    ),
                    'entry_term' => array(
                        'name' => 'Term Description',
                        'required' => true,
                    ),
                    'starts' => array(
                        'name' => 'Starts',
                        'required' => true,
                    ),
                    'ends' => array(
                        'name' => 'Ends',
                        'required' => true,
                    ),
                    'details' => array(
                        'name' => 'Details',
                    ),
                ));
                if ($validation->passed() && $this->model->add_term_only()) {
                    //proceed to step 2
                } else {
                    if (count($validation->errors()) == 1) {
                        $message = "There was 1 error in the form.";
                    } else {
                        $message = "There were " . count($validation->errors()) . " errors in the form.<br />";
                    }
                    $message .= $validate->display_errors();
                    Session::put('error', $message);
                }

            }
            Redirect::to(backToSender());
        }

        function calendar(){

            $this->view->academics = $this->model->get_academic_sessions();
            $this->view->schools = $this->model->get_school();

            //$page = ($action === 'update')? 'update_event': '';
            $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
            $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
            $this->view->js = array('teacher/js/ui.js');

            $this->view->title = 'Academic - Calender ';
            $this->view->render('teacher/calendar', 'admin');
        }
        function view($session_id){

            $this->view->academics = $this->model->get_academic_sessions($session_id);

            //$page = ($action === 'update')? 'update_event': '';
            $this->view->jsPlugin = array('timepicker/bootstrap-timepicker.min.js');
            $this->view->cssPlugin = array('timepicker/bootstrap-timepicker.min.css');
            $this->view->js = array('teacher/js/ui.js');

            $this->view->title = 'Academic - Calender ';
            $this->view->render('teacher/calendar_detailed', 'admin');
        }

        function pins($sch_id){
            $pdf = $this->model->generate_pins($sch_id);


            //==============================================================
            $html = '
        <head>
<style>
	ul{
		list-style: none;
		margin-bottom:0;
		padding-bottom:0;
		display:inline-block;
	}
	ul li  {
		list-style: none;
		padding-left:12px
		font-size:12px;
		margin-left: 5px;

	}
	ul li.pin{
		font-size:16px;
		font-weight:bold;
	}

</style>
</head>
<body>

<h1><a name="top"></a>School Management System - Result Portal</h1>
<h2>Scratch Card Pins: Generated '.date('d, F Y @ H:i:s').'</h2>
This file contains the list of pins and their serial and order numbers.
<hr />
'.$pdf .'


</body>
';

            //==============================================================

// Include the main TCPDF library (search for installation path).
            $path = 'public/TCPDF-master/tcpdf.php';
            require_once($path);

// create new PDF document
            $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor('Chinonso Ani ');
            $pdf->SetTitle('School Education Website Scratch card pins');
            $pdf->SetSubject('Result Pins for Accessing school results');
            $pdf->SetKeywords('School Education, Pins, Website');

            // remove default header
            $pdf->setPrintHeader(false);
            $pdf->setFooterData(array(0,64,0), array(0,64,128));

// set footer fonts
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                require_once(dirname(__FILE__).'/lang/eng.php');
                $pdf->setLanguageArray($l);
            }

// ---------------------------------------------------------

// set default font subsetting mode
            $pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
            $pdf->SetFont('helvetica', '', 14, '', true);

// Add a page
// This method has several options, check the source code documentation for more information.
            $pdf->AddPage();

// Print text using writeHTMLCell()
            $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
            $pdf->Output('School_Scratch_Card_Pins.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+

        }

        function account(){
            $this->view->account = $this->model->account();
            //$this->view->personnel_rank = $this->model->personnel_rank();

            $this->view->generalJS = array('upload_check.js');

            $this->view->title = 'My Account';
            $this->view->render('teacher/account', 'admin');
        }




    }