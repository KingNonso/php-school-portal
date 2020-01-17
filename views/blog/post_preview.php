
<?php // start about us query
    $user = new User;
    $blogs = $this->blog;
?>

<!-- Main -->
<div id="main">

    <!-- Post -->
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
                <?php
                    $name = $user->get_name($blogs['post_author'])
                ?>

                <a href="#" class="author"><span class="name"><?php echo $name['name']; ?></span><img src="<?php echo URL; ?>public/images/avatar.jpg" alt="" /></a>
            </div>
        </header>
        <a href="#" class="image featured">
            <?php if (!empty($blogs['featured_image'])){ ?>
                <img src="<?php echo URL; ?>public/uploads/post/<?php echo $blogs['featured_image']; ?>" alt="<?php echo $blogs['post_tittle']; ?>" />
            <?php } else { ?>
                <img src="<?php echo URL; ?>public/images/pic01.jpg" alt="<?php echo $blogs['post_tittle']; ?>"/>
            <?php } ?>
        </a>
        <p><?php echo (html_entity_decode($blogs['post_content'])); ?></p>

    </article>

    <article class="post" id="comment_form">
        <section>
            <h3>How do you see this post preview</h3>
            <i>Please note that this preview is provided for your view of how it looks only! Click the options below</i>
            <ul class="actions" id="submit">
                <li><a  href="<?php echo URL; ?>admin/post/update/<?php echo $blogs['post_id']; ?>" class="button">Edit this Post</a></li>
                <li><a href="<?php echo URL; ?>admin/workbench/all/" class="button">Its Okay, Proceed</a></li>
            </ul>

        </section>
        <hr />
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
            <h2><?php echo Session::get('site_name'); ?></h2>
            <p><?php echo Session::get('tagline'); ?></p>
            <h3>Post Preview</h3>
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

                                <h3  <?php if($blogs['post_id'] == $title['post_id']) { ?>style=" text-decoration:underline;" <?php } ?>><a href="<?php echo URL.$dob.urlencode($title['slug']); ?>"><?php echo $title['post_tittle']; ?></a></h3>
                                <?php
                                    $date = new DateTime($title['post_date']);
                                    $dob = $date->format('d M, Y ');//h:i a
                                ?>
                                <time class="published" datetime="<?php echo $dob ; ?>"><?php echo $dob ; ?></time>
                            </header>
                            <a href="#" class="image">
                                <?php if (!empty($title['featured_image'])){ ?>
                                    <img src="<?php echo URL; ?>public/uploads/post/<?php echo $title['featured_image']; ?>" alt="<?php echo $title['post_tittle']; ?>" height="51" width="51" />
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

