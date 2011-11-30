<?	
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);			
	
	$barra=barraPrincipal("../");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<script language="javascript" type="text/javascript" src="../lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript">

function detallesAnuncio(id_cat) 
{	
	fox=0;
	req=getXMLHttpRequest();
	req.onreadystatechange=processdetallesAnuncio;
	req.open("GET","detallesAnuncio.php?id_cat="+id_cat,true);
	req.send(null);	
} 

function processdetallesAnuncio()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("barra_detalles_anuncio").innerHTML=req.responseText;
		} 
		else 
			alert("Problema");      
	}
}



var fox=0;
function armarCategoria(id,tipo) 
{	
	fox=0;
	req=getXMLHttpRequest();
	req.onreadystatechange=processArmarCategoria;
	req.open("GET","../lib/servicios/armarCategoria.php?id="+id+"&tipo="+tipo,true);
	req.send(null);	
	
	
} 


function processArmarCategoria()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("categoriasSeleccionadas").innerHTML=req.responseText;
			fox=1;
			
			ventana.close();
			detallesAnuncio(document.Forma['id'].value);				
		} 
		else 
			alert("Problema");      
	}
}



function agregar_categoria()
{	
	if (document.Forma['id'].value=="NULL")
		ventana=window.open("agregarCategoria.php","publicar_agregar_categoria","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=750,height=160");
	else
		alert("Ya has seleccionado una categoría");
}



function eliminar_categoria()
{
	document.Forma['id'].value="NULL";
	document.Forma['tipo'].value="NULL";
	
	document.getElementById("categoriasSeleccionadas").innerHTML="no has agregado ninguna categor&iacute;a";
	document.getElementById("barra_detalles_anuncio").innerHTML="";
}

function subirFoto()
{	
	var foto;
	
	if (document.Forma['foto1'].value=="NO")
		foto="1"; else
	if (document.Forma['foto2'].value=="NO")
		foto="2"; else
	if (document.Forma['foto3'].value=="NO")
		foto="3"; else
	if (document.Forma['foto4'].value=="NO")
		foto="4"; else
	if (document.Forma['foto5'].value=="NO")
		foto="5"; else
	if (document.Forma['foto6'].value=="NO")
		foto="6";
	
	window.open("subirFoto.php?foto="+foto,"subirFoto","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=130");
}

function borrarFoto(foto)
{	
	document.Forma['foto'+foto].value="NO";
	document.getElementById("foto"+foto).innerHTML="Foto "+foto;
	
	calibrarFotos();		
}


function processBorrarFoto()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			
		} 
		else 
			alert("Ocurrió un problema");      
	}
}

function contar_texto()
{
	texto = new String (document.Forma.texto.value);
	longitud = 700-texto.length;
	if (longitud<0)
	{
		//window.alert("Tamaño máximo alcanzado");
		document.Forma.texto.value=texto.substr(0,700);
	}
	else
		document.getElementById("restan").innerHTML=longitud;	
}

function colocar()
{
	
	var aux=new String(document.Forma.id.value);
	var cates=aux.split(";");
	var id_cat=cates[cates.length-1];
	
	
	if (document.Forma.id.value=="NULL")
		window.alert("Debes seleccionar una categoría para tu anuncio");
	else 
	{
		if (document.Forma.email.value=="")
			window.alert("Debe indicar un e-mail válido");
		else
			if (document.Forma.nombre.value=="")
				window.alert("Debe indicar su nombre");
			else
				//if (document.Forma.elm1.value=="")
					//window.alert("Debe introducir la descripción del anuncio");
				//else
					if (document.Forma.ciudad.value=="")
						window.alert("Debe introducir la ciudad");
					else
						if (document.Forma.provincia.selectedIndex==0)
							window.alert("Debe seleccionar una provincia");
						else
							if ((document.Forma.precio.value!="")&&(validaDecimal(document.Forma.precio.value)==0))
								window.alert("El precio debe tener el formato indicado");
							else
							{
								if ((id_cat==4)||(id_cat==3))
								{
									if (document.Forma.urbanizacion.value=="")
										window.alert("Debes indicar la urbanización, barrio o zona donde se encuentra el inmueble");
									else
										if (validaDecimal(document.Forma.superficie.value)==0)
											window.alert("El valor de la superficie del inmueble debe tener el formato indicado");
										else
											if (validaEntero(document.Forma.habitaciones.value)==0)
												window.alert("El numero de habitaciones del inmueble debe ser un número entero");
											else
												document.Forma.submit();
								}
								else
									if ((id_cat==5)||(id_cat==6)||(id_cat==7)||(id_cat==8)||(id_cat==9)||(id_cat==10)||(id_cat==3707))
									{
										if (document.Forma.urbanizacion.value=="")
											window.alert("Debes indicar la urbanización, barrio o zona donde se encuentra el inmueble");
										else
											if (validaDecimal(document.Forma.superficie.value)==0)
												window.alert("El valor de la superficie del inmueble debe tener el formato indicado");
											else
												document.Forma.submit();
									}
									else
										if ((id_cat==11)||(id_cat==12)||(id_cat==16)||(id_cat==13)||(id_cat==14))
										{
											if (document.Forma.marca.value=="")
												window.alert("Debes indicar la marca del vehículo");
											else
												if (document.Forma.modelo.value=="")
													window.alert("Debes indicar el modelo del vehículo");
												else
													if (validaEntero(document.Forma.anio.value)==0)
														window.alert("El año del vehículo no es correcto");
													else
														if (validaEntero(document.Forma.kms.value)==0)
															window.alert("El kilometraje del vehículo no es correcto");
														else
															document.Forma.submit();
													
										}
										else
											document.Forma.submit();
							
							}
								
	}
}


function calibrarFotos()
{
	document.Forma['aux1'].value="0";
	document.Forma['aux2'].value="0";
	document.Forma['aux3'].value="0";
	document.Forma['aux4'].value="0";
	document.Forma['aux5'].value="0";
	document.Forma['aux6'].value="0";
	
	var num=0;
	
	if (document.Forma['foto1'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="1";
			
	}
	if (document.Forma['foto2'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="2";		
	}
	if (document.Forma['foto3'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="3";	
	}
	if (document.Forma['foto4'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="4";		
	}
	if (document.Forma['foto5'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="5";	
	}
	if (document.Forma['foto6'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="6";	
	}	
	//---------------------------------------------------------	
	req=getXMLHttpRequest();
	req.onreadystatechange=processCalibrar;
	req.open("GET","../lib/servicios/calibraFotosPublicar.php?foto1="+document.Forma['aux1'].value+"&foto2="+document.Forma['aux2'].value+"&foto3="+document.Forma['aux3'].value+"&foto4="+document.Forma['aux4'].value+"&foto5="+document.Forma['aux5'].value+"&foto6="+document.Forma['aux6'].value, true);
	req.send(null);	
}

var n=0;

function processCalibrar()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{			
			document.Forma['foto1'].value="NO";
			document.Forma['foto2'].value="NO";
			document.Forma['foto3'].value="NO";
			document.Forma['foto4'].value="NO";
			document.Forma['foto5'].value="NO";
			document.Forma['foto6'].value="NO";
			
			if (document.Forma['aux1'].value!="0")
			{
				document.Forma['foto1'].value="SI";
				n++;
				document.getElementById("foto1").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_1_muestra?d="+n+"'><br><a href='javascript:borrarFoto(1)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto1").innerHTML="Foto 1";
			}
			if (document.Forma['aux2'].value!="0")
			{
				document.Forma['foto2'].value="SI";
				n++;
				document.getElementById("foto2").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_2_muestra?d="+n+"'><br><a href='javascript:borrarFoto(2)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto2").innerHTML="Foto 2";
			}
			if (document.Forma['aux3'].value!="0")
			{
				document.Forma['foto3'].value="SI";
				n++;
				document.getElementById("foto3").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_3_muestra?d="+n+"'><br><a href='javascript:borrarFoto(3)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto3").innerHTML="Foto 3";
				}
			if (document.Forma['aux4'].value!="0")
			{
				document.Forma['foto4'].value="SI";
				n++;
				document.getElementById("foto4").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_4_muestra?d="+n+"'><br><a href='javascript:borrarFoto(4)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto4").innerHTML="Foto 4";
			}
			if (document.Forma['aux5'].value!="0")
			{
				document.Forma['foto5'].value="SI";
				n++;
				document.getElementById("foto5").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_5_muestra?d="+n+"'><br><a href='javascript:borrarFoto(5)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto5").innerHTML="Foto 5";
			}
			if (document.Forma['aux6'].value!="0")
			{
				document.Forma['foto6'].value="SI";
				n++;
				document.getElementById("foto6").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_6_muestra?d="+n+"'><br><a href='javascript:borrarFoto(6)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto6").innerHTML="Foto 6";
			}	
		} 
		else 
			alert("Ocurrió un problema");      
	}
}


</script>



<script type="text/javascript" src="../lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
	tinyMCE.init({
		// General options
		mode : "exact",
		elements : "elm1",
		theme : "advanced",
		height : "400",
		width : "630",
		language : 'es',		

		plugins : "safari,pagebreak,advhr,advimage,advlink,emotions,insertdatetime,preview,paste,noneditable,inlinepopups",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,cut,copy,paste,|,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "emotions,advhr,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		//theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		//theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,

		// Example word content CSS (should be your site CSS) this one removes paragraph margins
		content_css : "css/word.css",

		// Drop lists for link/image/media/template dialogs
		//template_external_list_url : "lists/template_list.js",
		//external_link_list_url : "lists/link_list.js",
		//external_image_list_url : "lists/image_list.js",
		//media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});
</script>






<title>Gestionar mis anuncios clasificados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>

  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="295" align="left"><a href="../"><img src="../img/logo_290.JPG" width="290" height="46" border="0"></a></td>
      <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados  en Venezuela</em></strong></td>
      <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Sección en construcción')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="../sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
    </tr>
  </table>
  <table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#appId=119426148153054&amp;xfbml=1"></script><fb:like href="http://www.hispamercado.com.ve/" send="false" layout="button_count" width="110" show_faces="true" font="arial"></fb:like>
    <div style="float:left;"><a href="http://twitter.com/share" class="twitter-share-button" data-text="Anuncios clasificados gratis en Venezuela - Inmuebles, Carros, Negocios, Servicios" data-count="horizontal" data-via="hispamercado" data-lang="es">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></div>
    </td>
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
        <td width="220" align="left" valign="bottom" class="arial13Negro"><a href="/" class="LinkFuncionalidad13"><b>Inicio </b></a>&raquo; Gestionar mis anuncios</td>
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
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>

<form name="Forma" method="post" action="index2.php">
  <table width="350"  border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="386" class="arial13Negro">Ingresa el e-mail que utilizaste para publicar tus anuncios<br>
      <input name="email" type="text" id="email" size="60"></td>
    </tr>
  </table>
  <table width="100" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><input type="submit" name="Submit2" value="Gestionar"></td>
    </tr>
  </table>  
</form>

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