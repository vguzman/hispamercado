<?
	include "../util.php";
	
	session_start();
	
	header ("Cache-Control: no-cache, must-revalidate");
	header('Content-Type: text/html; charset=iso-8859-1');
	
				
	$tipo=$_GET['tipo'];
	$id_anuncio=$_GET['id_anuncio'];
	$codigo=$_COOKIE['hispamercado_favoritos'];
	
		if ($tipo=="meter")
		{
			$aux="INSERT INTO Favoritos VALUES ('".$codigo."',".$id_anuncio.",CURRENT_TIMESTAMP())";
			operacionSQL($aux);
				
			//if (isset($_SESSION['user']))
				//operacionSQL("INSERT INTO favoritos_usuarios VALUES ('".$_SESSION['user']."',".$id_anuncio.",CURRENT_TIMESTAMP())");
								
			//echo "<a href='javascript:quitaFavoritos(".$id_anuncio.",".chr(34).$sesion.chr(34).")'><img src='img/favorito1.gif' alt='Quitar de favoritos' width='26' height='25' border='0'></a>";
		}
		if ($tipo=="sacar")
		{
			$aux="DELETE FROM Favoritos WHERE sesion='".$codigo."' AND id_anuncio=".$id_anuncio;
			operacionSQL($aux);
			
			//if (isset($_SESSION['user']))
			//{
				//$aux="DELETE FROM favoritos_usuarios WHERE usuario='".$_SESSION['user']."' AND id_anuncio=".$id_anuncio;
				//operacionSQL($aux);

			//}
			//echo "<a href='javascript:aFavoritos(".$id_anuncio.",".chr(34).$sesion.chr(34).")'><img src='img/favorito0.gif' alt='Añadir a favoritos' width='26' height='25' border='0'></a>";
		}		

?>