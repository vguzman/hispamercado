<?
	
	header("Content-type: image/jpeg");
	
	$tienda=$_GET['tienda'];
		
	$destino="../img/img_bank/logos/".$tienda;
	error_reporting(0);
	$info = getimagesize($destino);
		
	if ($info==NULL)
	{
		$original = imagecreatefromgif("../img/sinlogo.jpg");
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
		
		if (($original_w<=145)&&($original_h<=80))
			imagejpeg($original,"",100);	
		else
		{
			if($original_w<$original_h) 
			{				
				
				$muestra_w = intval(($original_w/$original_h)*80);
				$muestra_h=80;			
				
					
			}
			else
			{
				//echo "adasd";
				if ($original_w<145)
				{					
					$muestra_w = $original_w;
					//$muestra_h=80;	
				}
				else
				{	
					$muestra_w=145;					
				}
				$muestra_h=intval(($original_h/$original_w)*$muestra_w);	
				
			}
				
			$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
					
			imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
			imagedestroy($original);
				
			imagejpeg($muestra,"",100);
		}
	}

	
	
?>