
function request_friendship(viewer,owner){
    _("friend_btn").innerHTML = '<h3> Please wait... </h3>';

    var ajax = ajaxObj("POST", "../../profile/request_friendship");

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if((ajax.responseText) == 'error'){
                _("friend_btn").innerHTML = '<h3 class="error-code">There seems to be an error ...</h3>';

            } else {
                _("friend_btn").innerHTML = '<h3 class="bg-success">Request has been successfully sent</h3>';
            }
        }
    }
    ajax.send("viewer="+viewer+"&owner="+owner);


}

function accept_friendship(response,id){
    console.log('response is '+response+ 'and id is '+id);
    _("friend_response").innerHTML = '<h3> Please wait... </h3>';

    var ajax = ajaxObj("POST", "../../profile/friendship_response");

    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            if((ajax.responseText) == 'declined'){
                _("friend_response").innerHTML = '<h3 class="error-code">OOps declined ...</h3>';

            } else {
                _("friend_response").innerHTML = '<h3 class="bg-success">Write on persons wall</h3>';
            }
        }
    }
    ajax.send("response="+response+"&match="+id);


}





