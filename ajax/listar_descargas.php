<?php
require_once ($_SERVER['DOCUMENT_ROOT']."/class_room/php/conexion.php");

	$sqldocumento="SELECT titulo,archivo, publicado,grupodocumental,TD.tipo,DC.idcontenido as path,descargas,doc.iddocumento,dc.idcontenido
	FROM pla_documento AS DOC
	INNER JOIN pla_documentocontenido AS DC ON DOC.iddocumento=DC.iddocumento
	INNER JOIN pla_grupodocumental AS GD ON GD.idgrupodocumental=DOC.idgrupodocumental
	INNER JOIN pla_tipodocumento AS TD ON TD.idtipo=DOC.tipo";

	$resdocumento=$con->query($sqldocumento);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Documentos</title>
	<script language="javascript" src="../js/jquery-3.1.1.min.js"></script>

</head>
<body>
	<table class="table table-striped table-hover">
		<tbody>	
		<!-- documentos  -->
		<td >
			<?php 
			while ($row = mysqli_fetch_array($resdocumento)){  
		    $titulo= utf8_encode($row['titulo']);	
	    	$archivo=utf8_encode($row['archivo']);
		    $publicado=$row['publicado'];
		    $grupodocumental= utf8_encode($row['grupodocumental']);
			$tipo=$row['tipo'];//icono
			$path = $row['path'];
			$descargas = $row['descargas'];
			$idcontenido = $row['idcontenido'];
			//$nuevo = $row3['nuevo'];
			//$actualizado=$row3['actualizado'];
			$iddocumentocontar=$row['iddocumento'];
			//echo "img/tipos/".$tipo.".png";
			//echo "comienza<br>";
			if(file_exists("../files/".$path."/".$archivo)){
			//echo "existe<br>";
				$tamano = filesize("../files/".$path."/".$archivo)/(1024);
			if ($tamano>1024) {
				$tamano =number_format(filesize("../files/".$path."/".$archivo)/(1024*1024),2)	;
				$medida="MB";}
			else{$tamano=number_format($tamano,2);
				$medida="KB";}
				$grupodocumental = utf8_encode($row['grupodocumental']);
			?>
		
			<a href="<?php echo "../files/".$path."/".$archivo;?>" title="<?php echo $titulo;?>" id="contar-<?php echo $iddocumentocontar.$idcontenido;?>"> 
			<img class="img-fluid mx-auto d-block responsive-img" title="<?php echo $titulo;?>" src='<?php echo "../img/tipos/".$tipo.".png";?>' width="15" height="15"/><font ><?php echo "<b>".$grupodocumental."</b>: ".$titulo." - ".$tamano.$medida;?></font>
			</a>
			<?php echo ": &darr;".$descargas;?>
			<script>

				
				$("#contar-<?php echo $iddocumentocontar.$idcontenido;?>").click(function(e){
					$.get("../php/actualizacontador.php",{iddocumento:"<?php echo $iddocumentocontar;?>",idcontenido:"<?php echo $idcontenido;?>"});	
				});
			</script>


			<br>
			<?php	}}?>
						</td>
						</tr>
</body>
</html>