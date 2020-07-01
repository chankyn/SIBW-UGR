<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);

comprobarPrivilegios(1);

$id_usuario = $_REQUEST['id_usuario'];
$id_privilegio = selecionarDatosUsuario($id_usuario,"id_privilegio");
$nombreUsuario = selecionarDatosUsuario($id_usuario,"nombre");
$password = selecionarDatosUsuario($id_usuario,"password");
$primer_apellido = selecionarDatosUsuario($id_usuario,"primer_apellido");
$segundo_apellido = selecionarDatosUsuario($id_usuario,"segundo_apellido");
$direccion = selecionarDatosUsuario($id_usuario,"direccion");
$email = selecionarDatosUsuario($id_usuario,"email");

$menu = obtenerMenu();

echo $twig->render('profile.html',
    [
    'id_privilegio' => $id_privilegio,
    'nombreUsuario' => $nombreUsuario,
    'password' => $password,
    'primer_apellido' => $primer_apellido,
    'segundo_apellido' => $segundo_apellido,
    'direccion' => $direccion,
    'email' => $email,
    'menu' => $menu
    ]
);

?>
