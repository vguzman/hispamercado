<?

	session_start();
	include "../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	
	
	
	$conversacion=new Conversacion($_GET['codigo']);
	
	
	if ($_GET['accion']=="bloquear")
	{
		$email=$conversacion->anunciante_email;
		bloquearEmail($email);
	}
	if ($_GET['accion']=="inactivar")
	{
		operacionSQL("UPDATE Conversacion SET status=0 WHERE id=".$conversacion->id);	
	}
	if ($_GET['accion']=="editar")
	{
		echo "<SCRIPT LANGUAGE='JavaScript'> 
			document.location.href='publicar.php?edit=".$conversacion->hash."'; 
		</SCRIPT>";
		
	
	}
	
	echo "<SCRIPT LANGUAGE='JavaScript'> 
			document.location.href='conversacion.php?id_con=".$conversacion->id."'; 
		</SCRIPT>";
	


?>