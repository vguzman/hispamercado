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