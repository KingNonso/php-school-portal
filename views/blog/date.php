
<?php
    $user = new User;
?>

<!-- Main -->
<div id="main">
    <article class="post">
        <div class="title">
            <h3><a href="http://judidaily.com.ng/"><?php echo $this->title; ?></a></h3>

        </div>

    </article>


    <!-- Post -->
    <?php
        foreach($this->blog as $blogs){
    ?>
            <article class="post">
                <header>
                    <div class="title">
                        <h2><a href="http://judidaily.com.ng/"><?php echo $blogs['post_tittle']; ?></a></h2>
                        <?php if (!empty($blogs['subtitle'])){ ?>
                            <p><?php echo $blogs['subtitle']; ?></p>
                        <?php } ?>
                    </div>
                    <div class="meta">
                        <?php
                            $date = new DateTime($blogs['post_date']);
                            $dob = $date->format('d M, Y ');//h:i a
                        ?>
                        <time class="published" datetime="<?php echo $dob; ?>"><?php echo $dob; ?></time>
                        <a href="#" class="author"><span class="name"><?php echo $blogs['post_author']; ?></span><img src="<?php echo URL; ?>public/images/avatar.jpg" alt="" /></a>
                    </div>
                </header>
                <a href="#" class="image featured">
                    <?php if (!empty($blogs['featured_image'])){ ?>
                        <img src="images/blog/<?php echo $blogs['featured_image']; ?>" alt="<?php echo $blogs['post_tittle']; ?>" />
                    <?php } else { ?>
                        <img src="<?php echo URL; ?>public/images/pic01.jpg" alt="<?php echo $blogs['post_tittle']; ?>" />
                    <?php } ?>
                </a>
                <p><?php
                        $extract = getFirst($blogs['post_content'],2);
                        echo html_entity_decode($extract[0]);
                    ?></p>
                <hr />
                <?php
                    $comments = $user->get_blog_comments($blogs['post_id']);
                ?>

                <footer>
                    <ul class="stats">
                        <?php if (!empty($blogs['category'])){ ?>
                            <li><a href="#"><?php echo $blogs['category']; ?></a></li>
                        <?php }else { ?>
                            <li><a href="#">General</a></li>
                        <?php }?>
                        <li><a href="#" class="icon fa-heart">1</a></li>
                        <li><a href="#" class="icon fa-comment"><?php     echo $user->count();  ?></a></li>
                    </ul>
                </footer>
            </article>
    <?php
        }
    ?>
    <article class="post">
        <footer>
            <p class="copyright">&copy; 2016 Designed &amp; Developed by:  <a href="http://frogfreezone.com">KING</a>.</p>
        </footer>
    </article>

</div>

<!-- Sidebar -->
<section id="sidebar">

    <!-- Intro -->
    <section id="intro">
        <a href="#" class="logo"><img src="<?php echo URL; ?>public/images/logo.jpg" alt="" /></a>
        <header>
            <h2>JudiDaily</h2>
            <p>Where the word of the King is...</p>
        </header>
    </section>


    <!-- Posts List -->
    <section>
        <ul class="posts">
            <?php // start about us query
                $all_titles = $user->get_all_blog_titles();
                foreach($all_titles as $title){
                    ?>

                    <li>
                        <article>
                            <header>
                                <?php
                                    $date = new DateTime($title['post_date']);
                                    $dob = $date->format('Y/m/d/');
                                ?>

                                <h3><a href="<?php echo URL.$dob.urlencode($title['slug']); ?>"><?php echo $title['post_tittle']; ?></a></h3>
                                <?php
                                    $date = new DateTime($title['post_date']);
                                    $dob = $date->format('d M, Y ');//h:i a
                                ?>
                                <time class="published" datetime="2015-10-20"><?php echo $dob ; ?></time>
                            </header>
                            <a href="#" class="image">
                                <?php if (!empty($title['featured_image'])){ ?>
                                    <img src="images/blog/<?php echo $title['featured_image']; ?>" alt="<?php echo $title['post_tittle']; ?>" height="51" width="51" />
                                <?php } else { ?>
                                    <img src="<?php echo URL; ?>public/images/pic08.jpg" alt="<?php echo $title['post_tittle']; ?>" height="51" width="51" />
                                <?php } ?>
                            </a>
                        </article>


                    </li>
                <?php } ?>
        </ul>
    </section>
    <!--<section>
            <h3>Categories</h3>
            <div class="row">
                <div class="6u 12u$(small)">
                    <h4>Category 1much of my success</h4>
                    <h4>Category 1</h4>
                    <h4>Category 1</h4>
                    <h4>Category 1</h4>
                </div>
            </div>
    </section>-->
    <!-- About -->
    <section class="blurb">
        <h2>About</h2>
        <p>How much of my success is dependent on you.</p>
        <ul class="actions">
            <li><a href="#" class="button">Learn More</a></li>
        </ul>
    </section>

