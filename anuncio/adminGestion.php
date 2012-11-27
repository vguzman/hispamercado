<?

	session_start();
	include "../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	
	
	
	$anuncio=new Anuncio($_GET['codigo']);
	
	
	if ($_GET['accion']=="bloquear")
	{
		$email=$anuncio->anunciante_email;
		bloquearEmail($email);
	}
	if ($_GET['accion']=="inactivar")
	{
		$anuncio->inactivar("Reprobado");	
	}
	if ($_GET['accion']=="editar")
	{
		echo "<SCRIPT LANGUAGE='JavaScript'> 
			document.location.href='..//publicar/index.php?edit=".$anuncio->codigo_verificacion."'; 
		</SCRIPT>";
		
	
	}
	
	echo "<SCRIPT LANGUAGE='JavaScript'> 
			document.location.href='index.php?id=".$anuncio->id."'; 
		</SCRIPT>";
	


?>