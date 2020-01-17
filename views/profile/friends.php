<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>
<?php
    $photo = $this->member[0]['photo'];
    if(!empty($photo)){
        $myPhoto = URL.'public/uploads/profile-pictures/'.$photo;

    }else{
        if($this->member['sex']== 'Male'){
            $myPhoto = URL.'public/images/avatar-male.png';
        }else{
            $myPhoto = URL.'public/images/avatar-female.png';
        }
    }
    $status = $this->member[0]['status'];
?>

<?php
    $person = $this->member['firstname'].' '.$this->member['surname'].' '.$this->member['othername'];
?>
<div class="container-fluid text-center" id="myBody">
    <div class="row">
        <div class="col-sm-3 well">
            <div class="well">
                <p>
                    <a href="<?php echo(URL); ?>profile/member/<?php echo($this->member['slug']); ?>" ><?php echo($person); ?> </a>

                </p>
                <img src="<?php echo $myPhoto; ?>" class="img-circle" height="65" width="65" alt="<?php echo $me; ?>">
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
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
        </div>
        <div class="col-sm-7">

            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default text-left">
                        <div class="panel-heading">
                            <h2>FRIENDS of, <?php echo $person .': '.(count($this->myFriends)); ?> </h2>
                        </div>

                        <div class="panel-body">
                            <div class="row text-center">

                                <?php
                                    foreach($this->myFriends as $d){
                                    list($name, $source, $slug) = $user->get_person_name($d);
                                ?>

                                <div class="col-md-4">
                                    <a href="<?php echo(URL); ?>profile/member/<?php echo($slug); ?>" class="thumbnail">
                                        <p><?php echo($name); ?></p>
                                        <img src="<?php echo($source); ?>" alt="<?php echo($name); ?>" style="width:150px;height:150px">
                                    </a>
                                    <p><a class="btn btn-default" href="http://go.microsoft.com/fwlink/?LinkId=301867">Options &raquo;</a></p>

                                </div>
                                    <?php } ?>

                            </div>

                            <div>

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
