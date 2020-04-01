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
	<link rel="stylesheet" href="css/materialize.css">
	<link rel="stylesheet" href="css/materialize.min.css">
  <link rel="icon" type="image/gif" href="img/favico.jpg"/>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<!-- aumenté estos scrpts para los combos de país y región -->
	<script language="javascript" src="js/jquery-3.1.1.min.js"></script>
	<script language="javascript">
		$(document).ready(function(){
			$("#pais").change(function () {
				$('#region').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
				$("#pais option:selected").each(function () {
					id_estado = $(this).val();
					$.post("php/getRegion.php", { id_estado: id_estado }, function(data){
		//				$("#region").append('<option value="0">--Seleccionar país--</option>');		
	//					$("#region").html('<option value="0">--Seleccionar país--</option>');
						
						$("#region").html(data);
	//					$("#region").prop('disabled', false)

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
		<div class="row contenedor deep-purple darken-3" style="margin-bottom: 0px;">
          <div class="col l6 offset-l5 navegador">  <!--navegador1  -->
    <!--        <nav>
              <div class="nav-wrapper"style="background-color:#ffffff; border-bottom: 5px solid #66CCCC;">
                <div class="">
                  <a href="#" class="brand-logo"><img src="img/00lmsd001.png" class="resposive-img" width=300 height=55></a>
                  <a href="#" data-activates="mobile-demo" class="button-collapse"><i class="material-icons blue-text text-darken-4">menu</i></a>
                  <ul class="right hide-on-med-and-down">
                  </ul>  -->
                  <ul> <!-- class="side-nav" id="mobile-demo" style="background-color: #66CCCC">   -->
                  <li><a class="texto" href="#mision">¿Quiénes somos?</a></li>  <!-- class="waves-effect waves-light" style="color:#ffffff;"-->
                  <li><a class="texto" href="#cursos">Nuestra oferta</a></li>  <!--class="waves-effect waves-light" style="color:#66CCCC" -->
                  <li><a class="texto" href="#miInscripcion">Consultas</a></li>  <!--class="waves-effect waves-light" style="color:#ffffff;" id="inscribir"  -->
                  <li><a class="texto modal-trigger" href="#login">Ingresa</a></li>  <!--class="waves-effect waves-light" style="color:#ffffff;" id="inscribir"  -->
                  <li><a class="boton" href="#contactos">Aplica</a></li>   <!--class="waves-effect waves-light" style="color:#ffffff;"   -->
                </ul>
    <!--          </div>
            </div>
          </nav>  -->
          </div>
					<div class="row" style="margin-bottom: 0px;">
						<div id="miInscripcion" class="inscripcion flotante">
							<h6 class="center">Para más información ingresa tus datos </h6>
							<br>
	             <form id="formulario" action="php/agregarusuario.php" method="post">
		            <input class="mi_input" type="text" id="nombre" name="nombre" placeholder="Nombre">
		            <input class="mi_input" type="text" id="apellido" name="apellido" placeholder="Apellido"> <br> 
		            <input class="mi_input" type="email" id="email" name="email" placeholder="E-mail"><br>
		            <input class="mi_input" type="text" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de nacimiento"><br>
		            <input class="mi_input" type="text" id="celular" name="celular" placeholder="Número de celular"><br>
				  					
					<select name="pais" id="pais" class="" style="background-color:#fff; border-color:#ccc">
		              <option value="0">--Seleccionar país--</option>
		              <?php while($row = $resultado->fetch_assoc()) { ?>
		                <option value="<?php echo $row['id']; ?>"><?php echo utf8_encode($row['paisnombre']); ?></option>
		              <?php } ?>
		            </select>
		            
						<select name="region" id="region" class="browser-default mi_input" style="font-size:14px;" font="color:blue">
 
</select>
					
								<br>
								<div id="lista_postres" class="input-field">
	                <select multiple class="icons" id="sel_postres">
	                  <option value="" disabled selected>Selecciona tus postres favoritos.</option>
	                  <option value="galleta" data-icon="img/galleta.png" class="left circle">Galleta</option>
	                  <option value="helado" data-icon="img/helado.png" class="left circle">Helado</option>
	                  <option value="torta_chocolate" data-icon="img/torta_chocolate.png" class="left circle">Torta de Chocolate</option>
	                </select>
	                <label>Postres</label>
	              </div>

								<div class="center">
									<input type="submit" class="boton" id="btnEnviar" name="btnEnviar" value="Comienza ahora">
								</div>
	          	</form>

            </div>

						<div class="col l8 texto1 titulos">

							<h1 class="texto1">Desarrolla al máximo el potencial de tu creatividad</h1>
							<h4 class="texto2">Te ofrecemos conocimientos creativos, un espacio de trabajo digital, alta personalización, los mejores speakers y mentores, redes internacionales y mucho más</h4>
						</div>
        </div>
    </div>

  <!--    <div class="navegador">
        <nav class="nav-wrapper" style="background-color:#ffffff;border-bottom: 5px solid #66CCCC;">
        <a href="#" class="brand-logo"><img src="img/00lmsd001.png" class="resposive-img" width=300 height=55></a>
            <ul class="right hide-on-med-and-down" id="menu-principal">
              <li class="inicio1" onclick=""><a class="waves-effect waves-light" style="color:#66CCCC" href="#inicio">Inicio</a></li>
              <li class="mision1"><a class="waves-effect waves-light" style="color:#66CCCC" href="#mision">¿Quiénes somos?</a></li>
              <li class="mision1"><a class="waves-effect waves-light" style="color:#66CCCC" href="#cursos">Cursos activos</a></li>
              <li><a class="waves-effect waves-light" style="color:#ffffff; background-color:#66CCCC" id="inscribir" href="#miInscripcion">Registrate</a></li>
              <li class="contactos1"><a class="waves-effect waves-light" style="color:#66CCCC" href="#contactos">Contactos</a></li>
            </ul>
          </nav>
      </div>
-->
<div class="row amber lighten-5 scene" style="margin-bottom: 0px;">
	<div class="magic">

	</div>
	<div class="col l8 titulos texto3">
		<br>
		<br>
		<h3 class="check-out">Ayudamos a los equipos a ahorrar tiempo en investigación, acelerando hasta 3 veces más rápido</h3>
	</div>
	<div class="col s12 m6 l12 titulos">
		<div class="col s12 m6 l4 ideas center">
			<img src="img/ideas0001.png" class="img_ideas1 responsive-img" id="img_prod1" alt="">
				<h6 class="texto3"> <br>Construya mejores ideas creativas</h6>
			<p class="texto3">
				Utilice toneladas de información sobre el consumidor y del mercado, ideas creativas y tendencias listas para usar, altamente adaptadas a sus necesidades.
			</p>
		</div>
		<div class="col s12 m6 l4 ideas center">
			<img src="img/ideas0011.png" class="img_ideas2 responsive-img" id="img_prod2" alt="">
			<h6 class="texto3"><br> Ejecute lluvia de ideas creativas más suaves</h6>
			<p class="texto3">
				Obtenga un espacio para que su equipo creativo comparta ideas e ideas, organice foros y debates
			</p>
		</div>
		<div class="col s12 m6 l4 ideas center">
			<img src="img/ideas0031.png" class="img_ideas3 responsive-img" id="img_prod3" alt="">
			<h6 class="texto3"><br>Presenta tus ideas de forma avanzada</h6>
			<p class="texto3">
				Crea proyectos con información relevante, modelo de negocios ágil y una red internacional de trabajo
			</p>
		</div>
	</div>
	<div class="col l-18 titulos offset-l4 texto3">
			<h3>Alimenta tu proyecto I+D+i con tendencias, herramentas ágiles, speakers, mentores...</h3>
			<br>
	</div>
	<div class="col s12 m6 l12 titulos">
		<div class="col s12 m6 l4 ideas center">
			<img src="img/incubacion0001.png" class="img_ideas1 responsive-img" id="img_incu1" alt="">
			<h6 class="texto3"> <br>Preincubación de empresas de base tecnológica</h6>
			<p class="texto3" id="p_prod">
				Idealización, hasta el desarrollo del proyecto I+D+i
			</p>
		</div>
		<div class="col s12 m6 l4 ideas center">
			<img src="img/incubacion0002.png" class="img_ideas2 responsive-img" id="img_incu2" alt="">
			<h6 class="texto3"> <br>Incubación de empresas de base tecnológica</h6>
			<p class="texto3" id="p_prod">
				Proceso de desarrollo empresarial y tecnológico
			</p>
		</div>
		<div class="col s12 m6 l4 ideas center">
			<img src="img/incubacion0003.png" class="img_ideas3 responsive-img" id="img_incu3"  alt="">
			<h6 class="texto3">Aceleración de empresas de base tecnológica</h6>
			<p class="texto3" id="p_prod">
				Crecimiento en etapa temprana y etapa de desarrollo. Búsqueda mercados
			</p>
		</div>
	</div>
	<div class="col l12 titulos">
		<div class="col l8 texto3">
			<br>
			<h3>Aliados estratégicos</h3>
			<br>
		</div>
	</div>
	<div class="row responsive center" style="margin-bottom: 0px;">
			<div class="row">
				<div class="col s12 m6 l6 center">
					<div class="col offset-l3 l6 center white aliados">
						<br>
						<a  href="http://relais-ead.com/" target="_blank"><img src="img/relais_internacional.jpg" class="responsive-img" alt="" width="250px" height="auto"></a>
						<div class="">
								<h5>Aliado internacional</h5>
								<p>Relais Internacional tiene sede en Washington D.C. EEUU</p>
								<a href="http://relais-ead.com/" target="_blank" class="info">Visita su web</a>
						</div>
					</div>
					<!--<a href="http://relais-ead.com/" target="_blank">  <img src="img/relais_internacional.jpg" class="responsive-img img-aliados" alt="" width="250px" height="auto"></a>  -->
				</div>

				<div class="col s12 m6 l6 center">
						<h5>Genera center</h5>
					<div class="col offset-l3 l6 center white aliados">	</div>
					<p>Hola	<a href="http://generacenter.com/" target="_blank"> </a>
					</p>

				</div>
			</div>
			<div class="row" style="margin-bottom: 0px;">
				<div class="col s12 m6 l6 center">
					<div class="col offset-l3 l6 center white aliados">
						<a  href="https://www.facebook.com/cbti.bolivia/" target="_blank"><img src="img/cbti.png" class="responsive-img" alt="" width="200px" height="auto"></a>
						<div class="">
								<h5>Asociación nacional TIC</h5>
								<p>Cámara Boliviana de Tecnologías</p>
								<a href="https://www.facebook.com/cbti.bolivia/" target="_blank" class="info">Visita su web</a>
						</div>
					</div>
				<!--    <a href="https://www.facebook.com/ChuquisacaCETIC/" target="_blank"><img src="img/cetic.svg" alt="" class="responsive-img img-aliados" width="150px" height="auto" class="responsive"></a>  -->
				</div>

				<div class="col s12 m6 l6 center">
					<div class="col offset-l3 l6 center white aliados">
						<a href="https://www.facebook.com/ChuquisacaCETIC/" target="_blank"><img src="img/cetic.svg" class="responsive-img" alt="" width="200px" height="auto"></a>
						<div class="">
								<h5>Asociación regional TIC</h5>
								<p>Cámara de Empresas de Tecnolgías de la Información y Comunicación</p>
								<a href="https://www.facebook.com/ChuquisacaCETIC/" target="_blank" class="info">Visita su web</a>
						</div>
				</div>
			</div>
		</div>
		<br><br>
	</div>
</div>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large" target="_blank" href="https://api.whatsapp.com/send?phone=59177121123&text=Hola,%20requiero%20información" style="background-color:white">
      <img src="img/whatsapp.jpg" class="circle responsive-img">
    </a>
</div>

<div class="row deep-purple darken-3" style="margin-bottom: 0px;">
	<div class="col l9 m6 s12">
			<br>
			<h4 class="texto1">Contacto</h4>
				<p class="texto2">Incubadora Aceleradora de Empresas de Base Tecnológica <br>
					Escenario de desarrollo socio productivo asociado al uso intensivo de tecnología digital<br>
					Celular (+591) 77121123 <br>
					<br>
					Email <a class="texto1" href="">info@startup-bolivia.net</a>
					</p>
					<p class="texto2">#InnovarEsCrecer</p>
					<br>
				<p class="texto2">
					Redes Sociales <br>
					<a class="texto1" href="https://www.facebook.com/marlenesdr100">@marlenesdr100 </a><br>
				</p>
	</div>
	<div id="login" class="modal" style="text-align: center">
		<modal-content>
		<h5>Ingresar</h5>
			<form id="autenticacion" action="php/validar.php" method="post">
				<input id='usuario' name="usuario" type="text" class="text" placeholder="e-mail" style="width:50%">
				<input id='clave' name="clave" type="password" class="text" placeholder="contraseña" style="width:50%">
				<br>
				<modal-footer ><input type="submit" class="modal-close"id="btnlogin" name="btnlogin" value="Aceptar"></modal-footer>
				<br>
			</form>
			</modal-content>
		</div>
	</div>
    <script src="js/vendor/jquery.js"></script>
    <script src="js/vendor/what-input.js"></script>
    <script src="js/jssor.slider.min.js.descarga" type="text/javascript"></script>
    <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
    <script type="text/javascript" scr="/js/materialize.js"></script>
    <script src="js/modal.js" charset="utf-8"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
    <script>$(".button-collapse").sideNav();</script>
    <script type="text/javascript" src="js/class.js"></script>
    <script>
     	$(document).ready(function(){
		     $('select').material_select();
		  });
    </script>
    <script>
      $(document).ready(function(){
        $('.modal').modal()
      });
    </script>
		<script type="text/javascript">
			$(document).ready(function() {
				var $magic = $(".magic"),
						magicWHalf = $magic.width()*2;
				$(document).on("mousemove", function(e) {
					$magic.css({"left": e.pageX - magicWHalf, "top": e.pageY - magicWHalf});
				});
			});
		</script>
		<script type="text/javascript" src="js/index.js"> </script>
  </body>
</html>
