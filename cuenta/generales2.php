<?

	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
		
		
	$nombre=$_POST['nombre'];
	$email=$_POST['email'];
	$telefonos=$_POST['telefonos'];
	$ciudad=$_POST['ciudad'];
		
	operacionSQL("UPDATE UsuarioPreferenciasPublicacion SET email='".trim($email)."', nombre='".trim($nombre)."', telefonos='".trim($telefonos)."', ciudad='".trim($ciudad)."' WHERE id_usuario=".$user->id);
	
	
	echo "<script type='text/javascript'>
			window.history.go(-1);
		</script>";

?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>
