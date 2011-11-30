<?
	session_start();
	
	include "../../lib/class.php";
	
	$cat=new Categoria($_POST['id_cat']);
	
	
	operacionSQL("UPDATE Categoria SET nombre='".$_POST['nombre_categoria']."' WHERE id=".$_POST['id_cat']);
	
	echo "<SCRIPT LANGUAGE='JavaScript'> document.location.href='index.php'; </SCRIPT>";
?>