<!DOCTYPE html>
<html lang="en">
<?php
    $user = new User();
?>

<head>
    <title><?php $title = isset($this->title)? $this->title: "School Board"; echo $title; ?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="<?php// echo $blogs['tags']; ?>" />

    <link rel="stylesheet" href="<?php echo URL; ?>public/bootstrap/css/bootstrap.css">
    <link href="http://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <link href="<?php echo URL; ?>public/custom/css/member.css" rel="stylesheet" type="text/css">
    <?php  //General or public applicable css
        if (isset($this->generalCSS))
        {
            foreach ($this->generalCSS as $plugin)
            {
                echo '<link  href="'.URL.'public/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
    <?php  //General or public applicable css
        if (isset($this->pageCSS))
        {
            foreach ($this->pageCSS as $plugin)
            {
                echo '<link  href="'.URL.'views/'.$plugin.'" rel="stylesheet" type="text/css">';
            }
        }
    ?>
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><img src="<?php echo(Session::get('logged_in_user_photo')); ?>" class="img-thumbnail" width="40px" height="40px" alt="<?php echo (Session::get('logged_in_user_name')); ?>"></a>
        </div>
        <?php
            $navigation = array(
                'wall' => array(
                    'name' => 'My Wall',
                    'title' => 'Go to your wall: view private conversations',
                    'href' => URL.'wall',
                ),
                'church' => array(
                    'name' => 'My Study',
                    'href' => URL.'church',
                    'title' => 'Update your profile and account settings',
                ),
            );

            $url = isset($_GET['url']) ? $_GET['url'] : null;
            $url = rtrim($url, '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            $url_count = count($url);

            if(count($url) > 1){
                //reconstruct the url back
                //$url = $url[0].'/'.$url[1];
                $url = $url[0];
            }else{
                //it means we are viewing the index page
                $active = $url[0];
                $url = $url[0];

            }

        ?>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <?php
                    if (isset($navigation)){
                        foreach($navigation as $item => $page){?>
                            <li <?php if($item === $url ){ echo('class="active"'); }  ?>> <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"><?php echo $page['name']; ?></a></li>

                            <?php }  ?>
                    <?php }    ?>
            </ul>
            <form class="navbar-form navbar-right" role="search">
                <div class="form-group input-group">
                    <input type="text" id="person" name="livesearch" class="form-control" placeholder="Search.." onKeyUp="Search(this.value,'<?php echo $url_count;  ?>')">


          <span class="input-group-btn">
            <button class="btn btn-default" type="button">
                <span class="glyphicon glyphicon-search"></span>
            </button>
          </span>
                </div>

            </form>
            <ul class="nav navbar-nav navbar-right" id="re-nav">
                <li onclick="viewDashBoard()">
                    <a href="<?php echo URL; ?>wall#topBody"><span class="glyphicon glyphicon-globe"></span>Notifications</a>
                </li>
                <li>
                    <a href="<?php echo(URL); ?>login/logout"><span class="glyphicon glyphicon-log-out"></span>Log out</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container-fluid slideanim text-center" id="topBody"  style="display: none;">
    !-- Trigger the modal with a button -->
    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>

    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Modal Header</h4>
                </div>
                <div class="modal-body">
                    <p>Some text in the modal.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <!--END Modal -->

    <div class="row" id="topPlace">
        <div class="col-sm-3 well">
            <ul class="nav nav-pills nav-stacked">
                <li><a data-toggle="pill" href="#notification"> Notifications</a></li>
                <li><a data-toggle="pill" href="#request">Requests</a></li>
                <li class="active"><a data-toggle="pill" href="#search">Search Results</a></li>
                <li><a data-toggle="pill" href="#advertisement">Advertisements</a></li>

            </ul>
        </div>
        <div class="col-sm-7">
           <div class="row">
               <div class="col-sm-12">
                   <div class="tab-content">
                       <div id="notification" class="tab-pane fade">
                           <h4>Notifications <span class="badge">4 New</span> </h4>
                           <hr/>
                           <ul class="dropdown-menu" id="notifications">
                               <li class="header">You have 4 New Notifications</li>
                               <li><!-- start message -->
                                   <a href="#">
                                       <div class="pull-left">
                                           <img src="<?php echo URL; ?>public/custom/img/avatar5.png" class="img-circle" height="30" width="30" alt="Avatar">
                                       </div>
                                       <h4>
                                           Martha Kelvin
                                           <br />
                                           <small><i class="glyphicon glyphicon-time"></i> 5 mins</small>
                                           <small><i class="glyphicon glyphicon-pushpin"></i> Wall Post</small>
                                       </h4>

                                       <p> WROTE: Why not buy a new awesome theme? Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.</p>
                                   </a>
                               </li>
                               <li><!-- start message -->
                                   <a href="#">
                                       <div class="pull-left">
                                           <img src="<?php echo URL; ?>public/custom/img/avatar5.png" class="img-circle" height="30" width="30" alt="Avatar">
                                       </div>
                                       <h4>
                                           Kennedy Henshaw Kelvin
                                           <br />
                                           <small><i class="glyphicon glyphicon-time"></i> Yesterday</small>
                                           <small><i class="glyphicon glyphicon-share-alt"></i> Post Reply</small>
                                       </h4>

                                       <p> WROTE: Why not buy a new awesome theme? Just Forgot that I had to mention something about someone to someone about how I forgot something, but now I forgot it. Ahh, forget it! Or wait. I remember.</p>
                                   </a>
                               </li>
                               <li><a href="#">Page 1-1</a></li>
                               <li><a href="#">Page 1-2</a></li>
                               <li><a href="#">Page 1-3</a></li>
                           </ul>


                       </div>
                       <div id="request" class="tab-pane fade">
                           <?php
                               print_r($this->friendship_requested);
                               if($this->friendship_requested){ ?>
                           <h4>Requests


                               <span class="badge"><?php echo(count($this->friendship_requested)); ?> New</span>
                           </h4>
                           <hr/>
                           <div class="row">
                           <?php
                            foreach($this->friendship_requested as $request){
                                list($person, $source, $slug) = $user->get_person_name($request->user1_id);

                                ?>
                                <?php echo($request->user1_id); ?>
                                <?php ?>
                                    <div>
                                        <div class="col-sm-2">
                                            <img src="<?php echo($source); ?>" class="img-circle" height="55" width="55" alt="<?php echo($person); ?>">
                                        </div>
                                        <div class="col-sm-10 text-left text-holder">
                                            <a href="<?php echo(URL); ?>profile/member/<?php echo($slug); ?>" class="poster-name text-left"><?php echo($person); ?> </a>

                                            <p id="friend_response">
                                                <button type="button" class="btn btn-success btn-sm" id="submit" onclick="accept_friendship(1,'<?php echo $request->id; ?>')">
                                                    <span class="glyphicon glyphicon-heart"></span> Accept Friendship Request
                                                </button>
                                                <button type="button" class="btn btn-xs btn-default" id="submit" onclick="accept_friendship(0,'<?php echo $request->id; ?>')">
                                                    <span class="glyphicon glyphicon-volume-off"></span> Decline
                                                </button>
                                            </p>

                                        </div>

                                    </div>
                                    <br/>
                            <?php }?>
                            </div>
                           <?php }else{ ?>
                                   <h4>No New Requests  </h4>

                               <?php }?>

                       </div>
                       <div id="search" class="tab-pane fade in active">
                           <h4>Search Results </h4>
                           <hr/>
                           <div class="row">
                               <div id="livesearch"></div>

                           </div>
                           <div >
                               <div class="row">
                                   <div class="col-sm-2">
                                       <img src="<?php echo URL; ?>public/custom/img/avatar2.png" class="img-thumbnail" height="51px" width="51px"  alt="Avatar">
                                   </div>
                                   <div class="col-sm-10 text-left">
                                       <p><a href="#" class="poster-name text-left">Mercy Musa</a>: Student at Church
                                       </p>

                                   </div>

                               </div>
                               <hr/>
                               <div class="row">
                                   <div class="col-sm-2">
                                       <img src="<?php echo URL; ?>public/custom/img/avatar04.png" class="img-thumbnail" height="51px" width="51px"  alt="Avatar">
                                   </div>
                                   <div class="col-sm-10 text-left">
                                       <p><a href="#" class="poster-name text-left">Mark Musa</a>: Student at Church
                                       </p>
                                       <br/>
                                   </div>

                               </div>


                           </div>

                       </div>
                       <div id="advertisement" class="tab-pane fade">
                           <h4>Advertisements </h4>
                           <hr/>
                       </div>
                   </div>
               </div>
           </div>

        </div>
        <div class="col-sm-2 well">
            <p><a href="<?php echo(URL); ?>profile/member/<?php echo($this->member['slug']); ?>">My Profile Settings</a></p>
            <p><a href="#">Link</a></p>
            <p><a href="#">Link</a></p>
        </div>
    </div>
</div>

