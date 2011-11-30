<?
	session_start();
	include "../../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	
	$cat=new Categoria($_GET['id_cat']);
	
	if ($cat->anunciosActivos()==0)
	{	
		$hijos=$cat->hijos();
		
		for ($i=0;$i<count($hijos);$i++)
			operacionSQL("DELETE FROM Categoria WHERE id=".$hijos[$i]);
			//echo $hijos[$i]."<br>";
			
			
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Categoría eliminada. En paz descanse'); window.history.go(-1); </SCRIPT>";
	}
	else
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('No se puede eliminar esta categoria porque tiene anuncios activos'); window.history.go(-1); </SCRIPT>";


?>