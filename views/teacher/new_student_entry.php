<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                The Academic Portfolio
                <small>Teacher's panel</small>
            </h1>
            <ol class="breadcrumb">
                <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


            </ol>


        </section>

        <section class="content-header">
            <h2>
                Create or View Student/ Class Profile Entry
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
                <!-- left column -->
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border" id="">
                            <h2 class="box-title text-center">New Portfolio Entry </h2>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form action="<?php echo(URL.'teacher/entry/student'); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />


                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="select_session">Select Academic Calendar</label>

                                            <select class="form-control" name="select_session" id="select_session">

                                                <?php foreach ($this->academics as $class){ ?>
                                                    <option value="<?php echo $class['session_id']; ?>" <?php if (Session::flash('select_session') == $class['session_id'] ){echo "selected=\"selected\"";} ?> ><?php echo $class['session_name'].' '.$class['term'] ; ?> term</option>
                                                <?php }  ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="select_class">Select Class</label>

                                            <select class="form-control" name="select_class" id="select_class">

                                                <?php foreach ($this->class as $class){ ?>
                                                    <option value="<?php echo $class['class_id']; ?>" ><?php echo $class['class_name'] ; ?></option>


                                                <?php }  ?>




                                            </select>
                                            <p class="help-block">Note: JS1 is the Parent Class to JS1a, JS1b.</p>

                                        </div>

                                    </div>
                                </div>

                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer pull-right">
                                <button type="submit" class="btn btn-primary">START</button>
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