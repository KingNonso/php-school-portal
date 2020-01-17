<?php
    $user = new User();
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12 text-center">

            <h1><b>School Portal</b> <small>Enter your credentials to view result</small></h1>
        </div>

        <div class="col-sm-8 col-sm-offset-2">
            <h3 class="error-code text-center"><span class="glyphicon glyphicon-list-alt"></span> Online Result Checker</h3>
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
                        <p id="status">Enter Your Student Registration ID and PIN in the fields below </p>

                    </div>
                <?php } ?>

            </div>
            <form action="<?php echo(URL.'login/login'); ?>" method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                            <input type="text" id="student_id" name="student_id" class="form-control" placeholder="Enter Student Registration ID" required>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
                            <input type="password" id="student_pin"  name="student_pin"  class="form-control" placeholder="Enter PIN: " required>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group" id="submit">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Check Result Now</button>
                    </div>

                    <div class="col-sm-12 form-group">
                        <br>

                    </div>
                </div>


            </form>

        </div>
        <div class="col-sm-2">
            <!--
              <h2>Other Options <small>From The Webmaster</small></h2>
            <ul class="list-group">
                <li class="list-group-item"><a href="<?php echo(URL); ?>login/recovery">I forgot my password</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>admission/step/one" class="text-center">Register as Student</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>links/step/parent-web" class="text-center">Register as Parent</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>links/step/teacher" class="text-center">Register as Staff</a></li>

            </ul>

            -->

        </div>
    </div>

</div>



