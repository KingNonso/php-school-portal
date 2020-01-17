<?php
    $user = new User();
    $max = 500 * 1024; //50kb
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
<div class="row" id="container">
<div class="col-sm-12 text-center">

    <h1><b> Application Done </b> <small>Proceed to Physical Clearance</small></h1>
</div>

<div class="col-sm-7">
<div>
    <div class="col-sm-12">

        <?php if(Session::exists('home')){ ?>
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                <?php echo Session::flash('home');?>                         </div>
            <?php  ?>
        <?php } elseif(Session::exists('error')){ ?>
            <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                <?php echo Session::flash('error');  //echo  //$this->error;?>
            </div>
        <?php }
        else{?>
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Alert! Login Failed</h4>
                Please proceed for physical clearance.
            </div>
        <?php } ?>

    </div>
    <h1>FINAL STEPS</h1>
    <p>Please you must be physically cleared to login into the school portal with the email and password that you have already created. </p>
    <p>This is the final verification examination</p>
    <p>Please visit the school soon</p>
    <br/>
    <p>Once cleared, you may now login in with the email and password. </p>
    <p>Thank you so much, and that is it!</p>


</div>

</div>
<div class="col-sm-5">

    <h2>REQUIREMENTS <small>From The School Mgt</small></h2>
    <div class="list-group">
        <li> <a href="#" class="list-group-item active" title="Finished"> DONE! Proceed for Physical Clearance</a></li>

    </div>

</div>
</div>
</div>



