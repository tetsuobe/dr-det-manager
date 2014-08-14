$(document).foundation();
$('.side-nav a').on('click',function(event){
    event.preventDefault();
    var elem = $(this).attr('href');
    if($(elem).is(':visible')){
        return;
    }
    $('.main').not($(elem)).slideUp('100', function(){
        $(elem).slideDown();
    });
});