/**
 * Created by victor on 10/20/15.
 */
$(document).ready(function() {
    $("button[id$='Search']").click(function(e){
		
		form = document.getElementById('submitForm');
        form.action = e.target.id;
    });

    $("#saveBtn").click(function(e){

        var whatIs;

        if(e.target.name == "isbnBtn"){
            whatIs = "isbn";
        } else if(e.target.name == "upcBtn"){
            whatIs = "upc";
        } else if(e.target.name == "eanBtn"){
            whatIs = "ean";
        }

        console.log($('input[name="_token"]').val());
        $.ajax({
            url: 'databaseBookEntry',
            type: 'POST',
            beforeSend: function (xhr) {
                var token = $('input[name="_token"]').val();

                if (token) {
                    return xhr.setRequestHeader('X-CSRF-TOKEN', token);
                }
            },
            data: { isbn : $("#isbn").text(),
                    title : $("#bookTitle").text(),
                    author : $("#author").text(),
                    pageCount : $("#pageCount").text(),
                    price : $("#price").text(),
                    bookState : $("select option:selected").val(),
                    whatIs : whatIs },
            success: function(data){
                alert("Success!");
                window.location.href = "ajoutDeLivres";
            }, error:function(){
                alert("error!!!!!");
            }
        });
    });
});

