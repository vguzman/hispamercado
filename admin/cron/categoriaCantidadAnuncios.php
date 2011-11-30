<?
	include "../../lib/class.php";	



	$query=operacionSQL("SELECT id FROM Categoria");
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$cat=new Categoria(mysql_result($query,$i,0));
		
		
		$query=operacionSQL("SELECT * FROM CategoriaAnunciosActivos WHERE id_categoria=".$cat->id);
		if (mysql_num_rows($query)==0)
			operacionSQL("INSERT INTO CategoriaAnunciosActivos VALUES (".$cat->id.",".$cat->anunciosActivos().")");
		else
			operacionSQL("UPDATE CategoriaAnunciosActivos SET cantidad=".$cat->anunciosActivos()." WHERE id_categoria=".$cat->id);
		
	}
?>
