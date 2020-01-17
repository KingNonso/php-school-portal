<?php

class Blog extends Controller {

    function __construct() {
        parent::__construct();

        $logged = Session::get('loggedIn');
        //$role = Session::get('role');

        $this->view->generalJS = array('custom/js/ajax.js');
        //$this->view->js = array('index/js/main.js');
    }
    function index(){
        $this->view->js = array('blog/js/blog_search.js','blog/js/ajax_pagination.js');

        $this->view->latest10 = $this->model->get_all_blog_titles(false, 5);
        $this->view->mine = $this->model->get_all_blog_titles('mine',1);
        list($this->view->rpp,$this->view->last_no) = $this->model->get_all_blog_titles(true, 5);
        $this->view->last = $this->model->get_last_post();
        $this->view->category = $this->model->category();

        if (Session::get('loggedIn') == false) {
            $this->view->title = 'Blog - News and Articles';
            $this->view->render('blog/index');
        }else{
            $this->view->title = 'News and Articles';
            $this->view->render('blog/index_insider','member');
        }
    }
    function pagination_parser(){
        $this->model->pagination_parser();
    }
    function write(){
        $this->view->generalJS = array('custom/js/ajax.js','custom/plugins/select2/select2.full.min.js','custom/plugins/timepicker/bootstrap-timepicker.min.js','custom/plugins/bootstrap-imageupload/bootstrap-imageupload.js');

        $this->view->generalCSS = array('custom/plugins/select2/select2.min.css','custom/plugins/timepicker/bootstrap-timepicker.min.css','custom/plugins/bootstrap-imageupload/bootstrap-imageupload.css');

        $this->view->js = array('blog/js/slug_gen.js','blog/js/write.js');

        $this->view->category = $this->model->category();
        $this->view->tags = $this->model->tags();
        //get the last item in the blog and all titles
        $this->view->title = 'Write New Post';
        $this->view->render('blog/write','member');
    }

    function update($date = null, $slug= null){
        if(!isset($date) || !isset($slug)){
            Redirect::to(URL.'blog');
            return false;
        }

        $blog = $this->model->blog($slug, $date);
        $this->view->blog = $blog;

        $this->view->generalJS = array('custom/js/ajax.js','custom/plugins/select2/select2.full.min.js','custom/plugins/timepicker/bootstrap-timepicker.min.js','custom/plugins/bootstrap-imageupload/bootstrap-imageupload.js');

        $this->view->generalCSS = array('custom/plugins/select2/select2.min.css','custom/plugins/timepicker/bootstrap-timepicker.min.css','custom/plugins/bootstrap-imageupload/bootstrap-imageupload.css');

        $this->view->js = array('blog/js/slug_gen.js','blog/js/write_update.js');

        $this->view->category = $this->model->category();
        $this->view->tags = $this->model->tags();
        //get the last item in the blog and all titles
        $this->view->title = 'Update Post - '.$blog['post_title'];
        $this->view->render('blog/write_update','member');
    }


    function title($date = null, $slug= null){
        if(!isset($date) || !isset($slug)){
            Redirect::to(URL.'blog');
            return false;
        }
        $this->view->js = array('blog/js/commentator.js');
        //check if date is a 8 in number
        //check if slug is not empty
        $blog = $this->model->blog($slug, $date);
        $this->view->blog = $blog;
        list($this->view->suscribe2category, $this->view->suscribe2author) = $this->model->get_subscriptions($blog['category'], $blog['post_author']);
        $this->view->title = $blog['post_title'];

        if (Session::get('loggedIn') == false) {
            $this->view->render('blog/full_post');
        }else{
            $this->view->render('blog/full_post_insider','member');
        }

    }

    function publish($date = null, $slug= null){
        if(!isset($date) || !isset($slug)){
            Redirect::to(URL.'blog');
            return false;
        }

        $this->view->js = array('blog/js/commentator.js');
        //check if date is a 8 in number
        //check if slug is not empty
        $blog = $this->model->blog($slug, $date, true);
        $this->view->blog = $blog;
        list($this->view->suscribe2category, $this->view->suscribe2author) = $this->model->get_subscriptions($blog['category'], $blog['post_author']);

        $this->view->title = 'Post Published - '. $blog['post_title'];
        $this->view->render('blog/full_post_insider','member');

    }

    function delete($id){
        $this->model->delete_post($id);
        Redirect::to(URL.'blog#my-publication');

    }


    function search_blog($pattern, $search_term){
        $blogs = $this->model->blog_by_pattern($pattern,$search_term);

    }

    function date($year = null, $month = null, $day = null){ //, $title = null

        //if nothing is set, do nothing
        //if title is set, find that specific it using date also
        /*
         *         if(isset($title)){
            if(!is_numeric($year) || !is_numeric($month) || !is_numeric($day)){
                //call error
                $this->error();
                return false;
            }

            $goodDate = checkdate($month, $day, $year) ? true : false;
            if($goodDate){
                $date = new DateTime("$year-$month-$day");
                $dob = $date->format('Y-m-d');
                $this->view->blog = $this->model->blog($title, $dob);

                $this->view->title = ucwords(str_replace('-',' ',$title)). ' - Judidaily';
                $this->view->render('blog/index');
            }else{
                //call error
                $this->error();
            }
        }

         */
        //if date i.e. yr, month, day is set get all blog archives for that day
        if(is_numeric($day)){
            $goodDate = checkdate($month, $day, $year) ? true : false;
            if($goodDate){
                $date = new DateTime("$year-$month-$day");
                $dob = $year.$month.$day;
                $blogs = $this->model->blog_by_date($dob);
                $dob = $date->format('d F, Y');
                $this->show_date_results($dob,$blogs );

            }
        }
        elseif(is_numeric($month)){//if month is set, get archives for that month
            if($month >= 1 && $month <= 12  && $year >= 2010 && $year <= date('Y')){
                $d=cal_days_in_month(CAL_GREGORIAN,$month,$year);
                //echo "There was $d days in $month $year.<br>";

                $date = new DateTime("$year-$month");

                $dob = $year.$month;
                $blogs = $this->model->blog_by_date($dob);
                $dob = $date->format('F, Y');
                $this->show_date_results($dob,$blogs );
            }
        }

        //if year is set, get archives for that year
        elseif(is_numeric($year)){
            if($year >= 2010 && $year <= date('Y')){
                $date = new DateTime("$year");

                $dob = $year;
                $blogs = $this->model->blog_by_date($dob);
                $dob = $date->format('Y');
                $this->show_date_results($dob,$blogs );

            }
        }else{
            echo('bad_date');
            exit();
            //call error
        }


    }

    function  show_date_results($dob, $blogs){
        $user = new User();

        $echo = '<div class="panel panel-primary ">';
        $echo .= '<div class="panel-heading text-holder"><h4>All in '.$dob.' <small> Total found: </small><span class="badge">'.count($blogs).'</span></h4></div>';
        $echo .= '<div class="panel-body text-left">';
        $echo .= '';

        foreach($blogs as $blog){
            $echo .= '<div class="list-group-item">';
            $echo .= '<a class="list-group-item-heading" href="'.URL.'blog/title/'.$blog['slug_date'].'/'.$blog['slug_title'].'" title="View this Post"><h4>'.$blog['post_title'].'</h4></a>';
            $echo .= '<h5>';
            if (!empty($blog['tags'])){
                $tags = explode(',',$blog['tags']);
                $i = count($tags);
                $labels = array('default','primary','success','info','warning','danger');
                for($x = 0; $x<$i; $x++){
                    $tag = $user->blog_tag($tags[$x]);
                    $echo .= '<span class="label label-'.$labels[$x].'">'.$tag['tag_name'].'</span>  ';
                }}

            $echo .= '</h5>';
            list($name, $source, $slug) = $user->get_person_name($blog['post_author']);
            $date = new DateTime($blog['post_date']);
            $dob = $date->format('d M, Y ');//h:i a


            $echo .= '<p class="list-group-item-text"><span class="glyphicon glyphicon-time"></span> Post by <a href="'.URL.'profile/member/'.$slug.'" title="View Writer\'s profile">'.$name.'</a>: '.$dob.'.</p>';
            $echo .= '</div>';

        }
        $echo .= '</div>';
        $echo .= '</div>';
        echo($echo);
        exit();

    }

    function error($type = null){
        //this is to log the error for me to see
        $title = (isset($type))? $type : 'standard';

        $this->view->title = 'Request Error';
        $this->view->render('blog/error');
    }
    function category($cat_slug = null){
        if(!isset($cat_slug)){
            Redirect::to(URL.'blog');
            return false;
        }

        $this->view->js = array('blog/js/date_search.js');

        //this is to log the error for me to see
        $title = (isset($cat_slug))? $cat_slug : 'All';
        $category = $this->model->category($cat_slug);
        $this->view->category = $category;
        $this->view->blog = $this->model->get_blog_post($category['cat_id'],'category');
        $this->view->title = 'Category: '.$category['cat_name'];

        if (Session::get('loggedIn') == false) {
            $this->view->render('blog/category');
        }else{
            $this->view->render('blog/category_insider','member');
        }

    }

    function author($slug = null){
        if(!isset($slug)){
            Redirect::to(URL.'blog');
            return false;
        }
        $this->view->js = array('blog/js/date_search.js');

        $author = $this->model->author($slug);
        $this->view->author = $author;
        $this->view->blog = $this->model->get_blog_post($author['user_id'],'author');

        $this->view->title = 'Author: '.$author['firstname'].' '.$author['surname'];

        if (Session::get('loggedIn') == false) {
            $this->view->render('blog/author');
        }else{
            $this->view->render('blog/author_insider','member');
        }

    }


    function post_write(){

        if(Input::exists()){
            $validate = new Validate();
            //validate input

            $validation = $validate->check($_POST,array(
                'title' => array(
                    'name' => 'title',
                    'required' => true,
                ),
                'post' => array(
                    'name' => 'post',
                    'required' => true,
                ),
                'slug' => array(
                    'name' => 'slug',
                    'required' => true,
                    //'unique' => 'blog_post',
                ),
                'subtitle' => array(
                    'name' => 'subtitle',
                ),
                'category' => array(
                    'name' => 'category',
                ),
                'used_tags' => array(
                    'name' => 'used_tags',
                ),
            ));

            $path = $this->upload();
            $path = ($path)?$path:Input::get('previous_image');
            if($validate->passed()){
                $this->model->post_write('publish',$path);
            }
        }

    }

    function slug_check($update = false){

        if(Input::exists()){
            $validate = new Validate();
            //validate input

            $validation = $validate->check($_POST,array(
                'slug_title' => array(
                    'name' => 'slug_url',
                    'required' => true,
                ),

            ));

            if($validate->passed() && $this->model->slug_check($update)){
                echo('good');
                exit();
            }else{
                echo('bad');
                exit();
            }
        }

    }

    function upload(){
        $max = Input::get('MAX_FILE_SIZE');
        $folder = 'blog\\';

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
            //echo('fail');
            //exit();

            $path = NULL;
            $output = "<p class=\"errors\"> ";
            $output .= "Please review the following fields: <br />";
            foreach ($result as $error) {
                $output .= " - " . $error . "<br />";
            }
            $output .= "</p>";
            //echo($output);
            return false;
        } else {
            $resize = new Resize($destination.$path);
            $resize->resizeImage(840, 341, 'exact');
            $resize->saveImage($destination.$path, 100);

            return($path);
            //exit();
            //$this->model->upload($path);
        }
    }


    function autosave(){
        if(Input::exists()){
                $validate = new Validate();

                //validate input
                $validation = $validate->check($_POST,array(
                    'token' => array(
                        'token' => 'token',
                        'required' => true,
                    ),
                ));
            $path = $this->upload();
            $path = ($path)?$path:Input::get('previous_image');

            if($validate->passed() && $this->model->post_write('autosave',$path)){

                }
        }

    }

    function subscriptions($type,$style){
        $this->model->set_subscriptions($type,$style);
    }


    function comment($outside = false) {
        //@Task: Do your error checking
        if (Input::exists()) {

            $validate = new Validate();
            //validate input
            $validation = $validate->check($_POST, array(
                'name' => array(
                    'name' => ' Name(s)',
                    'required' => true),
                'email' => array(
                    'name' => 'Email'),
                'message' => array(
                    'name' => 'Message',
                    'required' => true),
            ));

            if($outside){
                if(recaptcha(true)){
                    if($this->model->comment()){
                        echo('success');
                        exit();

                    }else{
                        echo('error');
                        exit();
                    }
                }else{
                    echo('error recaptcha');
                    exit();

                }


            }

            if ($validation->passed() && !$outside) { //&& recaptcha(TRUE)
                if($this->model->comment()){
                    echo('success');
                    exit();

                }else{
                    echo('error');
                    exit();
                }



            } else {
                echo('bad_validation');
                exit();

            }
        }
        return false;
    }


    function comment_action($action) {
        $this->model->comment_action($action);
    }



    function add_resource($type){
        if(Input::exists()){
            $this->model->add_resource($type);

        }
    }

    function preview($last_id){
        $this->view->blog = $this->model->get_blog_post($last_id);
        $this->view->title =  'Post Preview - Judidaily';
        $this->view->render('blog/post_preview');
    }

    function approved($id){
        $this->model->approved($id);
    }


}