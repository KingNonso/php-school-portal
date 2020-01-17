<?php
    $max = 2000 * 1024; //2mb
    $user = new User();
?>

<div class="container-fluid text-center" id="myBody">
<div class="row">
<div class="col-sm-3 well">
    <div class="well">
        <p>
            <a href="<?php echo(URL); ?>profile/member/<?php echo(Session::get('logged_in_user_slug')); ?>" ><?php echo(Session::get('logged_in_user_name')); ?> </a>

        </p>
        <img src="<?php echo Session::get('logged_in_user_photo'); ?>" class="img-circle" height="65" width="65" alt="<?php echo Session::get('logged_in_user_name'); ?>">


    </div>
    <div class="well sidenav">
        <p>My Church</p>
        <ul class="nav nav-pills nav-stacked">
            <li><a href="<?php echo(URL); ?>church">Dashboard</a></li>
            <li class="active"><a href="<?php echo(URL); ?>blog">Blog</a></li>
            <li><a href="<?php echo(URL); ?>download">Downloads</a></li>
            <li><a href="<?php echo(URL); ?>profile/member">Winner</a></li>
        </ul><br>
    </div>
    <div class="alert alert-success fade in">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
        <p><strong>Church Details</strong></p>
        Feeling Blue...
    </div>
    <p><a href="<?php echo(URL); ?>profile/friends">My Friends</a></p>
    <p><a href="#">Link</a></p>
    <p><a href="#">Link</a></p>
</div>
<div class="col-sm-7">

<div class="row">
    <div class="col-sm-12">
        <form action="<?php echo(URL.'blog/post_write'); ?>" method="post" id="contact_form" enctype="multipart/form-data" onsubmit="return false">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h4>Write New Post</h4>
                <span id="work_report"></span>
            </div>
            <div class="panel-body text-left">
                    <div class="box-body">
                        <div class="form-group has-success">
                            <label class="control-label" for="title">Title</label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="title" name="title" placeholder="Enter Post Title Here...">
                                <span class="input-group-addon"><a href="javascript:void(0);" title="Add Subtitle" onclick="show_sub_holder()"><i class="glyphicon glyphicon-pencil"></i></a></span>
                            </div>

                        </div>
                        <div style="display: none" id="sub_holder" class="form-group">
                            <div class="input-group" >
                                <span class="input-group-addon">Subtitle</span>
                                <input type="text" class="form-control" placeholder="Enter subtitle here..." name="subtitle" id="subtitle">
                            </div>
                        </div>

                        <input type="hidden" name="token" id="token" value="<?php echo Token::generate(); ?>" />

                        <div class="form-group">
                            <label class="control-label" for="slug">Slug</label>
                            <div class="input-group">
                                <span class="input-group-addon">www.winnersfamily.com/blog/title/<?php echo(date('Ymd')); ?>/</span>
                                <input type="text" class="form-control" placeholder="Automatically generated Title slug..." name="slug" id="slug">
                            </div>
                            <p class="help-block" id="slug-guard">The "SLUG" is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</p>

                        </div>
                        <div class="form-group has-success">
                            <label>Post</label>
                            <textarea class="form-control" rows="18" placeholder="Enter Message here ..." id="post" name="post"></textarea>
                        </div>


                    </div>
                    <!-- /.box-body -->

            </div>
            <div class="panel-footer text-left">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="well">
                            <div class="row">
                                <div class="imageupload panel panel-default">
                                    <div class="panel-heading clearfix">
                                        <h3 class="panel-title pull-left">Add Featured Image</h3>
                                        <div class="btn-group pull-right">
                                            <button type="button" class="btn btn-default active">File</button>
                                            <button type="button" class="btn btn-default">URL</button>
                                        </div>
                                    </div>
                                    <div class="file-tab panel-body">
                                        <input type="hidden" name="MAX_FILE_SIZE" id="MAX_FILE_SIZE" value="<?php echo $max; ?>" />
                                        <label class="btn btn-default btn-file">
                                            <span>Browse</span>
                                            <!-- The file is stored here. -->
                                            <input type="file" name="filename" id="filename" class="btn btn-default"
                                                   data-maxfiles="<?php echo $_SESSION['maxfiles']; ?>"
                                                   data-postmax="<?php echo $_SESSION['postmax']; ?>"
                                                   data-displaymax="<?php echo $_SESSION['displaymax']; ?>"

                                                />

                                        </label>
                                        <button type="button" class="btn btn-default">Remove</button>
                                    </div>
                                    <div class="url-tab panel-body">
                                        <div class="input-group">
                                            <input type="text" class="form-control hasclear" placeholder="Image URL">
                                            <div class="input-group-btn">
                                                <button type="button" class="btn btn-default">Submit</button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-default">Remove</button>
                                        <!-- The URL is stored here. -->
                                        <input type="hidden" name="image-url">
                                    </div>
                                </div>
                                <button type="button" id="imageupload-disable" class="btn btn-danger">Disable</button>
                                <button type="button" id="imageupload-enable" class="btn btn-success">Enable</button>
                                <button type="button" id="imageupload-reset" class="btn btn-primary">Reset</button>
                            </div>


                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="well">
                            <h4>Post Category</h4>
                            <div id="d_cat">
                                <label for="category">Select from available</label>
                                <select id="category" name="category" class="form-control">
                                    <?php
                                        foreach($this->category as $cat){
                                            ?>

                                            <option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name']; ?></option>
                                        <?php }  ?>                              </select>
                                <br/>
                                <button onclick="show_category()" class="btn btn-warning">Add New</button>

                            </div>
                            <div class="box-body" id="show_cat" style="display: none" >
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="new_category">New Category</label>
                                        <input type="text" class="form-control" id="new_category" name="new_category" placeholder="Enter New Category Name ...">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="cat_parent">Parent</label>

                                    <select id="cat_parent" name="cat_parent" class="form-control">
                                        <option value="0"> None</option>
                                        <?php
                                            foreach($this->category as $cat){
                                                ?>

                                                <option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name']; ?></option>
                                            <?php }  ?>

                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Category Description</label>
                                    <textarea name="category_desc" id="category_desc" class="form-control" rows="8" placeholder="Enter Description here ..."></textarea>
                                </div>
                                <div class="box-footer">
                                    <button type="submit" class="btn btn-warning" onclick="addResource('category',1)">Add Category </button>
                                </div>

                            </div>

                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="well">
                            <h4>Post Tags</h4>



                            <div class="box-body">
                                <div class="form-group">
                                    <div class="form-group">
                                        <label for="used_tags">Select or Create</label>
                                        <div class="form-group"  id="tags">
                                            <select class="form-control select2" multiple="multiple" data-placeholder="Start typing here..." style="width: 100%;" id="used_tags">
                                                <option></option>
                                                <?php
                                                    foreach($this->tags as $tag){
                                                        ?>

                                                        <option value="<?php echo $tag['tag_id']; ?>"><?php echo $tag['tag_name']; ?></option>
                                                    <?php }  ?>                              </select>
                                        </div>

                                        <p class="help-block">Enter tag one by one, Use comma or space to separate tags.</p>

                                    </div>
                                </div>
                                <div class="box-footer">
                                    <div class="form-group">
                                        <p id="tag_holder" class="help-block"></p>
                                    </div>

                                </div>

                            </div>
                            <br/>
                            <!-- /.box-body -->
                        </div>
                    </div>
                </div>

            </div>
            <div class="panel-heading">
                <button type="submit" id="submit" class="btn btn-default btn-lg" onclick="publishPost()">Publish Immediately</button>
                <button onclick="callCrudAction('autosave',1)" class="btn btn-info pull-right">Save as Draft</button>
            </div>
        </div>
        </form>

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
        <p>ADS</p>
    </div>
    <div class="well">
        <p>ADS</p>
    </div>
</div>
</div>
</div>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
    tinymce.init({
        selector:'textarea#post',
        menubar: 'file edit insert view format table tools',


        toolbar: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image || forecolor backcolor emoticons | table',

        plugins: [
            'advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker',
            'searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking',
            'save table contextmenu directionality emoticons template paste textcolor',
            'table'
        ],
        table_default_styles: {
            width: '80%'
        }
    });

</script>

