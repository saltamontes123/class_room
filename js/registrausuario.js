// script para guardar sin salir de la página (con ajax)-->
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
    })
});
      function limpiar_campos(){
        $('input[type="text"]').val(''),
        $('input[type="email"]').val(''),
        $('select option[value="0"]').attr("selected", true),
        $('#region').find('option').remove().end().append('<option value="whatever"></option>').val('whatever')
      }
      
    </script>
   // hasta aqui el script para guardar con ajax-->