<?
	session_start();
	include "../../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	
	
	operacionSQL("INSERT INTO Categoria VALUES(null,'".$_POST['nombre_categoria']."',".$_POST['id_cat'].",-1,'venezuela')");
	
	
	
	echo "<SCRIPT LANGUAGE='JavaScript'> window.opener.history.go(0); window.close(); </SCRIPT>";
?>