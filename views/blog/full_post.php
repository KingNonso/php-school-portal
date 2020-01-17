<?php
    $user = new User();
?>
<?php $blog = $this->blog; ?>


<br/>
<div id="homecontent" class="container-fluid ">
<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div class="panel-heading text-holder"><h1> <?php echo($blog['post_title']) ?></h1></div>
<div class="panel-body text-left">
    <?php if (!empty($blog['featured_image'])) { ?>
        <p class="text-center"><img src="<?php echo(URL . 'public/uploads/blog/' . $blog['featured_image']); ?>" class="img-responsive text-center" alt="<?php echo($blog['post_title']); ?>"></p>
    <?php } ?>
    <?php if (!empty($blog['subtitle'])) { ?>
        <h4><small><?php echo($blog['subtitle']) ?></small></h4>
        <hr>
    <?php } ?>

    <?php
        $category = $user->blog_category($blog['category'])
    ?>

    <h4>Category: <a href="<?php echo(URL); ?>blog/category/<?php echo($category['cat_slug']); ?>" title="View All in this category"><?php echo($category['cat_name']); ?></a> </h4>
    <?php
        list($name, $source, $slug) = $user->get_person_name($blog['post_author']);

        $date = new DateTime($blog['post_date']);
        $dob = $date->format('d M, Y '); //h:i a
    ?>

    <h3><span class="glyphicon glyphicon-time"></span> Post by <a href="<?php echo(URL); ?>profile/member/<?php echo($slug); ?>" title="View Writer's profile">
            <?php echo($name); ?>
            <img src="<?php echo $source; ?>" alt="<?php echo($name); ?>" class="img img-thumbnail" width="60px" height="60px" />
        </a>: <?php echo($dob); ?>.</h3>


    <br>
    <p> <?php echo htmlspecialchars_decode($blog['post_content']); ?> </p>
    <h5>
        <?php
            if (!empty($blog['tags'])) {
                $tags = explode(',', $blog['tags']);
                $i = count($tags);
                $labels = array('default', 'primary', 'success', 'info', 'warning', 'danger');
                for ($x = 0; $x < $i; $x++) {
                    ?>
                    <?php
                    $tag = $user->blog_tag($tags[$x])
                    ?>

                    <span class="label label-<?php echo($labels[$x]) ?>"><?php echo($tag['tag_name']) ?></span>
                <?php }
            } ?>
    </h5>
    <br>
    <!--
    <p id="touched_me">If this post inspired you, made sense, got you thinking, or you just loved it... <a href="" title="It touched me"><span class="glyphicon glyphicon-heart"></span> Click here</a></p> -->
    <br>
    <h4><img src="<?php echo (URL . 'public/images/avatar.jpg'); ?>" alt="User" id="image_path" class="img img-circle" width="60px" height="60px" />
        Leave a Comment: </h4>


    <form action="<?php echo(URL . 'blog/post_comment'); ?>" method="post" id="contact_form" enctype="multipart/form-data" onsubmit="return false">
        <div class="row">
            <div class="col-sm-6 form-group">
                <input class="form-control" id="comment_name" name="comment_name" placeholder="Name " type="text" required>
            </div>
            <div class="col-sm-6 form-group">
                <input class="form-control" id="comment_email" name="comment_email" type="text" required>
            </div>
        </div>
        <textarea class="form-control" id="comment" name="comment" placeholder="Comment" rows="3"></textarea>
        <script src='https://www.google.com/recaptcha/api.js'></script>
        <div class="row">
            <div class="col-sm-12 form-group">
                <div class="g-recaptcha" data-sitekey="6LeWVSgTAAAAAMAHV2Dl4t9z7AGKxexuUFjoxZGh"></div>
            </div>
        </div>

        <input type="hidden" id="comment_blog" name="comment_blog" value="<?php echo($blog['post_id']); ?>">
        <div class="form-group">
            <h4 class="text-center">Subscribe to Posts <small>Alerts will be sent to your inbox</small></h4>

            <div class="row">
                <div class="col-sm-6" id="category_subscription">
                    <?php if ($this->suscribe2category) { ?>
                        <p class="text-danger">You have subscribed to posts from this category</p>
                        <label class="checkbox-inline"><input type="checkbox" value="yes" id="unsubscribe2category" onchange="subscriptions('unsubscribe', 'category')">Opt-out From this Category</label>
                    <?php } else { ?>
                        <label class="checkbox-inline"><input type="checkbox" value="yes" id="subscribe2category" onchange="subscriptions('subscribe', 'category')">From this Category</label>
                    <?php } ?>
                    <input type="hidden" id="blog_category" value="<?php echo($category['cat_id']); ?>">

                </div>
                <div class="col-sm-6" id="author_subscription">
                    <?php if ($this->suscribe2author) { ?>
                        <p class="text-danger">You have subscribed to posts from this Author</p>
                        <label class="checkbox-inline"><input type="checkbox" value="yes" id="unsubscribe2author" onchange="subscriptions('unsubscribe', 'author')">Opt-out From this Author</label>
                    <?php } else { ?>
                        <label class="checkbox-inline"><input type="checkbox" value="yes" id="subscribe2author" onchange="subscriptions('subscribe', 'author')">From this Author</label>
                    <?php } ?>


                    <input type="hidden" id="blog_author" value="<?php echo($blog['post_author']); ?>">

                </div>
            </div>

        </div>
        <span id="status"></span>
        <button type="submit" onclick="commentFromOutside()" class="btn btn-success btn-block" id="submit">Submit</button>
    </form>
    <br><br>
    <?php
        $comments = $user->get_blog_comments($blog['post_id']);
        $counter = $user->count();
    ?>

    <p><span class="badge" id="comment_count"><?php echo($counter); ?></span> Comments: <a href="<?php echo(URL); ?>blog/author/<?php echo($slug); ?>" > View All Posts by this Author (<?php echo($name); ?>) </a></p><br>



</div>

<div class="panel-footer text-left">
    <div class="row">
        <div id="new_addition"></div>

        <?php
            //blog comments generation
            foreach ($comments as $comment) {
                $date = new DateTime($comment['date']);
                $dob = $date->format('d M, Y h:i a');
                if ($comment['user_id']) {
                    list($name, $source, $slug) = $user->get_person_name($comment['user_id']);
                    ?>
                    <div id="message_<?php echo $comment["blog_comment_id"]; ?>">
                        <div class="col-sm-2 text-center">
                            <img src="<?php echo($source); ?>" class="img-circle" height="65" width="65" alt="<?php echo($name); ?>">
                        </div>
                        <div class="col-sm-10">
                            <h4><a href="<?php echo(URL); ?>profile/member/<?php echo($slug); ?>" title="View profile"><?php echo($name); ?></a> <small><?php echo($dob); ?></small></h4>
                            <p class="message-content"><?php echo nl2br($comment['message']); ?></p>
                            <?php if (Session::get('user_id') === $blog['post_author']) { ?>
                                <div id="span_holder_<?php echo($comment["blog_comment_id"]); ?>">
                                    <span class="btn btn-primary btn-xs" onclick="toggle('reply<?php echo($comment["blog_comment_id"]); ?>')">Reply </span> &nbsp;
                                    <span class="btn btn-warning btn-xs" onClick="showEditBox(<?php echo $comment["blog_comment_id"]; ?>)">Moderate </span>&nbsp;
                                    <span class="btn btn-danger btn-xs" onClick="blogBoxAction('delete', '<?php echo($comment["blog_comment_id"]); ?>')" >Delete </span>


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
                                            <a href="javascript:void(0);" class="btn reply-btn btn-sm" onClick="blogBoxAction('add', '<?php echo($comment["blog_comment_id"]); ?>')" >Send</a>
                                            <a href="javascript:void(0);" class="btn btn-default btn-xs"  onclick="toggle('reply<?php echo($comment["blog_comment_id"]); ?>')">Cancel</a>

                                        </div>


                                    </form>
                                </div>

                            <?php } ?>
                            <br>
                            <?php
                                $replies = $user->get_comment_reply($comment['blog_comment_id']);
                                $appendix_count = $user->count();
                            ?>

                            <div class="row" id="appendix<?php echo($comment["blog_comment_id"]); ?>">
                                <p><span class="badge" id="appendix-count<?php echo($comment["blog_comment_id"]); ?>"><?php echo($appendix_count); ?></span> Response(s):</p><br>
                                <?php
                                    foreach ($replies as $reply) {
                                        ?>
                                        <?php
                                        $date = new DateTime($reply['date']);
                                        $dob = $date->format('d M, Y '); //h:i a
                                        ?>
                                        <?php
                                        list($name, $source, $slug) = $user->get_person_name($reply['person_id']);
                                        ?>
                                        <div class="col-sm-2 text-center">
                                            <img src="<?php echo($source); ?>" class="img-rounded" height="45" width="45" alt="<?php echo($name); ?>">
                                        </div>
                                        <div class="col-xs-10">
                                            <h4><a href="<?php echo(URL); ?>profile/member/<?php echo($slug); ?>" title="View profile"><?php echo($name); ?></a> <small><?php echo($dob); ?></small></h4>

                                            <p><?php echo(nl2br($reply['reply'])); ?></p>
                                            <br>
                                        </div>
                                    <?php } ?>
                            </div>

                        </div>


                    </div>


                <?php } else { ?>
                    <div id="message_<?php echo $comment["blog_comment_id"]; ?>">
                        <div class="col-sm-2 text-center">
                            <img src="<?php echo(URL); ?>public/images/avatar.jpg" class="img-circle" height="65" width="65" alt="<?php echo $comment['name']; ?>">
                        </div>
                        <div class="col-sm-10">
                            <h4><?php echo $comment['name']; ?> <small><?php echo($dob); ?></small></h4>
                            <p><?php echo nl2br($comment['message']); ?></p>
                            <br>
                            <?php
                                $replies = $user->get_comment_reply($comment['blog_comment_id']);
                                $appendix_count = $user->count();
                            ?>

                            <div class="row" id="appendix<?php echo($comment["blog_comment_id"]); ?>">
                                <p><span class="badge" id="appendix-count<?php echo($comment["blog_comment_id"]); ?>"><?php echo($appendix_count); ?></span> Response(s):</p><br>
                                <?php
                                    foreach ($replies as $reply) {
                                ?>
                                <?php
                                    $date = new DateTime($reply['date']);
                                    $dob = $date->format('d M, Y '); //h:i a
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

                        <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>



    </div>
</div>
</div>

<div class="row"></div>
</div>

</div>
</div>



