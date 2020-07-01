<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


$id_comentario = $_POST["id_comentario"];

if (filter_var($_POST["id_comentario"], FILTER_VALIDATE_INT)) {
    $id_comentario = $_POST["id_comentario"];
}else{
    echo "El id del comentario no es válido";
    header('Location: index.php?id_comentario=error');
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
if ($privilegios < 2){
    echo "No tienes privilegios suficientes para ejecutar esta acción.";
}else{
    $nuevo_comentario = $_POST["nuevo_texto"];
    nuevoTextoComentario($id_comentario,$nuevo_comentario);
    echo "Se ha editado el comentario seleccionado. Redirigiendo...";
    
}



?>
