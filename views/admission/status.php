<?php
    $user = new User();
    $max = 500 * 1024; //50kb

?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12 text-center">

            <h1><b>CHECK ADMISSION STATUS </b> <small>School Portal</small></h1>
        </div>

        <div class="col-sm-7">
            <h3 class="error-code"><span class="glyphicon glyphicon-list-alt"></span> ADMISSION STATUS</h3>
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
                        <p id="status">Enter Your Examination ID and Scratch Card in the fields below </p>

                    </div>
                <?php } ?>

            </div>
            <form action="<?php echo(URL.'admission/check_admission_status'); ?>" method="post">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label>Enter Examination ID</label>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                            <input type="text" id="exam_id" name="exam_id" class="form-control" placeholder="Enter Examination ID" required>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label>Enter Scratch Card</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
                            <input type="password" id="scratch_card"  name="scratch_card"  class="form-control" placeholder="Enter Scratch Card: " required>
                        </div>

                    </div>
                    <div class="col-sm-8 form-group pull-left">
                        <p>We wish you well!</p>

                    </div>
                    <div class="col-sm-4 form-group" id="submit">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Check Now</button>
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
                <li class="list-group-item"><a href="<?php echo(URL); ?>admission/step/one">START ADMISSION APPLICATION</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>admission/step/one" class="text-center">How to Get Scratch Card</a></li>



            </ul>
        </div>
    </div>
</div>



