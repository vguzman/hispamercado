<?
	include "../lib/class.php";
	
	
	$query=operacionSQL("SELECT DISTINCT(ciudad) FROM Anuncio WHERE status_general='Activo'");
	
	
	
	//BORRANDO Y LLENANDO
	operacionSQL("DELETE FROM ConfigListaCiudades");
	
	

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<form id="form1" name="form1" method="post" action="conversionCiudades2.php">


  <p>
    <?
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$actual=mysql_result($query,$i,0);
		
		
		operacionSQL("INSERT INTO ConfigListaCiudades VALUES (null,'".$actual."')");
		
		echo '<table width="600" border="0" cellspacing="4" cellpadding="4" align="center">
				  <tr>
					<td width="214">'.$actual.'
					  <input type="hidden" name="actual_'.$i.'" id="actual_'.$i.'" /></td>
					<td width="386">
					  <input name="nueva_'.$i.'" type="text" id="nueva_'.$i.'" size="40" value="'.$actual.'" /></td>
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