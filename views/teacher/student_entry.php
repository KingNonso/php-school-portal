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
                Record of <?php echo Session::get('academic_class_name'); ?>  Class
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
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Showing All: Total
                                    <?php
                                        if(isset($this->students)){
                                            echo(count($this->students));
                                        }
                                    ?>
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Surname</th>
                                        <th>Names</th>
                                        <th>Reg ID</th>
                                        <th>Details </th>
                                        <th colspan="4">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if(isset($this->students)){
                                        foreach($this->students as $mod){
                                            ?>
                                            <tr>
                                                <td> <?php echo($mod->surname); ?></td>
                                                <td> <?php echo($mod->othername); ?></td>
                                                <td> <?php echo $mod->reg_no;  ?></td>

                                                <td> <?php echo $mod->details; ?></td>
                                                <td> <a href="<?php echo URL; ?>teacher/record/edit/<?php echo $mod->student_id; ?>" class="btn btn-info btn-flat">Edit</a></td>
                                                <td> <a href="<?php echo URL; ?>teacher/record/delete/<?php echo $mod->student_id; ?>" class="btn btn-default btn-flat">Delete</a></td>


                                                <td> <a href="<?php echo URL; ?>teacher/check_result/<?php echo $mod->student_id; ?>" class="btn btn-danger btn-flat">Print Result</a></td>
                                                <td> <a href="<?php echo URL; ?>teacher/cumulative_result/<?php echo $mod->student_id; ?>" class="btn btn-success btn-flat">Cumulative Result</a></td>

                                            </tr>
                                        <?php }}  ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Surname</th>
                                        <th>Names</th>
                                        <th>Reg ID</th>
                                        <th>Details </th>
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

            <div class="row">
                <!-- left column -->
                <div class="col-md-12 col-sm-12 col-xs-12">

                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">THE Students Record </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">

                            <h4>Print/ Preview Class Record</h4>
                            <div class="list-group">
                                <a href="<?php echo(URL.'teacher/preview'); ?>"  class="list-group-item">Print Data Sheet</a>
                                <a href="<?php echo(URL.'teacher/preview/1'); ?>"   class="list-group-item">Print Omni Bus</a>
                                <a href="<?php echo(URL.'teacher/annual'); ?>"  class="list-group-item">Print Annual</a>
                            </div>
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
                <!--/.col (left) -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>