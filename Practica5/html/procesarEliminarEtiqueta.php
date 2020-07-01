<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$id_etiqueta = $_POST["id_etiqueta"];

if (filter_var($_POST["id_etiqueta"], FILTER_VALIDATE_INT)) {
    $id_etiqueta = $_POST["id_etiqueta"];
}else{
    echo "La etiqueta seleccionada no es válida";
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
    eliminarEtiqueta($id_etiqueta);
    echo "Se ha eliminado el elemento seleccionado.";
    
}



?>
