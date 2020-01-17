<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>

<?php
    $photo = $this->person[0]['photo'];
    if(!empty($photo)){
        $myPhoto = URL.'public/uploads/profile-pictures/'.$photo;

    }else{
        if($this->person['sex']== 'Male'){
            $myPhoto = URL.'public/images/avatar-male.png';
        }else{
            $myPhoto = URL.'public/images/avatar-female.png';
        }
    }
    $status = $this->person[0]['status'];
    $me = $this->person['firstname'].' '.$this->person['surname'].' '.$this->person['othername'];
?>
<div class="container-fluid text-center" id="myBody">
    <div class="row">
        <div class="col-sm-3 well">
            <div class="well">

                <p>
                    <a href="<?php echo(URL); ?>profile/member/<?php echo($this->person['slug']); ?>" ><?php echo (Session::get('logged_in_user_name')); ?> </a>

                </p>
                <img src="<?php echo(Session::get('logged_in_user_photo')); ?>" class="img-circle"height="65" width="65" alt="<?php echo (Session::get('logged_in_user_name')); ?>">



            </div>
            <div class="well">
                <p><a href="#">MY Interests</a></p>
                <p>
                    <a href="#" class="btn btn-xs btn-default">CCU-LFC Ifite</a>
                    <a href="#" class="btn btn-xs btn-primary">Abundance WSF</a>
                    <a href="#" class="btn btn-xs btn-success">Technical-LFC Gwarinpa</a>
                    <a href="#" class="btn btn-xs btn-info">Security-LFC Ifite</a>
                    <a href="#" class="btn btn-xs btn-warning">FYF 2017- LFC Ifite</a>
                    <a href="#" class="btn btn-xs btn-danger">Other Units</a>
                </p>
            </div>
            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p><strong>MY Status</strong></p>
                Feeling Blue...
            </div>
            <p><a href="<?php echo(URL); ?>profile/friends">My Friends</a></p>
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
        </div>
        <div class="col-sm-7">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default text-left">
                        <div class="panel-body">
                            <form name="main_post" id="main_post" method="post" action="<?php echo URL; ?>wall/post" onsubmit="return false">
                                <p id="output"></p>
                                <textarea class="form-control" id="post_message" name="post_message" placeholder="What is on your mind... <?php echo $me; ?>?" rows="3" required="required" ></textarea><br>
                                <div>
                                    <div class=" form-group col-sm-9">
                                        <div class="pull-left">
                                            <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                                            <label class="btn btn-default btn-xs btn-file">
                                                <span><i class="glyphicon glyphicon-camera"></i> Add Photo</span>
                                                <input type="file" name="filename" id="filename" class="btn btn-default"
                                                       data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                                                       data-postmax="<?php echo $_SESSION['postmax']; ?>"
                                                       data-displaymax="<?php echo $_SESSION['displaymax']; ?>"

                                                    />
                                            </label>



                                        </div>



                                    </div>

                                    <div class="pull-right" id="post">
                                        <button type="submit" class="btn btn-default btn-sm" onclick="callCrudAction('post',1)">
                                            <span class="glyphicon glyphicon-pencil"></span> Post
                                        </button>

                                    </div>


                                </div>

                            </form>

                        </div>
                    </div>
                </div>
            </div>

            <span id="wall_post"></span>
            <?php
                $data = $this->wall_post;

            ?>

            <?php

                foreach($data as $d){
                    list($name, $source, $slug) = $user->get_person_name($d['author_id']);

                    if($d['post_image']){
                        $picture = '<img src="'.URL.'public/uploads/wall/'.$d['post_image'].'" class="img-responsive" height="50%">';
                    }else{
                        $picture = '';
                    }
                    ?>
                    <div class="row" id="post_holder<?php echo($d['post_id']); ?>">
                        <div class="col-sm-3">
                            <div class="panel panel-default">
                                <div class="panel-body">

                                    <img src="<?php echo($source); ?>" class="img-circle" height="55" width="55" alt="<?php echo($name); ?>">
                                </div>
                                <a href="<?php echo(URL); ?>profile/member/<?php echo($slug); ?>" class="poster-name text-left"><?php echo($name); ?> </a>
                            </div>
                        </div>
                        <div class="col-sm-9">
                            <div class="panel panel-default">
                                <?php echo($picture); ?>

                                <p><?php echo($d['message']); ?></p>
                                <div class="panel-footer text-left">
                                    <?php
                                        list($likes,$like_count,$user_likes_it,$likers) = $user->get_liked(Session::get('user_id'),'post_id',$d['post_id']);
                                    ?>
                                    <span class="glyphicon glyphicon-time"></span>
                                    <span class="liveTime" data-lta-value="<?php echo($d['when']); ?>"></span> &nbsp;&nbsp;
                                    <?php
                                    if(!$user_likes_it){
                                    ?>
                                        <a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction('like_post','<?php echo($d['post_id']); ?>')" title="Like it" id="like-btn<?php echo($d['post_id']); ?>">
                                            <span class="glyphicon glyphicon-thumbs-up"></span> Like
                                        </a>

                                    <?php }else{ ?>
                                        <a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction('unlike_post','<?php echo($d['post_id']); ?>')" title="Unlike it" id="like-btn<?php echo($d['post_id']); ?>">
                                            <span class="glyphicon glyphicon-thumbs-down"></span> Unlike
                                        </a>

                                    <?php } ?>
                                    <?php
                                    if(Session::get('user_id') == $d['author_id']){
                                    ?>
                                    <a href="javascript:void(0);" onClick="callCrudAction('delete_post','<?php echo($d['post_id']); ?>')" title="Delete Post" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                    <?php }  ?>

                                    <div class="pull-right">
                                        <a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-trigger="hover" data-content="<?php echo($likers); ?>" id="like-count<?php echo($d['post_id']); ?>"><?php echo($like_count); ?></a>
                                        <?php
                                            $replies = $user->get_post_reply($d['post_id']);
                                        ?>
                                        <?php
                                            $reply_count = $user->count();
                                            if($reply_count == 0){
                                                $reply_count = 'Comment';
                                                $reply_content = 'No Comments yet';
                                            }else{
                                                $reply_content = 'Click to view comments';
                                            }
                                        ?>

                                        <a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="toggle('all_replies<?php echo($d['post_id']); ?>')" data-toggle="popover" data-trigger="hover" data-content="<?php echo($reply_content); ?>">
                                            <i class="glyphicon glyphicon-comment" ></i> <span class="label label-default" id="reply-count<?php echo($d['post_id']); ?>"><?php echo($reply_count); ?></span></a>
                                    </div>
                                </div>
                                <!--########## Main Replies to a Post ####### -->
                                <div class="panel-body">
                                    <div class="row">
                                        <!-- all replies fall in here -->
                                        <div class="comments" id="all_replies<?php echo($d['post_id']); ?>">
                                        <?php
                                            foreach($replies as $reply){
                                                list($author, $author_img, $author_slug) = $user->get_person_name($reply['author']);
                                            ?>
                                                <div id="reply<?php echo($reply['reply_id']); ?>">
                                                    <div class="col-sm-2">
                                                        <img src="<?php echo($author_img); ?>" class="img-thumbnail" height="51px" width="51px"  alt="<?php echo($author); ?>">
                                                    </div>
                                                    <div class="col-sm-10 text-left text-holder">
                                                        <p><a href="<?php echo(URL); ?>profile/member/<?php echo($author_slug); ?>" class="poster-name text-left"><?php echo($author); ?></a>: <?php echo($reply['comment']); ?>
                                            <br/>
                                            <span class="pull-right">
                                                <span class="liveTime" data-lta-value="<?php echo($reply['date_posted']); ?>"></span>
                                                <?php
                                                    //for reactions to comments
                                                    $react = $user->get_reply_reaction($reply['reply_id']);
                                                ?>
                                                <?php
                                                    $react_count = $user->count();
                                                    if($react_count == 0){
                                                        $react_count = '';
                                                        $react_content = ' data-content="Be the first" ';
                                                    }elseif($react_count == 1){
                                                        $react_content = 'data-content="1 Reaction"';

                                                    }elseif($react_count >= 2){
                                                        $react_content = 'data-content="'.$react_count.' Reactions"';
                                                }
                                                ?>
                                                <?php
                                                    list($react_likes,$react_like_count,$user_likes_it,$react_likers) = $user->get_reply_likes(Session::get('user_id'),'reply_id',$reply['reply_id']);
                                                ?>
                                                <?php
                                                    if(!$user_likes_it){
                                                        ?>
                                                        <a  href="javascript:void(0);" id="like-reply<?php echo($reply['reply_id']); ?>" onClick="callCrudAction('like_reply','<?php echo($reply['reply_id']); ?>')"  data-toggle="popover" data-trigger="hover" class="btn" <?php echo($react_like_count); ?> ><span class="glyphicon glyphicon-thumbs-up "></span></a>
                                                    <?php }else{ ?>
                                                        <a  href="javascript:void(0);" id="like-reply<?php echo($reply['reply_id']); ?>" onClick="callCrudAction('unlike_reply','<?php echo($reply['reply_id']); ?>')"  data-toggle="popover" data-trigger="hover" class="btn" <?php echo($react_like_count); ?> ><span class="glyphicon glyphicon-thumbs-down "></span></a>

                                                    <?php } ?>

                                                <a href="javascript:void(0);" onclick="toggle('reply2comment<?php echo($reply['reply_id']); ?>')"  data-toggle="popover" data-trigger="hover" <?php echo($react_content); ?> class="btn" id="toggle-reply<?php echo($reply['reply_id']); ?>"><span class="glyphicon glyphicon-share-alt"></span></a>
                                                <?php
                                                    if(Session::get('user_id') == $reply['author']){
                                                        ?>
                                                        <a href="javascript:void(0);" onclick="callCrudAction('delete_comment','<?php echo($reply['reply_id']); ?>')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                                    <?php }  ?>

                                            </span>
                                                        </p>
                                                        <br/>

                                                    <div class="row reply2comment" style="display: none" id="reply2comment<?php echo($reply['reply_id']); ?>">
                                                        <span class="separator"></span>
                                                        <?php
                                                            echo($react);
                                                             ?>

                                                        <div class="panel-body" id="input_reply<?php echo($reply['reply_id']); ?>">
                                                            <div class="col-sm-2">
                                                                <img src="<?php echo URL; ?>public/uploads/profile-pictures/<?php echo $photo; ?>" class="img-rounded" height="30" width="30" alt="<?php echo($me); ?>">
                                                            </div>

                                                            <div class="col-sm-10 text-left">
                                                                <form class="form-inline reply-tab" method="post" onsubmit="return false">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control" size="50"  id="reactMsg<?php echo($reply['reply_id']); ?>" placeholder="React to Comment..." required="required">
                                                                        <div class="input-group-btn">
                                                                            <button type="submit" class="btn reply-btn-inverse" onClick="callCrudAction('react','<?php echo($reply['reply_id']); ?>')"><span class="glyphicon glyphicon-plus"></span></button>
                                                                        </div>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    </div>

                                                </div>
                                            <?php } ?>

                                        </div>
                                        <div id="post-reply<?php echo($d['post_id']); ?>"></div>
                                    <!--########## End Main Replies to a Post ####### -->
                                    </div>
                                    <!--########## Post comment section ####### -->

                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img src="<?php echo $myPhoto; ?>" class="img-rounded" height="30" width="30" alt="<?php echo $me; ?>">
                                            </div>
                                            <div class="col-sm-10 text-left">
                                                <form class="form-inline reply-tab" method="post" onsubmit="return false">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" size="50" id="txtmessage<?php echo($d['post_id']); ?>" placeholder="Reply to Post... " required="required">
                                                        <input name="author_id" id="author_id" type="hidden" value="<?php echo($d['author_id']); ?>" />
                                                        <input name="post_id" id="post_id" type="hidden" value="<?php echo($d['post_id']); ?>" />
                                                        <div class="input-group-btn">
                                                            <button type="submit" class="btn reply-btn" onClick="callCrudAction('comment','<?php echo($d['post_id']); ?>')"><span class="glyphicon glyphicon-plus"></span></button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

            <?php
                }
            ?>

            <div id="load_more_wall_post">

            </div>
            <div id="end_of_doc">

            </div>

            <div class="row" id="wrap">
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-circle" height="55" width="55" alt="Avatar">
                        </div>
                        <a href="#" class="poster-name text-left">Adekunle Adedidran</a>
                    </div>

                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <img src="<?php echo $myPhoto; ?>" class="img-responsive" alt="<?php echo $me; ?>">
                        <p>
                            Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                        <div class="panel-footer text-left">
                            2 hours ago
                            <a href="#" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Like
                            </a>

                            <a href="javascript:void(0);" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                            <div class="pull-right">
                                <a href="javascript:void(0);" class="btn btn-link" data-toggle="popover" data-trigger="focus" data-content="Joseph Blessing, Maku Stephens, Henry Owo, Sodeyi Mary"><span class="badge">4</span> Likes</a>

                                <a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="toggle('post1')">
                                    <span class="glyphicon glyphicon-comment"></span> 3
                                </a>
                            </div>

                        </div>
                        <div class="panel-body">
                            <div class="row comments" id="post1">
                                <div id="reply1">
                                    <div class="col-sm-2">
                                        <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-thumbnail" height="51px" width="51px"  alt="Avatar">
                                    </div>
                                    <div class="col-sm-10 text-left text-holder">
                                        <p><a href="#" class="poster-name text-left">Mercy Musa</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait.
                                        <span class="pull-right">
                                            4 mins ago
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="2 Likes" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy" class="btn"><span class="glyphicon glyphicon-thumbs-up "></span></a>
                                            <a href="javascript:void(0);" onclick="toggle('reply2comment1')" title="3 Replies" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy, Mary" class="btn"><span class="glyphicon glyphicon-share-alt"></span></a>
                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>
                                        </p>

                                        <div class="row reply2comment" style="display: none" id="reply2comment1">
                                            <span class="separator"></span>
                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-rounded" height="37px" width="37px"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Joy Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don'tno I don't no I don't.
                                                                                            <span class="pull-right">
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="Like" class="btn"><span class="glyphicon glyphicon-thumbs-up ">  </span></a>

                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>

                                                    </p>
                                                </div>

                                            </div>
                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-responsive"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Adekunle Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="panel-body" id="input_reply">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-rounded" height="30" width="30" alt="Avatar">
                                                </div>

                                                <div class="col-sm-10 text-left">
                                                    <form class="form-inline reply-tab">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" size="50" placeholder="Type Reply...">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn reply-btn"><span class="glyphicon glyphicon-plus"></span></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="reply2">
                                    <div class="col-sm-2">
                                        <img src="<?php echo URL; ?>public/custom/img/avatar04.png" class="img-thumbnail" height="51px" width="51px"  alt="Avatar">
                                    </div>
                                    <div class="col-sm-10 text-left text-holder">
                                        <p><a href="#" class="poster-name text-left">Mark Musa</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait.
                                        <span class="pull-right">
                                            4 mins ago
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="2 Likes" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy" class="btn"><span class="glyphicon glyphicon-thumbs-up "></span></a>
                                            <a href="javascript:void(0);" onclick="toggle('reply2comment2')" title="3 Replies" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy, Mary" class="btn"><span class="glyphicon glyphicon-share-alt"></span></a>
                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>
                                        </p>
                                        <br/>
                                        <div class="row reply2comment" style="display: none" id="reply2comment2">

                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-rounded" height="37px" width="37px"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Joy Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don'tno I don't no I don't.
                                                                                            <span class="pull-right">
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="Like" class="btn"><span class="glyphicon glyphicon-thumbs-up ">  </span></a>

                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>

                                                    </p>
                                                </div>

                                            </div>
                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-responsive"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Adekunle Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="panel-body" id="input_reply">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-rounded" height="30" width="30" alt="Avatar">
                                                </div>

                                                <div class="col-sm-10 text-left">
                                                    <form class="form-inline reply-tab">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" size="50" placeholder="Reply to Comment...<?php echo $me; ?>">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn reply-btn"><span class="glyphicon glyphicon-plus"></span></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <br/>




                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-rounded" height="30" width="30" alt="Avatar">
                                    </div>
                                    <div class="col-sm-10 text-left">
                                        <form class="form-inline reply-tab">
                                            <div class="input-group">
                                                <input type="text" class="form-control" size="50" placeholder="Reply to Post... <?php echo $me; ?> ">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn reply-btn"><span class="glyphicon glyphicon-plus"></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <div class="panel panel-default">
                        <div class="panel-body">

                            <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-circle" height="55" width="55" alt="Avatar">
                        </div>
                        <a href="#" class="poster-name text-left">Faith Kunle KabahKemi</a>
                    </div>

                </div>
                <div class="col-sm-9">
                    <div class="panel panel-default">
                        <p>
                            Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.</p>
                        <div class="panel-footer text-left">
                            2 hours ago
                            <a href="javascript:void(0);" class="btn btn-default btn-sm">
                                <span class="glyphicon glyphicon-thumbs-up"></span> Like
                            </a>

                            <a href="javascript:void(0);" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                            <div class="pull-right">
                                <a href="javascript:void(0);" class="btn btn-link btn-sm" data-toggle="popover" data-trigger="focus" data-content="Joseph Blessing, Maku Stephens, Henry Owo, Sodeyi Mary"><span class="badge">4</span> Likes</a>

                                <a href="javascript:void(0);" class="btn btn-default btn-sm" onclick="toggle('post1')"> 3
                                    <span class="glyphicon glyphicon-comment"></span>
                                </a>
                            </div>

                        </div>
                        <div class="panel-body">
                            <div class="row comments" id="post1">
                                <div id="reply1">
                                    <div class="col-sm-2">
                                        <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-thumbnail" height="51px" width="51px"  alt="Avatar">
                                    </div>
                                    <div class="col-sm-10 text-left text-holder">
                                        <p><a href="#" class="poster-name text-left">Mercy Musa</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait.
                                        <span class="pull-right">
                                            4 mins ago
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="2 Likes" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy" class="btn"><span class="glyphicon glyphicon-thumbs-up "></span></a>
                                            <a href="javascript:void(0);" onclick="toggle('reply2comment1')" title="3 Replies" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy, Mary" class="btn"><span class="glyphicon glyphicon-share-alt"></span></a>
                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>
                                        </p>

                                        <div class="row reply2comment" style="display: none" id="reply2comment1">
                                            <span class="separator"></span>
                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-rounded" height="37px" width="37px"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Joy Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don'tno I don't no I don't.
                                                                                            <span class="pull-right">
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="Like" class="btn"><span class="glyphicon glyphicon-thumbs-up ">  </span></a>

                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>

                                                    </p>
                                                </div>

                                            </div>
                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-responsive"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Adekunle Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="panel-body" id="input_reply">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-rounded" height="30" width="30" alt="Avatar">
                                                </div>

                                                <div class="col-sm-10 text-left">
                                                    <form class="form-inline reply-tab">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" size="50" placeholder="Type Reply...">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn reply-btn"><span class="glyphicon glyphicon-plus"></span></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <div id="reply2">
                                    <div class="col-sm-2">
                                        <img src="<?php echo URL; ?>public/custom/img/avatar04.png" class="img-thumbnail" height="51px" width="51px"  alt="Avatar">
                                    </div>
                                    <div class="col-sm-10 text-left text-holder">
                                        <p><a href="#" class="poster-name text-left">Mark Musa</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait.
                                        <span class="pull-right">
                                            4 mins ago
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="2 Likes" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy" class="btn"><span class="glyphicon glyphicon-thumbs-up "></span></a>
                                            <a href="javascript:void(0);" onclick="toggle('reply2comment2')" title="3 Replies" data-toggle="popover" data-trigger="hover" data-content="Jacob, Lucy, Mary" class="btn"><span class="glyphicon glyphicon-share-alt"></span></a>
                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>
                                        </p>
                                        <br/>
                                        <div class="row reply2comment" style="display: none" id="reply2comment2">

                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-rounded" height="37px" width="37px"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Joy Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don'tno I don't no I don't.
                                                                                            <span class="pull-right">
                                           <a  href="javascript:void(0);" onclick="like('reply2comment1')" title="Like" class="btn"><span class="glyphicon glyphicon-thumbs-up ">  </span></a>

                                            <a href="javascript:void(0);" onclick="remove('reply2comment1')" title="Remove" class="btn"> <span class="glyphicon glyphicon-remove"></span></a>
                                        </span>

                                                    </p>
                                                </div>

                                            </div>
                                            <div class="panel-body" id="comment_replies">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-responsive"  alt="Avatar">
                                                </div>
                                                <div class="col-sm-10 text-left text-holder">
                                                    <p>
                                                        <a href="#" class="poster-name text-left">Adekunle Adedidran</a>: Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.... no I don't.
                                                    </p>
                                                </div>

                                            </div>

                                            <div class="panel-body" id="input_reply">
                                                <div class="col-sm-2">
                                                    <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-rounded" height="30" width="30" alt="Avatar">
                                                </div>

                                                <div class="col-sm-10 text-left">
                                                    <form class="form-inline reply-tab">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" size="50" placeholder="Reply to Comment...">
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn reply-btn"><span class="glyphicon glyphicon-plus"></span></button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <br/>




                            </div>
                            <div class="panel-body">
                                <div class="row">
                                    <div class="col-sm-2">
                                        <img src="<?php echo URL; ?>public/custom/img/avatar.png" class="img-rounded" height="30" width="30" alt="Avatar">
                                    </div>
                                    <div class="col-sm-10 text-left">
                                        <form class="form-inline reply-tab">
                                            <div class="input-group">
                                                <input type="text" class="form-control" size="50" placeholder="Reply to Post...">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn reply-btn"><span class="glyphicon glyphicon-plus"></span></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-2 well">
            <div class="thumbnail mandate">
                <h4>August 2016:</h4>
                <p><strong>I am set for an Encounter with Power</strong></p>
                <p>Psalms 63:1-5</p>

            </div>
            <div class="well">
                <p>ADS</p>
            </div>
            <div class="well">
                <p>ADS</p>
            </div>
        </div>
    </div>
</div>

