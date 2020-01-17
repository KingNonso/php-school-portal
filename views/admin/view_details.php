<?php
    include(View::NavBar());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                View Details of <?php echo($this->action); ?>
                <small>Here are details for your perusal</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>
            </ol>
        </section>

        <?php
            $date = new DateTime('now');
            $today = $date->format('d F, Y');
        ?>

        <!-- Main content -->
        <section class="content">

            <!-- row -->
            <div class="row">
                <div class="col-md-12">
                    <!-- The time line -->
                    <ul class="timeline">
                        <!-- timeline time label -->
                        <li class="time-label">
                  <span class="bg-red">
                    <?php echo $today; ?>

                  </span>
                        </li>
                        <?php
                            if(isset($this->advisers)){
                                foreach($this->advisers as $mod){?>
                                    <li>
                                        <i class="fa fa-user bg-aqua"></i>

                                        <div class="timeline-item">
                                            <span class="time"> Made Adviser on  <i class="fa fa-clock-o"></i>
                                                <?php
                                                    echo $mod['date'];
                                                ?> </span>

                                            <h3 class="timeline-header no-border"><a href="#"> <?php echo($mod['name']); ?> </a>
                                            </h3>
                                            <div class="timeline-body">
                                                <p><b>Class: </b><?php echo $mod['class_name'];  ?></p>
                                                <p><b>Session: </b><?php echo $mod['session_name'];  ?></p>
                                                <p><b>Term: </b><?php echo $mod['term'];  ?></p>
                                                <p><b>Contact: </b><?php echo $mod['phone_no'];  ?></p>
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="<?php echo URL; ?>admin/adviser/class/<?php echo $mod['person_id']; ?>" class="btn btn-info btn-flat">Assign Class</a>

                                                <a href="<?php echo URL; ?>admin/adviser/delete/<?php echo $mod['adviser_id']; ?>" class="btn btn-danger btn-flat">Remove</a>
                                            </div>
                                        </div>
                                    </li>

                                <?php
                                }
                            }
                        ?>
                        <?php
                            if(isset($this->teachers)){
                                foreach($this->teachers as $mod){?>
                                    <li>
                                        <i class="fa fa-user bg-aqua"></i>

                                        <div class="timeline-item">
                                            <span class="time"> Made Adviser on  <i class="fa fa-clock-o"></i>
                                                <?php
                                                    echo $mod['date'];
                                                ?> </span>

                                            <h3 class="timeline-header no-border"><a href="#"> <?php echo($mod['name']); ?> </a>
                                            </h3>
                                            <div class="timeline-body">
                                                <p><b>Class: </b><?php echo $mod['subject_for'];  ?></p>
                                                <p><b>Subject: </b><?php echo $mod['subject_name'];  ?></p>
                                                <p><b>Has Lab Session: </b><?php $echo = ($mod['lab_enabled'] == 1)? 'Yes': 'No'; echo $echo;  ?></p>
                                                <p><b>Prerequisite: </b><?php echo $mod['prerequisite'];  ?></p>
                                                <p><b>Description: </b><?php echo $mod['description'];  ?></p>
                                                <p><b>Session: </b><?php echo $mod['session_name'];  ?></p>
                                                <p><b>Term: </b><?php echo $mod['term'];  ?></p>
                                                <p><b>Contact: </b><?php echo $mod['phone_no'];  ?></p>
                                            </div>
                                            <div class="timeline-footer">
                                                <a href="<?php echo URL; ?>admin/teacher/subject/<?php echo $mod['person_id']; ?>" class="btn btn-info btn-flat">Assign Class</a>

                                                <a href="<?php echo URL; ?>admin/teacher/delete/<?php echo $mod['teacher_id']; ?>" class="btn btn-danger btn-flat">Remove</a>
                                            </div>
                                        </div>
                                    </li>

                                <?php
                                }
                            }
                        ?>
                        <li>
                            <i class="fa fa-clock-o bg-gray"></i>
                        </li>
                    </ul>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->


        </section>    <!-- /.content -->
    </div>  <!-- /.content-wrapper -->

<?php
    include(View::rightNav());
?>