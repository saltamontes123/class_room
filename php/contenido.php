<?php 
require_once ($_SERVER['DOCUMENT_ROOT']."/class_room/php/conexion.php");
$usuario='1141962';
$materia=1;
$detallecontenido=1;
$sqlcontenido="SELECT c.descripcion,tc.tipocontenido,tc.php,dc.detallecontenido, dc.textoconformato,dc.iddetallecontenido
FROM pla_detallecontenido as dc
INNER JOIN pla_contenido as c on dc.idcontenido=c.idcontenido
INNER JOIN pla_tipocontenido as tc on dc.idtipocontenido=tc.idtipocontenido
INNER JOIN pla_tema as t on c.idtema=t.idtema
INNER JOIN pla_materia as m on t.idmateria=m.idmateria
INNER JOIN pla_curso as cu on m.codigocurso=cu.codigocurso 
INNER JOIN pla_usuariomateria as um on um.codigocurso=cu.codigocurso
INNER JOIN pla_usuariotipousuariocurso as utuc on um.codigocurso=utuc.codigocurso
INNER JOIN pla_usuario as u on u.numero_identidad=um.numero_identidad
WHERE um.idmateria=$materia and  um.numero_identidad='$usuario' ";

$res=$con->query($sqlcontenido);

//para las descargas

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
    <title>Document</title>
    <script language="javascript" src="../js/jquery-3.1.1.min.js"></script>
    <script type="text/javascript" src="http://localhost/class_room/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
    tinyMCE.init({ 
    selector: "textarea", readonly : 1 ,menubar: false, //quita las opciones de menu, barra de herramientas y estado del tinymce
     statusbar: false, 
     toolbar: false 
}); 
    tinymce.init({
     
    });
    </script>
</head>
<body>
<h1><?php 
while ($row = mysqli_fetch_array($res)){  
    $url=$row['detallecontenido'];
    $descripcion=utf8_encode($row['descripcion']);
    $tipocontenido=$row['tipocontenido'];
    $iddetallecontenido=$row['iddetallecontenido'];
    $textoconformato=$row['textoconformato'];
    if($tipocontenido=='Video'){
        //echo $tipocontenido;?>
        <iframe name=<?php echo $iddetallecontenido;?>  width="560" height="315" src="<?php echo $url;?>" allowfullscreen></iframe><br>
<?php    }
    elseif($tipocontenido=="Texto"){
        //echo $tipocontenido;
        ?>
        
        <textarea  cols="30" rows="10">
            <?php echo $textoconformato;?>
        </textarea> 
    
<?php    } 
    elseif(stristr($tipocontenido, 'documento')) 
    {
        
 ?>     
 
 
 <!-- <iframe src="../ajax/listar_descargas.php" frameborder="0" width=100%></iframe> -->
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
		
			<a href="<?php echo "files/".$path."/".$archivo;?>" title="<?php echo $titulo;?>" id="contar-<?php echo $iddocumentocontar.$idcontenido;?>"> 
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
	</table>
 
 
 <?php
    } 
   // echo $tipocontenido;
} ?><br></h1>
</body>
</html>