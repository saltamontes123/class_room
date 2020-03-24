<?php

$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$email=$_POST['email'];
$fecha_nacimiento=$_POST['fecha_nacimiento'];
$celular=$_POST['celular'];
$pais=$_POST['pais'];
$region=$_POST['region'];

require_once ("conexion.php");
$consulta="Select * from pla_usuario where email='$email'";
$query=$con->query($consulta);

if($query->num_rows>0){
echo "Usuario con email ".$email." ya existe.";
return;
//header("Location:../index.html");
}
else {
    $inserta="INSERT INTO pla_usuario (nombre, apellido,email,fecha_nacimiento,telefono, pais, region,fecha_registro) values ('$nombre','$apellido','$email','$fecha_nacimiento','$celular','$pais','$region',now())";
   
    $rres=$con->query($inserta);
  //  header("Location:../index.php");
    echo "Registro guardado satisfactoriamente.";
return;
}
mysqli_free_result($query);
mysqli_close($con);
?>