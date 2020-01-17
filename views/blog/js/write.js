
var maxFileSize =  $('#MAX_FILE_SIZE').val();

var $imageupload = $('.imageupload');
$imageupload.imageupload();
$imageupload.imageupload({
    allowedFormats: [ "jpg", "jpeg", "png", "gif" ],
    previewWidth: 250,
    previewHeight: 250,
    maxFileSize: maxFileSize
});


$('#imageupload-disable').on('click', function() {
    $imageupload.imageupload('disable');
    $(this).blur();
})

$('#imageupload-enable').on('click', function() {
    $imageupload.imageupload('enable');
    $(this).blur();
})

$('#imageupload-reset').on('click', function() {
    $imageupload.imageupload('reset');
    $(this).blur();
});



function show_category(){
    _('show_cat').style.display = "block";
    _('d_cat').style.display = "none";
}
function show_sub_holder(){
    _('sub_holder').style.display = "block";
}



//Initialize Select2 Elements
$(".select2").select2();
$('.select2').select2({
    tags: true,
    maximumSelectionLength: 6,
    tokenSeparators: [",", " "]
}).on("change", function(e) {
    var isNew = $(this).find('[data-select2-tag="true"]');
    if(isNew.length){
        var queryString = 'new_tag=' + isNew.val();
        var url = '../blog/add_resource/tag';
        jQuery.ajax({
            url: url,
            data: queryString,
            type: "POST",
            success: function (data) {
                isNew.replaceWith('<option selected value="'+data+'">'+isNew.val()+'</option>');
                $('#tag_holder').html('New tag: <code>' + isNew.val() + '</code> saved<br>');

            },
            error: function () {
            }
        });

    }
});

/*
//Datepicker
$(function() {
 //   $( ".datepicker" ).datepicker();
//    $( ".datepicker" ).datepicker( "option", "dateFormat","yy-mm-dd");

 $('#datepicker').datepicker({
        autoclose: true
    });

    //set the default date to today
    var monthNames = [
        "January", "February", "March",
        "April", "May", "June", "July",
        "August", "September", "October",
        "November", "December"
    ];
    var monthNo = [1,2,3,4,5,6,7,8,9,10,11,12];

    var date = new Date();
    var day = date.getDate();
    var monthIndex = date.getMonth();
    var year = date.getFullYear();

    //console.log(day, monthNames[monthIndex], year);

    document.getElementById("datepicker1").value =
        year+ '-' +monthNo[monthIndex]+ '-' + day;
});


//Timepicker
$(".timepicker").timepicker({
    showInputs: false
});
*/
var d = new Date();
var timer = d.toLocaleTimeString();
//document.getElementById("timepicker").value = timer;


function convertTo24Hour(time) {
    var hours = parseInt(time.substr(0, 2));
    if(time.indexOf('am') != -1 && hours == 12) {
        time = time.replace('12', '0');
    }
    if(time.indexOf('pm')  != -1 && hours < 12) {
        time = time.replace(hours, (hours + 12));
    }
    return time.replace(/(am|pm)/, '');
}


function callCrudAction(action, id) {
    $("#work_report").text('System is currently saving the work progress...');
    var token = $("#token").val();
    var queryString;
    switch (action) {
        case "autosave":

            var filename = $("#upload_file").val();
            var used_tags = $("#used_tags").val();
            var  date = $("#datepicker1").val();
            //var time = convertTo24Hour($("#timepicker").val().toLowerCase());

            var category = $("#category").val();
            var title = $("#title").val();
            var subtitle = $("#subtitle").val();
            var slug = $("#slug").val();
            var post = tinyMCE.get('post').getContent();

            queryString = 'token=' + token + '&title=' + title + '&slug=' + slug+ '&post=' + post+ '&filename=' + filename+ '&used_tags=' + used_tags+ '&date=' + date+ '&time=' + time+ '&category=' + category+ '&subtitle=' + subtitle;
            var url = '../post/autosave';
            break;

        case "publish":
            var filename = $("#upload_file").val();
            var used_tags = $("#used_tags").val();
            //var  date = $("#datepicker1").val();
            //var time = convertTo24Hour($("#timepicker").val().toLowerCase());

            var category = $("#category").val();
            var title = $("#title").val();
            var subtitle = $("#subtitle").val();
            var slug = $("#slug").val();
            var post = tinyMCE.get('post').getContent();

            queryString = 'token=' + token + '&title=' + title + '&slug=' + slug+ '&post=' + post+ '&filename=' + filename+ '&used_tags=' + used_tags+ '&category=' + category+ '&subtitle=' + subtitle;
            //+ '&date=' + date+ '&time=' + time
            var url = '../blog/post_write/publish';
            break;



    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {

                case "autosave":
                    $("#work_report").text("Work progress has been saved as a draft successfully! "+current_time());
                    break;

                case "publish":
                    $("#work_report").text("Work has been published successfully!");
                    //window.location.replace(data);
                    break;
            }
        },
        error: function () {
        }
    });
}

var myVar = setInterval(function(){callCrudAction('autosave', 1) }, 300000);


setInterval(function(){current_time() }, 1000);
function current_time(){
    var d = new Date();
    var timer = d.toLocaleTimeString();
    return timer;

}

function addResource(action, id) {
    $("#work_report").text('System is currently saving the work progress...');
    var queryString;
    var url;
    switch (action) {
        case "category":

            var new_category = $("#new_category").val();
            var category_desc = $("#category_desc").val();
            var cat_parent = $("#cat_parent").val();

            queryString = 'new_category=' + new_category + '&category_desc=' + category_desc+ '&cat_parent=' + cat_parent;
            var url = '../blog/add_resource/category';
            break;

        case "tag":
            //var new_tag = $("#new_tag").val();
            queryString = 'new_tag=' + id;
            var url = '../blog/add_resource/tag';
            break;

        case "untag":
            $('#tag'+id).remove();

            //var new_tag = $("#new_tag").val();
            //queryString = 'new_tag=' + new_tag;
            //var url = '../blog/add_resource/tag';
            break;



    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {

                case "category":
                    $("#work_report").text("New Category has been saved  successfully! "+current_time());
                    $("#d_cat").show();
                    var child = $('#category').children();
                    child.first().before(data);
                    //empty the input boxes
                    $("#new_category").val('');
                    $("#category_desc").val('');
                    $("#cat_parent").val('');
                    $("#show_cat").hide();
                    break;

                case "tag":

                    //Initialize Select2 Elements
                    $(".select2").select2();
                    $('.select2').select2({
                        tags: true,
                        tokenSeparators: [",", " "]
                    }).on("change", function(e) {
                        var isNew = $(this).find('[data-select2-tag="true"]');
                        if(isNew.length){
                            addResource('tag',isNew.val());

                            isNew.replaceWith('<option selected value="'+isNew.val()+'">'+isNew.val()+'</option>');
                            $('#tag_holder').text('<code>New tag: {"' + isNew.val() + ':"}</code> Saved successfully<br>');
                        }
                    });



                    break;

                case "untag":
                    $('#tag'+id).remove();
                    var child = $('#used_tags').children();
                    //child.first().before(data);
                    child.first().before('<option value="'+id+  '" >' +new_tag+ '</option>');
                    $("#new_tag").val('');
                    break;
            }
        },
        error: function () {
        }
    });
}
/*-----------------------------------The Publisher ---------------------- */

function publishPost(update){
    var url;
    if (update === undefined) {
        url = '../blog/post_write/publish';
    }else{
        url = '../../../blog/upload ';

    }
    var token = _("token").value;
    var category = _("category").value;
    var used_tags = $("#used_tags").val();

    //var used_tags = _("used_tags").value;
    var title = _("title").value;
    var subtitle = _("subtitle").value;
    var slug = _("slug").value;
    var post = tinyMCE.get('post').getContent();

    var file = _("filename").files[0];
    // alert(file.name+" | "+file.size+" | "+file.type);
    var formdata = new FormData();
    formdata.append("upload", file);
    formdata.append("MAX_FILE_SIZE", maxFileSize);
    formdata.append("token", token);
    formdata.append("category", category);
    formdata.append("title", title);
    formdata.append("subtitle", subtitle);
    formdata.append("slug", slug);
    formdata.append("post", post);
    formdata.append("used_tags", used_tags);


    var ajax = new XMLHttpRequest();
    ajax.upload.addEventListener("progress", progressHandler, false);
    ajax.addEventListener("load", completeHandler, false);
    ajax.addEventListener("error", errorHandler, false);
    ajax.addEventListener("abort", abortHandler, false);
    ajax.open("POST", url);
    ajax.send(formdata);
}
function progressHandler(event){
    //_("loaded_n_total").innerHTML = "Uploaded "+event.loaded+" bytes of "+event.total;
    var percent = (event.loaded / event.total) * 100;
    // _("progressBar").value = Math.round(percent);
    _("work_report").innerHTML = Math.round(percent)+"% uploaded... please wait";
}
function completeHandler(event){
    //_("upload_file").value = event.target.responseText;
    //_("progressBar").value = 0;
    console.log('the page to load is '+event.target.responseText);
    var page = '../'+event.target.responseText;
    window.location.assign(page);

    _("work_report").innerHTML = "Image Upload Successful!";
    //_("status_btn").style.display = "none";
    //$("#status_btn").hide();

}
function errorHandler(event){
    _("status").text = "Upload Failed";
}
function abortHandler(event){
    _("status").text = "Upload Aborted";
}