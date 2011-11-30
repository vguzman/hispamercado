<?
	session_start();
	
	header ("Cache-Control: no-cache, must-revalidate");
	header('Content-Type: text/html; charset=iso-8859-1');	
	
	$foto=$_GET['foto'];	
	
	unlink("../../img/img_bank/modif/".$_SESSION['id_anuncio']."_".$foto);
	unlink("../../img/img_bank/modif/".$_SESSION['id_anuncio']."_".$foto."_muestra");	
	
?>