$( document ).ready(function() {
  $('#modalBtn').on('click', function(e){
    e.preventDefault()
    $('#modal').fadeIn("fast")
  })
  $('#closeModal').on('click', function(e){
    $('#modal').fadeOut("fast")
  })
});
