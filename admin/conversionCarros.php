<?
	include "../lib/class.php";
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<script language="javascript" type="text/javascript" src="../lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>

<SCRIPT LANGUAGE="JavaScript">

var id_correspondiente;
function modelos(e) 
{	
	id_correspondiente=e.id;
	
	req=getXMLHttpRequest();
	req.onreadystatechange=process_modelos;
	req.open("GET","ajax_modelos.php?marca="+e.value+"&d="+now()+"&id="+id_correspondiente,true);
	req.send(null);
} 

function process_modelos()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			//window.alert(req.responseText);
			document.getElementById("espacio_modelo_"+id_correspondiente).innerHTML=req.responseText;
		} 
		else 
			alert("Problema");      
	}
}

</SCRIPT>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body >
<form id="form1" name="form1" method="post" action="conversionCarros2.php">


  <p>
    <?
	
	$query=operacionSQL("SELECT id FROM Anuncio A, Anuncio_Detalles_Vehiculos B WHERE A.id=B.id_anuncio AND (id_categoria=11 OR id_categoria=12 OR id_categoria=13) AND status_general='Activo'
AND (B.marca NOT IN (SELECT marca FROM ConfigMarca)
OR B.modelo NOT IN (SELECT modelo FROM ConfigModelo))");	

	echo '<p align="center"><strong>Faltan '.mysql_num_rows($query).'</strong></p>';

	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$selec_marca="<select name='".$i."' id='".$i."' onchange='modelos(this)'><option></option>";
		$query2=operacionSQL("SELECT * FROM ConfigMarca");
		for ($e=0;$e<mysql_num_rows($query2);$e++)
			$selec_marca.="<option value='".mysql_result($query2,$e,0)."' >".mysql_result($query2,$e,1)."</option>";
		$selec_marca.="</select>";
		
		
		
		$anuncio=new Anuncio(mysql_result($query,$i,0));
		$detalles=$anuncio->detalles();
		
				
		echo '<table width="1000" border="0" cellspacing="4" cellpadding="4" align="center">
				  <tr>
					<td width="600" class="arial11Negro">'.$anuncio->titulo.'<br>
					<strong>Marca: '.$detalles['marca'].' | Modelo: '.$detalles['modelo'].' | Anio: '.$detalles['anio'].'</strong>
					
					</td>
					<td width="400">'.$selec_marca.' - <span id="espacio_modelo_'.$i.'"></span> - <input name="anio_'.$i.'" id="anio_'.$i.'" type="text" value="'.$detalles['anio'].'" size="5" /></td>
				  </tr>
				</table>';
		
	}

?>
    
    
  </p>
  <p align="center">
    <input type="submit" name="button" id="button" value="Enviar" />
  </p>
</form>
</body>
</html>