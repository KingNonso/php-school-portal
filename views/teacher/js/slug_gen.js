$(document).ready(function(e) {

    var diff = true;
    //var path = window.location.pathname;
    //var split = path.split("/");
    //var l = split.pop();
    //if(l == 'school'){
        //diff = true;
    //}

    if(diff){
        /*-----------------------SLUG GEN CALLER -------------------*/
//this function is to generate slug on mouse up
        $('#sch_name').keyup(function(e) {
            generate('#sch_name');
        });
        $("#sch_name").change(function(){
            slugCheck("create",1);
        });

        $("#slug").on({
            focus: function(){
                //$(this).css("background-color", "lightgray");
                slugCheck("create",1);
            },
            keyup: function(){
                slugCheck("create",1);
            },
            blur: function(){
                generate('#slug');
                slugCheck("create",1);
            }
        });
        /*-----------------------SLUG GEN CALLER END -------------------*/

    }else{
        /*-----------------------SLUG GEN CALLER -------------------*/
//this function is to generate slug on mouse up
        $('#sch_name').keyup(function(e) {
            generate('#sch_name');
        });
        $("#sch_name").change(function(){
            slugCheck("update",1);
        });

        $("#slug").on({
            focus: function(){
                //$(this).css("background-color", "lightgray");
                slugCheck("update",1);
            },
            keyup: function(){
                slugCheck("update",1);
            },
            blur: function(){
                generate('#slug');
                slugCheck("update",1);
            }
        });
        /*-----------------------SLUG GEN CALLER END -------------------*/

    }


    function generate(from){
        var name = $(from).val();

        //alert($( this ).attr( "id" ));
        var map = {// remove accents, swap ñ for n, etc
            from: 'àáäãâèéëêìíïîòóöôõùúüûñç·/_,:;'
            , to  : 'aaaaaeeeeiiiiooooouuuunc------'
        };


        for (var i=0, j=map.from.length; i<j; i++) {
            name = name.replace(new RegExp(map.from.charAt(i), 'g'), map.to.charAt(i));
        }

        /* .replace(/\s+/g, '-')           // Replace spaces with -
         .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
         .replace(/\-\-+/g, '-')         // Replace multiple - with single -
         .replace(/^-+/, '')             // Trim - from start of text
         .replace(/-+$/, '');            // Trim - from end of text
         */
        name = name.toString().toLowerCase().replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
        //check if slug already exist in database

        $("#slug").val(name);

    }

    function slugCheck(action, id) {
        var guard = $("#slug-guard");

        guard.text('Checking for availability of slug URL...');

        var submitButton = ($('button[type="submit"]').length) ? $('button[type="submit"]') : $('input[type="submit"]');

        var slug = $("#slug").val();
        var queryString;
        var url;
        switch (action) {
            case "create":
                //console.log('msg sent'+submitButton);
                queryString = 'slug=' + slug;
                url = '../webmaster/slug_check';
                break;

            case "update":
                var token = $("#token").val();
                queryString = 'slug=' + slug;
                url = '../../../webmaster/slug_check/update';
                break;



        }
        jQuery.ajax({
            url: url,
            data: queryString,
            type: "POST",
            success: function (data) {
                switch (action) {

                    case "create":
                    case "update":
                        if(jQuery.trim(data) == 'good'){
                            guard.text("Hurray!!! Slug URL is available for Use! ");
                            guard.css("color", "green");
                            submitButton.prop('disabled', false);

                        }else{
                            guard.text("This Slug URL has cannot be used. Please edit the Slug URL to make it unique! ");
                            guard.css("color", "red");
                            submitButton.prop('disabled',true);

                        }
                        break;
                }
            },
            error: function () {
            }
        });
        $("#slug").val(slug);

    }

    //$("#slug")
});

