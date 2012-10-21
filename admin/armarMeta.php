<?
	set_time_limit(0);
	include "../lib/class.php";
	
	$query=operacionSQL("SELECT id FROM Anuncio ORDER BY id ASC");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$anuncio=new Anuncio(mysql_result($query,$i,0));
		$anuncio->metainformacion();
	}


?>