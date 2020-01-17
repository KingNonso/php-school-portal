<?php
    $user = new User();
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-12 text-center">

            <h1><b> THE ADMISSIONS BOARD </b> <small>All Applications for Admission into this Institution is done online</small></h1>
        </div>

        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Instructions</h2>
                    <ol>
                        <li>It would take you about 5mins to fill out this form correctly</li>
                        <li>If the form is not properly filled, it will not be processed by the server</li>
                        <li>All fields marked * are required</li>
                        <li>You would have to agree to the terms and conditions to proceed below</li>
                        <li>Please ensure you proceed to the last step, to prevent any loss of progress made</li>
                    </ol>




                </div>
                <div class="col-sm-6">
                    <h2>Steps</h2>

                    <ol>
                        <li>If you are a student, making this application by yourself, then know that the fields marked 'Name', 'Email', 'Phone' etc are for your own details, while those marked "Parent's Name" etc are for your parents</li>
                        <li>If you are a Parent or Guide, making this application by yourself, then know that the fields marked 'Name', 'Email', 'Phone' etc are for your child or ward's details, while those marked "Parent's Name" etc are for you</li>
                    </ol>


                </div>
            </div>
            <hr/>
            <div class="row">
                <div class="col-sm-12">
                    <h2>START ADMISSION APPLICATION <small> now</small> </h2>
                    <a href="<?php echo(URL) ?>admission/step/one" class="btn btn-lg btn-primary">Click Here to Begin Admission Process</a>


                </div>

            </div>

        </div>
        <div class="col-sm-5">

            <h2>REQUIREMENTS <small>From The School Mgt</small></h2>
            <div class="list-group">
                <a href="<?php echo(URL) ?>admission/step/one" class="list-group-item active">
                    <h4 class="list-group-item-heading">START ADMISSION APPLICATION</h4>
                    <p class="list-group-item-text">Click Here to Begin Admission Process</p>
                </a>
                <a href="<?php echo(URL) ?>admission/status" class="list-group-item">
                    <h4 class="list-group-item-heading">CHECK ADMISSION STATUS</h4>
                    <p class="list-group-item-text">Click Here to Check Your Admission Status</p>
                </a>
                <a href="#" class="list-group-item">
                    <h4 class="list-group-item-heading">VIEW INTERVIEW DATE</h4>
                    <p class="list-group-item-text">Click Here to See the Interview Schedule</p>
                </a>
            </div>

        </div>
    </div>
</div>



