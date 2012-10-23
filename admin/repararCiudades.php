<?
	include "../lib/class.php";
	
	
	
	function operacionSQLViejo($aux)
	{
		$link=mysql_connect ("localhost","root","123456") or die ('I cannot connect to the database because: ' . mysql_error());
		mysql_select_db ("hispamercado_viejo"); 
		
		$query=mysql_query($aux,$link);
		
		if (!($query))
		{
			echo $error=mysql_error();
			mysql_close($link);
		}
		else
		{	
			mysql_close($link);
			return $query;		
		}
		
	}
	
	
	$z=0;
	$query=operacionSQL("SELECT id FROM Anuncio");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$id_actual=mysql_result($query,$i,0);
		
		
		
		$query2=operacionSQLViejo("SELECT ciudad,id_provincia FROM Anuncio WHERE id=".$id_actual);
		if (mysql_num_rows($query2)>0)
		{
			$ciudad=mysql_result($query2,0,0);
			$provincia=mysql_result($query2,0,1);
			
			$query2=operacionSQLViejo("SELECT nombre FROM Provincia WHERE id=".$provincia);
			$provincia=mysql_result($query2,0,0);
			
			
			echo $aux="UPDATE Anuncio SET ciudad='".$ciudad.", ".$provincia."' WHERE id=".$id_actual;
			echo "<br>";
		
			operacionSQL($aux);
			
		}
		else
		{
			$z++;
		}
		
	}
	
	echo "<br><br><br>".$z." Anuncios no actualizados";
	
	





?>