<?php
    include(View::teacher_nav());
    $max = 2000 * 1024; //500kb

?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
          <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


      </ol>


    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Your Page Content Here -->
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3><?php if(isset($this->student)){ echo($this->student);} ?></h3>

                        <p>Students</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bowtie"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3><?php if(isset($this->subject)){ echo($this->subject);} ?></h3>

                        <p>Subjects</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3><?php if(isset($this->class)){ echo($this->class);} ?></h3>

                        <p>Classes</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-add"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3><?php if(isset($this->result)){ echo($this->result);} ?></h3>

                        <p>Results</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-ios-location"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>
        <!-- /.row -->
        <!-- Info boxes -->
        <!-- /.row -->
      <section class="content-header">
          <h2>
              Quick Links
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
                      First, You must set the Academic Session and Term you wish to enter records for
                  </div>
              <?php } ?>
          </div>

      </section>

      <div class="row">

      <!-- right column -->
      <div class="col-sm-6 col-sm-offset-3">
          <!-- Horizontal Form -->
          <div class="box box-info">
              <div class="box-header with-border text-center">
                  <h3 class="box-title">Set Academic Session & Term to Work With </h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo(URL.'teacher/set_active'); ?>" method="post" id="contact_form">
                  <div class="box-body">

                      <div class="form-group">
                          <label for="entry_session" class="col-sm-2 control-label">Session</label>

                          <div class="col-sm-10">
                              <select class="form-control" name="entry_session" id="entry_session" onchange="retrieve_reg_no('term',1)" required="required">
                                  <?php echo($this->sessions); ?>


                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="entry_term" class="col-sm-2 control-label">Term</label>

                          <div class="col-sm-10">
                              <select class="form-control" name="entry_term" id="entry_term">
                                  <?php if (Session::exists('entry_term')){?>
                                      <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                                  <?php }?>
                              </select>
                          </div>
                      </div>

                      <div class="form-group"></div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                      <button type="reset" class="btn btn-default">Cancel</button>
                      <button type="submit" class="btn btn-danger pull-right">Set Active</button>
                  </div>
                  <!-- /.box-footer -->
              </form>
          </div>
          <!-- /.box -->
      </div>
      <!--/.col (right) -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>
