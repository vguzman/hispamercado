<?
	session_start();	
	include "../lib/class.php";	
	
	
	$url=$_POST['url'];
	$cadenas=file($url);
	
	$contenido=file_get_contents($url);
	
	
	if (substr_count($contenido,'<meta property="og:title"')>0)
		echo "1";
	else
		echo "0";
	
?>