/**
 * Created by victor on 10/20/15.
 */
$(document).ready(function() {

    $("#upcSearch").click(function(){
        $.get("http://api.upcdatabase.org/json/9b2028c160f324a5a0ed889f07394e5d/" + $("#isbnText").val(), function(data){
            $('#returnBook').append("<p>" + json.parse(data) + "</p>");
            $('#returnBook').show();
        }, "json");
    });
});