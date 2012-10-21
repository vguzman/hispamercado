<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
	$query=operacionSQL("SELECT id FROM Conversacion WHERE hash='".$_GET['code']."'");
	$id_conversacion=mysql_result($query,0,0);
		
		
	if ($_GET['accion']=="finalizar")
		operacionSQL("UPDATE Conversacion SET status=0 WHERE id=".$id_conversacion);
	if ($_GET['accion']=="reactivar")
		operacionSQL("UPDATE Conversacion SET status=1 WHERE id=".$id_conversacion);
		
		
		
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
