<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/class_room/php/conexion.php");
$usuario='1141962';
$materia=1;
$detallecontenido=1;


$temas="select distinct cu.codigocurso as curso,ma.sigla AS materia , te.idtema,te.titulo as tema
from pla_curso as cu
INNER JOIN pla_materia as ma on cu.codigocurso=ma.codigocurso
INNER JOIN pla_tema as te on ma.idmateria=te.idmateria
ORDER BY idtema ASC ";

$restemas=$con->query($temas);


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <meta name="description" content="Empresas de innovación digital y desarrollo tecnológico">
    <meta property="og:image" content="http://startup-bolivia.net/msd-innova/img/favicon.png">
    <title>Class</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/estilo_class.css">
    <script>document.getElementsByTagName("html")[0].className += " js";</script>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/materialize.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="icon" type="image/gif" href="img/favico.jpg"/>
        <!-- aumenté estos scrpts para actualizar el contenido con ajax -->
        <script language="javascript" src="/js/jquery-3.1.1.min.js"></script>
       <!-- para cargar el contenido   -->
    <script>
      function cargarcontenido(div,url)
      {
        //alert("Hola");
        $(div).load(url);
      }
    </script>
 
    <script language="javascript">
			$(document).ready(function(){
				$("#pais").change(function () {

					$('#region').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					
					$("#pais option:selected").each(function () {
						id_estado = $(this).val();
						$.post("php/getRegion.php", { id_estado: id_estado }, function(data){
							$("#region").html(data);
						});            
					});
				})
			});
		</script>
   <!-- hasta aquí para país y región-->
  </head>
<header>
</header>
  <body>
    <div class="row deep-purple darken-4" style="margin-bottom: 0px;">
      <div class="row">
        <div class="col l8">
          <img src="img/logo.jpg" alt="">

        </div>
        <div class="col l3">
          <ul>
            <li><a class="texto" href="#mision">Mis cursos</a></li>
            <li><a class="texto" href="#cursos">Avances</a></li>
            <li><a class="boton" href="#contactos">Cerrar sesión</a></li>
          </ul>
        </div>
      </div>
        <br>
          <div class="row text-component">
            <div class="col l3 scrollbar" id="style-4">
             

              <h5 class="texto3 white">Desarrollo web</h5>
              <!-- desde aqui se va a rellenar el arbolde TEMAS y contenidos -->
              <?php while($rowtema=mysqli_fetch_array($restemas)){
                  $tema=$rowtema['tema'];
                  $idtema=$rowtema['idtema'];
                  
                ?>
              <ul class="cd-accordion cd-accordion--animated margin-top-lg margin-bottom-lg">
                <li class="cd-accordion__item cd-accordion__item--has-children">
                  <input class="cd-accordion__input" type="checkbox" name ="<?php echo 'group-'.$idtema;?>" id="<?php echo 'group-'.$idtema;?>">
                  <label class="cd-accordion__label cd-accordion__label--icon-folder" for="<?php echo 'group-'.$idtema;?>"><span><?php echo utf8_encode($tema); ?></span></label>
                  <!-- Aqui pondremos los contenidos  -->
            
                  <?php
                  $contenidos="select distinct cu.codigocurso as curso,ma.sigla AS materia , te.idtema,te.titulo as tema,co.idcontenido,co.descripcion as contenido
                  from pla_curso as cu
                  INNER JOIN pla_materia as ma on cu.codigocurso=ma.codigocurso
                  INNER JOIN pla_tema as te on ma.idmateria=te.idmateria
                  INNER JOIN pla_contenido as co on te.idtema=co.idtema
                  Where co.idtema=$idtema
                  ORDER BY idtema,co.orden ASC ";       
                    $rescontenidos=$con->query($contenidos); 
                    
                    while( $rowcontenido=mysqli_fetch_array($rescontenidos)){
                    $contenido=$rowcontenido['contenido'];
                    $idcontenido=$rowcontenido['idcontenido'];
                  ?>
                    <ul class="cd-accordion__sub cd-accordion__sub--l1">
                      <li class="cd-accordion__item cd-accordion__item--has-children">
                        <input class="cd-accordion__input" type="checkbox" name ="<?php echo 'sub-group-'.$idcontenido;?>" id="<?php echo 'sub-group-'.$idcontenido;?>" onclick='cargarcontenido("#contenido","php/contenido.php");'>
                       e <label class="cd-accordion__label cd-accordion__label--icon-folder" for="<?php echo 'sub-group-'.$idcontenido;?>"><span><?php echo utf8_encode($contenido);?></span></labl>
                     </li>
                    </ul>
                  <?php 
                    
                    };
                    mysqli_free_result($rescontenidos);
                    $contenidos=""; ?>
                
                </li>
              </ul>
              <?php }?>
 

            </div>

            <div class="col l9 white" style="height:30em">
              <div class="col l12" name="contenido" id="contenido">

                <h6>Desarrollo Web/Lección 3: Crear una aplicación Node.js</h6>
                <h4>Lección 3: Crear una aplicación Node.js</h4>
                <h6>Integrando el front y back-end</h6>
              </div>
              <div class="col offset-s1 l11">
                <iframe width="460" height="255" src="https://www.youtube.com/watch?v=I75CUdSJifw" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
              </div>
              <div class="col l12">
                <a href="download/acme-doc-2.0.1.txt" download="Acme Documentation (ver. 2.0.1).txt">Download Text</a>
                <a href="download/acme-doc-2.0.1.txt" download="Acme Documentation (ver. 2.0.1).txt">Download PDF</a>
              </div>
            </div>
          </div>
        </div>
      
  </body>
  <script src="js/util.js"></script>
  <script src="js/main.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

  <div class="demo-avd demo-avd-cf demo-avd--light js-demo-avd" style="bottom: 30px; left: 30px; top: auto;"></div>
<!--  <script src="js/demo-avd.js"></script>   -->
  <script>
    (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-48014931-1', 'codyhouse.co');
      ga('set', 'anonymizeIp', true);
      ga('send', 'pageview');
  </script>
</html>
