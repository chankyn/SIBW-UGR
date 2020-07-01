<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Comprobamos que el id_evento es un id de usuario válido
$id_evento = $_POST["id_evento"];
if (filter_var($_POST["id_evento"], FILTER_VALIDATE_INT)) {
    $id_evento = $_POST["id_evento"];
}else{
    header('Location: index.php?id_evento=error');
}
comprobarPrivilegios(3);

$titulo = $_POST["titulo"];
$fecha = $_POST["fecha"];
$descripcion = $_POST["descripcion"];
$descripcion_avanzada = $_POST["descripcion_avanzada"];

actualizarDatosEvento($id_evento,$titulo,$fecha,$descripcion,$descripcion_avanzada);
header('Location: eventos.php?id='.$id_evento);



?>
