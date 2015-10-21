/**
 * Created by vicag on 20/10/2015.
 */
$(document).ready(function(){
    $("button").click(function(){
        //if = -1, the login is not an email, otherwise it is
        if($('input[name=login]').val().indexOf("@") == -1){
            $("#hiddenPhone").val($('input[name=login]').val())
            console.log($("#hiddenPhone").val())
        } else {
            $("#hiddenEmail").val($('input[name=login]').val())
            console.log($("#hiddenEmail").val())
        }
    });
});