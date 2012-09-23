<?	
	include "../lib/class.php";
	$sesion=checkSession();	

	//CASOS USUARIO REGISTRADO
	if ($sesion!=false)
	{
		$usuario=new Usuario($sesion);
		$id_usuario=$usuario->id;
	}
	else
		$id_usuario="NULL";
		
	
	operacionSQL("INSERT INTO Conversacion VALUES (null,".$id_usuario.",".trim($_POST['categoria']).",'".trim($_POST['nombre'])."','".trim($_POST['email'])."','".trim($_POST['titulo'])."','".trim($_POST['content'])."',1)");
	
	


?>