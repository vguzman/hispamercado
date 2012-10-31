<?
	include "../lib/class.php";
	$sesion=checkSession();
	
	$query=operacionSQL("SELECT id FROM Anuncio WHERE codigo_verificacion='".$_POST['codigo']."'");
	$anuncio=new Anuncio(mysql_result($query,0,0));
	$id_anuncio=$anuncio->id;
	
	
	if ($sesion!=false)
		$id_usuario=$sesion;
	else
		$id_usuario="NULL";
	
	
	$id_sesion=$_POST['id_anuncio'];	
	
	
	
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
	$texto=$_POST['content'];
	$titulo=$_POST['titulo'];
	$precio=$_POST['precio'];
	$moneda=$_POST['moneda'];
	
	
	$ciudad=$_POST['ciudad'];
	
	
	if ($_POST['estado_yutub']=="SI")
		$youtube=$_POST['youtube'];
	else
		$youtube="";
	
	
	
	if ($precio=="")
	{
		$precio="NULL";
		$moneda="NULL";
	}
	if ($youtube=="")
		$youtube="NULL";
	else
		$youtube="'".$youtube."'";
	
	$hoy=getdate();
	$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];		
		
	$fecha2=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];	
	$verificacion=codigo_verificacion($fecha2,$id_sesion);
	
	
	$flag=0;
	//COMPROBANDO TIPO CORRECTO
	$cat=new Categoria($id_cat);
	$patriarca=$cat->patriarca();
	$query=operacionSQL("SELECT * FROM Categoria_Accion WHERE id_categoria=".$patriarca." AND nombre='".$tipo."'");
	if (mysql_num_rows($query)==0)
		$flag=1;
	
	
	if ($flag==1)
	{
		echo "ACCION ILEGAL";
		echo "<script type='text/javascript'>
			document.location.href='../index.php';
		</script>";
		exit;
	}
	
	
	$query=operacionSQL("SELECT * FROM EmailsBloqueados WHERE email='".trim($email)."'");
	if (mysql_num_rows($query)>0)
	{
		$contenido="<div align='center'>
				<table border='0' width='600' id='table1'>
					<tr>
						<td align='left'><p>Hola,</p>
					    <p>Tu e-mail ha sido bloqueado para publicar anuncios en Hispamercado por uso abusivo del servicio.</p>
					    <p>Si consideras que esto es un error comunicate a <a href='mailto:info@hispamercado.com.ve'>info@hispamercado.com.ve</a> explicando tu situación.</p>
					    <p>Hasta luego.</p></td>
					</tr>
				</table>
			</div>";
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: Hispamercado <admin@hispamercado.com.ve>\n";
		$headers .= "Reply-To: admin@hispamercado.com.ve";
		
		email("Hispamercado","info@hispamercado.com",$_POST['nombre'],$email,"Tu e-mail ha sido bloqueado en Hispamercado",$contenido);
		
		
		echo "<script type='text/javascript'>
			document.location.href='../index.php';
		</script>";
		exit;
		
		
	}
	
	
	
	$precio=str_replace(",",".",$precio);
	
	
	$aux="UPDATE Anuncio SET id_categoria=".$id_cat.", tipo_categoria='".trim($tipo)."', titulo='".addslashes(trim($titulo))."', descripcion='".addslashes($texto)."', precio='".trim($precio)."', moneda='".$moneda."', ciudad='".trim($ciudad)."', foto1='".$foto1."', foto2='".$foto2."',  foto3='".$foto3."',  foto4='".$foto4."',  foto5='".$foto5."',  foto6='".$foto6."', video_youtube=".trim($youtube).", anunciante_email='".addslashes(trim($email))."', anunciante_nombre='".addslashes(trim($nombre))."', anunciante_telefonos='".addslashes(trim($telefonos))."' WHERE id=".$id_anuncio;
	
	operacionSQL($aux);
	
	
	
	if (($id_cat==4)||($id_cat==3))
	{
		operacionSQL("DELETE FROM Anuncio_Detalles_Inmuebles WHERE id_anuncio=".$id_anuncio);
		
		
		$superficie=str_replace(",",".",$_POST['superficie']);
		operacionSQL("INSERT INTO Anuncio_Detalles_Inmuebles VALUES (".$id_anuncio.",'".trim($_POST['urbanizacion'])."',".trim($superficie).",".trim($_POST['habitaciones']).")");
	}
	
	if (($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
	{
		operacionSQL("DELETE FROM Anuncio_Detalles_Inmuebles WHERE id_anuncio=".$id_anuncio);
		
		
		$superficie=str_replace(",",".",$_POST['superficie']);
		operacionSQL("INSERT INTO Anuncio_Detalles_Inmuebles VALUES (".$id_anuncio.",'".trim($_POST['urbanizacion'])."',".trim($superficie).",NULL)");
	}
	
	if (($id_cat==11)||($id_cat==12)||($id_cat==13))
	{
		operacionSQL("DELETE FROM Anuncio_Detalles_Vehiculos WHERE id_anuncio=".$id_anuncio);
		
		
		$query_marca=operacionSQL("SELECT marca FROM ConfigMarca WHERE id=".$_POST['marca']);
		$marca=mysql_result($query_marca,0,0);
		$modelo=$_POST['modelo'];
		
		
		operacionSQL("INSERT INTO Anuncio_Detalles_Vehiculos VALUES (".$id_anuncio.",'".trim($marca)."','".trim($modelo)."',".trim($_POST['kms']).",".trim($_POST['anio']).")");
	}
	
	
	
	
	error_reporting(0);
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
		unlink("../img/img_bank/".$id_anuncio."_5");
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
	error_reporting(1);
	



	
	$anuncio->metainformacion();
	$anuncio->revisarCiudad();
	
	
	echo "<script type='text/javascript'>
			document.location.href='index.php?edit=".$anuncio->codigo_verificacion."&time=".time()."';
		</script>";
		
	

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