<?

	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		


	$codigo=$_GET['hash'];
	$query=operacionSQL("SELECT id FROM Anuncio WHERE codigo_verificacion='".$codigo."'");
	
	$anuncio=new Anuncio(mysql_result($query,0,0));
	$anuncio->destacar();
	
	$user->puntosOperacion("destacar_anuncio",$anuncio->id,0,15);
	
	echo "<script type='text/javascript'>
			window.history.go(-1);
		</script>";


?>