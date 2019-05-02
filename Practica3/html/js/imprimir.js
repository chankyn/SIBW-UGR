$(function () {
    var source = "Enlace video: localhost:8080/"+$(".video").attr('src');
    var texto = $('<p>'+source+'</p>');
    
    $("#videos video").remove();

    //Si se encuentra video ponemos su url.
    if (source.indexOf( "undefined" ) == -1 ){

        texto.appendTo($('#videos'));
        $("#videos").append( "<p>"+source+"</p>" );
    }
});