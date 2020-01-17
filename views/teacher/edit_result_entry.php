<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                 Students Results Office
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
                    Update/ Edit Details: <?php
                        if(isset($this->students)){
                            $mod = $this->students;
                            echo(($mod['student_name']).' '.($mod['student_reg_no']));
                        }
                    ?>
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
                            Here is where you enter/edit info
                        </div>
                    <?php } ?>

                </div>


            </section>

            <!-- Your Page Content Here -->

            <div class="row">
                <!-- left column -->
                <div class="col-md-3 col-sm-6 col-xs-12">

                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">THE Student's Result </h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <div class="box-body">
                            <p>A couple of things you need to note about updating or editing Result Record </p>
<p>Be truthful</p>


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
                        <form action="<?php echo(URL.'teacher/result/edit/'.$this->folder['id']); ?>" method="post" id="contact_form" enctype="multipart/form-data">
                            <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                            <div class="box-header with-border">
                                <h3 class="box-title">Update/Edit Result</h3>
                            </div>

                            <div class="box-body">
                                <div class="row">
                                    <input type="hidden" class="form-control" name="student_id" id="student_id" value="<?php if (Session::exists('student_id')){ echo(Session::get('student_id')); } ?>">
                                    <?php if (isset($this->records)){
                                        foreach($this->records as $tab){
                                            ?>
                                            <div class="col-sm-3">
                                                <div class="form-group">
                                                    <label for="subject_id_<?php echo($tab['record_id']); ?>"><?php echo($tab['subject_name']); ?></label>
                                                    <input type="text" class="form-control" name="subject_id_<?php echo($tab['record_id']); ?>" id="subject_id_<?php echo($tab['record_id']); ?>" value="<?php if (Session::exists('subject_id_'.$tab['record_id'])){ echo(Session::flash('subject_id_'.$tab['record_id'])); }else{ echo($tab['subject_score']);} ?>">
                                                </div>

                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                    <div class="col-sm-12">
                                        <hr/>
                                        <div class="row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="total">Total</label>
                                                    <input type="text" class="form-control" name="total" id="total" value="<?php if (Session::exists('total')){ echo(Session::flash('total')); }else{ echo($this->folder['total']);} ?>">
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="average">Average</label>
                                                    <input type="text" class="form-control" name="average" id="average" value="<?php if (Session::exists('average')){ echo(Session::flash('average')); }else{ echo($this->folder['average']);} ?>">
                                                </div>

                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <label for="position">Position</label>
                                                    <input type="text" class="form-control" name="position" id="position" value="<?php if (Session::exists('position')){ echo(Session::flash('position')); }else{ echo($this->folder['position']);} ?>">
                                                </div>

                                            </div>


                                        </div>
                                    </div>

                                </div>






                            </div>
                            <!-- /.box-body -->

                            <div class="box-footer">
                                <button type="submit" class="btn btn-danger pull-right">Submit Update</button>
                                <!--


                                 -->

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