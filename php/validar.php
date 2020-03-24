<?php
require_once ("seguridad.php");
$usuario=$_POST['usuario'];
$clave=$_POST['clave'];
$claveE=SED::encryption($clave);
require_once ("conexion.php");
$consulta="Select * from pla_usuario where nombreusuario='$usuario' and contrasena='$claveE'";
$query=$con->query($consulta);
if($query->num_rows>0){
    session_start();
    $_SESSION['usuario']=$usuario;
    header("Location:../cursos.html");
}
else header("Location:../index.html");
mysqli_free_result($query);
mysqli_close($con);
?>