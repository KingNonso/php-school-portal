<?php
    $user = new User();
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-6">
                    <h2>School Address </h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <?php
                        foreach($this->contact as $contact){ ?>
                            <?php if($contact->type == 'Address'){ ?>
                                <p><?php echo($contact->details)  ?></p>
                            <?php  } ?>
                    <?php  } ?>

                </div>
                <div class="col-sm-6">
                    <h2>School Contact Numbers </h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <?php
                        foreach($this->contact as $contact){ ?>
                            <?php if($contact->type == 'Phone'){ ?>
                                <p><?php echo($contact->details)  ?></p>
                            <?php  }} ?>

                </div>

            </div>
            <hr/>

            <div class="row" id="contact-form">
                <div class="col-sm-12">
                    <h2>Contact Us</h2>

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
                            You may wish to communicate with us by completing the form below.
                        </div>
                    <?php } ?>

                </div>

                <div class="col-sm-12">
                    <form action="<?php echo(URL.'contact/new_enquiry'); ?>" method="post" id="contact_form" enctype="multipart/form-data" class="form-horizontal" role="form">

                        <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="name">Name:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="phone_no">Telephone:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="phone_no" name="phone_no" placeholder="Enter Phone Number ">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="email">Email:</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="address">Address:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="address" name="address" placeholder="Enter Office or Home Address">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="subject">Subject:</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="subject" name="subject" placeholder="What is it about?">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-sm-2" for="message">Message:</label>
                            <div class="col-sm-10">
                                <textarea class="form-control" rows="5" id="message" name="message"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label><input type="checkbox"> Request Newsletter</label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>


            </div>

        </div>
        <div class="col-sm-5">

            <h2>Bus Routes <small>Showing closest landmarks</small></h2>
            <ul class="list-group">
                <?php
                    foreach($this->contact as $contact){ ?>
                        <?php if($contact->type == 'Route'){ ?>
                            <li class="list-group-item"><?php echo($contact->details)  ?></li>
                        <?php  }} ?>

            </ul>



        </div>
    </div>
</div>
<div class="container-fluid col5">
    <div class="row" id="container">

        <div class="col-sm-7">
            <div class="row">
                <div class="col-sm-6">
                    <h2>Online Result Checker</h2>
                    <ol>
                        <li>You would need to get a scratch card from the School or purchase it online using this link</li>
                        <li>You would need to know your registration number or the registration number of the student you want to see his result.</li>
                        <li>Please sit in a very relaxed position and ensure your device is on a table!</li>
                        <li>Connection speed would depend on your service provider</li>
                        <li>Please be patient while the result is being computed.</li>
                    </ol>

                    <a href="<?php echo(URL) ?>links" class="btn btn-danger">View Result &raquo;</a>


                </div>
                <div class="col-sm-6">
                    <h2>Alumni Links</h2>

                    <ol>
                        <li>If you are a returning student, making this application by yourself, then know that the fields marked 'Name', 'Email', 'Phone' etc are for your own details, while those marked "Parent's Name" etc are for your parents</li>
                        <li>If you are a Parent or Guide, making this application by yourself, then know that the fields marked 'Name', 'Email', 'Phone' etc are for your child or ward's details, while those marked "Parent's Name" etc are for you</li>
                    </ol>
                    <a href="<?php echo(URL) ?>links/step/alumni" class="btn btn-md btn-primary pull-left">Begin Process for Alumni</a>


                </div>
            </div>
            <hr/>


        </div>
        <div class="col-sm-5">
            <h2>Staff/ Parent  <small> Registration</small> </h2>
            <div class="list-group">
                <a href="<?php echo(URL) ?>links/step/teacher" class="list-group-item">

                    <h4 class="list-group-item-heading">Begin Process for Staff </h4>
                    <p class="list-group-item-text">Create a Staff Web Portal Account</p>
                </a>
                <a href="<?php echo(URL) ?>links/step/parent-web" class="list-group-item">

                    <h4 class="list-group-item-heading">Begin Process for Parents </h4>
                    <p class="list-group-item-text">Create a Parents Web Portal Account, have access to your child's records anytime, anywhere</p>
                </a>

            </div>

        </div>
    </div>
</div>



