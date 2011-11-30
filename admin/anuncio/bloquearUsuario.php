<?

	session_start();
	include "../../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	
	
	
	$anuncio=new Anuncio($_GET['codigo']);
	$email=$anuncio->anunciante_email;
	

	
	bloquearEmail($email);
	
	
	echo "<SCRIPT LANGUAGE='JavaScript'> 
			document.location.href='gestion_index.php?id=".$anuncio->id."'; 
		</SCRIPT>";
	


?>