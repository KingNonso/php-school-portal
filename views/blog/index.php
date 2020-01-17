<?php
    $user = new User();
?>


<br/>
<div id="homecontent" class="container-fluid ">
<div class="row">
<div class="col-sm-12">
<div class="panel panel-primary">
<div>
    <br/>

    <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#latest">Latest</a></li>
        <li><a data-toggle="tab" href="#search-blog">Search</a></li>
        <li><a data-toggle="tab" href="#all-blog">All</a></li>
        <li><a data-toggle="tab" href="#my-publication">My Publications</a></li>
    </ul>

</div>
<div class="panel-body">

    <div class="tab-content text-left">
        <div id="latest" class="tab-pane fade in active">
            <h4>Latest <small>Top 5 Trending:</small></h4>
            <div class="list-group">
                <?php foreach($this->latest10 as $blog){?>

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

        </div>
        <div id="search-blog" class="tab-pane fade">
            <h4>Search <label for="search_pattern"><small>By Title, Author or Category:</small></label></h4>
            <form action="<?php echo(URL.'blog/date'); ?>" method="post" id="contact_form" enctype="multipart/form-data" onsubmit="return false">
                <div class="form-group">

                    <div class="row">
                        <div class="col-sm-3">
                            <select name="search_pattern" id="search_pattern" class="form-control" onchange="checkPattern()">
                                <option value="title">Title</option>
                                <option value="author">Author</option>
                                <option value="category">Category</option>
                            </select>

                        </div>
                        <div class="col-sm-6">
                            <div id="d_cat" style="display: none">

                                <select id="search_category" name="search_category" class="form-control" onchange="searchBlog(this.value)">
                                    <?php
                                        foreach($this->category as $cat){
                                            ?>

                                            <option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name']; ?></option>
                                        <?php }  ?>                              </select>
                                <label for="category">Select from available</label>

                            </div>
                            <div id="search_input">
                                <input type="text" class="form-control" id="search_term" name="search_term" placeholder="Enter Search Term" onkeyup="searchBlog(this.value)">
                            </div>



                        </div>
                        <div class="col-sm-3" id="searcher">
                            <button type="submit" class="btn btn-success" onclick="searchBlog(search_term.value);">Search &raquo;</button>

                        </div>

                    </div>
                </div>
            </form>

            <h4>Search <label for="blog_year"><small>By Date:</small></label></h4>
            <form action="<?php echo(URL.'blog/date'); ?>" method="post" id="contact_form" enctype="multipart/form-data" onsubmit="return false">
                <div class="form-group">

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
        </div>
        <div id="all-blog" class="tab-pane fade">
            <h4>Showing Everything <small>Beginning from the most recent</small></h4>
            <form>
                <input type="hidden" id="results_per_page" value="<?php echo($this->rpp); ?>">
                <input type="hidden" id="last_page" value="<?php echo($this->last_no); ?>">
            </form>
            <div id="pagination_controls_up"></div>
            <div id="results_box"></div>
            <div id="pagination_controls_down"></div>


        </div>
        <div id="my-publication" class="tab-pane fade">
            <h4>My Publications <small>Shows everything you have done.</small></h4>
            <div class="list-group">
                <?php foreach($this->mine as $blog){?>

                    <div class="list-group-item">
                        <a class="list-group-item-heading" href="<?php echo(URL); ?>blog/title/<?php echo($blog['slug_date'].'/'.$blog['slug_title']);  ?>" title="View this Post"><h4><?php echo($blog['post_title'])  ?></h4>
                        </a>

                        <?php

                            $status = ($blog['post_status'] == 'publish') ? 'Published ': 'Last Saved ';
                            $status_btn = ($blog['post_status'] == 'publish') ? '<a href="'.URL.'blog/title/'.$blog['slug_date'].'/'.$blog['slug_title'].'" class="btn btn-default btn-sm">Moderate Comments</a> ': '<a href="'.URL.'blog/publish/'.$blog['slug_date'].'/'.$blog['slug_title'].'" class="btn btn-success btn-sm">Publish Post Now</a>';
                            $date = new DateTime($blog['post_date']);
                            $dob = $date->format('d M, Y ');//h:i a
                            $comments = $user->get_blog_comments($blog['post_id']);
                            $c_count = $user->count();
                        ?>
                        <h5>
                            Comments: <span class="badge"><?php echo($c_count)  ?></span>
                        </h5>

                        <p class="list-group-item-text text-"><span class="glyphicon glyphicon-time"></span> Post <?php echo($status); ?> on: <?php echo($dob);  ?>.</p>
                        <br>

                        <div>
                            <a href="<?php echo(URL); ?>blog/update/<?php echo($blog['slug_date'].'/'.$blog['slug_title']);  ?>" class="btn btn-primary btn-sm">Update Post</a>
                            <a href="<?php echo URL; ?>blog/delete/<?php echo $blog['post_id']; ?>" onclick="return confirm('This post will be permanently deleted. It cannot be undone. PROCEED?')" class="btn btn-danger btn-sm">Delete Post </a>

                            <?php echo($status_btn);  ?>

                        </div>

                    </div>
                <?php } ?>
            </div>

        </div>
    </div>

</div>
<div class="panel-footer text-left">
    <div id="search_results"></div>

    <h4><small>MOST RECENT POST</small></h4>
    <hr>
    <?php $blog = $this->last; ?>

    <h2> <?php echo($blog['post_title'])  ?></h2>
    <?php
        list($name, $source, $slug) = $user->get_person_name($blog['post_author']);

        $date = new DateTime($blog['post_date']);
        $dob = $date->format('d M, Y ');//h:i a
    ?>

    <h5><span class="glyphicon glyphicon-time"></span> Post by <a href="<?php echo(URL); ?>profile/member/<?php echo($slug);  ?>" title="View Writer's profile">
            <?php echo($name); ?>
        </a>: <?php echo($dob);  ?>
    </h5>
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
    <?php $limit = (htmlspecialchars_decode($blog['post_content']));
        if($limit = limit_word($limit)){ ?>
            <p> <?php echo $limit; ?> </p>
            <br><a href="<?php echo URL.'blog/title/'.($blog['slug_date']).'/'.($blog['slug_title']); ?>" class="btn btn-default btn-lg"> Read More &raquo; </a>

        <?php }else{ ?>
            <p> <?php echo htmlspecialchars_decode($blog['post_content']);  ?>
            </p>

        <?php } ?>

    <br><br>
</div>
</div>
<!--
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
-->
</div>

</div>
</div>



