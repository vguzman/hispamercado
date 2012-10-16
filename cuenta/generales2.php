<?

	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
		
		
	$nombre=$_POST['nombre'];
	$email=$_POST['email'];
	$telefonos=$_POST['telefonos'];
	$ciudad=$_POST['ciudad'];
		
	operacionSQL("UPDATE UsuarioPreferenciasPublicacion SET email='".trim($email)."', nombre='".trim($nombre)."', telefonos='".trim($telefonos)."', ciudad='".trim($ciudad)."' WHERE id_usuario=".$user->id);
	
	
	echo "<script type='text/javascript'>
			window.history.go(-1);
		</script>";

?>