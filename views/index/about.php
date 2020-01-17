<?php
    $user = new User();
?>


<!-- Container (About LFC worldwide Section) -->
<div id="homecontent" class="container-fluid ">
    <div class="row" id="container">
        <div class="col-sm-7">
            <!--            <div class="row">
                <div class="col-sm-6">
                    <h2>About School New</h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <p>Nullamlacus dui ipsum conseqlo borttis non euisque morbipen a sdapibulum orna.</p>
                    <p>Urnau ltrices quis curabitur pha sellent esque congue magnisve stib ulum quismodo nulla et feugiat. Adipisciniap ellentum leo ut consequam.</p>
                    <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>

                </div>
                <div class="col-sm-6">
                    <h2>Events/ Calendar</h2>
                    <div class="imgholder"><img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail" /></div>
                    <br/>
                    <p>Nullamlacus dui ipsum conseqlo borttis non euisque morbipen a sdapibulum orna.</p>
                    <p>Urnau ltrices quis curabitur pha sellent esque congue magnisve stib ulum quismodo nulla et feugiat. Adipisciniap ellentum leo ut consequam.</p>
                    <p class="readmore"><a href="#">Continue Reading &raquo;</a></p>

                </div>
            </div>
 -->
            <div class="row">
                <?php foreach($this->about as $about){    ?>
                    <div class="col-sm-12">
                        <h2><?php echo($about->menu_name)  ?> </h2>
                        <img src="<?php echo(URL) ?>public/images/240x130.gif" alt="" class="img-thumbnail imgl"/>                    <p>Nullamlacus dui ipsum conseqlo borttis non euisque morbipen a sdapibulum orna.</p>
                        <p><?php echo($about->content)  ?></p>
                    </div>
                    <hr/>
                <?php  } ?>

            </div>

        </div>
        <div class="col-sm-5">

            <h2>Latest <small>From The School Blog</small></h2>
            <div class="list-group">
                <?php foreach($this->latest10 as $blog){?>

                    <div class="list-group-item">
                        <a class="list-group-item-heading" href="<?php echo(URL); ?>blog/title/<?php echo($blog['slug_date'].'/'.$blog['slug_title']);  ?>" title="View this Post"><h4><?php echo($blog['post_title'])  ?></h4>
                        </a>
                        <h5>
                            <?php if (!empty($blog['tags'])){
                                $tags = explode(',',$blog['tags']);
                                $i = count($tags);
                                $labels = array('default','primary','success','info','warning','danger');
                                for($x = 0; $x<$i; $x++){?>
                                    <?php
                                    $tag = $user->blog_tag($tags[$x]);
                                    ?>

                                    <span class="label label-<?php echo($labels[$x])  ?>"><?php echo($tag['tag_name'])  ?></span>
                                <?php  }}?>
                        </h5>
                        <?php
                            list($name, $source, $slug) = $user->get_person_name($blog['post_author']);

                            $date = new DateTime($blog['post_date']);
                            $dob = $date->format('d M, Y ');//h:i a
                        ?>

                        <p class="list-group-item-text text-"><span class="glyphicon glyphicon-time"></span> Post by <a href="<?php echo(URL); ?>profile/member/<?php echo($slug);  ?>" title="View Writer's profile"><?php echo($name); ?></a>: <?php echo($dob);  ?>.</p>
                    </div>
                <?php } ?>
            </div>


        </div>
    </div>
    <div class="row" id="login" >
        <div class="col-sm-3 col0 text-center" >
            <h2> School Portal</h2><br>
            <p>  Sign in to start your session  Mandate speaks of liberation in all facets of human existence, we focus mainly on destinies that have been afflicted, battered, beaten, tattered, deformed and subsequently in groaning and agonies, as a result of pains, pangs and crying. This is the mandate...</p>
            <br>

        </div>
        <div class="col-sm-4 col-sm-offset-1">
            <h2> Teachers <small>& Admin Login</small></h2><br>

            <form action="<?php echo(URL.'login/login'); ?>" method="post">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email address" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" id="password"  name="password"  class="form-control" placeholder="Enter Password: " required>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember" id="login_me" name="login_me"> Keep me logged in(this is my device)
                    </label>

                </div>
                <button type="submit" class="btn btn-info">Login</button>
            </form>
        </div>
        <div class="col-sm-4" id="students">
            <h2> Students <small> & Parents Login</small></h2><br>

            <form action="<?php echo(URL.'login/login'); ?>" method="post">
                <div class="form-group">
                    <label for="email">Email address:</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Enter Email address" required>
                </div>
                <div class="form-group">
                    <label for="pwd">Password:</label>
                    <input type="password" id="password"  name="password"  class="form-control" placeholder="Enter Password: " required>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" value="remember" id="login_me" name="login_me"> Keep me logged in(this is my device)
                    </label>

                </div>
                <button type="submit" class="btn btn-info">Login</button>
            </form>
        </div>

    </div>

</div>



