<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);

comprobarPrivilegios(3);

$menu = obtenerMenu();

echo $twig->render('nuevo_evento.html',
    [
    'menu' => $menu
    ]
);

?>
