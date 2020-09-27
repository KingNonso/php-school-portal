<?php
    $user = new User();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AGSS Nnewi  </title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo URL; ?>public/bootstrap/css/bootstrap.css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="<?php echo URL; ?>public/custom/css/custom.css" rel="stylesheet" type="text/css">
    <link href="<?php echo URL; ?>public/custom/phone/css/intlTelInput.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

</head>
<body id="myPage">
<div class="container-fluid col1">
    <div id="header">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <div id="logo" >
                    <h1><a href="#">AGSS Nnewi</a></h1>
                    <p>Anglican Girls Secondary School, AGSS Nnewi</p>
                </div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <li class="active"><a href="<?php echo URL; ?>index">HOME</a></li>
                    <li><a href="<?php echo URL; ?>about">ABOUT</a></li>
                    <!-- About school. principal, staff, etc -->
                    <li><a href="<?php echo URL; ?>media">MEDIA</a></li>
                    <!--PHOTO GALLERY, /BLOG, EVENTS-CALENDAR, SCHOOL  -->
                    <li><a href="<?php echo URL; ?>admission">ADMISSION</a></li>
                    <!-- admissions application -->
                    <li><a href="<?php echo URL; ?>result">RESULT</a></li>
                    <!--, RESULT CHECKER, PTA, ALLUMNI  -->
                   <li><a href="<?php echo URL; ?>contact">CONTACT</a></li>
                    <!-- CONTACT AND MAP TO LOCATION -->
                </ul>
            </div>
        </nav>

    </div>

</div>

<div class="container-fluid text-center col2">
    <div id="featured_slide">
        <?php
            for( $i=1; $i<=5; $i++){
            foreach ($this->gallery as $image) {
        ?>
        <div class="featured_box"><a href="#"><img src="<?php echo(URL) ?>public/uploads/photo_gallery/<?php echo($image['image']); ?>" alt="" /></a>
            <div class="floater text-left">
                <h2><?php echo($i); $i++; ?>. <?php echo($image['head']); ?>:</h2>
                <p> <?php echo $image['description']; ?>     </p>
                <p class="readmore"><a href="<?php echo(URL) ?>about">Continue Reading &raquo;</a></p>
            </div>
        </div>
            <?php }} ?>


    </div>
</div>

<!-- Container (About LFC Ifite Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-7">
            <?php $about = $this->about  ?>
            <div class="row">
                <div class="col-sm-12">
                    <h2><?php echo($about['menu_name'])  ?> </h2>
                    <img src="<?php echo(URL) ?>public/uploads/photo_gallery/about-ITF-Nigeria.jpg" width="240px" height="130px" alt="" class="img-thumbnail imgl"/>
                    <p><?php echo($about['content'])  ?></p>


                    <p class="readmore"><a href="<?php echo(URL) ?>about">Continue Reading &raquo;</a></p>
                </div>

            </div>
            <div class="row">
                <?php
                    $contact = $this->contact  ?>

                <div class="col-sm-6">
                    <h2>School <?php echo($contact->type)  ?> </h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <p><?php echo($contact->details)  ?></p>
                    <p class="readmore"><a href="<?php echo(URL) ?>contact">Continue Reading &raquo;</a></p>

                </div>
                <div class="col-sm-6">

                    <h2>School Calendar Events</h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <?php
                        if(isset($this->event)){
                        $event = $this->event
                    ?>
                    <h4><?php echo($event->title)  ?> </h4>
                    <p><?php echo($event->description)  ?></p>
                    <?php

                        $date = new DateTime($event->date);
                        $dob = $date->format('d M, Y ');//h:i a
                    ?>
                    <p><?php echo($dob.' @ '.$event->time)  ?></p>
                    <p class="readmore"><a href="<?php echo(URL) ?>contact">Continue Reading &raquo;</a></p>
                        <?php
                        }
                    ?>

                </div>

            </div>
            <hr/>

        </div>
        <div class="col-sm-5">

            <h2>Latest <small>From The School Blog</small></h2>
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
    </div>
</div>


<!-- Container (About LFC worldwide Section) -->
<div class="container-fluid col4">
    <div class="row" id="footer">
        <div class="col-sm-4">
            <div class="footbox">
                <h2>School Address</h2>
                <ul>
                    <li><a href="#">Address Line 1</a></li>
                    <li><a href="#">Address Line 2</a></li>
                    <li><a href="#">Contact Number 1</a></li>
                    <li><a href="#">Contact Number 2</a></li>
                </ul>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="text-center">
                <h2>Site Links</h2>
                <div class="list-group">
                    <a href="#" class="list-group-item">First item</a>
                    <a href="#" class="list-group-item">Second item</a>
                    <a href="#" class="list-group-item">Third item</a>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="">
                <h2 >Bus Routes</h2>
                <ul>
                    <li><a href="#">Bus route 1</a></li>
                    <li><a href="#">Major Bustop/ Landmark</a></li>
                    <li><a href="#">Bus route 2</a></li>
                    <li><a href="#">Major Bustop/ Landmark</a></li>
                    <li><a href="#">Bus route 3</a></li>
                    <li><a href="#">Major Bustop/ Landmark</a></li>
                </ul>
            </div>
        </div>
    </div><br>
    <hr/>
    <div id="copyright">
        <p class="pull-left">Digital Technology for School Management.</p>
        <br/>
        <p class="pull-right">Design and Developed for School Education by <a href="http://kingnonso.com/"> <span class="glyphicon glyphicon-king"> </span> Chinonso Ani. </a> All rights reserved &copy; <?php echo(date('Y')); ?></p>

    </div>

</div>

<script src="<?php echo URL; ?>public/bootstrap/js/jQuery-2.2.0.min.js"></script>
<script src="<?php echo URL; ?>public/bootstrap/js/bootstrap.min.js"></script>
<script src="<?php echo URL; ?>public/custom/plugins/slide-cycle/jquery.cycle.min.js"></script>
<script src="<?php echo URL; ?>public/custom/plugins/slide-cycle/jquery.cycle.setup.js"></script>

<?php
    //general applicable js
    if (isset($this->generalJS))
    {
        foreach ($this->generalJS as $general)
        {
            echo '<script type="text/javascript" src="'.URL.'public/'.$general.'"></script>';
        }
    }
    //page specific js
    if (isset($this->js))
    {
        foreach ($this->js as $js)
        {
            echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
        }
    }

?>





</body>
</html>
