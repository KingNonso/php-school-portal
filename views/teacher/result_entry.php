<?php
    include(View::teacher_nav());
?>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                 Record Office
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
                Class: <?php echo Session::get('academic_class_name'); ?>; Subject: <?php echo Session::get('academic_subject_name'); ?>; Term: <?php echo Session::get('academic_term_name'); ?>; Session: <?php echo Session::get('academic_session_name'); ?>;
            </h2>
            <div class="box-body">
                <?php if(Session::exists('home')){ ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        <p id="statusReport"><?php echo Session::flash('home');?></p>
                     </div>
                    <?php  ?>
                <?php } elseif(Session::exists('error')){ ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <p id="statusReport"><?php echo Session::flash('error');  ?></p>
                    </div>
                <?php }
                else{?>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        <p id="statusReport">Here is where you enter new info</p>
                    </div>
                <?php } ?>

            </div>


        </section>

        <section class="content">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title" >Showing All: Total <span class="badge" id="totalCount">
                                    <?php
                                        if(isset($this->total)){
                                            echo(($this->total));
                                        }
                                    ?>
                                    </span>
                                </h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <div class="table-responsive">

                                    <table id="example2" class="table table-bordered table-hover table-striped">
                                        <thead>
                                        <tr>
                                            <th class="rotate">Surname</th>
                                            <th>Other Names</th>
                                            <th>CA</th>
                                            <th>EXAM</th>
                                            <th>TOTAL</th>
                                            <th>GP</th>
                                            <th>Remark</th>
                                            <th>Pos</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if(isset($this->students)){
                                                echo($this->students );
                                            }  ?>

                                        <!--
                                                                  <tr>
                                <td id="record_1_surname" ondblclick="editable(1,'surname','text')">Thagbo </td>
                                <td id="record_1_othername" ondblclick="editable(1,'othername','text')"> Mbeki Emmanuel </td>
                                <td id="record_1_ca" ondblclick="editable(1,'ca','number')">33 </td>
                                <td id="record_1_exam" ondblclick="editable(1,'exam','number')">66 </td>
                                <td id="record_1_total" ondblclick="editable(1,'total','number')">99 </td>
                                <td id="record_1_position" class="sortPost">2nd</td>
                                <td><a href="javascript:void(0);" class="btn btn-danger" onclick="return confirm('This would delete all the record and the Name of the Student associated with this record')">Delete</a> </td>
                            </tr>

                                        -->
                                        <tr id="newAdder">
                                            <td><input type="text" class="form-control" name="new_record_surname" id="new_record_surname" placeholder="Surname"></td>
                                            <td><input type="text" class="form-control" name="new_record_othername" id="new_record_othername" placeholder="First Name - Middle Name"></td>
                                            <td><input type="text" class="form-control" name="new_record_ca" id="new_record_ca" placeholder="CA" onkeyup="autoTotal()"></td>
                                            <td><input type="text" class="form-control" name="new_record_exam" id="new_record_exam" placeholder="EXAM" onkeyup="autoTotal()"></td>
                                            <td><input type="text" class="form-control" name="new_record_total" id="new_record_total" placeholder="Total"></td>
                                            <td colspan="4"><a href="javascript:void(0);" class="btn btn-success" onclick="createNewRecord()">Create New Record</a> </td>
                                        </tr>
                                        <tr id="rowAppendage"></tr>

                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th class="rotate">Surname</th>
                                            <th>Other Names</th>
                                            <th>CA</th>
                                            <th>EXAM</th>
                                            <th>TOTAL</th>
                                            <th>GP</th>
                                            <th>Remark</th>
                                            <th>Pos</th>
                                            <th>Actions</th>
                                        </tr>
                                        </tfoot>
                                    </table>

                                </div>
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

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


<?php
    include(View::rightNav());
?>