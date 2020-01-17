function toggle(id){
    $("div#"+id).slideToggle();
}

var filename = document.getElementById("filename");
filename.addEventListener("change", changePost, false);

function changePost(){
    document.getElementById("post").innerHTML = '<button type="submit" class="btn btn-default btn-sm" onclick="picturePost()"><span class="glyphicon glyphicon-pencil"></span> Post</button>';
}

function callCrudAction(action, id) {
    //$("#loaderIcon").show();
    var queryString;
    var url;
    var date = new Date();
        //date = date.replace(/ /g,'T');
    switch (action) {
        case "post":
            var main_post = $("#post_message").val(); //for post

            queryString = 'action=' + action + '&picture='+id + '&message=' + main_post+'&date=' + date;
             url = 'wall/post';
            break;

        case "comment":
            var test = $("#txtmessage" + id).val(); //for comments
            queryString = 'action=' + action + '&txtmessage=' + test + '&post_id=' + id+'&date=' + date;
             url = "wall/comment";
            break;

        case "react":
            $("[data-toggle='popover']").popover('hide');
            $('#toggle-reply' + id).replaceWith('<a href="javascript:void(0);" class="btn" onClick="toggle(\'reply2comment'+id+')" data-toggle="popover" data-trigger="hover" data-content="You just reacted"  id="toggle-reply'+ id+'"><span class="glyphicon glyphicon-share-alt"></span></a>');

            var test = $("#reactMsg" + id).val(); //for comments
            queryString = 'action=' + action + '&txtmessage=' + test + '&reply_id=' + id;
            var url = "wall/react";
            break;

        case "delete_post":
            //alert('post delete');
            queryString = 'action=' + action + '&post_id=' + id;
            var url = "wall/delete/post/"+id;
            break;

        case "delete_comment":
            queryString = 'action=' + action + '&comment_id=' + id;
            var url = "wall/delete/comment/"+id;
            break;

        case "like_post":
            $('#like-btn' + id).replaceWith('<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'unlike_post\','+id+')" title="Like it" id="like-btn'+ id+'"><span class="glyphicon glyphicon-thumbs-down"></span> Unlike</a>');

            queryString = 'action=' + action + '&post_id=' + id;
            var url = "wall/like/post/"+id;
            break;

        case "unlike_post":
            $('#like-btn' + id).replaceWith('<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'like_post\','+id+')" title="Like it" id="like-btn'+ id+'"><span class="glyphicon glyphicon-thumbs-up"></span> Like</a>');

            queryString = 'action=' + action + '&post_id=' + id;
            var url = "wall/unlike/post/"+id;
            break;

        case "like_reply":
            $("[data-toggle='popover']").popover('hide');
            $('#like-reply' + id).replaceWith('<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'unlike_reply\','+id+')" data-toggle="popover" data-trigger="hover" data-content="Unlike" title=" You like this"  id="like-reply'+ id+'"><span class="glyphicon glyphicon-thumbs-down"></span></a>');

            queryString = 'action=' + action + '&post_id=' + id;
            var url = "wall/like/reply/"+id;
            break;

        case "unlike_reply":
            $("[data-toggle='popover']").popover('hide');
            $('#like-reply' + id).replaceWith('<a href="javascript:void(0);" class="btn btn-default btn-sm" onClick="callCrudAction(\'like_reply\','+id+')"  data-toggle="popover" data-trigger="hover" data-content="Like"  id="like-reply'+ id+'"><span class="glyphicon glyphicon-thumbs-up"></span></a>');

            queryString = 'action=' + action + '&post_id=' + id;
            var url = "wall/unlike/reply/"+id;
            break;

    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {

                case "post":
                    $("#wall_post").fadeIn().after(data);
                    $("#post_message").val('');
                    $("#filename").val('');
                    $('#output').empty();

                    break;
                case "comment":
                    //$("div#all_replies"+id).slideDown();
                    $("#post-reply" + id).fadeIn().before(data);
                    $("span#reply-count" + id).text(function (i, origText) {
                        if (isNaN(parseInt(origText))) {
                            return  1;// + " Comment";
                        } else {
                            var sum = parseInt(origText) + 1;
                            return sum; // + " Comments";
                        }

                    });

                    break;
                case "react":
                    $("#input_reply" + id).fadeIn().before(data);
                    $("span#reply-count" + id).text(function (i, origText) {
                        if (isNaN(parseInt(origText))) {
                            return  1;// + " Comment";
                        } else {
                            var sum = parseInt(origText) + 1;
                            return sum+ " Replies"; // ;
                        }

                    });

                    break;
                case "delete_post":
                    $('#post_holder' + id).fadeOut();
                    break;

                case "delete_comment":
                    $('#reply' + id).fadeOut();
                    //var parents = $('#reply' + id).parentsUntil("#father");
                    //var wanted = parents.find('a.view_comment');
                    //var link = wanted.attr('id');
                    $("span#reply-count" + data).text(function (i, origText) {

                        var sum = parseInt(origText) - 1;
                        return sum; // + " Comments"

                    });
                    break;

                case "like_post":
                    $('#like-count' + id).replaceWith(data);
                    break;

                case "unlike_post":
                    $('#like-count' + id).html(data);
                    break;

                case "like_reply":
                    $('#like-count' + id).replaceWith(data);
                    break;

                case "unlike_reply":
                    $('#like-count' + id).html(data);
                    break;

            }
            //$('.liveTime').liveTimeAgo();
            $('[data-toggle="popover"]').popover();
            $("#reactMsg" + id).val('');
            $("#txtmessage" + id).val('');

            $("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}
/*******************************Not Used yet */
function toggle_visibility(show, hide) {
    $("div#"+hide).hide();
    $("div#"+show).slideDown();
    return false;
}
