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
                <form action="<?php echo URL; ?>admission/parents_info" method="post" enctype="multipart/form-data" name="form1" class="w3-container w3-card-4" id="form1">
                    <div class="col-sm-12">
                        <h1>Sponsor (Parents & Next of Kin) Information</h1>

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

                    <div class="form-group">
                        <label class="control-label" for="parents_name">Name of Sponsor (Parents & Next of Kin)*</label>
                        <input class="form-control" style="width:95%" required type="text" name="parents_name" id="parents_name"  value="<?php if (Session::exists('parents_name')){ echo(Session::flash('parents_name')); } ?>" >
                    </div>
                    <div class="form-group w3-container">
                        <label for="day">Relationship*</label>
                        <select class="form-control" name="relationship" id="relationship" required="required">
                            <?php if (Session::exists('relationship')){?>
                                <option value="<?php echo $flash = Session::flash('relationship'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <option value="0">Select</option>
                            <?php Person::relationship(); ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="parents_phone"> Phone Number of Parent/ Guardian* </label>
                        <input class="form-control" style="width:95%" required type="text" name="parents_phone" id="parents_phone"  value="<?php if (Session::exists('parents_phone')){ echo(Session::flash('parents_phone')); } ?>" >
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="parents_email"> Email of Parent/ Guardian</label>
                        <input class="form-control" style="width:95%" type="email" name="parents_email" id="parents_email"  value="<?php if (Session::exists('parents_email')){ echo(Session::flash('parents_email')); } ?>" >
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="parents_occupation"> Occupation of Parent/ Guardian</label>
                        <input class="form-control" style="width:95%" type="text" name="parents_occupation" id="parents_occupation"  value="<?php if (Session::exists('parents_occupation')){ echo(Session::flash('parents_occupation')); } ?>" >
                    </div>




                    <div class="form-group">
                        <label class="control-label" for="biz_address">Full Business/ Office Address*</label>
                        <textarea class="form-control" style="width:95%" name="biz_address" id="biz_address" required>
                            <?php if (Session::exists('biz_address')){ echo(Session::flash('biz_address')); } ?>
                        </textarea>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="home_address">Home/ Residence Address</label>
                        <textarea class="form-control" style="width:95%" name="home_address" id="home_address">
                            <?php if (Session::exists('home_address')){ echo(Session::flash('home_address')); } ?>
                        </textarea>
                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />

                    </div>
                    <p>Just in case you are unable to complete your registration for any reason, it is being tracked by this alphanumeric code below. You may wish to copy and paste it somewhere. It's computer generated and It would be useless after the application is completed </p>
                    <p class="text-primary">  <?php  echo $_SESSION['record_tracker']; ?></p>

                    <div class="row">
                        <div class="col-sm-12">
                            <input class="btn btn-primary btn-lg" type="submit" name="send" id="send" value="Submit &amp; Proceed" />
                        </div>
                    </div>
                    <br />

                </form>


            </div>

        </div>
        <div class="col-sm-5">

            <h2>REQUIREMENTS <small>From The School Mgt</small></h2>
            <div class="list-group">
                <?php

                    if (isset($this->navigation)){
                        foreach($this->navigation as $item => $page){
                            ?>
                            <li> <a href="#" class="list-group-item <?php if($this->navigation['parent'] === $page ){ echo(' active'); }  ?>" title="<?php echo $page['name']; ?>"> <?php echo $page['name']; ?></a></li>
                        <?php } }  ?>

            </div>

        </div>
    </div>
</div>



