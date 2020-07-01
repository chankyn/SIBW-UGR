<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);


comprobarPrivilegios(4);

$array = obtenerTodosUsuarios();

$menu = obtenerMenu();

echo $twig->render('listado_usuarios.html',
    [
    'usuarios' => $array,
    'menu' => $menu
    ]
);

?>
