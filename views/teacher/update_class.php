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
<?php
    $mod = $this->classes;
        ?>        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <section class="content-header">
                <h2>
                    Update class: <?php echo($mod['class_name']); ?>
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
                            Here is where you update the info
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
                            <h3 class="box-title">THE <?php echo($mod['class_name']); ?></h3>
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
                        <div class="box-header with-border">
                            <h3 class="box-title"> Update <?php echo($mod['class_name']); ?></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'teacher/create_class/'.$mod['class_id']); ?>" method="post">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="class_name">Class Name</label>
                                    <input type="text" class="form-control" id="class_name" name="class_name" placeholder="Enter  Short Name e.g. JS1, SS1 ..." value="<?php if (Session::exists('class_name')){ echo(Session::flash('class_name')); }else{ echo($mod["class_name"]);} ?>">
                                </div>

                                <div class="form-group">
                                    <label>Class Description</label>
                                    <textarea class="form-control" rows="2" placeholder="Enter Long Name here e.g. Junior Secondary School One ..." id="class_desc" name="class_desc">
                                        <?php if (Session::exists('class_desc')){ echo(Session::flash('class_desc')); }else{ echo($mod["class_desc"]);} ?>
                                    </textarea>
                                </div>

                                <div class="form-group">
                                    <label for="parent_class">Parent Class</label>
                                    <p class="help-block">E.g. JS1 is the Parent to JS1a, JS1b.</p>
                                    <select class="form-control" name="parent_class" id="parent_class">

                                        <option value="">Nil</option>

                                        <?php foreach ($this->class as $class){ if($class['parent_class'] == null){ ?>
                                            <option value="<?php echo $class['class_name']; ?>" <?php if ($mod['parent_class'] == $class['class_name'] ){echo "selected=\"selected\"";} ?> ><?php echo $class['class_name'] ; ?></option>


                                        <?php }}  ?>




                                    </select>
                                </div>


                                <div class="form-group">
                                    <label>Requirements to be in this class</label>
                                    <textarea class="form-control textarea" rows="3" placeholder="Enter requirement here ..." id="requirement" name="requirement">
                                        <?php if (Session::exists('requirement')){ echo(Session::flash('requirement')); }else{ echo($mod["requirement"]);} ?>
                                    </textarea>
                                </div>


                            </div>

                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="<?php echo URL; ?>teacher/classes" class="btn btn-default pull-right">Cancel</a>
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