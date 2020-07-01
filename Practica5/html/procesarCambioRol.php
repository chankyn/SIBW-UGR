<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


comprobarPrivilegios(4);

$id_usuario = $_REQUEST["id_usuario"];

if (filter_var($_REQUEST["usuario_cambio"], FILTER_VALIDATE_INT)) {
    $usuario_cambio = $_REQUEST["usuario_cambio"];
}else{
    echo "El id de usuario introducido no es válido";
    header('Location: index.php?id_usuario=error');
}

if (filter_var($_REQUEST["nuevo_rol"], FILTER_VALIDATE_INT)) {
    $nuevo_rol = $_REQUEST["nuevo_rol"];
}else{
    echo "El nuevo privilegio introducido no es válido";
    header('Location: index.php?id_privilegio=error');
}
$privilegios = selecionarDatosUsuario($id_usuario,"id_privilegio");
$num_superusuario = obtenerNumSuperusuariosSistema();

if ($privilegios == 4 && $usuario_cambio == $id_usuario && $num_superusuario < 2)
    header('Location: listado_usuarios.php?id_usuario='.$id_usuario.'&num_superusuarios=error');
else{
    nuevoRol($usuario_cambio,$nuevo_rol);
    header( "location: listado_usuarios.php?id_usuario=".$id_usuario);
}




?>
