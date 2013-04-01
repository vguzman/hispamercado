<?
	include "lib/class.php";
	
	$query=operacionSQL("SELECT email,id FROM Usuario");
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$email=mysql_result($query,$i,0);
		$id=mysql_result($query,$i,1);
		
		operacionSQL("UPDATE Anuncio SET id_usuario=".$id." WHERE anunciante_email='".$email."'");
	}


?>