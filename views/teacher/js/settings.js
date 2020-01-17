//Datepicker
$(function() {
    $( "#datepicker" ).datepicker({
        changeMonth: true,
        changeYear: true,
        yearRange: '-2:+5', // last hundred years
        maxDate: "+2y" //The maximum selectable date. When set to null, there is no maximum
        //"y" for years, "m" for months, "w" for weeks, and "d" for days. For example, "+1m +7d" represents one month and seven days from today.
    });
    $( "#datepicker" ).datepicker( "option", "dateFormat", "yy-mm-dd");
});

function startRecord(action, id) {
    //$("#loaderIcon").show();
    var queryString;
    var url;
    var date = new Date();
    //date = date.replace(/ /g,'T');
    switch (action) {
        case "term":
            var entry_session = $("#entry_session").val(); //for name
            queryString = 'entry_session='+entry_session ;
            url = '../../result/retrieve/term';
            break;

        case "class":
            var find_session = $("#find_session").val(); //for session
            var find_class = $("#select_class").val(); //for class
            queryString = 'find_session='+find_session + '&class=' + find_class ;
            url = '../teacher/retrieveClassSubjects';
            break;

    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {
                case "term":
                    $("#entry_term").html(data);

                    break;
                case "class":
                    $("#select_subject").html(data);

                    break;

            }

        },
        error: function () {
        }
    });
}


$('#createClass').hide();
$('#creatingClass').hide();

//Initialize Select2 Elements
$(".select2").select2();
$('.select2').select2({
    tags: true,
    maximumSelectionLength: 20,
    tokenSeparators: [",", " "]
}).on("change", function(e) {
    //var isNew = $(this).find('[data-select2-tag="true"]');

});



function resumptionCreator(all) {
    var createClassStep = $(".createClassStep");
    var creatingClass = $("#creatingClass");
    createClassStep.fadeOut();
    creatingClass.fadeIn();

    var queryString;
    var url;
    var datepicker = $("#datepicker").val();
    var entry_session = $("#entry_session").val();
    var entry_term = $("#entry_term").val();
    var note = $("#note").val();
    var classes = $("#classes").val();
    queryString = 'datepicker='+datepicker+'&entry_session='+entry_session+'&entry_term='+entry_term+'&note='+note+'&classes='+classes;
    url = '../../teacher/resumptionCreator/'+all;
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            var newURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;
            window.location.assign(newURL);

        },
        error: function () {
        }
    });

    creatingClass.fadeOut();
    createClassStep.fadeIn();
    $("#entry_session").val('');
    $("#entry_term").val('');
    $("#note").val('');
    $("#classes").val('');
    $(".select2").select2();

}

function schoolFeesCreator(all) {
    var createClassStep = $(".createClassStep");
    var creatingClass = $("#creatingClass");
    createClassStep.fadeOut();
    creatingClass.fadeIn();

    var queryString;
    var url;
    var amount = $("#amount").val();
    var entry_session = $("#entry_session").val();
    var entry_term = $("#entry_term").val();
    var note = $("#note").val();
    var classes = $("#classes").val();
    queryString = 'amount='+amount+'&entry_session='+entry_session+'&entry_term='+entry_term+'&note='+note+'&classes='+classes;
    url = '../../teacher/schoolFeesCreator/'+all;
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            var newURL = window.location.protocol + "//" + window.location.host + "/" + window.location.pathname;
            window.location.assign(newURL);

        },
        error: function () {
        }
    });

    creatingClass.fadeOut();
    createClassStep.fadeIn();
    $("#entry_session").val('');
    $("#entry_term").val('');
    $("#note").val('');
    $("#classes").val('');
    $(".select2").select2();

}
