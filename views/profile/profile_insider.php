<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>
<?php
    $owner_id = $this->member['user_id'];
    $viewer = Session::get('user_id');
    $person = $this->member['firstname'].' '.$this->member['surname'].' '.$this->member['othername'];
?>
<div class="container-fluid text-center" id="myBody">
    <div class="row">
        <div class="col-sm-3 well">
            <div class="well">
                <p>
                    <a href="<?php echo(URL); ?>profile/member/<?php echo($this->member['slug']); ?>" ><?php echo($person); ?> </a>

                </p>
                <img src="<?php echo URL; ?>public/custom/img/avatar5.png" class="img-circle" height="65" width="65" alt="Avatar">
            </div>
            <div class="well">
                <p><a href="#"><?php echo $person; ?> Interests</a></p>
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
                <p><strong><?php echo $person; ?> Status</strong></p>
                Feeling Blue...
            </div>
            <p><a href="<?php echo(URL); ?>profile/friends/<?php echo($this->member['slug']); ?>"> Friends  of <?php echo $person; ?></a></p>
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
        </div>
        <div class="col-sm-7">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default text-left">
                        <div class="panel-heading">
                            <h2>About, <?php echo $person; ?> </h2>
                            <p>Some really long thing about them</p>
                            <h4>1. Check whether you are friends</h4>
                        </div>

                        <div class="panel-body">
                            <div>
                                <?php if($this->isFriend == 'friends'){?>
                                    <h4>Write on <?php echo $person; ?>'s Wall                                     <button type="button" class="btn btn-default btn-sm">
                                            <span class="glyphicon glyphicon-list-alt"></span> Go to <?php echo $person; ?>'s Wall
                                        </button>
                                    </h4>
                                    <form class="form" method="post" enctype="multipart/form-data" name="form1" id="form1">
                                        <textarea class="form-control" id="full_addy" name="full_addy" placeholder="Say something to... <?php echo $person; ?>?" rows="3" ></textarea><br>
                                        <div class="pull-left">
                                            <p contenteditable="true">Status: Feeling Blue. Upload file preview</p>

                                        </div>
                                        <div class="pull-right">
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-pencil"></span> Post
                                            </button>
                                            <button type="button" class="btn btn-default btn-sm">
                                                <span class="glyphicon glyphicon-camera"></span> Upload
                                            </button>

                                        </div>

                                        <br>
                                        <hr/>


                                    </form>
                                <?php  } elseif($this->isFriend == 'pending'){
                                    echo("<h4> Friendship request status with $person is pending</h4>");
                                }elseif($this->isFriend == 'not-yet'){ ?>
                                    <h4>Request Friendship from <?php echo $person; ?></h4>
                                    <p id="friend_btn">
                                        <button type="button" class="btn btn-success" onclick="request_friendship('<?php echo $viewer; ?>','<?php echo $owner_id; ?>')">
                                            <span class="glyphicon glyphicon-heart"></span> Send Friendship Request
                                        </button>

                                    </p>

                                <?php }elseif(is_numeric($this->isFriend)){ ?>
                                    <h4>Respond to Friendship Request from <?php echo $person; ?></h4>
                                    <p id="friend_response">
                                        <button type="button" class="btn btn-success" id="submit" onclick="accept_friendship(1,'<?php echo $this->isFriend; ?>')">
                                            <span class="glyphicon glyphicon-heart"></span> Accept Friendship Request
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger" id="submit" onclick="accept_friendship(0,'<?php echo $this->isFriend; ?>')">
                                            <span class="glyphicon glyphicon-volume-off"></span> Decline
                                        </button>
                                    </p>
                                <?php }elseif(($this->isFriend == 'owner')){ ?>
                                    <h4><span class="glyphicon glyphicon-cog"></span> Update my profile Settings</h4>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <p>form input field</p>
                                        </div>

                                    </div>

                                <?php } ?>



                            </div>


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
