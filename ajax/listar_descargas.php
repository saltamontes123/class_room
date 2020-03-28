<?php
/* Connect To Database*/
	require_once ("../inicio.php");

$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
if($action == 'ajax'){
	$query = mysqli_real_escape_string($con,(strip_tags($_REQUEST['query'], ENT_QUOTES)));

	$tables="convocatoria";
	$campos="*";
	$sWhere=" estado<>'X' and convocatoria.descripcion LIKE '%".$query."%'";
	$sWhere.=" order by convocatoria.idconvocatoria desc";
	
	
	include 'pagination.php'; //include pagination file
	//pagination variables
	$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
	$per_page = 10;//intval($_REQUEST['per_page']); //how much records you want to show
	$adjacents  = 4; //gap between pages after number of adjacents
	$offset = ($page - 1) * $per_page;
	//Count the total number of row in your table*/
	$count_query   = mysqli_query($con,"SELECT count(*) AS numrows FROM $tables where $sWhere ");
	if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
	else {echo mysqli_error($con);}
	$total_pages = ceil($numrows/$per_page);
	//main query to fetch the data
	$query = mysqli_query($con,"SELECT $campos FROM  $tables where $sWhere LIMIT $offset,$per_page");
	//loop through fetched data

	if ($numrows>0){
		
	?>
		<div class="table-responsive">
			<table class="table table-striped table-hover">
				<tbody>	
						<?php 
						$finales=0;
						$fila = 0;
						
						while($row = mysqli_fetch_array($query)){	
							$fila++;
							$idconvocatoria =  $row['idconvocatoria'];
							$descripcion =  utf8_encode($row['descripcion']);
							$numeroconvocatoria =  $row['numeroconvocatoria'];
							$iddistrito =  $row['iddistrito'];
							$fecharegistro =  $row['fecharegistro'];
							$fechainicio =  $row['fechainicio'];
							$fechafin =  $row['fechafin'];
							$estado =  $row['estado'];
							if($estado=="A"){$estado="Vigente";}
							else{$estado="No vigente";}
							$imagen =  $row['imagen'];
							$idusuario =  $row['idusuario'];
							$lugarpresentacion =  utf8_encode($row['lugarpresentacion']);
							$numerodepuestos =  $row['numerodepuestos'];
							$extensionlogo=substr($imagen,strpos($imagen,"."),5);
							$finales++;
							//lista de distritos
							$campos2="d.distrito";
							$tables2="distrito as d, convocatoriadistrito as cd, convocatoria as c";
							$sWhere2="cd.iddistrito=d.iddistrito and  c.idconvocatoria= cd.idconvocatoria and c.idconvocatoria=".$idconvocatoria;
							$query2 = mysqli_query($con,"SELECT $campos2 FROM  $tables2 where $sWhere2");

							//lista de documentos, se consudera nuevo cuando la antigüedad es menor a 4 días
							$campos3="doc.titulo,doc.archivo,t.tipo,IF(doc.reutilizable=0,replace(con.numeroconvocatoria,'/','-'),'shared')as path, gru.grupodocumental,docon.descargas,if(docon.fechaactualizacion>docon.fechapublicacion , 1,0) as actualizado, if(DATEDIFF(NOW(),fechapublicacion)<2,1,0)as nuevo, con.idconvocatoria, doc.iddocumento";
							$tables3="documento as doc, documentoconvocatoria as docon,convocatoria as con,grupodocumental as gru, tipo as t";
							$sWhere3="con.idconvocatoria=docon.idconvocatoria and docon.iddocumento=doc.iddocumento and t.idtipo=doc.tipo  and docon.publicado=1 and docon.idcategoria=gru.idgrupodocumental and con.idconvocatoria=".$idconvocatoria;
							$query3 = mysqli_query($con,"SELECT $campos3 FROM  $tables3 where $sWhere3");
							
							//lista de areas y numero de cargos
							$campos4="ap.area, a.numero";
							$tables4="areaconvocatoria as a, areaprofesional as ap, convocatoria as c";
							$sWhere4="c.idconvocatoria= a.idconvocatoria and a.idareaprofesional=ap.idarea and c.idconvocatoria=".$idconvocatoria;
							$query4 = mysqli_query($con,"SELECT $campos4 FROM  $tables4 where $sWhere4");

							//echo $con,"SELECT $campos3 FROM  $tables3 where $sWhere3";
							//exit;					
						
						?>	
						<tr class="<?php echo $text_class;?>" style="width:100%;">
						<td><h6><?php echo $numeroconvocatoria;?></h6></td>
						<td colspan=3><?php echo $descripcion;?></td>
						<td style="FONT-SIZE:9px;width=150px;"><?php echo "Estado<br>".$estado;?></td>
						<td colspan=2>
						<input type="text" placeholder="N° C.I."  id="ci" />
                                <button class="btn btn-info" type="button" onclick="">
                                <span class="glyphicon glyphicon-list-alt" ></span>
                            </button>
						</td>
						<td><a href=<?php echo "files/zipear.php?id=".$idconvocatoria;?> id="<?php echo $idconvocatoria;?>zip"> 
									<img class="img-fluid mx-auto d-block responsive-img" title="<?php echo $numeroconvocatoria;?>" src='<?php echo "images/tipos/zip.png";?>' width="25" height="25" />
									<script>
									$("#"+<?php echo $idconvocatoria;?>+"zip").click(function(e){
										//contar los documentos e incrementar en +1
										$.get("php/actualizacontadorzip.php",{idconvocatoria:"<?php echo $idconvocatoria;?>"});	
									});
									</script>
						</td>
							</tr><tr>
						<td style="width:100px;FONT-SIZE:9px;"><?php while($row2 = mysqli_fetch_array($query2)){	
									$distrito = utf8_encode($row2['distrito']);
									echo $distrito;?><br><?php	}?>
						</td>
						<td style="width:120px;FONT-SIZE:9px;" ><?php echo "<b>Vigencia</b><br><b>Del:</b> ".date("d/m/Y", strtotime($fechainicio));?><br>
						<?php echo "<b>Al:</b> ".date("d/m/Y h:i", strtotime($fechafin));?></td>
					<!--	<td><?php // echo $lugarpresentacion;?></td> -->
					<!-- Areas y Cargos  -->
						<td style="width:120px;FONT-SIZE:9px;">	<b>Área: Vacantes</b><br>
            				<?php while($row4 = mysqli_fetch_array($query4)){	
									$area = utf8_encode($row4['area']);
									$numero = $row4['numero'];
									echo $area.": ".$numero;?><br><?php }?>
						</td>
					<!-- documentos  -->
						<td style="width:250px;FONT-SIZE:9px; LINE-HEIGHT:15px;">

						<?php while($row3 = mysqli_fetch_array($query3)){	
									$icono = $row3['tipo'];
									$titulo = utf8_encode($row3['titulo']);
									$archivo = utf8_encode($row3['archivo']);
									$path = utf8_encode($row3['path']);
									$descargas = $row3['descargas'];
									$nuevo = $row3['nuevo'];
									$actualizado=$row3['actualizado'];
									$iddocumentocontar=$row3['iddocumento'];
									if(file_exists("../files/".$path."/".$archivo)){
									$tamano = filesize("../files/".$path."/".$archivo)/(1024);
									if ($tamano>1024) {
										$tamano =number_format(filesize("../files/".$path."/".$archivo)/(1024*1024),2);
										$medida="MB";}
										else{$tamano=number_format($tamano,2);
											$medida="KB";}
									$grupodocumental = utf8_encode($row3['grupodocumental']);
									?><a href="<?php echo "files/".$path."/".$archivo;?>" title="<?php echo $titulo;?>" id="contar-<?php echo $iddocumentocontar.$idconvocatoria;?>"> 
									<img class="img-fluid mx-auto d-block responsive-img" title="<?php echo $titulo;?>" src='<?php echo "images/tipos/".$icono.".png";?>' width="15" height="15"/><font size=1><?php echo $grupodocumental.". ".$tamano.$medida;?></font>
									<?php if($nuevo){?>
										<img class="img-fluid mx-auto d-block responsive-img" src="images/nuevo.gif" width="25" height="15"/>
										<?php }; ?>
									<?php if($actualizado){?>
										<img class="img-fluid mx-auto d-block responsive-img" src="images/actualizado.png" width="55" height="15"/>
										<br>
										<?php }; ?>

									</a><?php echo ": &darr;".$descargas;?>
									<script>
									$("#contar-"+<?php echo $iddocumentocontar.$idconvocatoria;?>).click(function(e){
										$.get("php/actualizacontador.php",{iddocumento:"<?php echo $iddocumentocontar;?>",idconvocatoria:"<?php echo $idconvocatoria;?>"});	
									});
									</script>

							
							<br><?php	}}?>
						</td>
						</tr>
						<?php }?>
						<tr>
							<td colspan='6'> 
								<?php 
									$inicios=$offset+1;
									$finales+=$inicios -1;
									echo "Mostrando $inicios al $finales de $numrows registros";
									echo paginate( $page, $total_pages, $adjacents);
								?>
							</td>
						</tr>
				</tbody>			
			</table>
		</div>	
	<?php	
	}	
}
//mysql_close($con);
?>          
		  
<>