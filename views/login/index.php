<?php
    $user = new User();
    $max = 500 * 1024; //50kb

?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12 text-center">

            <h1><b>School Portal</b> <small> Sign in to start your session </small></h1>
        </div>

        <div class="col-sm-7">
            <h3 class="error-code"><span class="glyphicon glyphicon-log-in"></span> Login</h3>
            <div class="box-body">
                <?php if (Session::exists('home')) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        <?php echo Session::flash('home'); ?>                         </div>
                    <?php ?>
                <?php } elseif (Session::exists('error')) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php echo Session::flash('error');  //echo  //$this->error;?>
                    </div>
                <?php } else {
                    ?>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        <p id="status">Enter Your Email and Password in the fields below </p>

                    </div>
                <?php } ?>

            </div>
            <form action="<?php echo(URL.'login/login'); ?>" method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email address" required>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
                            <input type="password" id="password"  name="password"  class="form-control" placeholder="Enter Password: " required>
                        </div>

                    </div>
                    <div class="col-sm-8 form-group pull-left">
                        <label>
                            <input type="checkbox" value="remember" id="login_me" name="login_me"> Keep me logged in(this is my device)
                        </label>

                    </div>
                    <div class="col-sm-4 form-group" id="submit">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
                    </div>

                    <div class="col-sm-12 form-group">
                        <br>

                    </div>
                </div>


            </form>

        </div>
        <div class="col-sm-5">

            <h2>Other Options <small>From The Webmaster</small></h2>
            <ul class="list-group">
                <li class="list-group-item"><a href="<?php echo(URL); ?>login/recovery">I forgot my password</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>admission/step/one" class="text-center">Register as Student</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>links/step/parent-web" class="text-center">Register as Parent</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>links/step/teacher" class="text-center">Register as Staff</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>login/register" class="text-center">Register as Portal</a></li>

            </ul>
        </div>
    </div>
</div>



