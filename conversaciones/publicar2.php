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
		
	$id_sesion=session_id();
	$hoy=getdate();
	$fecha2=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];	
	$verificacion=codigo_verificacion($fecha2,$id_sesion);
	
	if (isset($_POST['notificaciones']))
		$noti=1;
	else
		$noti=0;
	
	
	if ($_POST['tipo']=="new")
	{
	
		$query=operacionSQL("SELECT MAX(id) FROM Conversacion");
		$id_nuevo=mysql_result($query,0,0)+1;
		
		
		$aux="INSERT INTO Conversacion VALUES (".$id_nuevo.",'".$verificacion."',".$id_usuario.",".trim($_POST['categoria']).",NOW(),'".trim($_POST['titulo'])."','".trim($_POST['content'])."',".$noti.",1)";
		operacionSQL($aux);
	}
	else
	{
		$query=operacionSQL("SELECT id FROM Conversacion WHERE hash='".$_POST['hash']."'");
		$id_nuevo=mysql_result($query,0,0);
		
		operacionSQL("UPDATE Conversacion SET id_categoria=".trim($_POST['categoria']).", titulo='".trim($_POST['titulo'])."', descripcion='".trim($_POST['content'])."', notificaciones=".$noti." WHERE id=".$id_nuevo);
	}
	
	
	
	$conver=new Conversacion($id_nuevo);
	
	echo "<script type='text/javascript'>
			document.location.href='../".$conver->armarEnlace()."';
		</script>";
	
	


?>