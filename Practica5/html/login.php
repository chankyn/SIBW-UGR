<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
$location = $_POST["location"];

$pos = strpos($location, "evento");

if(!validarLogin())
    if (!$pos)
        header('Location: '.$location.'?&login=false');
    else
        header('Location: '.$location.'?login=false');
else{
    $user = $_POST["nombreUser"];
    $id_usuario = obtenerIdUsuario($user);
    $privilegios = selecionarDatosUsuario($id_usuario,"id_privilegio");

    session_start(); //start the PHP_session function 
    $_SESSION['usuario_actual'] = $id_usuario;
    
    //Si la validación ha salido bien enviamos por la url el nombre de usuario y su id
    if (!$pos)
        header('Location: '.$location.'?&login=true&user='.$user.'&idUser='.$id_usuario.'&idP='.$privilegios);
    else
        header('Location: '.$location.'&login=true&user='.$user.'&idUser='.$id_usuario.'&idP='.$privilegios);

}


?>
