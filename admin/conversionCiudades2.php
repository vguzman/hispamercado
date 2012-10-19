<?
	include "../lib/class.php";
	
	
	$query=operacionSQL("SELECT DISTINCT(ciudad) FROM Anuncio WHERE status_general='Activo'");
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$actual=mysql_result($query,$i,0);
		$nueva=$_POST['nueva_'.$i];
		
		if ($actual!=$nueva)
			operacionSQL("UPDATE Anuncio SET ciudad='".$nueva."' WHERE ciudad='".$actual."'");
	}
	
	
	echo "<script type='text/javascript'>
			document.location.href='conversionCiudades.php';
		</script>";

?>