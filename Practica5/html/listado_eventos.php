<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);


comprobarPrivilegios(3);

if ($_REQUEST['search']){
    $param = $_REQUEST['search'];
    $array = busquedaEventos("titulo",$param);
}
else
    $array = seleccionarTodosEventos();

    $menu = obtenerMenu();

echo $twig->render('listado_eventos.html',
    [
    'eventos' => $array,
    'menu' => $menu
    ]
);

?>
