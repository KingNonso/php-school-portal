
function editable(field,record, type){
    var text = "record_"+field+"_"+record;
    //get text from the field
    var value = $("#record_"+field+"_"+record).text();
    // Store
    localStorage.setItem("lastValue", value);
    //create a html element
    var element = (type == 'text')? '' : 'onkeyup="autoEditTotal('+field+')"';
    var html = '<td><input type="text" name="'+text+'" id="'+text+'" value="'+value+'" class="form-control" '+element+' onblur="UpdateRecord('+field+',\''+(record)+'\',\''+type+'\')"></td>';
    //send to client
    $("#record_"+field+"_"+record).replaceWith(html);

}

function return2Table(field,record,type){
    var text = "record_"+field+"_"+record;
    var value = $("#record_"+field+"_"+record).val();
    if(value == ''){
        value = '---';
    }
    var html = '<td id="'+text+'" ondblclick="editable('+field+',\''+record+'\',\''+type+'\')">'+value+'</td>';

    $("#record_"+field+"_"+record).parent().replaceWith(html);

}

function autoTotal(){
    var new_record_ca = document.getElementById("new_record_ca").value ? document.getElementById("new_record_ca").value : 0;
    var new_record_exam = document.getElementById("new_record_exam").value ? document.getElementById("new_record_exam").value : 0 ;

    var sum = parseInt(new_record_ca) + parseInt(new_record_exam);
    $("#new_record_total").val(sum);
}

function autoEditTotal(field){
    var record_ca = "record_"+field+"_ca";
    var record_exam = "record_"+field+"_exam";

    var new_record_ca = document.getElementById(record_ca).value ? document.getElementById(record_ca).value : document.getElementById(record_ca).innerHTML;
    if(!(new_record_ca)){ new_record_ca = 0;}

    var new_record_exam = document.getElementById(record_exam).value ? document.getElementById(record_exam).value : document.getElementById(record_exam).innerHTML;
    if(!(new_record_exam)){ new_record_exam = 0;}

    var sum = parseInt(new_record_ca) + parseInt(new_record_exam);

    $("#record_"+field+"_total").text(sum);
}

function addNewRow(){
    var html =
        '<tr id="newAdder">'+
            '<td><input type="text" class="form-control" name="new_record_surname" id="new_record_surname" placeholder="Surname"></td>'+
            '<td><input type="text" class="form-control" name="new_record_othername" id="new_record_othername" placeholder="First Name - Middle Name"></td>'+
            '<td><input type="text" class="form-control" name="new_record_ca" id="new_record_ca" placeholder="CA" onkeyup="autoTotal()"></td>'+
            '<td><input type="text" class="form-control" name="new_record_exam" id="new_record_exam" placeholder="EXAM" onkeyup="autoTotal()"></td>'+
            '<td><input type="text" class="form-control" name="new_record_total" id="new_record_total" placeholder="Total"></td>'+
            '<td colspan="4"><a href="javascript:void(0);" class="btn btn-success" onclick="createNewRecord()">Add New Record</a> </td>'+
            '</tr>';

    $("#rowAppendage").fadeIn().before(html);
}


function createNewRecord() {
    var queryString;
    var url;
    var new_record_surname = $("#new_record_surname").val();
    var new_record_othername = $("#new_record_othername").val();
    var new_record_ca = $("#new_record_ca").val();
    var new_record_exam = $("#new_record_exam").val();
    var new_record_total = $("#new_record_total").val();
    if(new_record_surname && new_record_othername){
        queryString = 'surname='+new_record_surname+'&othername='+new_record_othername+'&ca='+new_record_ca+'&exam='+new_record_exam+'&total='+new_record_total;
        url = '../teacher/createNewRecord';

        jQuery.ajax({
            url: url,
            data: queryString,
            type: "POST",
            success: function (data) {
                $("#newAdder").remove();
                $("#rowAppendage").fadeIn().before(data);
                addNewRow();
                updateTotalCount();

            },
            error: function () {
            }
        });
    }

}

function UpdateRecord(field,record, type){
    var queryString;
    var url;

    var text = "record_"+field+"_"+record;
    var value = $("#record_"+field+"_"+record).val();
    // Retrieve
    var lastRecord = localStorage.getItem("lastValue");
    console.log('local stored '+localStorage.getItem("lastValue"));

    if(value != lastRecord){
        queryString = ''+record+'='+value;
        if(record == 'ca' || record == 'exam'){ // total is affected
            var total = $("#record_"+field+"_total").text();
            queryString += '&total='+total;
        }
        url = '../teacher/UpdateRecord/'+record+'/'+field;

        jQuery.ajax({
            url: url,
            data: queryString,
            type: "POST",
            success: function (data) {
                var res = data.split('||');
                $("#record_"+field+"_position").text(res[1]);
                $("#record_"+field+"_grade").text(res[2]);
                $("#record_"+field+"_remark").text(res[3]);
                $("#statusReport").fadeIn().text(res[0]);

            },
            error: function () {
            }
        });
    }
    // return to table
    return2Table(field,record,type);

}

function createAcadRecord(field,record, type){
    var queryString;
    var url;

    var text = "record_"+field+"_"+record;
    var value = $("#record_"+field+"_"+record).val();

    if(value){
        queryString = ''+record+'='+value;
        if(record == 'ca' || record == 'exam'){ // total is affected
            var total = $("#record_"+field+"_total").text();
            queryString += '&total='+total;
        }
        url = '../teacher/createAcadRecord/'+record+'/'+field;

        jQuery.ajax({
            url: url,
            data: queryString,
            type: "POST",
            success: function (data) {
                var res = data.split('||');
                $("#record_"+field+"_position").text(res[1]);
                $("#record_"+field+"_grade").text(res[2]);
                $("#record_"+field+"_remark").text(res[3]);
                $("#statusReport").fadeIn().text(res[0]);
                // return to table
                return2Table(field,record,type);

            },
            error: function () {
            }
        });
    }

}

function updateTotalCount(){
    $("span#totalCount").text(function (i, origText) {
        if (isNaN(parseInt(origText))) {
            return  1;// + " Comment";
        } else {
            var sum = parseInt(origText) + 1;
            return sum; // + " Comments";
        }

    });
}

