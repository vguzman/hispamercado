<?
	session_start();
	include "../lib/class.php";	
	
	
	$id_anuncio=$_POST['id_anuncio'];	
	$anuncio=new Anuncio($id_anuncio);
	
	$contenido="Saludos,<br><br>Tu amigo ".$_POST['tu_nombre']." te recomienda que le des un vistazo al siguiente anuncio: <a href='http://".$_SERVER['HTTP_HOST']."/anuncio/?id=".$id_anuncio."'>".$anuncio->titulo."</a><br><br>_______<br><a href='http://".$_SERVER['HTTP_HOST']."'>Hispamercado ".$pais->nombre."</a><br>¡Tu Clasificado GRATIS en 1 minuto!";
	
	
	$resul=email("Hispamercado","no-responder@hispamercado.com","",$_POST['email_amigo'],"Tu amigo ".$_POST['tu_nombre']." te recomienda este anuncio",$contenido);
	
	if ($resul==1)
		echo "<script type='text/javascript'>
			window.alert('Tu recomendación ha sido enviada exitosamente');
			document.location.href='index.php?id=".$id_anuncio."';
		</script>";
	else
		echo "<script type='text/javascript'>
			//window.alert('Ha ocurrido un problema, intente mas tarde');
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