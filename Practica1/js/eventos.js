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
  var t = document.getElementById("nombreComentario").value;
  var t2 = "Autor: "+t;
  var textoComentario = document.createTextNode(t2);

  parrafo.appendChild(textoComentario); 
  return parrafo;
}

function crearParrafoFecha(){
  var parrafo = document.createElement("p");
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
    contenedor.appendChild(crearParrafoAutor());
    contenedor.appendChild(crearParrafoFecha());
    contenedor.appendChild(crearParrafoComentario());
  }else
    alert("Introduce todos los datos para enviar el comentario.");

  
}

function ocultarComentario() {
  document.getElementById("oculto").style.display= "none";
}

function comprobarPalabrasProhibidas(){
  var prohibidas = [/hola/gi,/adios/gi,/prueba/gi,/prueba2/gi];
  var cambio = ['****','*****','******','*******'];
  var texto =  document.getElementById("textoComentario").value;
  for(var i =0; i < prohibidas.length; i++){
    
    texto = texto.replace(prohibidas[i], cambio[i]);
  }
  document.getElementById("textoComentario").value = texto;
}
  