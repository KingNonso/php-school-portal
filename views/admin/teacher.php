<?php
    include(View::NavBar());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                The School teachers
                <small>Administrator's Control panel</small>
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
                                        <th>Name</th>
                                        <th>Details</th>
                                        <th>Phone </th>
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
                                        <th>Name</th>
                                        <th>Details</th>
                                        <th>Phone </th>
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
                    Add New teacher to a subject
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
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Search for Staff</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form role="form" action="<?php echo(URL.'admin/teacher'); ?>" method="post" id="contact_form">
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="staff_search">Enter Staff Name*</label>
                                    <input type="text" class="form-control pull-right" id="staff_search" name="staff_search">
                                </div>


                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                        </form>
                    </div>

                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">THE teacher Planner</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>A couple of things you need to note about Adding New Events to Calendar</p>
                            <ul>
                                <li><strong>The Title:</strong>
                                    This must be a memorable, catchy phrase. </li>
                                <li><strong>The Description:</strong>
                                    Describe the event in full length. </li>
                                <li><strong>The Date & Time</strong>
                                    . </li>
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
                        <form action="<?php echo(URL.'admin/add_teacher'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                            <div class="box-header with-border">
                                <h3 class="box-title">
                                <?php
                                    if(isset($this->person)){
                                        echo('Add '.$this->person);
                                    }else{ ?>
                                        Add New teacher
                                    <?php }
                                ?></h3>
                                <p>
                                    <?php
                                        if(isset($this->detail)){
                                            echo("<br/>Teacher Details: <br/>".$this->detail);
                                        } ?>
                                </p>

                            </div>

                            <div class="box-body">
                                <input type="hidden" name="teacher" id="teacher" value="<?php if(isset($this->person_id)){ echo($this->person_id); } ?>">
                                <div class="form-group">
                                    <label for="show_academic">Add Teacher to </label>
                                    <select class="form-control" name="entry_class" id="entry_class">


                                        <?php foreach ($this->subject as $class){  ?>
                                            <option value="<?php echo $class['subject_id']; ?>" <?php if (Session::flash('entry_class') == $class['subject_id'] ){echo "selected=\"selected\"";} ?> ><?php echo $class['subject_name'].' for '.$class['subject_for'] ; ?></option>


                                        <?php } ?>

                                    </select>



                                </div>
                                <div class="form-group">
                                    <label for="title">Effective From</label>

                                    <select class="form-control" name="show_academic" id="show_academic">

                                        <?php foreach ($this->academics as $class){ ?>
                                            <option value="<?php echo $class['session_id']; ?>" <?php if (Session::flash('show_academic') == $class['session_id'] ){echo "selected=\"selected\"";} ?> ><?php echo $class['session_name'].' '.$class['term'] ; ?> term</option>
                                        <?php }  ?>
                                    </select>

                                </div>

                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea id="description" name="description" class="form-control" placeholder="Brief Description...">
                                        <?php if (Session::exists('description')){ echo(Session::flash('description')); } ?>

                                    </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="datepicker">Effective Date</label>

                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker" name="datepicker">
                                    </div>
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