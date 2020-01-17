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
    <style type="text/css">
        @media print {

            @page {
                size: A4;
            }

            html, body {
                width: 1024px;
            }

            body {
                margin: 0 auto;
                line-height: 1em;
                word-spacing:1px;
                letter-spacing:0.2px;
                font: 14px "Times New Roman", Times, serif;
                background:white;
                color:black;
                width: 100%;
                float: none;
            }

            /* avoid page-breaks inside a listingContainer*/
            .listingContainer{
                page-break-inside: avoid;
            }

            h1 {
                font: 28px "Times New Roman", Times, serif;
            }

            h2 {
                font: 24px "Times New Roman", Times, serif;
            }

            h3 {
                font: 20px "Times New Roman", Times, serif;
            }

            /* Improve colour contrast of links */
            a:link, a:visited {
                color: #781351
            }

            /* URL */
            a:link, a:visited {
                background: transparent;
                color:#333;
                text-decoration:none;
            }

            a[href]:after {
                content: "" !important;
            }

            a[href^="http://"] {
                color:#000;
            }

            #header {
                height:75px;
                font-size: 24pt;
                color:black
            }

            #img_holder{
                float: right;
            }
            #name_holder{
                float: left;
            }
            #principal_sign{
                width: 50%;
                float: right;
            }
            #moral_score{
                width: 50%;
                float: left;
            }
            .progress{
                background-color: #F5F5F5 !important;
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#F5F5F5', endColorstr='#F5F5F5')" !important;
            }
            .progress-bar-info{
                display: block !important;
                background-color: #5bc0de !important;
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#5BC0DE', endColorstr='#5BC0DE')" !important;
            }
            .progress-bar-success{
                display: block !important;
                background-color: #5cb85c !important;
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#5BC0DE', endColorstr='#5BC0DE')" !important;
            }
            .progress-bar-warning{
                display: block !important;
                background-color: #f0ad4e !important;
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#5BC0DE', endColorstr='#5BC0DE')" !important;
            }
            .progress-bar-primary{
                display: block !important;
                background-color: #337ab7 !important;
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#5BC0DE', endColorstr='#5BC0DE')" !important;
            }
            .progress-bar-danger{
                display: block !important;
                background-color: #d9534f !important;
                -ms-filter: "progid:DXImageTransform.Microsoft.gradient(GradientType=0,startColorstr='#5BC0DE', endColorstr='#5BC0DE')" !important;
            }

            .progress, .progress > .progress-bar {
                display: block !important;
                -webkit-print-color-adjust: exact !important;

                box-shadow: inset 0 0 !important;
                -webkit-box-shadow: inset 0 0 !important;
            }
        }
    </style>
</head>
<body class="hold-transition register-page">

<div id="about" class="container">

    <div class="row" id="container">
        <br/>

        <div class="col-sm-10 col-sm-offset-1 register-box-body">
            <div class="col-sm-12 text-center">

                <h3 class="error-code text-center"> Anambra State Post Primary Schools Service Commission</h3>
                <h1><b> Anglican Girls Secondary School, Nnewi</b></h1>
                <!--   <p>P.O.Box 90 Oraifite Ekwusigo L.G.A., Nnewi Zone, Anambra State</p> -->
                <p>Email address: info@agss.org.ng</p>

                <hr>
                <h3><b> Statement of Result</b></h3>
                <h4>Annual Cumulative Result for <?php echo Session::get('result_session'); ?> Academic Session </h4>
                <hr>
            </div>
            <div class="row">
                <div class="col-sm-6 " id="name_holder">

                    <p class="list-group-item-text">Name</p>
                    <h4 class="list-group-item-heading"><?php echo($this->name['student_name']); ?></h4>

                    <p class="list-group-item-text">Student ID</p>
                    <h4 class="list-group-item-heading"> <?php echo($this->name['student_reg_no']); ?></h4>

                    <p class="list-group-item-text">Class</p>
                    <h4 class="list-group-item-heading"><?php echo Session::flash('result_class'); ?></h4>

                </div>
                <div class="col-sm-6 text-right" id="img_holder">
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/girls_sschool.fw.png" alt="" class="img-thumbnail" width="150" height="150" /></div>
                </div>

            </div>

            <div class="col-sm-12 text-center">
                <br/>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title"><b>Report Card</b> <small>Cognitive Assessment </small> </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body table-responsive no-padding text-left">
                        <table class="table table-striped table-bordered">


                            <?php
                                if(isset($this->result)){
                                        ?>
                                    <?php echo $this->result; ?>
                                    <?php }  ?>



                        </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->


            </div>


            <div class="col-sm-6" id="moral_score">
                <h4>Keys to Grading <small>Assessment</small></h4>
                <ul>
                    <li>75 - 100: A (Distinction)</li>
                    <li>60 - 74: C (Credit)</li>
                    <li>45 - 59: P (Pass)</li>
                    <li>0 - 45: F (Fail)</li>
                </ul>
                <hr/>
                <h4>Next Term Begins <small> Resumption</small></h4>
                <ul>
                    <?php
                        if(isset($this->resumption)){
                            foreach($this->resumption as $mod){ ?>
                                <li><?php echo $mod['class'];  ?>: <b><?php echo($mod['date']);  ?></b></li>
                            <?php }} ?>
                </ul>






            </div>
            <div class="col-sm-6" id="principal_sign">

                <p>Summary:
                    <br/>
                    <b><?php echo nl2br(Session::get('result_summary_outline')); ?></b>
                </p>
                <hr>
                <h4>Next Term Fees <small> Payment</small></h4>
                <ul>
                    <?php
                        if(isset($this->school_fees)){
                            foreach($this->school_fees as $mod){ ?>
                                <li><?php echo $mod['class'];  ?>: <b><?php echo($mod['amount']);  ?></b></li>
                            <?php }} ?>
                </ul>
                <hr>
                <h4><b>Principal.</b> <small> (for management)</small></h4>
                <!--- <div class="imgholder"><img src="<?php echo(URL) ?>public/images/agss-principal-sign.png" alt="" width="100" height="40" /></div>  -->
            </div>


        </div>
    </div>


</div>

<div class="col-sm-12 center-block text-center">
    <div class="pull-left">
        <button type="button" onclick="window.print();" class="btn btn-default btn-flat"> Print Result </button>


    </div>
    <div class="pull-right">
        <a href="<?php echo URL; ?>links/logout" class="btn btn-default btn-flat">Log out</a>
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
</body>
</html>





