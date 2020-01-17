
<?php
    $max = 2000 * 1024; //2mb
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
                                      <li <?php if($this->navigation['step-1'] === $page ){ echo('class="selected"'); }  ?>> <a href="<?php echo $page['href']; ?>" title="<?php echo $page['title']; ?>"> <?php echo $page['name']; ?></a></li>
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
	<div class="w3-row">
      <?php if(Session::exists('home')){?>
          <div class="w3-container w3-green"><p><?php echo Session::flash('home');?> </p></div>
      <?php } ?>
        <?php if(Session::exists('error')){ ?>
            <div class="w3-container w3-red"><p><?php echo Session::flash('error');  ?> </p></div>
        <?php }
            ?>

  </div>

    </div>
    <div id="father">
        <header class="w3-container">
            <h1>Upload a new Document</h1>
        </header>

        <div>
                <form action="<?php echo URL; ?>wall/document_upload" method="post" enctype="multipart/form-data" name="form1" class="w3-container w3-card-4" id="form1">
  					<div class="w3-row">
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="title" id="title" value="<?php if (Session::exists('title')){ echo(Session::flash('title')); } ?>" required="required">
                            <label class="w3-label">Title  </label>
                          </div>
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="author" id="author" value="<?php if (Session::exists('author')){ echo(Session::flash('author')); } ?>" required>
                            <label class="w3-label">Author(s)  </label>
                          </div>
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="tag" id="tag" value="<?php if (Session::exists('tag')){ echo(Session::flash('tag')); } ?>" >
                            <label class="w3-label">Tag or Category or Keywords  </label>
                          </div>
                          <div class="w3-group">      
                            <textarea class="w3-input" style="width:90%" name="abstract" id="abstract"><?php if (Session::exists('abstract')){ echo(Session::flash('abstract')); } ?></textarea>
                            <label class="w3-label">Abstract</label>
                          </div>
                    </div>

                    <div class="w3-container w3-amber" id="upload_response"><p>Upload file should be no more than <?php echo Upload::convertFromBytes($max);?>.</p></div>
                    <div class="w3-container w3-red hidden" id="upload_bad"><p>Oops... The selected file can't be uploaded because it exceeds <?php echo Upload::convertFromBytes($max);?>.</p></div>
                    <div class="w3-container w3-green hidden" id="upload_good"><p>Beautiful... Selected file Ok. You can proceed....</p></div>


                    <div class="w3-group">
                    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                    <label for="filename">Upload PDF Document:</label>
                    <input type="file" name="filename" id="filename"
                           data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                           data-postmax="<?php echo $_SESSION['postmax']; ?>"
                           data-displaymax="<?php echo $_SESSION['displaymax']; ?>"

                           required="required"/>
                </div>

		<div id="output"></div>

                    <input type="hidden" name="token" value="<?php echo Token::generate(); ?>" />
<div>
<div class="w3-container w3-blue" onClick="toggle_visibility('foo','bar');" id="bar" style="cursor:pointer;"><p onMouseOver="">Click here to enter details about the work. If it has already been presented. </p></div>

<div id="foo" style="display:none; border-top: 1px dashed #ff9c00">
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="occasion" id="occasion" value="<?php if (Session::exists('occasion')){ echo(Session::flash('occasion')); } ?>" >
                            <label class="w3-label">Occasion Presented at  </label>
                          </div>
                          <div class="w3-group">      
                            <input class="w3-input" type="text" style="width:90%" name="place" id="place" value="<?php if (Session::exists('place')){ echo(Session::flash('place')); } ?>" >
                            <label class="w3-label">Place Presented at  </label>
                          </div>
                          <div class="w3-group">      
  					<div class="w3-row">
                                  <label for="day">Date Presented </label>
                                  <br />

                        <div class="w3-third w3-center">
                            <select name="day" id="day" required="required">
                                <?php if (Session::exists('day')){?>
                                    <option value="<?php echo $flash= (Session::flash('day')); ?>" selected="selected"><?php echo ($flash); ?></option>
                                <?php } ?>
                                <option value="0">Day</option>
                                <?php Date::daygen(); ?>
                            </select>
                        </div>
                        <div class="w3-third  w3-center">
                            <select name="month" id="month" required="required">
                                <?php if (Session::exists('month')){?>
                                    <option value="<?php echo $flash = Session::flash('month'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Month</option>
                                <?php Date::monthgen(); ?>
                            </select>
                        </div>
                        <div class="w3-third  w3-center">
                            <select name="year" id="year" required="required">
                                <?php if (Session::exists('year')){?>
                                    <option value="<?php echo $flash = Session::flash('year'); ?>" selected="selected"><?php echo $flash; ?></option>
                                <?php }?>
                                <option value="0">Year</option>
                                <?php Date::yeargen(); ?>

                            </select>
                        </div>
                    </div>
                          </div>
</div>
</div>
                        <br>
                        <input class="w3-btn w3-green w3-center w3-centered"  type="submit" name="submit" id="submit" value="Upload This File" style="width:100%" />
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <br><br>
                </form>
        </div>

    </div>
    <header class="w3-container">
        <h1>All My Documents</h1>
    </header>
    <div class="w3-content w3-container w3-card-4 " id="documents">
        <?php
            $my_files = $user->my_pdf_uploads($_SESSION['user_id']);
            $numFiles = $user->count();
        ?>

        <?php if ($numFiles < 1){ ?>

            <div class="w3-container w3-red" id="upload_good"><p>Your Documents Folder is empty. No file to display. Please upload a file ....</p></div>

        <?php }elseif ($numFiles >= 1){?>
<table class="w3-table w3-bordered w3-striped w3-border">
 <thead>
<tr>
  <th>Paper Title</th>
  <th>Date Uploaded</th>
  <th>Action</th>
</tr>
</thead>
<tbody>
    <?php foreach($my_files as $pdf){?>

<tr>
  <td><?php echo $pdf['paper_title']; ?></td>
    <?php
        $date = new DateTime($pdf['uploaded_on']);
        $dob = $date->format('D d M, Y ');//h:i a
    ?>
  <td><?php echo $dob; ?></td>
  <td><a href="<?php echo URL; ?>wall/delete/document/<?php echo $pdf['paper_id']; ?>" class="w3-btn w3-red">Delete</a></td>
</tr>
    <?php  } ?>

</tbody>
</table>
        <?php  } ?>


    </div>


    <div>

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
