$(document).ready(function(e) {
    var path = window.location.pathname;
    var split = path.split("/");
    var diff = split.lastIndexOf("write") - split.lastIndexOf("blog");

    if(diff === 1){
        console.log('blog write');

        /*-----------------------SLUG GEN CALLER -------------------*/
//this function is to generate slug on mouse up
        $('#title').keyup(function(e) {
            generate('#title');
        });
        $("#title").change(function(){
            slugCheck("blog",1);
        });

        $("#slug").on({
            focus: function(){
                //$(this).css("background-color", "lightgray");
                slugCheck("blog",1);
            },
            keyup: function(){
                slugCheck("blog",1);
            },
            blur: function(){
                generate('#slug');
                slugCheck("blog",1);
            }
        });
        /*-----------------------SLUG GEN CALLER END -------------------*/

    }else{
        console.log('blog update');

        /*-----------------------SLUG GEN CALLER -------------------*/
//this function is to generate slug on mouse up
        $('#title').keyup(function(e) {
            generate('#title');
        });
        $("#title").change(function(){
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
            case "blog":
                //console.log('msg sent'+submitButton);
                queryString = 'slug_title=' + slug;
                url = '../blog/slug_check';
                break;

            case "update":
                var token = $("#token").val();
                var slug_date = $("#slug_date").val();

                queryString = 'token=' + token + '&slug_title=' + slug+ '&slug_date=' + slug_date;
                url = '../../../blog/slug_check/update';
                break;



        }
        jQuery.ajax({
            url: url,
            data: queryString,
            type: "POST",
            success: function (data) {
                switch (action) {

                    case "blog":
                    case "update":
                        if(data == 'good'){
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

