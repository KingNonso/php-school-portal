<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php $title = isset($this->title)? $this->title: "School Education"; echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="<?php echo URL; ?>public/bootstrap/css/bootstrap.css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link href="<?php echo URL; ?>public/custom/css/custom.css" rel="stylesheet" type="text/css">
    <?php  //General or public applicable css
        if (isset($this->generalCSS))
        {
            foreach ($this->generalCSS as $plugin)
            {
                echo '<link  href="'.URL.'public/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <?php  //General or public applicable css
        if (isset($this->pageCSS))
        {
            foreach ($this->pageCSS as $plugin)
            {
                echo '<link  href="'.URL.'views/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>

</head>
<body id="myPage">
<div class="container-fluid col1">
    <div id="header">
        <nav class="navbar navbar-default">
            <div class="navbar-header">
                <div id="logo" >
                    <h1><a href="#">ITF Staff School</a></h1>
                    <p> Industrial Training Fund, ITF Staff School</p>
                </div>
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

            </div>
            <?php
                $navigation = array(
                    'index' => array(
                        'name' => 'HOME',
                        'title' => 'Goto the site\'s home page',
                        'href' => URL.'index',
                    ),
                    'about' => array(
                        'name' => 'ABOUT',
                        'href' => URL.'about',
                        'title' => 'About the school, management, student life, etc',
                    ),
                    'media' => array(
                        'name' => 'MEDIA',
                        'href' => URL.'media',
                        'title' => 'Visit our blog, photo gallery, view school events, calendars, etc ',
                    ),
                    'admission' => array(
                        'name' => 'ADMISSION',
                        'href' => URL.'admission',
                        'title' => 'Begin the admission process, view admission status, etc',
                    ),
                    'links' => array(
                        'name' => 'RESULT',
                        'href' => URL.'result',
                        'title' => 'Result Checker',
                    ),
                    'contact' => array(
                        'name' => 'CONTACT',
                        'href' => URL.'contact',
                        'title' => 'Our addresses, contact numbers, and geographical map',
                    ),
                );

                $url = isset($_GET['url']) ? $_GET['url'] : null;
                $url = rtrim($url, '/');
                $url = filter_var($url, FILTER_SANITIZE_URL);
                $url = explode('/', $url);
                $url_count = count($url);

                if(count($url) > 1){
                    //reconstruct the url back
                    //$url = $url[0].'/'.$url[1];
                    $url = $url[0];
                }else{
                    //it means we are viewing the index page
                    $active = $url[0];
                    $url = $url[0];

                }

            ?>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav navbar-nav navbar-right">
                    <?php
                        if (isset($navigation)){
                            foreach($navigation as $item => $page){?>
                                <li <?php if($item === $url ){ echo('class="active"'); }  ?>> <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"><?php echo $page['name']; ?></a></li>

                            <?php }  ?>
                        <?php }    ?>

                </ul>
            </div>
        </nav>

    </div>

</div>

<!-- Container (About LFC Ifite Section) -->
<div class="container-fluid col2">
    <div class="row" id="container">
        <div class="col-sm-12 text-left">
            <ul class="breadcrumb">
                <?php echo Session::homecrumbs('li'); ?>
            </ul>
        </div>
    </div>
</div>
