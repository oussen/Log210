$(document).ready(function() {

    $("#saveReservationBtn").click(function(){
        $('*[id^="chkSelect"]').each(function(){
            if($(this).is(":checked")) {

                var bookID = $(this).attr("id").split("-")[1];
                var reservedUntil = $("#reservedUntil").val();
                var userID = $("#currentUserID").val();
                var friendlyTime = timeConverter(reservedUntil);
                var deliveryPrice = $("#" + bookID + "-deliveryPrice").text().trim();
                var coopID = $("#currentBookCoopID").val();

                var isTransfer = false;

                if(deliveryPrice == "10$"){
                    var answer = confirm("Cet achat aura un frais supplémentaire de 10$ pour la livraison");

                    isTransfer = true;

                    if(answer == false){
                        exitReservation();
                    }
                }

                $.ajax({
                    url: 'reserveBook',
                    type: 'POST',
                    beforeSend: function (xhr) {
                        var token = $('input[name="_token"]').val();

                        if (token) {
                            return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                        }
                    },
                    data: {
                            bookID : bookID,
                            userID : userID,
                            reservedUntil : friendlyTime,
                            coopID : coopID,
                            isTransfer : isTransfer
                    },
                    success: function () {
                        alert("Votre livre a été réservé jusqu'au - " + friendlyTime);
                        window.location.href = "bookReservation";
                    }, error: function () {
                        alert(isTransfer);
                    }
                });
            }
        });
    });

    function timeConverter(time){
        var a = new Date(time * 1000);
        var year = a.getFullYear();
        var month = a.getMonth() + 1;
        var day = a.getDate();
        var hour = a.getHours();
        var min = a.getMinutes();
        var sec = a.getSeconds();
        var time = year + '-' + month + '-' + day + ' ' + hour + ':' + min + ':' + sec ;
        return time;
    }

    function exitReservation(){
        alert("Réservation Annulée");
        window.location.href("bookReservation");
    }

    window.setTimeout(function(){
        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
        })}, 1000);
});