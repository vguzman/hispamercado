<?
	
	$id_anuncio=$_GET['code'];
	
	echo $foto1=$_GET['foto1'];
	echo "--";
	echo $foto2=$_GET['foto2'];
	echo "--";
	echo $foto3=$_GET['foto3'];
	echo "--";
	echo $foto4=$_GET['foto4'];
	echo "--";
	echo $foto5=$_GET['foto5'];
	echo "--";
	echo $foto6=$_GET['foto6'];
	
	
	if (($foto1!="0")&&($foto1!="1"))
	{
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto1,"../img/img_bank/temp/".$id_anuncio."_1");
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto1."_muestra","../img/img_bank/temp/".$id_anuncio."_1_muestra");
		
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto1);
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto1."_muestra");
	}
	
	if (($foto2!="0")&&($foto2!="2"))
	{
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto2,"../img/img_bank/temp/".$id_anuncio."_2");
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto2."_muestra","../img/img_bank/temp/".$id_anuncio."_2_muestra");
		
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto2);
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto2."_muestra");
	}
	
	if (($foto3!="0")&&($foto3!="3"))
	{
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto3,"../img/img_bank/temp/".$id_anuncio."_3");
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto3."_muestra","../img/img_bank/temp/".$id_anuncio."_3_muestra");
		
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto3);
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto3."_muestra");
	}
	
	if (($foto4!="0")&&($foto4!="4"))
	{
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto4,"../img/img_bank/temp/".$id_anuncio."_4");
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto4."_muestra","../img/img_bank/temp/".$id_anuncio."_4_muestra");
		
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto4);
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto4."_muestra");
	}
	
	if (($foto5!="0")&&($foto5!="5"))
	{
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto5,"../img/img_bank/temp/".$id_anuncio."_5");
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto5."_muestra","../img/img_bank/temp/".$id_anuncio."_5_muestra");
		
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto5);
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto5."_muestra");
	}
	
	if (($foto6!="0")&&($foto6!="6"))
	{
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto6,"../img/img_bank/temp/".$id_anuncio."_6");
		copy("../img/img_bank/temp/".$id_anuncio."_".$foto6."_muestra","../img/img_bank/temp/".$id_anuncio."_6_muestra");
		
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto6);
		unlink("../img/img_bank/temp/".$id_anuncio."_".$foto6."_muestra");
	}
	
	
	
	
	if ($foto1=="0")
	{
		unlink("../img/img_bank/temp/".$id_anuncio."_1");
		unlink("../img/img_bank/temp/".$id_anuncio."_1_muestra");
	}
	if ($foto2=="0")
	{
		unlink("../img/img_bank/temp/".$id_anuncio."_2");
		unlink("../img/img_bank/temp/".$id_anuncio."_2_muestra");
	}
	if ($foto3=="0")
	{
		unlink("../img/img_bank/temp/".$id_anuncio."_3");
		unlink("../img/img_bank/temp/".$id_anuncio."_3_muestra");
	}
	if ($foto4=="0")
	{
		unlink("../img/img_bank/temp/".$id_anuncio."_4");
		unlink("../img/img_bank/temp/".$id_anuncio."_4_muestra");
	}
	if ($foto5=="0")
	{
		unlink("../img/img_bank/temp/".$id_anuncio."_5");
		unlink("../img/img_bank/temp/".$id_anuncio."_5_muestra");
	}
	if ($foto6=="0")
	{
		unlink("../img/img_bank/temp/".$id_anuncio."_6");
		unlink("../img/img_bank/temp/".$id_anuncio."_6_muestra");
	}
	
	
?>