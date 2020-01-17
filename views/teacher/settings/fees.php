<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            School Fees
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
                                    <th>Amount</th>
                                    <th>Session - Term</th>
                                    <th>For</th>
                                    <th>Note</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($this->fees)){
                                        foreach($this->fees as $mod){
                                            ?>
                                            <tr>
                                                <td><?php echo($mod['amount']);  ?></td>
                                                <td><?php echo $mod['session'];  ?></td>
                                                <td><?php echo $mod['class'];  ?></td>
                                                <td><?php echo $mod['note'];  ?></td>

                                                <td><a href="<?php echo URL; ?>teacher/delete_setting/fees/<?php echo $mod['id']; ?>" class="btn btn-danger btn-flat">Delete</a></td>



                                            </tr>
                                        <?php }} ?>


                                </tbody>
                                <tfoot>
                                <tr>
                                    <th>Amount</th>
                                    <th>Session - Term</th>
                                    <th>For</th>
                                    <th>Note</th>
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
                    <h3 class="box-title">Create a New Fees</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form action="<?php echo(URL.'teacher/create_subject'); ?>" method="post" id="contact_form" onsubmit="return false">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-blackboard"></i></span>
                                <input class="form-control" id="amount" name="amount" placeholder="School Fees Amount" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="entry_session">Select Academic Session</label>

                            <select class="form-control" name="entry_session" id="entry_session" onchange="startRecord('term',1)" required="required">
                                <?php echo($this->sessions); ?>


                            </select>
                        </div>
                        <div class="form-group">
                            <label for="entry_term">Select Academic Term</label>
                            <select class="form-control" name="entry_term" id="entry_term">
                                <?php if (Session::exists('entry_term')){?>
                                    <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="note">Note</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="glyphicon glyphicon-pencil"></i></span>
                                <input class="form-control" id="note" name="note" placeholder="Something note worthy about this " type="text">
                            </div>
                        </div>




                        <div class="list-group createClassStep">
                            <a href="javascript:void(0);" class="list-group-item" onclick="schoolFeesCreator('yes')">
                                <h4 class="list-group-item-heading">For All  Students</h4>
                                <p class="list-group-item-text">Will be created for all classes</p>
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
                                            <?php }  ?>                              </select>
                                </div>

                                <p class="help-block">Enter class one by one, Use comma or space to separate classes.</p>

                            </div>
                        </div>


                    </div>
                    <!-- /.box-body -->
                    <div class="alert alert-info alert-dismissible" id="creatingClass">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-gears"></i> PROCESSING!</h4>
                        Please wait while the Resumption for the respective class is being set. Thanks
                    </div>


                    <div class="box-footer createClassStep">
                        <button type="submit" class="btn btn-primary" onclick="schoolFeesCreator('no')">Submit</button>
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