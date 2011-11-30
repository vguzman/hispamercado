<?
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	$id_anuncio=$_POST['id_anuncio'];
	$anuncio=new Anuncio($id_anuncio);
	
	if ($_POST['visi']=="pub")
	{
		operacionSQL("INSERT INTO Anuncio_Comentario VALUES (null,".$id_anuncio.",CURRENT_TIMESTAMP(),'".$_POST['comentario']."','','".$_POST['tu_nombre']."','".$_POST['tu_email']."','Por revisar')");
		$aux="Este comentario es público y se encuentra visible en la sección de comentarios de tu anuncio, puedes responderlo ingresando a la sección <a href='http://www.hispamercado.com.ve/gestionar/'>Gestionar tu anuncio</a><br><br>";
	}
	
	$contenido="Saludos ".$anuncio->anunciante_nombre.",<br><br>Has recibido un comentario en tu anuncio <a href='http://".$_SERVER['HTTP_HOST']."/anuncio/?id=".$id_anuncio."'>".$anuncio->titulo."</a><br><br>
	De: ".$_POST['tu_nombre']." (<a href='mailto:".$_POST['tu_email']."'>".$_POST['tu_email']."</a>)<br>
	Comentario: ".$_POST['comentario']."<br><br>
	
	".$aux."	
	
	_______<br><a href='http://".$_SERVER['HTTP_HOST']."'>Hispamercado ".$pais->nombre."</a><br>¡Tu Clasificado GRATIS en 1 minuto!";
	
	$resul=email("Hispamercado ".$pais->nombre,"info@hispamercado.com",$anuncio->anunciante_nombre,$anuncio->anunciante_email,"Has recibido un comentario en tu anuncio",$contenido);


	if ($resul==1)
		echo "<script type='text/javascript'>
			window.alert('Tu comentario ha sido enviado exitosamente');
			document.location.href='index.php?id=".$id_anuncio."';
		</script>";
	else
		echo "<script type='text/javascript'>
			window.alert('Ha ocurrido un problema, intente mas tarde');
			document.location.href='index.php?id=".$id_anuncio."';
		</script>";



?>