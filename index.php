<?php
	require ('php/conexion.php');
	$query = "SELECT id,paisnombre FROM pais ORDER BY paisnombre";
	$resultado=$con->query($query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1, width=device-width">
    <meta name="description" content="Empresas de innovación digital y desarrollo tecnológico">
    <meta property="og:image" content="http://startup-bolivia.net/msd-innova/img/favicon.png">
    <title>IEBT</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="css/materialize.min.css">
    <link rel="stylesheet" href="css/materialize.css">
    <link rel="stylesheet" type="text/css" href="css/demo.css" />
    <link rel="stylesheet" type="text/css" href="css/style_common.css" />
    <link rel="" href="css/style.css">
    <link rel="icon" type="image/gif" href="img/favico.jpg"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/css/materialize.min.css" media="screen,projection" />
   <!-- aumenté estos scrpts para los combos de país y región -->
    <script language="javascript" src="js/jquery-3.1.1.min.js"></script>
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
   <!-- script para guardar sin salir de la página (con ajax)-->
   <script language="javascript">
		$(document).ready(function () {
    $("#formulario").bind("submit",function(){
        // Capturamnos el boton de envío
        var btnEnviar = $("#btnEnviar");
        $.ajax({
            type: $(this).attr("method"),
            url: $(this).attr("action"),
            data:$(this).serialize(),
            beforeSend: function(){
                /* Esta función se ejecuta durante el envió de la petición al  servidor. */
                // btnEnviar.text("Enviando"); Para button 
                btnEnviar.val("Enviando"); // Para input de tipo button
                btnEnviar.attr("disabled","disabled");
            },complete:function(data){
                /** Se ejecuta al termino de la petición* */
                btnEnviar.val("Comienza ahora");
                btnEnviar.removeAttr("disabled");
            },success: function(data){
                /** Se ejecuta cuando termina la petición y esta ha sido correcta* */
//                $(".respuesta").html(data);
                  alert(data);//muestra el mensaje que genera el archivo php
                  if(data=="Registro guardado satisfactoriamente.")
                  limpiar_campos();
            },error: function(data){
                /* * Se ejecuta si la peticón ha sido erronea* */
                alert("Problemas al tratar de enviar el formulario");
//                $respuesta.html(data);
  //              alert($respuesta);          }
        }});
        // Nos permite cancelar el envio del formulario
        return false;
    });
});
    </script>
    <script>
      function limpiar_campos(){
        $('input[type="text"]').val('');
        $('input[type="email"]').val('');
        $('select option[value="0"]').attr("selected", true);
        $('#region').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
      }
    </script>
   <!-- hasta aqui el script para guardar con ajax-->
  </head>
  <body>
    <header>
      <div class="navegador1">
        <nav>
          <div class="nav-wrapper"style="background-color:#ffffff; border-bottom: 5px solid #66CCCC;">
            <div class="">
              <a href="#" class="brand-logo"><img src="img/00lmsd001.png" class="resposive-img" width=300 height=55></a>
              <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons blue-text text-darken-4">menu</i></a>
              <ul class="right hide-on-med-and-down">
              </ul>
              <ul class="side-nav" id="mobile-demo" style="background-color: #66CCCC">
              <li><a class="waves-effect waves-light" style="color:#ffffff;" href="#inicio">Inicio</a></li>
              <li><a class="waves-effect waves-light" style="color:#ffffff;" href="#mision">¿Quiénes somos?</a></li>
              <li class="mision1"><a class="waves-effect waves-light" style="color:#66CCCC" href="#cursos">Cursos activos</a></li>
              <li><a class="waves-effect waves-light" style="color:#ffffff;" id="inscribir" href="#miInscripcion">Ingresa</a></li>
              <li><a class="waves-effect waves-light" style="color:#ffffff;" href="#contactos">Contactos</a></li>
            </ul>
          </div>
        </div>
       </nav>
      </div>
      <div class="navegador">
        <nav class="nav-wrapper" style="background-color:#ffffff;border-bottom: 5px solid #66CCCC;">
        <a href="#" class="brand-logo"><img src="img/00lmsd001.png" class="resposive-img" width=300 height=55></a>
            <ul class="right hide-on-med-and-down" id="menu-principal">
              <li class="inicio1" onclick=""><a class="waves-effect waves-light" style="color:#66CCCC" href="#inicio">Inicio</a></li>
              <li class="mision1"><a class="waves-effect waves-light" style="color:#66CCCC" href="#mision">¿Quiénes somos?</a></li>
              <li class="mision1"><a class="waves-effect waves-light" style="color:#66CCCC" href="#cursos">Cursos activos</a></li>
              <li><a class="waves-effect waves-light" style="color:#ffffff; background-color:#66CCCC" id="ingresar" href="#miInscripcion">Registrate</a></li>
              <li class="mision1"><a class="waves-effect waves-light" style="color:#66CCCC" href="login.php">Ingresar</a></li>
              <li class="contactos1"><a class="waves-effect waves-light" style="color:#66CCCC" href="#contactos">Contactos</a></li>
            </ul>
          </nav>
      </div>
    </header>
    <div class="">
        <div id="miInscripcion" class="inscribir_personal titulos flotante">
          <h5>Registra tus datos: </h5>
          <form id="formulario" action="php/agregarusuario.php" method="post">
            <input class="mi_input" type="text" id="nombre" name="nombre" placeholder="Nombre">
            <input class="mi_input" type="text" id="apellido" name="apellido" placeholder="Apellido"> <br>
            <input class="mi_input" type="email" id="email" name="email" placeholder="E-mail"><br>
            <input class="mi_input" type="text" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de nacimiento"><br>
            <input class="mi_input" type="text" id="celular" name="celular" placeholder="Número de celular"><br>
            

            <select name="pais" id="pais" class="browser-default" style="background-color:#fff; border-color:#ccc">
              <option value="0">--Seleccionar país--</option>
              <?php while($row = $resultado->fetch_assoc()) { ?>
                <option value="<?php echo $row['id']; ?>"><?php echo utf8_encode($row['paisnombre']); ?></option>
              <?php } ?>
            </select>
            <div><select name="region" id="region" class="browser-default" style="background-color:#fff; border-color:#ccc"></select></div>
            
            
            <label for="">Programa de interés *</label>
            <select name="programa" class="browser-default" style="background-color:#fff; border-color:#ccc placehoder='programa">
                <option>-- Seleccionar --</option>
                <option>Tecnología digital</option>
                <option>Diseño gráfico</option>
                <option>Negocio digital</option>
            </select>
            <br>
            <div class="boton-check">
              <i class="material-icons">save</i>
              <input type="submit" id="btnEnviar" name="btnEnviar" value="Comienza ahora">
              <!-- <a href="#" class="guardar boton" name="guardar" id="guardar"><i class="material-icons">save</i> Comienza ahora</a> -->
            </div>
          </form>
        </div>
        <div class="contenedor">
          <div id="frase">

          </div>
        </div>
        <div class="contenedor1">
        </div>
        <div class="contenedor2">
        </div>
    </div>
  <br>
  <br>
  <div class="row"  id="mision" style="background:#66CCCC">
  <div class="col l12 m6 s12">
      <h5 style="color:white">¿Quiénes somos?</h5>
  </div>
</div>
<div>       <!--   inicia ubicación -->
  <div class="col s-12" style="padding:20px 20px 20px 20px;">
        <table style="font-size:16px; color: grey; padding: 25px 25px 25px 25px;">
          <tr>
            <p style="width:100%;font-size:16px; color:grey; padding: 25px 25px 25px 25px; text-align:justify" >
              <span> La empresas</span>
              <span style="color:#66cccc;font-size:18px;">M</span>
              <span style="color:#ff9933;font-size:18px;">S</span>
              <span style="color:#00cc99;font-size:18px;">D</span>
              <span style="color:#006699;font-size:18px"> Innova</span>
              <span> se constituye en un componente importante del ecosistema de emprendimiento e innovación de Bolivia, como agente que promueve la tranformación digital de la sociedad, las empresas e instituciones, a través de promover la tranferencia de conocimiento, el desarrollo de productos tecnológicos y desarrollo web.
              <br> <br>Con más de 3 años de trabajo, la empresa tiene una cartera de clientes regionales, nacionales e internacionales.
              </span>
            </p>
          </tr>
          <tr>
            <td class="center" style="width:150px;">MISIÓN</td>
            <td style="width:400px;">Aportar con la transformación digital de profesionales, instituciones públicas y/o privadas, para lograr su mayor competitividad y productividad.</td>
          </tr>
          <tr>
            <td class="center" style="width:150px;">VISIÓN</td>
            <td style="width:400px;">Ser referente a nivel Latinoamérica en desarrollo de productos y servicios web a través de nuestro modelo de gestión de la innovación tecnológica, trabajando con competitividad, calidad y conectividad.</td>
          </tr>
          <tr>
            <td class="center"  style="width:150px;">VOCACIÓN</td>
            <td style="width:400px;">MSD Innova tiene como vocación el fomento de la innovación, la calidad y la gestión del conocimento, con compromiso y transparencia.</td>
          </tr>
        </table>
  </div>
</div>
<br>
<br>

<div class="row" style="background:#66CCCC" id="cursos">
<div class="col l12 m6 s12">
    <h5 style="color: white">Productos y servicios</h5>
</div>
</div>

<br>
<br>
<div class="row" style="background:#66CCCC" id="aliados">
<div class="col l-12 m-6 s-12">
    <h5 style="color: white">Aliados estratégicos y participación en asociaciones</h5>
</div>
</div>

<div class="row responsive" style="padding: 55px 25px 25px 25px;">
    <div class="col s12 m6 l3 center view ver-img">
      <a  href="http://relais-ead.com/" target="_blank"><img src="img/relais_internacional.jpg" class="responsive-img" alt="" width="250px" height="auto"></a>
      <div class="mask">
          <h5>Aliado internacional</h5>
          <p>Relais Internacional tiene sede en Washington D.C. EEUU</p>
          <a href="http://relais-ead.com/" target="_blank" class="info">Visita su web</a>
      </div>
      <!--<a href="http://relais-ead.com/" target="_blank">  <img src="img/relais_internacional.jpg" class="responsive-img img-aliados" alt="" width="250px" height="auto"></a>  -->
    </div>
    <div class="col s12 m6 l3 center view ver-img">
      <a href="http://generacenter.com/" target="_blank"><img src="img/cropped-generacenter-transp.png" class="responsive-img" alt="" width="250px" height="auto"></a>
      <div class="mask">
          <h5>Aliado nacional</h5>
          <p>GeneraCenter tiene como brazo articulador a GeneraKnow en Bolivia</p>
          <a href="http://generacenter.com/" target="_blank" class="info">Visita su web</a>
      </div>
      <!--  <a href="http://generacenter.com/" target="_blank"><img src="img/cropped-generacenter-transp.png" class="responsive-img img-aliados" alt="" width="250px" height="auto" class="responsive"></a>  -->
    </div>
    <div class="col s12 m6 l3 center view ver-img">
      <a  href="https://www.facebook.com/cbti.bolivia/" target="_blank"><img src="img/cbti.png" class="responsive-img" alt="" width="200px" height="auto"></a>
      <div class="mask">
          <h5>Asociación nacional TIC</h5>
          <p>Cámara Boliviana de Tecnologías</p>
          <a href="https://www.facebook.com/cbti.bolivia/" target="_blank" class="info">Visita su web</a>
      </div>
    <!--    <a href="https://www.facebook.com/ChuquisacaCETIC/" target="_blank"><img src="img/cetic.svg" alt="" class="responsive-img img-aliados" width="150px" height="auto" class="responsive"></a>  -->
    </div>
    <div class="col s12 m6 l3 center view ver-img">
      <a href="https://www.facebook.com/ChuquisacaCETIC/" target="_blank"><img src="img/cetic.svg" class="responsive-img" alt="" width="200px" height="auto"></a>
      <div class="mask">
          <h5>Asociación regional TIC</h5>
          <p>Cámara de Empresas de Tecnolgías de la Información y Comunicación</p>
          <a href="https://www.facebook.com/ChuquisacaCETIC/" target="_blank" class="info">Visita su web</a>
      </div>
    <!--    <a href="https://www.facebook.com/ChuquisacaCETIC/" target="_blank"><img src="img/cetic.svg" alt="" class="responsive-img img-aliados" width="150px" height="auto" class="responsive"></a>  -->
    </div>
  </div>
</div>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large" target="_blank" href="https://api.whatsapp.com/send?phone=59177121123&text=Hola,%20requiero%20información" style="background-color:white">
      <img src="img/whatsapp.jpg" class="circle responsive-img">
    </a>
</div>

<footer>
  <div class="row" style="background:#013F72" id="contactos">
    <div class="col l9 m6 s12">
      <h5 style="color:white;">Contacto</h5>
        <p style="font-size:14px;color:white;">Marlene Salinas D. Msc <br>
          Consultor en TIC e innovación digital <br>
          Celular (+591) 77121123 <br>
          Email <a href="">info@startup-bolivia.net</a>
          </p>
          <p style="font-size:14px;color:orange;">#InnovarEsCrecer</p>
          <br>
        <p style="font-size:14px;color:white;">
          <a href="https://www.facebook.com/marlenesdr100">@marlenesdr100 </a> Redes Sociales <br>
          Presidenta de <a href="https://www.facebook.com/ChuquisacaCETIC/?modal=admin_todo_tour">CETIC</a> <br>
          Miembro de <a href="https://www.facebook.com/cbti.bolivia/">CBTI</a>  <br>
          </p>
  </div>
  <div class="col l3 m6 s12">
    <br>
    <img src="img/logo.svg" class="responsive-img" alt="">
  </div>
</div>
</footer>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/jssor.slider.min.js.descarga" type="text/javascript"></script>
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" scr="/js/materialize.js"></script>
    <script src="js/modal.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script>$(".button-collapse").sideNav();</script>
</body>
</html>
