<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                The Academic Results
                <small>Teacher's panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


            </ol>


        </section>

        <section class="content-header">
            <h2>
                 Result Entry
            </h2>
            <div class="box-body">
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
                        Here is where you enter new info
                    </div>
                <?php } ?>

            </div>


        </section>



        <section class="content">

            <div class="row">
                <!-- left column -->
                <div class="col-sm-7 col-sm-offset-3 ">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border" id="">
                            <h2 class="box-title text-center">New Result Entry </h2>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'teacher/start_recording'); ?>" method="post">


                            <div class="box-body">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="entry_session">Select Academic Session</label>

                                            <select class="form-control" name="entry_session" id="entry_session" onchange="startRecord('term',1)" required="required">
                                                <?php echo($this->sessions); ?>


                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="entry_term">Academic Term</label>
                                            <select class="form-control" name="entry_term" id="entry_term">
                                                <?php if (Session::exists('entry_term')){?>
                                                    <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label for="select_class">Select Class</label>

                                            <select class="form-control" name="select_class" id="select_class" onchange="startRecord('class',1)">
                                                <option value="0">Select Class</option>

                                                <?php foreach ($this->class as $class){ ?>
                                                    <option value="<?php echo $class['class_id']; ?>" ><?php echo $class['class_name'] ; ?></option>
                                                <?php }  ?>
                                            </select>

                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="select_subject">Select Subject</label>

                                                <select class="form-control" name="select_subject" id="select_subject">
                                                    <option value="0">Loading</option>

                                                    <?php foreach ($this->subject as $subject){ ?>
                                                        <option value="<?php echo $subject['subject_id']; ?>" ><?php echo $subject['subject_name'].' for '.$subject['subject_for'] ; ?></option>

                                                    <?php }  ?>

                                                </select>

                                            </div>

                                        </div>


                                </div>

                                <div class="row">
                                    <div class="col-sm-12"></div>
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer pull-right">
                                <button type="submit" class="btn btn-primary">START</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->


                </div>
                <!--/.col (left) -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>