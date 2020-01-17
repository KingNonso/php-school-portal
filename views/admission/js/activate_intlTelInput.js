
$(document).ready(function(){
    var url = $('#url_path').val();
    //var modal = $('#insert-modal');

    $("#telephone, #convert_telephone, #testifier_telephone").intlTelInput({
        // allowDropdown: false,
        // autoHideDialCode: false,
        // autoPlaceholder: false,
        dropdownContainer: "body",
        // excludeCountries: ["us"],
        // geoIpLookup: function(callback) {
        //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {
        //     var countryCode = (resp && resp.country) ? resp.country : "";
        //     callback(countryCode);
        //   });
        // },
        initialCountry: "ng",
        // nationalMode: false,
        numberType: "MOBILE",
        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],
        preferredCountries: ['ng','us','gb','gh'],
        // separateDialCode: true,
        utilsScript: url+'public/custom/phone/js/utils.js'
    });



    //populateCountries("country", "state","lga");
    //populateCountries("nationality", "state_origin");

});

function intlNumber(){
    // Get the current number in the given format
    var intlNumber = $("#telephone").intlTelInput("getNumber");

    var str = intlNumber;
    var re = /^\+234\d+$/; //check if it is a nigerian no
    var res = str.replace("+", "");
    if(re.test(str)){
        $("#phone_number").val(res);
        checkNumber(res);
    }else{
        _("call_center_status").innerHTML = 'The input a valid Phone number';
        _("call_center").style.backgroundColor = "red";
    }

}

function checkNumber(phone){
    var ajax = ajaxObj("POST", "../../login/check_details/phone_number");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            //var str = ajax.responseText;
            //str = str.replace(/\s+/g,'');
            jQuery.trim(ajax.responseText);
            if(jQuery.trim(ajax.responseText) === "detail_ok"){
                _("call_center_status").style.color = "blue";
                _("call_center_status").innerHTML = 'An SMS will be sent to this phone number soon!';

            } else {
                _("call_center_status").innerHTML = 'The Phone number already exists';
                _("call_center").style.backgroundColor = "red";
                _("call_center_status").style.color = "red";
            }
        }
    }
    ajax.send("phone_number="+phone);

}

function checkEmail(email){
    //var email = $("#email").val();
    var ajax = ajaxObj("POST", "../../login/check_details/email");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            //var str = ajax.responseText;
            //str = str.replace(/\s+/g,'');
            jQuery.trim(ajax.responseText);
            if(jQuery.trim(ajax.responseText) === "detail_ok"){
                _("email_center_status").style.color = "blue";
                _("email_center_status").innerHTML = 'A mail will be sent to this Email soon, please click on the link or copy and paste it in your browser\'s address bar!';
                _("email_center").style.backgroundColor = "";
            } else {
                _("email_center_status").innerHTML = 'The Email already exists';
                _("email_center").style.backgroundColor = "red";
                _("email_center_status").style.color = "red";
            }
        }
    }
    ajax.send("email="+email);

}

function login_box(){
    //var recaptcha = _("g-recaptcha-response").value;
    var recaptcha = 1234567890;
    var email = _("email").value;
    var record_tracker = _("record_tracker").value;
    var phone_number = _("phone_number").value;
    var password = _("password").value;
    var password_again = _("password_again").value;
    var owner_is = _("owner_is").value;
    //var account_is = _("account_is").value;
    var agreement_2_terms = false;
    if(_("agreement_2_terms").checked){
         agreement_2_terms = _("agreement_2_terms").value;
    }else{
        _("login_status").innerHTML = '<h3> You must accept the terms and conditions to proceed. </h3>';
    }

    if(password !== password_again || password === ''){
        _("login_status").innerHTML = '<h3> Please, Your passwords do not match. </h3>';
    }
    if(email == "" || phone_number == "" ){
        _("login_status").innerHTML = '<h3> Please, Enter your login credentials. </h3>';
    } else{
        emptyElement('login_status');
        _("login_submit").style.display = "none";
        _("login_status").innerHTML = '<h3>Processing... Please wait ...<h3>';
        var ajax = ajaxObj("POST", "../../login/account_setup");

        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if(jQuery.trim(ajax.responseText) == 'success'){
                    //trigger modal here
                    $("#myModal").modal();
                } else {
                    _("login_status").innerHTML = '<h3 class="error-code">There seems to be a problem with your submission/ Verification process</h3><p>'+ajax.responseText+'</p>';
                    _("login_submit").style.display = "block";
                }
            }
        }
        ajax.send("email="+email+"&phone_number="+phone_number+"&password="+password+"&password_again="+password_again+"&owner_is="+owner_is+"&recaptcha="+recaptcha+"&agreement_2_terms="+agreement_2_terms+"&record_tracker="+record_tracker);//
    }
}

function checkCode(){
    var code = $("#code").val();
    var ajax = ajaxObj("POST", "../../login/check_details/code");
    ajax.onreadystatechange = function() {
        if(ajaxReturn(ajax) == true) {
            //var str = ajax.responseText;
            //str = str.replace(/\s+/g,'');
            jQuery.trim(ajax.responseText);
            if(jQuery.trim(ajax.responseText) === "detail_ok"){
                //get where to redirect to
                var page = '../../admission/step/done'; //first for first timers online
                window.location.assign(page);

            } else {
                _("email_center_status").innerHTML = 'The Email already exists';
                _("email_center").style.backgroundColor = "red";
                _("email_center_status").style.color = "red";
            }
        }
    }
    ajax.send("code="+code);

}
