/**
 * Created by Ben on 2015-11-11.
 */

$(document).ready(function() {

    $("#saveBtnRec").click(function(){
        $('*[id^="chkSelect"]').each(function(){
            if($(this).is(":checked")) {

                var id = $(this).attr("id").split("t")[1];

                $.ajax({
                    url: 'sendBooks',
                    type: 'POST',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {id: id},
                    success: function (data) {
                        alert("Votre livre a été envoyé avec succès!");
                        window.location.href = "bookTransfer";
                    }, error: function () {
                        alert("error!!!!!");
                    }
                });

            }
        });
    });
});