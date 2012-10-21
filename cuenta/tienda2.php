<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
	
	
	$query=operacionSQL("SELECT * FROM Tienda WHERE id_usuario=".$user->id);
	if (mysql_num_rows($query)==0)
		operacionSQL("INSERT INTO Tienda VALUES (null,".$user->id.",'".strtolower(trim($_POST['nick']))."','".trim($_POST['nombre'])."','".trim($_POST['descripcion'])."','".$_POST['logo']."',1)");
	else
	{
		operacionSQL("UPDATE Tienda SET nick='".strtolower(trim($_POST['nick']))."', nombre='".trim($_POST['nombre'])."', descripcion='".trim($_POST['descripcion'])."', logo='".$_POST['logo']."' WHERE id_usuario=".$user->id);
	}
	
	echo "<script type='text/javascript'>
			document.location.href='tienda.php';
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
