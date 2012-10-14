<?
	include "../lib/class.php";
	
	
	$verificacion=$_GET['id'];
	
	$query=operacionSQL("SELECT id FROM Anuncio WHERE codigo_verificacion='".$verificacion."'");
	if (mysql_num_rows($query)>0)
	{
		$anuncio=new Anuncio(mysql_result($query,0,0));
		$ciudad=$anuncio->ciudad;
		
		
		//CHEQUEANDO Y GUARDANDO EMAIL
		$query9=operacionSQL("SELECT * FROM EmailConfirmados WHERE email='".trim($anuncio->anunciante_email)."'");
		if (mysql_num_rows($query9)==0)
			operacionSQL("INSERT INTO EmailConfirmados VALUES ('".$anuncio->anunciante_email."')");
		
		
		//ALERTA NUEVA CIUDAD
		$aux="SELECT * FROM ConfigListaCiudades WHERE ciudad='".$ciudad."'";
		$query2=operacionSQL($aux);
		if (mysql_num_rows($query2)==0)
		{
			operacionSQL("UPDATE Anuncio SET status_general='Int_Ciu' WHERE id=".$anuncio->id);
			echo "<script type='text/javascript'>
				window.alert('Tu anuncio se encuentra en proceso de revisión');
				document.location.href='../';
			</script>";
		}
		else
		{
			operacionSQL("UPDATE Anuncio SET status_general='Activo' WHERE codigo_verificacion='".$verificacion."'");
			echo "<script type='text/javascript'>
				window.alert('Tu anuncio ha sido activado correctamente');
				document.location.href='../anuncio/?id=".mysql_result($query,0,0)."';
			</script>";
		}
	}
	else
	{
		echo "<script type='text/javascript'>
			window.alert('Ha ocurrido un problema con la activación de tu anuncio');
			document.location.href='../';
		</script>";
	}
?>
