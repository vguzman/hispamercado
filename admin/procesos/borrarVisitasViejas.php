<?
	include "../../lib/class.php";	

	$query=operacionSQL("DELETE FROM AnuncioVisita WHERE fecha<=(CURDATE() - INTERVAL 3 MONTH)");
	
		
	//email("HispaMercado","info@hispamercado.com","Victor","vmgafrm@gmail.com","CRON borrar visitas viejas","Realizado!");


?>