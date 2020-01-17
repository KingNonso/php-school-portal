<!DOCTYPE html>
<html>
<head>
    <title><?php $title = isset($this->title)? $this->title: 'School Board'; echo $title; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link href="<?php echo URL; ?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <?php  //page applicable plugin
        if (isset($this->cssPlugin))
        {
            foreach ($this->cssPlugin as $plugin)
            {
                echo '<link  href="'.URL.'public/custom/plugins/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <!-- Theme style -->
    <link href="<?php echo URL; ?>public/custom/css/AdminLTE.min.css" rel="stylesheet" type="text/css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect.
  -->
    <link href="<?php echo URL; ?>public/custom/css/skins/skin-blue.min.css" rel="stylesheet" type="text/css">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="hold-transition register-page">

<div id="about" class="container-fluid">

    <div class="row" id="container">
        <br/>

        <div class="col-sm-10 col-sm-offset-1 register-box-body">
            <div class="col-sm-12 text-center">

                <h3 class="error-code text-center"> Anambra State Post Primary Schools Service Commission</h3>
                <h1><b> Boys' Secondary School, Oraifite</b></h1>
                <p>P.O.Box 90 Oraifite Ekwusigo L.G.A., Nnewi Zone, Anambra State</p>
                <p>Email address: info@agss.org.ng</p>

                <hr>
                <h3><b> Statement of Result</b></h3>
                <h4>First Term 2015/2016 Academic Session </h4>
                <hr>
            </div>
            <div class="col-sm-6 ">

                <p class="list-group-item-text">Name</p>
                <h4 class="list-group-item-heading">Chukwu Okoye Kinsley</h4>

                <p class="list-group-item-text">Student ID</p>
                <h4 class="list-group-item-heading">agss/01/890</h4>

                <p class="list-group-item-text">Class</p>
                <h4 class="list-group-item-heading">SS2 A</h4>

            </div>

            <div class="col-sm-6 text-right">
                <div class="imgholder"><img src="<?php echo(URL) ?>public/images/sch_logo.jpg" alt="" class="img-thumbnail" width="150" height="150" /></div>
            </div>
            <div class="col-sm-12 text-center">
                <br/>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>Report</b> <small> card</small> </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th rowspan="2" style="width: 10px">#</th>
                                <th rowspan="2" style="text-align: center">Subject</th>
                                <th colspan="2" style="text-align: center">1st Term</th>
                                <th colspan="2" style="text-align: center">2nd Term</th>
                                <th colspan="2" style="text-align: center">3rd Term</th>
                                <th rowspan="2">Total</th>
                                <th rowspan="2">Average</th>
                                <th rowspan="2">Position</th>
                                <th rowspan="2">Grade</th>
                                <th style="text-align: center">Highest </th>
                                <th style="text-align: center">Lowest </th>
                            </tr>
                            <tr>
                                <td>CA</td>
                                <td>Exam </td>
                                <td>CA</td>
                                <td>Exam </td>
                                <td>CA</td>
                                <td>Exam </td>
                                <td>Score </td>
                                <td>Score </td>
                            </tr>
                            <tr>
                                <td>2.</td>
                                <td>Mathematics </td>

                            </tr>
                            <tr>
                                <td>3.</td>
                                <td>Igbo Language </td>

                            </tr>
                            <tr>
                                <td>4.</td>
                                <td>Physics </td>
                                <td></td>
                            </tr>
                            <tfoot>
                            <tr>
                                <th colspan="8" class="text-right">Grand Total</th>
                                <th colspan="6" class="text-left">719</th>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-right">Total Average</th>
                                <th colspan="6" class="text-left">376</th>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-right">Overall Position</th>
                                <th colspan="6" class="text-left">4 / 37 Students</th>
                            </tr>
                            <tr>
                                <th colspan="8" class="text-right">Remark</th>
                                <th colspan="6" class="text-left">Promoted</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>


            <div class="col-sm-6 col-sm-offset-6">
                <p>Comment: </p>
                <br/>
                <hr>
                <p>Principal Sign</p>
            </div>


        </div>
    </div>


</div>
<div class="container">

    <!-- Modal -->
    <div class="modal fade" id="find_student_reg_no" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Retrieve Reg Number</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo(URL.'login/login'); ?>" method="post" onsubmit="return false;">

                        <div class="row">
                            <div class="col-sm-12 form-group">
                                <label for="find_session">Academic Session</label>
                                <select class="form-control" name="find_session" id="find_session" required="required" onchange="retrieve_reg_no('class',1)">

                                    <?php echo($this->sessions); ?>
                                </select>
                            </div>
                            <div class="col-sm-12 form-group">

                                <label for="find_class">Select Classroom </label>
                                <select class="form-control" name="find_class" id="find_class" onchange="retrieve_reg_no('class',1)">
                                    <?php echo($this->classes); ?>
                                </select>
                            </div>

                            <div class="col-sm-12 form-group">
                                <label for="find_name">Select Name </label>
                                <select class="form-control" name="find_name" id="find_name" onchange="retrieve_reg_no('name',1)">
                                    <option value="0">Loading</option>
                                </select>
                            </div>


                            <div class="col-sm-12 form-group" id="submit">
                                <h2 id="ur_reg_no" class="text-danger"></h2>
                                <input type="hidden" id="found_reg_no">
                                <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="insert_found()">Insert Reg Number</button>
                            </div>

                        </div>


                    </form>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>

</div>


<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
<!-- Latest compiled JavaScript -->
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo URL; ?>public/custom/js/app.min.js"></script>
<script src="<?php echo URL; ?>public/custom/js/demo.js"></script>

<?php
    //general applicable js
    if (isset($this->generalJS))
    {
        foreach ($this->generalJS as $general)
        {
            echo '<script type="text/javascript" src="'.URL.'public/custom/js/'.$general.'"></script>';
        }
    }
    if (isset($this->jsPlugin))
    {
        foreach ($this->jsPlugin as $jsPlugin)
        {
            echo '<script type="text/javascript" src="'.URL.'public/custom/plugins/'.$jsPlugin.'"></script>';
        }
    }
    //page specific js
    if (isset($this->js))
    {
        foreach ($this->js as $js)
        {
            echo '<script type="text/javascript" src="'.URL.'views/'.$js.'"></script>';
        }
    }

?>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
     Both of these plugins are recommended to enhance the
     user experience. Slimscroll is required when using the
     fixed layout. -->
</body>
</html>
