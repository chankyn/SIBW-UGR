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

$id_usuario = $_POST["id_usuario"];
if (filter_var($_POST["id_usuario"], FILTER_VALIDATE_INT)) {
    $id_usuario = $_POST["id_usuario"];
}else{
    echo "El id del usuario no es válido";
    header('Location: index.php?errorUser=true');
}

session_start();
$id_usuario_sesion = $_SESSION['usuario_actual'];

if ($id_usuario_sesion != $id_usuario)
    header('Location: index.php?id_user_error=true');

//Comprobamos que el usuario tiene los permisos requeridos para la accion
$privilegios = selecionarDatosUsuario($id_usuario,"id_privilegio");
if ($privilegios < 3){
    echo "No tienes privilegios suficientes para ejecutar esta acción.";
}else{
    eliminarEvento($id_evento);
    echo "Se ha eliminado el evento seleccionado. Redirigiendo a la página principal..";
    
}



?>
