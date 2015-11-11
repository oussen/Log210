/**
 * Created by Ben on 2015-10-22.
 */

$(document).ready(function() {

    $("#saveBtnRec").click(function(){
        $('*[id^="chkSelect"]').each(function(){
            if($(this).is(":checked")) {

                var id = $(this).attr("id").split("t")[1];

                $.ajax({
                    url: 'receiveBooks',
                    type: 'POST',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id: id},
                    success: function (data) {
                        alert("Votre livre a été reçu avec succès!");
                        $('#SendMail' + id)[0].click();
                        window.location.href = "receptionLivres";
                    }, error: function () {
                        alert("error!!!!!");
                    }
                });

            }
        });
    });
});