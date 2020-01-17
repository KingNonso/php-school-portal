<?php
    $user = new User();
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12">
            <h2>Congratulations, Admission Granted</h2>


            <?php
                if(isset($this->admissions)){
                    $mod = $this->admissions;
                    ?>
                    <div class="row">
                        <div class="col-sm-5">
                            <img src="<?php echo(URL) ?>public/uploads/profile-pictures/<?php echo($mod['profile_picture']); ?>" alt="<?php echo $mod['name'];  ?>" class="img-thumbnail" width="65" height="65" />
                        </div>
                        <div class="col-sm-7">
                            <h3><b>Name: </b><?php echo $mod['name'];  ?></h3>
                            <p><b>Student Number: </b><?php echo $mod['student_reg_no'];  ?></p>
                        </div>


                    </div>
                    <p><b>Class: </b><?php echo $mod['class_name'];  ?></p>
                    <p><b>Standard: </b><?php echo $mod['parent_class'];  ?></p>

                <?php

                }
            ?>
        </div>
    </div>
</div>



