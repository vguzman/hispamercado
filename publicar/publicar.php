<?
	include "../lib/class.php";
	require '../lib/facebook/src/facebook.php';
	$sesion=checkSession();
	
	
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
	
	//De lchoas fotos
	$foto1=$_POST['foto1'];
	$foto2=$_POST['foto2'];
	$foto3=$_POST['foto3'];
	$foto4=$_POST['foto4'];
	$foto5=$_POST['foto5'];
	$foto6=$_POST['foto6'];
	
	if ($_POST['estado_yutub']=="SI")
		$youtube=$_POST['youtube'];
	else
		$youtube="";
	
	//Del cliente
	$email=$_POST['email'];
	$nombre=$_POST['nombre'];
	$telefonos=$_POST['telefonos'];	
	
	//Del anuncio
	$texto=$_POST['content'];
	$titulo=$_POST['titulo'];
	$precio=$_POST['precio'];
	$moneda=$_POST['moneda'];
	
	//CUIDANDO TITULO
	$titulo=str_replace("<script>","",$titulo);
	$titulo=str_replace("<style>","",$titulo);
	$titulo=str_replace("<iframe>","",$titulo);
	$titulo=str_replace("<?","",$titulo);
	$titulo=str_replace("<?php","",$titulo);
	
	
	$ciudad=$_POST['ciudad'];
	
	
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
	$aux="INSERT INTO Anuncio VALUES (".$id_anuncio.",'".$verificacion."',".$id_cat.",'".trim($tipo)."',".$id_usuario.",DATE_ADD(NOW(),INTERVAL 30 MINUTE),'".addslashes(trim($titulo))."','".addslashes($texto)."',".trim($precio).",'".$moneda."','".trim($ciudad)."','".$foto1."','".$foto2."','".$foto3."','".$foto4."','".$foto5."','".$foto6."',".trim($youtube).",'".addslashes(trim($email))."','".addslashes(trim($nombre))."','".addslashes(trim($telefonos))."','Verificar','Revision')";
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
	
	if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13))
	{
		$query_marca=operacionSQL("SELECT marca FROM ConfigMarca WHERE id=".$_POST['marca']);
		$marca=mysql_result($query_marca,0,0);
		$modelo=$_POST['modelo'];
		
		
		operacionSQL("INSERT INTO Anuncio_Detalles_Vehiculos VALUES (".$id_anuncio.",'".trim($marca)."','".trim($modelo)."',".trim($_POST['kms']).",".trim($_POST['anio']).")");
	}
	
	if (($id_cat>=5001)&&($id_cat<=5021))
	{
		$jornada=$_POST['jornada'];
		
		if (($_POST['exp_desde']) < ($_POST['exp_hasta']))
			$experiencia=$_POST['exp_desde']."-".$_POST['exp_hasta'];
		else
			$experiencia=$_POST['exp_hasta']."-".$_POST['exp_desde'];
		
		
		$salario=$_POST['salario'];
		if (trim($salario)=="")
			$salario="NULL";
		
		$aux="INSERT INTO Anuncio_Detalles_Empleos VALUES (".$id_anuncio.",'".trim($jornada)."','".trim($experiencia)."',".$salario.")";
		operacionSQL($aux);

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
	
	
	
	//POR SI EL EMAIL ES DE UN USUARIO REGISTRADO
	$query=operacionSQL("SELECT id FROM Usuario WHERE email='".$email."'");
	if (mysql_num_rows($query)>0)
	{
		$id_usuario=mysql_result($query,0,0);
		operacionSQL("UPDATE Anuncio SET id_usuario=".$id_usuario." WHERE id=".$id_anuncio);
	}
	
	
	//CHEQUEANDO SI EL EMAIL YA HA SIDO CONFIRMADO
	$query9=operacionSQL("SELECT * FROM EmailConfirmados WHERE email='".trim($email)."'");
			
	//-----Aquí envío mail de activación de anuncio
	if (($id_usuario=="NULL")&&(mysql_num_rows($query9)==0))
	{
		$contenido="<div align='center'>
				<table border='0' width='800' id='table1'>
					<tr>
					  <td align='left'><img src='http://www.hispamercado.com.ve/img/logo_original.jpg'  width='360' height='58'></td>
				  </tr>
					<tr>
						<td align='left'><font face='Arial' size='2'>Hola <b>".$nombre."</b>,</font><p>
						<font face='Arial' size='2'>Muchas gracias por utilizar
						<a href='http://".$_SERVER['HTTP_HOST']."'>Hispamercado</a>.</font><p>
						<font face='Arial' size='2'>Para que tu anuncio sea activado y aparezca en nuestros 
			listados debes ingresar en el siguiente link:
			<a href='http://".$_SERVER['HTTP_HOST']."/publicar/activaAnuncio.php?id=".$verificacion."'>
			http://www.hispamercado.com/publicar/activaAnuncio.php?id=".$verificacion."</a></font></p>
						<p><font face='Arial' size='2'>Podrás realizar cambios a tu anuncio 
						en cualquier momento ingresando en el siguiente link: <a href='http://www.hispamercado.com.ve/publicar/index.php?edit=".$verificacion."'>http://www.hispamercado.com.ve/publicar/index.php.php?edit=".$verificacion."</a> </font></p>
						<p>¡Gracias por usar Hispamercado!</p>
						</td>
					</tr>
</table>
			</div>";
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: Hispamercado <admin@hispamercado.com.ve>\n";
		$headers .= "Reply-To: admin@hispamercado.com.ve";
		
		email("Hispamercado","info@hispamercado.com.ve",$_POST['nombre'],$email,"Activa tu anuncio",$contenido);
	}
	else
		operacionSQL("UPDATE Anuncio SET status_general='Activo' WHERE id=".$id_anuncio);
//--------------------------------------------------------------------------------------------------------------------
		


	$anuncio=new Anuncio($id_anuncio);
	$anuncio->metainformacion();
	
	
	if ($id_usuario!="NULL")
	{
		$usuario=new Usuario($id_usuario);
		$opciones=$usuario->opciones();
		
		if ($opciones['fb_anuncio']=="1")
		{
			
			$facebook = new Facebook(array(
		  'appId'  => '119426148153054',
		  'secret' => '213d854b0e677a7e5b72b16ec8297325',
		));
		
		$result = $facebook->api( 
			'/me/feed/', 'post' ,
			array('access_token' => $usuario->fb_token, 'message' => "Mira el anuncio que acabo de publicar en Hispamercado!" , 'link' => 'http://www.hispamercado.com.ve/'.$anuncio->armarEnlace() , 'picture' => 'http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=1' ) 
			);
		
		
		}
	}
	
	
	
	$enlace="http://www.hispamercado.com.ve/".$anuncio->armarEnlace();

?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<meta name="description" content="Publicar aviso clasificado gratis en cualquier ciudad de venezuela con fotos y videos. Publique su anuncio en solo 1 minuto">

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<link href="../lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="../lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="../lib/facebox/src/facebox.js" type="text/javascript"></script>

<script language="javascript" type="text/javascript">


jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../lib/facebox/src/loading.gif',
        closeImage   : '../lib/facebox/src/closelabel.png'
      })
    })
	
	
</script>



<title>Publicar anuncio clasificado gratis en Venezuela</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="730" align="left" valign="top" ><div style="width:100%;"> <a href="..//"><img src="../img/logo_original.jpg" alt="" width="360" height="58" border="0" /></a> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span></div></td>
    <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
      <?
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	
	
	 ?>
      <table width="270" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
          <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="../cuenta/index.php?d=<? echo time() ?>&amp;path=../" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="../closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
        </tr>
      </table>
    </div>
      <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
        <div style="width:160px; height:26px; float:right; background-image:url(../img/fondo_fb.png); background-repeat:repeat;" align="left">
          <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email,publish_stream&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede con Facebook</a></div>
        </div>
        <div style="width:26px; height:26px; float:right; background-image:url(../img/icon_facebook.png); background-repeat:no-repeat;"></div>
      </div></td>
  </tr>
</table>
<div style="margin-top:50px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;"><a href="../gestionAnuncio.php" class="LinkFuncionalidad17">Gestionar mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="../conversaciones/" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="../tiendas/" class="LinkFuncionalidad17">Tiendas</a></td>
    </tr>
  </table>
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="320"><input type="button" name="button2" id="button2" value="Publicar Anuncio" onclick="document.location.href='../publicar/'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;" />
        <input type="button" name="button2" id="button2" value="Iniciar conversaci&oacute;n" onclick="document.location.href='../conversaciones/publicar.php'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;" /></td>
      <td width="680"><div style="margin:0 auto 0 auto; width:100%; background-color:#D8E8AE; padding-top:3px; padding-bottom:3px; padding-left:5px;">
        <input name="buscar" type="text" onfocus="manejoBusqueda('adentro')" onblur="manejoBusqueda('afuera')" onkeypress="validar(event,'../')" id="buscar" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado" />
        &nbsp;
        <select name="categorias" id="categorias" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
          <option selected="selected" value="todas">Todas las categor&iacute;as</option>
          <?
	  	$aux="SELECT id,nombre FROM Categoria WHERE id<>160 AND id_categoria IS NULL";
		$query=operacionSQL($aux);
		$total=mysql_num_rows($query);	
		
		for ($i=0;$i<$total;$i++)
		{
			$categoria=new Categoria(mysql_result($query,$i,0));
			
			//if ($categoria->anunciosActivos()>0)
			echo "<option value='".mysql_result($query,$i,0)."'style='font-size:13px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C'>".mysql_result($query,$i,1)."</option>";
			
			
		}
		?>
        </select>
        &nbsp;
        <select name="ciudades" id="ciudades" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
          <option selected="selected" value='todas' style='font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C'>Todas las ciudades</option>
          <option value='Fuera del pa&iacute;s'style='font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C'>Fuera del pa&iacute;s</option>
          <?
		
		//-----EXCLUYENDO CATEGORIA ADULTOS
	$cat=new Categoria(160);
	$hijos=$cat->hijos();
	
	$parche="";
	for ($i=0;$i<count($hijos);$i++)
		$parche.=" AND id_categoria<>".$hijos[$i];
	//-----------
		
		
	  	$query=operacionSQL("SELECT ciudad,COUNT(*) FROM Anuncio WHERE status_general='Activo' AND ciudad<>'Fuera del pa&iacute;s' ".$parche." GROUP BY ciudad ORDER BY ciudad ASC");
				
		for ($i=0;$i<mysql_num_rows($query);$i++)
			echo "<option value='".mysql_result($query,$i,0)."' style='font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C'>".mysql_result($query,$i,0)."</option>";
		
	  ?>
        </select>
        &nbsp;
        <label>
          <input type="button" name="button2" id="button2" value="Buscar" onclick="buscar('../')" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;" />
        </label>
      </div></td>
    </tr>
  </table>
</div>
<div style="visibility:hidden; display:none;"> <img src="../img/bigrotation2.gif" width="32" height="32" ></div>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8" style=" border-style:solid; border-color:#999; border-width:1px; margin-top:50px;" >
<tr>
          <td align="left" class="arial13Negro" style="padding:15px;">
          
          <p><strong>&iexcl;Felicidades!</strong> <strong>Tu anuncio fue recibido correctamente</strong>
          <? if (($id_usuario=="NULL")&&(mysql_num_rows($query9)==0)) echo "<br>Ahora solo debes activarlo ingresando al link que enviamos a tu e-mail</p>" ?>
            
          <p>Podras ver publicado tu anuncio en el siguiente link: <a href="http://www.hispamercado.com.ve/anuncio/?id=<? echo $id_anuncio ?>">http://www.hispamercado.com.ve/anuncio/?id=<? echo $id_anuncio ?></a></p>
          
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
    
    
<div style="margin:0 auto 0 auto; width:1000px;; margin-top:80px; padding-top:5px;" >

 <table width="230" border="0" cellspacing="0" cellpadding="0" style="float:left; margin-left:470px;">
                    <tr>
                      <td  height="25" class="arial11Negro" ><strong>Danos tu opini&oacute;n sobre Hispamercado</strong></td>
                    </tr>
                  </table>

<table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                    <tr>
                      <td width="30"><img src="../img/social-facebook-box-blue-icon.png" alt="" width="25" height="25" /></td>
                      <td width="70"><strong><a class="LinkFuncionalidad" href="http://www.facebook.com/Hispamercado" target="_blank">Facebook</a></strong></td>
                    </tr>
                  </table>
                  
                  <table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;" >
                     <tr>
                       <td width="30"><img src="../img/social-twitter-box-blue-icon.png" width="25" height="25" /></td>
                       <td width="70"><strong><a class="LinkFuncionalidad" href="http://twitter.com/hispamercado" target="_blank">Twitter</a></strong></td>
                     </tr>
                   </table>
                   
                   <table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                     <tr>
                       <td width="30"><img src="../img/Email-icon.png" width="25" height="25"></td>
                       <td width="70"><strong><a class="LinkFuncionalidad" href="mailto:info@hispamercado.com.ve">E-mail</a></strong></td>
                     </tr>
                   </table>
	
</div>
<div style="margin:0 auto 0 auto; width:1000px; padding-left:40px; padding-right:40px; padding-top:10px; border-top:1px solid #77773C; clear:both; text-align:justify;"class="arial11Gris">
 <strong>En Hispamercado creemos que la compra y venta de productos y servicios es una experiencia social. Cuando queremos comprar o vender un producto solemos pedir la opini&oacute;n de amigos o familiares que pueden tener mas conocimientos sobre el tema. Con Hispamercado queremos llevar esa experiencia a Internet, no pretendemos ser un simple portal de clasificados en l&iacute;nea, queremos construir una comunidad de usuarios que interactuen alrededor de los anuncios. Anunciate en Hispamercado y comparte tus opiniones y dudas con la comunidad.</strong>
 </div>
    
    
    
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