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

        <?php
            $mod = $this->subject;
        ?>        <!-- Main content -->
        <section class="content">
        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header">
                            <h3 class="box-title">Showing
                                <?php
                                    if(isset($this->person)){
                                        $mod = $this->person;
                                        echo($this->person);
                                    }
                                ?>
                            </h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example2" class="table table-bordered table-hover table-striped">
                                <thead>
                                <tr>
                                    <th>Student No</th>
                                    <th>Student Name</th>
                                    <th>Details </th>
                                    <th colspan="2">Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($this->adviser)){
                                        foreach($this->adviser as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['name']); ?></td>
                                                <td><?php echo $mod['detail'];  ?></td>

                                                <td><?php echo $mod['phone_no']; ?></td>
                                                <td><a href="<?php echo URL; ?>admin/teacher/subject/<?php echo $mod['person_id']; ?>" class="btn btn-info btn-flat">Assign Subject</a></td>

                                                <td><a href="<?php echo URL; ?>admin/teacher/delete/<?php echo $mod['teacher_id']; ?>" class="btn btn-danger btn-flat">Remove</a></td>

                                            </tr>
                                        <?php }}  ?>


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Student No</th>
                                    <th>Student Name</th>
                                    <th>Details </th>
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
            <section class="content-header">
                <h2>
                    Add Results for: <?php echo($mod['subject_name']); echo(' '.$this->header); ?>
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
                            <h3 class="box-title">Search for Student</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="<?php echo(URL.'teacher/result/'.$this->action.'/'.$this->id); ?>" method="post" id="contact_form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="search_term">Enter Student Number (Name)*</label>
                                    <input type="text" class="form-control pull-right" id="search_term" name="search_term" onkeyup="Search(this.value)">
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->


                </div>
                <div class="col-md-9 col-sm-12 col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border" id="">
                            <h3 class="box-title">Results for <?php echo($mod['subject_name']); ?> Subject </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'admin/create_subject/'.$mod['subject_id']); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />


                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="subject_for">Select Session</label>

                                            <select class="form-control" name="subject_for" id="subject_for">
                                                <?php Date::sessionsInFuture();  ?>

                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <label for="subject_for">Select Term</label>
                                        <select class="form-control" name="entry_term" id="entry_term">
                                            <?php if (Session::exists('entry_term')){?>
                                                <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                                            <?php }?>
                                            <option value="1">First (1st)</option>
                                            <option value="2">Second (2nd)</option>
                                            <option value="3">Third (3rd)</option>
                                        </select>

                                    </div>
                                </div>

                                <div id="livesearch">

                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="subject_name">Enter Score</label>
                                            <input type="text" class="form-control" id="subject_score" name="subject_score">
                                        </div>

                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="subject_alias">Enter Grade</label>
                                            <input type="text" class="form-control" id="subject_grade" name="subject_grade" placeholder="A, B, C ..." >
                                        </div>
                                        <input type="hidden" class="form-control" id="subject_id" name="subject_id" value="<?php echo($mod['subject_id']); ?>">                                    </div>
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