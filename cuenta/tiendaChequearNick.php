<?
	include "../lib/class.php";
	
	$nick=trim($_GET['nick']);
	if (($nick=="anuncio")||($nick=="cuenta")||($nick=="conversaciones")||($nick=="publicar")||($nick=="tiendas")||($nick=="tienda"))
		echo "NO";
	else
	{
		$query=operacionSQL("SELECT * FROM Tienda WHERE nick='".trim($_GET['nick'])."'");
		if (mysql_num_rows($query)==0)
			echo "SI";
		else
			echo "NO";
	}
		
	


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
