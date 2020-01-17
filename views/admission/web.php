<?php
    $user = new User();
    $max = 500 * 1024; //50kb
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12 text-center">

            <h1><b> THE ADMISSIONS BOARD </b> <small>Application in Progress</small></h1>
        </div>

        <div class="col-sm-7">
            <div>
                <form id="form1" name="form1" method="post" action="<?php echo URL; ?>login/account_setup" onsubmit="return false"  enctype="multipart/form-data">

                    <div class="col-sm-12">
                        <h1>Set Up Your Web Access Profile</h1>

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
                                Please complete the form below.
                            </div>
                        <?php } ?>

                    </div>
                    <br>

                    
                    <div class="form-group" >
                        <label class="control-label" for="email" id="email_center"> Login Email * </label>
                        <input class="form-control" style="width:95%" type="email" name="email" id="email" required="required" value="<?php if (Session::exists('email')){ echo(Session::flash('email')); } ?>" onchange="checkEmail(this.value)" >
                        <p class="help-block" id="email_center_status">Please note that this email has to be verified and must be unique to you. All information will be sent to this mail.</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="telephone" id="call_center">Contact Phone Number</label>
                        <br/>
                        <input type="hidden" id="phone_number" name="phone_number">
                        <input type="hidden" name="url_path" id="url_path" value="<?php echo URL; ?>">
                        <input type="tel" id="telephone" name="telephone" onchange="intlNumber()" class="form-control" style="width:95%" required="required" value="<?php if (Session::exists('telephone')){ echo(Session::flash('telephone')); } ?>" />



                        <p class="help-block" id="call_center_status">Please note that all SMS Notifications will be sent to this Number (Has to be verified also).</p>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password">Password*</label>
                        <input class="form-control" style="width:95%"  type="password" name="password" id="password" required="required">
                        <span id="strength"></span>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="password_again">Password Again*</label>
                        <input class="form-control" style="width:95%" type="password" name="password_again" id="password_again" required="required" >
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />

                    </div>

                    <div class="form-group">
                        <label class="w3-checkbox">
                            <input type="checkbox" name="agreement_2_terms" id="agreement_2_terms" value="yes">
                             I have read and agreed to be bound by the <a href="#" target="#">rules and regulations of the School*</a>
                        </label>
                    </div>

                    <div class="form-group">
                        <label for="owner_is">Please Identify Yourself Accordingly*</label>
                        <div class="input-group">
                            <div class="input-group-addon">I am a</div>
                            <select class="form-control" name="owner_is" id="owner_is" required="required">
                                <option value="1">Student/ Prospective (Use details of the Student Registered)</option>
                                <option value="2">Parent/ Sponsor (Use details of the Parent/ Sponsor Registered)</option>
                                <option value="3">Staff</option>
                                <option value="0">Others</option>

                            </select>

                        </div>
                    </div>

                    <script src='https://www.google.com/recaptcha/api.js'></script>
                    <div class="row">
                        <div class="col-sm-12 form-group">
                            <div class="g-recaptcha" data-sitekey="6LeWVSgTAAAAAMAHV2Dl4t9z7AGKxexuUFjoxZGh"></div>                    </div>
                    </div>


                    <p id="login_status"></p>
                    <p>Applications not verified in 7 days will be deleted from the database.</p>




                    <input type="hidden" name="record_tracker" id="record_tracker" value="<?php echo $_SESSION['record_tracker']; ?>" />

                    <div class="row">
                        <div class="col-sm-12" id="login_submit">
                            <input class="btn btn-primary btn-lg" type="submit" name="send" id="send" value="Submit &amp; Start" onclick="login_box()" />
                        </div>
                    </div>
                    <?php //echo $salt = Hash::randomDigits(6); ?>
                    <br />

                </form>

            </div>
            <?php
                include(View::modal_sms());
            ?>

        </div>

        <div class="col-sm-5">

            <h2>REQUIREMENTS <small>From The School Mgt</small></h2>
            <div class="list-group">
                <?php

                    if (isset($this->navigation)){
                        foreach($this->navigation as $item => $page){
                            ?>
                            <li> <a href="#" class="list-group-item <?php if($this->navigation['web'] === $page ){ echo(' active'); }  ?>" title="<?php echo $page['name']; ?>"> <?php echo $page['name']; ?></a></li>
                        <?php } }  ?>

            </div>

        </div>
    </div>
</div>



