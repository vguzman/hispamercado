<?
	include "../lib/class.php";
	$sesion=checkSession();
	
	
	
	//REDIRECCIONANDO A FRIENDLY URL
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
	$query=operacionSQL("SELECT * FROM Anuncio WHERE id=".$_GET['id']);
	if (mysql_num_rows($query)==0)
		echo "<SCRIPT LANGUAGE='JavaScript'>		
			document.location.href='../index.php';			
		</SCRIPT>";
	
	

	
	
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
	$categoria=new Categoria($anuncio->id_categoria);
//---------------------------------------------------------------------------------------------------------




	if (($anuncio->precio=="")||($anuncio->precio==0))
		$precio="no indicado";
	else
		$precio=number_format($anuncio->precio,2,",",".")." ".$anuncio->moneda;





//---------------------------INFORMACION DE VISITA---------------------------------------------------
	$query=operacionSQL("SELECT * FROM AnuncioVisita WHERE id_anuncio=".$id_anuncio." AND id_sesion='".session_id()."'");
	if (mysql_num_rows($query)==0)
		operacionSQL("INSERT INTO AnuncioVisita VALUES (".$id_anuncio.",'".session_id()."',NOW())");
//---------------------------------------------------------------------------------------------------





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
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="730" align="left" valign="top" ><div style="width:100%;"> <img src="../img/logo_original.jpg" alt="" width="360" height="58" /> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span></div></td>
    <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
      <?
	
	//echo "*****".$sesion."*******";
	if ($sesion!=false)
		$user=new Usuario($sesion);
	
	
	 ?>
      <table width="270" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
          <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="cuenta/index.php?d=<? echo time() ?>" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
        </tr>
      </table>
    </div>
      <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
        <div style="width:160px; height:26px; float:right; background-image:url(img/fondo_fb.png); background-repeat:repeat;" align="left">
          <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede con Facebook</a></div>
        </div>
        <div style="width:26px; height:26px; float:right; background-image:url(img/icon_facebook.png); background-repeat:no-repeat;"></div>
      </div></td>
  </tr>
</table>
<div style="margin-top:50px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;"><a href="gestionAnuncio.php" class="LinkFuncionalidad17">Gestionar mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" class="LinkFuncionalidad17">Tiendas</a></td>
    </tr>
  </table>
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="320"><input type="button" name="button2" id="button2" value="Publicar Anuncio" onClick="document.location.href='publicar/'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;" />
        <input type="button" name="button2" id="button2" value="Iniciar conversaci&oacute;n" onClick="listarRecientes()" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;" /></td>
      <td width="680"><div style="margin:0 auto 0 auto; width:100%; background-color:#D8E8AE; padding-top:3px; padding-bottom:3px; padding-left:5px;">
        <input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event)" id="buscar" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado" />
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
          <input type="button" name="button" id="button" value="Buscar" onClick="listarRecientes()" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;" />
        </label>
      </div></td>
    </tr>
  </table>
</div>
<div style=" margin:0 auto 0 auto; margin-top:50px; border-collapse:collapse; border-bottom:#C8C8C8 1px solid; width:1000px; padding-left:5px;  ">

  <a href="/" class="LinkFuncionalidad15"><b>Inicio</b></a> &raquo;  <?

				$categoria=new Categoria($anuncio->id_categoria);
				$arbol=$categoria->arbolDeHoja();
				$niveles=count($arbol);
				
				for ($i=($niveles-1);$i>=0;$i--)
				{
					$cat=new Categoria($arbol[$i]['id']);
					$enlace=$cat->armarEnlace();
					
					echo "<a class='LinkFuncionalidad15' href='".$enlace."'><b>".$arbol[$i]['nombre']."</b></a>";
					if ($i>0)
						echo " &raquo; ";
				}

	  ?>
  
</div>

  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:25px;">
    <tr>
      <td width="700">
      
      		  <table width="700" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:0px; margin-top:40px;">
      <tr>
        <td width="394"><div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#appId=119426148153054&amp;xfbml=1"></script><fb:like href="http://<? echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>" send="false" layout="button_count" width="110" show_faces="true" font="arial"></fb:like>
    <div style="float:left;"><a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal" data-via="hispamercado" data-lang="es">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div></td>
    <td width="256" valign="bottom" align="right"><span class="arial13Negro"><em>Publicado hace <? echo $anuncio->tiempoHace(); ?></em></span></td>
      </tr>
    </table>
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8" style="border-collapse:collapse ">
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
    <table width="700" height="400" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8">
  <tr>
    <td width="363" valign="center">
    
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
    
    <td width="337" valign="top">
    
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
        </tr>
      <tr>
        <td width="10%" align="left"><a href="javascript:recomendarAmigo(<? echo $id_anuncio ?>)"><img src="../img/amigo.jpg" alt="" width="30" height="23" border="0"></a></td>
        <td width="45%" align="left"><a href="javascript:recomendarAmigo(<? echo $id_anuncio ?>)" class="LinkFuncionalidad13" id="recomendar2">Recomendar a un amigo</a></td>
        </tr>
    </table>
    
    </td>
  </tr>
    </table>
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#F4F9E8">
      <tr>
        <td>&nbsp;<? echo $anuncio->descripcion ?></td>
      </tr>
    </table>
   
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#F4F9E8">
      <tr bgcolor="#F4F9E8">
        <td align="left" class="arial13Negro" height="40"><strong>Comentarios recibidos</strong></td>
    </tr>
      <tr>
        <td valign="top"><div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script><fb:comments href="<? echo $url_completa ?>" num_posts="5" width="700"></fb:comments></td>
    </tr>
    </table> 

      
      </td>
      <td width="300" valign="top">
      
      <div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px; width:300px; margin-left:20px; margin-top:60px;"><strong><span class="arial15Negro">Conversaciones mas activas</span></strong></div>
      <div style="width:300px; margin-left:20px; ">
      	<?
				$cate=new Categoria($anuncio->id_categoria);
				$hijos=$cate->hijos();
				
				$bloque="(";
				for ($i=0;$i<count($hijos);$i++)
				{
					if ((count($hijos)-1)==$i)
						$bloque.="id_categoria=".$hijos[$i].") ";
					else
						$bloque.="id_categoria=".$hijos[$i]." OR ";
				}
				
				$query=operacionSQL("SELECT id_conversacion,COUNT(*) AS C FROM ConversacionComentario A, Conversacion B WHERE B.status=1 AND ".$bloque." AND A.id_conversacion=B.id GROUP BY id_conversacion ORDER BY C DESC LIMIT 5");
				
				
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$conver=new Conversacion(mysql_result($query,$i,0));
					$usuario=new Usuario($conver->id_usuario);
					
					if (($i%2)==0)
						$colorete="#FFFFFF";			
					else
						$colorete="#F2F7E6";
					
					
					echo '<table width="300" height="70" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#999 1px solid; background-color:'.$colorete.'; ">
						  <tr>
							<td width="50" align="center">
							<a href="../'.$conver->armarEnlace().'" target="_blank">
								
								<img src="https://graph.facebook.com/'.$usuario->fb_nick.'/picture" border=0 alt="'.$conver->titulo.'" title="'.$conver->titulo.'" width="30" heigth="30" /> 
							</a>
							</td>
							<td width="250" style="padding-bottom:5px; padding-top:5px;">
							
							<div>
								<a href="../'.$conver->armarEnlace().'" class="tituloAnuncioChico" target="_blank">'.(substr($conver->titulo,0,150)).'</a>
							</div>
							
							<div class=" arial11Negro" align="right" style="padding-right:5px; margin-top:10px;">
								<em>'.mysql_result($query,$i,1).' comentarios</em>
							</div>
							
							</td>
						  </tr>
						</table>';
							
				}
				
				
				
				
				
				
				
		
		?>
        <table width="300" border="0" cellspacing="0" cellpadding="0" style="background-color:#F2F7E6; border-bottom:#999 1px solid;">
	<tr>
		<td align="center" style="padding-bottom:10px; padding-top:10px; "><a href="../conversaciones/publicar.php" class="LinkFuncionalidad17" target="_blank">
        <strong><< Iniciar Conversación >></strong></a></td>
	</tr>
	</table>
      </div>
      
      </td>
    </tr>
  </table>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>

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