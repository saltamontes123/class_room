<?php
	require ('php/conexion.php');
	$query = "SELECT id, paisnombre FROM pais ORDER BY paisnombre";
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
		function getregion(sel){
				$('#region').find('option').remove().end().append('<option value="whatever"></option>').val('whatever');
					id_estado = sel.value;
					$.post("php/getRegion.php", { id_estado: id_estado }, function(data){
						$("#region").html(data);
					});
				}
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
      		<div class="row embazado" style="margin-bottom: 0px;">
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
                        <li><a class="boton" href="index.php"><i class="material-icons">home</i></a></li>   <!--class="waves-effect waves-light" style="color:#ffffff;"   -->
                      </ul>
          <!--          </div>
                  </div>
                </nav>  -->
                </div>
            </div>
                <div class="row cuerpo" style="margin-bottom: 0px;">
                  <br><br>
                  <h3 class="texto1 center">Para más información ingresa tus datos</h3>
                  <div class="col l8 offset-l2 inputs inscripcion texto0">
                    <br><br>
                     <form id="formulario" action="php/agregarusuario.php" method="post">
                      <input class="mi_input" type="text" id="nombre" name="nombre" placeholder="Nombre completo">
                      <input class="mi_input" type="text" id="apellido" name="apellido" placeholder="Apellido"> <br>
                      <input class="mi_input" type="email" id="email" name="email" placeholder="E-mail"><br>
											<input class="datepicker" type="date" id="fecha_nacimiento" name="fecha_nacimiento" placeholder="Fecha de nacimiento"><br>
                    	<input class="mi_input" type="text" id="celular" name="celular" placeholder="Número de celular"><br>
											<br>
											<div class="">
                        <label for="">País</label>
                        <select name="pais" id="pais" class="browser-default input-field" onchange="getregion(this);">
                          <option value="0">--Seleccionar país--</option>
                          <?php while($row = $resultado->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo utf8_encode($row['paisnombre']); ?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div>
                        <label for="">Ciudad </label>
                        <select name="region" id="region" class="browser-default" style="background-color:#fff; border-color:#ccc">
							<option value="0">--Seleccionar ciudad--</option>
                          <?php while($row = $resultado->fetch_assoc()) { ?>
                            <option value="<?php echo $row['id']; ?>"><?php echo utf8_encode($row['paisnombre']); ?></option>
						  <?php } ?>
						</select>
  					  </div>
                      <br>
                      <label>Área de interés<span><em>*</em><br></span><br></label>
                      <div class="texto0">
                        <fieldset>
                          <input class="with-gap" type="checkbox" id="area1" value='Desarrollo web' name="area1"><label for="area1"> Desarrollo web</label><br>
                          <input type="checkbox" id="area2" value='Diseño gráfico' name="area2"><label for="area2"> Diseño gráfico</label><br>
                          <input type="checkbox" id="area3" value='Negocios digitales' name="area3"><label for="area3"> Negocios digitales</label><br>
                        </fieldset>
                      </div>
											<br><br>
                      <div class="center">
                        <input type="submit" class="boton" id="btnEnviar" name="btnEnviar" value="Comienza ahora">
                      </div>
                    </form>
                  </div>
                </div>
          <div class="row contenedor" style="margin-bottom: 0px;">
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
      <script src="js/vendor/jquery.js"></script>
      <script src="js/vendor/what-input.js"></script>
      <script src="js/jssor.slider.min.js.descarga" type="text/javascript"></script>
      <script src="js/jquery-1.9.1.min.js" type="text/javascript"></script>
      <script src="js/modal.js" charset="utf-8"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/materialize/0.100.2/js/materialize.min.js"></script>
      <script>$(".button-collapse").sideNav();</script>
      <script type="text/javascript" src="js/class.js"></script>
			<script type="text/javascript">
		   $(document).ready(function(){
		     $('.timepicker').timepicker();
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
    </div>
  </body>
</html>
