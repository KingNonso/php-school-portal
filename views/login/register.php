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
    <!-- iCheck -->
    <link rel="stylesheet" href="<?php echo URL; ?>public/custom/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <h1><?php echo Session::get('site_name'); ?></h1>
            <?php if(Session::exists('home')){?>
                <span id="status"><?php echo Session::flash('home');?></span>
            <?php } ?>
            <?php if(Session::exists('error')){ ?>
                <span id="status"><?php echo Session::flash('error');?></span>
            <?php }?>


    </div>

    <div class="register-box-body">
        <p class="login-box-msg">Register a new membership</p>

        <form action="<?php echo(URL.'login/account_setup'); ?>" method="post">
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="firstname" name="firstname" placeholder="First Name">
                <span class="glyphicon glyphicon-user form-control-feedback"></span>
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="surname" name="surname" placeholder="Last Name">

                <span class="glyphicon glyphicon-user form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="text" class="form-control" id="phone_number" name="phone_number" placeholder="Phone Number">

                <span class="glyphicon glyphicon-phone form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="email" class="form-control" id="email" name="email" placeholder="Email" required>
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="password" name="password" placeholder="New Password" required>
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" id="new_again" name="new_again" placeholder="Re-type password" required>
                <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-8">
                    <div class="checkbox icheck">
                        <label>
                            <input type="checkbox" value="yes" id="agree" name="agree"> I agree to the <a href="#">terms</a>
                        </label>
                    </div>
                    <p>All errors to inputs made will be traced to your account</p>
                </div>
                <!-- /.col -->
                <div class="col-xs-4">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Register</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
        <!-- /.col
        <div class="social-auth-links text-center">
            <p>- OR -</p>
            <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
                Facebook</a>
            <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
                Google+</a>
        </div>
        -->
        <a href="<?php echo URL; ?>login" class="text-center">I already have a membership</a>
    </div>
    <!-- /.form-box -->
</div>
<!-- /.register-box -->

<!-- jQuery 2.2.0 -->
<script src="<?php echo URL; ?>public/custom/plugins/jQuery/jQuery-2.2.0.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="<?php echo URL; ?>public/custom/bootstrap/js/bootstrap.min.js"></script>
<!-- iCheck -->
<script src="<?php echo URL; ?>public/custom/plugins/iCheck/icheck.min.js"></script>
<?php
    //general applicable js
    if (isset($this->generalJS))
    {
        foreach ($this->generalJS as $general)
        {
            echo '<script type="text/javascript" src="'.URL.'public/custom/js/'.$general.'"></script>';
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
<script>
    $(function () {
        $('input').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });
    });
</script>
</body>
</html>
