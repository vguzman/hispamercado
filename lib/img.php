<?php	
	Header("Content-type: image/jpeg");
	
	$tipo=$_GET['tipo'];
	
	if ($tipo=="lista")
	{
		$destino="../img/img_bank/".$_GET['anuncio']."_1";
		//error_reporting(0);
		//$info = getimagesize($destino);
		//echo "sdasdas";
		
		if (file_exists($destino)) 
		   $existe=true; 
		else 
		   $existe=false;				
		
		if ($existe==false)
		{
			$original = imagecreatefromgif("../img/no_foto.gif");
			imagegif($original);
		}
		else
		{
			$info = getimagesize($destino);
			switch ($info[2]) 
			{
				case 1:
					$original = imagecreatefromgif($destino); break;
				case 2:
					$original = imagecreatefromjpeg($destino); break;
				case 3:
					$original = imagecreatefrompng($destino); break;		
			}
			
			$original_w = imagesx($original);
			$original_h = imagesy($original);
			
			if (($original_w<=77)&&($original_h<=70))
				imagejpeg($original,"",100);	
			else
			{
				if($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*70);
						$muestra_h=70;				
				}
				else
				{
						$muestra_w=77;
						$muestra_h=intval(($original_h/$original_w)*77);
				}
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
					
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
					
				imagejpeg($muestra,"",100);
			}
		}
	}
	
	
	
	if ($tipo=="anuncio")
	{
		$foto=$_GET['foto'];
		$destino="../img/img_bank/".$_GET['anuncio']."_".$foto;
		error_reporting(0);
		$info = getimagesize($destino);
		
		if ($info==NULL)
		{
			$original = imagecreatefromgif("../img/no_foto.gif");
			imagegif($original);
		}
		else
		{
			switch ($info[2]) 
			{
				case 1:
					$original = imagecreatefromgif($destino); break;
				case 2:
					$original = imagecreatefromjpeg($destino); break;
				case 3:
					$original = imagecreatefrompng($destino); break;				
			}
			
			$original_w = imagesx($original);
			$original_h = imagesy($original);
			
			if (($original_w<=280)&&($original_h<=230))
				imagejpeg($original,"",100);	
			else
			{
				if($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*230);
						$muestra_h=230;				
				}
				else
				{
						$muestra_w=270;
						$muestra_h=intval(($original_h/$original_w)*270);
				}
				
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
					
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
					
				imagejpeg($muestra,"",100);
			}
		}
	}
	
	
	if ($tipo=="real")
	{
		$foto=$_GET['foto'];
		$destino="../img/img_bank/".$_GET['anuncio']."_".$foto;
		error_reporting(0);
		$info = getimagesize($destino);
		
		if ($info==NULL)
		{
			$original = imagecreatefromgif("../img/no_foto.GIF");
			imagegif($original);
		}
		else
		{
			switch ($info[2]) 
			{
				case 1:
					$original = imagecreatefromgif($destino); break;
				case 2:
					$original = imagecreatefromjpeg($destino); break;
				case 3:
					$original = imagecreatefrompng($destino); break;				
			}		
				
			imagejpeg($original,"",100);	
		}
	}
	
	
?>