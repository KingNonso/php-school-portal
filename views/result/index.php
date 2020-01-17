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
        <div class="col-sm-12 text-center">

            <h1><b>School Portal</b> </h1>
            <?php
                if($this->sch->logo ){ ?>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/<?php echo($this->sch->logo)  ?>" alt="" class="img-thumbnail" /></div>
                <?php  } ?>
        </div>

        <div class="col-sm-6 col-sm-offset-3 register-box-body">
            <h3 class="error-code text-center"><span class="glyphicon glyphicon-list-alt"></span> Online Result Checker</h3>
            <div class="box-body">
                <?php if (Session::exists('home')) { ?>
                    <div class="alert alert-success alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-check"></i> Alert!</h4>
                        <?php echo Session::flash('home'); ?>                         </div>
                    <?php ?>
                <?php } elseif (Session::exists('error')) { ?>
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                        <?php echo Session::flash('error');  //echo  //$this->error;?>
                    </div>
                <?php } else {
                    ?>
                    <div class="alert alert-info alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        <h4><i class="icon fa fa-info"></i> Alert!</h4>
                        <p id="status"> Enter your credentials to view result </p>

                    </div>
                <?php } ?>

            </div> 
            <form action="<?php echo(URL.'result/check'); ?>" method="post">
                <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                <input type="hidden" name="school_id" id="school_id" value="<?php echo ($this->sch->school_id); ?>" />
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <label for="student_id">Student ID</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i> </span>
                            <input type="text" id="student_id" name="student_id" class="form-control" placeholder="Enter Student Registration ID" required>
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#find_student_reg_no" onclick="return false">Find Reg Number</button>
                            </span>
                        </div>

                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="entry_session">Academic Session*</label>
                        <select class="form-control" name="entry_session" id="entry_session" onchange="retrieve_reg_no('term',1)" required="required">
                            <?php if (Session::exists('entry_session')){?>
                                <option value="<?php echo $flash = Session::flash('entry_session'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                            <?php echo($this->sessions); ?>
                        </select>
                    </div>
                    <div class="col-sm-12 form-group">
                        <label for="entry_term">Academic Term*</label>
                        <select class="form-control" name="entry_term" id="entry_term">
                            <?php if (Session::exists('entry_term')){?>
                                <option value="<?php echo $flash = Session::flash('entry_term'); ?>" selected="selected"><?php echo $flash; ?></option>
                            <?php }?>
                        </select>
                    </div>

                    <div class="col-sm-12 form-group">
                        <label for="student_pin">Access PIN</label>
                        <div class="input-group">
                            <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i> </span>
                            <input type="password" id="student_pin"  name="student_pin"  class="form-control" placeholder="Enter PIN: " required>
                        </div>

                    </div>

                    <div class="col-sm-12 form-group" id="submit">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Check Result Now</button>
                    </div>
                    <a href="<?php echo(URL); ?>login/recovery" class="btn btn-link">I Have a Pin Error</a> &nbsp;&nbsp;
                    <a href="<?php echo(URL); ?>login/recovery" class="btn btn-default">Purchase PIN</a>
                </div>


            </form>

        </div>
        <div class="col-sm-3">
            <!--
              <h2>Other Options <small>From The Webmaster</small></h2>
            <ul class="list-group">
                <li class="list-group-item"><a href="<?php echo(URL); ?>links/step/parent-web" class="text-center">Register as Parent</a></li>
                <li class="list-group-item"><a href="<?php echo(URL); ?>links/step/teacher" class="text-center">Register as Staff</a></li>

            </ul>

            -->

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
