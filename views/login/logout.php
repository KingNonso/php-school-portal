<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php $title = isset($this->title)? $this->title: null; echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/custom/css/AdminLTE.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        <h1><?php echo Session::get('site_name'); ?></h1>
        <p class=""><?php echo Session::get('tagline'); ?></p>

    </div>
    <!-- User name -->
    <div class="lockscreen-name"><?php echo(Session::get('logged_in_user_name')); ?></div>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
            <?php if(!empty($_SESSION['user_image'])){ ?>
                <!-- The user image in the navbar-->
                <img src="<?php echo(Session::get('logged_in_user_photo')); ?>" class="user-image" alt="<?php echo(Session::get('logged_in_user_name')); ?>">
            <?php }else{  ?>
                <img src="<?php echo URL; ?>public/custom/img/avatar5.png" class="user-image" alt="User Image">
            <?php } ?>        </div>
        <!-- /.lockscreen-image -->

        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" action="<?php echo(URL.'login/login'); ?>" method="post">
            <div class="input-group">
                <input type="password" id="password" name="password" class="form-control" placeholder="Enter Password">
                <input type="hidden" id="username" name="username" value="<?php echo $_SESSION['email']; ?>">

                <div class="input-group-btn">
                    <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>

                </div>
            </div>
        </form>
        <!-- /.lockscreen credentials -->

    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
        Enter your password to retrieve your session
    </div>
    <div class="text-center">
        <a href="<?php echo URL; ?>login">Or sign in as a different user</a>
    </div>
    <div class="lockscreen-footer text-center">
        <!-- To the right -->
        For Judidaily
        <!-- Default to the left -->
        <strong><p>Developed by <a href="http://frogfreezone.com/" title="The King">King</a> &copy; 2016</p></strong> All rights reserved.
    </div>
</div>
<!-- /.center -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo URL; ?>public/custom/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo URL; ?>public/custom/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
