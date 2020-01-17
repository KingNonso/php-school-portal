<?php
    $nav = array(
        'dashboard' => array(
            'name' => 'Dashboard',
            'title' => 'Go to your wall: view private conversations',
            'href' => URL.'webmaster',
            'class' => '<i class="fa fa-dashboard"></i>'

        ),
        /*
              'clearance' => array(
            'pages' => array(
                'Students' => URL.'webmaster/clearance/Students',
                'Parents' => URL.'webmaster/clearance/Parents',
                'Staff' => URL.'webmaster/clearance/Staff',
                'Portal' => URL.'webmaster/clearance/Portal',
            ),
            'name' => 'Clearance',
            'href' => URL.'webmaster/clearance',
            'title' => 'Verify claims and persons physically',
            'class' => '<i class="fa fa-eye-slash"></i>'

        ),

         */
        'about' => array(
            'name' => 'About School',
            'href' => URL.'webmaster/about',
            'title' => 'About The School, The Management, etc',
            'class' => '<i class="fa fa-mortar-board"></i>'

        ),
        'clearance' => array(
            'name' => 'Set Portals',
            'href' => URL.'webmaster/clearance/Portal',
            'title' => 'About The School, The Management, etc',
            'class' => '<i class="fa fa-laptop"></i>'

        ),
        'contact' => array(
            'pages' => array(
                'Enquiries' => URL.'webmaster/enquiry',
                'Contact Info' => URL.'webmaster/contact',
            ),
            'name' => 'Contact/ Enquiries ',
            'href' => URL.'webmaster/contact',
            'title' => 'Set Contact, respond to requests',
            'class' => '<i class="fa fa-pie-chart"></i>'

        ),

        'events' => array(
            'name' => 'Events/ Calendar ',
            'href' => URL.'webmaster/event',
            'title' => 'Edit and Approve Post',
            'class' => '<i class="fa fa-calendar"></i>'

        ),
        'photo' => array(

            'name' => 'Photo Gallery',
            'href' => URL.'webmaster/gallery',
            'title' => 'Write Posts',
            'class' => '<i class="fa fa-photo"></i>'
        ),
        'admissions' => array(
            'pages' => array(
                'Applications' => URL.'webmaster/admissions',
                'Interview & Requirements' => URL.'webmaster/admissions/interview',
            ),

            'name' => 'Admissions ',
            'href' => URL.'webmaster/admissions',
            'title' => 'Your Enquiries',
            'class' => '<i class="fa fa-mail-reply"></i>'

        ),
        'account' => array(
            'name' => 'My Account',
            'href' => URL.'webmaster/account',
            'title' => 'Set your account',
            'class' => '<i class="fa fa-user"></i>'

        ),



    );

    $url = isset($_GET['url']) ? $_GET['url'] : null;
    $url = rtrim($url, '/');
    $url = filter_var($url, FILTER_SANITIZE_URL);
    $url = explode('/', $url);

    if(count($url) > 1){
        //reconstruct the url back
        $url = URL.$url[0].'/'.$url[1];
        if(count($url) > 2){
            $subURL = URL.$url[0].'/'.$url[1].'/'.$url[2];
        }

    }else{
        //it means we are viewing the index page
        $active = $url[0];
        $url = URL.$url[0];

    }

?>


<!-- Sidebar Menu -->
<ul class="sidebar-menu">
    <li class="header">MAIN NAVIGATION</li>
    <!-- Optionally, you can add icons to the links -->
    <!-- This is a dynamically generated navigation bar from the navigation array. It first passes the first level, then checks for 'pages' which signifies that has children, if 'pages' is not found, it continues normally, else if inserts a tree view i.e. a drop down -->

    <?php

        if (isset($nav)){
            foreach($nav as $item => $page){
                if (array_key_exists('pages',$page)){

                    foreach(($page) as $name => $link){
                        if (is_array($link)) {?>
                            <li class="treeview" <?php if($page['href'] === $url ){ echo('class="active"'); }  ?>>
                                <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"> <?php echo $page['class']; ?> <span><?php echo $page['name']; ?></span> <i class="fa fa-angle-left pull-right"></i></a>
                                <ul class="treeview-menu">
                                    <?php
                                        while (list($key, $val) = each($link)) {
                                            ?>
                                            <li> <a href="<?php echo $val; ?>" title="<?php echo $key; ?>" <?php if(isset($subURL) && $subURL === $val ){ echo('class="active"'); } ?>><i class="fa fa-link"></i><span> <?php echo $key; ?></span></a></li><?php   }     ?>
                                </ul>
                            </li>
                        <?php   }}} else{ ?>
                    <li <?php if($page['href'] === $url ){ echo('class="active"'); }  ?>> <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"><?php echo $page['class']; ?><span> <?php echo $page['name']; ?></span><?php if(array_key_exists('label',$page)){ ?> <?php echo $page['label']; ?> <?php }  ?></a></li>
                <?php } }  ?>                              <?php }    ?>


</ul>
<!-- /.sidebar-menu -->
</section>
<!-- /.sidebar -->
</aside>