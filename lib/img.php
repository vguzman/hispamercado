<?php	
	Header("Content-type: image/jpeg");
	
	$tipo=$_GET['tipo'];
	
	if ($tipo=="lista")
	{
		$destino="../img/img_bank/".$_GET['anuncio']."_1";
		
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
			
			if (($original_w<=145)&&($original_h<=135))
				imagejpeg($original,"",100);	
			else
			{
				if ($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*145);
						$muestra_h=135;	
						
						if ($muestra_w>145)
						{
							$muestra_w=145;
							$muestra_h=intval(($original_h/$original_w)*145);
						}
									
				}
				if ($original_w>$original_h)
				{
						$muestra_w=135;
						$muestra_h=intval(($original_h/$original_w)*135);
						
						if ($muestra_h>135)
						{
							$muestra_w = intval(($original_w/$original_h)*135);
							$muestra_h=135;	
						}
						
				}
				if($original_w==$original_h) 
				{
					$muestra_w=135;
					$muestra_h=135;
				}
				
				
				
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
					
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
					
				imagejpeg($muestra,"",100);
			}
		}
	}
	
	
	if ($tipo=="gestion")
	{
		$destino="../img/img_bank/".$_GET['anuncio']."_1";
		
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
			
			if (($original_w<=100)&&($original_h<=80))
				imagejpeg($original,"",100);	
			else
			{
				if ($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*100);
						$muestra_h=90;	
						
						if ($muestra_w>100)
						{
							$muestra_w=100;
							$muestra_h=intval(($original_h/$original_w)*100);
						}
									
				}
				if ($original_w>$original_h)
				{
						$muestra_w=90;
						$muestra_h=intval(($original_h/$original_w)*90);
						
						if ($muestra_h>90)
						{
							$muestra_w = intval(($original_w/$original_h)*135);
							$muestra_h=90;	
						}
						
				}
				if($original_w==$original_h) 
				{
					$muestra_w=90;
					$muestra_h=90;
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
			
			if (($original_w<=380)&&($original_h<=350))
				imagejpeg($original,"",100);	
			else
			{
				if($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*350);
						$muestra_h=350;				
				}
				if($original_w>$original_h) 
				{
						$muestra_w=380;
						$muestra_h=intval(($original_h/$original_w)*380);
				}
				if($original_w==$original_h) 
				{
						$muestra_w=350;
						$muestra_h=350;
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
			
			if (($original_w<=800)&&($original_h<=500))
				imagejpeg($original,"",100);	
			else
			{
				if($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*500);
						$muestra_h=500;
						
						if ($muestra_w>800)
						{
							$muestra_w=800;
							$muestra_h=intval(($original_h/$original_w)*800);
						}
				}
				if($original_w>$original_h) 
				{
						$muestra_w=800;
						$muestra_h=intval(($original_h/$original_w)*800);
						
						if ($muestra_h>500)
						{
							$muestra_w = intval(($original_w/$original_h)*500);
							$muestra_h=500;	
						}
				}
				if($original_w==$original_h) 
				{
						$muestra_w=500;
						$muestra_h=500;
				}
				
				
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
					
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
					
				imagejpeg($muestra,"",100);
			}
		}
	}
	
	
	if ($tipo=="real2")
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