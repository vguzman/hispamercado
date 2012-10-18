<?
	include "../lib/class.php";
	
	
	$datos = json_decode(file_get_contents("https://api.mercadolibre.com/categories/MLV1744"));
	
	$categorias=$datos->children_categories;
	
	$z=0;
	for ($i=0;$i<count($categorias);$i++)
	{
		$cate=$categorias[$i];
		echo $cate->name."<br>";
		
		$id_marca=$i;
		
		operacionSQL("INSERT INTO ConfigMarca VALUES (".$id_marca.",'".utf8_decode($cate->name)."')");
		
		$datos2 = json_decode(file_get_contents("https://api.mercadolibre.com/categories/".$cate->id));
		$categorias2=$datos2->children_categories;
		for ($e=0;$e<count($categorias2);$e++)
		{
			$id_modelo=$z;
			
			$cate=$categorias2[$e];
			echo "- ".$cate->name."<br>";
			
			
			operacionSQL("INSERT INTO ConfigModelo VALUES (".$id_modelo.",".$id_marca.",'".$cate->name."')");
			
			$z++;
		}
		
	}
	
	
	
	

?>