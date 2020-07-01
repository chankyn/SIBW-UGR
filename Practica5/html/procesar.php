<?php 
include 'funcionesBD.php';
$idEvento = $_POST["idEvento"];

comprobarPrivilegios(1);
if(!validarComentario())
    header('Location: eventos.php?id='.$idEvento.'&error=true');
else
   header('Location: eventos.php?id='.$idEvento);
?>
