<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);

$id_usuario = $_POST["id_usuario"];
if (filter_var($_POST["id_usuario"], FILTER_VALIDATE_INT)) {
    $id_usuario = $_POST["id_usuario"];
}else{
    echo "El id del usuario no es válido";
    header('Location: index.php?errorUser=true');
}

//Comprobamos que el usuario tiene los permisos requeridos para la accion
$privilegios = selecionarDatosUsuario($id_usuario,"id_privilegio");
if ($privilegios < 4){
    echo "No tienes privilegios suficientes para ejecutar esta acción.";
    header('Location: index.php?privilegios=error');
}

if (filter_var($_POST["id_evento"], FILTER_VALIDATE_INT)) {
    $id_evento = $_POST["id_evento"];
}else{
    echo "El id del evento no es válido";
    header('Location: index.php?id_evento=error');
}
$etiqueta = $_POST["etiqueta"];
if ($etiqueta == "Parrafo" || $etiqueta == "Texto" || $etiqueta == "Imagen"){
    $id_etiqueta = anadirEtiqueta($id_evento,$etiqueta);
    echo $id_etiqueta;
    //header( 'location: eventos.php?id='.$id_evento.'&id_etiqueta='.$id_etiqueta );
}
else
    header( 'location: eventos.php?id='.$id_evento.'&etiqueta=error');

?>
