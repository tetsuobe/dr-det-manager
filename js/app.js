$(document).foundation();
$('.side-nav a').on('click',function(event){
    event.preventDefault();
    var elem = $(this).attr('href');
    if($(elem).is(':visible')){
        return;
    }
    $('html,body').animate({scrollTop: 0}, 100);
    $('.main').not($(elem)).slideUp('100', function(){
        $(elem).slideDown();
    });
});