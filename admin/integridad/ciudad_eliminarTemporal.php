<?
	session_start();
	include "../../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}

	operacionSQL("DELETE FROM Temporal WHERE tipo='nueva_ciudad' AND info1='".$_GET['nombre']."'");
	echo "<SCRIPT LANGUAGE='JavaScript'> 
			document.location.href='index.php'; 
		</SCRIPT>";
?>