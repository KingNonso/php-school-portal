function request_friendship(from, to){
    var person_state = _("person_state").value;
    var interests = _("interests").value;

    if(person_state == "" || interests == "" ){
        _("status").innerHTML = '<h3> Please, form fields cannot be empty. </h3>';

    } else{

        emptyElement('status');
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Processing... Please wait ...<h3>';
        var ajax = ajaxObj("POST", "../wall/member_status");

        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if((ajax.responseText) == 'error'){
                    _("status").innerHTML = '<h3 class="error-code">There seems to be a problem updating your profile ...</h3>';

                    _("status").style.display = "block";
                } else {
                    uploadFile(ajax.responseText);
                }
            }
        }
        ajax.send("person_state="+person_state+"&interests="+interests);

    }


}

