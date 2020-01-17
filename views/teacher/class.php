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
                                        <th>Super Class</th>
                                        <th>Classes</th>
                                        <th colspan="4">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        if(isset($this->class)){
                                        foreach($this->class as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['class_name']); ?></td>
                                                <td><?php echo $mod['parent_class'];  ?></td>
                                                <td><?php echo $mod['class_desc'];  ?></td>
                                                <td><?php echo $mod['requirement'];  ?></td>

                                                <td><a href="<?php echo URL; ?>teacher/add_students/<?php echo $mod['class_id']; ?>" class="btn btn-success btn-flat"> Students </a></td>
                                                <td><a href="<?php echo URL; ?>teacher/add_subjects/<?php echo $mod['class_id']; ?>" class="btn btn-danger btn-flat"> Subjects </a></td>
                                                <td><a href="<?php echo URL; ?>teacher/add_result/class/<?php echo $mod['class_id']; ?>" class="btn btn-primary btn-flat"> Result</a></td>
                                                <td><a href="<?php echo URL; ?>teacher/run_cumulative/<?php echo $mod['class_id']; ?>" class="btn btn-default btn-flat">Compute Cumulative</a></td>



                                            </tr>
                                        <?php } } ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Class</th>
                                        <th>Parent</th>
                                        <th>Description</th>
                                        <th>Requirements</th>
                                        <th colspan="2">Actions</th>
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

            <div class="row">
                <!-- left column -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">THE Classroom</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>When you wish to create a new Classroom, there are a couple of things you need to note.</p>
                            <ul>
                                <li><strong>The Classroom:</strong> Anything with position one is what appears first in the display. The position 1, is also unique as it shows up on the home page also. The position shows the hierarchy of how it would be displayed to the user. </li>
                                <li><strong>The Parent:</strong> Anything with Visibility equals to one will be shown, while Visibility equals to zero(0) will be hidden. This is useful if you just want to hide and not delete a particular content. </li>
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
                        <div class="box-header with-border">
                            <h3 class="box-title">Create Classrooms in <?php echo(Session::get('school_name')); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'teacher/create_class'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />

                            <div class="box-body">
                                <div class="form-group">
                                    <label for="class_name">Class Name</label>
                                    <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Enter  Short Name e.g. JS1, SS1 ..." value="<?php if (Session::exists('class_name')){ echo(Session::flash('class_name')); } ?>">
                                </div>
                                <div class="form-group">
                                    <label>Class Description</label>
                                    <textarea class="form-control textarea" rows="2" placeholder="Enter Long Name here e.g. Junior Secondary School One ..." id="class_desc" name="class_desc">
                                        <?php if (Session::exists('class_desc')){ echo(Session::flash('class_desc')); } ?>
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="parent_class">Parent Class</label>
                                    <p class="help-block">E.g. JS1 is the Parent to JS1a, JS1b.</p>
                                    <select class="form-control" name="parent_class" id="parent_class">

                                        <option value="">Nil</option>

                                        <?php foreach ($this->class as $class){ if($class['parent_class'] == null){ ?>
                                            <option value="<?php echo $class['class_name']; ?>" <?php if (Session::flash('parent_class') == $class['class_name'] ){echo "selected=\"selected\"";} ?> ><?php echo $class['class_name'] ; ?></option>


                                        <?php }}  ?>




                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Requirements to be in this class</label>
                                    <textarea class="form-control textarea" rows="3" placeholder="Enter requirement here ..." id="requirement" name="requirement">
                                        <?php if (Session::exists('requirement')){ echo(Session::flash('requirement')); } ?>
                                    </textarea>
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