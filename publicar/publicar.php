<?
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);			
	
	$barra=barraPrincipal("../");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
	
	
	$id_sesion=session_id();	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	//De las categorías
	$id=$_POST['id'];
	$id_cat=explode(";",$id);
	$id_cat=$id_cat[count($id_cat)-1];
	$tipo=$_POST['tipo'];
	
	//De lchoas fotos
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
	
	
	
	if ($_POST['ubicacion_fuera']=="SI")
	{	
		$ciudad="Fuera del país";
		$provincia="NULL";
	}
	else
	{
		$ciudad=ucwords(strtolower(addslashes($_POST['ciudad'])));
		$provincia=$_POST['provincia'];	
	}
	
	
	
	$query=operacionSQL("SELECT max(id) FROM Anuncio");
	$max=mysql_result($query,0,0);
	$id_anuncio=$max+1;
	
	
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
	
	//COMPROBANDO MONEDA CORRECTA
	if ($precio!="NULL")
	{
		$aux="SELECT * FROM Pais_Moneda WHERE id_pais='".$id_pais."' AND moneda='".$moneda."'";
		$query=operacionSQL($aux);
		if (mysql_num_rows($query)==0)
			$flag=1;
	}
	
	
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
		$headers .= "From: HispaMercado ".$nombre_pais." <admin@hispamercado.com.ve>\n";
		$headers .= "Reply-To: admin@hispamercado.com.ve";
		
		email("HispaMercado ".$nombre_pais,"info@hispamercado.com",$_POST['nombre'],$email,"Tu e-mail ha sido bloqueado en Hispamercado",$contenido);
		
		
		echo "<script type='text/javascript'>
			document.location.href='../index.php';
		</script>";
		exit;
		
		
	}
	
	
	
	
	
	$precio=str_replace(",",".",$precio);
	$aux="INSERT INTO Anuncio VALUES (".$id_anuncio.",'".$verificacion."',".$id_cat.",'".trim($tipo)."',NULL,DATE_ADD(NOW(),INTERVAL 30 MINUTE),'".addslashes(trim($titulo))."','".addslashes($texto)."',".trim($precio).",'".$moneda."','".trim($ciudad)."',".$provincia.",'".$id_pais."','".$foto1."','".$foto2."','".$foto3."','".$foto4."','".$foto5."','".$foto6."',".trim($youtube).",'".addslashes(trim($email))."','".addslashes(trim($nombre))."','".addslashes(trim($telefonos))."','Verificar','Revision')";
	//echo "<br>";
	operacionSQL($aux);
	//INFO DE ANUNCIANTE	
	$aux="INSERT INTO Anuncio_Info VALUES (".$id_anuncio.",'".$_SERVER['REMOTE_ADDR']."','".session_id()."','".$_POST['referencia']."',NULL)";
	operacionSQL($aux);
	//echo "<br>";
	
	if (($id_cat==4)||($id_cat==3))
	{
		$superficie=str_replace(",",".",$_POST['superficie']);
		operacionSQL("INSERT INTO Anuncio_Detalles_Inmuebles VALUES (".$id_anuncio.",'".trim($_POST['urbanizacion'])."',".trim($superficie).",".trim($_POST['habitaciones']).")");
	}
	
	if (($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
	{
		$superficie=str_replace(",",".",$_POST['superficie']);
		operacionSQL("INSERT INTO Anuncio_Detalles_Inmuebles VALUES (".$id_anuncio.",'".trim($_POST['urbanizacion'])."',".trim($superficie).",NULL)");
	}
	
	if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
	{
		$marca=ucwords(strtolower(addslashes(trim($_POST['marca']))));
		$modelo=ucwords(strtolower(addslashes(trim($_POST['modelo']))));
		
		
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
	
	//-----Aquí envío mail de activación de anuncio
		$contenido="<div align='center'>
				<table border='0' width='800' id='table1'>
					<tr>
						<td align='left'><font face='Arial' size='2'>Hola <b>".$nombre."</b>,</font><p>
						<font face='Arial' size='2'>Muchas gracias por utilizar
						<a href='http://".$_SERVER['HTTP_HOST']."'>HispaMercado ".$pais->nombre."</a>.</font><p>
						<font face='Arial' size='2'>Para que tu anuncio sea activado y aparezca en nuestros 
			listados debes ingresar en el siguiente link:
			<a href='http://".$_SERVER['HTTP_HOST']."/publicar/activaAnuncio.php?id=".$verificacion."'>
			http://www.hispamercado.com/publicar/activaAnuncio.php?id=".$verificacion."</a></font></p>
						<p><font face='Arial' size='2'>Podrás realizar cambios a tu anuncio 
						en cualquier momento ingresando en el siguiente link: <a href='http://www.hispamercado.com.ve/gestionar/redirect.php?codigo=".$verificacion."'>http://www.hispamercado.com.ve/gestionar/redirect.php?codigo=".$verificacion."</a> </font></p>
						
						<p><font face='Arial' size='2'>Tambien podrás editar tu anuncio ingresando en la opción <b>Gestionar mis 
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
		$headers .= "From: HispaMercado ".$nombre_pais." <admin@hispamercado.com.ve>\n";
		$headers .= "Reply-To: admin@hispamercado.com.ve";
		
		email("HispaMercado ".$nombre_pais,"info@hispamercado.com",$_POST['nombre'],$email,"Activa tu anuncio",$contenido);
		//mail($email,"Activa tu anuncio",$contenido,$headers);
		//mail("vmgafrm@gmail.com","Nuevo anuncio publicado",$contenido,$headers);
	//--------------------------------------------------------------------------------------------------------------------
		


	$anuncio=new Anuncio($id_anuncio);
	$anuncio->metainformacion();
	
	$enlace="http://www.hispamercado.com.ve/".$anuncio->armarEnlace();

?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<meta name="description" content="Publicar aviso clasificado gratis en cualquier ciudad de venezuela con fotos y videos. Publique su anuncio en solo 1 minuto">

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">



<title>Publicar anuncio clasificado gratis en Venezuela</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>

  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="295" align="left"><a href="../"><img src="../img/logo_290.JPG" width="290" height="46" border="0"></a></td>
      <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados  en Venezuela</em></strong></td>
      <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Sección en construcción')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="../sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="6" bgcolor="#FFFFFF">
    <tr>
      <td width="10">&nbsp;</td>
      <td width="777" align="right" class="Arial11Negro">&nbsp;</td>
      <td width="13">&nbsp;</td>
    </tr>
  </table>
  <? echo $barra; ?>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
    <tr>
      <td>&nbsp;</td>
    </tr>
</table>
  <div align="center">
    <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse ">
      <tr>
        <td width="220" align="left" valign="bottom" class="arial13Negro"><a href="/" class="LinkFuncionalidad13"><b>Inicio </b></a>&raquo; Publicar anuncio </td>
        <td width="580" align="right" valign="bottom">&nbsp;</td>
      </tr>
    </table>
    <table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor="#C8C8C8">
      <tr>
        <td height="1"></td>
      </tr>
    </table>
  </div>

      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8" style=" border-style:solid; border-color:#999; border-width:1px;" >
        <tr>
          <td align="left" class="arial13Negro" style="padding:15px;">
          
          <p><strong>&iexcl;Felicidades!</strong> <strong>Tu anuncio fue recibido correctamente</strong><br>
          Ahora solo debes activarlo ingresando al link que enviamos a tu e-mail</p>
            
          <p>Podras ver preliminarmente tu anuncio en el siguiente link: <a href="http://www.hispamercado.com.ve/anuncio/?id=<? echo $id_anuncio ?>">http://www.hispamercado.com.ve/anuncio/?id=<? echo $id_anuncio ?></a></p>
          
          </td>
        </tr>
        <tr>
          <td align="left" class="arial13Negro" style="padding:15px; border-top-width:1px; border-top-style:dashed; border-color:#999;"><div style="float:left; margin-right:5px;">
          
          <strong>Comparte tu nuevo anuncio con tus amigos</strong></div>
          
          
          <div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#appId=119426148153054&amp;xfbml=1"></script><fb:like href="<? echo $enlace ?>" send="false" layout="button_count" width="110" show_faces="true" font="arial"></fb:like>
            
            
            <div style="float:left; margin-left:5px; margin-right:5px;"><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://www.hispamercado.com.ve/anuncio/?id=<? echo $id_anuncio ?>" data-text="<? echo $anuncio->titulo ?>" data-count="none" data-via="hispamercado" data-lang="es">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
            
          <div style="float:right;"><input type="submit" name="button" id="button" value="Publicar otro anuncio" style=" font-size:20px;" onClick="document.location.href='index.php'"></div> 
          
          
          </td>
        </tr>
      </table>
      <table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
</table>
</body>
</html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>