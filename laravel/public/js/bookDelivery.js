$(document).ready(function(){
    $("button[id$='Delivery']").click(function(e){
        form = document.getElementById('deliveryForm');
        form.action = e.target.id;
    });

    window.setTimeout(function(){
        $(".alert-success").fadeTo(2000, 500).slideUp(500, function(){
            $("#success-alert").alert('close');
        })}, 1000);

    window.setTimeout(function(){
        $(".alert-danger").fadeTo(2000, 500).slideUp(500, function(){
            $("#danger-alert").alert('close');
        })}, 1000);

    $(":checkbox").change(function(){
        idArray = this.id.split("-");
        id = idArray[1];

        $("input[name='item_name']").val($("#bookTitle-"+id).text());
        $("input[name='item_number']").val($("#isbn-"+id).text());
        $("input[name='amount']").val($("#price-"+id).text());
    });
});
