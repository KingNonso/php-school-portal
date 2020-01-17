<?php
    $user = new User();
    $max = 500 * 1024; //50kb
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12 text-center">

            <h1><b> ADMINISTRATIVE BOARD </b> <small>Application in Progress</small></h1>
        </div>

        <div class="col-sm-7">
            <div>
                <form id="form1" name="form1" method="post" action="<?php echo URL; ?>login/account_setup" onsubmit="return false"  enctype="multipart/form-data">
                    <div id="message_alert" class="col-sm-12">
                        <h1>Create a Sponsor/ Parents Account</h1>

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
                                <h4><i class="icon fa fa-info"></i> Alert!</h4>
                                If you already have created a login and it seems to fail, then just go for clearance else
                                Please complete the form below.
                            </div>
                        <?php } ?>

                    </div>

                    <div class="form-group" id="setter">
                        <label class="control-label" for="child">Search Student Detail*</label>
                        <input class="form-control" style="width:95%" required type="text" name="child" id="child" onkeyup="Search(this.value);" >

                        <div class="list-group" id="livesearch"><p class="help-block">
                                Enter the name of the student's account to whom you are affiliated!
                        </p></div>

                    </div>

                    <input type="hidden" name="owner_is" id="owner_is" value="2" />



                    <div class="form-group">
                        <label class="control-label" for="telephone" id="call_center">Contact Phone Number</label>
                        <br/>
                        <input type="hidden" id="phone_number" name="phone_number">
                        <input type="hidden" name="url_path" id="url_path" value="<?php echo URL; ?>">
                        <input type="tel" id="telephone" name="telephone" onchange="intlNumber()" class="form-control" style="width:95%" required="required" value="<?php if (Session::exists('telephone')){ echo(Session::flash('telephone')); } ?>" />



                        <p class="help-block" id="call_center_status">Please note that all SMS Notifications will be sent to this Number (Has to be verified also).</p>
                    </div>

                    <div class="form-group" >
                        <label class="control-label" for="email" id="email_center"> Login Email * </label>
                        <input class="form-control" style="width:95%" type="email" name="email" id="email" required="required" value="<?php if (Session::exists('email')){ echo(Session::flash('email')); } ?>" onchange="checkEmail(this.value)" >
                        <p class="help-block" id="email_center_status">Please note that this email has to be verified and must be unique to you. All information will be sent to this mail.</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password*</label>
                        <input class="form-control" style="width:95%"  type="password" name="password" id="password" required="required">
                        <span id="strength"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password_again">Password Again*</label>
                        <input class="form-control" style="width:95%" type="password" name="password_again" id="password_again" required="required" >

                    </div>

                    <div class="form-group">
                        <label class="w3-checkbox">
                            <input type="checkbox" name="agreement_2_terms" id="agreement_2_terms" value="yes">
                            I have read and agreed to be bound by the <a href="#" target="#">rules and regulations of the School*</a>
                        </label>
                    </div>





                    <div class="row">
                        <div class="col-sm-12" id="login_submit">
                            <input class="btn btn-primary btn-lg" type="submit" name="send" id="send" value="Submit &amp; Start" onclick="login_box()" />
                        </div>
                    </div>
                    <br />

                </form>

                <?php
                    include(View::modal_sms());
                ?>

            </div>

        </div>
        <div class="col-sm-5">

            <h2>REQUIREMENTS <small>From The School Mgt</small></h2>
            <p>This account is for <b>teachers/ staffs</b></p>
            <p>This account should be created by the <b>teacher/ staff</b></p>
            <p>Please note that it will require you to visit the school to ascertain the truism of the account created before access is granted to the school's portal</p>
            <p>With the parent's account, you can view your child's performance on the go - anytime, anywhere!</p>
            <p>Note that access will only be granted to you if it is verified that you have a child or ward in this institution!</p>

        </div>
    </div>
</div>



