<?php
    $user = new User();
?>

<div class="container-fluid text-center" id="myBody">
<div class="row">
<div class="col-sm-3 well">
    <div class="well">
        <p>
            <a href="<?php echo(URL); ?>profile/member/<?php echo(Session::get('logged_in_user_slug')); ?>" ><?php echo(Session::get('logged_in_user_name')); ?> </a>

        </p>
        <img src="<?php echo Session::get('logged_in_user_photo'); ?>" class="img-circle" height="65" width="65" alt="<?php echo Session::get('logged_in_user_name'); ?>">


    </div>
    <div class="well sidenav">
        <p>My Church</p>
        <ul class="nav nav-pills nav-stacked">
            <li><a href="<?php echo(URL); ?>church">Dashboard</a></li>
            <li class="active"><a href="<?php echo(URL); ?>blog">Blog</a></li>
            <li><a href="<?php echo(URL); ?>download">Downloads</a></li>
            <li><a href="<?php echo(URL); ?>profile/member">Winner</a></li>
        </ul><br>
    </div>
    <div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p><strong>Church Details</strong></p>
        Feeling Blue...
    </div>
    <p><a href="<?php echo(URL); ?>profile/friends">My Friends</a></p>
    <p><a href="#">Link</a></p>
    <p><a href="#">Link</a></p>
</div>
<div class="col-sm-7">
    <?php $blog = $this->blog; ?>
<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-primary ">
            <div class="panel-heading text-holder"><h1> <?php echo($blog['post_title'])  ?></h1></div>
            <div class="panel-body text-left">
                <?php if (!empty($blog['featured_image'])){ ?>
                    <p><img src="<?php echo(URL.'public/uploads/blog/'.$blog['featured_image']); ?>" class="img-responsive" alt="<?php echo($blog['post_title']); ?>"></p>
                <?php } ?>
                <?php if (!empty($blog['subtitle'])){ ?>
                    <h4><small><?php echo($blog['subtitle'])  ?></small></h4>
                    <hr>
                <?php } ?>

                <?php
                    $category = $user->blog_category($blog['category'])
                ?>

                <h4>Category: <a href="<?php echo(URL); ?>blog/category/<?php echo($category['cat_slug']);  ?>" title="View All in this category"><?php echo($category['cat_name']);  ?></a> </h4>
                <?php
                    list($name, $source, $slug) = $user->get_person_name($blog['post_author']);

                    $date = new DateTime($blog['post_date']);
                    $dob = $date->format('d M, Y ');//h:i a
                ?>

                <h3><span class="glyphicon glyphicon-time"></span> Post by <a href="<?php echo(URL); ?>profile/member/<?php echo($slug);  ?>" title="View Writer's profile">
                        <?php echo($name); ?>
                        <img src="<?php echo $source; ?>" alt="<?php echo($name); ?>" class="img img-thumbnail" width="60px" height="60px" />
                    </a>: <?php echo($dob);  ?>.</h3>


                 <br>
                <p> <?php echo htmlspecialchars_decode($blog['post_content']);  ?> </p>
                <h5>
                    <?php if (!empty($blog['tags'])){
                        $tags = explode(',',$blog['tags']);
                        $i = count($tags);
                        $labels = array('default','primary','success','info','warning','danger');
                        for($x = 0; $x<$i; $x++){?>
                            <?php
                            $tag = $user->blog_tag($tags[$x])
                            ?>

                            <span class="label label-<?php echo($labels[$x])  ?>"><?php echo($tag['tag_name'])  ?></span>
                        <?php  }}?>
                </h5>
                <br>
                <p id="touched_me">If this post inspired you, made sense, got you thinking, or you just loved it... <a href="" title="It touched me"><span class="glyphicon glyphicon-heart"></span> Click here</a></p>
                <br>
                 <h4><img src="<?php echo Session::get('logged_in_user_photo'); ?>" alt="<?php echo(Session::get('logged_in_user_name')); ?>" id="image_path" class="img img-circle" width="60px" height="60px" />
                     <a href="<?php echo(URL); ?>profile/member/<?php echo(Session::get('logged_in_user_slug')); ?>" ><?php echo(Session::get('logged_in_user_name')); ?> </a> Leave a Comment </h4>

                <form action="<?php echo(URL.'blog/post_comment'); ?>" method="post" id="contact_form" enctype="multipart/form-data" onsubmit="return false">
                    <input type="hidden" id="comment_name" name="comment_name" value="<?php echo(Session::get('logged_in_user_name')); ?>">
                    <input type="hidden" id="user_id" name="user_id" value="<?php echo(Session::get('user_id')); ?>">
                    <input type="hidden" id="comment_email" name="comment_email" value="<?php echo(Session::get('email')); ?>">
                    <input type="hidden" id="comment_blog" name="comment_blog" value="<?php echo($blog['post_id']); ?>">
                    <div class="form-group">
                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <h4>Subscribe to Posts <small>Alerts will be sent to your inbox</small></h4>

                        <div class="row">
                            <div class="col-sm-6" id="category_subscription">
                                <?php if($this->suscribe2category){  ?>
                                    <p class="text-danger">You have subscribed to posts from this category</p>
                                    <label class="checkbox-inline"><input type="checkbox" value="yes" id="unsubscribe2category" onchange="subscriptions('unsubscribe','category')">Opt-out From this Category</label>
                                <?php }else{ ?>
                                    <label class="checkbox-inline"><input type="checkbox" value="yes" id="subscribe2category" onchange="subscriptions('subscribe','category')">From this Category</label>
                                <?php } ?>
                                <input type="hidden" id="blog_category" value="<?php echo($category['cat_id']);  ?>">

                            </div>
                            <div class="col-sm-6" id="author_subscription">
                                <?php if($this->suscribe2author){  ?>
                                    <p class="text-danger">You have subscribed to posts from this Author</p>
                                    <label class="checkbox-inline"><input type="checkbox" value="yes" id="unsubscribe2author" onchange="subscriptions('unsubscribe','author')">Opt-out From this Author</label>
                                <?php }else{ ?>
                                    <label class="checkbox-inline"><input type="checkbox" value="yes" id="subscribe2author" onchange="subscriptions('subscribe','author')">From this Author</label>
                                <?php } ?>


                                <input type="hidden" id="blog_author" value="<?php echo($blog['post_author']);  ?>">

                            </div>
                        </div>

                    </div>
                    <span id="status"></span>
                    <button type="submit" onclick="commentFromInside()" class="btn btn-success btn-block" id="submit">Submit</button>
                </form>
                <br><br>
                <?php
                    $comments = $user->get_blog_comments($blog['post_id']);
                    $counter = $user->count();

                ?>

                <p><span class="badge" id="comment_count"><?php echo($counter); ?></span> Comments: <a href="<?php echo(URL); ?>blog/author/<?php echo($slug);  ?>" > View All Posts by this Author (<?php echo($name);  ?>) </a></p><br>



            </div>
            <div class="panel-footer text-left">
                <div class="row">
                    <div id="new_addition"></div>

                    <?php
                        //blog comments generation
                        foreach($comments as $comment){
                            $date = new DateTime($comment['date']);
                            $dob = $date->format('d M, Y h:i a');
                            if($comment['user_id']){
                                list($name, $source, $slug) = $user->get_person_name($comment['user_id']);
                                ?>
                                <div id="message_<?php echo $comment["blog_comment_id"]; ?>">
                                    <div class="col-sm-2 text-center">
                                        <img src="<?php echo($source); ?>" class="img-circle" height="65" width="65" alt="<?php echo($name); ?>">
                                    </div>
                                    <div class="col-sm-10">
                                        <h4><a href="<?php echo(URL); ?>profile/member/<?php echo($slug);  ?>" title="View profile"><?php echo($name); ?></a> <small><?php echo($dob); ?></small></h4>
                                        <p class="message-content"><?php echo nl2br($comment['message']); ?></p>
                                        <?php
                                            if(Session::get('user_id') === $blog['post_author']){ ?>
                                                <div id="span_holder_<?php echo($comment["blog_comment_id"]); ?>">
                                                    <span class="btn btn-primary btn-xs" onclick="toggle('reply<?php echo($comment["blog_comment_id"]); ?>')">Reply </span> &nbsp;
                                                    <span class="btn btn-warning btn-xs" onClick="showEditBox(<?php echo $comment["blog_comment_id"]; ?>)">Moderate </span>&nbsp;
                                                    <span class="btn btn-danger btn-xs" onClick="blogBoxAction('delete','<?php echo($comment["blog_comment_id"]); ?>')" >Delete </span>


                                                </div>
                                                <div class="text-left blog-reply" id="reply<?php echo($comment["blog_comment_id"]); ?>">
                                                    <form role="form" method="post" onsubmit="return false">
                                                        <div class="form-group">
                                                            <div id="moderate_<?php echo($comment["blog_comment_id"]); ?>">
                                                                <label for="comment">Comment:</label>
                                                                <textarea class="form-control" rows="3" placeholder="Reply to this comment..."  id="txtmessage<?php echo($comment["blog_comment_id"]); ?>"></textarea>
                                                            </div>


                                                        </div>
                                                        <input name="author_id" id="author_id" type="hidden" value="<?php echo($blog['post_author']); ?>" />
                                                        <input name="blog_id" id="blog_id" type="hidden" value="<?php echo($blog['post_id']); ?>" />
                                                        <div class="btn-group btn-group-justified" id="sender_<?php echo($comment["blog_comment_id"]); ?>">
                                                            <a href="javascript:void(0);" class="btn reply-btn btn-sm" onClick="blogBoxAction('add','<?php echo($comment["blog_comment_id"]); ?>')" >Send</a>
                                                            <a href="javascript:void(0);" class="btn btn-default btn-xs"  onclick="toggle('reply<?php echo($comment["blog_comment_id"]); ?>')">Cancel</a>

                                                        </div>


                                                    </form>
                                                </div>

                                            <?php }  ?>
                                        <br>
                                        <?php
                                            $replies = $user->get_comment_reply($comment['blog_comment_id']);
                                            $appendix_count = $user->count();
                                        ?>

                                                <div class="row" id="appendix<?php echo($comment["blog_comment_id"]); ?>">
                                                    <p><span class="badge" id="appendix-count<?php echo($comment["blog_comment_id"]); ?>"><?php echo($appendix_count); ?></span> Response(s):</p><br>
                                                    <?php
                                                        foreach ($replies as $reply){
                                                            ?>
                                                            <?php
                                                            $date = new DateTime($reply['date']);
                                                            $dob = $date->format('d M, Y ');//h:i a
                                                            ?>
                                                            <?php
                                                            list($name, $source, $slug) = $user->get_person_name($reply['person_id']);

                                                            ?>
                                                            <div class="col-sm-2 text-center">
                                                        <img src="<?php echo($source); ?>" class="img-rounded" height="45" width="45" alt="<?php echo($name); ?>">
                                                    </div>
                                                    <div class="col-xs-10">
                                                        <h4><a href="<?php echo(URL); ?>profile/member/<?php echo($slug);  ?>" title="View profile"><?php echo($name); ?></a> <small><?php echo($dob); ?></small></h4>

                                                        <p><?php echo(nl2br($reply['reply'])); ?></p>
                                                        <br>
                                                    </div>
                                            <?php }?>
                                </div>

                                    </div>


                                </div>


                            <?php }else{  ?>
                            <div id="message_<?php echo $comment["blog_comment_id"]; ?>">
                                <div class="col-sm-2 text-center">
                                    <img src="<?php echo(URL); ?>public/images/avatar.jpg" class="img-circle" height="65" width="65" alt="<?php echo $comment['name']; ?>">
                                </div>
                                <div class="col-sm-10">
                                    <h4><?php echo $comment['name']; ?> <small><?php echo($dob); ?></small></h4>
                                    <p><?php echo nl2br($comment['message']); ?></p>
                                    <?php
                                        if(Session::get('user_id') === $blog['post_author']){ ?>
                                            <div id="span_holder_<?php echo($comment["blog_comment_id"]); ?>">
                                                <span class="btn btn-primary btn-xs" onclick="toggle('reply<?php echo($comment["blog_comment_id"]); ?>')">Reply </span> &nbsp;
                                                <span class="btn btn-warning btn-xs" onClick="showEditBox(<?php echo $comment["blog_comment_id"]; ?>)">Moderate </span>&nbsp;
                                                <span class="btn btn-danger btn-xs" onClick="blogBoxAction('delete','<?php echo($comment["blog_comment_id"]); ?>')" >Delete </span>


                                            </div>
                                            <div class="text-left blog-reply" id="reply<?php echo($comment["blog_comment_id"]); ?>">
                                                <form role="form" method="post" onsubmit="return false">
                                                    <div class="form-group">
                                                        <div id="moderate_<?php echo($comment["blog_comment_id"]); ?>">
                                                            <label for="comment">Comment:</label>
                                                            <textarea class="form-control" rows="3" placeholder="Reply to this comment..."  id="txtmessage<?php echo($comment["blog_comment_id"]); ?>"></textarea>
                                                        </div>


                                                    </div>
                                                    <input name="author_id" id="author_id" type="hidden" value="<?php echo($blog['post_author']); ?>" />
                                                    <input name="blog_id" id="blog_id" type="hidden" value="<?php echo($blog['post_id']); ?>" />
                                                    <div class="btn-group btn-group-justified" id="sender_<?php echo($comment["blog_comment_id"]); ?>">
                                                        <a href="javascript:void(0);" class="btn reply-btn btn-sm" onClick="blogBoxAction('add','<?php echo($comment["blog_comment_id"]); ?>')" >Send</a>
                                                        <a href="javascript:void(0);" class="btn btn-default btn-xs"  onclick="toggle('reply<?php echo($comment["blog_comment_id"]); ?>')">Cancel</a>

                                                    </div>


                                                </form>
                                            </div>

                                        <?php }  ?>
                                    <br>
                                    <?php
                                        $replies = $user->get_comment_reply($comment['blog_comment_id']);
                                        $appendix_count = $user->count();
                                    ?>

                                    <div class="row" id="appendix<?php echo($comment["blog_comment_id"]); ?>">
                                        <p><span class="badge" id="appendix-count<?php echo($comment["blog_comment_id"]); ?>"><?php echo($appendix_count); ?></span> Response(s):</p><br>
                                        <?php
                                            foreach ($replies as $reply){
                                        ?>
                                        <?php
                                            $date = new DateTime($reply['date']);
                                            $dob = $date->format('d M, Y ');//h:i a
                                        ?>
                                        <?php
                                            list($name, $source, $slug) = $user->get_person_name($reply['person_id']);

                                        ?>
                                                <div class="col-sm-2 text-center">
                                                    <img src="<?php echo($source); ?>" class="img-circle" height="65" width="65" alt="<?php echo($name); ?>">
                                                </div>
                                                <div class="col-xs-10">
                                                    <h4><?php echo($name); ?> <small><?php echo($dob); ?></small></h4>
                                                    <p><?php echo(nl2br($reply['reply'])); ?></p>
                                                    <br>
                                                </div>
                                            </div>

                                        <?php }?>
                                </div>
                            </div>
                        <?php }  ?>


                            <?php
                            ?>
                        <?php } ?>



                    <div class="col-sm-2 text-center">
                        <img src="<?php echo(URL); ?>public/images/avatar-male.png" class="img-circle" height="65" width="65" alt="Avatar">
                    </div>
                    <div class="col-sm-10">
                        <h4>Anja <small>Sep 29, 2015, 9:12 PM</small></h4>
                        <p>Keep up the GREAT work! I am cheering for you!! Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <br>
                    </div>
                    <div class="col-sm-2 text-center">
                        <img src="<?php echo(URL); ?>public/images/avatar-female.png" class="img-circle" height="65" width="65" alt="Avatar">
                    </div>
                    <div class="col-sm-10">
                        <h4>John Row <small>Sep 25, 2015, 8:25 PM</small></h4>
                        <p>I am so happy for you man! Finally. I am looking forward to read about your trendy life. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <br>
                        <p><span class="badge">1</span> Comment:</p><br>
                        <div class="row">
                            <div class="col-sm-2 text-center">
                                <img src="<?php echo(URL); ?>public/images/avatar.jpg" class="img-circle" height="65" width="65" alt="Avatar">
                            </div>
                            <div class="col-xs-10">
                                <h4>Nested Bro <small>Sep 25, 2015, 8:28 PM</small></h4>
                                <p>Me too! WOW!</p>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-8">
                <div class="well">
                    <h4>Write New</h4>
                    <p>Don't underestimate yourself, and remember that what ever you have written will surely be relevant to someone someday!</p>
                    <a href="<?php echo(URL); ?>blog/write" class="btn btn-success">Start</a>
                    <a href="<?php echo(URL); ?>profile/member" class="btn btn-default">View Suggestions </a>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="well">
                    <h4>Suggest</h4>
                    <p>Suggest to the contributors on what should be written</p>
                    <a href="" class="btn btn-success">Start</a>
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

