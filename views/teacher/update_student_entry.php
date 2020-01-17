<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                 Students Record Office
                <small>Teacher's panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


            </ol>


        </section>

        <!-- Main content -->
        <section class="content">
        <section class="content-header">
            <h2>
                Update/ Edit Details: <?php
                    if(isset($this->students)){
                        $mod = $this->students;
                        echo(($mod['student_name']).' '.($mod['student_reg_no']));
                    }
                ?>
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
                        Here is where you enter/edit info
                    </div>
                <?php } ?>

            </div>


        </section>

            <!-- Your Page Content Here -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-3 col-sm-6 col-xs-12">

                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">THE Students Record </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>A couple of things you need to note about Adding New Student Record </p>
                            <ul>
                                <li><strong>The Full Name:</strong>
                                    This is the full name of the person, including first name, surname and middle names. Ensure they are well spaced and correctly spelled. </li>
                                <li><strong>The Reg ID:</strong>
                                    The Student Registration Number/ I.D is what the school uses to identify any particular student. Ensure it is entered correctly
                                </li>
                                <li><strong>Other Details:</strong>
                                    This is any other detail, the school would like to describe any particular student.
                                </li>
                            </ul>



                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Improve this Description</button>
                        </div>
                    </div>
                    <!-- /.box -->


                </div>
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'teacher/record/update/'.$mod['student_id']); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                            <div class="box-header with-border">
                                <h3 class="box-title">Update/Edit Record</h3>
                            </div>

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="student_name">Student Full Name</label>

                                    <input type="text" class="form-control" name="student_name" id="student_name" value=" <?php if (isset($mod['student_name'])){ echo(($mod['student_name'])); } ?>">
                                </div>

                                <div class="form-group">
                                    <label for="student_reg_id">Student Registration Number/ I.D</label>

                                    <input type="text" class="form-control" name="student_reg_id" id="student_reg_id" value=" <?php if (isset($mod['student_reg_no'])){ echo(($mod['student_reg_no'])); } ?>">
                                </div>

                                <div class="form-group">
                                    <label for="select_sex">Select Sex</label>

                                    <select class="form-control" name="select_sex" id="select_sex">
                                        <?php if (isset($mod['sex'])){ ?>
                                            <option value="<?php echo(($mod['sex']));  ?>"><?php echo(($mod['sex'])); } ?></option>

                                        <option value="Female">Female</option>
                                        <option value="Male">Male</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Other Details</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Brief Description...">
                                        <?php if (isset($mod['details'])){ echo(($mod['details'])); } ?>

                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="select_class">Select Class</label>

                                    <select class="form-control" name="select_class" id="select_class">

                                        <?php foreach ($this->class as $class){ ?>
                                            <option value="<?php echo $class['class_id']; ?>" <?php  if($mod['start_class'] == $class['class_id']){echo('selected="selected"');} ?> ><?php echo $class['class_name'] ; ?></option>


                                        <?php }  ?>




                                    </select>
                                    <p class="help-block">Note: JS1 is the Parent Class to JS1a, JS1b.</p>

                                </div>

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo(URL.'teacher/student'); ?>" class="btn btn-danger pull-right">Finish/Exit</a>
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