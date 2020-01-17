
function login_box(){

    var login_email = _("login_email").value;
    var login_pwd = _("login_pwd").value;

    if(_("login_me").checked){
        var login_me = _("login_me").value;
    }else{
        var login_me = false;
    }

    if(login_email == "" || login_pwd == "" ){
        _("login_status").innerHTML = '<h3> Please, Enter your login credentials. </h3>';

    } else{

            emptyElement('status');
            _("login_submit").style.display = "none";
            _("login_status").innerHTML = '<h3>Processing... Please wait ...<h3>';
            var ajax = ajaxObj("POST", "login/run");

            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText == 'success'){
                        //get where to redirect to
                        var page = 'wall'; //first for first timers online
                        window.location.assign(page);

                    } else {
                        if(ajax.responseText == 'no_match'){
                            _("login_status").innerHTML = '<h3 class="error-code">Your email and password do not match</h3>';
                        }else{
                            _("login_status").innerHTML = '<h3 class="error-code">There seems to be a problem submitting ...</h3><p>'+ajax.responseText+'</p>';
                        }

                        _("login_submit").style.display = "block";
                    }
                }
            }
            ajax.send("login_email="+login_email+"&login_pwd="+login_pwd+"&login_me="+login_me);

    }


}

function juke_vox(){

    var new_login_email = _("new_login_email").value;
    var new_login_device = _("new_login_device").value;
    var new_login_pwd = _("new_login_pwd").value;
    var new_login_confirm_pwd = _("new_login_confirm_pwd").value;
    var current_stat = _("current_stat").value;

    if(_("new_login_device").checked){
        var new_login_device = _("new_login_device").value;
    }else{
        var new_login_device = false;
    }

    if(new_login_pwd == "" || new_login_confirm_pwd == "" ){
        _("new_login_status").innerHTML = '<h3> Please, Your passwords field cannot be empty. </h3>';

    } else{

        emptyElement('new_login_status');
        if(new_login_pwd !== new_login_confirm_pwd){
            _("new_login_status").innerHTML = '<h3> Please, Your Passwords do not match. </h3>';

        }else{

            emptyElement('new_login_status');
            _("new_login_btn").style.display = "none";
            _("new_login_status").innerHTML = '<h3>Processing... Please wait ...<h3>';
            var ajax = ajaxObj("POST", "winner/new_member3");

            ajax.onreadystatechange = function() {
                if(ajaxReturn(ajax) == true) {
                    if(ajax.responseText == 'done'){
                        //get where to redirect to
                        var page = 'wall/first'; //first for first timers online
                        window.location.assign(page);

                    } else {
                        _("new_login_status").innerHTML = '<h3 class="error-code">There seems to be a problem submitting ...</h3><p>'+ajax.responseText+'</p>';
                        _("new_login_btn").style.display = "block";
                    }
                }
            }
            ajax.send("new_login_email="+new_login_email+"&new_login_device="+new_login_device+"&new_login_pwd="+new_login_pwd+"&new_login_confirm_pwd="+new_login_confirm_pwd+"&current_stat="+current_stat);

        }
    }


}

function bornAgain() {
    var born_again_status = _("born_again_status").value;
    if(born_again_status ==='yes'){
        _("born_again").style.display = "block";
        //Datepicker
        $(function() {
            $( "#datepicker" ).datepicker({
                changeMonth: true,
                changeYear: true,
                //yearRange: '1950:2013', // specifying a hard coded year range
                yearRange: '-50:+0', // last 50 years
                maxDate: "+0d" //The maximum selectable date. When set to null, there is no maximum
                //minDate: new Date(2007, 1 - 1, 1)
                //"y" for years, "m" for months, "w" for weeks, and "d" for days. For example, "+1m +7d" represents one month and seven days from today.
            });
            $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
            $( "#datepicker" ).datepicker( "setDate", "2012-12-12" );
        });
    }else{
        _("born_again").style.display = "none";
    }
}

function newConvert(){
    var new_convert_first_name = _("new_convert_first_name").value;
    var new_convert_last_name = _("new_convert_last_name").value;
    var new_convert_phone = _("new_convert_phone").value;
    var new_convert_sex = _("new_convert_sex").value;
    var new_convert_person = _("new_convert_person").value;
    var new_convert_need = _("new_convert_need").value;
    var new_convert_address = _("new_convert_address").value;
    var converter_pass = _("converter_pass").value;
    if(new_convert_last_name == "" || new_convert_phone == "" || new_convert_sex == "" ){
        _("status").innerHTML = '<h3> Please Fill out the form data </h3>';
    } else {
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Please wait ...<h3>';
        var ajax = ajaxObj("POST", "winner/new_convert");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText == "converted"){
                    _("new_convert_form").innerHTML = '<div class="row"><div class="col-sm-12"><h1>Your New Convert details has been successfully submitted...</h1><p>Thank You and God Bless</p></div></div>';

                } else {
                    _("status").innerHTML = '<h3 class="error-code">There seems to be a problem submitting ...</h3><p>'+ajax.responseText+'</p>';
                    _("submit").style.display = "block";
                }
            }
        }
        ajax.send("new_convert_first_name="+new_convert_first_name+"&new_convert_last_name="+new_convert_last_name+"&new_convert_phone="+new_convert_phone+"&new_convert_sex="+new_convert_sex+"&new_convert_person="+new_convert_person+"&new_convert_need="+new_convert_need+"&new_convert_address="+new_convert_address+"&converter_pass="+converter_pass);

    }

}

function testimony_time(){
    var testimony_phone = _("testimony_phone").value;
    var testifier_email = _("testifier_email").value;
    var testifier_fname = _("testifier_fname").value;
    var testifier_lname = _("testifier_lname").value;
    var testifier_church = _("testifier_church").value;
    var testifier_church_id = _("testifier_church_id").value;
    var testifier_place = _("testifier_place").value;
    var testifier_subject = _("testifier_subject").value;
    var testifier_msg = _("testifier_msg").value;
    var testifier_user_id = _("testifier_user_id").value;

    if(testimony_phone == "" || testifier_msg == "" || testifier_subject == "" ){
        _("testimony_status").innerHTML = '<h3> Please Fill out the form data </h3>';
    } else {
        _("testimony_submit").style.display = "none";
        _("testimony_status").innerHTML = '<h3>Please wait ...<h3>';
        var ajax = ajaxObj("POST", "winner/testimony_time");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText == "submitted"){
                    _("testimonials").innerHTML = '<div class="row"><div class="col-sm-12"><h1>Your Testimony has been successfully submitted...</h1><p class="glyphicon glyphicon-ok jumbosmall"></p><p>Thank You and God Bless</p></div></div>';

                } else {
                    _("testimony_status").innerHTML = '<h3 class="error-code">There seems to be a problem submitting ...</h3><p>'+ajax.responseText+'</p>';
                    _("testimony_submit").style.display = "block";
                }
            }
        }
        ajax.send("testimony_phone="+testimony_phone+"&testifier_email="+testifier_email+"&testifier_fname="+testifier_fname+"&testifier_lname="+testifier_lname+"&testifier_church="+testifier_church+"&testifier_church_id="+testifier_church_id+"&testifier_place="+testifier_place+"&testifier_subject="+testifier_subject+"&testifier_msg="+testifier_msg+"&testifier_user_id="+testifier_user_id);

    }

}

function newMember(){
    var firstname = _("firstname").value;
    var surname = _("surname").value;
    var othername = _("othername").value;
    var marital_status = _("marital_status").value;
    var phone_no = _("phone_no").value;
    var email = _("new_member_email").value;
    var occupation = _("occupation").value;
    var sex = _("sex").value;
    var nationality = _("nationality").value;
    var state_origin = _("state_origin").value;
    var full_addy = _("full_addy").value;
    var country = _("country").value;
    var state = _("state").value;
    var lga = _("lga").value;
    var born_again_status = _("born_again_status").value;
    if(born_again_status ==='yes'){
        var datepicker = _("datepicker").value;
        var location = _("location").value;

        if(datepicker == "" || location == "" ){
            _("status").innerHTML = '<h3> Please, let us know your date and place of birth. </h3>';
        } else{
            emptyElement("status");
        }
    }
    if(firstname == "" || phone_no == "" || state == "" ){
        _("status").innerHTML = '<h3> Please Fill out the form data </h3>';
    } else {
        _("submit").style.display = "none";
        _("status").innerHTML = '<h3>Processing... Please wait ...<h3>';
        var ajax = ajaxObj("POST", "winner/new_member");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText){
                    _("new_member").innerHTML = ajax.responseText;

                    //Datepicker
                    $(function() {
                        $( "#church_date" ).datepicker({
                            changeMonth: true,
                            changeYear: true,
                            //yearRange: '1950:2013', // specifying a hard coded year range
                            yearRange: '-50:+0', // last 50 years
                            maxDate: "+0d" //The maximum selectable date. When set to null, there is no maximum
                            //minDate: new Date(2007, 1 - 1, 1)
                            //"y" for years, "m" for months, "w" for weeks, and "d" for days. For example, "+1m +7d" represents one month and seven days from today.
                        });
                        $( "#church_date" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
                        $( "#church_date" ).datepicker( "setDate", "2012-12-12" );
                    });


                } else {
                    _("status").innerHTML = '<h3 class="error-code">There seems to be a problem submitting ...</h3><p>'+ajax.responseText+'</p>';
                    _("submit").style.display = "block";
                }
            }
        }
        ajax.send("firstname="+firstname+"&surname="+surname+"&othername="+othername+"&marital_status="+marital_status+"&phone_no="+phone_no+"&email="+email+"&occupation="+occupation+"&sex="+sex+"&nationality="+nationality+"&state_origin="+state_origin+"&full_addy="+full_addy+"&country="+country+"&state="+state+"&lga="+lga+"&born_again_status="+born_again_status+"&datepicker="+datepicker+"&location="+location);

    }

}

function newMember2(){
    var user = _("user").value;
    var church = _("church").value;
    var wsf_centre = _("wsf_centre").value;
    var unit = _("unit").value;
    var service_time = _("service_time").value;
    var prayer_point = _("prayer_point").value;
    var certificate = _("certificate").value;
    var baptized = _("born_again_status").value;

    if(baptized ==='yes'){
        var datepicker = _("datepicker").value;
        var location = _("location").value;

        if(datepicker == "" || location == "" ){
            _("new_member_status").innerHTML = '<h3> Please, let us know your date and place of birth. </h3>';
        } else{
            emptyElement('new_member_status');
        }
    }
    if(church == "" ){
        _("new_member_status").innerHTML = '<h3> Please Fill out the form data </h3>';
    } else {
        _("new_member_submit").style.display = "none";
        _("new_member_status").innerHTML = '<h3>Processing... Please wait ...<h3>';
        var ajax = ajaxObj("POST", "winner/new_member2");
        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(ajax.responseText){
                    _("new_member").innerHTML = ajax.responseText;

                } else {
                    _("new_member_status").innerHTML = '<h3 class="error-code">There seems to be a problem submitting ...</h3><p>'+ajax.responseText+'</p>';
                    _("new_member_submit").style.display = "block";
                }
            }
        }
        ajax.send("user="+user+"&church="+church+"&wsf_centre="+wsf_centre+"&unit="+unit+"&service_time="+service_time+"&prayer_point="+prayer_point+"&certificate="+certificate+"&baptized="+baptized+"&datepicker="+datepicker+"&location="+location);

    }

}


