<?php
require_once ("seguridad.php");
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
$claveE=SED::encryption($clave);
require_once ("conexion.php");
$consulta="Select * from pla_usuario where nombreusuario='$usuario' and clave='$claveE'";

$query=$con->query($consulta);
if($query->num_rows>0){
    session_start();
    $_SESSION['usuario']=$usuario;
    header("Location:../class.php");
}
else
 header("Location:../index.php");
mysqli_free_result($query);
mysqli_close($con);
?>