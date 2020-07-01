<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_evento = $_POST["id_evento"];

if (filter_var($_POST["id_evento"], FILTER_VALIDATE_INT)) {
    $id_evento = $_POST["id_evento"];
}else{
    echo "El id del evento no es válido";
    header('Location: index.php?id_evento=error');
}
comprobarPrivilegios(3);

$accion = $_POST["accion"];
$imagen = $_POST["imagen"];
$borrado = $_POST["borrado"];
if ($borrado === "NO")// si la accion es cambiar la imagen..
    if ($accion == 1){ //Cambiamos la imagen primaria
        nuevosDatosEventos($id_evento,"ruta_imagen",$imagen);
    }else if ($accion == 2){ //Cambiamos la imagen secundaria
        nuevosDatosEventos($id_evento,"ruta_imagen_secundaria",$imagen);
    }else{//Cambiamos la imagen de una etiqueta
        $id_etiqueta = $_POST["id_etiqueta"];
        nuevosDatosEtiqueta($id_etiqueta,"ruta_imagen",$imagen);
    }
else{
    if ($accion == 1){ //Cambiamos la imagen primaria
        nuevosDatosEventos($id_evento,"ruta_imagen","");
    }else if ($accion == 2){ //Cambiamos la imagen secundaria
        nuevosDatosEventos($id_evento,"ruta_imagen_secundaria","");
    }
}
header( 'location: eventos.php?id='.$id_evento);




?>
