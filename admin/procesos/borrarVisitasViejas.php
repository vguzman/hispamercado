<?
	include "../../lib/class.php";	

	$query=operacionSQL("SELECT id_anuncio,COUNT(*) AS cuenta FROM AnuncioVisita WHERE fecha<=(CURDATE() - INTERVAL 7 DAY) GROUP BY id_anuncio ORDER BY cuenta DESC");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$id_anuncio=mysql_result($query,$i,0);
		$cuenta=mysql_result($query,$i,1);
		
		
		$query2=operacionSQL("SELECT * FROM AnuncioVisitaResumen WHERE id_anuncio=".$id_anuncio);
		if (mysql_num_rows($query2)==0)
			operacionSQL("INSERT INTO AnuncioVisitaResumen VALUES (".$id_anuncio.",0)");
			
			
		operacionSQL("UPDATE AnuncioVisitaResumen SET cuenta=cuenta+".$cuenta." WHERE id_anuncio=".$id_anuncio);
		
	}
	
	
	$query=operacionSQL("DELETE FROM AnuncioVisita WHERE fecha<=(CURDATE() - INTERVAL 7 DAY)");
	
		


?>