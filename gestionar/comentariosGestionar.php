<?
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);
	
	$anuncio=new Anuncio($_POST['id_anuncio']);
	$comentarios=$anuncio->comentarios();
	for ($i=0;$i<count($comentarios);$i++)
	{
		if (trim($_POST['respuesta_'.$comentarios[$i]['id']])!="")
			operacionSQL("UPDATE Anuncio_Comentario SET respuesta='".$_POST['respuesta_'.$comentarios[$i]['id']]."' WHERE id=".$comentarios[$i]['id']);
	}

	echo "<script type='text/javascript'>
			document.location.href='comentarios.php';
		</script>";

?>