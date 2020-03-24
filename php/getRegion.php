<?php
	
	require ('conexion.php');
	
	$id_estado = $_POST['id_estado'];
	//$id_estado=123;
	$queryM = "SELECT id,estadonombre FROM estado WHERE ubicacionpaisid = '$id_estado' ORDER BY estadonombre";

	$resultadoM = $con->query($queryM);
	
	$html= utf8_decode("<option value='0'>-- Seleccionar Región --</option>");
	
	while($rowM = $resultadoM->fetch_assoc())
	{
		$html.= "<option value='".$rowM['id']."'>".$rowM['estadonombre']."</option>";
	}
	
	echo utf8_encode($html);
?>