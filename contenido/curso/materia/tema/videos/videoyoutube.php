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

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script type="text/javascript" src="http://localhost/class_room/js/tinymce/tinymce.min.js"></script>
    <script type="text/javascript">
    tinymce.init({
        selector: "textarea"
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
        echo $tipocontenido;?>
        <iframe name=<?php echo $iddetallecontenido;?>  width="560" height="315" src="<?php echo $url;?>" allowfullscreen></iframe><br>
<?php    }
    elseif($tipocontenido=="Texto"){
        echo $tipocontenido;
        ?>
        
        <textarea  cols="30" rows="10">
            <?php echo $textoconformato;?>
        </textarea> 
    
<?php    } else echo"adios"; 

} ?><br></h1>
</body>
</html>