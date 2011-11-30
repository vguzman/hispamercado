<?
	session_start();
	
	include "../../lib/class.php";	
	
	$query=operacionSQL("SELECT id FROM Anuncio WHERE codigo_verificacion='".$_GET['codigo']."'");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body onload="document.Forma.submit()">
<form id="Forma" name="Forma" method="post" action="../../gestionar/detalles.php">
  <input name="codigo_verificacion" type="hidden" id="codigo_verificacion" value="<? echo $_GET['codigo'] ?>" />
  <input type="hidden" name="revisar" id="revisar" value="<? echo mysql_result($query,0,0) ?>" />
</form>
</body>
</html>
