$(function () {
    $("#divRegistroUsuario").css("display","none");
    $("#enlaceRegistro").click(function(){
        $("#divInicioSesion").css("display","none");
        $("#divRegistroUsuario").css("display","block");
    });
    $("#enlaceInicioSesion").click(function(){
        $("#divInicioSesion").css("display","block");
        $("#divRegistroUsuario").css("display","none");
    });
    $("#submitIniciarSesion").click(function(){
        $("#locationI").val(location.pathname+location.search);
        document.forms["login"].submit();
    });

    $("#submitRegistro").click(function(){
        $("#locationR").val(location.pathname+location.search);
        document.forms["register"].submit();
    });
    $( ".gestores" ).tooltip();
    $( ".moderadores" ).tooltip();
    $("#submitLogout").click(function(){
        $("#userSession").val(sessionStorage.getItem('sesionNombre'));
        sessionStorage.setItem('sesionIniciada', false); 
        sessionStorage.setItem('sesionidUser', null);
        sessionStorage.setItem('sesionNombre', null);
        sessionStorage.setItem('sesionPrivilegios',null);
        $("#divSesionIniciada").css("display","none");
        $("#divInicioSesion").css("display","block");
        document.forms["logout"].submit();
    });
    //Se comprueba si está iniciada la sesión del usuario.
    if (sessionStorage.getItem('sesionIniciada') === "true"){
        $("#divInicioSesion").css("display","none");
        $("#usuarioSesion").text(sessionStorage.getItem('sesionNombre'));
        $("#enviarComentario").prop('disabled', false);
        $("#divSesionIniciada").css("display","block");
        $("#enlacePerfilUsuario").attr('href',"users_profile.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        $("#enlaceListadoComentarios").attr('href',"listado_comentarios.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        $("#enlaceNuevoEvento").attr('href',"nuevo_evento.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        $("#enlaceListadoEventos").attr('href',"listado_eventos.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        $("#enlaceListadoUsuarios").attr('href',"listado_usuarios.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        
    }
    if (sessionStorage.getItem('sesionIniciada') === "false"){
        $("#enviarComentario").prop('disabled', true);
        $("#enviarComentario").attr("title","Debes iniciar sesión para enviar comentarios.");
        $( "#enviarComentario" ).tooltip();
    }
    $.urlParam = function(name){
        var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
        if(results != null)
        return results[1] || 0;
    }
    $("#enviarCambios").click(function(){
        $("#id_usuario").val($.urlParam("id_usuario"));
        document.forms["perfil"].submit();
    });
    
    $("#editEvent").click(function(){
        var $elementos_editables=$(".editable");
        var esEditable = $elementos_editables.attr('contenteditable') == 'true';
        if (!esEditable){
            $elementos_editables.css("background","#EAEAEA");
            $elementos_editables.attr('contenteditable','true');
            $("#enviarCambiosE").css("display","block");
            $(".editarEle").css("display","inherit");
            $("span.editarEtiqueta").css("display","inline");
        }  
        else{
            $elementos_editables.css("background","");
            $elementos_editables.attr('contenteditable','false');
            $("#enviarCambiosE").css("display","none");
            $(".editarEle").css("display","none");
            $(".editarEtiqueta").css("display","none");
        }
    })

    $(".editComment").click(function(){
        var id_evento = $.urlParam("id");
        var elementos_editables=$(".textoEditableComentario"+$(this).attr("name"));
        var esEditable = elementos_editables.attr('contenteditable') == 'true';
        if (!esEditable){
            elementos_editables.css("background","#EAEAEA");
            elementos_editables.attr('contenteditable','true');
            elementos_editables.focus();
            var that = this;
            elementos_editables.blur(function(){
                $.post("procesarCambiosComentario.php",
                {
                    id_usuario: sessionStorage.getItem('sesionidUser'),
                    id_comentario: $(that).attr("name"),
                    nuevo_texto: elementos_editables.text()
                },
                function(data,status){
                    alert(data);
                    if (location.href.indexOf("listado") != -1)
                        location = "listado_comentarios.php?id_usuario="+sessionStorage.getItem('sesionidUser');
                    else
                        location = "eventos.php?id="+id_evento;
                });
            });
        }  
        else{
            elementos_editables.css("background","");
            elementos_editables.attr('contenteditable','false');
        }
    })
    
    $("#enviarCambiosE").click(function(){
        $("#formEid").val($.urlParam("id"));
        var i = 0;
        var array = new Array();
        array.push("#formEtitulo");array.push("#formEfecha");
        array.push("#formEdes");array.push("#formEdesA");
        $(".editable").each(function(){
            $(array[i]).val($(this).text());
            i++;
        })
        $("#formCambiosEvento").attr("action","procesarCambiosEvento.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        document.forms["eventos"].submit();
    });

    $('#deleteEvent').click(function(){
        $.post("procesarEliminarEvento.php",
        {
            id_usuario: sessionStorage.getItem('sesionidUser'),
            id_evento: $.urlParam("id")
        },
        function(data,status){
            alert(data);
            location = "index.php";
        });
        
    });
    $('.deleteComment').click(function(){
        var id_evento = $.urlParam("id");
        $.post("procesarEliminarComentario.php",
        {
            id_usuario: sessionStorage.getItem('sesionidUser'),
            id_comentario: $(this).attr("name")
        },
        function(data,status){
            alert(data);
            if (location.href.indexOf("listado") != -1)
                location = "listado_comentarios.php?id_usuario="+sessionStorage.getItem('sesionidUser');
            else
                location = "eventos.php?id="+id_evento;
        });
    });
    
    $("#anadirImagen").click(function(){
        if($("#subirImagen").css("display") == "none")
            $("#subirImagen").css("display","block");
        else
            $("#subirImagen").css("display","none");
    }); 
    $(".editarImagen").click(function(){
        $("#imagenPriSec").val($(this).attr("name"));
        if($("#editarImagen").css("display") == "none")
            $("#editarImagen").css("display","block");
        else
            $("#editarImagen").css("display","none");
    }); 
    $(".editarImagenEtiqueta").click(function(){
        var etiqueta = $(this).attr("name").replace("etiqueta","");
        $("#id_etiqueta_cambioImagen").val(etiqueta);
    });
    
    $("#upload").click(function(){
        var fd = new FormData();
        var files = $('#file')[0].files[0];
        fd.append('file',files);

        $.ajax({
            url: 'upload.php',
            type: 'post',
            data: fd,
            contentType: false,
            processData: false,
            success: function(response){
                if(response != 0){
                    $("#img").attr("src",response); 
                    $(".preview img").show(); // Display image element
                }else{
                    alert('El archivo no ha sido subido.');
                }
            },
        });
    });

    $("img.seleccionable").imgCheckbox({"radio": true});

    $("#botonCambiarImagen").click(function(){
        $("#imagenSeleccionada").val($(".imgChked img").attr("src"));
        $("#borrarImagen").val("NO");
        $(".id_evento").val($.urlParam("id"));
        $("#formCambiarImagen").attr("action","procesarCambioImagen.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        document.forms["cambiarImagen"].submit();
    });
    $("#btnNuevoEvento").click(function(){
        $("#formNuevoEvento").attr("action","procesarNuevoEvento.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        document.forms["nuevoEvento"].submit();
    });
    $(".deleteImagen").click(function(){
        $("#imagenPriSec").val($(this).attr("name"));
        $(".id_evento").val($.urlParam("id"));
        $("#borrarImagen").val("SI");
        $("#formCambiarImagen").attr("action","procesarCambioImagen.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
        document.forms["cambiarImagen"].submit();
    });
    $( "#selFecha" ).datepicker({ dateFormat: 'yy-mm-dd' });
    $("#btnBusqueda").click(function(){
        var busqueda = $("#busqueda").val();
        location.href = "listado_eventos.php?id_usuario="+sessionStorage.getItem('sesionidUser')+"&search="+busqueda;
    });
    $("#btnBusquedaComment").click(function(){
        var busqueda = $("#busquedaComment").val();
        location.href = "listado_comentarios.php?id_usuario="+sessionStorage.getItem('sesionidUser')+"&search="+busqueda;
    });
    $("#busqueda").click(function(){
        $("#busqueda").val("");
    });
    $(".submitCambiarRol").click(function(){
        var id_cambio = $(this).attr("name");
        var nuevo;
        $(".privilegios"+id_cambio).each(function(){
            if ($(this).prop("checked")){
                nuevo = ($(this).val());
            }
        })
        location.href = "procesarCambioRol.php?id_usuario="+sessionStorage.getItem('sesionidUser')+"&usuario_cambio="+id_cambio+"&nuevo_rol="+nuevo;
    });
    $("#anadirEtiqueta").click(function(){
        if($("#divAnadirEtiqueta").css("display") == "none")
            $("#divAnadirEtiqueta").css("display","block");
        else
            $("#divAnadirEtiqueta").css("display","none");
    }); 
    $("#submitAnadirEtiqueta").click(function(){
        var id_evento = $.urlParam("id");
        var elemento = $("#divAnadirEtiqueta select").val();
        $.post("anadirNuevaEtiqueta.php",
        {
            id_usuario: sessionStorage.getItem('sesionidUser'),
            id_evento: id_evento,
            etiqueta: elemento
        },
        function(data,status){
            location.href = "eventos.php?id="+id_evento;
        });
    });

    $(".editarEle").click(function(){
        var etiqueta = $(this).attr("value").replace("etiqueta","");
        var id_evento= $.urlParam("id");
        $.post("procesarEliminarEtiqueta.php",
        {
            id_usuario: sessionStorage.getItem('sesionidUser'),
            id_etiqueta: etiqueta
        },
        function(data,status){
            alert(data);
            location = "eventos.php?id="+id_evento;
        });
    });
    $(".editarEtiqueta").click(function(){
        var etiqueta = $(this).attr("name");
        var id_evento= $.urlParam("id");
        $.post("procesarEditarEtiqueta.php",
        {
            id_usuario: sessionStorage.getItem('sesionidUser'),
            id_etiqueta: etiqueta,
            contenido: $(".edit"+etiqueta).text()
        },
        function(data,status){
            alert(data);
            location = "eventos.php?id="+id_evento;
        });
    });
    
    if (sessionStorage.getItem('sesionPrivilegios') > 1){
        $(".moderadores").css("display","inherit");
    }
    if (sessionStorage.getItem('sesionPrivilegios') > 2){
        $("div.gestores").css("display","inline");
        $(".gestores").not("div").css("display","inherit");
 
    }
    if (sessionStorage.getItem('sesionPrivilegios') > 3){
        $(".super").css("display","inherit");
    }

    //Jquery para crear los mensajes de error del sistema.
    $( "#mensajeErrorRegistro1" ).dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        width: "30%",
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                //Cambiamos la url.
                location.search=location.search.replace(/(\?registro=error1|&registro=error1)/gi, '');
            }
        }
    }).parent().addClass("ui-state-error");
    $( "#mensajeErrorRegistro2" ).dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        width: "30%",
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                //Cambiamos la url.
                location.search=location.search.replace(/(\?registro=error2|&registro=error2)/gi, '');
            }
        }
    }).parent().addClass("ui-state-error");
    $( "#mensajeErrorRegistro" ).dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        width: "30%",
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                //Cambiamos la url.
                location.search=location.search.replace(/(\?registro=error|&registro=error)/gi, '');
            }
        }
    }).parent().addClass("ui-state-error");
    $( "#mensajeRegistroSatisfactorio" ).dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        width: "30%",
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                //Cambiamos la url.
                location.search=location.search.replace(/(\?registro=true|&registro=true)/gi, '');
            }
        }
    }).parent().addClass("ui-state-highlight");


    $( "#mensajeLoginIncorrecto" ).dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        width: "30%",
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                //Cambiamos la url.
                location.search=location.search.replace(/\?login=false|&login=false/gi, '');
            }
        }
    }).parent().addClass("ui-state-error");
    $( "#mensajeLoginCorrecto" ).dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        width: "30%",
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                var user = getVariableURL('&','user');
                var idUser = getVariableURL('&','idUser');
                var idPrivilegios = getVariableURL('&','idP');
                sessionStorage.setItem('sesionIniciada', true);
                sessionStorage.setItem('sesionidUser', idUser);
                sessionStorage.setItem('sesionNombre', user);
                sessionStorage.setItem('sesionPrivilegios', idPrivilegios);
                

                var idEvento = $.urlParam('id');
                
                if (idEvento > 0)
                    location.search=location.search.replace(location.search, "?id="+idEvento);
                else 
                    location.search=location.search.replace(location.search, "");

            }
        }
    }).parent().addClass("ui-state-highlight");

    $( "#mensajePrivilegiosError" ).dialog({
        resizable:false,
        modal:true,
        autoOpen: false,
        width: "30%",
        //Esto evita que salga el botón pequeño de cerrar.
        open: function() { $(".ui-dialog-titlebar-close").hide(); },
        buttons: {
            "Aceptar": function()
            {
                $(this).dialog('close');
                //Cambiamos la url.
                location.search=location.search.replace(/\?privilegios=error/gi, '');
            }
        }
    }).parent().addClass("ui-state-error");

    
    //Jquery para controlar los errores producidos.
    var errorRegistro = getVariableURL('?','registro');
    var errorRegistro2 = getVariableURL('&','registro');
    
    var errorLogin = getVariableURL('?','login');
    var errorLogin2 = getVariableURL('&','login');

    var errorPrivi = getVariableURL('?','privilegios');

    if (errorRegistro == "error" ||errorRegistro2 == "error"){
        //Muestra el error que se ha producido
        $( "#mensajeErrorRegistro" ).dialog("open");
        
    }
    if (errorRegistro == "error1" || errorRegistro2 == "error1"){
        //Muestra el error que se ha producido
        $( "#mensajeErrorRegistro1" ).dialog("open");
    
    }
    if (errorRegistro == "error2" || errorRegistro2 == "error2"){
        //Muestra el error que se ha producido
        $( "#mensajeErrorRegistro2" ).dialog("open");
    }
    if (errorRegistro == "true" || errorRegistro2 == "true"){
        $("#mensajeRegistroSatisfactorio").dialog("open");
    }
    if (errorLogin == "false" || errorLogin2 == "false"){
        $("#mensajeLoginIncorrecto").dialog("open");
    }
    if (errorLogin == "true" || errorLogin2 == "true"){
        
        $("#mensajeLoginCorrecto").dialog("open");

    }
    if (errorPrivi == "error"){
        $("#mensajePrivilegiosError").dialog("open");
    }
    

    /************** Práctica 5 AJAX ***************************/
    $('.search input[type="text"]').on("keyup input", function(){
        /* Get input value on change */
        var inputVal = $(this).val();
        var res = $(this).siblings(".resultado");

        if(inputVal.length){
            $.get("busqueda.php", {term: inputVal, id_usuario: sessionStorage.getItem('sesionidUser')}).done(function(data){
                // Display the returned data in browser
                data=data.split('|');
                var final ="<div>";
                for (var i = 0; i < data.length; i=i+2)
                    final +="<a href=eventos.php?id="+data[i+1]+"&search="+inputVal+">"+data[i]+"</a>";
                final = final+"</div>";
                res.html(final);                
            });
        } else{
            res.empty();
        }
    });
    
    var subrayado = getVariableURL('&','search');
    if (subrayado.length>0 ){
        var replaceD = "<span class='highlight'>" + subrayado + "</span>";
        $(".editable").each(function() {
            var text = $(this).text();
            
            text = text.replace(new RegExp(subrayado, "i"), replaceD);
            $(this).html(text);
        });
    }

    $(".despublicarEvento").click(function(){
        $.post("publicarEvento.php",
        {
            id_usuario: sessionStorage.getItem('sesionidUser'),
            id_evento: $(this).attr("name"),
            accion: "despublicar"
        },
        function(data,status){
            alert(data);
            location = "listado_eventos.php?id_usuario="+sessionStorage.getItem('sesionidUser');
        });
    });

    $(".publicarEvento").click(function(){
        $.post("publicarEvento.php",
        {
            id_usuario: sessionStorage.getItem('sesionidUser'),
            id_evento: $(this).attr("name"),
            accion: "publicar"
        },
        function(data,status){
            alert(data);
            location = "listado_eventos.php?id_usuario="+sessionStorage.getItem('sesionidUser');
        });
    });
});


function getVariableURL(separador,variable){
    var url = window.location.href;
    var vars = url.split(separador);
    vars.shift();
  
    for (var i = 0;i < vars.length; i++) {
      var pair = vars[i].split("=");
      if(pair[0] == variable){
        return pair[1];
      }
    }
    return 0;
  }
  
