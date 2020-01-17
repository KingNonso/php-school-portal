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
                <form id="form1" name="form1" method="post" action="<?php echo URL; ?>admission/educational"  enctype="multipart/form-data">
                    <div class="col-sm-12">
                        <h1>Educational Information</h1>

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


                    <div class="form-group">
                        <label class="control-label" for="institute">Name of Institution Last Attended*</label>
                        <input class="form-control" style="width:95%" required="required" type="text" name="institute" id="institute"  value="<?php if (Session::exists('institute')){ echo(Session::flash('institute')); } ?>"  >
                    </div>
                    <div class="form-group">
                        <label for="program">Highest  Qualification*</label>
                        <select class="form-control" name="program" id="program" style="width:95%" required="required">
                            <?php if (Session::exists('program')){?>
                                <option value="<?php echo $flash = Session::flash('program'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <option value="0">Select</option>
                            <?php Person::get_program(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="course"> Examination Taken</label>
                        <input class="form-control" style="width:95%" type="text" name="course" id="course"  value="<?php if (Session::exists('course')){ echo(Session::flash('course')); } ?>"  />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="faculty"> Examining Board </label>
                        <input class="form-control" style="width:95%" type="text" name="faculty" id="faculty"  value="<?php if (Session::exists('faculty')){ echo(Session::flash('faculty')); } ?>"  />
                    </div>
                    <div class="form-group">
                        <label for="adm_day">Admission/Entry Date*</label>
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" name="adm_day" id="adm_day" required="required">
                                    <?php if (Session::exists('adm_day')){?>
                                        <option value="<?php echo $flash = Session::flash('adm_day'); ?>" selected="selected"><?php echo $flash; ?></option>
                                    <?php }?>
                                    <option value="0">Day</option>
                                    <?php Date::daygen(); ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="adm_month" id="adm_month" required="required">
                                    <?php if (Session::exists('adm_month')){?>
                                        <option value="<?php echo $flash = Session::flash('adm_month'); ?>" selected="selected"><?php echo $flash; ?></option>
                                    <?php }?>
                                    <option value="0">Month</option>
                                    <?php Date::monthgen(); ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="adm_year" id="adm_year" required="required">
                                    <?php if (Session::exists('adm_year')){?>
                                        <option value="<?php echo $flash = Session::flash('adm_year'); ?>" selected="selected"><?php echo $flash; ?></option>
                                    <?php }?>
                                    <option value="0">Year</option>
                                    <?php Date::yeargen(); ?>

                                </select>
                            </div>

                        </div>
                    </div>
                    <div class="form-group w3-container">
                        <label for="grad_day">Graduation Date</label>
                        <div class="row">
                            <div class="col-sm-4">
                                <select class="form-control" name="grad_day" id="grad_day">
                                    <?php if (Session::exists('grad_day')){?>
                                        <option value="<?php echo $flash = Session::flash('grad_day'); ?>" selected="selected"><?php echo $flash; ?></option>
                                    <?php }?>
                                    <option value="0">Day</option>
                                    <?php Date::daygen(); ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="grad_month" id="grad_month">
                                    <?php if (Session::exists('grad_month')){?>
                                        <option value="<?php echo $flash = Session::flash('grad_month'); ?>" selected="selected"><?php echo $flash; ?></option>
                                    <?php }?>
                                    <option value="0">Month</option>
                                    <?php Date::monthgen(); ?>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <select class="form-control" name="grad_year" id="grad_year">
                                    <?php if (Session::exists('grad_year')){?>
                                        <option value="<?php echo $flash = Session::flash('grad_year'); ?>" selected="selected"><?php echo $flash; ?></option>
                                    <?php }?>
                                    <option value="0">Year</option>
                                    <?php Date::yeargen(); ?>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="sch_address">Full School Address*</label>
                        <textarea class="form-control" style="width:95%" required="required" name="sch_address" id="sch_address" >
                            <?php if (Session::exists('sch_address')){ echo(Session::flash('sch_address')); } ?>
                        </textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="sch_phone">School Contact Phone No</label>
                        <input class="form-control" style="width:95%"  type="text" name="sch_phone" id="sch_phone" value="<?php if (Session::exists('sch_phone')){ echo(Session::flash('sch_phone')); } ?>" />
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="sch_postal">School Postal Address</label>
                        <textarea class="form-control" style="width:95%" name="sch_postal" id="sch_postal" >
                            <?php if (Session::exists('sch_postal')){ echo(Session::flash('sch_postal')); } ?>
                        </textarea>
                    </div>
                    
                    
                    

                    

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
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
                            <li> <a href="#" class="list-group-item <?php if($this->navigation['two'] === $page ){ echo(' active'); }  ?>" title="<?php echo $page['name']; ?>"> <?php echo $page['name']; ?></a></li>
                        <?php } }  ?>

            </div>

        </div>
    </div>
</div>



