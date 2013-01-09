<?
	include "../lib/class.php";	

	$sesion=checkSession();
	if ($sesion!=false)
		$id_usuario=$sesion;
	else
		$id_usuario="NULL";
	
	
	
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
	
	email("Hispamercado",$_POST['tu_email'],$anuncio->anunciante_nombre,$anuncio->anunciante_email,"Has recibido un mensaje sobre tu anuncio",$contenido);

	$query=operacionSQL("SELECT MAX(id) FROM AnuncioMensaje");
	$nuevo_id=mysql_result($query,0,0)+1;

	operacionSQL("INSERT INTO AnuncioMensaje VALUES (".$nuevo_id.",".$id_anuncio.",'".$_POST['tu_nombre']."','".$_POST['tu_email']."','".$_POST['comentario']."',NOW())");
	
	//SACANDO ID DE NUEVO COMENTARIO
	if ($id_usuario!="NULL")
	{
		$usuario_aux=new Usuario($id_usuario);
		$usuario_aux->puntosOperacion("mensaje_anuncio",$nuevo_id,2,0);
		
		$_SESSION['puntos']=2;
		$_SESSION['puntos_tipo']="mensaje";
	}
	
	

	echo "<script type='text/javascript'>
			window.alert('Tu mensaje ha sido enviado exitosamente');
			document.location.href='index.php?id=".$id_anuncio."';
		</script>";
	

?>

 <script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>