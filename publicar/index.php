<?	
	include "../lib/class.php";
	$sesion=checkSession();	



	//CASOS SPAM
	if (isset($_GET['precarga']))
	{
		$query=operacionSQLSpam("SELECT * FROM anuncios WHERE id=".$_GET['precarga']);
		
		if (mysql_num_rows($query)>0)
		{
			$pre_email=mysql_result($query,0,3);
			$pre_nombre=mysql_result($query,0,4);
			$pre_telefonos=mysql_result($query,0,10);
			$pre_titulo=mysql_result($query,0,1);
			$pre_descripcion=mysql_result($query,0,2);
			$pre_ciudad=mysql_result($query,0,8);
		}
	}
	
	
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<meta name="description" content="Publicar aviso clasificado gratis en cualquier ciudad de venezuela con fotos y videos. Publique su anuncio en solo 1 minuto">

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<script language="javascript" type="text/javascript" src="../lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/selecCategoria.js"> </script>
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
			
			//ventana.close();
			detallesAnuncio(document.Forma['id'].value);				
		} 
		else 
			alert("Problema");      
	}
}



function resetCategoria() 
{	
	eliminar_categoria();
	
	req=getXMLHttpRequest();
	req.onreadystatechange=process_selecCategoria;
	req.open("GET","ajax_resetCategoria.php",true);
	req.send(null);
} 


function process_selecCategoria()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("categoriasSeleccionadas").innerHTML=req.responseText;
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
		alert("Ya has seleccionado una categor�a");
}



function eliminar_categoria()
{
	document.Forma['id'].value="NULL";
	document.Forma['tipo'].value="NULL";
	
	//document.getElementById("categoriasSeleccionadas").innerHTML="no has agregado ninguna categor&iacute;a";
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
		window.open("subirFoto.php?foto="+foto,"subirFoto","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=130");
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
			alert("Ocurri� un problema");  
			
	}
}

function contar_texto()
{
	texto = new String (document.Forma.texto.value);
	longitud = 700-texto.length;
	if (longitud<0)
	{
		//window.alert("Tama�o m�ximo alcanzado");
		document.Forma.texto.value=texto.substr(0,700);
	}
	else
		document.getElementById("restan").innerHTML=longitud;	
}

function colocar()
{
	//probarYoutube();
	//while (document.Forma.estado_yutub.value=="X")
		//document.Forma.estado_yutub.value=document.Forma.estado_yutub.value;
	
	var aux=new String(document.Forma.id.value);
	var cates=aux.split(";");
	var id_cat=cates[cates.length-1];
	
	
	
	//EXPRESIONES REGULARES
	var patron_email=/^[^@ ]+@[^@ ]+.[^@ .]+$/;
	var patron_ciudad=/^[a-zA-Z][a-zA-Z\s]+$/;
	var patron_anio=/^19\d\d|200\d|201\d$/;
	var patron_no_vacio=/^\S[\w\W]*$/;
	
	
	
	
	if (document.Forma.id.value=="NULL")
		window.alert("Debes seleccionar una categor�a para tu anuncio");
	else 
	{
		if (patron_email.test(document.Forma.email.value)==false)
			window.alert("Debe indicar un e-mail v�lido");
		else
			if (patron_no_vacio.test(document.Forma.nombre.value)==false)
				window.alert("Debe indicar su nombre");
			else
				if (patron_no_vacio.test(document.Forma.titulo.value)==false)
					window.alert("Debe introducir el t�tulo del anuncio");
				else
					if ((patron_ciudad.test(document.Forma.ciudad.value)==false)&&(document.Forma.ubicacion_fuera.checked==false))
						window.alert("Debe introducir un nombre de ciudad v�lido");
					else
						if ((document.Forma.provincia.selectedIndex==0)&&(document.Forma.ubicacion_fuera.checked==false))
							window.alert("Debe seleccionar una provincia");
						else
							if ((document.Forma.precio.value!="")&&(validaDecimal(document.Forma.precio.value)==0))
								window.alert("El precio debe tener el formato indicado");
							else
							{
								if ((id_cat==4)||(id_cat==3))
								{
									if (patron_no_vacio.test(document.Forma.urbanizacion.value)==false)
										window.alert("Debes indicar la urbanizaci�n, barrio o zona donde se encuentra el inmueble");
									else
										if (validaDecimal(document.Forma.superficie.value)==0)
											window.alert("El valor de la superficie del inmueble debe tener el formato indicado");
										else
											if (validaEntero(document.Forma.habitaciones.value)==0)
												window.alert("El numero de habitaciones del inmueble debe ser un n�mero entero");
											else
												document.Forma.submit();
								}
								else
									if ((id_cat==5)||(id_cat==6)||(id_cat==7)||(id_cat==8)||(id_cat==9)||(id_cat==10)||(id_cat==3707))
									{
										if (patron_no_vacio.test(document.Forma.urbanizacion.value)==false)
											window.alert("Debes indicar la urbanizaci�n, barrio o zona donde se encuentra el inmueble");
										else
											if (validaDecimal(document.Forma.superficie.value)==0)
												window.alert("El valor de la superficie del inmueble debe tener el formato indicado");
											else
												document.Forma.submit();
									}
									else
										if ((id_cat==11)||(id_cat==12)||(id_cat==16)||(id_cat==13)||(id_cat==14))
										{
											if (patron_no_vacio.test(document.Forma.marca.value)==false)
												window.alert("Debes indicar la marca del veh�culo");
											else
												if (patron_no_vacio.test(document.Forma.modelo.value)==false)
													window.alert("Debes indicar el modelo del veh�culo");
												else
													if (patron_anio.test(document.Forma.anio.value)==false)
														window.alert("El a�o del veh�culo no es correcto");
													else
														if (validaEntero(document.Forma.kms.value)==0)
															window.alert("El kilometraje del veh�culo no es correcto");
														else														
															document.Forma.submit();											
													
										}
										else
											if ((document.Forma.youtube.value!="")&&(document.Forma.estado_yutub.value!="1"))
												window.alert("El video introducido no existe o no es v�lido");
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
			alert("Ocurri� un problema");      
	}
}



function control_ubicacion(donde)
{
	if (donde=="fuera")
	{
		if (document.Forma.ubicacion_fuera.checked==true)
		{
			document.Forma.ciudad.value="";
			document.Forma.ciudad.disabled=true;
			document.Forma.provincia.selectedIndex=0;
			document.Forma.provincia.disabled=true;
			
			document.Forma.ubicacion_todo.checked=false;
			
		}
		else
		{
			document.Forma.ciudad.disabled=false;
			document.Forma.provincia.disabled=false;
		}		
	}
	
	
	if (donde=="todo")
	{
		if (document.Forma.ubicacion_todo.checked==true)
		{
			document.Forma.ciudad.value="";
			document.Forma.ciudad.disabled=true;
			document.Forma.provincia.selectedIndex=0;
			document.Forma.provincia.disabled=true;
			
			document.Forma.ubicacion_fuera.checked=false;
			
		}
		else
		{
			document.Forma.ciudad.disabled=false;
			document.Forma.provincia.disabled=false;
		}		
	}
	
	
}


function probarYoutube() 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange2;
	req.open("POST","ajax_comprobarYutub.php", true);
	req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	req.send("url="+document.Forma.youtube.value);		
}

function processStateChange2()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.Forma.estado_yutub.value=req.responseText;								
		} 
		else 
		{
			//window.alert("Problema youtube");
			window.alert(req.status);
		}
	}
} 


</script>



<script type="text/javascript" src="../lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
// General options
mode : "textareas",
theme : "advanced",
height : "450px",
language : "es",
plugins : "table,inlinepopups,preview",

// Theme options
theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,|,bullist,numlist,|,forecolor,backcolor,|",
theme_advanced_buttons2 : "link,unlink,image,table,|,cut,copy,paste,undo,redo,|,preview,|,code,|",
theme_advanced_buttons3 : "",
theme_advanced_buttons4 : "",

theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,


})
</script>






<title>Publicar anuncio clasificado gratis en Venezuela</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="730" align="left" valign="top" ><div style="width:100%;"> <img src="../img/logo_original.jpg" alt="" width="360" height="58"> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span> </div></td>
    <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
      <?
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	
	
	 ?>
      <table width="270" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
          <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="closeSession.php" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
        </tr>
      </table>
    </div>
      <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
        <div style="width:160px; height:26px; float:right; background-image:url(../img/fondo_fb.png); background-repeat:repeat;" align="left">
          <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede con Facebook</a></div>
        </div>
        <div style="width:26px; height:26px; float:right; background-image:url(img/icon_facebook.png); background-repeat:no-repeat;"></div>
      </div></td>
  </tr>
</table>
<div style="margin-top:50px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;"><a href="" class="LinkFuncionalidad17">Gestionar mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" class="LinkFuncionalidad17">Tiendas</a></td>
    </tr>
  </table>
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="320"><input type="button" name="button2" id="button2" value="Publicar Anuncio" onClick="listarRecientes()" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;">
        <input type="button" name="button2" id="button2" value="Iniciar conversaci&oacute;n" onClick="listarRecientes()" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;"></td>
      <td width="680"><div style="margin:0 auto 0 auto; width:100%; background-color:#D8E8AE; padding-top:3px; padding-bottom:3px; padding-left:5px;">
        <input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event)" id="buscar" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado">
        &nbsp;
        <select name="categorias" id="categorias" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
          <option selected value="todas">Todas las categor&iacute;as</option>
          <?
	  	$aux="SELECT id,nombre FROM Categoria WHERE id_pais='".$id_pais."' AND id<>160 AND id_categoria IS NULL";
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
          <option selected value='todas' style='font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C'>Todas las ciudades</option>
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
          <input type="button" name="button" id="button" value="Buscar" onClick="listarRecientes()" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;">
        </label>
      </div></td>
    </tr>
  </table>
</div>
<div style="visibility:hidden; display:none;">
<img src="../img/bigrotation2.gif" width="32" height="32" ></div>
<div align="center" style="margin-top:40px;">
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
 <form name="Forma" method="post" action="publicar.php">
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="484" align="left" class="arial13Negro"><strong>Categor&iacute;a <span class="arial13Rojo">*</span></strong></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#F4F9E8">
    <tr>
      <td align="center" id="categoriasSeleccionadas" class="arial13Negro"><table width="800" align="center" border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="67"><select name="principal" size="6" id="principal" onChange="subcategorias(this)">
            <?			
			$categorias=categorias_principales($id_pais);			
			$total=sizeof($categorias);
			for ($i=0;$i<$total;$i++)
				echo "<option value='".$categorias[$i]['id']."'>".$categorias[$i]['nombre']."</option>";			
		?>
          </select></td>
          <td width="7" align="center" class="arial13Negro"><b>&nbsp;&raquo;&nbsp;</b></td>
          <td width="7" id="sub1">&nbsp;</td>
          <td width="7" id="sig_sub1"></td>
          <td width="7" id="sub2">&nbsp;</td>
          <td width="7" id="sig_sub2"></td>
          <td width="7" id="sub3">&nbsp;</td>
          <td width="7" id="sig_sub3"><div align="center"></div></td>
          <td width="584" align="left" id="final">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3">
    <tr>
      <td><i><font face="Arial" size="2" color="#666666">
        <input name="id" type="hidden" id="id" value="NULL">
        <input name="tipo" type="hidden" id="tipo" value="NULL">
        &nbsp;
        <input name="control_sub2" type="hidden" id="control_sub2" value="NO">
      </font></i></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="332" align="left" class="arial13Negro"><strong>Datos del anunciante</strong></td>
      <td width="268" align="right" class="Estilo3"><? //f (isset($_SESSION['user'])) echo "te encuentras logueado como <strong>".$_SESSION['user']."</strong>"; ?></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td width="117" align="left" class="arial13Negro">E-mail</td>
      <td width="258" valign="middle" align="left"><input name="email" type="text" id="email" size="25" maxlength="255" value="<? echo $pre_email ?>"></td>
      <td width="65" align="left" class="arial13Negro">Nombre</td>
      <td width="340" align="left"><input name="nombre" type="text" id="nombre" size="25" maxlength="255" value="<? echo $pre_nombre ?>"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Tel&eacute;fono(s)</td>
      <td align="left" class="arial13Negro"><input name="telefonos" type="text" id="telefonos2" size="20" maxlength="255" value="<? echo $pre_telefonos ?>"> 
      <em>(opcional)</em></td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </table>
  <table width="200" border="0" align="center" cellpadding="0" cellspacing="3">
    <tr>
      <td>&nbsp;<input name="id_anuncio" type="hidden" id="id_anuncio" value="<? echo session_id(); ?>"></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="484" align="left" class="arial13Negro"><strong>Datos del anuncio</strong></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td align="left" class="arial13Negro"> T&iacute;tulo</td>
      <td align="left"><input name="titulo" type="text" id="titulo" size="100" maxlength="200" value="<? echo $pre_titulo ?>"></td>
    </tr>
    <tr>
      <td width="112" align="left" valign="top" class="arial13Negro">Descripci&oacute;n</td>
      <td width="676" align="left"><textarea id="content" name="content" rows="10" style="width:100%" ><? echo $pre_descripcion ?>
	</textarea></td>
    </tr>
  </table>
    <table width="800" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8">
    <tr>
      <td id="barra_detalles_anuncio"></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td align="left" class="arial13Negro">Ciudad</td>
      <td align="left">
        
        <span class="arial11Gris">Introduzca solo letras y espacios</span><br>
        <input name="ciudad" type="text" id="ciudad" size="40" maxlength="255"><br>
      	  
          
          
          <input name="ubicacion_fuera" type="checkbox" id="ubicacion_fuera" onClick="control_ubicacion('fuera')" value="SI">        
     	<span class="arial11Negro">El producto o servicio anunciado se encuentra fuera del pa�s</span>       
        </td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Estado</td>
      <td align="left"><select name="provincia" id="provincia">
          <option selected> </option>
          <?
	  	$query=operacionSQL("SELECT id FROM Provincia WHERE id_pais='".$id_pais."'");
		
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$provincia=new Provincia(mysql_result($query,$i,0));
			echo "<option value='".$provincia->id."'>".$provincia->nombre."</option>";
		}
	  ?>
      </select></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Precio </td>
      <td align="left" class="arial13Negro"><input name="precio" type="text" id="precio" size="16">
          <select name="moneda" id="moneda">
            <?
			
			$monedas=$pais->monedas();
			for ($i=0;$i<count($monedas);$i++)
				echo "<option>".$monedas[$i]."</option>";
		?>
          </select>
      <em>(opcional)</em><br>
          <span class="arial11Gris">Usar formato 999.99</span></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Fotos (<a href="javascript:subirFoto()" class="LinkFuncionalidad13">subir foto</a>) </td>
      <td align="left"><table width="600" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#C8C8C8" style="border-collapse:collapse ">
          <tr>
            <td width="100" height="81" align="center" class="arial13Negro" id="foto1">Foto 1</td>
            <td width="100" align="center" class="arial13Negro" id="foto2">Foto 2</td>
            <td width="100" align="center" class="arial13Negro" id="foto3">Foto 3</td>
            <td width="100" align="center" class="arial13Negro" id="foto4">Foto 4</td>
            <td width="100" align="center" class="arial13Negro"  id="foto5">Foto 5</td>
            <td width="100" align="center" class="arial13Negro"  id="foto6">Foto 6</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Video <img src="../img/youtube.png" width="16" height="16"></td>
      <td align="left" class="arial13Negro"><input name="youtube" type="text" id="youtube" size="72" maxlength="255" onChange="probarYoutube()">
        <input name="estado_yutub" type="hidden" id="estado_yutub" value="X">
      <em>(opcional)</em><br>
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
        <td><input name="foto1" type="hidden" id="foto1" value="NO">
        <input name="aux1" type="hidden" id="aux1"></td>
        <td><input name="foto2" type="hidden" id="foto2" value="NO">
        <input name="aux2" type="hidden" id="aux2"></td>
        <td><input name="foto3" type="hidden" id="foto3" value="NO">
        <input name="aux3" type="hidden" id="aux3"></td>
        <td><input name="foto4" type="hidden" id="foto4" value="NO">
        <input name="aux4" type="hidden" id="aux4"></td>
        <td><input name="foto5" type="hidden" id="foto5" value="NO">
        <input name="aux5" type="hidden" id="aux5"></td>
        <td><input name="foto6" type="hidden" id="foto6" value="NO">
        <input name="aux6" type="hidden" id="aux6"></td>
      </tr>
  </table>
 
      <p align="center">
        <input type="button" name="Submit" value="Colocar anuncio" onClick="colocar()">
  </p>
      <table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
          <td><input type="hidden" name="referencia" id="referencia" value="<? echo $_GET['precarga'] ?>"></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
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