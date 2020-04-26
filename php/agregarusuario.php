<?php

$nombre=$_POST['nombre'];
$apellido=$_POST['apellido'];
$email=$_POST['email'];
$fecha_nacimiento=$_POST['fecha_nacimiento'];
$celular=$_POST['celular'];
$pais=$_POST['pais'];
$region=$_POST['region'];
if(isset($_POST['zona'])){$zona=$_POST['zona'];}else{$zona="";}
if(isset($_POST['sexo'])){$sexo=$_POST['sexo'];}else{$sexo=-1;}
if(isset($_POST['ocupacion'])){$ocupacion=$_POST['ocupacion'];}else{$ocupacion="";}
if(isset($_POST['coordenadas'])){$coordenadas=$_POST['coordenadas'];}else{$coordenadas="0 0";}
//$sexo=$_POST['sexo'];
//$ocupacion=$_POST['ocupacion'];
//$coordenadas=$_POST['coordenadas'];
// reconoce si hay areas de interes y tambien las almacena 
$area1=$_POST['area1'];
$area2=$_POST['area2'];
$area3=$_POST['area3'];


require_once ("conexion.php");
$consulta="Select * from pla_usuario where email='$email'";
$query=$con->query($consulta);

if($query->num_rows>0){
echo "Usuario con email ".$email." ya existe.";

//header("Location:../index.html");
}
else {
    $inserta="INSERT INTO pla_usuario (nombre, apellido,email,fecha_nacimiento,telefono, pais, region,fecha_registro,sexo,zona,ocupacion,coordenadas) values ('$nombre','$apellido','$email','$fecha_nacimiento','$celular','$pais','$region',now(),$sexo,'$zona','$ocupacion',geomfromtext('point($coordenadas)'))";
   
    $rres=$con->query($inserta);
    $id=mysqli_insert_id($con);
  //  header("Location:../index.php");
    echo "Registro guardado satisfactoriamente.";

}
// guarda las areas de interes si estas existen 
if(isset($area1)){
  $sqlareas= "INSERT into pla_areadeinteres (area, numero_identidad, estado) values ('$area1','$id',1)";
  $res2=$con->query($sqlareas);
}
if(isset($area2)){
  $sqlareas= "INSERT into pla_areadeinteres (area, numero_identidad, estado) values ('$area2','$id',1)";
  $res2=$con->query($sqlareas);
}
if(isset($area3)){
  $sqlareas= "INSERT into pla_areadeinteres (area, numero_identidad, estado) values ('$area3','$id',1)";
  $res2=$con->query($sqlareas);
}
mysqli_free_result($query);
mysqli_close($con);
?>