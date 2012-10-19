<?
	include "../lib/class.php";
	$query=operacionSQL("SELECT id FROM Anuncio A, Anuncio_Detalles_Vehiculos B WHERE A.id=B.id_anuncio AND (id_categoria=11 OR id_categoria=12 OR id_categoria=13) AND status_general='Activo'
AND (B.marca NOT IN (SELECT marca FROM ConfigMarca)
OR B.modelo NOT IN (SELECT modelo FROM ConfigModelo))");	
	
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$anuncio=new Anuncio(mysql_result($query,$i,0));
		$detalles=$anuncio->detalles();
		
		if (isset($_POST['modelo_'.$i]))
		{
			$query_marca=operacionSQL("SELECT marca FROM ConfigMarca WHERE id=".$_POST[$i]);
			$marca=mysql_result($query_marca,0,0);
			
			
			$aux="UPDATE Anuncio_Detalles_Vehiculos SET marca='".$marca."', modelo='".$_POST['modelo_'.$i]."', anio='".$_POST['anio_'.$i]."' WHERE id_anuncio=".$anuncio->id;	
			operacionSQL($aux);
		}
	}
	
	echo "<script type='text/javascript'>
			document.location.href='conversionCarros.php';
		</script>";
	
	
?>
