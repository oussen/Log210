$(document).ready(function(){
  $("select").on("change", function(){
      $("#coopSelected").val($("select option:selected").val());
  });
});
