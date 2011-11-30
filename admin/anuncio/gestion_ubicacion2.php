<?
	include "../../lib/class.php";	
	
	if ($_POST['ubicacion_fuera']=="SI")
	{	
		$ciudad="Fuera del país";
		$provincia="NULL";
	}
	else
	{
		$ciudad=ucwords(strtolower(addslashes($_POST['ciudad'])));
		$provincia=$_POST['provincia'];	
	}
	
	operacionSQL("UPDATE Anuncio SET ciudad='".utf8_decode($ciudad)."', id_provincia=".$provincia." WHERE id=".$_POST['id_anuncio']);
	
		echo "<SCRIPT LANGUAGE='JavaScript'> 
			document.location.href='gestion_index.php?id=".$_POST['id_anuncio']."'; 
		</SCRIPT>";
?>