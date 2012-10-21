<?
	include "../lib/class.php";
	
	$id_marca=$_GET['marca'];
	$query=operacionSQL("SELECT modelo FROM ConfigModelo WHERE id_marca=".$id_marca);
	
	echo  utf8_decode('<select name="modelo_'.$_GET['id'].'" id="modelo_'.$_GET['id'].'" class="arial13Negro"><option value=""></option>');
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		echo utf8_decode('<option value="'.mysql_result($query,$i,0).'">'.mysql_result($query,$i,0).'</option>');
	}
	echo  utf8_decode('</select>');
	
?>