function Commentator(){
    var recaptcha = _("g-recaptcha-response").value;
    //var recaptcha = 12345;
    var name = _("name").value;
    var token = _("token").value;
    var email = _("email").value;
    var subscribe = _("subscribe").value;
    var message = _("message").value;
    var post_id = _("post_id").value;
    if(email == "" || name == "" || message == "" ){
        _("status").innerHTML = '<h3> Please Fill out the form data </h3>';
    } else {
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Please wait ...<h3>';
        //you can only comment on a specific post in a yy/mm/dd
        var ajax = ajaxObj("POST", "post/comment");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText == "success"){
                    _("comment_form").innerHTML = '<header><div class="title"><h4>'+name+'</h4><blockquote>'+message+'</blockquote></div><div class="meta"><time class="published" datetime="'+current_time()+'">'+current_time()+'</time><a href="#" class="author"><span class="name">'+name+'</span><img src="'+put_image()+'"/></a></div></header>';

                }else if(ajax.responseText == "bad_subscriber"){
                    _("comment_form").innerHTML = '<header><div class="title"><h4>'+name+'</h4><blockquote>'+message+'</blockquote></div><div class="meta"><time class="published" datetime="'+current_time()+'">'+current_time()+'</time><a href="#" class="author"><span class="name">'+name+'</span><img src="'+put_image()+'"/></a></div></header><p>There seems to be a problem though with your subscription. This email might have been used by someone else</p>';
                } else {
                    _("status").innerHTML = '<h3>There seems to be a problem submitting ...</h3>';
                    _("submit").style.display = "block";
                }
            }
        }
        ajax.send("email="+email+"&recaptcha="+recaptcha+"&token="+token+"&name="+name+"&subscribe="+subscribe+"&post_id="+post_id+"&message="+message);

    }
}
function emptyElement(x){
    _(x).innerHTML = "";
}

function current_time(){
    var d = new Date();
    return d.toLocaleTimeString();
}

function put_image(){
    var x = document.images.namedItem("image_path").src;
//document.getElementById("demo").innerHTML = x;
    return(x);
}