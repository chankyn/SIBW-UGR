<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);

$array = seleccionarEventos();
$menu = obtenerMenu();

echo $twig->render('portada.html',
    [
        'eventos' => $array,
        'menu' => $menu
    ]);


?>
