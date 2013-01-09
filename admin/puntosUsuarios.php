<?
	set_time_limit(0);
	include "../lib/class.php";
	
	$query=operacionSQL("SELECT id FROM Usuario");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$id_usuario=mysql_result($query,$i,0);
		echo $aux="INSERT INTO UsuarioPuntos VALUES (null,".$id_usuario.",'registro',".$id_usuario.",NOW(),5,0)";
		echo "<br>";
		operacionSQL($aux);
	}


?>