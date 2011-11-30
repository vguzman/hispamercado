<?	
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);			
	
	$barra=barraPrincipal("../");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
	
	
	if ($_POST['codigo_verificacion']==NULL)
		$codigo_verificacion=$_SESSION['codigo_verificacion'];
	else
		$codigo_verificacion=$_POST['codigo_verificacion'];
		
	
	$_SESSION['codigo_verificacion']=$codigo_verificacion;
	
	
	
	$query=operacionSQL("SELECT id,status_general FROM Anuncio WHERE codigo_verificacion='".$codigo_verificacion."'");
	if (mysql_num_rows($query)==0)
		echo "<script language='javascript' type='text/javascript'>
				window.alert('El código de verificación introducido es inválido');
				document.location.href='index.php';
		</script>";
	else
		if (mysql_result($query,0,1)=="Verificar")
			echo "<script language='javascript' type='text/javascript'>
				window.alert('Este anuncio no se encuentra verificado, para hacerlo debe seguir el enlace que fue enviado a su e-mail cuando se realizó la publicación del mismo');
				document.location.href='index.php';
		</script>";
	
	
	
//*******************************************************************FIN INICIO SESION******************************************

	$temp_id=session_id().time();
//***********************************************************************************************


	



//*******FUNCION ESCALADORA IMAGENES**********************
	function escalarImagen($id_anuncio,$foto,$temp_id)
	{
		$destino="../img/img_bank/".$id_anuncio."_".$foto;		
		
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
		
		if($original_w<$original_h) 
		{
			$muestra_w = intval(($original_w/$original_h)*97);
			$muestra_h=97;				
		}
		else
		{
			$muestra_w=77;
			$muestra_h=intval(($original_h/$original_w)*77);
		}
		$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
			
		imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
		imagedestroy($original);
			
		//Para cerrar y guardar foto			
		imagejpeg($muestra,"../img/img_bank/temp/".$temp_id."_".$foto."_muestra",100);
		imagedestroy($muestra);			
	}



	
	
		
	$anuncio=new Anuncio(mysql_result($query,0,0));
	$categoria=new Categoria($anuncio->id_categoria);
	
	$arbol=$categoria->arbolDeHoja();
	for ($i=count($arbol)-1;$i>=0;$i--)
		$categorias.=$arbol[$i]['id'].";";
	
	$categorias=substr($categorias,0,strlen($categorias)-1);
	
	
	if ($anuncio->status_general=="Activo")
		$status_actual="<span class='arial13Verde'><strong>Activo</strong></span> (<a href='javascript:cambioStatus(0)' class='LinkFuncionalidad13'>Dar de baja</a>)";
	else
		$status_actual="<span class='arial13Rojo'><strong>Inactivo</strong></span> (<a href='javascript:cambioStatus(1)' class='LinkFuncionalidad13'>Activar</a>)";
	
	
	
//--------------------------------TRATAMIENTO DE FOTOS ¡QUE GUEVO!-------------------------------------------------------------
	$value_1="NO";$value_2="NO";$value_3="NO";$value_4="NO";$value_5="NO";$value_6="NO";
	if ($anuncio->foto1=="SI")
	{
		copy("../img/img_bank/".$anuncio->id."_1","../img/img_bank/temp/".$temp_id."_1");
		escalarImagen($anuncio->id,"1",$temp_id);
		$html_foto_1="<img src='../img/img_bank/temp/".$temp_id."_1_muestra?d=".time()."'><br><a href='javascript:borrarFoto(1)' class='LinkFuncionalidad'>eliminar</a>";
		$value_1="SI";
	}
	else
		$html_foto_1="Foto 1";
	if ($anuncio->foto2=="SI")
	{
		copy("../img/img_bank/".$anuncio->id."_2","../img/img_bank/temp/".$temp_id."_2");
		escalarImagen($anuncio->id,"2",$temp_id);
		$html_foto_2="<img src='../img/img_bank/temp/".$temp_id."_2_muestra?d=".time()."'><br><a href='javascript:borrarFoto(2)' class='LinkFuncionalidad'>eliminar</a>";
		$value_2="SI";
	}
	else
		$html_foto_2="Foto 2";
	if ($anuncio->foto3=="SI")
	{
		copy("../img/img_bank/".$anuncio->id."_3","../img/img_bank/temp/".$temp_id."_3");
		escalarImagen($anuncio->id,"3",$temp_id);
		$html_foto_3="<img src='../img/img_bank/temp/".$temp_id."_3_muestra?d=".time()."'><br><a href='javascript:borrarFoto(3)' class='LinkFuncionalidad'>eliminar</a>";
		$value_3="SI";
	}
	else
		$html_foto_3="Foto 3";
	if ($anuncio->foto4=="SI")
	{
		copy("../img/img_bank/".$anuncio->id."_4","../img/img_bank/temp/".$temp_id."_4");
		escalarImagen($anuncio->id,"4",$temp_id);
		$html_foto_4="<img src='../img/img_bank/temp/".$temp_id."_4_muestra?d=".time()."'><br><a href='javascript:borrarFoto(4)' class='LinkFuncionalidad'>eliminar</a>";
		$value_4="SI";
	}
	else
		$html_foto_4="Foto 4";
	if ($anuncio->foto5=="SI")
	{
		copy("../img/img_bank/".$anuncio->id."_5","../img/img_bank/temp/".$temp_id."_5");
		escalarImagen($anuncio->id,"5",$temp_id);
		$html_foto_5="<img src='../img/img_bank/temp/".$temp_id."_5_muestra?d=".time()."'><br><a href='javascript:borrarFoto(5)' class='LinkFuncionalidad'>eliminar</a>";
		$value_5="SI";
	}
	else
		$html_foto_5="Foto 5";
	if ($anuncio->foto6=="SI")
	{
		copy("../img/img_bank/".$anuncio->id."_6","../img/img_bank/temp/".$temp_id."_6");
		escalarImagen($anuncio->id,"6",$temp_id);
		$html_foto_6="<img src='../img/img_bank/temp/".$temp_id."_6_muestra?d=".time()."'><br><a href='javascript:borrarFoto(6)' class='LinkFuncionalidad'>eliminar</a>";
		$value_6="SI";
	}
	else
		$html_foto_6="Foto 6";

?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate"> 

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<script language="javascript" type="text/javascript" src="../lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript">

var status_actual;
var status_actual_html;
function cambioStatus(nuevo)
{
	status_actual_html=document.getElementById("barra_status").innerHTML;
	status_actual=document.Forma['status'].value;
	if (nuevo==1)
	{
		document.getElementById("barra_status").innerHTML="Estatus cambiado a <span class='arial13Verde'><strong>Activo</strong></span> (<a href='javascript:deshacerStatus()' class='LinkFuncionalidad13'>deshacer cambio</a>)";
		document.Forma['status'].value="Activo";
	}
	else
	{
		document.getElementById("barra_status").innerHTML="Estatus cambiado a <span class='arial13Rojo'><strong>Inactivo</strong></span> (<a href='javascript:deshacerStatus()' class='LinkFuncionalidad13'>deshacer cambio</a>)";
		document.Forma['status'].value="Inactivo";
	}
}

function deshacerStatus()
{
	document.getElementById("barra_status").innerHTML=status_actual_html;
	document.Forma['status'].value=status_actual;
}



function detallesAnuncio2(id_cat,id_anuncio) 
{	
	fox=0;
	req=getXMLHttpRequest();
	req.onreadystatechange=processdetallesAnuncio;
	req.open("GET","detallesAnuncio.php?id_cat="+id_cat+"&id_anuncio="+id_anuncio,true);
	req.send(null);
}
function detallesAnuncio(id_cat) 
{	
	fox=0;
	req=getXMLHttpRequest();
	req.onreadystatechange=processdetallesAnuncio;
	req.open("GET","../publicar/detallesAnuncio.php?id_cat="+id_cat,true);
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



function armarCategoria2(id,tipo) 
{	
	fox=0;
	req=getXMLHttpRequest();
	req.onreadystatechange=processArmarCategoria2;
	req.open("GET","../lib/servicios/armarCategoria.php?id="+id+"&tipo="+tipo,true);
	req.send(null);	
}
function processArmarCategoria2()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("categoriasSeleccionadas").innerHTML=req.responseText;
			fox=1;
			
			detallesAnuncio2(document.Forma['id'].value,document.Forma['id_anuncio'].value);			
		} 
		else 
			alert("Problema");      
	}
}








function agregar_categoria()
{	
	if (document.Forma['id'].value=="NULL")
		ventana=window.open("../publicar/agregarCategoria.php","publicar_agregar_categoria","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=750,height=160");
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
	var foto="X";
	
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
	
	if (foto!="X")
		window.open("subirFoto.php?foto="+foto+"&temp_id="+document.Forma['temp_id'].value,"subirFoto","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=130");
	else
		window.alert("Ya has subido todas las fotos posibles");
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
											if (document.Forma.status.value=="Inactivo")
											{
												var dec=window.confirm("Este anuncio se guardará como Inactivo y no aparecerá en los listados del sitio ¿está seguro?");
												if (dec==true)
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
	req.open("GET","../lib/servicios/calibraFotos.php?foto1="+document.Forma['aux1'].value+"&foto2="+document.Forma['aux2'].value+"&foto3="+document.Forma['aux3'].value+"&foto4="+document.Forma['aux4'].value+"&foto5="+document.Forma['aux5'].value+"&foto6="+document.Forma['aux6'].value+"&id_anuncio="+document.Forma['temp_id'].value, true);
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
				document.getElementById("foto1").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['temp_id'].value+"_1_muestra?d="+n+"'><br><a href='javascript:borrarFoto(1)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto1").innerHTML="Foto 1";
			}
			if (document.Forma['aux2'].value!="0")
			{
				document.Forma['foto2'].value="SI";
				n++;
				document.getElementById("foto2").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['temp_id'].value+"_2_muestra?d="+n+"'><br><a href='javascript:borrarFoto(2)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto2").innerHTML="Foto 2";
			}
			if (document.Forma['aux3'].value!="0")
			{
				document.Forma['foto3'].value="SI";
				n++;
				document.getElementById("foto3").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['temp_id'].value+"_3_muestra?d="+n+"'><br><a href='javascript:borrarFoto(3)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto3").innerHTML="Foto 3";
				}
			if (document.Forma['aux4'].value!="0")
			{
				document.Forma['foto4'].value="SI";
				n++;
				document.getElementById("foto4").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['temp_id'].value+"_4_muestra?d="+n+"'><br><a href='javascript:borrarFoto(4)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto4").innerHTML="Foto 4";
			}
			if (document.Forma['aux5'].value!="0")
			{
				document.Forma['foto5'].value="SI";
				n++;
				document.getElementById("foto5").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['temp_id'].value+"_5_muestra?d="+n+"'><br><a href='javascript:borrarFoto(5)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto5").innerHTML="Foto 5";
			}
			if (document.Forma['aux6'].value!="0")
			{
				document.Forma['foto6'].value="SI";
				n++;
				document.getElementById("foto6").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['temp_id'].value+"_6_muestra?d="+n+"'><br><a href='javascript:borrarFoto(6)' class='LinkFuncionalidad'>eliminar</a>";
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






<title>Gestion de anuncio</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body onLoad="armarCategoria2('<? echo $categorias ?>','<? echo $anuncio->tipo_categoria ?>')">

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
        <td width="654" align="left" valign="bottom" class="arial13Negro"><a href="/" class="LinkFuncionalidad13"><b>Inicio </b></a>&raquo;  Gestion de anuncio        </td>
        <td width="146" align="right" valign="bottom" class="arial13Negro"><strong>Anuncio</strong>&nbsp;&nbsp;&nbsp;<a href="comentarios.php" class="LinkFuncionalidad13">Comentarios</a></td>
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
 <form name="Forma" method="post" action="guardar.php">
   <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
     <tr>
       <td width="484" align="left" class="arial13Negro"><strong>Estatus
         <input type="hidden" name="revisar" id="revisar" value="<? echo $_POST['revisar'] ?>">
       </strong></td>
       <td align="right">&nbsp;</td>
     </tr>
   </table>
   <table width="800" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#F4F9E8">
     <tr>
       <td align="left" id="barra_status" class="arial13Negro">Actualmente este anuncio se encuentra <? echo $status_actual ?></td>
     </tr>
   </table>
   <table width="200" border="0" align="center" cellpadding="0" cellspacing="3">
     <tr>
       <td>&nbsp;</td>
     </tr>
   </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="484" align="left" class="arial13Negro"><strong>Categor&iacute;a <span class="arial13Rojo">*</span></strong></td>
      <td align="right"><a href="javascript:agregar_categoria()" class="LinkFuncionalidad13">Seleccionar</a></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#F4F9E8">
    <tr>
      <td align="center" id="categoriasSeleccionadas" class="arial13Negro">no has agregado ninguna categor&iacute;a</td>
    </tr>
  </table>

  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3">
    <tr>
      <td><i><font face="Arial" size="2" color="#666666">
        <input name="id" type="hidden" id="id" value="<? echo $categorias ?>">
        <input name="tipo" type="hidden" id="tipo" value="<? echo $anuncio->tipo_categoria ?>">
        &nbsp;</font></i></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="332" align="left" class="arial13Negro"><strong>Datos del anunciante</strong></td>
      <td width="268" align="right" class="Estilo3"><? //f (isset($_SESSION['user'])) echo "te encuentras logueado como <strong>".$_SESSION['user']."</strong>"; ?></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td width="117" align="left" class="arial13Negro">E-mail <span class="arial13Rojo">*</span></td>
      <td width="258" valign="middle" align="left"><input name="email" type="text" id="email" size="25" maxlength="255" value="<? echo $anuncio->anunciante_email ?>"></td>
      <td width="65" align="left" class="arial13Negro">Nombre <span class="arial13Rojo">*</span></td>
      <td width="340" align="left"><input name="nombre" type="text" id="nombre" size="25" maxlength="255" value="<? echo $anuncio->anunciante_nombre ?>"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Tel&eacute;fono(s)</td>
      <td align="left"><input name="telefonos" type="text" id="telefonos2" size="20" maxlength="255" value="<? echo $anuncio->anunciante_telefonos ?>"></td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </table>
  <table width="200" border="0" align="center" cellpadding="0" cellspacing="3">
    <tr>
      <td>&nbsp;<input name="id_anuncio" type="hidden" id="id_anuncio" value="<? echo $anuncio->id ?>" />
      <input name="temp_id" type="hidden" id="temp_id" value="<? echo $temp_id ?>" >
      <input type="hidden" name="status" id="status" value="<? echo $anuncio->status_general ?>">
      <input type="hidden" name="codigo_verificacion" id="codigo_verificacion" value="<? echo $codigo_verificacion ?>"></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="484" align="left" class="arial13Negro"><strong>Datos del anuncio</strong></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td align="left" class="arial13Negro"> T&iacute;tulo <span class="arial13Rojo">*</span></td>
      <td align="left"><input name="titulo" type="text" id="titulo" size="100" maxlength="255" value="<? echo htmlspecialchars($anuncio->titulo) ?>"></td>
    </tr>
    <tr>
      <td width="112" align="left" class="arial13Negro">Descripci&oacute;n <span class="arial13Rojo">*</span></td>
      <td width="676" align="left"><textarea id="elm1" name="elm1" rows="10" ><? echo $anuncio->descripcion ?>
	</textarea></td>
    </tr>
  </table>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8">
    <tr>
      <td id="barra_detalles_anuncio"></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td align="left" class="arial13Negro">Ciudad <span class="arial13Rojo">*</span></td>
      <td align="left"><input name="ciudad" type="text" id="ciudad" size="40" maxlength="255" value="<? echo $anuncio->ciudad ?>"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Estado <span class="arial13Rojo">*</span></td>
      <td align="left"><select name="provincia" id="provincia">
          <option selected> </option>
          <?
	  	$query=operacionSQL("SELECT id FROM Provincia WHERE id_pais='".$id_pais."'");
		
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$provincia=new Provincia(mysql_result($query,$i,0));
			
			if ($anuncio->id_provincia==$provincia->id)
				echo "<option value='".$provincia->id."' selected>".$provincia->nombre."</option>";
			else
				echo "<option value='".$provincia->id."'>".$provincia->nombre."</option>";
		}
	  ?>
      </select></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Precio </td>
      <td align="left"><input name="precio" type="text" id="precio" size="16" value="<? echo $anuncio->precio ?>">
          <select name="moneda" id="moneda">
            <?
			
			$monedas=$pais->monedas();
			for ($i=0;$i<count($monedas);$i++)
			{
				if ($anuncio->moneda==$monedas[$i])
					echo "<option selected>".$monedas[$i]."</option>";
				else
					echo "<option>".$monedas[$i]."</option>";
			}
		?>
          </select>
          <br>
          <span class="arial11Gris">Usar formato 999.99</span></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Fotos (<a href="javascript:subirFoto()" class="LinkFuncionalidad13">subir foto</a>) </td>
      <td align="left"><table width="600" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#C8C8C8" style="border-collapse:collapse ">
          <tr>
            <td width="100" height="81" align="center" class="arial13Negro" id="foto1"><? echo $html_foto_1 ?></td>
            <td width="100" align="center" class="arial13Negro" id="foto2"><? echo $html_foto_2 ?></td>
            <td width="100" align="center" class="arial13Negro" id="foto3"><? echo $html_foto_3 ?></td>
            <td width="100" align="center" class="arial13Negro" id="foto4"><? echo $html_foto_4 ?></td>
            <td width="100" align="center" class="arial13Negro"  id="foto5"><? echo $html_foto_5 ?></td>
            <td width="100" align="center" class="arial13Negro"  id="foto6"><? echo $html_foto_6 ?></td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Video</td>
      <td align="left"><input name="youtube" type="text" id="youtube" size="72" maxlength="255" value="<? if ($anuncio->video_youtube!="NULL") echo $anuncio->video_youtube ?>">
          <br>
          <span class="arial11Gris">Introducir url del video de YouTube (ejemplo: http://www.youtube.com/watch?v=DZRXe1wtC)</span></td>
    </tr>
  </table>
  <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div align="center">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
      <tr>
        <td><input name="foto1" type="hidden" id="foto1" value="<? echo $value_1 ?>">
        <input name="aux1" type="hidden" id="aux1"></td>
        <td><input name="foto2" type="hidden" id="foto2" value="<? echo $value_2 ?>">
        <input name="aux2" type="hidden" id="aux2"></td>
        <td><input name="foto3" type="hidden" id="foto3" value="<? echo $value_3 ?>">
        <input name="aux3" type="hidden" id="aux3"></td>
        <td><input name="foto4" type="hidden" id="foto4" value="<? echo $value_4 ?>">
        <input name="aux4" type="hidden" id="aux4"></td>
        <td><input name="foto5" type="hidden" id="foto5" value="<? echo $value_5 ?>">
        <input name="aux5" type="hidden" id="aux5"></td>
        <td><input name="foto6" type="hidden" id="foto6" value="<? echo $value_6 ?>">
        <input name="aux6" type="hidden" id="aux6"></td>
      </tr>
  </table>
 
      <p align="center">
        <input type="button" name="Submit" value="Guardar cambios" onClick="colocar()">
</p>
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
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
          <td align="center" class="arial13Negro"><? echo $barraPaises; ?> </td>
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
var pageTracker = _gat._getTracker("UA-3308629-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>