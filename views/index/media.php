<?php
    $user = new User();
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-7">
            <!--            <div class="row">
                <div class="col-sm-6">
                    <h2>About School New</h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <p>Nullamlacus dui ipsum conseqlo borttis non euisque morbipen a sdapibulum orna.</p>
                    <p>Urnau ltrices quis curabitur pha sellent esque congue magnisve stib ulum quismodo nulla et feugiat. Adipisciniap ellentum leo ut consequam.</p>
                    <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>

                </div>
                <div class="col-sm-6">
                    <h2>Events/ Calendar</h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <p>Nullamlacus dui ipsum conseqlo borttis non euisque morbipen a sdapibulum orna.</p>
                    <p>Urnau ltrices quis curabitur pha sellent esque congue magnisve stib ulum quismodo nulla et feugiat. Adipisciniap ellentum leo ut consequam.</p>
                    <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>

                </div>
            </div>
 -->
            <div class="row">
                <div class="col-sm-12 text-center">

                    <h1><b> THE SCHOOL's BLOG </b> <small>Young Writers and Publishers</small></h1>
                </div>
                <?php foreach($this->latest10 as $blog){?>
                    <div class="col-sm-12">
                        <h2><?php echo($blog['post_title'])  ?>
                            <?php if (!empty($blog['subtitle'])) { ?>
                                <small><?php echo($blog['subtitle']) ?></small>
                            <?php } ?>
                        </h2>
                        <?php if (!empty($blog['featured_image'])) { ?>
                            <p class="text-center"><img src="<?php echo(URL . 'public/uploads/blog/' . $blog['featured_image']); ?>" class="img-responsive text-center" alt="<?php echo($blog['post_title']); ?>"></p>
                        <?php } ?>



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
                        <hr>

                        <?php $limit = (html_entity_decode($blog['post_content']));
                            if($limit = limit_word($limit)){ ?>
                                <p> <?php echo $limit; ?> </p>


                            <?php }else{ ?>
                                <p> <?php echo htmlspecialchars_decode($blog['post_content']); ?> </p>
                            <?php } ?>


                        <p class="readmore"><a href="<?php echo(URL); ?>blog/title/<?php echo($blog['slug_date'].'/'.$blog['slug_title']);  ?>">Continue Reading &raquo;</a></p>
                    </div>
                    <hr/>
                <?php  } ?>

            </div>

        </div>
        <div class="col-sm-5">

            <h2>School Calender <small>Happening in 7 day (in Blue)</small></h2>
            <div class="list-group">
                <?php
                    $date = new DateTime('now');
                    $today = $date->format('d F, Y');
                ?>

                <?php
                    $interval = $date->add(new DateInterval('P7D'));
                    //echo $timeSub = $date->format('d F, Y') ;
                ?>
                    <div class="list-group">
                        <?php foreach($this->event as $event){?>
                            <?php

                            $date = new DateTime($event->date);
                            $dob = $date->format('d M, Y ');//h:i a
                            ?>
                            <?php
                            if($date >= date('Y-m-d') && $date <= $interval ){
                             ?>
                            <a href="#" class="list-group-item active">
                            <h4 class="list-group-item-heading"><?php echo($event->title)  ?></h4>
                            <p class="list-group-item-text"><?php echo($event->description)  ?></p>
                            <p><?php echo($dob.' @ '.$event->time)  ?></p>
                        </a>
                                <hr/>
                            <?php } else{?>

                            <a href="#" class="list-group-item">
                                <h4 class="list-group-item-heading"><?php echo($event->title)  ?></h4>
                                <p class="list-group-item-text"><?php echo($event->description)  ?></p>
                                <p><?php echo($dob.' @ '.$event->time)  ?></p>
                        </a>
                        <?php }} ?>
                    </div>

            </div>


        </div>
    </div>
</div>



