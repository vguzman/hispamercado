<?
	session_start();
	
	include "lib/class.php";
	
	
	if (isset($_SESSION['nick_gestion'])==false)
		echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='index.php';			
			</SCRIPT>";
	
	$aux=explode(";",$_POST['anuncios']);
	
	
	if ($_GET['accion']=="cambiar_categoria")
	{
		$id_categoria=$_POST['categorias'];
		$cat=new Categoria($id_categoria);
		
		if ($cat->esHoja()==true)
		{
			for ($i=0;$i<count($aux)-1;$i++)
			{
				
				
				$id_anuncio=$aux[$i];
				if ($_POST['check_'.$id_anuncio]=="SI")
				{	
					//echo $id_anuncio."<br>";
					operacionSQL("UPDATE Anuncio SET id_categoria=".$cat->id." WHERE id=".$id_anuncio);
				}
			}
			echo "<SCRIPT LANGUAGE='JavaScript'>				
				window.history.go(-1);			
			</SCRIPT>";
		}
		else
			echo "<SCRIPT LANGUAGE='JavaScript'>		
				window.alert('".$cat->nombre." no es una categoria hoja');
				window.history.go(-1);			
			</SCRIPT>";
		
	}
	


?>