<?php

    $nombreServer = "localhost";

    
    function conectarBD(){
    
        $mysqli = new mysqli($nombreServer,"SIBW", "SIBW", "wanderlust");
        if ($mysqli->connect_errno) {
            echo "Fallo al conectar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        $mysqli->set_charset("utf8");
        return $mysqli;
    }
   
    function seleccionarImagenesEventos()
    {   
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM eventos";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
        //echo " id = " . $fila['ruta_imagen'] . "\n";
            array_push($array,$fila['ruta_imagen']);
        }
        return $array;
    }
    function seleccionarEventos()
    {   
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM eventos";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            /*array_push($array,$fila['id']);
            array_push($array,$fila['titulo']);
            array_push($array,$fila['ruta_imagen']);*/
            array_push($array,$fila);
        }

        return $array;
    }
    function selecionarAtributosEvento($id,$attr)
    {  
        $mysqli = conectarBD();
        $sql = "SELECT * FROM eventos WHERE id =".$id;
        $resultado = $mysqli->query($sql);
        $fila = $resultado->fetch_assoc();

        return $fila[$attr];
    }
    function cargarComentarios($id){
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM comentarios WHERE id_evento =".$id." ORDER BY fecha DESC";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila);
        }

        return $array;
    }
    function validarComentario(){
        $nombre=$email=$texto=$estrellas=$idEvento = "";
        if (!empty($_POST["nombre"])) {
            $nombre = test_input($_POST["nombre"]);
        }
        
        if (filter_var( $_POST["email"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["email"];
        }

        if (!empty($_POST["texto"])) {
            $texto = test_input($_POST["texto"]);
            $palabras_prohibidas = seleccionarPalabrasProhibidas();
            for ($i = 0; $i < sizeof($palabras_prohibidas); $i++) {
               $texto = str_ireplace($palabras_prohibidas[$i],convertirAsteriscos($palabras_prohibidas[$i]),$texto);
            }
        }

        if (filter_var($_POST["idEvento"], FILTER_VALIDATE_INT)) {
            $idEvento = $_POST["idEvento"];
        }
        echo $nombre;echo $email; echo $texto; echo $idEvento;
        if ($nombre != "" && $email != "" && $texto != "" && $idEvento != ""){
            $estrellas = $_POST["estrellas"];
            echo insertarComentario($idEvento,$nombre,$email,$texto,$estrellas);
            return true;
        }else return false;

    }
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    function insertarComentario($id,$n,$e,$t,$s){
        $mysqli = conectarBD();
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO `comentarios`(`id_evento`, `ip`, `autor`, `email`, `valoracion`, `comentario`) 
                VALUES (".$id.",'".$ip."','".$n."','".$e."','".$s."','".$t."')";
        $mysqli->query($sql);
        return $sql;
    }
    function seleccionarPalabrasProhibidas()
    {  
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM palabras_prohibidas";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila['palabra']);
        }
        return $array;
    }
    function convertirAsteriscos($cadena){
        return str_repeat("*", strlen($cadena));
    }
    function obtenerImagenesGaleria($idEvento){
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM imagenes_eventos WHERE id_evento =".$idEvento;
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila['ruta_imagen']);
        }
        return $array;
    }
    function obtenerVideoEvento($idEvento){
        $mysqli = conectarBD();
        $sql = "SELECT * FROM videos_eventos WHERE id_evento =".$idEvento;
        $resultado = $mysqli->query($sql);
        $fila = $resultado->fetch_assoc();
        return $fila["ruta_video"];
    }
    function obtenerMenu(){
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM menu_principal";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila);
        }
        return $array;
    }
?>