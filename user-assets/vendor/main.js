$(document).ready(function(){
    $('a.nav-link').click(function(event){
        event.preventDefault();
        const id = $(this).attr("href");
        $("html, body").animate({
            scrollTop: ($('#order').offest().top)
        }, 2000)
    })
})