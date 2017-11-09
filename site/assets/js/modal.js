$( document ).ready(function() {
    $('#modalBtn').on('click', function(e){
        e.preventDefault();
        $('#modal').fadeIn("fast");
        $('#modal').css('overflow', 'hidden');
        $('body').css('overflow', 'hidden');
    });

    $('.close').on('click', function(e){
        $('#modal').fadeOut("fast");
        $('[id^="modal-"]').fadeOut("fast");
        $('[id^="modal-reserve-"]').fadeOut("fast");
        $('body').css('overflow', 'scroll');
    });

    $('[id^="btn-modal-"]').on('click', function(e) {
        $('#' + this.id.substring(4, this.id.length)).fadeIn("fast");
        $('body').css('overflow', 'hidden');
    })

    $('[id^="btn-modal-reserve-"]').on('click', function(e) {
        $('#' + this.id.substring(4, this.id.length)).fadeIn("fast");
        $('body').css('overflow', 'hidden');
    })
});
