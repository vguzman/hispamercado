<?
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);			
	
	$barra=barraPrincipal("../");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
	
	
	
	
	
	$url=$_SERVER['REQUEST_URI'];
		
	if (substr_count($url,"/anuncio/?id=")>0)
	{
		$aux=explode("id=",$url);
		
		$anuncio=new Anuncio($aux[1]);
		echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='http://www.hispamercado.com.ve/".$anuncio->armarEnlace()."';			
			</SCRIPT>";
			
		exit;
		
	}
	

	//---ANUNCIO INEXISTENTE
	if (isset($_SESSION['nick_gestion'])==false)
	{
		$query=operacionSQL("SELECT * FROM Anuncio WHERE id=".$_GET['id']);
		if (mysql_num_rows($query)==0)
			echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='../index.php';			
			</SCRIPT>";
	}
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='http://www.hispamercado.com.ve/admin/anuncio/gestion_index.php?id=".$_GET['id']."';			
			</SCRIPT>";
		
	

	
//---------------------------------------------------------	
	
	$id_anuncio=$_GET['id'];	
	
	$anuncio=new Anuncio($id_anuncio);
	
	
	if (($anuncio->status_general!="Activo")&&($anuncio->status_general!="Verificar"))
		echo "<SCRIPT LANGUAGE='JavaScript'>		
					document.location.href='../index.php';			
				</SCRIPT>";
	
	if ($anuncio->id_usuario=="")
	{
		$email=$anuncio->anunciante_email;
		$nombre=$anuncio->anunciante_nombre;
		$telefonos=$anuncio->anunciante_telefonos;
	}
	else
	{
		$usuario=new Usuario($anuncio->id_usuario);
		$email=$usuario->email;
		$nombre=$usuario->nombre;
		$telefonos=$usuario->telefonos;
	}
	if ($anuncio->id_provincia=="")
		$provincia="";
	else
	{	
		$provincia=new Provincia($anuncio->id_provincia);
		$provincia=$provincia->nombre;
	}
	$categoria=new Categoria($anuncio->id_categoria);
//---------------------------------------------------------------------------------------------------------




	if (($anuncio->precio=="")||($anuncio->precio==0))
		$precio="no indicado";
	else
		$precio=number_format($anuncio->precio,2,",",".")." ".$anuncio->moneda;





//---------------------------INFORMACION DE VISITA---------------------------------------------------

	$sesion=session_id();
	$query=operacionSQL("SELECT * FROM AnuncioVisita WHERE id_anuncio=".$id_anuncio." AND id_sesion='".$sesion."'");
	if (mysql_num_rows($query)==0)
		operacionSQL("INSERT INTO AnuncioVisita VALUES (".$id_anuncio.",'".$sesion."',NOW())");


//---------------------------------------------------------------------------------------------------





//----------------------------------------BARRA DE ADMINISTRADOR------------------------------------------------------
	$barra_gestion="";
	if (isset($_SESSION['nick_gestion']))
	{
		$barra_gestion="<table width='800' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#CCCC33'>
							  <tr>
								<td>
								  Status revisión: <br /><br />
								  
									<input type='button' name='button' id='button' value='Reprobar revisión' %enabled% onClick='document.location.href=".chr(34)."../admin/anuncios/procesarIndividual.php?accion=reprobar&id_anuncio=".$anuncio->id.chr(34)."' />&nbsp;&nbsp;&nbsp;
									<input type='button' name='button2' id='button2' value='Aprobar revisión' %enabled% onClick='document.location.href=".chr(34)."../admin/anuncios/procesarIndividual.php?accion=aprobar&id_anuncio=".$anuncio->id.chr(34)."' />&nbsp;&nbsp;&nbsp;
									<a href=".chr(34)."../admin/anuncios/redirect.php?codigo=".$anuncio->codigo_verificacion.chr(34)."' target='_blank'>Editar anuncio</a>
								</td>
							  </tr>
							</table> ";
			
		if ($anuncio->status_revision!="Revision")
			$barra_gestion=str_replace("%enabled%","disabled",$barra_gestion);
		else
			$barra_gestion=str_replace("%enabled%","",$barra_gestion);
			
	}
//-------------------------------------------------------------------------------------------------------------------

	$url_completa="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<? 
	if (substr_count($_SERVER['HTTP_HOST'],"testhispamercado")==0)
		echo '<base href="http://www.hispamercado.com.ve/anuncio/" />';
	else
		echo '<base href="http://www.testhispamercado.com/anuncio/" />';
?>





<title><? echo $anuncio->titulo." - ".$anuncio->ciudad ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="<? echo $anuncio->textoDescripcion() ?>">
<meta property="fb:admins" content="{684722409}"/>


<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">
<link href="../lib/windows_js_1.3/themes/default.css" rel="stylesheet" type="text/css"></link>
<link href="../lib/windows_js_1.3/themes/alert.css" rel="stylesheet" type="text/css"></link>


<script type="text/javascript" src="../lib/windows_js_1.3/javascripts/prototype.js"> </script> 
<script type="text/javascript" src="../lib/windows_js_1.3/javascripts/effects.js"> </script>
<script type="text/javascript" src="../lib/windows_js_1.3/javascripts/window.js"> </script>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/basicos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/InnerDiv.js"></SCRIPT>
<script type="text/javascript" src="../lib/js/dialog.js"> </script>

<SCRIPT LANGUAGE="JavaScript">	

var fotoActual=1;

function verFoto(foto,anuncio)
{
	if (foto=="adelante")
	{
		foto=fotoActual+1;
		document.getElementById("foto").innerHTML="<a href='javascript:verFotoGrande("+anuncio+","+foto+","+document.getElementById("foto_"+foto+"_w").value+","+document.getElementById("foto_"+foto+"_h").value+")' ><img src='../lib/img.php?tipo=anuncio&anuncio="+anuncio+"&foto="+foto+"' border='0'></a>";
		document.getElementById("foto"+foto).innerHTML="<b>"+foto+"</b>";
		document.getElementById("foto"+fotoActual).innerHTML="<a href='javascript:verFoto("+fotoActual+","+anuncio+")' class='LinkFuncionalidad13'>"+fotoActual+"</a>";
		fotoActual=foto
	}
	else
		if (foto=="atras")
		{
			foto=fotoActual-1;
			document.getElementById("foto").innerHTML="<a href='javascript:verFotoGrande("+anuncio+","+foto+","+document.getElementById("foto_"+foto+"_w").value+","+document.getElementById("foto_"+foto+"_h").value+")' ><img src='../lib/img.php?tipo=anuncio&anuncio="+anuncio+"&foto="+foto+"' border='0'></a>";
			document.getElementById("foto"+foto).innerHTML="<b>"+foto+"</b>";
			document.getElementById("foto"+fotoActual).innerHTML="<a href='javascript:verFoto("+fotoActual+","+anuncio+")' class='LinkFuncionalidad13'>"+fotoActual+"</a>";
			fotoActual=foto
		}
		else
		{
			document.getElementById("foto").innerHTML="<a href='javascript:verFotoGrande("+anuncio+","+foto+","+document.getElementById("foto_"+foto+"_w").value+","+document.getElementById("foto_"+foto+"_h").value+")' ><img src='../lib/img.php?tipo=anuncio&anuncio="+anuncio+"&foto="+foto+"' border='0'></a>";
			document.getElementById("foto"+foto).innerHTML="<b>"+foto+"</b>";
			document.getElementById("foto"+fotoActual).innerHTML="<a href='javascript:verFoto("+fotoActual+","+anuncio+")' class='LinkFuncionalidad13'>"+fotoActual+"</a>";
			fotoActual=foto;
		}
	
	var comilla=String.fromCharCode(34);
	
	if (fotoActual>1)
		document.getElementById("atras").innerHTML="<a href='javascript:verFoto("+comilla+"atras"+comilla+","+anuncio+")' class='LinkFuncionalidad13'><<</a>";
	else
		if (document.Forma.num_fotos.value>1)
			document.getElementById("atras").innerHTML="<<<";
	
	if (fotoActual<document.getElementById("num_fotos").value)
		document.getElementById("adelante").innerHTML="<a href='javascript:verFoto("+comilla+"adelante"+comilla+","+anuncio+")' class='LinkFuncionalidad13'>>></a>";
	else
		if (document.Forma.num_fotos.value>1)
			document.getElementById("adelante").innerHTML=">>";
}

function accionAnuncio(tipo) 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange;
	req.open("GET","../lib/servicios/acciones_anuncio.php?tipo=requerir&que="+tipo, true);
	req.send(null);	
} 
 
function processStateChange()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("ejecuta_accion").innerHTML=req.responseText;						
		} 
		else 
			window.alert("Problema");      
	}
}

function ejecutaAccionAnuncio(tipo,id_anuncio) 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange2;
	req.open("POST","lib/servicios/acciones_anuncio.php?tipo=ejecutar&que="+tipo, true);
	if (tipo=="amigo")
	{
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		req.send("tunombre="+document.Forma.tunombre.value+"&para="+document.Forma.para.value+"&id_anuncio="+id_anuncio+"&captcha="+document.Forma.captcha.value);
		document.Forma.boton_enviar.disabled=true;
		document.Forma.boton_enviar.value="Enviando";
	}
	if (tipo=="anunciante")
	{
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		req.send("tunombre="+document.Forma.tunombre.value+"&tuemail="+document.Forma.tuemail.value+"&id_anuncio="+id_anuncio+"&captcha="+document.Forma.captcha.value+"&mensaje="+document.Forma.mensaje.value);
		document.Forma.boton_enviar.disabled=true;
		document.Forma.boton_enviar.value="Enviando";
	}
		
}

function processStateChange2()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			if (req.responseText=="error captcha")
			{
				window.alert("Código de verificación errado");
				
				document.Forma.boton_enviar.disabled=false;
				document.Forma.boton_enviar.value="Enviar";
			}
			else
				if ((req.responseText=="Debe introducir su nombre")||(req.responseText=="Debe introducir su e-mail")
					||(req.responseText=="Debe introducir un mensaje"))
				{	
					window.alert(req.responseText);
					
					document.Forma.boton_enviar.disabled=false;
					document.Forma.boton_enviar.value="Enviar";
				}
				else
					document.getElementById("ejecuta_accion").innerHTML=req.responseText;						
		} 
		else 
		{
			window.alert("Problema");      
		
			document.Forma.boton_enviar.disabled=false;
			document.Forma.boton_enviar.value="Enviar";
		}
	}
} 

function dejarComentario(id)
{
	posicion=posicionElemento("recomendar");
	INNERDIV.newInnerDiv('dejarComentario',500,posicion['top']-10,400,250,'dejarComentario.php?id_anuncio='+id+"&adsad=",'Realizar comentario');
}

function recomendarAmigo(id)
{
	fecha = now();
	dialog(400,190,"recomendarAmigo.php?id_anuncio="+id+"&hora="+fecha);
}

function contactarAnunciante(id)
{
	fecha = now();
	dialog(400,450,"contactarAnunciante.php?id_anuncio="+id+"&hora="+fecha);
	
}

function verFotoGrande(anuncio,foto,w,h)
{
	fecha = now();
	dialog(w+80,h+80,"verFoto.php?anuncio="+anuncio+"&foto="+foto+"&hora="+fecha);
	
}


function verVideo(id)
{
	fecha = now();
	dialog(600,500,"verVideo.php?id_video="+id+"&hora="+fecha);
}

function validarContacto()
{
	//EXPRESIONES REGULARES
	var patron_email=/^[^@ ]+@[^@ ]+.[^@ .]+$/;
	
	document.Forma_Contacto.button.value="Enviando....";
	document.Forma_Contacto.button.disabled=true;
	
	$good=false;
	
	if (trim(document.Forma_Contacto.tu_nombre.value)=="")
		window.alert("Debes indicar tu nombre");
	else
		if (patron_email.test(trim(document.Forma_Contacto.tu_email.value))=="")
			window.alert("Debes indicar un email valido");
		else
			if (trim(document.Forma_Contacto.comentario.value)=="")
				window.alert("Debes ingresar el mensaje que va a recibir el anunciante");
			else
			{
				document.Forma_Contacto.submit();
				$good=true;
			}
	
	if ($good==false)
	{
		document.Forma_Contacto.button.disabled=false;
		document.Forma_Contacto.button.value="Enviar consulta";
	}
}



</SCRIPT>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="295" align="left"><a href="../"><img src="../img/logo_290.JPG" alt="Home" width="290" height="46" border="0"></a></td>
    <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></td>
    <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Sección en construcción')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="../sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
  </tr>
</table>
<div style="margin:0 auto 0 auto; width:800px; margin-top:30px;">
	<? echo $barra; ?>
</div>

<div style="margin:0 auto 0 auto; width:800px;">
	<input type="hidden" name="foto_1_w" id="foto_1_w" value="<? if ($anuncio->foto1=="SI") $medidas=$anuncio->tamanoFoto("1"); echo $medidas["w"];  ?>">
          <input type="hidden" name="foto_1_h" id="foto_1_h" value="<? if ($anuncio->foto1=="SI") $medidas=$anuncio->tamanoFoto("1"); echo $medidas["h"];  ?>">
          <input type="hidden" name="foto_2_w" id="foto_2_w" value="<? if ($anuncio->foto2=="SI") $medidas=$anuncio->tamanoFoto("2"); echo $medidas["w"];  ?>">
          <input type="hidden" name="foto_2_h" id="foto_2_h" value="<? if ($anuncio->foto2=="SI") $medidas=$anuncio->tamanoFoto("2"); echo $medidas["h"];  ?>">
          <input type="hidden" name="foto_3_w" id="foto_3_w" value="<? if ($anuncio->foto3=="SI") $medidas=$anuncio->tamanoFoto("3"); echo $medidas["w"];  ?>">
          <input type="hidden" name="foto_3_h" id="foto_3_h" value="<? if ($anuncio->foto3=="SI") $medidas=$anuncio->tamanoFoto("3"); echo $medidas["h"];  ?>">
          <input type="hidden" name="foto_4_w" id="foto_4_w" value="<? if ($anuncio->foto4=="SI") $medidas=$anuncio->tamanoFoto("4"); echo $medidas["w"];  ?>">
          <input type="hidden" name="foto_4_h" id="foto_4_h" value="<? if ($anuncio->foto4=="SI") $medidas=$anuncio->tamanoFoto("4"); echo $medidas["h"];  ?>">
          <input type="hidden" name="foto_5_w" id="foto_5_w" value="<? if ($anuncio->foto5=="SI") $medidas=$anuncio->tamanoFoto("5"); echo $medidas["w"];  ?>">
          <input type="hidden" name="foto_5_h" id="foto_5_h" value="<? if ($anuncio->foto5=="SI") $medidas=$anuncio->tamanoFoto("5"); echo $medidas["h"];  ?>">
          <input type="hidden" name="foto_6_w" id="foto_6_w" value="<? if ($anuncio->foto6=="SI") $medidas=$anuncio->tamanoFoto("6"); echo $medidas["w"];  ?>">
          <input type="hidden" name="foto_6_h" id="foto_6_h" value="<? if ($anuncio->foto6=="SI") $medidas=$anuncio->tamanoFoto("6"); echo $medidas["h"];  ?>">
          
          <input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $_GET['id'] ?>">
          <input name="num_fotos" type="hidden" id="num_fotos" value="<? echo $anuncio->numeroFotos() ?>">
</div>

<div style="margin:0 auto 0 auto; width:800px;">
	<? echo $barra_gestion ?>
</div>

<div style="margin:0 auto 0 auto; width:800px; margin-bottom:20px; margin-top:40px; <? if ($categoria->patriarca()==160) echo 'display:none;' ?>" align="center">
		  <script type="text/javascript"><!--
        google_ad_client = "ca-pub-8563690485788309";
        /* Hispamercado Anuncio Top */
        google_ad_slot = "3487409011";
        google_ad_width = 728;
        google_ad_height = 90;
        //-->
        </script>
        <script type="text/javascript"
        src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
        </script>
        &nbsp; 
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; margin-top:40px; ">
    <tr>
      <td width="537" align="left" valign="bottom" class="arial13Negro"><a href="../" class="LinkFuncionalidad13"><b>Inicio</b></a> &raquo; <?
	 $arbol=$categoria->arbolDeHoja();
	 for ($i=(count($arbol)-1);$i>=0;$i--)
	 {	
		$categoria_aux=new Categoria($arbol[$i]['id']);		
		echo "<a href='../listado.php?id_cat=".$arbol[$i]['id']."' class='LinkFuncionalidad13'><b>".$categoria_aux->nombre."</b></a> &raquo; ";		
	 }
	 echo "<b>".$anuncio->tipo_categoria."</b>";
	  ?></td>
      <td width="263" align="right" valign="bottom" class="arial11Negro">&nbsp;</td>
    </tr>
</table>
  <table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor="#C8C8C8">
  <tr>
    <td height="1"></td>
  </tr>
</table>
  <form name="Forma" method="post" action="">
    <table width="800" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:0px; margin-top:40px;">
      <tr>
        <td width="631"><div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#appId=119426148153054&amp;xfbml=1"></script><fb:like href="http://<? echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>" send="false" layout="button_count" width="110" show_faces="true" font="arial"></fb:like>
    <div style="float:left;"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="hispamercado" data-lang="es">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div></td>
    <td width="169" valign="bottom" align="right"><span class="arial13Negro"><em>Publicado hace <? echo $anuncio->tiempoHace(); ?></em></span></td>
      </tr>
    </table>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8" style="border-collapse:collapse ">
  <tr>
    <td>
      <table width="95%" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:10px;">
      <tr>
          <td width="70%" class="arial17Negro" align="center" ><b><? echo $anuncio->titulo ?></b></td>
          </tr>
    </table></td>
  </tr>
  <tr>
    <td align="center" class="arial17Negro">&nbsp;</td>
  </tr>
</table>
    <table width="800" height="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8">
  <tr>
    <td width="400" valign="center">
    
    	<div id="foto" align="center">
        	<a href="javascript:verFotoGrande(<? echo $id_anuncio; ?>,1,<? $medidas=$anuncio->tamanoFoto("1"); echo $medidas['w']; ?>,<? echo $medidas['h'] ?>)" ><img src="../lib/img.php?tipo=anuncio&anuncio=<? echo $id_anuncio; ?>&foto=1" border="0"></a>
        </div>
        
        <div align="center" style="margin-top:5px;">
        	<?	
			$num_fotos=0;
			if (($anuncio->foto1=="SI")&&($anuncio->foto2=="SI"))
				echo "<var id='atras'><<</var>&nbsp;&nbsp;&nbsp;";
			if ($anuncio->foto1=="SI")
			{
				$num_fotos++;
				echo "<var id='foto1'><b>1</b></var>";				
				if ($anuncio->foto2=="SI")
				{
					$num_fotos++;
					echo "&nbsp; <b>|</b> &nbsp;<var id='foto2'><a href='javascript:verFoto(2,".$id_anuncio.")' class='LinkFuncionalidad13'>2</a></var>";
					if ($anuncio->foto3=="SI")
					{
						$num_fotos++;
						echo "&nbsp; <b>|</b> &nbsp;<var id='foto3'><a href='javascript:verFoto(3,".$id_anuncio.")' class='LinkFuncionalidad13'>3</a></var>";
						if ($anuncio->foto4=="SI")
						{
							$medidas=$anuncio->tamanoFoto("4");
							$num_fotos++;
							echo "&nbsp; <b>|</b> &nbsp;<var id='foto4'><a href='javascript:verFoto(4,".$id_anuncio.")' class='LinkFuncionalidad13'>4</a></var>";
							if ($anuncio->foto5=="SI")
							{
								$num_fotos++;
								echo "&nbsp; <b>|</b> &nbsp;<var id='foto5'><a href='javascript:verFoto(5,".$id_anuncio.")' class='LinkFuncionalidad13'>5</a></var>";
								if ($anuncio->foto6=="SI")
								{
									$num_fotos++;
									echo "&nbsp; <b>|</b> &nbsp;<var id='foto6'><a href='javascript:verFoto(6,".$id_anuncio.")' class='LinkFuncionalidad13'>6</a></var>";													
								}
							}							
						}						
					}					
				}								
			}
			if ($anuncio->video_youtube!="")
			{	
				$aux=explode("?v=",$anuncio->video_youtube);
				$aux2=$aux[1];
				$aux3=explode("&",$aux2);
				$id_video=$aux3[0];
				
				echo "&nbsp; <b>|</b> &nbsp;<var id='foto6'><a href='javascript:verVideo(".chr(34).$id_video.chr(34).")' class='LinkRojo13'>Video</a></var>";
			}
			
			if (($anuncio->foto1=="SI")&&($anuncio->foto2=="SI"))
				echo "&nbsp;&nbsp;&nbsp;<var id='adelante'><a href='javascript:verFoto(".chr(34)."adelante".chr(34).",".$id_anuncio.")' class='LinkFuncionalidad13'>>></a></var>";
		?>
        </div>
    
    
    
    </td>
    
    <td width="400" valign="top">
    
   <div class="arial15RojoPrecio" style=" margin-top:10px; width:94%; float:right;"><strong><? if ((trim($anuncio->precio)!="")&&($anuncio->precio>0)) echo "Bs ".number_format($anuncio->precio,2,',','.') ?></strong></div>
        <?
	$arreglo=$anuncio->detalles();
	$id_cat=$anuncio->id_categoria;
	
	if (($id_cat==4)||($id_cat==3))
		echo "<table width='95%' border='0' align='right' cellpadding='0' cellspacing='4' style='margin-top:10px; clear:both;'>
				  <tr>
				  	<td align='left' class='arial13Negro'><em>Urbanizaci&oacute;n</em></td>
					<td align='left' class='arial13Negro'>".$arreglo['urbanizacion']."</td>	
				  </tr>
				  <tr>
					<td width='25%' align='left' class='arial13Negro'><em>Superficie</em></td>
					<td width='75%' align='left' class='arial13Negro'>".$arreglo['m2']." m2</td>
				  </tr>
				   <tr>
					<td align='left' class='arial13Negro'><em>Habitaciones</em></td>
					<td align='left' class='arial13Negro'>".$arreglo['habitaciones']."</td>
				  </tr>
				</table>";
	
	
	if (($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		echo "<table width='95%' border='0' align='right' cellpadding='0' cellspacing='4' style='margin-top:10px; clear:both;'>
			  <tr>
				<td width='25%' align='left' class='arial13Negro'><em>Urbanización</em></td>
				<td width='75%' align='left' class='arial13Negro'>".$arreglo['urbanizacion']."</td>
			  </tr>
			  <tr>
				<td align='left' class='arial13Negro'><em>Superficie</em></td>
				<td align='left' class='arial13Negro'>".$arreglo['m2']." m2</td>
			  </tr>
			</table>";
	
	
	if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		echo "<table width='95%' border='0' align='right' cellpadding='0' cellspacing='4' style='margin-top:10px; clear:both;'>
			  <tr>
				<td width='25%' align='left' class='arial13Negro'><em>Marca</em></td>
				<td width='75%' align='left' class='arial13Negro'>".$arreglo['marca']."</td>
			  </tr>
			   <tr>			
				<td align='left' class='arial13Negro'><em>Modelo</em></td>
				<td align='left' class='arial13Negro'>".$arreglo['modelo']."</td>				
			  </tr>
			   <tr>			
				<td align='left' class='arial13Negro'><em>A&ntilde;o</em></td>
				<td align='left' class='arial13Negro'>".$arreglo['anio']."</td>
			  </tr>
			   <tr>			
				<td align='left' class='arial13Negro'><em>Kilometraje</em></td>
				<td align='left' class='arial13Negro'>".$arreglo['kms']."</td>
			  </tr>
			</table>";
	
?>
    
    
    <table width="95%" border="0" cellspacing="4" cellpadding="0" align="right" style="margin-top:10px; clear:both;">
      <tr>
        <td width="25%" class="arial13Negro"><em>Anunciante</em></td>
        <td width="75%" class="arial13Negro"><span class="arial13Negro"><? echo $nombre; ?></span></td>
      </tr>
      <tr>
        <td class="arial13Negro"><em>Ubicaci&oacute;n</em></td>
        <td><span class="arial13Negro"><? echo $anuncio->ciudad.", ".$provincia ?></span></td>
      </tr>
      <tr>
        <td class="arial13Negro"><em>Tel&eacute;fonos</em></td>
        <td class="arial13Negro"><? if (trim($anuncio->anunciante_telefonos)!="") echo $anuncio->anunciante_telefonos; else echo "no indicado"; ?></td>
      </tr>
    </table>
    
    <table width="95%" border="0" cellspacing="0" cellpadding="0" align="right" style="clear:left;">
  <tr>
    <td><div style="margin:0 auto 0 auto; width:100%; border-bottom:#D2D2D2 dashed 2px; margin-bottom:5px; margin-top:15px;"></div></td>
  </tr>
</table>
    
    <table width="95%" border="0" cellspacing="0" cellpadding="0" align="right" style="clear:both;">
      <tr>
        <td align="left"><a href="javascript:contactarAnunciante(<? echo $id_anuncio ?>)" class="LinkFuncionalidad13"><img src="../img/Mail_32x32.png" alt="" width="32" height="30" border="0"></a></td>
        <td align="left"><a href="javascript:contactarAnunciante(<? echo $id_anuncio ?>)" class="LinkFuncionalidad13">Contactar al anunciante</a></td>
        <td align="left" id="favorito_<? echo $anuncio->id ?>"><a href='javascript:aFavoritos(<? echo $anuncio->id ?>,"../")'><img src='../img/favorito0.gif' title='A&ntilde;adir a favoritos' width='26' height='25' border='0'></a></td>
        <td align="left" class="arial13Negro">Favoritos</td>
      </tr>
      <tr>
        <td width="10%" align="left"><a href="javascript:recomendarAmigo(<? echo $id_anuncio ?>)"><img src="../img/amigo.jpg" alt="" width="30" height="23" border="0"></a></td>
        <td width="45%" align="left"><a href="javascript:recomendarAmigo(<? echo $id_anuncio ?>)" class="LinkFuncionalidad13" id="recomendar2">Recomendar a un amigo</a></td>
        <td width="8%" align="left">&nbsp;</td>
        <td width="27%" align="left">&nbsp;</td>
      </tr>
    </table>
    
    </td>
  </tr>
    </table>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#F4F9E8">
      <tr>
        <td>&nbsp;<? echo $anuncio->descripcion ?></td>
      </tr>
    </table>
    <div style="margin:0 auto 0 auto; width:800px; margin-top:15px; <? if ($categoria->patriarca()==160) echo 'display:none;' ?>">
      <script type="text/javascript"><!--
		google_ad_client = "ca-pub-8563690485788309";
		/* Hispamercado__Anuncio */
		google_ad_slot = "8673209427";
		google_ad_width = 800;
		google_ad_height = 90;
		//-->
		</script>
	  <script type="text/javascript"
		src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
		</script>&nbsp;
	</div>
    <table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
    <td><hr width="800"></td>
  </tr>
</table>

<table width="800px" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#F4F9E8">
      <tr bgcolor="#F4F9E8">
        <td align="left" class="arial13Negro" height="40"><strong>Comentarios recibidos</strong></td>
    </tr>
      <tr>
        <td valign="top"><div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script><fb:comments href="<? echo $url_completa ?>" num_posts="5" width="800"></fb:comments></td>
    </tr>
    </table> 
</form>  
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