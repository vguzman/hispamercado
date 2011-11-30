<?
	session_start();
	$id_sesion=session_id();
	$_SESSION['codigo_verificacion']=$_POST['verificacion_anuncio'];
	
	include "../lib/class.php";
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	//Del anuncio
	$codigo_verificacion=$_POST['codigo_verificacion'];
	$aux="SELECT id FROM Anuncio WHERE codigo_verificacion='".$codigo_verificacion."'";
	//echo "<br>";
	$query=operacionSQL($aux);
	$id_anuncio=mysql_result($query,0,0);
	$temp_id=$_POST['temp_id'];
	
	//De las categorías
	$id=$_POST['id'];
	$id_cat=explode(";",$id);
	$id_cat=$id_cat[count($id_cat)-1];
	$tipo=$_POST['tipo'];
	
	//De las fotos
	$foto1=$_POST['foto1'];
	$foto2=$_POST['foto2'];
	$foto3=$_POST['foto3'];
	$foto4=$_POST['foto4'];
	$foto5=$_POST['foto5'];
	$foto6=$_POST['foto6'];
	$youtube=$_POST['youtube'];
	
	//Del cliente
	$email=$_POST['email'];
	$nombre=$_POST['nombre'];
	$telefonos=$_POST['telefonos'];	
	
	//Del anuncio
	$texto=$_POST['elm1'];
	$titulo=$_POST['titulo'];
	$precio=$_POST['precio'];
	$moneda=$_POST['moneda'];
	$provincia=$_POST['provincia'];	
	$ciudad=$_POST['ciudad'];
	
	
	if ($precio=="")
	{
		$precio="NULL";
		$moneda="NULL";
	}
	if ($youtube=="")
		$youtube="NULL";
	else
		$youtube="'".$youtube."'";
	
	
	
	
	$aux="UPDATE Anuncio SET id_categoria=".$id_cat.", tipo_categoria='".$tipo."', titulo='".addslashes($titulo)."', descripcion='".addslashes($texto)."', precio=".$precio.", moneda='".$moneda."', ciudad='".addslashes($ciudad)."', id_provincia=".$provincia.", foto1='".$foto1."', foto2='".$foto2."', foto3='".$foto3."', foto4='".$foto4."', foto5='".$foto5."', foto6='".$foto6."', video_youtube=".$youtube.", anunciante_email='".addslashes($email)."', anunciante_nombre='".addslashes($nombre)."', anunciante_telefonos='".addslashes($telefonos)."', status_general='".$_POST['status']."' WHERE id=".$id_anuncio;
	operacionSQL($aux);

	//POR SI ACASO VIENE DE LA REVISION
	//if ($_POST['revisar']==$id_anuncio)
		//operacionSQL("UPDATE Anuncio SET status_revision='Aprobado' WHERE id=".$id_anuncio);
	
	//echo $id_anuncio."<br>";
	
	if (($id_cat==4)||($id_cat==3))
	{
		operacionSQL("DELETE FROM Anuncio_Detalles_Inmuebles WHERE id_anuncio=".$id_anuncio);
		operacionSQL("INSERT INTO Anuncio_Detalles_Inmuebles VALUES (".$id_anuncio.",'".$_POST['urbanizacion']."',".$_POST['superficie'].",".$_POST['habitaciones'].")");
	}
	
	if (($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
	{
		operacionSQL("DELETE FROM Anuncio_Detalles_Inmuebles WHERE id_anuncio=".$id_anuncio);
		operacionSQL("INSERT INTO Anuncio_Detalles_Inmuebles VALUES (".$id_anuncio.",'".$_POST['urbanizacion']."',".$_POST['superficie'].",NULL)");
	}
	
	if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
	{
		operacionSQL("DELETE FROM Anuncio_Detalles_Vehiculos WHERE id_anuncio=".$id_anuncio);
		$aux="INSERT INTO Anuncio_Detalles_Vehiculos VALUES (".$id_anuncio.",'".$_POST['marca']."','".$_POST['modelo']."',".$_POST['kms'].",".$_POST['anio'].")";
		operacionSQL($aux);
	}
	
	
	
	
	error_reporting(0);
	if ($foto1=="SI")
	{		
		unlink("../img/img_bank/".$id_anuncio."_1");
		copy("../img/img_bank/temp/".$temp_id."_1","../img/img_bank/".$id_anuncio."_1");
		unlink("../img/img_bank/temp/".$temp_id."_1");
		unlink("../img/img_bank/temp/".$temp_id."_1_muestra");
	}
	if ($foto2=="SI")
	{		
		unlink("../img/img_bank/".$id_anuncio."_2");
		copy("../img/img_bank/temp/".$temp_id."_2","../img/img_bank/".$id_anuncio."_2");
		unlink("../img/img_bank/temp/".$temp_id."_2");
		unlink("../img/img_bank/temp/".$temp_id."_2_muestra");
	}
	if ($foto3=="SI")
	{		
		unlink("../img/img_bank/".$id_anuncio."_3");
		copy("../img/img_bank/temp/".$temp_id."_3","../img/img_bank/".$id_anuncio."_3");
		unlink("../img/img_bank/temp/".$temp_id."_3");
		unlink("../img/img_bank/temp/".$temp_id."_3_muestra");
	}
	
	if ($foto4=="SI")
	{		
		unlink("../img/img_bank/".$id_anuncio."_4");
		copy("../img/img_bank/temp/".$temp_id."_4","../img/img_bank/".$id_anuncio."_4");
		unlink("../img/img_bank/temp/".$temp_id."_4");
		unlink("../img/img_bank/temp/".$temp_id."_4_muestra");
	}
	if ($foto5=="SI")
	{		
		unlink("../img/img_bank/".$id_anuncio."_5");
		copy("../img/img_bank/temp/".$temp_id."_5","../img/img_bank/".$id_anuncio."_5");
		unlink("../img/img_bank/temp/".$temp_id."_5");
		unlink("../img/img_bank/temp/".$temp_id."_5_muestra");
	}
	if ($foto6=="SI")
	{		
		unlink("../img/img_bank/".$id_anuncio."_6");
		copy("../img/img_bank/temp/".$temp_id."_6","../img/img_bank/".$id_anuncio."_6");
		unlink("../img/img_bank/temp/".$temp_id."_6");
		unlink("../img/img_bank/temp/".$temp_id."_6_muestra");
	}
	error_reporting(1);
	
		
	
	
	echo "<script type='text/javascript'>
			window.alert('Se han guardado los cambios realizados en su anuncio');
			document.location.href='detalles.php';
		</script>";


?>

