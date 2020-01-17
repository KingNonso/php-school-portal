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
            <?php $author = $this->author; ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-primary ">
                        <div class="panel-heading text-holder"><h1><?php echo($author['firstname'].' '.$author['surname'].' '.$author['othername'])  ?></h1></div>
                        <div class="panel-body text-left">
                            <h4>All By The Author <small>Publications</small></h4>

                            <div class="list-group">
                                <?php foreach($this->blog as $blog){?>

                                <div class="list-group-item">
                                    <a class="list-group-item-heading" href="<?php echo(URL); ?>blog/title/<?php echo($blog['slug_date'].'/'.$blog['slug_title']);  ?>" title="View this Post"><h4><?php echo($blog['post_title'])  ?></h4>
                                    </a>
                                    <h5>
                                            <?php if (!empty($blog['tags'])){
                                                $tags = explode(',',$blog['tags']);
                                                $i = count($tags);
                                                $labels = array('default','primary','success','info','warning','danger');
                                                for($x = 0; $x<$i; $x++){?>
                                                    <?php
                                                    $tag = $user->blog_tag($tags[$x]);
                                                    ?>

                                                    <span class="label label-<?php echo($labels[$x])  ?>"><?php echo($tag['tag_name'])  ?></span>
                                                <?php  }}?>
                                        </h5>
                                    <?php
                                        list($name, $source, $slug) = $user->get_person_name($blog['post_author']);

                                        $date = new DateTime($blog['post_date']);
                                        $dob = $date->format('d M, Y ');//h:i a
                                    ?>

                                    <p class="list-group-item-text text-"><span class="glyphicon glyphicon-time"></span> Post by <a href="<?php echo(URL); ?>profile/member/<?php echo($slug);  ?>" title="View Writer's profile"><?php echo($name); ?></a>: <?php echo($dob);  ?>.</p>
                                </div>
                                <?php } ?>
                            </div>







                            <br><br>
                            <h4>Search by Date:</h4>
                            <form action="<?php echo(URL.'blog/date'); ?>" method="post" id="contact_form" enctype="multipart/form-data" onsubmit="return false">
                                <div class="form-group">
                                    <label for="blog_year">Search for Blog by Date</label>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <select name="blog_year" id="blog_year" class="form-control">
                                                <?php Date::yeargen(2010); ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3">
                                            <select name="blog_month" id="blog_month" class="form-control">
                                                <option value="x">Select Month</option>
                                                <?php Date::monthgen(); ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3">
                                            <select name="blog_day" id="blog_day" class="form-control">
                                                <option value="x">Select Day</option>
                                                <?php Date::daygen(); ?>
                                            </select>

                                        </div>
                                        <div class="col-sm-3">
                                            <button type="submit" class="btn btn-success" onclick="searchDate();">Search &raquo;</button>

                                        </div>

                                    </div>
                                </div>
                            </form>

                            <br><br>





                        </div>
                        <div class="panel-footer text-left">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4>Search Results <small>Displayed Here</small></h4>
                                    <div id="search_results"></div>

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

