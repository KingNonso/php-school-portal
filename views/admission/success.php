<?php
    $user = new User();
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12">
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


            <?php
                if(isset($this->admissions)){
                    $mod = $this->admissions;
                    ?>
                    <div>
                        <i class="fa fa-user bg-aqua"></i>

                        <div class="timeline-item">
                                            <span class="time"> Made Application on  <i class="fa fa-clock-o"></i>
                                                <?php
                                                    echo $mod['date'];
                                                ?> </span>

                            <h3 class="timeline-header no-border"><a href="#"> <?php echo($mod['name']); ?> </a>
                            </h3>
                            <div class="timeline-body">
                                <p><b>Sex: </b><?php echo $mod['sex'];  ?></p>
                                <p><b>Date of Birth: </b><?php echo $mod['dob'];  ?></p>
                                <p><b>Marital Status: </b><?php echo $mod['marital_status'];  ?></p>
                                <p><b>Place of Birth: </b><?php echo $mod['place_of_birth'];  ?></p>

                                <p><b>State of Origin: </b><?php echo $mod['state_of_origin'];  ?></p>
                                <p><b>LGA: </b><?php echo $mod['lga'];  ?></p>
                                <p><b>Nationality: </b><?php echo $mod['nationality'];  ?></p>
                                <p><b>Phone Number: </b><?php echo $mod['phone_no'];  ?></p>
                                <p><b>Postal address: </b><?php echo $mod['postal_address'];  ?></p>
                                <p><b>Postal state: </b><?php echo $mod['postal_state'];  ?></p>
                                <p><b>Email: </b><?php echo $mod['email'];  ?></p>
                                <p><b>Residential address: </b><?php echo $mod['residential_address'];  ?></p>
                                <p><b>State of Residence: </b><?php echo $mod['state_of_residence'];  ?></p>
                                <h3>Educational Information</h3>
                                <p><b>Name of Institution Last Attended: </b><?php echo $mod['institution'];  ?></p>
                                <p><b>Highest Qualification: </b><?php echo $mod['program'];  ?></p>
                                <p><b>Examination Taken: </b><?php echo $mod['course'];  ?></p>
                                <p><b>Examining Board: </b><?php echo $mod['faculty'];  ?></p>
                                <p><b>Admission/Entry Date: </b><?php echo $mod['admission_date'];  ?></p>
                                <p><b>Graduation Date: </b><?php echo $mod['graduation_date'];  ?></p>
                                <p><b>School Address: </b><?php echo $mod['school_address'];  ?></p>
                                <p><b>School Phone No: </b><?php echo $mod['school_phone'];  ?></p>
                                <p><b>Sex: </b><?php echo $mod['sex'];  ?></p>
                            </div>

                            <div class="timeline-footer">
                                <a href="<?php echo URL; ?>admission/status/accept/<?php echo $mod['adm_app_id']; ?>" onclick="return confirm('This cannot be undone. PROCEED?')" class="btn btn-success btn-flat">Accept </a>

                                <a href="<?php echo URL; ?>admission/status/decline/<?php echo $mod['adm_app_id']; ?>" onclick="return confirm('This cannot be undone. PROCEED?')" class="btn btn-danger btn-flat">Decline </a>
                            </div>
                        </div>
                    </div>

                <?php

                }
            ?>
        </div>
    </div>
</div>



