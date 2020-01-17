/**
 * Created by King on 29/10/17.
 */

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


function selectClass(class_type){
    $('#selectClass').hide();
    $('#createClass').show();
    $('.box-title').text('Create '+class_type+' Classrooms');
    $('#classType').val(class_type);

}

function classSubjectCreator(action, id) {
    var createClassStep = $(".createClassStep");
    var creatingClass = $("#creatingClass");
    createClassStep.fadeOut();
    creatingClass.fadeIn();

    var queryString;
    var url;
    var subject_name = $("#subject_name").val();
    var subject_alias = $("#subject_alias").val();
    queryString = 'subject_name='+subject_name+'&subject_alias='+subject_alias;
    url = '../teacher/classSubjectCreator';
    switch (action) {
        case "all":
            queryString += '';
            url += '/ALL';
            break;

        case "jss":
            queryString += '';
            url += '/JSS';
            break;

        case "ss":
            queryString += '';
            url += '/SS';
            break;

        case "class":
            var classes = $("#classes").val();
            queryString += '&classes='+classes;
            url += '/class';
            break;



    }
    jQuery.ajax({
        url: url,
        data: queryString,
        type: "POST",
        success: function (data) {
            switch (action) {

            }

        },
        error: function () {
        }
    });

    creatingClass.fadeOut();
    createClassStep.fadeIn();
    $("#classes").val('');
    $("#subject_name").val('');
    $("#subject_alias").val('');
    $(".select2").select2();

}
