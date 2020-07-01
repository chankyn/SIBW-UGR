<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$location = $_POST["location"];

$res = validarRegistroUsuario();
$pos = strpos($location, "evento");

if($res == 1) //Error de validación
    if (!$pos)
        $location =$location.'?registro=error';
    else
        $location =$location.'&registro=error';
else if ($res == 2)//Usuario ya existe
    if (!$pos)
        $location =$location.'?registro=error1';
    else
        $location =$location.'&registro=error1';
else if ($res == 3)//Correo ya existe
    if (!$pos)
        $location=$location.'?registro=error2';
    else
        $location=$location.'&registro=error2';
else 
    if (!$pos)
        $location=$location.'?registro=true';
    else
        $location=$location.'&registro=true';

header('Location: '.$location);


?>
