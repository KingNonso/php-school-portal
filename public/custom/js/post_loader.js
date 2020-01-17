/**
 * Created by Nonny on 9/24/16.
 * Javascript Scroll Tutorial Load Dynamic Content Into Page When User Reaches Bottom Ajax
 */

function yHandler(){
    var wrap = document.getElementById('load_more_wall_post');
    var contentHeight = wrap.offsetHeight;
    var yOffset = window.pageYOffset;
    var y = yOffset + window.innerHeight;
    if(y >= contentHeight){
        // Ajax call to get more dynamic data goes here
        var ajax = ajaxObj("POST", "wall/load_more_wall_post");

        ajax.onreadystatechange = function() {
            if(ajaxReturn(ajax) == true) {
                if((ajax.responseText) == 'nothing'){
                    var end_of_doc = document.getElementById('end_of_doc');
                    end_of_doc.innerHTML = '<div class="newData">You have reached the end of active posts/ conversations</div>';
                } else {
                    wrap.innerHTML += '<div class="newData">'+ajax.responseText+'</div>';
                    $('.liveTime').liveTimeAgo();
                    // Select all elements with data-toggle="popover" in the document
                    $('[data-toggle="popover"]').popover({html: true, placement: "top"});


                }
            }
        }
        ajax.send();//"person_state="+person_state+"&person_slug="+person_slug

    }
    //for testing and development purposes
    //var status = document.getElementById('status');
    //status.innerHTML = contentHeight+" | "+y;
}
window.onscroll = yHandler;

