<?
	session_start();
	
	include "../lib/class.php";	
	
	$id_anuncio=$_POST['id_anuncio'];
	$anuncio=new Anuncio($id_anuncio);
	
	
	
	
	//VALIDACION DEL CAPTCHA
	include_once '../lib/securimage/securimage.php';
	$securimage = new Securimage();
	if ($securimage->check($_POST['captcha_code']) == false)
	{
		echo "<script type='text/javascript'>
			window.alert('El código de seguridad ingresado no es válido');
			document.location.href='index.php?id=".$id_anuncio."';
		</script>";
		exit;
	}
	
	
	
	
	
	
	
	$contenido="Saludos ".$anuncio->anunciante_nombre.",<br><br>Has recibido un mensaje sobre u anuncio <a href='http://".$_SERVER['HTTP_HOST']."/anuncio/?id=".$id_anuncio."'>".$anuncio->titulo."</a><br><br>
	<b>De</b>: ".$_POST['tu_nombre']." (<a href='mailto:".$_POST['tu_email']."'>".$_POST['tu_email']."</a>)<br>
	<b>Mensaje</b>: ".$_POST['comentario']."<br><br>
	
	_______<br><a href='http://".$_SERVER['HTTP_HOST']."'>Hispamercado ".$pais->nombre."</a><br>¡Tu Clasificado GRATIS en 1 minuto!";
	
	$resul=email("Hispamercado",$_POST['tu_email'],$anuncio->anunciante_nombre,$anuncio->anunciante_email,"Has recibido un mensaje sobre tu anuncio",$contenido);



	operacionSQL("INSERT INTO AnuncioMensaje VALUES (null,".$id_anuncio.",'".$_POST['tu_nombre']."','".$_POST['tu_email']."','".$_POST['comentario']."',NOW())");

	if ($resul==1)
		echo "<script type='text/javascript'>
			window.alert('Tu mensaje ha sido enviado exitosamente');
			document.location.href='index.php?id=".$id_anuncio."';
		</script>";
	else
		echo "<script type='text/javascript'>
			window.alert('Ha ocurrido un problema, intente mas tarde');
			document.location.href='index.php?id=".$id_anuncio."';
		</script>";



?>