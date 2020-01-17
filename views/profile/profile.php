<?php
    $user = new User();
?>
<?php
    $owner_id = $this->member['user_id'];
    $viewer = Session::get('user_id');
    $person = $this->member['firstname'].' '.$this->member['surname'].' '.$this->member['othername'];
?>

<!-- Container (Header Section) -->
<div id="testimonies" class="container-fluid text-center">
    <h2> <span class="glyphicon glyphicon-paperclip"></span> News and Articles</h2>
</div>
<!-- Container (Blog Section) -->
<div id="home-cells" class="container-fluid text-center bg-grey">
<?php $category = $this->category; ?>

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

<div class="row"></div>
</div>

</div>
