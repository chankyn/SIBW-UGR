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
  if (comprobarCamposComentario()){
    var contenedor = document.getElementById("comentariosArchivados");
    var div = document.createElement("div");
    div.appendChild(crearParrafoAutor());
    div.appendChild(crearEstrellasValoracion());
    div.appendChild(crearParrafoFecha());
    div.appendChild(crearParrafoComentario());

    contenedor.appendChild(div);
  }else
    alert("Introduce todos los datos para enviar el comentario.");

  
}

function ocultarComentario() {
  document.getElementById("oculto").style.display= "none";
}

function comprobarPalabrasProhibidas(){
  var prohibidas = ["hola","adios","prueba","inutil","manolo","pepe"];
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
  var nEstrellas = getVariableURL('estrellas');
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

function getVariableURL(variable){
  var url = window.location.href;
  var vars = url.split("#");
  vars.shift();

  for (var i = 0;i < vars.length; i++) {
    var pair = vars[i].split("=");
    if(pair[0] == variable){
      return pair[1];
    }
  }
  return 0;
}
  
