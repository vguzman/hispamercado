<? session_start(); ?>
<title>Hispamercado <?php echo $nombre_pais; ?> - Subir foto</title>
<?
	
	$foto=$_POST['foto'];	
	$size=$_FILES['ruta']['size'];
	$nombre=$_FILES['ruta']['name'];
	$tipo=$_FILES['ruta']['type'];
	$temp=$_FILES['ruta']['tmp_name'];



        echo "<SCRIPT LANGUAGE='JavaScript'>
			window.alert('".$tipo." - ".$size." - ".$temp."');
		</SCRIPT>";

	
	if (($tipo=="image/x-png")||($tipo=="image/gif")||($tipo=="image/pjpeg")||($tipo=="image/jpeg"))
	{       
		$destino="../img/img_bank/temp/".session_id()."_".$foto;		
		if (copy($_FILES['ruta']['tmp_name'],$destino)) 
		{
			$status = "Archivo subido";
						
			$info = getimagesize($destino);
			
			//Para abrir archivo
			switch ($info[2]) 
			{
				case 1:
					$original = imagecreatefromgif($destino); break;
				case 2:
					$original = imagecreatefromjpeg($destino); break;
				case 3:
					$original = imagecreatefrompng($destino); break;
				
			}
			
			//TODO LO QUE VIENE ES PARA CUADRAR LAS PROPORCIONES DE LA FOTO
			$original_w = imagesx($original);
			$original_h = imagesy($original);
		
			if($original_w<$original_h) 
			{
				$muestra_w = intval(($original_w/$original_h)*97);
				$muestra_h=97;				
			}
			else
			{
				$muestra_w=77;
				$muestra_h=intval(($original_h/$original_w)*77);
			}
			$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
			
			imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
			imagedestroy($original);
			
			//Para cerrar y guardar foto			
			imagejpeg($muestra,$destino."_muestra",100);
			imagedestroy($muestra);			
			//***************************************************************
		}
		else 
			$status = "Error al subir la imagen";        	
	} 
	else
		$status = "El formato de la imagen no es válido";
	
	if ($status=="Archivo subido")
	{		
	
		$hoy=getdate();
		$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];			
	
		$foto="foto".$_POST['foto'];
		$borrar="borrar".$_POST['foto'];
		$html_foto="<img src='".$destino."_muestra?d=".$fecha."'><br><a href='javascript:borrarFoto(".$_POST['foto'].")' class='LinkFuncionalidad'>eliminar</a>";		
		
		
		echo "<SCRIPT LANGUAGE='JavaScript'>	
			
			window.opener.document.getElementById('".$foto."').innerHTML=".chr(34).$html_foto.chr(34).";	
			window.opener.document.Forma['".$foto."'].value='SI';			
			window.close();
		
			</SCRIPT>";
	}
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>	
			window.alert('".$status."');				
			window.close();
		</SCRIPT>";
	
	
?>