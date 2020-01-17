<?php
    include(View::teacher_nav());
    $max = 2000 * 1024; //500kb

?>
  <!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Preview Record
            <small>Teacher's panel</small>
        </h1>
        <ol class="breadcrumb">
            <p style="color:#da620b"> <?php echo Session::breadcrumbs(); ?>  - You are here</p>


        </ol>
    </section>

    <div class="pad margin no-print">
        <div class="callout callout-info" style="margin-bottom: 0!important;">
            <h4><i class="fa fa-info"></i> Note:</h4>
            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
        </div>
    </div>

    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> <?php echo Session::get('school_name'); ?>
                    <small class="pull-right">Date: <?php echo(date('d/m/Y')); ?></small>
                </h2>
            </div>
            <!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <b>Session:</b> <?php echo Session::get('academic_session_name'); ?><br>
                <br>
            </div>
            <div class="col-sm-4 invoice-col">
                <b>Term:</b> <?php echo Session::get('academic_term_name'); ?><br>
            </div>
            <div class="col-sm-4 invoice-col">
                <b>Class:</b> <?php echo Session::get('academic_class_name'); ?><br>
            </div>
        </div>
        <!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive ">
                <table class="table table-striped table-bordered">

                    <?php
                        if(isset($this->students)){
                            ?>
                            <?php echo $this->students;  ?>

                        <?php }  ?>



                </table>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="lead"> Instruction Methods:</p>

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Here is how to effectively use this datasheet
                </p>
                <p>
                    Form Teacher Name/ Phone No:
                </p>
                <hr/>

                <p>
                    Signature/ Date:
                </p>
                <hr/>

            </div>
            <!-- /.col -->
            <div class="col-xs-6">
                <p class="lead">Summary</p>

                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Broadsheet:</th>
                            <td><?php echo Session::get('total_subjects'); ?> Subjects</td>
                        </tr>
                        <tr>
                            <th style="width:50%">Total:</th>
                            <td><?php echo Session::get('total_students'); ?> Students</td>
                        </tr>
                        <tr>
                            <th>Pass:</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Fail:</th>
                            <td> </td>
                        </tr>
                        <tr>
                            <th>Error:</th>
                            <td> </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->

        <!-- this row will not appear when printing -->
        <div class="row no-print">
            <div class="col-xs-12">
                <a href="<?php echo(URL.'teacher/printer/'.$this->url); ?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>

                <a href="<?php echo(URL.'teacher/excel_doc/'.$this->url); ?>" target="_blank" class="btn btn-success pull-right"><i class="fa fa-file-excel-o"></i> Generate Excel File</a>

                <a href="<?php echo(URL.'teacher/generate_pdf/'.$this->url); ?>" target="_blank" class="btn btn-primary pull-right" style="margin-right: 5px;"><i class="fa fa-download"></i> Generate PDF </a>

            </div>
        </div>
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
</div>
