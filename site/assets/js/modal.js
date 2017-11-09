$( document ).ready(function() {
  $('#modalBtn').on('click', function(e){
    e.preventDefault();
    $('#modal').fadeIn("fast")
  });
  $('.close').on('click', function(e){
    $('#modal').fadeOut("fast");
  });
});
