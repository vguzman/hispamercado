<?
	//PROCESO DE INICIO DE SESION
	session_start();
	
		
	include "../lib/util.php";
	
	
	$pais=$_GET['pais'];
	$id_sesion=session_id();
	
	
	$nombre_pais=nombrePais($pais);
	
	if (isset($_SESSION['user']))
	{
		$user_aux="'".$_SESSION['user']."'";
		$status="Activo";
	}
	else
	{
		$user_aux="NULL";
		$status="Verificar";
	}

	//De las categorías
	$id_1=$_POST['id_1'];
	$id_2=$_POST['id_2'];
	$id_3=$_POST['id_3'];
	$id_4=$_POST['id_4'];
	$tipo_1=$_POST['tipo_1'];
	$tipo_2=$_POST['tipo_2'];
	$tipo_3=$_POST['tipo_3'];
	$tipo_4=$_POST['tipo_4'];
	
	//De las fotos
	$foto1=$_POST['foto1'];
	$foto2=$_POST['foto2'];
	$foto3=$_POST['foto3'];
	$foto4=$_POST['foto4'];
	$foto5=$_POST['foto5'];
	$foto6=$_POST['foto6'];
	
	//Del cliente
	$email=$_POST['email'];
	$nombre=$_POST['nombre'];
	$telefonos=$_POST['telefonos'];	
	
	//Del anuncio
	$texto=$_POST['texto'];
	$precio=$_POST['precio'];
	$moneda=$_POST['moneda'];
	$provincia=$_POST['provincia'];	
	$ciudad=$_POST['ciudad'];
	
	function id_categoria($cadenas)
	{
		$num="";
		$len=strlen($cadenas);
		for ($i=0;$i<$len;$i++)
		{			
			if ($cadenas[$i]==';')
			{				
				$num="";
			}
			else
				$num.=$cadenas[$i];
		}
		
		return $num;
	}
	
	
	//Tratamiento del cliente
	/*$query=operacionSQL("SELECT * FROM cliente WHERE email='".$email."'");
	if (mysql_num_rows($query)==0)
		operacionSQL("INSERT INTO cliente VALUES ('".$email."','".$nombre."','".$telefonos."')");
	else
		operacionSQL("UPDATE cliente SET nombre='".$nombre."', telefonos='".$telefonos."' WHERE email='".$email."'");*/
		
	
	//Determinando el ID del anuncio
	$query=operacionSQL("SELECT max(id) FROM anuncio");
	$max=mysql_result($query,0,0);
	$id_anuncio=$max+1;	
	
	if ($precio=="")
	{
		$precio="NULL";
		$moneda="NULL";
	}		
	
	$hoy=getdate();
	$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];		
		
	$fecha2=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];	
	$verificacion=codigo_verificacion($fecha2,$id_sesion);
	
	$aux="INSERT INTO anuncio VALUES (".$id_anuncio.",'".$fecha."','".$texto."',".$precio.",'".$status."',
	'NO','".$email."','".$nombre."','".$telefonos."','".$foto1."','".$foto2."','".$foto3."',
	'".$foto4."','".$foto5."','".$foto6."','".$pais."','".$provincia."','".$ciudad."','".$moneda."','".$verificacion."',".$user_aux.")";
	operacionSQL($aux);
		
	
	//Tratamiento de categorias
	if ($id_1!="NULL")
	{
		$id_1=id_categoria($id_1);
		operacionSQL("INSERT INTO anuncio_categoria VALUES(".$id_anuncio.",".$id_1.",'".$tipo_1."')");
	}	
	if ($id_2!="NULL")
	{
		$id_2=id_categoria($id_2);
		operacionSQL("INSERT INTO anuncio_categoria VALUES(".$id_anuncio.",".$id_2.",'".$tipo_2."')");
	}	
	if ($id_3!="NULL")
	{
		$id_3=id_categoria($id_3);
		operacionSQL("INSERT INTO anuncio_categoria VALUES(".$id_anuncio.",".$id_3.",'".$tipo_3."')");
	}	
	if ($id_4!="NULL")
	{
		$id_4=id_categoria($id_4);
		operacionSQL("INSERT INTO anuncio_categoria VALUES(".$id_anuncio.",".$id_4.",'".$tipo_4."')");
	}
	
	
	
	
	
	unlink("../img/img_bank/".$id_anuncio."_1");
	unlink("../img/img_bank/".$id_anuncio."_2");
	unlink("../img/img_bank/".$id_anuncio."_3");
	unlink("../img/img_bank/".$id_anuncio."_4");
	unlink("../img/img_bank/".$id_anuncio."_5");
	unlink("../img/img_bank/".$id_anuncio."_6");
	if ($foto1=="SI")
	{		
		copy("../img/img_bank/temp/".$id_sesion."_1","../img/img_bank/".$id_anuncio."_1");
		unlink("../img/img_bank/temp/".$id_sesion."_1");
		unlink("../img/img_bank/temp/".$id_sesion."_1_muestra");
	}
	if ($foto2=="SI")
	{		
		copy("../img/img_bank/temp/".$id_sesion."_2","../img/img_bank/".$id_anuncio."_2");
		unlink("../img/img_bank/temp/".$id_sesion."_2");
		unlink("../img/img_bank/temp/".$id_sesion."_2_muestra");
	}
	if ($foto3=="SI")
	{		
		copy("../img/img_bank/temp/".$id_sesion."_3","../img/img_bank/".$id_anuncio."_3");
		unlink("../img/img_bank/temp/".$id_sesion."_3");
		unlink("../img/img_bank/temp/".$id_sesion."_3_muestra");
	}
	
	if ($foto4=="SI")
	{		
		copy("../img/img_bank/temp/".$id_sesion."_4","../img/img_bank/".$id_anuncio."_4");
		unlink("../img/img_bank/temp/".$id_sesion."_4");
		unlink("../img/img_bank/temp/".$id_sesion."_4_muestra");
	}
	if ($foto5=="SI")
	{		
		copy("../img/img_bank/temp/".$id_sesion."_5","../img/img_bank/".$id_anuncio."_5");
		unlink("../img/img_bank/temp/".$id_sesion."_5");
		unlink("../img/img_bank/temp/".$id_sesion."_5_muestra");
	}
	if ($foto6=="SI")
	{		
		copy("../img/img_bank/temp/".$id_sesion."_6","../img/img_bank/".$id_anuncio."_6");
		unlink("../img/img_bank/temp/".$id_sesion."_6");
		unlink("../img/img_bank/temp/".$id_sesion."_6_muestra");
	}
	
	//-----Aquí envío mail de activación de anuncio
	if ($status=="Verificar")
	{
		$query=operacionSQL("SELECT nombre FROM cliente WHERE email='".$email."'");
				
		$contenido="<div align='center'>
				<table border='0' width='800' id='table1'>
					<tr>
						<td><font face='Arial' size='2'>Hola <b>".mysql_result($query,0,0)."</b>,</font><p>
						<font face='Arial' size='2'>Muchas gracias por utilizar
						<a href='http://www.hispamercado.com/".$pais."/'>HispaMercado ".$nombre_pais."</a>.</font><p>
						<font face='Arial' size='2'>Para que tu anuncio sea activado y aparezca en nuestros 
			listados debes ingresar en el siguiente link:
			<a href='http://www.hispamercado.com/publicar/activaAnuncio.php?id=".$verificacion."'>
			http://www.hispamercado.com/publicar/activaAnuncio.php?id=".$verificacion."</a></font></p>
						<p><font face='Arial' size='2'>Podrás realizar cambios a tu anuncio 
						en cualquier momento ingresando en la opción <b>Gestionar mis 
						anuncios</b> del menú principal 
			utilizando el siguiente código de verificación: </font></p>
						<p align='center'><font face='Arial' size='2'><strong>
						<span style='background-color: #FFFF00'>".$verificacion."</span></strong></font></p>
			<p class='Estilo1'><font face='Arial' size='2'>Hasta luego...</font></p>		
						</td>
					</tr>
				</table>
			</div>";
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: HispaMercado ".$nombre_pais." <info@hispamercado.com>\n";
		$headers .= "Reply-To: info@hispamercado.com";
		
		mail($email,"Activa tu anuncio",$contenido,$headers);
		mail("vmgafrm@gmail.com","Nuevo anuncio publicado",$aux,$headers);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<style type="text/css">
.Estilo1 {font-family: Arial, Helvetica, sans-serif; color:#000000; font-size:13px; text-decoration:none}
</STYLE>
<title>HispaMercado <? echo $nombre_pais; ?> (BETA) - Publicar anuncio GRATIS</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body topmargin="5">
<table width="600" height="21" border="0" align="center" cellpadding="2" cellspacing="0"  bgcolor="#FFCC33" style="border-collapse: collapse">
  <tr>
    <td width="387" align="center" class="Estilo1"><div align="left"><? if ($status=="Activo")
	echo "Tu anuncio ha sido publicado correctamente";
	else
		echo "Tu anuncio ha sido recibido, para completar el proceso debes activarlo a trav&eacute;s del link que ha sido enviado a tu e-mail";
	?></div></td>
    <td width="75" align="center" class="Estilo1"><div align="right"><font face="Arial" size="2"><a href="http://www.hispamercado.com/<? echo $pais; ?>/anuncio_<? echo $id_anuncio; ?>">ver anuncio</a></font> </div></td>
    <td width="126" align="center" class="Estilo1"><div align="right"><font face="Arial" size="2"><a href="http://www.hispamercado.com/<? echo $pais; ?>/publicar/">colocar otro anuncio</a></font></div></td>
  </tr>
</table>
</body>
</html>