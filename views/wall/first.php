<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>
<?php $me = $this->person['firstname'].' '.$this->person['surname'].' '.$this->person['othername']; ?>
<div class="container-fluid text-center" id="myBody">
    <div class="row">
        <div class="col-sm-3 well">
            <div class="well">
                <p><a href="#"><?php echo $me; ?> </a></p>
                <img src="<?php echo URL; ?>public/custom/img/avatar5.png" class="img-circle" height="65" width="65" alt="Avatar">
            </div>
            <div class="well">
                <p><a href="#">Set your Interests</a></p>
                <p>
                    <span class="label label-default">News</span>
                    <span class="label label-primary">W3Schools</span>
                    <span class="label label-success">Labels</span>
                    <span class="label label-info">Football</span>
                    <span class="label label-warning">Gaming</span>
                    <span class="label label-danger">Friends</span>
                </p>
            </div>
            <div class="alert alert-success fade in">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p><strong>Set your Status</strong></p>
                Feeling Blue...
            </div>
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
        </div>
        <div class="col-sm-7">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default text-left">
                        <div class="panel-heading">
                            <h2>Hello, <?php echo $me; ?> </h2>
                            <p>Be up an running in no time!</p>
                            <h4>1. Change your display picture</h4>
                            <h4>2. Set your Status</h4>
                            <h4>3. Set your interests</h4>
                        </div>
                        <div class="panel-body">
                            <form class="form" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                <div>
                                    <h4>1. <span class="glyphicon glyphicon-camera"></span> Upload a photo of yourself</h4>

                                    <div class="form-group">
                                        <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo $max; ?>" />

                                        <input type="file" name="filename" id="filename" class="form-control"
                                               data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                                               data-postmax="<?php echo $_SESSION['postmax']; ?>"
                                               data-displaymax="<?php echo $_SESSION['displaymax']; ?>"

                                              />


                                    </div>
                                    <p id="output"></p>
                                </div>

                                <h4>2. Set your Status</h4>

                                <textarea class="form-control" id="person_state" name="person_state" placeholder="2. Set your Status Here... Something about you " rows="1" required="required"></textarea>
                                <br>
                                <div>
                                    <h4>3. Customize how people find you</h4>
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-globe"></i>  www.winnersfamily.org/profile/member/</span>
                                            <input class="form-control" id="person_slug" name="person_slug" value="<?php echo toAscii($me); ?>" type="text">

                                        </div>
                                        <p class="help-block">This will appear on your UNIT ID card (if you belong to any), and cannot be changed</p>
                                    </div>


                                </div>
                                <br/>
                                <p id="status"></p>
                                <button type="button" class="btn btn-success btn-block" id="submit" onclick="account_setup()">
                                    <span class="glyphicon glyphicon-pencil"></span> I'm All Set, Take me to my wall
                                </button>


                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-2 well">
            <div class="thumbnail mandate">
                <h4>August 2016:</h4>
                <p><strong>I am set for an Encounter with Power</strong></p>
                <p>Psalms 63:1-5</p>

            </div>
            <div class="well">
                <p>Notifications from LFC World wide appears here</p>
            </div>
            <div class="well">
                <p>Notifications from Your Residence Church appears here</p>
            </div>
            <div class="well">
                <p>Notifications from Your UNIT/ WSF appears here</p>
            </div>
        </div>
    </div>
</div>
