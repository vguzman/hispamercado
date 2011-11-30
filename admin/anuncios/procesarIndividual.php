<?
	session_start();
	include "../../lib/class.php";
	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	else
	{
		if ($_GET['accion']=="aprobar")
			operacionSQL("UPDATE Anuncio SET status_revision='Aprobado' WHERE id=".$_GET['id_anuncio']);
		if ($_GET['accion']=="reprobar")
			operacionSQL("UPDATE Anuncio SET status_revision='Reprobado', status_general='Inactivo' WHERE id=".$_GET['id_anuncio']);
	}

	
	echo "<script type='text/javascript'>
			document.location.href='../../anuncio/?id=".$_GET['id_anuncio']."';
		</script>";

?>