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
		{
			//SI SE VA A APROBAR UN ANUNCIO CON REVISION DE CIUDAD, SE AGREGA LA CIUDAD A LA LISTA DE CIUDADES VALIDAS
			$query=operacionSQL("SELECT ciudad FROM Anuncio WHERE status_general='Int_Ciu' AND id=".$_GET['id_anuncio']);
			if (mysql_num_rows($query)>0)
				operacionSQL("INSERT INTO ConfigListaCiudades VALUES (null,'".trim(mysql_result($query,0,0))."')");
			
			
			operacionSQL("UPDATE Anuncio SET status_revision='Aprobado', status_general='Activo' WHERE id=".$_GET['id_anuncio']);
		
		}
		if ($_GET['accion']=="reprobar")
			operacionSQL("UPDATE Anuncio SET status_revision='Reprobado', status_general='Inactivo' WHERE id=".$_GET['id_anuncio']);
	}

	
	echo "<script type='text/javascript'>
			document.location.href='../../anuncio/?id=".$_GET['id_anuncio']."';
		</script>";

?>