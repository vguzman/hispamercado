<?
	session_start();	
	include "../lib/class.php";	
	
	
	$url=$_POST['url'];
	$cadenas=file($url);
	
	for ($i=0;$i<count($cadenas);$i++)
	{
		//echo $cadenas[$i];
		if (substr_count($cadenas[$i],'<div id="watch-player-div" class="flash-player">')>0)
		{
			
			echo "1";
			exit;
		}
	}
	echo "0";
	
?>