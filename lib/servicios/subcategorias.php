<?
	header ("Cache-Control: no-cache, must-revalidate");
	
	include "../util.php";	
	
	$id_padre=$_GET['id_padre'];	
	
	
	if ($_GET['selec']=="principal")
		$nombre="sub1";
	if ($_GET['selec']=="sub1")
		$nombre="sub2";		

    
	$query=operacionSQL("SELECT * FROM Categoria WHERE id_categoria=".$id_padre." ORDER BY orden ASC");
	if (mysql_num_rows($query)>0)
	{
		$result="<select name='".$nombre."' size='6' onChange='subcategorias(this)'>";
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$result.="<option value='".mysql_result($query,$i,0)."'>".mysql_result($query,$i,1)."</option>";
		}
	}
	else
	{
		$result="<select name='acciones' size='6' onChange='activar(this)'>";
		
		$query=operacionSQL("SELECT id_categoria FROM Categoria WHERE id=".$id_padre);
		$id_padre=mysql_result($query,0,0);
			
		$query=operacionSQL("SELECT * FROM Categoria WHERE id_categoria IS NULL AND id=".$id_padre);		
		if (mysql_num_rows($query)==0)
		{
			$query=operacionSQL("SELECT id_categoria FROM Categoria WHERE id=".$id_padre);
			$id_padre=mysql_result($query,0,0);
		}
		
		$query=operacionSQL("SELECT nombre FROM Categoria_Accion WHERE id_categoria=".$id_padre);
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$result.="<option>".mysql_result($query,$i,0)."</option>";
		}		
		
	}
	
	$result.="</select>";
	
	echo utf8_encode($result);
	


?>