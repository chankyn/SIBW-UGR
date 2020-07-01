<?php 
include 'funcionesBD.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_REQUEST["term"])){
    $busqueda = $_REQUEST["term"];

    if ($_REQUEST["id_usuario"] == NULL) //Si no hay sesión de usuario hacemos la búsqueda normal.
        busquedaAjax($busqueda,"no_gestor");
    else{
        $id_usuario = $_REQUEST["id_usuario"];
        
        //Comprobamos que el usuario tiene los permisos requeridos para la accion
        $privilegios = selecionarDatosUsuario($id_usuario,"id_privilegio");
        if ($privilegios < 3){
            busquedaAjax($busqueda,"no_gestor");
        }else busquedaAjax($busqueda,"gestor");
    }
    
}


?>
