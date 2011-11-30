<?
	session_start();
	
	if (($_POST['user']=="admin")&&($_POST['pass']=="21381665"))
	{
		$_SESSION['nick_gestion']="admin";		
		
		echo "<SCRIPT LANGUAGE='JavaScript'>
				document.location.href='estadisticas/';
			</SCRIPT>";		
	}
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>
				window.alert('Usuario o password no válidos');
				window.history.back();
			</SCRIPT>";

?>