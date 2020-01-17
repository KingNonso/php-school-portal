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
                <form id="form1" name="form1" method="post" action="<?php echo URL; ?>admission/admission"  enctype="multipart/form-data">
                    <div class="col-sm-12">
                        <h1>ADMISSION Entry Information</h1>

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
                        <label class="control-label" for="exam_taken">Exam Number</label>
                        <input class="form-control" type="text" name="exam_taken" id="exam_taken"  value="<?php if (Session::exists('exam_taken')){ echo(Session::flash('exam_taken')); } ?>"  >
                    </div>
                    <div class="form-group">
                        <label for="exam_score">Exam Score</label>
                        <input class="form-control" type="text" name="exam_score" id="exam_score"  value="<?php if (Session::exists('exam_score')){ echo(Session::flash('exam_score')); } ?>"  />  
                    </div>
                    <div class="form-group">
                        <label for="entry_session">Admission/Entry Session*</label>
                        <select class="form-control" name="entry_session" id="entry_session" required="required">
                            <?php if (Session::exists('entry_session')){?>
                                <option value="<?php echo $flash = Session::flash('entry_session'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <?php Date::sessionsInFuture(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="entry_term">Admission/Entry Term*</label>
                        <select class="form-control" name="entry_term" id="entry_term">
                            <?php if (Session::exists('entry_term')){?>
                                <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <option value="0">Select Starting Term</option>
                            <option value="1">First (1st)</option>
                            <option value="2">Second (2nd)</option>
                            <option value="3">Third (3rd)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="entry_class">Admission/Entry Class*</label>
                        <select class="form-control" name="entry_class" id="entry_class">


                            <?php foreach ($this->class as $class){ if($class['parent_class'] == null){ ?>
                                <option value="<?php echo $class['class_name']; ?>" <?php if (Session::flash('entry_class') == $class['class_name'] ){echo "selected=\"selected\"";} ?> ><?php echo $class['class_name'] ; ?></option>


                            <?php }}  ?>




                        </select>
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
                            <li> <a href="#" class="list-group-item <?php if($this->navigation['three'] === $page ){ echo(' active'); }  ?>" title="<?php echo $page['name']; ?>"> <?php echo $page['name']; ?></a></li>
                        <?php } }  ?>

            </div>

        </div>
    </div>
</div>



