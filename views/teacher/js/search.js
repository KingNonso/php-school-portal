function Search(str,where) {
    //this function is to be globally available
    //hence we need to iterate through the depth of url
    if (str.length==0) {
        document.getElementById("livesearch").innerHTML="";
        document.getElementById("livesearch").style.border="0px";
        return;
    }

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp=new XMLHttpRequest();
    } else {  // code for IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            document.getElementById("livesearch").innerHTML=xmlhttp.responseText;
            //document.getElementById("livesearch").style.border="1px solid #A5ACB2";
        }
    }

    xmlhttp.open("GET", "../teacher/search_for_person/"+where+"/"+str,true);
    xmlhttp.send();
}

function set_item(name, reg_id, id) {
    document.getElementById("setter").innerHTML= name+" :: "+reg_id;

    var student_id = document.getElementById( "student_id" );
    student_id.value = id;

    // hide proposition list
    document.getElementById("livesearch").innerHTML="";
    document.getElementById("livesearch").style.border="0px";



}
