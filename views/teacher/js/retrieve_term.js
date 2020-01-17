/**
 * Created by Nonny on 1/11/17.
 */

function insert_found(){
    var ses = $("#find_session").val(); //for session
    var cls = $("#find_class").val(); //for class
    var reg = $("#found_reg_no").val(); //for reg

    $("#student_id").val(reg);
    $("#find_student_reg_no").modal("hide");
}

function retrieve_reg_no(action, id) {
    //$("#loaderIcon").show();
    var queryString;
    var url;
    var date = new Date();
    //date = date.replace(/ /g,'T');
    switch (action) {
        case "term":
            var entry_session = $("#entry_session").val(); //for name
            queryString = 'entry_session='+entry_session ;
            url = '../../../result/retrieve/term';
            break;

        case "class":
            var find_session = $("#find_session").val(); //for session
            var find_class = $("#find_class").val(); //for class
            queryString = 'find_session='+find_session + '&find_class=' + find_class ;
            url = '../../../result/retrieve/class';
            break;

        case "name":
            var name_id = $("#find_name").val(); //for name
            queryString = 'name_id='+name_id ;
            url = '../../../result/retrieve/name';
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
                    $("#find_name").html(data);

                    break;

                case "name":
                    $("#ur_reg_no").text('Retrieved Reg No is: '+data);
                    $("#found_reg_no").val(data);

                    break;

            }

            //$("#loaderIcon").hide();
        },
        error: function () {
        }
    });
}

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
            url = '../result/retrieve/term';
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

