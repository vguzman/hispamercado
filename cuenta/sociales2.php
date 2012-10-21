<?

	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
	if (isset($_POST['fb_anuncio']))
		$fb_anuncio="1";
	else
		$fb_anuncio="0";
		
	if (isset($_POST['fb_conversacion']))
		$fb_conversacion="1";
	else
		$fb_conversacion="0";
		
	if (isset($_POST['tw_anuncio']))
		$tw_anuncio="1";
	else
		$tw_anuncio="0";
	
	if (isset($_POST['tw_conversacion']))
		$tw_conversacion="1";
	else
		$tw_conversacion="0";	
	
	
	operacionSQL("UPDATE UsuarioOpciones SET fb_anuncio=".$fb_anuncio.", fb_conversacion=".$fb_conversacion.", tw_anuncio=".$tw_anuncio.", tw_conversacion=".$tw_conversacion." WHERE id_usuario=".$user->id);
	
	
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
