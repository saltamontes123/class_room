<?php
include "conexion.php";
//echo "actualizando...";
$iddocumento=$_GET['iddocumento'];//
$idcontenido=$_GET['idcontenido'];
//$iddocumento=1;
//$idcontenido=1;

$con->query("update pla_documentocontenido set descargas=descargas+1 where idcontenido=$idcontenido and iddocumento=$iddocumento");
/*$res=mysqli_fetch_array($con->query("Select descargas from pla_documentocontenido where idcontenido=$idcontenido and iddocumento=$iddocumento"));
echo $res['descargas'];*/
?>