<?
	include "../lib/class.php";
	
	$accion=$_GET['accion'];
	
	if ($accion=="finalizar")
	{
		$query=operacionSQL("UPDATE Anuncio SET status_general='Inactivo' WHERE codigo_verificacion='".$_GET['code']."'");
	}
	if ($accion=="reactivar")
	{
		$query=operacionSQL("UPDATE Anuncio SET status_general='Activo',fecha=NOW() WHERE codigo_verificacion='".$_GET['code']."'");
	}
	
	
	echo '<SCRIPT LANGUAGE="JavaScript">
			window.history.go(-1);
			</SCRIPT>';
	
?>