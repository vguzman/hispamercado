<?
	header ("Cache-Control: no-cache, must-revalidate");
	
	include "../lib/util.php";	
	
	$id_padre=$_GET['id_padre'];
	$nivel=$_GET['nivel'];	
	
	
	$query=operacionSQL("SELECT * FROM Categoria WHERE id_categoria=".$id_padre." ORDER BY orden ASC");
	if (mysql_num_rows($query)>0)
	{
		$result="<select name='selec_".($nivel)."' id='selec_".($nivel)."' size='6' onChange='manejoSeleCat(this)' style='float:left;'>";
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$result.="<option value='".mysql_result($query,$i,0)."'>".mysql_result($query,$i,1)."</option>";
		}
		$result.="</select>";
		$result.='<div style="float:left; width:5px; padding-top:50px; margin-left:3px; margin-right:3px; width:auto;" class="arial13Negro">&raquo;</div>';
	}
	else
	{
		
		$result="OK";
		
	}
	
	
	
	echo utf8_encode($result);
	


?>