<?
	include "../lib/class.php";
	
	$id_marca=$_GET['marca'];
	$query=operacionSQL("SELECT modelo FROM ConfigModelo WHERE id_marca=".$id_marca);
	
	echo "<option value=''></option>";
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		echo "<option value='".mysql_result($query,$i,0)."'>".mysql_result($query,$i,0)."</option>";
	}

	
?>