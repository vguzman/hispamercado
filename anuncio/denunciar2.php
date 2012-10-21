<?
	session_start();
	include "../lib/class.php";	
	
	$anuncio=new Anuncio($_POST['id_anuncio']);
	
	$contenido="<a href='http://www.hispamercado.com.ve/".$anuncio->armarEnlace()."'>http://www.hispamercado.com.ve/".$anuncio->armarEnlace()."</a><br><br>".$_POST['porque']."<br><br>".$_POST['comentario'];
	
	email("Hispamercado","info@hispamercado.com.ve","Victor","vmgafrm@gmail.com","Anuncio denunciado",$contenido);
	
	
	echo "<script type='text/javascript'>
			window.alert('Tu denuncia ha sido enviada, en las proximas horas la estaremos revisando. Muchas gracias por contribuir con la comunidad Hispamercado');
			document.location.href='index.php?id=".$anuncio->id."';
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