<?php 
include 'funcionesBD.php';
require_once 'vendor/autoload.php';

$loader = new \Twig\Loader\FilesystemLoader('templates');
$twig = new \Twig\Environment($loader,[ ]);

$idEvento = $_REQUEST["id"];
if (filter_var($_REQUEST["id"], FILTER_VALIDATE_INT)) {
    $idEvento = $_REQUEST["id"];
    $nEventos = sizeof(seleccionarImagenesEventos());
    if ($idEvento > $nEventos)
        header('Location: eventos.php?id=1&error2=true');
    
}else{
    header('Location: eventos.php?id=1&error2=true');
}
$tituloEvento = selecionarAtributosEvento($idEvento,"titulo");
$fechaEvento = selecionarAtributosEvento($idEvento,"fecha");
$rutaImagenEvento = selecionarAtributosEvento($idEvento,"ruta_imagen");
$rutaImagenSEvento = selecionarAtributosEvento($idEvento,"ruta_imagen_secundaria");
$descripcionEvento = selecionarAtributosEvento($idEvento,"descripcion");
$descripcionAvanzadaEvento = selecionarAtributosEvento($idEvento,"descripcion_avanzada");
$fecha_creacion = selecionarAtributosEvento($idEvento,"fecha_creacion");
$fecha_modificacion = selecionarAtributosEvento($idEvento,"ultima_modificacion");
$galeria = obtenerImagenesGaleria($idEvento);

$comentarios = cargarComentarios($idEvento);
$video = obtenerVideoEvento($idEvento);

$menu = obtenerMenu();

echo $twig->render('eventos.html',
    [
    'id' => $idEvento,
    'titulo' => $tituloEvento,
    'ruta_imagen' => $rutaImagenEvento,
    'ruta_imagen_secundaria' => $rutaImagenSEvento,
    'descripcion' => $descripcionEvento,
    'descripcion_avanzada' => $descripcionAvanzadaEvento,
    'fecha' => $fechaEvento,
    'comentarios' => $comentarios,
    'fecha_creacion' => $fecha_creacion,
    'fecha_modificacion' => $fecha_modificacion,
    'galeria' => $galeria,
    'video' => $video,
    'menu' => $menu
    ]
);

?>
