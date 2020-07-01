<?php
    function conectarBD(){
        $nombreServer = "localhost";
    
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
        $sql = "SELECT * FROM eventos WHERE publicado = 1";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila);
        }

        return $array;
    }
    function seleccionarTodosEventos()
    {   
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM eventos";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {

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
    function registrarUsuario($nombre,$password,$email){
        $mysqli = conectarBD();
        $sql = "INSERT INTO `usuarios`(`id_usuario`, `id_privilegio`, `nombre`, `password`, `primer_apellido`, `segundo_apellido`, `direccion`, `email`)
                VALUES (NULL, '1', '".$nombre."', '".$password."', NULL, NULL, NULL, '".$email."')";
        $mysqli->query($sql);

    }
    function comprobarUsuarioUnico($nombre){
        $mysqli = conectarBD();
        $sql = "SELECT * FROM usuarios WHERE nombre='".$nombre."'";
        $result = $mysqli->query($sql);
        
        return $result->num_rows;
    }

    function comprobarCorreoUnico($email){
        $mysqli = conectarBD();
        $sql = "SELECT * FROM usuarios WHERE email='".$email."'";
        $result = $mysqli->query($sql);
        
        return $result->num_rows;
    }
    function validarRegistroUsuario(){
        $nombre=$password=$email = "";
        if (!empty($_POST["reUser"])) {
            $nombre = test_input($_POST["reUser"]);
            $registrados = comprobarUsuarioUnico($nombre);
            if ($registrados > 0)
                return 2;
        }
        
        if (filter_var( $_POST["reMail"], FILTER_VALIDATE_EMAIL)) {
            $email = $_POST["reMail"];
            $registra2 = comprobarCorreoUnico($email);
            if ($registra2> 0)
                return 3;
        }

        if (!empty($_POST["rePassword"])) {
            $password = $_POST["rePassword"];
        }
        echo $registrados;
            echo $registra2;
        if ($nombre != "" && $email != "" && $password != ""){
            registrarUsuario($nombre,$password,$email);
            
            return 0;
        }else return 1;

    }
    function validarLogin(){
        $nombre=$password= "";
        if (!empty($_POST["nombreUser"])) {
            $nombre = test_input($_POST["nombreUser"]);
        }
        if (!empty($_POST["passwordUser"])) {
            $password = $_POST["passwordUser"];
        }
        if ($nombre != "" && $password != ""){
            if (correspondeUserPass($nombre,$password) > 0 )
                return true;
        }
        return false;
    }
    function correspondeUserPass($u,$p){
        $mysqli = conectarBD();
        $sql = 'SELECT * FROM usuarios WHERE nombre ="'.$u.'" AND password = "'.$p.'"';
        $result = $mysqli->query($sql);
        
        return $result->num_rows;
    }
    
    function selecionarDatosUsuario($id,$attr)
    {  
        $mysqli = conectarBD();
        $sql = "SELECT * FROM usuarios WHERE id_usuario =".$id;
        $resultado = $mysqli->query($sql);
        $fila = $resultado->fetch_assoc();
        
        return $fila[$attr];
    }
    function obtenerIdUsuario($nombre_usuario)
    {   
        $mysqli = conectarBD();
        $sql = 'SELECT * FROM usuarios WHERE nombre ="'.$nombre_usuario.'"';
        $resultado = $mysqli->query($sql);
        $fila = $resultado->fetch_assoc();
        return $fila["id_usuario"];
    }
    function nuevosDatosPerfil($id_usuario,$attr,$nattr){
        $mysqli = conectarBD();
        $sql = 'UPDATE usuarios SET '.$attr.'="'.$nattr.'" WHERE id_usuario='.$id_usuario;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }

    function actualizarDatosEvento($id_evento,$titulo,$fecha,$descripcion,$descripcion_avanzada){
        $mysqli = conectarBD();
        $sql = 'UPDATE eventos SET titulo="'.$titulo.'", fecha="'.$fecha.'", descripcion="'.$descripcion.'", descripcion_avanzada="'.$descripcion_avanzada.'" WHERE id='.$id_evento;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }
    function eliminarEvento($id_evento){
        $mysqli = conectarBD();
        $sql = 'DELETE FROM eventos WHERE id='.$id_evento;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }
    function eliminarComentario($id_comentario){
        $mysqli = conectarBD();
        $sql = 'DELETE FROM comentarios WHERE id_comentario='.$id_comentario;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }

    function obtenerImagenesServidor(){
        $array = array();
        $imagenes = glob("imagenes/*.*");
        for ($i=1; $i<count($imagenes); $i++)
        {
            $imagen = $imagenes[$i];
            array_push($array,$imagen);
        }
        return $array;
    }
    function nuevosDatosEventos($id_evento,$attr,$nattr){
        $mysqli = conectarBD();
        $sql = 'UPDATE eventos SET '.$attr.'="'.$nattr.'" WHERE id='.$id_evento;
        echo $sql;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }
    function nuevoEvento($titulo,$fecha,$descripcion,$descripcion_avanzada,$ruta_imagen,$ruta_imagen_secundaria){
        $mysqli = conectarBD();
        $ip = $_SERVER['REMOTE_ADDR'];
        $sql = "INSERT INTO `eventos`(`titulo`, `fecha`, `descripcion`, `descripcion_avanzada`, `ruta_imagen`, `ruta_imagen_secundaria`) 
                VALUES ('".$titulo."','".$fecha."','".$descripcion."','".$descripcion_avanzada."','".$ruta_imagen."','".$ruta_imagen_secundaria."')";
        $mysqli->query($sql);
        echo $sql;
    }
    function busquedaEventos($colum,$parametro){
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM eventos WHERE ".$colum." LIKE '%".$parametro."%'";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {

            array_push($array,$fila);
        }

        return $array;
    }
    function busquedaComentarios($colum,$parametro){
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM comentarios WHERE ".$colum." LIKE '%".$parametro."%'";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {

            array_push($array,$fila);
        }

        return $array;
    }
    function obtenerTodosUsuarios()
    {   
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM usuarios";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila);
        }

        return $array;
    }
    function nuevoRol($id_usuario,$nattr){
        $mysqli = conectarBD();
        $sql = 'UPDATE usuarios SET id_privilegio ='.$nattr.' WHERE id_usuario='.$id_usuario;
        $resultado = $mysqli->query($sql);
        echo $sql;
        return $resultado;
    }
    function obtenerNumSuperusuariosSistema(){
        $mysqli = conectarBD();
        $sql = "SELECT * FROM usuarios WHERE id_privilegio=4";
        $result = $mysqli->query($sql);
        
        return $result->num_rows;
    }
    function anadirEtiqueta($id_evento,$tipo){
        $mysqli = conectarBD();
        $sql = "INSERT INTO `etiquetas_eventos`(`id_evento`, `etiqueta`) 
                VALUES (".$id_evento.",'".$tipo."')";
        $mysqli->query($sql);
        return $mysqli->insert_id;
    }
    function obtenerEtiquetasEvento(){
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM etiquetas_eventos";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila);
        }
        return $array;
    }
    function eliminarEtiqueta($id_etiqueta){
        $mysqli = conectarBD();
        $sql = 'DELETE FROM etiquetas_eventos WHERE id_etiqueta='.$id_etiqueta;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }

    function nuevosDatosEtiqueta($id_etiqueta,$attr,$nattr){
        $mysqli = conectarBD();
        $sql = 'UPDATE etiquetas_eventos SET '.$attr.'="'.$nattr.'" WHERE id_etiqueta='.$id_etiqueta;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }
    function seleccionarComentarios()
    {   
        $array = array();
        $mysqli = conectarBD();
        $sql = "SELECT * FROM comentarios";
        $resultado = $mysqli->query($sql);
        while ($fila = $resultado->fetch_assoc()) {
            array_push($array,$fila);
        }

        return $array;
    }
    function nuevoTextoComentario($id_comentario,$nattr){
        $mysqli = conectarBD();
        $sql = 'UPDATE comentarios SET comentario="'.$nattr.'*Mensaje editado por el moderador" WHERE id_comentario='.$id_comentario;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }
    function comprobarPrivilegios($privilegios_requeridos){
        //Obtenemos el id por request para comprobar el usuario.
        if (filter_var($_REQUEST["id_usuario"], FILTER_VALIDATE_INT)) {
            $id_usuario = $_REQUEST["id_usuario"];
        }else{
            header('Location: index.php?errorUser=true');
        }
        
        //Comprueba que el usuario de la sesión sea el mismo que hemos indicado por parámetro.
        session_start();
        $id_usuario_sesion = $_SESSION['usuario_actual'];

        if ($id_usuario_sesion != $id_usuario){
            header('Location: index.php?id_user_error=true');

        }

        //Comprobamos que el usuario tiene los permisos requeridos para la accion
        $privilegios = selecionarDatosUsuario($id_usuario,"id_privilegio");
        if ($privilegios < $privilegios_requeridos){
            echo "No tienes privilegios suficientes para ejecutar esta acción.";
            header('Location: index.php?privilegios=error');
        }
    }

    function busquedaAjax($busqueda,$es_gestor){
        if($es_gestor == "gestor")
            $sql = "SELECT * FROM eventos WHERE titulo LIKE ? OR descripcion LIKE ?";
        else 
            $sql = "SELECT * FROM eventos WHERE publicado = 1 AND titulo LIKE ? OR descripcion LIKE ?";
        $mysqli = conectarBD();
        $array = array();
        if($sentencia = $mysqli->prepare($sql)){
            $buscame = '%'.$busqueda.'%';
            //Añadimos los parámetros a la sentencia preparada, s de string
            $sentencia->bind_param("ss", $buscame, $buscame);
            
            // Ejecución de la sentencia
            if($sentencia->execute()){
                $result = $sentencia->get_result();
                // Miramos si hay resultados...
                if($result->num_rows> 0){
                    // Obtenemos los eventos
                    while ($fila = $result->fetch_assoc()) {
                        echo $fila['titulo']."|".$fila['id']."|";
                    }
                    $sentencia->close();
                } else{
                    echo 'No hay coincidencias';
                }
            } else{
                echo "ERROR: Could not able to execute $sql";
            }
        }
    }
    function publicarEvento($id_evento){
        $mysqli = conectarBD();
        $sql = 'UPDATE eventos SET publicado = 1 WHERE id='.$id_evento;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }
    function despublicarEvento($id_evento){
        $mysqli = conectarBD();
        $sql = 'UPDATE eventos SET publicado = 0 WHERE id='.$id_evento;
        $resultado = $mysqli->query($sql);
        return $resultado;
    }
?>
