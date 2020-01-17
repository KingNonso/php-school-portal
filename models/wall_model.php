<?php

class Wall_Model extends Model {


    function __construct() {
        parent::__construct();
        $this->user = new User();
    }

    public function get_person(){
        $data =  $this->db->fetch_exact('info_personal','user_id',Session::get('user'));
        $data[] = $this->db->fetch_last('member_status','status_id','member_id',$data['person_id']);

        return($data);
    }

    function member_status($upload = false, $id = false) {
        try {
            //Get previous record if any
            $data = $this->db->fetch_last('member_status','status_id','member_id',$_SESSION['user_id']);
            $data = !empty($data['photo'])? $data['photo'] : null;
            $status = (Input::get('person_state'))? Input::get('person_state') : $data['status'];

            //logde in new details
            if(!$upload){
                $this->db->update('info_personal', array(
                    'slug' => trim(Input::get('person_slug')),
                ),'user_id',Session::get('user_id'));

                $this->db->insert('member_status',array(
                    'member_id' => $_SESSION['user_id'],
                    'date_added' => $this->today,
                    'status' => $status,
                    'photo' => $data,
                    'active' => 1

                ));

                $insert_id = $this->db->last_insert_id();
                echo($insert_id);
                exit();

            }else{
                $this->db->update('member_status', array(
                    'photo' => $upload,
                ),'status_id',$id);

                return(true);

            }


        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    function search_for_person($str, $event_id = null){
        $search = $this->user->search_box($str, 'members');
        $search_count = $this->user->count();

        if($search_count != 0){

            foreach($search as $suggestion){
                if($suggestion['user_id'] === Session::get('user_id')){
                    continue; //makes person unable to search for themselves
                }
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
                $echo = '<div class="col-sm-6">';
                $echo .= '<div class="row">
                        <div class="col-sm-2">';

                $echo .= '<img src="'.$source.'" class="img-circle" height="51px" width="51px"  alt="'.$name.'">';
                $echo .= '</div>
                        <div class="col-sm-10 text-left text-holder">';

                $echo .= '<a href="'.URL.'profile/member/'.$suggestion['slug'].'" class="poster-name text-left">'.$name.'</a>';

                $echo .= '</div>';
                $echo .= '</div>';
                $echo .= '<br/>';
                $echo .= '</div>';




                echo($echo);
            }


        }else {
            echo "No suggestion";
        }

    }

    public function friendship_request($owner){
        // user2 is the acceptor
        $is_friend = $this->db->get('friends',array('user2_id','=',$owner,'accepted','=',0))->results();
        $is_friend_count = $this->db->count();
        if($is_friend_count){
            return(($is_friend));

        }else{
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
        //add myself, so I can see my own post
        $my_friends[] = Session::get('user_id');

        return(($my_friends)) ;



    }

    public function  lastFive($array, $limit = 10){
        //produce the last five results
        $lastFive = array();
        for($i=0; $i < $limit; $i++){
            $obj = array_pop($array);
            if($obj == null) break;
            $lastFive[] = $obj;
        }
        return $lastFive;
        //produce the first five results
        $arrayCount = count($array);
        if($arrayCount > 5){
            $output = array_slice($array, (-5),$arrayCount);
        }else{
            $output = $array;
        }

    }

    public function wall_post(){
        $data = $this->db->getAll_assoc('post','post_id')->results_assoc();
        $limit = 3;
        $newArray = array();
        foreach ($data as $entry) {
            if(in_array($entry['author_id'],$this->get_my_friends())){
                $newArray[] = array(
                    'post_id' => $entry['post_id'],
                    'author_id' => $entry['author_id'],
                    'when' => $entry['when'],
                    'message' => $entry['message'],
                    'post_image' => $entry['post_image'],
                    //'tags' => $entry['tags'],
                );
            }
            $arrayCount = count($newArray);
            if($arrayCount === $limit){
                $last_id_picked = $newArray[$limit-1]['post_id'];
                Session::put('last_wall_post_id',$last_id_picked);
                return $newArray;
                break;
            }
        }
        if(Session::exists('last_wall_post_id')) Session::delete('last_wall_post_id');
        return $newArray;
    }

    public function load_more_wall_post(){
        $last_post_id = Session::exists('last_wall_post_id')? Session::get('last_wall_post_id') : null;
        if($last_post_id){ //there exists more post
            $post_data = $this->db->get_assoc('post', array('post_id','<',$last_post_id),'post_id')->results_assoc();
            $limit = 3;
            $newArray = array();
            $post_remains = false;
            foreach ($post_data as $entry) {
                if(in_array($entry['author_id'],$this->get_my_friends())){
                    $newArray[] = array(
                        'post_id' => $entry['post_id'],
                        'author_id' => $entry['author_id'],
                        'when' => $entry['when'],
                        'message' => $entry['message'],
                        'post_image' => $entry['post_image'],
                        //'tags' => $entry['tags'],
                    );
                }
                $arrayCount = count($newArray);
                if($arrayCount === $limit){
                    $post_remains = true;
                    $last_id_picked = $newArray[$limit-1]['post_id'];
                    Session::put('last_wall_post_id',$last_id_picked);
                    //$new_posts = $newArray;
                    break;
                }else{
                    $post_remains = false;
                }

            }
            if(!$post_remains) Session::delete('last_wall_post_id');
            //return $newArray;


            $return = '';
            $person = $this->get_person();
            $photo = $person[0]['photo'];
            if(!empty($photo)){
                $myPhoto = URL.'public/uploads/profile-pictures/'.$photo;

            }else{
                if($person['sex']== 'Male'){
                    $myPhoto = URL.'public/images/avatar-male.png';
                }else{
                    $myPhoto = URL.'public/images/avatar-female.png';
                }
            }
            $status = $person[0]['status'];
            $me = $person['firstname'].' '.$person['surname'].' '.$person['othername'];


            $user = new User();
            foreach($newArray as $d){
                list($name, $source, $slug) = $user->get_person_name($d['author_id']);

                if($d['post_image']){
                    $picture = '<img src="'.URL.'public/uploads/wall/'.$d['post_image'].'" class="img-responsive" height="50%">';
                }else{
                    $picture = '';
                }

                $return .= '<div class="row" id="post_holder'. ($d['post_id']).'">';
                $return .= '<div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-body">';
                $return .= '<img src="'.$source.'" class="img-circle" height="55" width="55" alt="'.$name.'">';
                $return .= '</div>';
                $return .= '<a href="'.URL.'profile/member/'.$slug.'" class="poster-name text-left">'.$name.' </a>';
                $return .= '</div>
                        </div>';
                $return .= '<div class="col-sm-9">
                            <div class="panel panel-default">';
                $return .= $picture;
                $return .= '<p>'.$d['message'].'</p>';
                $return .= '<div class="panel-footer text-left">';

                list($likes,$like_count,$user_likes_it,$likers) = $user->get_liked(Session::get('user_id'),'post_id',$d['post_id']);

                $return .= '<span class="glyphicon glyphicon-time"></span>';
                $return .= '<span class="liveTime" data-lta-value="'.$d['when'].'"></span>';

                if(!$user_likes_it){
                    $return .= '<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'like_post\',\''.$d['post_id'].'\')"';
                    $return .= ' title="Like it" id="like-btn'.$d['post_id'].'">';
                    $return .= '<span class="glyphicon glyphicon-thumbs-up"></span> Like
                                        </a>';
                }else{
                    $return .= '<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'unlike_post\',\''.$d['post_id'].'\')" ';
                    $return .= 'title="Unlike it" id="like-btn'.$d['post_id'].'">';
                    $return .= '<span class="glyphicon glyphicon-thumbs-down"></span> Unlike
                                        </a>';

                }

                if(Session::get('user_id') == $d['author_id']){
                    $return .= '<a href="javascript:void(0);" onClick="callCrudAction(\'delete_post\',\''.$d['post_id'].'\')" title="Delete Post" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>';

                }

                $return .= '<div class="pull-right">';
                $return .= '<a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-trigger="hover" data-content="'.$likers.'" id="like-count'.$d['post_id'].'">'.$like_count.'</a>';

                $replies = $user->get_post_reply($d['post_id']);
                $reply_count = $user->count();
                if($reply_count == 0){
                    $reply_count = 'Comment';
                    $reply_content = 'No Comments yet';
                }else{
                    $reply_content = 'Click to view comments';
                }
    ##################################################################

                $return .= '<a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="toggle(\'all_replies'.$d['post_id'].'\')" data-toggle="popover" data-trigger="hover" data-content="'.$reply_content.'">';
                $return .= '<i class="glyphicon glyphicon-comment" ></i>';
                $return .= '<span class="label label-default" id="reply-count'.$d['post_id'].'">'.$reply_count.'</span>';
                $return .= '</a>';
                $return .= '    </div>
                            </div>';
                $return .= '<!--########## Main Replies to a Post ####### -->';
                $return .= '<div class="panel-body">
                                    <div class="row">';
                $return .= '<!-- all replies fall in here -->';
                $return .= '<div class="comments" id="all_replies'.$d['post_id'].'">';

            foreach($replies as $reply){
                list($author, $author_img, $author_slug) = $user->get_person_name($reply['author']);
                $return .= '<div id="reply'.$reply['reply_id'].'">';
                $return .= '<div class="col-sm-2">';
                $return .= '<img src="'.$author_img.'" class="img-thumbnail" height="51px" width="51px"  alt="'.$author.'">';
                $return .= '</div>';
                $return .= '<div class="col-sm-10 text-left text-holder">';
                $return .= '<p><a href="'.URL.'profile/member/'.$author_slug.'" class="poster-name text-left">'.$author.'</a>: '.$reply['comment'].'';
                $return .= '<br/>';
                $return .= '<span class="pull-right">';
                $return .= '<span class="liveTime" data-lta-value="'.$reply['date_posted'].'"></span>';

            $react = $user->get_reply_reaction($reply['reply_id']);
            $react_count = $user->count();
            if($react_count == 0){
                $react_count = '';
                $react_content = ' data-content="Be the first" ';
            }elseif($react_count == 1){
                $react_content = 'data-content="1 Reaction"';

            }elseif($react_count >= 2){
                $react_content = 'data-content="'.$react_count.' Reactions"';
            }

            list($react_likes,$react_like_count,$user_likes_it,$react_likers) = $user->get_reply_likes(Session::get('user_id'),'reply_id',$reply['reply_id']);

             if(!$user_likes_it){
                 $return .= '<a  href="javascript:void(0);" id="like-reply'.$reply['reply_id'].'" onClick="callCrudAction(\'like_reply\',\''.$reply['reply_id'].'\')"  data-toggle="popover" data-trigger="hover" class="btn" '.$react_like_count.' >';
                 $return .= '<span class="glyphicon glyphicon-thumbs-up "></span>';
                 $return .= '</a>';

             }else{
                 $return .= '<a  href="javascript:void(0);" id="like-reply'.$reply['reply_id'].'" onClick="callCrudAction(\'unlike_reply\',\''.$reply['reply_id'].'\')"  data-toggle="popover" data-trigger="hover" class="btn" '.$react_like_count.' >';
                 $return .= '<span class="glyphicon glyphicon-thumbs-down "></span>';
                 $return .= '</a>';

             }

                $return .= '<a href="javascript:void(0);" onclick="toggle(\'reply2comment'.$reply['reply_id'].'\')"  data-toggle="popover" data-trigger="hover" '.$react_content.' class="btn" id="toggle-reply'.$reply['reply_id'].'">';
                $return .= '<span class="glyphicon glyphicon-share-alt"></span>';
                $return .= '</a>';

            if(Session::get('user_id') == $reply['author']){
                $return .= '<a href="javascript:void(0);" onclick="callCrudAction(\'delete_comment\',\''.$reply['reply_id'].'\')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>';

            }

                $return .= '</span>';
                $return .= '</p>';
                $return .= '<br/>';
                $return .= '<div class="row reply2comment" style="display: none" id="reply2comment'.$reply['reply_id'].'">';
                $return .= '<span class="separator"></span>';
                $return .= $react;
                $return .= '<div class="panel-body" id="input_reply'.$reply['reply_id'].'">';
                $return .= '<div class="col-sm-2">';
                $return .= '<img src="'.URL.'public/uploads/profile-pictures/'.$photo.'" class="img-rounded" height="30" width="30" alt="'.$me.'">';
                $return .= '</div>';
                $return .= '<div class="col-sm-10 text-left">';
                $return .= '<form class="form-inline reply-tab" method="post" onsubmit="return false">';
                $return .= '<div class="input-group">';
                $return .= '<input type="text" class="form-control" size="50"  id="reactMsg'.$reply['reply_id'].'" placeholder="React to Comment..." required="required">';
                $return .= '<div class="input-group-btn">';
                $return .= '<button type="submit" class="btn reply-btn-inverse" onClick="callCrudAction(\'react\',\''.$reply['reply_id'].'\')"><span class="glyphicon glyphicon-plus"></span></button>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</form>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';

            }
                $return .= '</div>';
                $return .= '<div id="post-reply'.$d['post_id'].'"></div>';
                $return .= '<!--########## End Main Replies to a Post ####### -->';
                $return .= '</div>';
                $return .= '<!--########## Post comment section ####### -->';
                $return .= '<div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-2">';
                $return .= '<img src="'.$myPhoto.'" class="img-rounded" height="30" width="30" alt="'.$me.'">';
                $return .= '</div>';
                $return .= '<div class="col-sm-10 text-left">';
                $return .= '<form class="form-inline reply-tab" method="post" onsubmit="return false">';
                $return .= '<div class="input-group">';
                $return .= '<input type="text" class="form-control" size="50" id="txtmessage'.$d['post_id'].'" placeholder="Reply to Post... " required="required">';
                $return .= '<input name="author_id" id="author_id" type="hidden" value="'.$d['author_id'].'" />';
                $return .= '<input name="post_id" id="post_id" type="hidden" value="'.$d['post_id'].'" />';
                $return .= '<div class="input-group-btn">';
                $return .= '<button type="submit" class="btn reply-btn" onClick="callCrudAction(\'comment\',\''.$d['post_id'].'\')"><span class="glyphicon glyphicon-plus"></span></button>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</form>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';
                $return .= '</div>';

                $return .= '';
            }

            echo $return;
            exit();
        }else{
            echo('nothing');
            exit();
        }

    }


    function post() {
        try {
            $picture = !is_numeric(Input::get('picture'))? Input::get('picture') : null;

            $this->db->insert('post',array(
                'author_id' => $_SESSION['user_id'],
                'when' => $this->today,
                'message' => Input::get('message'),
                'post_image' => $picture,
                'tags' => "Some dynamically generated tags",

            ));

            $insert_id = $this->db->last_insert_id();
            //get user details

            $profile = $this->db->fetch_exact('info_personal','user_id',$_SESSION['user_id']);
            $name = $profile['firstname']. ' '.$profile['surname'].' '.$profile['othername'];
            $pix = $this->user->get_profile_pic($profile['person_id']);
            if(!empty($pix['photo'])){
                $source = URL.'public/uploads/profile-pictures/'. $pix['photo'];
            }else{
                if($profile['sex']== 'Male'){
                    $avatar = 'male';
                }else{
                    $avatar = 'female';
                }
                $source = URL.'public/images/avatar-'.$avatar.'.png';
            }

            //output to wall

            $echo = "<br/>";
            $echo .= '<div class="row" id="post_holder'.$insert_id.'">
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-body">';
            $echo .= '<img src="'.$source.'" class="img-circle" height="55" width="55" alt="'.$name.'">';
            $echo .= '</div>
                        <a href="'.URL.'profile/member/'.($profile['slug']).'" class="poster-name text-left">'.$name.' </a>
                    </div>
                </div>';
            $echo .= '<div class="col-sm-9">
                    <div class="panel panel-default">';
            if($picture){
                $echo .= '<img src="'.URL.'public/uploads/wall/'.$picture.'" class="img-responsive" height="50%">';

            }
            $echo .= '<p>'.(nl2br(Input::get('message'))).'</p>';
            $echo .= '<div class="panel-footer text-left">';
            $echo .= '<span class="glyphicon glyphicon-time"></span>
                        <span class="liveTime" data-lta-value="'.Input::get('date').'">Just Now</span>
                            <a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'like_post\','.$insert_id.')" title="Like it" id="like-btn'. $insert_id.'">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Like
                            </a>';
            $echo .= '<a href="javascript:void(0);" onClick="callCrudAction(\'delete_post\','. $insert_id.')" title="Delete Post" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>';

            $echo .= '<div class="pull-right">
                                <a href="javascript:void(0);" id="like-count'. $insert_id.'" class="btn btn-link" data-toggle="popover" data-trigger="focus" data-content="No Likes"></a>
                                <a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="toggle(\'all_replies'. $insert_id.'\')" data-toggle="popover" data-trigger="hover" data-content="Add comments">
<i class="glyphicon glyphicon-comment" ></i> <span class="label label-default" id="reply-count'. $insert_id.'">Comment</span></a>
                            </div>';
            $echo .= '</div>';
            $echo .= '<div class="panel-body">
                            <div class="row">
                                <div class="comments" id="all_replies'.$insert_id.'">
                              </div>
                                <div id="post-reply'.$insert_id.'"></div>
                            </div>';
            $echo .= '<div class="panel-body">
                        <div class="row">
                            <div class="col-sm-2">';
            $echo .= '<img src="'.$source.'" class="img-rounded" height="30" width="30" alt="'.$name.'">';

            $echo .= '</div>
                        <div class="col-sm-10 text-left">
                            <form class="form-inline reply-tab" method="post" onsubmit="return false">
                                <div class="input-group">';
            $echo .= '<input type="text" class="form-control" size="50" id="txtmessage'.$insert_id.'" placeholder="Reply to Post... " required="required">';
            $echo .= '<input name="author_id" id="author_id" type="hidden" value="'. $_SESSION['user_id'].'" />';
            $echo .= '<input name="post_id" id="post_id" type="hidden" value="'.$insert_id.'" />';

            $echo .= '<div class="input-group-btn">
                        <button type="submit" class="btn reply-btn" onClick="callCrudAction(\'comment\','.$insert_id.')"><span class="glyphicon glyphicon-plus"></span></button>
                    </div>';
            $echo .= '</div>';
            $echo .= '</form>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '<br/>';


            echo($echo);


        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }


    function comment() {
        try {
            $this->db->insert('post_reply',array(
                'post_id' => Input::get("post_id"),
                'author' => $_SESSION['user_id'],
                'date_posted' => $this->today,
                'comment' => Input::get("txtmessage"),

            ));

            $insert_id = $this->db->last_insert_id();
            //get user details

            $profile = $this->db->fetch_exact('info_personal','user_id',$_SESSION['user_id']);
            $name = $profile['firstname']. ' '.$profile['surname'].' '.$profile['othername'];
            $pix = $this->user->get_profile_pic($profile['person_id']);
            if(!empty($pix['photo'])){
                $source = URL.'public/uploads/profile-pictures/'. $pix['photo'];
            }else{
                if($profile['sex']== 'Male'){
                    $avatar = 'male';
                }else{
                    $avatar = 'female';
                }
                $source = URL.'public/images/avatar-'.$avatar.'.png';
            }
            //output to wall

            $echo = '<div id="reply' . $insert_id . '">
                        <div class="col-sm-2">';

            $echo .= '<img src="'.$source.'" class="img-thumbnail" height="51px" width="51px"  alt="'.$name.'">';
        $echo .= '        </div>
                        <div class="col-sm-10 text-left text-holder">';

            $echo .= '<p><a href="'.URL.'profile/member/'.$profile['slug'].'" class="poster-name text-left">'.$name.'</a>: '.Input::get("txtmessage");
            $echo .= '<br/>';
            $echo .= '<span class="pull-right">
                            <span class="liveTime" data-lta-value="'.Input::get('date').'">Just Now</span>
                           <a  href="javascript:void(0);" onClick="callCrudAction(\'like_reply\','.$insert_id.')" id="like-reply'.$insert_id.'" data-toggle="popover" data-trigger="hover" data-content="Like" class="btn"><span class="glyphicon glyphicon-thumbs-up "></span></a>
                            <a href="javascript:void(0);" onclick="toggle(\'reply2comment'. $insert_id.'\')" data-toggle="popover" data-trigger="hover" data-content="React Now" class="btn" id="toggle-reply'. $insert_id.'"><span class="glyphicon glyphicon-share-alt"></span></a>
                            <a href="javascript:void(0);" onclick="callCrudAction(\'delete_comment\','.$insert_id.')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                        </span>
                                </p>';
            $echo .= '<br/>';

            $echo .= '<!-- reply to reply here -->';
            $echo .= '<div class="row reply2comment" style="display: none" id="reply2comment' . $insert_id . '"><span class="separator"></span>
                        <div class="panel-body" id="input_reply' . $insert_id . '">';

            $echo .= '<div class="col-sm-2">
                        <img src="'.$source.'" class="img-rounded" height="30" width="30"  alt="'.$name.'">';
            $echo .= '        </div>
                        <div class="col-sm-10 text-left">';

            $echo .= '<form class="form-inline reply-tab" method="post" onsubmit="return false">
                        <div class="input-group">
                        <input type="text" class="form-control" size="50"  id="reactMsg' . $insert_id . '" placeholder="React to Comment..." required="required">
                        <div class="input-group-btn">
                        <button type="submit" class="btn reply-btn-inverse" onClick="callCrudAction(\'react\',' . $insert_id . ')"><span class="glyphicon glyphicon-plus"></span></button></div>';

            $echo .= '</div>';
            $echo .= '</form>';

            $echo .= '</div>';
            $echo .= '</div>';
            $echo .= '<!-- end of cosmetic reply here -->';
            $echo .= '</div>';
            $echo .= '</div>';


            echo($echo);


        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }


    function react() {
        try {
            $this->db->insert('post_reply',array(
                'comment_id' => Input::get("reply_id"),
                'author' => $_SESSION['user_id'],
                'date_posted' => $this->today,
                'comment' => Input::get("txtmessage"),

            ));

            $insert_id = $this->db->last_insert_id();
            //get user details

            $profile = $this->db->fetch_exact('info_personal','user_id',$_SESSION['user_id']);
            $name = $profile['firstname']. ' '.$profile['surname'].' '.$profile['othername'];
            $pix = $this->user->get_profile_pic($profile['person_id']);
            if(!empty($pix['photo'])){
                $source = URL.'public/uploads/profile-pictures/'. $pix['photo'];
            }else{
                if($profile['sex']== 'Male'){
                    $avatar = 'male';
                }else{
                    $avatar = 'female';
                }
                $source = URL.'public/images/avatar-'.$avatar.'.png';
            }
            //output to wall

            $echo = '<div class="panel-body" id="comment_reply' . $insert_id . '">
                        <div class="col-sm-2">';

            $echo .= '<img src="'.$source.'" class="img-rounded" height="37px" width="37px"  alt="'.$name.'">';
            $echo .= '        </div>
                        <div class="col-sm-10 text-left text-holder">';

            $echo .= '<p><a href="'.URL.'profile/member/'.$profile['slug'].'" class="poster-name text-left">'.$name.'</a>: '.Input::get("txtmessage");
            $echo .= '<br/>';
            $echo .= '<!-- <span class="pull-right">
                            Just Now
                           <a  href="javascript:void(0);" onClick="callCrudAction(\'like_comment\','.$insert_id.')" title="2 Likes" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy" class="btn"><span class="glyphicon glyphicon-thumbs-up "></span></a>
                            <a href="javascript:void(0);" onclick="toggle(\'reply2comment'. $insert_id.'\')" title="3 Replies" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy, Mary" class="btn"><span class="glyphicon glyphicon-share-alt"></span></a>
                            <a href="javascript:void(0);" onclick="callCrudAction(\'delete_comment\','.$insert_id.')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                        </span>-->
                                </p>';

            $echo .= '<!-- reply to reply here -->';
            $echo .= '</div>';
            $echo .= '</div>';


            echo($echo);


        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    public function like($post, $id){
        try{
            if($post == 'post'){
                $this->db->insert('likes',array(
                    'post_id' => $id,
                    'user_id' => $_SESSION['user_id'],
                    'date' => $this->today,
                    'like' => 'Yes',
                ));
                //count no of likes
                $likes = $this->db->get_assoc('likes', array('post_id', '=', $id))->results_assoc();
                $no_of_likes = $this->db->count_assoc();

                if(($no_of_likes == 1)){
                    list($likers) = $this->user->get_person_name($likes[$no_of_likes-1]['user_id']);
                }else{
                    $likers = '';
                    for($i=0; $i < 3; $i++){
                        $obj = array_pop($likes);
                        if($obj == null) break;
                        list($name) = $this->user->get_person_name($obj['user_id']);
                        $likers .= $name.', ';
                    }
                    $likers = chop($likers, ", ");

                    if(($no_of_likes) > 3){
                        $likers = $likers.' + '.($no_of_likes - 3).' more';

                      }


                }


                $echo = '';
                if($no_of_likes == 1){
                    $echo = '<a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="'.$likers.'" id="like-count'.$id.'">';
                    $echo .= '<span class="badge"  id="like'.$id.'">1</span> You';
                    $echo .= '</a>';
                }elseif($no_of_likes == 2 ){
                    $echo = '<a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="'.$likers.'" id="like-count'.$id.'">';
                    $echo .= 'You + <span class="badge"  id="like'.$id.'">'.($no_of_likes -1). '</span>';
                    $echo .= '</a>';
                }elseif($no_of_likes >= 3){
                    $echo = '<a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-placement="left" data-trigger="hover" data-content="'.$likers.'" id="like-count'.$id.'">';
                    $echo .= 'You + <span class="badge"  id="like'.$id.'">'.($no_of_likes -1). '</span>';
                    $echo .= '</a>';

                }
                echo $echo;

                exit();

            }else{
                $this->db->insert('likes',array(
                    'reply_id' => $id,
                    'user_id' => $_SESSION['user_id'],
                    'date' => $this->today,
                    'like' => 'Yes',
                ));
                //count no of likes
                /*
                 * $likes = $this->db->get_assoc('likes', array('reply_id', '=', $id))->results_assoc();
                $no_of_likes = $this->db->count_assoc();
                if($no_of_likes == 1){
                    echo "You like this";
                }elseif($no_of_likes == 2 ){
                    echo "You like this + ".($no_of_likes -1). ' other';
                }elseif($no_of_likes >= 3){
                    echo "You like this + ".($no_of_likes -1). ' others';
                }
                exit();
                 */
                return true;

            }


        }catch (Exception $e){

        }

    }

    public function unlike($post, $id){
        try{
            if($post == 'post'){
                $this->db->delete('likes', array('post_id', '=', $id,'user_id', '=', Session::get('user_id')));
                //count no of likes
                $likes = $this->db->get_assoc('likes', array('post_id', '=', $id))->results_assoc();
                $no_of_likes = $this->db->count_assoc();
                if($no_of_likes == 0){
                    echo '<span class="badge"  id="like'.$id.'">0</span> Like';
                }elseif($no_of_likes == 1 ){
                    echo '<span class="badge"  id="like'.$id.'">1</span> Like';
                }elseif($no_of_likes >= 2){
                    echo '<span class="badge"  id="like'.$id.'">'.($no_of_likes -1). '</span> Likes';
                }
                exit();

            }else{
                $this->db->delete('likes', array('reply_id', '=', $id));
                $this->db->insert('likes',array(
                    'reply_id' => $id,
                    'user_id' => $_SESSION['user_id'],
                    'date' => $this->today,
                    'like' => 'Yes',
                ));
                //count no of likes
                $likes = $this->db->get_assoc('likes', array('reply_id', '=', $id))->results_assoc();
                $no_of_likes = $this->db->count_assoc();
                if($no_of_likes == 1){
                    echo '<span class="badge"  id="like'.$id.'">1</span> Like';
                }elseif($no_of_likes == 2 ){
                    echo '<span class="badge"  id="like'.$id.'">'.($no_of_likes -1). '</span> Likes';
                }elseif($no_of_likes >= 3){
                    echo '<span class="badge"  id="like'.$id.'">'.($no_of_likes -1). '</span> Likes';
                }
                exit();

            }


        }catch (Exception $e){

        }

    }

    public function delete($type, $id) {
        try {
            if($type == 'post'){
                $this->db->delete('post', array('post_id', '=', $id));
                return true;

            }elseif($type == 'comment'){
                $data = $this->db->fetch_exact('post_reply','reply_id',$id);
                if($data['post_id'])

                $this->db->delete('post_reply', array('reply_id', '=', $id));
                echo $data['post_id'];
            }elseif($type == 'document'){
                //check if the person deleting is the uploader
                $uploader = $this->db->fetch_exact('technical_papers','paper_id',$id);
                if($_SESSION['user_id'] === $uploader['uploaded_by'] ){
                    $this->db->delete('technical_papers', array('paper_id', '=', $id));

                }
                Redirect::to(URL.'wall/documents#documents');
            }

        } catch (Exception $e) {
            //echo $e->getTraceAsString();
            return false;
        }
    }

    public function events($act) {
        $user_id = Session::get('user_id');
        //first find events registered for
        $event_reg = array();
        $event = $this->db->get_assoc('event_registrations', array('user_id', '=', $_SESSION['user_id']),'event_id')->results_assoc();
        foreach($event as $reg){
            array_push($event_reg, $reg['event_id']);
        }

        switch($act){
            case 'manage':
                $first = $this->db->get_assoc('events', array('started_by', '=', $user_id),'event_id')->results_assoc();

                break;
            case 'trending':
                //ALL THE EVENTS
                $trending = array();
                $allEvents = $this->db->get_assoc('events', array('is_live', '=', 1),'event_id')->results_assoc();
                //trend only those found
                foreach($allEvents as $it){
                    if(!in_array($it['event_id'],$event_reg)){
                        array_push($trending, $it['event_id']);
                    }
                }
                $first = $trending;
                //die('events_id '. print_r($trending));

                break;
            case 'registered':
                $first = $event_reg;
                break;

        }


        return ($first);
        //
    }


}
