<?php

class Blog_Model extends Model {
    //private  $_data;

    function __construct() {
        parent::__construct();
        $this->user = new User();

    }

    function category($cat_slug = null){
        if($cat_slug){
            return $this->db->fetch_exact('blog_category','cat_slug',$cat_slug);
        }
        return $this->db->getAll_assoc('blog_category')->results_assoc();
    }
    function author($slug){
        return $this->db->fetch_exact('info_personal','slug',$slug);
    }
    function tags(){
        return $this->db->getAll_assoc('blog_tag')->results_assoc();
    }

    public function get_all_blog_titles($ajax = false, $limit = 20){
        if($ajax === 'mine'){
            $data = $this->db->get_assoc('blog_post',array('post_author','=',Session::get('user_id')),'post_id')->results_assoc();

            return $data;

        }
        if(!$ajax){
            $data = $this->db->get_assoc('blog_post',array('post_status','=','publish'))->results_assoc();
            $lastTen = array();
            for($i=0; $i < $limit; $i++){
                $obj = array_pop($data);
                if($obj == null) break;
                $lastTen[] = $obj;
            }
            return $lastTen;

        }
        else{
            $data = $this->db->get_assoc('blog_post',array('post_status','=','publish'),'post_id')->results_assoc();
            $count = $this->db->count_assoc();
            // Here we have the total row count
            $total_rows = $count;
// Specify how many results per page
            $rpp = 10;
// This tells us the page number of our last page
            $last = ceil($total_rows/$rpp);
// This makes sure $last cannot be less than 1
            if($last < 1){
                $last = 1;
            }
            return array($rpp, $last);

        }
    }

    public function pagination_parser(){
        // Make the script run only if there is a page number posted to this script
        if(isset($_POST['pn'])){
            $rpp = preg_replace('#[^0-9]#', '', $_POST['rpp']);
            $last = preg_replace('#[^0-9]#', '', $_POST['last']);
            $pn = preg_replace('#[^0-9]#', '', $_POST['pn']);
            // This makes sure the page number isn't below 1, or more than our $last page
            if ($pn < 1) {
                $pn = 1;
            } else if ($pn > $last) {
                $pn = $last;
            }

            // This sets the range of rows to query for the chosen $pn
            $limit = ($pn - 1) * $rpp .',' .$rpp;
            // This is your query again, it is for grabbing just one page worth of rows by applying $limit
            $blogs = $this->db->get_limited('blog_post',$limit,
array('post_status','=','publish'),'post_id')->results_assoc();

            $user = new User();
            $echo = '';

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


            // Echo the results back to Ajax
            echo $echo;
            exit();
        }

    }


    public function blog($title, $dob, $publish = false) {
        $data = $this->db->fetch_exact_two('blog_post', 'slug_title',$title , 'slug_date',$dob);
        if($data){
            if($publish){
                $this->db->update('blog_post', array(
                    'post_status' => 'publish',
                ),'post_id',$data['post_id']);
            }
            return $data;
        }else{
            //call error
            $this->error();
        }
    }

    function delete_post($id){
        try {
            $this->db->delete('blog_post',array('post_id', '=',$id));
            return true;


        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }


    public function get_last_post(){
        $data = $this->db->fetch_last('blog_post','post_id');
        return $data;
    }

    public function get_blog_post($post_id = NULL, $action = false){
        switch($action) {
            case "category":
                $data = $this->db->get_assoc('blog_post', array('category','=',$post_id),'post_id')->results_assoc();

                break;
            case "author":
                $data = $this->db->get_assoc('blog_post', array('post_author','=',$post_id),'post_id')->results_assoc();
                break;
            default:
                return $this->db->fetch_exact('blog_post','post_id',$post_id);
                break;
        }

        return $data;
       }

    public function blog_by_date($dob) {
        $dob = "%".$dob."%";

        $data = $this->db->get_assoc('blog_post', array('slug_date','LIKE',$dob),'post_id')->results_assoc();
        $count = $this->db->count_assoc();
        if($count > 0){
            return $data;
        }else{
            echo('bad_date');
            exit();
            //$this->error();
        }
    }

    function  show_search_results($dob, $blogs){
        $user = new User();

        $echo = '<div class="panel panel-primary ">';
        $echo .= '<div class="panel-heading text-holder"><h4>All  '.$dob.' <small> Total found: </small><span class="badge">'.count($blogs).'</span></h4></div>';
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


    public function blog_by_pattern($pattern, $search_term) {
        switch($pattern){
            case 'title':
                $search = "%".$search_term."%";

                $data = $this->db->get_assoc('blog_post', array('post_title','LIKE',$search),'post_id')->results_assoc();
                $count = $this->db->count_assoc();
                if($count > 0){
                    $this->show_search_results(' with Title: '.$search_term,$data );
                }else{
                    echo('bad_search');
                    exit();
                }

                break;
            case 'author':
                $search = $this->user->search_box($search_term, 'info_personal');
                $search_count = $this->user->count();
                if($search_count != 0){
                    foreach($search as $suggestion){
                        $data = $this->db->get_assoc('blog_post', array('post_author','=',$suggestion['user_id']),'post_id')->results_assoc();
                        $count = $this->db->count_assoc();
                        if($count > 0){
                            $this->show_search_results(' with Author\'s name: '.$search_term,$data );
                        }else{
                            echo('bad_search');
                            exit();
                        }

                    }

                }else{
                    echo('bad_search');
                    exit();
                }



                break;
            case 'category':
                $data = $this->db->get_assoc('blog_post', array('category','=',$search_term),'post_id')->results_assoc();
                $cat = $this->db->fetch_exact('blog_category','cat_id',$search_term);

                $count = $this->db->count_assoc();
                if($count > 0){
                    $this->show_search_results(' in Category: '.$cat['cat_name'],$data );
                }else{
                    echo('bad_search');
                    exit();
                }



                break;

        }

    }


    public function archives($start, $end) {
        $data = $this->db->get_multiple('blog_post', array('post_date','>',$start,'post_date','<',$end),'post_id')->results_assoc();
        $count = $this->db->count_assoc();
        if($count > 0){
            return $data;
        }else{
            //call error
            $this->error();
        }
    }

    public function error() {
        Redirect::to(URL.'post/error');
        return false;
    }

    public function slug_check($update = false){
        if($update){
            $check = $this->db->get('blog_post', array('slug_date','=',Input::get('slug_date'),'slug_title','=',Input::get('slug_title')));
            if($this->db->count()<= 1){
                return true;
            }else{
                return false;
            }
        }
        $check = $this->db->get('blog_post', array('slug_date','=',date('Ymd'),'slug_title','=',Input::get('slug_title')));
        if($this->db->count()){
            return false;
        }
        return true;

    }

    public function post_write($status = 'autosave',$image = null){
        try{
            //find guide and replace what is there already
            //get the id
            $guide = $this->db->fetch_exact('blog_post','guide',Input::get('token'));
            if(!empty($guide['post_id'])){
                $this->db->update('blog_post', array(
                    'post_title' => Input::get('title'),
                    'post_content' => htmlspecialchars($_POST['post']),//Input::get('post')
                    'featured_image' => $image,
                    'post_author' => $guide['post_author'],
                    'category' => Input::get('category'),
                    'subtitle' => Input::get('subtitle'),
                    'tags' => Input::get('used_tags'),
                    'post_date' => $this->today,
                    'guide' => Input::get('token'),
                    'post_status' => $status,
                    'post_parent' => 1,
                ),'post_id',$guide['post_id']);

                $insert_id = $guide['post_id'];

            }else{
                $this->db->insert('blog_post',array(
                    'post_title' => Input::get('title'),
                    'slug_date' => date('Ymd'),
                    'slug_title' => trim(Input::get('slug')),
                    'post_content' => htmlspecialchars($_POST['post']),//Input::get('post')
                    'featured_image' => $image,
                    'post_author' => Session::get('user_id'),
                    'category' => Input::get('category'),
                    'subtitle' => Input::get('subtitle'),
                    'tags' => Input::get('used_tags'),
                    'post_date' => $this->today,
                    'guide' => Input::get('token'),
                    'post_status' => $status,
                    'post_parent' => 1,

                ));
                $insert_id = $this->db->last_insert_id();

            }
            cleanUP();

            if($status == 'publish'){// || $status == 'editor'
                //use $insert_id to get slug
                $slug = $this->db->fetch_exact('blog_post','post_id',$insert_id);
                //preview post
                $echo = 'blog/title/'.$slug['slug_date'].'/'.$slug['slug_title'];
                echo($echo);
                exit();
            }else{
                echo('Saved');

                return true;
            }

        }catch(Exception $e){
            return false;
            //$e->getMessage();
        }
    }

    public function set_subscriptions($type,$style){
        //set email for all those who want to subscribe to posts from this category
        //check if they have been subscribed before
        switch ($type){
            case 'subscribe':
                switch ($style) {
                    case 'category':
                        $data = $this->db->fetch_exact_two('blog_subscriptions','sub_category',Input::get('category'),'subscriber',Session::get('user_id'));
                        if(count($data)){
                            $this->db->insert('blog_subscriptions',array(
                                'subscriber' => Session::get('user_id'),
                                'subscriber_email' => Input::get('comment_email'),
                                'sub_category' => Input::get('category'),
                                'active' => 1,
                                'date' => $this->today,
                            ));
                        }
                        break;
                    case 'author':
                        $data = $this->db->fetch_exact_two('blog_subscriptions','sub_author',Input::get('author'),'subscriber',Session::get('user_id'));
                        if(count($data)){
                            $this->db->insert('blog_subscriptions',array(
                                'subscriber' => Session::get('user_id'),
                                'subscriber_email' => Input::get('comment_email'),
                                'sub_author' => Input::get('author'),
                                'active' => 1,
                                'date' => $this->today,
                            ));
                        }
                        break;
                }
                break;
            case 'unsubscribe':
                switch ($style) {
                    case 'category':
                        $data = $this->db->fetch_exact_two('blog_subscriptions','sub_category',Input::get('category'),'subscriber',Session::get('user_id'));
                        if(count($data)){
                            $undo = $this->db->delete('blog_subscriptions',array('sub_category','=',Input::get('category'),'subscriber','=',Session::get('user_id')));
                        }
                        break;
                    case 'author':
                        $data = $this->db->fetch_exact_two('blog_subscriptions','sub_author',Input::get('author'),'subscriber',Session::get('user_id'));
                        if(count($data)){
                            $undo = $this->db->delete('blog_subscriptions',array('sub_author','=',Input::get('author'),'subscriber','=',Session::get('user_id')));
                        }
                        break;
                }
                break;


        }
        return true;

    }

    public function get_subscriptions($cat_id, $author_id){

        $category = $this->db->get('blog_subscriptions',array('sub_category','=',$cat_id,'subscriber','=',Session::get('user_id')));
        $subscribed2category = $this->db->count() ? true : false;

        $author = $this->db->get('blog_subscriptions',array('sub_author','=',$author_id,'subscriber','=',Session::get('user_id')));
        $subscribed2author = $this->db->count() ? true : false;

        return array($subscribed2category,$subscribed2author);

    }
    public function send_subscriptions(){
        //send email to all those who have subscribed to posts from this category
        //send email to all those who have subscribed to posts from this author

    }

    function upload($upload) {
        try {
            $this->db->update('events', array(
                'event_image' => $upload,
            ),'event_id',Input::get('event_id'));

            echo "Upload was completed successfully";
            //Redirect::to(URL.'wall/event#manage');

        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    function comment($subscribe = false) {
        try {
            $this->db->insert('blog_comments', array(
                'name' => Input::get('name'),
                'user_id' => Input::get('user_id'),
                'email' => Input::get('email'),
                'message' => Input::get('message'),
                'date' => $this->today,
                'post_id' => Input::get('blog_id'),
            ));

            /* ###################################           Send Email to Author to moderate      #################################################################*/
            $to =  'author@site.com';// author's email "ucjudith@gmail.com";
            $from = "postmaster@judidaily.com.ng";

            $blogs = $this->get_blog_post(Input::get('post_id'));

            $subject = 'Please Moderate - Feedback from Your Blog Post: '.$blogs['post_title'];

            // build the message
            $email_message = "Message: ".Input::get('message')." \n\n";

            // limit line length to 70 characters
            $email_message = wordwrap($email_message, 70);

            // create additional headers
            $additionalHeaders = 'From: '.Input::get('name').'  <'.Input::get('email').'>';
            $additionalHeaders .= 'Reply-To: '.$from.'' . "\r\n";

            // send it
            $mailSent = mail($to, $subject, $email_message, $additionalHeaders);


            /*#######################################################################################################################333*/
            if($subscribe){
                //add to subscribers if email does not exist
                $exists =  $this->db->fetch_exact('users','email',Input::get('email'));
                if(empty($exists['email'])){
                    $this->db->insert('users', array(
                        'email' => Input::get('email'),
                        'joined' => $this->today,
                        'role' => 1,
                        'name' => Input::get('name'),
                    ));
                    return 'good_subscriber';

                }else{
                    return 'bad_subscriber';

                }
            }
            return true;

        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    function comment_action($action) {
        try {
            $echo = '';
            switch($action) {
                case "add":
                    $this->db->insert('blog_comment_reply', array(
                        'comment_id' => Input::get('comment_id'),
                        'blog_id' => Input::get('blog_id'),
                        'person_id' => Session::get('user_id'),
                        'reply' => Input::get('txtmessage'),
                        'date' => $this->today,
                    ));

                    /* ###################################           Send Email to Author to moderate      #################################################################*/
                    $to =  'tothecommenter@site.com';// author's email "ucjudith@gmail.com";
                    $from = "postmaster@judidaily.com.ng";

                    $blogs = $this->get_blog_post(Input::get('post_id'));

                    $subject = 'Please Moderate - Feedback from Your Blog Post: '.$blogs['post_title'];

                    // build the message
                    $email_message = "Message: ".Input::get('message')." \n\n";

                    // limit line length to 70 characters
                    $email_message = wordwrap($email_message, 70);

                    // create additional headers
                    $additionalHeaders = 'From: '.Input::get('name').'  <'.Input::get('email').'>';
                    $additionalHeaders .= 'Reply-To: '.$from.'' . "\r\n";

                    // send it
                    $mailSent = mail($to, $subject, $email_message, $additionalHeaders);


                    /*#######################################################################################################################333*/
                    $echo .= '';
                    $echo .= Input::get('txtmessage');
                    $echo .= '';



                    break;
                case "edit":
                    $this->db->update('blog_comments', array(
                        'message' => Input::get('txtmessage'),
                    ),'blog_comment_id',Input::get('comment_id'));

                    $echo .= Input::get('txtmessage');

                    break;

                case "delete":
                    $this->db->delete('blog_comments',array('blog_comment_id','=',Input::get('comment_id')));
                    break;
            }

            $echo .= '';
            //echo($echo);
            //exit();
            return true;





        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    public function get_blog_comments($post_id) {
        $data =  $this->db->get_assoc('blog_comments',array('post_id','=',$post_id))->results_assoc();
        $count = $this->db->count_assoc();
        if($count > 0){
            return $data;
        }else{
            return false;
        }
    }

    public function add_resource($type) {
        try {
            if($type == 'category'){
                //check if it doesn't exist
                $check = $this->db->fetch_exact('blog_category','cat_name',Input::get('new_category'));
                if($check){
                    $insert_id = $check['cat_id'];
                }else{
                    $this->db->insert('blog_category', array(
                        'cat_name' => Input::get('new_category'),
                        'cat_desc' => Input::get('category_desc'),
                        'cat_slug' => toAscii(Input::get('new_category')),
                        'parent' => Input::get('cat_parent'),
                    ));
                    $insert_id = $this->db->last_insert_id();

                }

                $echo = '<option value="' . $insert_id . '" selected="selected">' . Input::get('new_category') . '</option>';
                echo($echo);
                exit();

            }elseif($type == 'tag'){
                //check if it doesn't exist
                $check = $this->db->fetch_exact('blog_tag','tag_name',Input::get('new_tag'));
                if($check){
                    $insert_id = $check['tag_id'];
                }else{
                    $this->db->insert('blog_tag', array(
                        'tag_name' => Input::get('new_tag'),
                        'desc' => Input::get('new_tag'),
                        'tag_slug' => toAscii(Input::get('new_tag')),
                    ));
                    $insert_id = $this->db->last_insert_id();

                }

                echo($insert_id);
                exit();
                /*
                 * $echo = '<option value="' . $insert_id . '" selected="selected">' . Input::get('new_tag') . '</option>';
                $echo .= '<option value="' . $insert_id . '" selected="selected">' . Input::get('new_tag') . '</option>';
                echo($echo);
                 */
            }
            cleanUP();

        } catch (Exception $e) {
            return false;
            //die($e->getMessage());
        }
    }

    function approved($id) {
        try {
            $this->db->update('blog_post', array(
                'post_status' => 'publish',
            ),'post_id',$id);

            Session::flash('home','Post was published successfully successfully');
            Redirect::to(URL.'admin/editor');

        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }


}
