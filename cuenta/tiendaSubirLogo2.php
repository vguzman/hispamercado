<?
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
	
	$size=$_FILES['ruta']['size'];
	$nombre=$_FILES['ruta']['name'];
	$tipo=$_FILES['ruta']['type'];
	$temp=$_FILES['ruta']['tmp_name'];

	
	if (($tipo=="image/x-png")||($tipo=="image/gif")||($tipo=="image/pjpeg")||($tipo=="image/jpeg"))
	{       
		$destino="../img/img_bank/tiendaLogo/".$user->idTienda();		
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
		
		
		
			//*********************************************LA QUE SE VA A MOSTRAR*******************************************************
			if (($original_w<=300)&&($original_h<=150))
			{	
				$muestra_w=$original_w;
				$muestra_h=$original_h;
			}
			else
			{
				if ($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*150);
					$muestra_h=150;	
						
					if ($muestra_w>300)
					{
						$muestra_w=300;
						$muestra_h=intval(($original_h/$original_w)*300);
					}
									
				}
				if ($original_w>$original_h)
				{
					$muestra_w=300;
					$muestra_h=intval(($original_h/$original_w)*300);
				}				
			}
			$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
			
			imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
			
			//Para cerrar y guardar foto			
			imagejpeg($muestra,$destino,100);
			imagedestroy($muestra);
			
			
			
			
		
		
		
			
			//*********************************************MUESTRA*******************************************************
			if (($original_w<=200)&&($original_h<=50))
			{	
				$muestra_w=$original_w;
				$muestra_h=$original_h;
			}
			else
			{
				if ($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*50);
					$muestra_h=50;	
						
					if ($muestra_w>200)
					{
						$muestra_w=200;
						$muestra_h=intval(($original_h/$original_w)*200);
					}
									
				}
				if ($original_w>$original_h)
				{
					$muestra_w=200;
					$muestra_h=intval(($original_h/$original_w)*200);
					
					if ($muestra_h>50)
					{
						$muestra_w = intval(($original_w/$original_h)*50);
						$muestra_h=50;	
					}
						
				}
				if($original_w==$original_h) 
				{
					$muestra_w=50;
					$muestra_h=50;
				}
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
	
	
		$html_foto="<img src='".$destino."_muestra?d=".time()."'><br><a href='javascript:borrarLogo()' class='LinkFuncionalidad'>Cambiar logo</a>";		
		
		
		echo "<SCRIPT LANGUAGE='JavaScript'>	
			
			window.opener.document.getElementById('logo_html').innerHTML=".chr(34).$html_foto.chr(34).";	
			window.opener.document.Forma['logo'].value='SI';			
			window.close();
		
			</SCRIPT>";
	}
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>	
			window.alert('".$status."');				
			window.close();
		</SCRIPT>";
	
	
?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>
