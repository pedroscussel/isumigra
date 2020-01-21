/**
 * 
 */

function changeSelect(idFirstSelect, idSecondSelect, baseUrl) {
    
    $(idFirstSelect).on('change', function(){
        var id  = $(this).val();
        var url = baseUrl + "/" + id;

        $.ajax({
            type: "GET",
            url: url
        }).done(function(data){
            $(idSecondSelect).empty(); // remove old options
            $.each(data, function(i, item) {
                $(idSecondSelect).append($("<option></option>")
                            .attr("value", i).text(item));
                
            });
            $(idSecondSelect).trigger('change');
        });
    });
    
}


