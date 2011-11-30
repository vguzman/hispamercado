<?
	session_start();
	
	header ("Cache-Control: no-cache, must-revalidate");
	header('Content-Type: text/html; charset=iso-8859-1');
	
	$id_sesion=session_id();
	$foto=$_GET['foto'];
	
	unlink("../../img/img_bank/temp/".$id_sesion."_".$foto);
	unlink("../../img/img_bank/temp/".$id_sesion."_".$foto."_muestra");	
?>