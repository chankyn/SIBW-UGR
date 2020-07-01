<?php

/* Getting file name */
$filename = $_FILES['file']['name'];

/* Donde se guardan las imágenes nuevas. Por comodidad en la carpeta imagenes */
$location = "imagenes/".$filename;
$uploadOk = 1;
$imageFileType = pathinfo($location,PATHINFO_EXTENSION);

/* Extensiones que se permiten */
$valid_extensions = array("jpg","jpeg","png");
/* Comprueba que la extensión es válida. */
if( !in_array(strtolower($imageFileType),$valid_extensions) ) {
   $uploadOk = 0;
}

if($uploadOk == 0){
   echo 0;
}else{
   /* Subimos la imagen nueva */
   if(move_uploaded_file($_FILES['file']['tmp_name'],$location)){
      echo $location;
   }else{
      echo 0;
   }
}
?>