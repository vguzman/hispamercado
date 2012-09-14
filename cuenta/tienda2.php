<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
	
	
	$query=operacionSQL("SELECT * FROM Tienda WHERE id_usuario=".$user->id);
	if (mysql_num_rows($query)==0)
		operacionSQL("INSERT INTO Tienda VALUES (null,".$user->id.",'".trim($_POST['nick'])."','".trim($_POST['nombre'])."','".trim($_POST['descripcion'])."','SI',1)");
	else
	{
		operacionSQL("UPDATE Tienda SET nick='".trim($_POST['nick'])."', nombre='".trim($_POST['nombre'])."', descripcion='".trim($_POST['descripcion'])."', logo='SI' WHERE id_usuario=".$user->id);
	}
	
	echo "<script type='text/javascript'>
			document.location.href='tienda.php';
		</script>";
	
	
?>