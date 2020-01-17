<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                The School Academic Calender
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
                                <h3 class="box-title">Showing all

                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <table id="example2" class="table table-bordered table-hover table-striped">
                                    <thead>
                                    <tr>
                                        <th>Term</th>
                                        <th>Starts</th>
                                        <th>Ends</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        foreach($this->academics[0] as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['term']); ?></td>
                                                <td><?php echo($mod['term_starts']); ?></td>
                                                <td><?php echo($mod['term_ends']); ?></td>


                                                <td>
                                                    <a href="<?php echo URL; ?>teacher/view/<?php echo $mod['term_id']; ?>" class="btn btn-primary btn-flat">Update </a>
                                                </td>


                                            </tr>
                                        <?php }  ?>


                                    </tbody>
                                    <tfoot>
                                    <tr>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Action</th>
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
                    Add New Academic Term to Calendar Session
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
                            <h3 class="box-title">THE Event Planner</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>A couple of things you need to note about  Calendar</p>
                            <ul>
                                <li><strong>The Session:</strong>
                                    A yearly arrangement. </li>
                                <li><strong>The Term:</strong>
                                     </li>
                                <li><strong>The Date </strong>
                                    Describe the Dates in full length. </li>
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
                            <h3 class="box-title"> Term Only </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" action="<?php echo(URL.'teacher/add_term_only'); ?>" method="post" id="contact_form">
                            <div class="box-body">
                                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                                <div class="form-group">
                                    <label for="entry_session" class="col-sm-2 control-label">Session</label>

                                    <div class="col-sm-10">
                                        <p class="form-control-static"><?php if (Session::exists('session_name')){ echo(Session::get('session_name')); }?></p>
                                        <input type="hidden" class="form-control" name="entry_session" id="entry_session" required="required" value="<?php if (Session::exists('session_id')){ echo(Session::get('session_id')); }?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="entry_term" class="col-sm-2 control-label">Term</label>

                                    <div class="col-sm-10">
                                        <select class="form-control" name="entry_term" id="entry_term" required="required">
                                            <?php if (Session::exists('entry_term')){?>
                                                <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                                            <?php }?>
                                            <?php
                                                foreach($this->academics[1] as $mod){
                                                    ?>
                                                    <option value="<?php echo($mod); ?>"><?php echo($mod); ?> </option>
                                                <?php }  ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="starts" class="col-sm-2 control-label">Starts</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control datepicker pull-right" id="starts" name="starts" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="ends" class="col-sm-2 control-label">Ends</label>

                                    <div class="col-sm-10">
                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control datepicker pull-right" id="ends" name="ends" required="required">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="details" class="col-sm-2 control-label">Details</label>

                                    <div class="col-sm-10">
                                        <textarea id="details" name="details" class="form-control" placeholder="Brief details..."></textarea>
                                    </div>
                                </div>
                                <div class="form-group"></div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <button type="reset" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-info pull-right" onclick="return confirm('This cannot be undone!. PROCEED?')">Start New Term in Session</button>
                            </div>
                            <!-- /.box-footer -->
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