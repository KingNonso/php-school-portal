<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                The School Classes
                <small>Teacher's panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


            </ol>

        </section>

        <!-- Main content -->
        <section class="content">
            <section class="content">
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
                    <?php } ?>

                </div>

                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Showing all </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Classes</th>
                                        <th>Super Class</th>
                                        <th colspan="4">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if(isset($this->class)){
                                            foreach($this->class as $mod){
                                                ?>
                                                <tr>
                                                    <td> <?php echo $mod['class_name'];  ?></td>
                                                    <td><?php echo($mod['super_class']); ?></td>

                                                    <td><a href="<?php echo URL; ?>teacher/add_students/<?php echo $mod['class_id']; ?>" class="btn btn-success btn-flat"> Students </a></td>
                                                    <td><a href="<?php echo URL; ?>teacher/add_subjects/<?php echo $mod['class_id']; ?>" class="btn btn-danger btn-flat"> Subjects </a></td>
                                                    <td><a href="<?php echo URL; ?>teacher/termly_report_sheet/<?php echo $mod['class_id'].'/'.Session::get('academic_term_id'); ?>" class="btn btn-primary btn-flat"> Compute <?php echo Session::get('academic_term_name'); ?> Term Result</a></td>
                                                    <td><a href="<?php echo URL; ?>teacher/run_cumulative/<?php echo $mod['class_id']; ?>" class="btn btn-default btn-flat">Compute <?php echo Session::get('academic_session_name'); ?> Annual </a></td>

                                                </tr>
                                            <?php } } ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Classes</th>
                                        <th>Super Class</th>
                                        <th colspan="4">Actions</th>
                                    </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->

                        <!-- /.box -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </section>

            <!-- Your Page Content Here -->
            <section class="content-header">
                <h2>
                    Create a New Class
                </h2>


            </section>

            <div class="row">
                <!-- left column -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Create Classrooms in <?php echo(Session::get('school_name')); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'teacher/create_class'); ?>" method="post" id="contact_form">
                            <input type="hidden" name="classType" id="classType" />

                            <div class="box-body">
                                <div class="list-group" id="selectClass">
                                    <a href="javascript:void(0);" class="list-group-item" onclick="selectClass('JSS')">
                                        <h4 class="list-group-item-heading">Create JSS Classes</h4>
                                        <p class="list-group-item-text"> Junior Secondary School</p>
                                    </a>
                                    <a href="javascript:void(0);" class="list-group-item" onclick="selectClass('SS')">
                                        <h4 class="list-group-item-heading">Create SS Classes</h4>
                                        <p class="list-group-item-text"> Senior Secondary School</p>
                                    </a>

                                </div>
                            </div>
                            <div class="box-body" id="createClass">

                                <div class="form-group">
                                    <label for="class_name">Class Name</label>
                                    <input type="number" class="form-control" id="class_name" name="class_name" placeholder="Enter  Digits e.g. 1 or 2 ..." value="<?php if (Session::exists('class_name')){ echo(Session::flash('class_name')); } ?>">
                                    <p class="help-block">Enter only digits here</p>
                                </div>

                                <div class="form-group">
                                    <label for="sub_class">Sub Classes</label>
                                    <input type="text" class="form-control" id="sub_class" name="sub_class" placeholder="a,b,c,x..." value="<?php if (Session::exists('sub_class')){ echo(Session::flash('sub_class')); } ?>">
                                    <p class="help-block">Enter all sub-classes under the class name, comma delimited</p>

                                </div>




                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
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