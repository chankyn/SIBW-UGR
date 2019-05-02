$(function () {
    /*$("li").hover(function() {
        if($(this).find("ul").css("display") == "none")
            $(this).find("ul").css("display", "block");
        else
            $(this).find("ul").css("display", "none");
        return false;
    });*/
    $('nav li ul').hide().removeClass('hijo');
    $('nav li').hover(
    function () {
        $('ul', this).stop().slideDown(100);
    },
    function () {
        $('ul', this).stop().slideUp(100);
    }
);

});