$(function () {
  var a = 0;
  var b = 2;

  //Crea el carrusel de imágenes.
  $("#lightSlider").lightSlider({
    item: 1,
    speed: 400, //ms'
    auto: true,
    loop: true,
    slideEndAnimation: true
  }); 

  //Define el mensaje (popup) cuando pulsamos sobre el icono de las redes
  $( "#mensajeRedes" ).dialog({
    resizable:false,
    modal:true,
    autoOpen: false,
    width: "30%",
    buttons: {
        "Aceptar": function()
        {
            $(this).dialog('close');
            choice(true);
        },
        "Cancelar": function()
        {
            $(this).dialog('close');
            choice(false);
        }
    }
  });
  
  //Jquery para crear los mensajes de error del sistema.
  $( "#mensajeErrorComentario" ).dialog({
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
            location.search=location.search.replace('&error=true', '');
        }
    }
  }).parent().addClass("ui-state-error");

  $( "#mensajeErrorID" ).dialog({
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
            location.search=location.search.replace('&error2=true', '');
        }
    }
  }).parent().addClass("ui-state-error");

  //Jquery para controlar los errores producidos.
  var errorComment = getVariableURL('&','error');
  var errorID =getVariableURL('&','error2');
  if (errorComment){
    //Muestra el error que se ha producido
    $( "#mensajeErrorComentario" ).dialog("open");
  }
  if (errorID){
    //Muestra el error que se ha producido
    $( "#mensajeErrorID" ).dialog("open");
  }
  
  //Código para crear los botones para ver más comentarios.
  var nComentarios = Math.ceil($("#comentariosArchivados > div").length/2);
  var button = $('<input type="button"/> ');
  for (var i = 1; i <= nComentarios; i++) { 
    button = $('<input class="moreC" type="button" value ='+i+'>');
    button.appendTo($('#comentariosArchivados'));
  }
  
  $( "#comentariosArchivados div" ).hide();
  $( "#comentariosArchivados div" ).slice( a,b ).show();

  $(".ec-stars-wrapper a").click(function(){
    //Es necesario porque se ejecuta antes de que la url se recarge y cuenta mal las estrellas seleccionadas.
    setTimeout(cambiarColorEstrellas,200);
  })

  //Función para mantener el color de las estrellas al dar click.
  function cambiarColorEstrellas(){
    var nEstrellas = getVariableURL('#','estrellas');
    $(".ec-stars-wrapper a").css('color','#888');
    $(".ec-stars-wrapper a:lt("+nEstrellas+")").css('color','#E5BE01');
  }
  //Función para cargar nuevos comentarios al pulsar el botón.
  $(".moreC").click(function(){
    $(".moreC").css('background-color','#DDD');
    $(this).css('background-color','##4eb5f1');

    $( "#comentariosArchivados div" ).hide();
    var n = parseInt($(this).val(), 10);
    var n2 = n - 2;
    $( "#comentariosArchivados div" ).slice( n+n2, n+n2+2 ).show();
  })

  //Jquery para controlar el mensaje de las redes sociales.
  
  $(".icon").click(function(){
    $(".borrame").remove();
    var red = $(this).attr('name');
    $("#mensajeRedes").prepend("<p class='borrame'>Se publicará en "+red+" el siguiente mensaje:</p>");
    $("#mensajeRedes").dialog("open");
  })

  //Jquery para controlar las sesiones
  $("#enviarComentario").click(function(){
    //Guardamos el nombre de usuario y el email al pulsar el boton enviar.
    var comentario = document.getElementById("nombreComentario").value;
    var email = document.getElementById("emailComentario").value;
    
    //if (localStorage.getItem('nombre')==null && comentario!="")
    if (comentario!="")
      localStorage.setItem('nombre', comentario);
    //if (localStorage.getItem('email')==null && email!="")
    if (email!="")
      localStorage.setItem('email', email);

      enviarComentario();
    
  })
  $("#botonAbrirComentario").click(function(){
    //Cargamos los valores de la sesión cuando pulsamos en el botón comentarios.
    if (sessionStorage.getItem('sesionNombre')!=null)
      document.getElementById("nombreComentario").value = sessionStorage.getItem('sesionNombre');
    
    
  })

  
});

function cambiarVisibilidad() {
    var visible = document.getElementById("oculto").style.display;
    if (visible == "none"){
      document.getElementById("oculto").style.display="inline-block";
      document.getElementById("cont").style.width="60%";
      document.getElementById("cont").style.display="inline-block";
      document.getElementById("cont").style.float="left";
    }else{
      document.getElementById("oculto").style.display= "none";
      document.getElementById("cont").style.width="100%";
      document.getElementById("cont").style.display="block";
    }
}
function getFecha(){
  var fechaActual = new Date();
  var dia = fechaActual.getDate();
  var mes = fechaActual.getMonth()+1;
  var anio = fechaActual.getFullYear();
  var hora = fechaActual.getHours();
  var minutos = fechaActual.getMinutes();

  if (minutos < 10)
    minutos = "0"+minutos;

  if (mes < 10)
    mes = "0"+mes;
  return dia+"/"+mes+"/"+anio+" "+hora+":"+minutos;
}

function crearParrafoComentario(){

  var parrafo = document.createElement("p");
  var t = document.getElementById("textoComentario").value;
  var textoComentario = document.createTextNode(t);
  
  parrafo.appendChild(textoComentario);
  return parrafo; 
}

function crearParrafoAutor(){
  var parrafo = document.createElement("p");
  parrafo.classList.add("nombre");

  var t = document.getElementById("nombreComentario").value;
  var t2 = "Autor: "+t;
  var textoComentario = document.createTextNode(t2);

  parrafo.appendChild(textoComentario); 
  return parrafo;
}

function crearParrafoFecha(){
  
  var parrafo = document.createElement("p");
  parrafo.classList.add("fecha");
  var t = "Fecha: "+ getFecha();
  var textoComentario = document.createTextNode(t);
  
  parrafo.appendChild(textoComentario); 
  return parrafo;
}
function validarEmail(){
  var email = document.getElementById("emailComentario").value;
  //Alfanumérico + @ + . y letras de 2 a 4 de longitud
  const emailRegex = /^([A-Za-z0-9_\-.+])+@([A-Za-z0-9_\-.])+\.([A-Za-z]{2,4})$/;
  return emailRegex.test(email);
  
}
function comprobarCamposComentario(){
  
  var nombre = document.getElementById("nombreComentario").value;
  var texto =  document.getElementById("textoComentario").value;

  if (nombre.length < 3)
   document.getElementById("nombreComentario").style.borderColor="red";
  else
    document.getElementById("nombreComentario").style.borderColor="initial";

  if (texto.length < 3)
    document.getElementById("textoComentario").style.borderColor="red";
  else
    document.getElementById("textoComentario").style.borderColor="rgb(169, 169, 169)";

  if (!validarEmail())
    document.getElementById("emailComentario").style.borderColor="red";
  else
    document.getElementById("emailComentario").style.borderColor="initial";

  if (nombre.length < 3 || texto.length < 3 || !validarEmail()){
    return false;
  }
  
  return true;//Podemos añadir el comentario
}
function enviarComentario() {
  var nEstrellas = getVariableURL('#','estrellas');
  var idEvento = getVariableURL('?','id');
  idEvento = idEvento.split('#').shift();

  document.getElementById("estrellas").value = nEstrellas;
  document.getElementById("idEvento").value = idEvento;
  if (comprobarCamposComentario()){
    $("#formEnviarComentario").attr("action","procesar.php?id_usuario="+sessionStorage.getItem('sesionidUser'));
    document.forms["comentario"].submit();
  }else
    alert("Introduce todos los datos para enviar el comentario.");

}

function ocultarComentario() {
  document.getElementById("oculto").style.display= "none";
}

function comprobarPalabrasProhibidas(){
  var prohibidas = ["hola","adios","prueba","manolo","inutil","pepe"];
  var texto =  document.getElementById("textoComentario").value;

  for(var i =0; i < prohibidas.length; i++){
    var palabra = prohibidas[i];
    var asteriscos = "";
    for (var j = 0; j < palabra.length; j++ )
      asteriscos += "*";
    texto = texto.replace(prohibidas[i], asteriscos);
  }

  document.getElementById("textoComentario").value = texto;
}

function crearEstrellasValoracion(){
  var nEstrellas = getVariableURL('#','estrellas');
  if ( nEstrellas > 0 ){
    var texto ="";
    for (var i = 0; i < nEstrellas; i++)
      texto += '\u2605' ;

    var parrafo = document.createElement("p");
    parrafo.classList.add("estrellas");
    var textoComentario = document.createTextNode(texto);

    parrafo.appendChild(textoComentario); 
    return parrafo;
  }else{
    var texto ='\u2605';
    
    var parrafo = document.createElement("p");
    parrafo.classList.add("estrellas");
    var textoComentario = document.createTextNode(texto);

    parrafo.appendChild(textoComentario); 
    return parrafo;
  }
}



  
