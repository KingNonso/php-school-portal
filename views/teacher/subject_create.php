<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            All Subjects
            <small>Teacher's panel</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php  echo Session::breadcrumbs(); ?>  - You are here</p>


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
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Prerequisite</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($this->subject)){
                                        foreach($this->subject as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['subject_name']);  ?></td>
                                                <td><?php echo $mod['subject_for'];  ?></td>
                                                <td><?php echo $mod['prerequisite'];  ?></td>

                                                <td><a href="<?php echo URL; ?>teacher/subject/update/<?php echo $mod['subject_id']; ?>" class="btn btn-success btn-flat">Edit</a></td>



                                            </tr>
                                        <?php }} ?>


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Subject</th>
                                    <th>Class</th>
                                    <th>Prerequisite</th>
                                    <th>Actions</th>
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

        <section class="content-header">
        <h2>
            Create a New subject
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
        <div class="col-md-12 col-sm-12 col-xs-12">
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"> Subject Center</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="<?php echo(URL.'teacher/create_subject'); ?>" method="post" id="contact_form" onsubmit="return false">
                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />

                    <div class="box-body">
                        <div class="form-group">
                            <label for="subject_name">Subject Full Name</label>
                            <input type="text" class="form-control" id="subject_name" name="subject_name" placeholder="Enter  Full Name e.g. Introductory Technology ..." value="<?php if (Session::exists('subject_name')){ echo(Session::flash('subject_name')); } ?>">
                        </div>
                        <div class="form-group">
                            <label for="subject_alias">Subject Short Name/ Alias</label>
                            <input type="text" class="form-control" id="subject_alias" name="subject_alias" placeholder="Enter  Short Name e.g. Intro Tech ..." value="<?php if (Session::exists('subject_alias')){ echo(Session::flash('subject_alias')); } ?>">
                        </div>




                        <div class="list-group createClassStep">
                            <a href="javascript:void(0);" class="list-group-item" onclick="classSubjectCreator('all',1)">
                                <h4 class="list-group-item-heading">Create for All Available Classes</h4>
                                <p class="list-group-item-text">Subject will be created for all classes</p>
                            </a>
                            <a href="javascript:void(0);" class="list-group-item" onclick="classSubjectCreator('jss',1)">
                                <h4 class="list-group-item-heading">Create for all JSS Classes</h4>
                                <p class="list-group-item-text">Junior Secondary School</p>
                            </a>
                            <a href="javascript:void(0);" class="list-group-item" onclick="classSubjectCreator('ss',1)">
                                <h4 class="list-group-item-heading">Create for all SS Classes</h4>
                                <p class="list-group-item-text">Senior Secondary School</p>
                            </a>

                        </div>

                        <div class="createClassStep">
                            <h4>Create for individual classes</h4>
                            <div class="form-group">
                                <label for="classes">Select Classes Here</label>
                                <div class="form-group"  id="tags">
                                    <select class="form-control select2" multiple="multiple" data-placeholder="Start typing here..." style="width: 100%;" id="classes">
                                        <option></option>
                                        <?php
                                            foreach($this->class as $tag){
                                                ?>

                                                <option value="<?php echo $tag['class_id']; ?>"><?php echo $tag['class_name']; ?></option>
                                            <?php }  ?>
                                    </select>
                                </div>

                                <p class="help-block">Enter class one by one, Use comma or space to separate tags.</p>

                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="alert alert-info alert-dismissible" id="creatingClass">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-gears"></i> PROCESSING!</h4>
                        Please wait while the subject for the respective class is being created. Thanks
                    </div>


                    <div class="box-footer createClassStep">
                        <button type="submit" class="btn btn-primary" onclick="classSubjectCreator('class',1)">Submit</button>
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