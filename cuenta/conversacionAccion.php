<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
	$query=operacionSQL("SELECT id FROM Conversacion WHERE hash='".$_GET['code']."'");
	$id_conversacion=mysql_result($query,0,0);
		
		
	if ($_GET['accion']=="finalizar")
		operacionSQL("UPDATE Conversacion SET status=0 WHERE id=".$id_conversacion);
	if ($_GET['accion']=="reactivar")
		operacionSQL("UPDATE Conversacion SET status=1 WHERE id=".$id_conversacion);
		
		
		
	echo "<script type='text/javascript'>
			window.history.go(-1);
		</script>";
	
	
	
	
	
?>