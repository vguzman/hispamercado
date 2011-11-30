<?
	session_start();
	include "../../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body>

<?

$query=operacionSQL("SELECT DISTINCT(ciudad) FROM Anuncio WHERE status_general='Activo' ORDER BY ciudad ASC");
for ($i=0;$i<mysql_num_rows($query);$i++)
{
	$ciudad=mysql_result($query,$i,0);
	echo utf8_encode($ciudad)."<br><br>";
	
	operacionSQL("INSERT INTO ConfigListaCiudades VALUES (null,'".$ciudad."')");
}



?>
</body>
</html>
