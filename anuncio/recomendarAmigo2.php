<?
	include "../lib/class.php";	
	
	$sesion=checkSession();
	if ($sesion!=false)
		$id_usuario=$sesion;
	else
		$id_usuario="NULL";
	
	
	$id_anuncio=$_POST['id_anuncio'];	
	$anuncio=new Anuncio($id_anuncio);
	
	$contenido="Saludos,<br><br>Tu amigo ".$_POST['tu_nombre']." te recomienda que le des un vistazo al siguiente anuncio: <a href='http://".$_SERVER['HTTP_HOST']."/anuncio/?id=".$id_anuncio."'>".$anuncio->titulo."</a><br><br>_______<br><a href='http://".$_SERVER['HTTP_HOST']."'>Hispamercado </a>";
	
	
	email("Hispamercado","no-responder@hispamercado.com","",$_POST['tu_email'],"Tu amigo ".$_POST['tu_nombre']." te recomienda este anuncio",$contenido);
	
	
	//SACANDO ID DE NUEVO COMENTARIO
	if ($id_usuario!="NULL")
	{
		$usuario_aux=new Usuario($id_usuario);
		$usuario_aux->puntosOperacion("recomendacion_anuncio",$anuncio->id,2,0);
		
		$_SESSION['puntos']=2;
		$_SESSION['puntos_tipo']="recomendacion";
	}
	
	
	
	echo "<script type='text/javascript'>
			window.alert('Tu recomendación ha sido enviada exitosamente');
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