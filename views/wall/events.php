
<?php
    $user = new User();
?>


<div class="w3-container">
  <div class="w3-row">
            <div>
              <div class="w3-quarter">
                    <div class="w3-card" style="background-color:#fff">
                      <ul class="w3-ul" id="admin_side_nav">
                          <?php

                              if (isset($this->navigation)){
                                  foreach($this->navigation as $item => $page){
                                      ?>
                                      <li <?php if($this->navigation['step-2'] === $page ){ echo('class="selected"'); }  ?>> <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"> <?php echo $page['name']; ?></a></li>
                                  <?php } }  ?>
                      </ul>
                    </div>
                    <br>
              </div>
            </div>
<div class="w3-half w3-padding-left">
              <!--################################################# 	MAIN BODY  	#######################################################################-->
<div class=" w3-white">
    <div class="w3-content w3-container w3-card-4 " id="firstThing">
	<div class="w3-row"></div>

    </div>
    <div id="father">
        <header class="w3-container">
            <h1>Events || Conferences || Workshops</h1>
        </header>
        <?php if($this->iManage){ ?>
        <div class="w3-container w3-card-4">
            <div class="w3-row" onclick="toggle('manage')" style="cursor: pointer">
                <?php if(Session::exists('manage')){?>
                    <div class="w3-container w3-green"><p><?php echo Session::flash('manage');?> </p></div>
                <?php } ?>

                <h2 class="w3-text-green" >Events that you manage <i class="mdi mdi-arrow-collapse"></i> </h2>
            </div>
            <div id="manage">
                <p>Here are all the events started or being managed by you</p>
                <div>
                    <div class="w3-content w3-container " id="documents">
                            <table class="w3-table w3-bordered w3-striped w3-border">
                                <thead>
                                <tr>
                                    <th>Event</th>
                                    <th>Venue</th>
                                    <th>Date</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($this->iManage as $event){?>

                                    <tr>
                                        <td><a href="<?php echo URL; ?>event/purpose/moderate/<?php echo $event['slug']; ?>" class="w3-btn w3-theme-light" title="Moderate This Event"><?php echo $event['title']; ?></a></td>

                                        <td></td>
                                        <td><?php echo $event['event_venue']; ?></td>
                                        <?php
                                            $date = new DateTime($event['start_date']);
                                            $dob = $date->format('D d M, Y ');//h:i a
                                        ?>
                                        <td><?php echo $dob; ?></td>
                                        <?php if($event['is_live'] == 1){ ?>
                                        <td><a href="<?php echo URL; ?>event/details/<?php echo $event['slug']; ?>" class="w3-btn w3-green">View Details</a></td>
                                        <?php } else { ?>
                                        <td><a href="<?php echo URL; ?>event/start/now/<?php echo $event['slug']; ?>" class="w3-btn w3-red"> Make Live</a></td>
                                        <?php } ?>

                                    </tr>
                                <?php  } ?>

                                </tbody>
                            </table>


                    </div>
                    <br>


                </div>
            </div>

        </div>
        <br/>
        <?php } ?>

        <?php if($this->trending){ ?>
        <div class="w3-container w3-card-4">
            <div class="w3-row" onclick="toggle('trending')" style="cursor: pointer">
                <h2 class="w3-text-blue" >Now Trending Events <i class="mdi mdi-arrow-collapse"></i> </h2>
            </div>
            <div id="trending">
                <p>New and latest events to attend</p>
                <div>
                    <div class="w3-content w3-container " id="documents">
                        <table class="w3-table w3-bordered w3-striped w3-border">
                            <thead>
                            <tr>
                                <th>Event</th>
                                <th>Venue</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($this->trending as $event){?>
                            <?php $event = $user->get_trending($event); ?>

                                <tr>
                                    <td><?php echo $event['title']; ?></td>
                                    <td><?php echo $event['event_venue']; ?></td>
                                    <?php
                                        $date = new DateTime($event['start_date']);
                                        $dob = $date->format('D d M, Y ');//h:i a
                                    ?>
                                    <td><?php echo $dob; ?></td>
                                    <?php if($event['is_live'] == 1){ ?>
                                        <td><a href="<?php echo URL; ?>event/purpose/reg/<?php echo $event['slug']; ?>" class="w3-btn w3-green">REGISTER</a></td>
                                    <?php } else { ?>
                                        <td><a href="<?php echo URL; ?>event/review/<?php echo $event['slug']; ?>" class="w3-btn w3-red">Write Review</a></td>
                                    <?php } ?>

                                </tr>
                            <?php  } ?>

                            </tbody>
                        </table>


                    </div>
                    <br>


                </div>

            </div>

        </div>
        <br/>
        <?php } ?>
        <?php if($this->registered){ ?>
        <div class="w3-container w3-card-4">
            <div class="w3-row" onclick="toggle('register')" style="cursor: pointer">
                <h3 class="w3-text-amber">Events Registered and Attended  <i class="mdi mdi-arrow-collapse"></i></h3>
            </div>
            <div id="register">
                <p>All  events  registered</p>
                <div>
                    <div class="w3-content w3-container " id="documents">
                        <table class="w3-table w3-bordered w3-striped w3-border">
                            <thead>
                            <tr>
                                <th>Event</th>
                                <th>Venue</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach($this->registered as $event){?>
                                <?php $event = $user->get_trending($event); ?>

                                <tr>
                                    <td><?php echo $event['title']; ?></td>
                                    <td><?php echo $event['event_venue']; ?></td>
                                    <?php
                                        $date = new DateTime($event['start_date']);
                                        $dob = $date->format('D d M, Y ');//h:i a
                                    ?>
                                    <td><?php echo $dob; ?></td>
                                    <?php $attend = $user->get_attended($event['event_id']); ?>
                                    <?php if($attend['attended'] == 1){ ?>
                                        <td><a href="<?php echo URL; ?>event/purpose/reg/<?php echo $event['slug']; ?>" class="w3-btn w3-grey">Attended</a></td>
                                    <?php } else { ?>
                                        <td><a href="<?php echo URL; ?>event/review/<?php echo $event['slug']; ?>" class="w3-btn w3-blue"> Review</a></td>
                                    <?php } ?>

                                </tr>
                            <?php  } ?>

                            </tbody>
                        </table>


                    </div>
                    <br>


                </div>

            </div>

        </div>
        <br/>
        <?php } ?>

        <div class="w3-container w3-card-4"></div>
        <br/>

        <div>

                <form action="<?php echo URL; ?>wall/start_event" method="post" enctype="multipart/form-data" name="start_event" class="w3-container w3-card-4" id="start_event">
                    <div class="w3-row">
                        <h3 class="w3-text-red">Start Event</h3>
                    </div>
                    <div class="w3-row">
                        <?php if(Session::exists('home')){?>
                            <div class="w3-container w3-green"><p><?php echo Session::flash('home');?> </p></div>
                        <?php } ?>
                        <?php if(Session::exists('error')){ ?>
                            <div class="w3-container w3-red"><p><?php echo Session::flash('error');  //echo  //$this->error;?> </p></div>
                        <?php }
                        else{?>
                            <div class="w3-container w3-amber"><p>Please enter Details.</p></div>
                        <?php } ?>

                        <div class="w3-row">
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="title" id="title" value="<?php if (Session::exists('title')){ echo(Session::flash('title')); } ?>" required="required">
                            <label class="w3-label">Name/ Title  </label>
                          </div>
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="caption" id="caption" value="<?php if (Session::exists('caption')){ echo(Session::flash('caption')); } ?>" required>
                            <label class="w3-label">Caption/ Theme  </label>
                          </div>
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="abbreviation" id="abbreviation" value="<?php if (Session::exists('abbreviation')){ echo(Session::flash('abbreviation')); } ?>" required="required" >
                            <label class="w3-label">Abbreviation (Make this Unique &amp; Short)  </label>
                          </div>
                        <div class="w3-group">
                            <textarea class="w3-input" style="width:90%" name="overview" id="overview"><?php if (Session::exists('overview')){ echo(Session::flash('overview')); } ?></textarea>
                            <label class="w3-label">Event Overview</label>
                        </div>
                        <div class="w3-group">
                            <div class="w3-row">
                                <div class="w3-third">
                                    <label for="event_type">Type of Event</label>
                                    <br/>
                                    <select name="event_type" id="event_type" required="required">
                                        <?php if (Session::exists('event_type')){?>
                                            <option value="<?php echo $flash = Session::flash('event_type'); ?>" selected="selected"><?php echo $flash; ?></option>
                                        <?php }?>
                                        <?php Person::event_type(); ?>
                                    </select>

                                </div>

                                <div class="w3-third">
                                    <label for="event_scope">Scope of Event</label>
                                    <br/>
                                    <select name="event_scope" id="event_scope" required="required">
                                        <?php if (Session::exists('event_scope')){?>
                                            <option value="<?php echo $flash = Session::flash('event_scope'); ?>" selected="selected"><?php echo $flash; ?></option>
                                        <?php }?>
                                        <?php Person::event_scope(); ?>
                                    </select>

                                </div>
                                <div class="w3-third">
                                    <label for="ticket_type">Ticket Type </label>
                                    <br/>
                                    <select name="ticket_type" id="ticket_type" required="required">
                                        <?php if (Session::exists('ticket_type')){?>
                                            <option value="<?php echo $flash = Session::flash('ticket_type'); ?>" selected="selected"><?php echo $flash; ?></option>
                                        <?php }?>
                                        <?php Person::ticket_type(); ?>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="foo">
                        <div class="w3-group">
                            <input class="w3-input" type="text" style="width:90%" name="venue" id="venue" value="<?php if (Session::exists('venue')){ echo(Session::flash('venue')); } ?>" required="required" >
                            <label class="w3-label">Venue</label>
                        </div>
                        <div class="w3-group">
                            <input class="w3-input" type="text" style="width:90%" name="time" id="time" value="<?php if (Session::exists('time')){ echo(Session::flash('time')); } ?>" required="required" >
                            <label class="w3-label">Time(s)  </label>
                        </div>
                        <div class="w3-group w3-container">
                            <label for="adm_day">Start Date*</label>
                            <select name="adm_day" id="adm_day" required="required">
                                <?php if (Session::exists('adm_day')){?>
                                    <option value="<?php echo $flash = Session::flash('adm_day'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Day</option>
                                <?php Date::daygen(); ?>
                            </select>
                            <select name="adm_month" id="adm_month" required="required">
                                <?php if (Session::exists('adm_month')){?>
                                    <option value="<?php echo $flash = Session::flash('adm_month'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Month</option>
                                <?php Date::monthgen(); ?>
                            </select>
                            <select name="adm_year" id="adm_year" required="required">
                                <?php if (Session::exists('adm_year')){?>
                                    <option value="<?php echo $flash = Session::flash('adm_year'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Year</option>
                                <?php Date::yearInFuture(); ?>

                            </select>
                        </div>
                        <div class="w3-group w3-container">
                            <label for="grad_day">End Date</label>
                            <select name="grad_day" id="grad_day">
                                <?php if (Session::exists('grad_day')){?>
                                    <option value="<?php echo $flash = Session::flash('grad_day'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Day</option>
                                <?php Date::daygen(); ?>
                            </select>
                            <select name="grad_month" id="grad_month">
                                <?php if (Session::exists('grad_month')){?>
                                    <option value="<?php echo $flash = Session::flash('grad_month'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Month</option>
                                <?php Date::monthgen(); ?>
                            </select>
                            <select name="grad_year" id="grad_year">
                                <?php if (Session::exists('grad_year')){?>
                                    <option value="<?php echo $flash = Session::flash('grad_year'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Year</option>
                                <?php Date::yearInFuture(); ?>

                            </select>
                        </div>
                    </div>
                    <div class="w3-group">
                        <input class="w3-input" type="text" style="width:90%" name="organizers_name" id="organizers_name" value="<?php if (Session::exists('organizers_name')){ echo(Session::flash('organizers_name')); } ?>" required="required" >
                        <label class="w3-label">Organizers Name  </label>
                    </div>
                    <div class="w3-group">
                        <textarea class="w3-input" style="width:90%" name="organizers_desc" id="organizers_desc"><?php if (Session::exists('organizers_desc')){ echo(Session::flash('organizers_desc')); } ?></textarea>
                        <label class="w3-label">Organizers Description</label>
                    </div>






                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
<div>

</div>
                        <br>
                        <input class="w3-btn w3-green w3-center w3-centered"  type="submit" name="submit" id="submit" value="Start Event" style="width:100%" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <br><br>
                </form>
        </div>

    </div>


</div>
        
                <!--############################################### END OF MAIN BODY  	###################################################################-->
            </div>
        </div>
        <div class="w3-quarter w3-padding-left">
               <div class=" w3-white ">
                  <div class="advertisement">
                 <h2>Advertisements</h2>
                      <?php
                          if (isset($this->adverts)){
                              foreach($this->adverts as $item => $page){
                                  if(isset($this->adverts['step-1']) === $page || $this->adverts['general'] === $page ){
                                      foreach($page as $helps => $help){

                                          ?>
                                          <p class="scroll"><?php echo $help ?></p>
                                      <?php }   } }   } ?>
               </div>
            </div>
          </div>
      </div>
    </div>
    <!-- end main body -->
