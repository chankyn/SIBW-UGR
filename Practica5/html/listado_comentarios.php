<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);


comprobarPrivilegios(2);

if ($_REQUEST['search']){
    $param = $_REQUEST['search'];
    $array = busquedaComentarios("comentario",$param);
}
else
    $array = seleccionarComentarios();

    $menu = obtenerMenu();

echo $twig->render('listado_comentarios.html',
    [
    'comentarios' => $array,
    'menu' => $menu
    ]
);

?>
