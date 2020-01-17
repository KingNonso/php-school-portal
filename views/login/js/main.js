function Login(){
    var email = _("email").value;
    var password = _("password").value;
    if(_("login_me").checked){
        var login_me = _("login_me").value;
    }else{
        var login_me = false;
    }
    if(email == "" || password ==""){
    _("status").innerHTML = '<h2 class="btn btn-danger"> Please Fill out the form data </h3>';
    } else {
        _("submit").style.display = "none";
        //_("status").style.display = "block";
    _("status").innerHTML = '<h2 class="btn btn-default">Please wait ...<h3>';
        var queryString;
        queryString = "login_email="+email+"&login_pwd="+password+"&login_me="+login_me;
        console.log(queryString);
        jQuery.ajax({
            url: 'login/run',
            data: queryString,
            type: "POST",
            success: function (data) {
                switch (data) {

                    case "success":
                        _("status").innerHTML = '<h2 class="btn btn-success "> Login in ...<h3>';
                        //get the protocol
                        var protocol = window.location.protocol;
                        //get the hostname
                        var host = window.location.hostname;
                        //get the pathname
                        var path = window.location.pathname;
                        //get where to redirect to
                        var page = 'wall';
                        //now go there protocol+host+path+
                        window.location.assign(page);
                        break;
                    case "no_match":
                        _("status").innerHTML = '<h2 class="btn btn-warning "> Username/password combination is incorrect.<br />Please make sure your caps lock key is off and try again..<h3>';
                        _("submit").style.display = "block";

                        break;
                }
            },
            error: function () {
                _("status").innerHTML = '<h3 class="btn btn-warning ">There seems to be a problem submitting ...</h3>';
                _("submit").style.display = "block";

            }
        });


}
}
