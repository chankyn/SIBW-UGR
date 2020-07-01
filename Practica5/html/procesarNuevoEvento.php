<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

comprobarPrivilegios(3);

$titulo = $_POST["titulo"];
if (empty($titulo))
    header('Location: index.php?new_event=error');
$fecha = $_POST["fecha"];
$descripcion = $_POST["descripcion"];
$descripcion_avanzada = $_POST["descripcion_avanzada"];
$ruta_imagen = $_POST["ruta_imagen"];
$ruta_imagen_secundaria = $_POST["ruta_imagen_secundaria"];
nuevoEvento($titulo,$fecha,$descripcion,$descripcion_avanzada,$ruta_imagen,$ruta_imagen_secundaria);
header('Location: index.php');


?>
