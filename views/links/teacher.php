<?php
    $max = 500 * 1024; //50kb
?>

<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
<div class="row" id="container">
<div class="col-sm-12 text-center">

    <h1><b> THE STAFF BOARD </b> <small>Application in Progress</small></h1>
</div>

<div class="col-sm-7">
<div>
<form id="form1" name="form1" method="post" action="<?php echo URL; ?>links/staff_personal"  enctype="multipart/form-data">
<input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
<br>
<div class="col-sm-12">
    <h1>Personal Information</h1>

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
            Please complete the form below.
        </div>
    <?php } ?>

</div>

<div class="form-group">
    <label class="control-label" for="surname">Surname*</label>
    <input class="form-control" style="width:95%" required="required" type="text" name="surname" id="surname"  value="<?php if (Session::exists('surname')){ echo(Session::flash('surname')); } ?>" >
</div>
<div class="form-group">
    <label class="control-label" for="firstname">First name*</label>
    <input class="form-control" style="width:95%" required="required" type="text" name="firstname" id="firstname"  value="<?php if (Session::exists('firstname')){ echo(Session::flash('firstname')); } ?>"  >
</div>
<div class="form-group">
    <label class="control-label" for="othernames">Other name(s)</label>
    <input class="form-control" style="width:95%" type="text" name="othernames" id="othernames"  value="<?php if (Session::exists('othernames')){ echo(Session::flash('othernames')); } ?>"  >
</div>
<div class="row">
    <div class="col-sm-3">
        <div  class="form-group">
            <label for="sex">Sex*</label>
            <br />
            <select class="form-control" name="sex" id="sex" required="required">
                <?php if (Session::exists('sex')){?>
                    <option value="<?php echo $flash = Session::flash('sex'); ?>" selected="selected"><?php echo $flash; ?></option>
                <?php }?>
                <option value="0">Select</option>
                <?php Person::sex(); ?>
            </select>
        </div>
    </div>
    <div class="form-group">

        <label for="day">Date of Birth*</label>
        <br />
        <div class="col-sm-3">
            <select class="form-control" name="day" id="day" required="required">
                <?php if (Session::exists('day')){?>
                    <option value="<?php echo $flash= (Session::flash('day')); ?>" selected="selected"><?php echo ($flash); ?></option>
                <?php } ?>
                <option value="0">Day</option>
                <?php Date::daygen(); ?>
            </select>
        </div>
        <div class="col-sm-3 ">
            <select class="form-control" name="month" id="month" required="required">
                <?php if (Session::exists('month')){?>
                    <option value="<?php echo $flash = Session::flash('month'); ?>" selected="selected"><?php echo $flash; ?></option>
                <?php }?>
                <option value="0">Month</option>
                <?php Date::monthgen(); ?>
            </select>
        </div>
        <div class="col-sm-3 ">
            <select class="form-control" name="year" id="year" required="required">
                <?php if (Session::exists('year')){?>
                    <option value="<?php echo $flash = Session::flash('year'); ?>" selected="selected"><?php echo $flash; ?></option>
                <?php }?>
                <option value="0">Year</option>
                <?php Date::yeargen(); ?>

            </select>
        </div>

    </div>
</div>

<div class="row">
    <div class="col-sm-6">
        <label for="marital_status">Marital Status*</label>
        <select class="form-control" name="marital_status" id="marital_status" style="width: 95%" required="required">
            <?php if (Session::exists('marital_status')){?>
                <option value="<?php echo $flash= Session::flash('marital_status'); ?>" selected="selected"><?php echo $flash; ?></option>
            <?php }?>
            <?php Person::Marital_status(); ?>
        </select>
    </div>
    <div class="col-sm-6">
        <label for="state_of_birth">State of Birth</label>
        <select class="form-control" name="state_of_birth" id="state_of_birth" style="width: 95%">
            <?php if (Session::exists('state_of_birth')){?>
                <option value="<?php echo $flash= Session::flash('state_of_birth'); ?>" selected="selected"><?php echo $flash; ?></option>
            <?php }?>
            <?php person::naija_state_gen(); ?>
        </select>
    </div>
</div>
<br/>
<div class="form-group">
    <label class="control-label" for="place_of_birth">Place of Birth</label>
    <input class="form-control" style="width:95%" type="text" name="place_of_birth" id="place_of_birth" value="<?php if (Session::exists('place_of_birth')){ echo(Session::flash('place_of_birth')); } ?>" />
</div>
<div class="form-group">
    <label for="nationality">Nationality*</label>
    <select class="form-control" name="nationality" id="nationality" style="width: 95%" required="required">
        <?php if (Session::exists('nationality')){?>
            <option value="<?php echo $flash = Session::flash('nationality'); ?>" selected="selected"><?php echo $flash; ?></option>
        <?php }?>
        <?php Person::country();  ?>
    </select>
</div>

<div class="form-group">
    <label for="state_of_origin">State of Origin*</label>
    <select class="form-control" name="state_of_origin" id="state_of_origin" style="width: 95%" required="required">
        <?php if (Session::exists('state_of_origin')){?>
            <option value="<?php echo $flash = Session::flash('state_of_origin'); ?>" selected="selected"><?php echo $flash; ?></option>
        <?php }?>
        <?php Person::naija_state_gen(); ?>
    </select>
</div>

<div class="form-group">
    <label class="control-label" for="lga">LGA*</label>
    <input class="form-control" style="width:95%" required="required" type="text" name="lga" id="lga" value="<?php if (Session::exists('lga')){ echo(Session::flash('lga')); } ?>" />
</div>
<div class="form-group">
    <label class="control-label" for="residential_address">Permanent Home Address*</label>
    <textarea class="form-control" style="width:95%" name="residential_address" id="residential_address" required="required">
        <?php if (Session::exists('residential_address')){ echo(Session::flash('residential_address')); } ?>
    </textarea>
</div>
<div class="form-group">
    <label for="state_of_residence">State of Residence*</label>
    <select class="form-control" name="state_of_residence" id="state_of_residence" style="width: 95%" required="required">
        <?php if (Session::exists('state_of_residence')){?>
            <option value="<?php echo $flash= Session::flash('state_of_residence'); ?>" selected="selected"><?php echo $flash; ?></option>
        <?php }?>
        <?php Person::naija_state_gen(); ?>
    </select>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="form-group">
            <label class="control-label" for="phone">Phone Number*</label>
            <input class="form-control" style="width:95%" required="required" type="text" name="phone" id="phone" value="<?php if (Session::exists('phone')){ echo(Session::flash('phone')); } ?>"  />
        </div>
    </div>
    <div class="col-sm-6">
        <div class="form-group">
            <label class="control-label" for="email">Email</label>
            <input class="form-control" style="width:95%" required="required" type="email" name="email" id="email" value="<?php if (Session::exists('email')){ echo(Session::flash('email')); } ?>"/>
        </div>
    </div>
</div>
<br/>
<h1>Professional Information</h1>

<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label" for="level">Level*</label>
        <input class="form-control" style="width:95%" required="required" type="text" name="level" id="level" value="<?php if (Session::exists('level')){ echo(Session::flash('level')); } ?>"  />
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label" for="appointment">Appointment*</label>
        <input class="form-control" style="width:95%" required="required" type="text" name="appointment" id="appointment" value="<?php if (Session::exists('appointment')){ echo(Session::flash('appointment')); } ?>"  />
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label" for="title">Title*</label>
        <input class="form-control" style="width:95%" required="required" type="text" name="title" id="title" value="<?php if (Session::exists('title')){ echo(Session::flash('title')); } ?>"  />
    </div>
</div>

<div class="col-sm-6">
    <div class="form-group">
        <label class="control-label" for="department">Department*</label>
        <input class="form-control" style="width:95%" required="required" type="text" name="department" id="department" value="<?php if (Session::exists('department')){ echo(Session::flash('department')); } ?>"  />
    </div>
</div>

<div class="form-group">
    <label class="control-label" for="citation">About me: Professional Bio Data</label>
    <textarea class="form-control" style="width:95%" name="citation" id="citation">
        <?php if (Session::exists('citation')){ echo(Session::flash('citation')); } ?>
    </textarea>
</div>
<div class="w3-container w3-amber" id="upload_response"><p>Upload file should be no more than <?php echo Upload::convertFromBytes($max);?>.</p></div>
<div class="w3-container w3-red hidden" id="upload_bad"><p>Oops... The selected file can't be uploaded because it exceeds <?php echo Upload::convertFromBytes($max);?>.</p></div>
<div class="w3-container w3-green hidden" id="upload_good"><p>Beautiful... Selected file Ok. You can proceed....</p></div>

<div class="form-group">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
    <label for="filename">Upload Profile Picture:
        <input type="file" name="filename" id="filename"
               data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
               data-postmax="<?php echo $_SESSION['postmax']; ?>"
               data-displaymax="<?php echo $_SESSION['displaymax']; ?>"

               required="required"/></label>
</div>
<div id="output"></div>


<div class="form-group-lg">
    <p class="help-block">By Clicking this button, you agree to be bound by the terms and condition that apply</p>
    <input class="btn btn-primary btn-lg" type="submit" name="send" id="send" value="Submit &amp; Proceed" />
</div>
</form>


</div>

</div>
<div class="col-sm-5">

    <h2>REQUIREMENTS <small>From The School Mgt</small></h2>
    <p>This account is for <b>teachers/ staffs</b></p>
    <p>This account should be created by the <b>teacher/ staff</b></p>
    <p>Please note that it will require you to visit the webmaster to ascertain the truism of the account created before access is granted to the school's portal</p>
    <p>With the staff's account, you can add to student's record on the go - anytime, anywhere!</p>
    <p>Note that access will only be granted to you if it is verified that you are a staff in this institution!</p>



</div>
</div>
</div>



