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
			
			if (($original_w<=120)&&($original_h<=110))
				imagejpeg($original,"",100);	
			else
			{
				if ($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*110);
						$muestra_h=110;	
						
						if ($muestra_w>120)
						{
							$muestra_w=120;
							$muestra_h=intval(($original_h/$original_w)*120);
						}
									
				}
				if ($original_w>$original_h)
				{
						$muestra_w=120;
						$muestra_h=intval(($original_h/$original_w)*120);
						
						if ($muestra_h>110)
						{
							$muestra_w = intval(($original_w/$original_h)*110);
							$muestra_h=110;	
						}
						
				}
				if($original_w==$original_h) 
				{
					$muestra_w=110;
					$muestra_h=110;
				}
				
				
				
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
					
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
					
				imagejpeg($muestra,"",100);
			}
		}
	}
	
	
	if ($tipo=="mini")
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
			
			if (($original_w<=60)&&($original_h<=60))
				imagejpeg($original,"",100);	
			else
			{
				if ($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*60);
						$muestra_h=60;	
						
						if ($muestra_w>60)
						{
							$muestra_w=60;
							$muestra_h=intval(($original_h/$original_w)*60);
						}
									
				}
				if ($original_w>$original_h)
				{
						$muestra_w=60;
						$muestra_h=intval(($original_h/$original_w)*60);
						
						if ($muestra_h>60)
						{
							$muestra_w = intval(($original_w/$original_h)*60);
							$muestra_h=60;	
						}
						
				}
				if($original_w==$original_h) 
				{
					$muestra_w=60;
					$muestra_h=60;
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
			
			if (($original_w<=300)&&($original_h<=300))
				imagejpeg($original,"",100);	
			else
			{
				if($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*300);
						$muestra_h=300;				
				}
				if($original_w>$original_h) 
				{
						$muestra_w=300;
						$muestra_h=intval(($original_h/$original_w)*300);
				}
				if($original_w==$original_h) 
				{
						$muestra_w=300;
						$muestra_h=300;
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