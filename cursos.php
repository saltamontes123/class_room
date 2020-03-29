<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/class_room/php/conexion.php");
$usuario='1141962';
$materia=1;
$detallecontenido=1;
$sqlcursos="SELECT curso,m.materia, nombre, apellido
FROM pla_materia as m
INNER JOIN pla_curso as cu on m.codigocurso=cu.codigocurso 
INNER JOIN pla_usuariomateria as um on um.codigocurso=cu.codigocurso
INNER JOIN pla_usuariotipousuariocurso as utuc on um.codigocurso=utuc.codigocurso
INNER JOIN pla_usuario as u on u.numero_identidad=um.numero_identidad
LEFT JOIN pla_avance as av on av.numero_identidad=u.numero_identidad
WHERE u.numero_identidad='$usuario'";

$res=$con->query($sqlcursos);

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="initial-scale=1, width=device-width">
  <meta name="description" content="Empresas de innovación digital y desarrollo tecnológico">
  <meta property="og:image" content="http://startup-bolivia.net/msd-innova/img/favicon.png">
  <title>Mis cursos</title>
  <link rel="stylesheet" href="css/estilo.css">
  <link rel="stylesheet" href="css/materialize.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection" />
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
  <link rel="icon" type="image/gif" href="img/favico.jpg"/>
  </head>
<header>
</header>
  <body>
    <div class="row deep-purple darken-3" style="margin-bottom: 0px;">
      <div class="row">
        <div class="col l6">

        </div>
        <div class="col l6">
          <ul>
            <li><a class="texto" href="#mision">Mi perfil</a></li>
            <li><a class="texto" href="#cursos">Avances</a></li>
            <li><a class="boton" href="#contactos">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
      <!-- comienza el ciclo de recuperacion de todos los cursos activos del usuario  -->
      <?php 
      while ($row = mysqli_fetch_array($res)){
        $Materia=utf8_encode($row['materia']);
        ?>
      <div class="row">
        <div class="col l3 offset-l2 center avance">
            <br>
            <h5><?php echo $Materia; ?></h5>
              <p>20%</p>
            <div class="progress">
                <div class="determinate" style="width: 20%"></div>
            </div>
            <br>
            <input type="button" name="" class="boton" value="Iniciar">
            <br>
            <br>
        </div>
      <?php }?>


      </div>

    </div>

    </div>
    <div class=" col fixed-action-btn">
        <a class="btn-floating btn-large" target="_blank" href="https://api.whatsapp.com/send?phone=59177121123&text=Hola,%20requiero%20información" style="background-color:white">
          <img src="img/whatsapp.jpg" class="circle responsive-img">
        </a>
    </div>

    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
    <script type="text/javascript" src="js/class.js"></script>


<!--    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script>$(".button-collapse").sideNav();</script>  -->
</body>
</html>
