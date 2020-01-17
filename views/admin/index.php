<?php
    include(View::NavBar());
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
                        <h3>1</h3>

                        <p>New Converts</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-bag"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>53<sup style="font-size: 20px">%</sup> </h3>

                        <p>First Timers</p>
                    </div>
                    <div class="icon">
                        <i class="ionicons ion-clipboard"></i>
                    </div>
                    <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>4</h3>

                        <p>SMSes sent</p>
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
                        <h3>5</h3>

                        <p>Contacts</p>
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
        <section class="content-header">
            <h2>
                This week
            </h2>

        </section>
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="ion ionicons ion-bowtie"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">New Converts</span>
                        <span class="info-box-number">2</span>
                    </div>
                    <!-- /.info-box-content -->
                    <a class="btn btn-sm bg-aqua btn-flat pull-right" href="javascript:void(0)">View</a>

                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ionicons ion-ios-personadd"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">First Timers</span>
                        <span class="info-box-number">7</span>
                    </div>
                    <!-- /.info-box-content -->
                    <a class="btn btn-sm bg-green btn-flat pull-right" href="javascript:void(0)">View</a>

                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ionicons ion-android-contacts"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Attendance</span>
                        <span class="info-box-number">76</span>
                    </div>
                    <!-- /.info-box-content -->
                    <a class="btn btn-sm bg-yellow btn-flat pull-right" href="javascript:void(0)">Process</a>

                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Home Cells Opened</span>
                        <span class="info-box-number">4</span>

                    </div><!-- /.info-box-content -->
                    <a class="btn btn-sm bg-red btn-flat pull-right" href="javascript:void(0)">Terminate</a>
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
      <section class="content-header">
          <h2>
              Quick Links
          </h2>

      </section>

      <div class="row">
      <!-- left column -->
      <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
              <div class="box-header with-border">
                  <h3 class="box-title">Academic Session</h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form role="form">
                  <div class="box-body">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Title</label>
                          <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Enter heading">
                      </div>
                      <div class="form-group">
                          <label>Post</label>
                          <textarea class="form-control" rows="3" placeholder="What's on your mind ..."></textarea>
                      </div>


                  </div>
                  <!-- /.box-body -->

                  <div class="box-footer">
                      <button type="submit" class="btn btn-primary">Save Draft</button>
                  </div>
              </form>
          </div>
          <!-- /.box -->


      </div>
      <!--/.col (left) -->
      <!-- right column -->
      <div class="col-md-6">
          <!-- Horizontal Form -->
          <div class="box box-info">
              <div class="box-header with-border">
                  <h3 class="box-title">Academic Session & Term </h3>
              </div>
              <!-- /.box-header -->
              <!-- form start -->
              <form class="form-horizontal" action="<?php echo(URL.'admin/session_term_start'); ?>" method="post" id="contact_form">
                  <div class="box-body">
                      <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                      <div class="form-group">
                          <label for="entry_session" class="col-sm-2 control-label">Session</label>

                          <div class="col-sm-10">
                              <select class="form-control" name="entry_session" id="entry_session" required="required">
                                  <?php if (Session::exists('entry_session')){?>
                                      <option value="<?php echo $flash = Session::flash('entry_session'); ?>" selected="selected"><?php echo $flash; ?></option>
                                  <?php }?>
                                  <?php Date::sessionsInFuture(); ?>
                              </select>
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="entry_term" class="col-sm-2 control-label">Term</label>

                          <div class="col-sm-10">
                              <select class="form-control" name="entry_term" id="entry_term" required="required">
                                  <?php if (Session::exists('entry_term')){?>
                                      <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                                  <?php }?>
                                  <option value="0">Select Term</option>
                                  <option value="1st">First (1st)</option>
                                  <option value="2nd">Second (2nd)</option>
                                  <option value="3rd">Third (3rd)</option>
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
      <!--/.col (right) -->
      </div>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>