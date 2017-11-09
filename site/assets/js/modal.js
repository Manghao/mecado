$( document ).ready(function() {
  $('#modalBtn').on('click', function(e){
    e.preventDefault();
    $('#modal').fadeIn("fast");
    $('#modal').css('overflow', 'hidden');
    $('body').css('overflow', 'hidden');
  });

  $('.close').on('click', function(e){
    $('#modal').fadeOut("fast");
      $('body').css('overflow', 'scroll');
  });
});
