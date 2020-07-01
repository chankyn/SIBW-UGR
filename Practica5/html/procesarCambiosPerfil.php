<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$id_usuario = $_POST["id_usuario"];
if (filter_var($_POST["id_usuario"], FILTER_VALIDATE_INT)) {
    $id_usuario = $_POST["id_usuario"];
}else{
    header('Location: index.php?id_usuario=error');
}
$mensaje_password = '';
if (!empty($_POST["passwordActual"])) {
    $passwordActual = test_input($_POST["passwordActual"]);
    $passwordBD = selecionarDatosUsuario($id_usuario,"password");
    if( $passwordActual != $passwordBD ){
        $mensaje_password = "&change_password=false";
    }
    else if (!empty($_POST["nuevaPassword"]) && !empty($_POST["nuevaPasswordR"]) ) {
        $nuevaPassword = $_POST["nuevaPassword"];
        $nuevaPasswordR = $_POST["nuevaPasswordR"];
        if( $nuevaPassword == $nuevaPasswordR){
            nuevosDatosPerfil($id_usuario,"password",$nuevaPassword);
            $mensaje_password = "&change_password=true";
        }
        else{
            $mensaje_password = "&change_password=false";
        }
            
    }
}
if (!empty($_POST["primer_apellido"])) {
    $primer_apellido = test_input($_POST["primer_apellido"]);
    nuevosDatosPerfil($id_usuario,"primer_apellido",$primer_apellido);
}
if (!empty($_POST["segundo_apellido"])) {
    $segundo_apellido = test_input($_POST["segundo_apellido"]);
    nuevosDatosPerfil($id_usuario,"segundo_apellido",$segundo_apellido);
    
}
if (!empty($_POST["direccion"])) {
    $direccion = test_input($_POST["direccion"]);
    nuevosDatosPerfil($id_usuario,"direccion",$direccion);
}
header('Location: users_profile.php?id_usuario='.$id_usuario.$mensaje_password);

?>
