<?php
    $user = new User();
?>
<?php $category = $this->category; ?>


<br/>
<div id="homecontent" class="container-fluid ">
    <div class="row">
        <div class="col-sm-12">
            <div class="panel panel-primary ">
                <div class="panel-heading text-holder"><h1><?php echo($category['cat_name'])  ?></h1></div>
                <div class="panel-body text-left">
                    <h4><small>All in this category:</small></h4>

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
                                            $tag = $user->blog_tag($tags[$x])
                                            ?>

                                            <span class="label label-<?php echo($labels[$x])  ?>"><?php echo($tag['tag_name'])  ?></span>
                                        <?php  }}?>
                                </h5>
                                <?php
                                    list($name, $source, $slug) = $user->get_person_name($blog['post_author']);

                                    $date = new DateTime($blog['post_date']);
                                    $dob = $date->format('d M, Y ');//h:i a
                                ?>

                                <p class="list-group-item-text"><span class="glyphicon glyphicon-time"></span> Post by <a href="<?php echo(URL); ?>profile/member/<?php echo($slug);  ?>" title="View Writer's profile"><?php echo($name); ?></a>: <?php echo($dob);  ?>.</p>
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

            <div class="row"></div>
        </div>

    </div>
</div>



