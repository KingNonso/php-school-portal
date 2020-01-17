function searchDate(){ //year, month, day
    var year = $("#blog_year").val();
    var month = $("#blog_month").val();
    var day = $("#blog_day").val();
    var url = '../../blog/date/'+year+'/'+month+'/'+day;
    var queryString = 'year='+year+'&month='+ month+'&day='+ day;

    jQuery.ajax({
        url: url,
        data:queryString,
        type: "POST",
        success:function(data){
            var search_results = $("#search_results");
            switch (data){
                case 'bad_date':
                    search_results.html('<h4 class="text-danger"> <span class="glyphicon glyphicon-warning-sign"></span> Oops...<br> <small>Nothing was found for the given date, please check the dates and try again!</small></h4>');
                    break;
                default :
                    search_results.html(data);
                    break;


            }

        },
        error:function (){}
    });


}
