<?
	include "lib/class.php";
	$sesion=checkSession();
	
	//PARA EVITAR PROBLEMAS CON HTACCESS
	if (( isset($_GET['tipo']) )&& ($_GET['tipo']=="")) 		unset($_GET['tipo']);
	if (( isset($_GET['ciudad']) )&& ($_GET['ciudad']=="")) 	unset($_GET['ciudad']);
	if (( isset($_GET['id_cat']) )&& ($_GET['id_cat']=="")) 	unset($_GET['id_cat']);
	
	
	
	//------SI CATEGORIA NO EXISTE LO MANDO PAL INDEX
	if (isset($_GET['id_cat']))
	{
		$query=operacionSQL("SELECT id FROM Categoria WHERE id=".$_GET['id_cat']);
		if (mysql_num_rows($query)==0)
			echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='http://www.hispamercado.com.ve/';			
			</SCRIPT>";
	}
	
	
			
//--------------------------------------------------------------------------------------------------------
	$aux_tipo="";
	$aux_ciudad="";
	$aux_cat="";
	$aux_marca="";
	$aux_anio="";
	$aux_modelo="";
	
	
	
	$url_actual="listado.php?";
	$url_rewrite="";
	
	
	$aux="SELECT id FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
	$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo' AND (id=99999999";	
	$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
	$aux_cat="SELECT id_categoria,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
	
	
	
	if (isset($_GET['id_cat']))
	{
		$url_actual.="id_cat=".$_GET['id_cat'];	
		
		$id_cat=$_GET['id_cat'];
		
		$cat=new Categoria($id_cat);
		$enlace=$cat->armarEnlace();
		
		$url_rewrite.=$enlace;
		
		
		if (($id_cat==4)||($id_cat==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		{
			$aux="SELECT id FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";	
			$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_cat="SELECT id_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";																																	  			
		}
		
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{
			$aux="SELECT id FROM Anuncio,Anuncio_Detalles_Vehiculos  WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos  WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";	
			$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_cat="SELECT id_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";																																  
			$aux_marca="SELECT marca,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_anio="SELECT anio,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_modelo="SELECT modelo,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
		}
		
		
		$categoria=new Categoria($id_cat);
		$hijos=$categoria->hijos();		
		
		for ($i=0;$i<count($hijos);$i++)
		{
			$aux.=" OR id_categoria=".$hijos[$i];
			$aux_tipo.=" OR id_categoria=".$hijos[$i];
			$aux_ciudad.=" OR id_categoria=".$hijos[$i];
			$aux_cat.=" OR id_categoria=".$hijos[$i];
			$aux_marca.=" OR id_categoria=".$hijos[$i];
			$aux_anio.=" OR id_categoria=".$hijos[$i];
			$aux_modelo.=" OR id_categoria=".$hijos[$i];
		}
	}
	if (isset($_GET['tipo']))
	{
		$url_actual.="&tipo=".$_GET['tipo'];
		$url_rewrite.="tipo-".$_GET['tipo']."/";
		
		
		$aux.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_tipo.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_ciudad.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_cat.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_marca.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_anio.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_modelo.=") AND (tipo_categoria='".$_GET['tipo']."'";
		
	}
	if (isset($_GET['ciudad']))
	{
		$url_actual.="&ciudad=".$_GET['ciudad'];
		$url_rewrite.="ciudad-".$_GET['ciudad']."/";
		
		$aux.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_tipo.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_ciudad.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_cat.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_marca.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_anio.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_modelo.=") AND (ciudad='".$_GET['ciudad']."'";
	}
	if (isset($_GET['m2']))
	{
		$url_actual.="&m2=".$_GET['m2'];
		
		if ($_GET['m2']=="menos50")	$aux_aux=") AND (m2<50";
		if ($_GET['m2']=="50-100")	$aux_aux=") AND (m2>=50) AND (m2<=100";
		if ($_GET['m2']=="100-150")	$aux_aux=") AND (m2>=100) AND (m2<=150";
		if ($_GET['m2']=="150-200")	$aux_aux=") AND (m2>=150) AND (m2<=200";
		if ($_GET['m2']=="200-250")	$aux_aux=") AND (m2>=200) AND (m2<=250";
		if ($_GET['m2']=="250-300")	$aux_aux=") AND (m2>=250) AND (m2<=300";
		if ($_GET['m2']=="mas300")	$aux_aux=") AND (m2>50";
		
		
		$aux.=$aux_aux;
		$aux_tipo.=$aux_aux;
		$aux_ciudad.=$aux_aux;
		$aux_cat.=$aux_aux;
	}
	if (isset($_GET['hab']))
	{
		$url_actual.="&hab=".$_GET['hab'];
		
		if ($_GET['hab']=="1")	$aux_aux=") AND (habitaciones=1";
		if ($_GET['hab']=="2")	$aux_aux=") AND (habitaciones=2";
		if ($_GET['hab']=="3")	$aux_aux=") AND (habitaciones=3";
		if ($_GET['hab']=="4")	$aux_aux=") AND (habitaciones=4";
		if ($_GET['hab']=="5")	$aux_aux=") AND (habitaciones=5";
		if ($_GET['hab']=="mas5")	$aux_aux=") AND (habitaciones>5";
		
		
		$aux.=$aux_aux;
		$aux_tipo.=$aux_aux;
		$aux_ciudad.=$aux_aux;
		$aux_cat.=$aux_aux;
	}
	if (isset($_GET['marca']))
	{
		$url_actual.="&marca=".$_GET['marca'];
		
		$aux.=") AND (marca='".$_GET['marca']."'";
		$aux_tipo.=") AND (marca='".$_GET['marca']."'";
		$aux_ciudad.=") AND (marca='".$_GET['marca']."'";
		$aux_cat.=") AND (marca='".$_GET['marca']."'";
		$aux_marca.=") AND (marca='".$_GET['marca']."'";
		$aux_anio.=") AND (marca='".$_GET['marca']."'";
		$aux_modelo.=") AND (marca='".$_GET['marca']."'";
		
	}
	if (isset($_GET['anio']))
	{
		$url_actual.="&anio=".$_GET['anio'];
		
		$aux.=") AND (anio=".$_GET['anio'];
		$aux_tipo.=") AND (anio=".$_GET['anio'];
		$aux_ciudad.=") AND (anio=".$_GET['anio'];
		$aux_cat.=") AND (anio=".$_GET['anio'];
		$aux_marca.=") AND (anio=".$_GET['anio'];
		$aux_anio.=") AND (anio=".$_GET['anio'];
		$aux_modelo.=") AND (anio=".$_GET['anio'];
	}
	if (isset($_GET['modelo']))
	{
		$url_actual.="&modelo=".$_GET['modelo'];
		
		$aux.=") AND (modelo='".$_GET['modelo']."'";
		$aux_tipo.=") AND (modelo='".$_GET['modelo']."'";
		$aux_ciudad.=") AND (modelo='".$_GET['modelo']."'";
		$aux_cat.=") AND (modelo='".$_GET['modelo']."'";
		$aux_marca.=") AND (modelo='".$_GET['modelo']."'";
		$aux_anio.=") AND (modelo='".$_GET['modelo']."'";
		$aux_modelo.=") AND (modelo='".$_GET['modelo']."'";
	}
	
	$aux.=") ORDER BY fecha DESC";
	$aux_tipo.=") GROUP BY tipo_categoria ORDER BY C DESC";
	$aux_ciudad.=") GROUP BY ciudad ORDER BY ciudad ASC";
	$aux_cat.=") GROUP BY id_categoria ORDER BY ciudad ASC";
	$aux_marca.=") GROUP BY marca ORDER BY marca ASC";
	$aux_anio.=") GROUP BY anio ORDER BY anio DESC";
	$aux_modelo.=") GROUP BY modelo ORDER BY modelo ASC";
			
			
			
	
	
//-----------------------------CASO NO CATEGORIA-	
	if (isset($_GET['id_cat'])==false)
	{		
		$aux="SELECT id FROM Anuncio WHERE status_general='Activo'";
		$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo'";
		$aux_cat="SELECT A.id_categoria,COUNT(*) AS C FROM Anuncio A, Categoria B WHERE A.id_categoria=B.id AND status_general='Activo'";
		
		if (isset($_GET['ciudad']))
		{
			$url_actual.="&ciudad=".$_GET['ciudad'];
			
			$aux.=" AND ciudad='".$_GET['ciudad']."'";
			$aux_ciudad.=" AND ciudad='".$_GET['ciudad']."'";
			$aux_cat.=" AND ciudad='".$_GET['ciudad']."'";								
		}
		
		$aux.=" ORDER BY fecha DESC";
		$aux_ciudad.=" GROUP BY ciudad ORDER BY ciudad ASC";
		$aux_cat.=" GROUP BY A.id_categoria ORDER BY B.orden ASC";
	}	
	
	
	
	
	
	
	
	$query=operacionSQL($aux);
	//METIENDO TODOS LOS ANUNCIOS EN UN VECTOR
	for ($i=0;$i<mysql_num_rows($query);$i++)
		$anuncios[$i]=mysql_result($query,$i,0);
	




	
	
//---------------------------ARMANDO PAGINACION--------------------------------
	if ( (isset($_GET['factor']))==false )
		$factor=30;
	else
	{
		$factor=$_GET['factor'];
		$url_actual.="&factor=".$_GET['factor'];
	}	
	
	
	if ( (isset($_GET['parte']))==false )
		$parte=1;
	else
		$parte=$_GET['parte'];
//---------------------------------------------------------





	
//----------------------------------------------ARMANDO TITULO--------------------------
	$titulo="Anuncios clasificados";
	if (isset($_GET['id_cat']))
	{
		$titulo.=", ";
		
		$arbol=$categoria->arbolDeHoja();
		for ($i=count($arbol)-1;$i>=0;$i--)
			$titulo.=$arbol[$i]['nombre']." - ";
			
		$titulo=substr($titulo,0,strlen($titulo)-3);
	}	
	
	if (isset($_GET['tipo'])) $titulo.=", ".$_GET['tipo'];
	if (isset($_GET['ciudad'])) $titulo.=", ".$_GET['ciudad']; else $titulo.=", Venezuela";
//------------------------------------------------------------------------------------------	
	
?>




<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<base href="http://www.hispamercado.com.ve/" />


<title><? echo $titulo ?></title>




<style type="text/css">

#listado
{
	width:180px;	
	float:left;
	margin-right:15px;
	text-align:left;
}


</style>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="<? echo $titulo ?>">

<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">


<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/InnerDivMod.js"></SCRIPT>

<SCRIPT LANGUAGE="JavaScript" >

function verMasCiudades()
{
	posicion=posicionElemento("listadoCiudades_html");
	INNERDIV_MOD.newInnerDiv('listadoCiudades',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaCiudades').value,'Ver todas las ciudades');
}
function verMasModelos()
{
	posicion=posicionElemento("listadoModelos_html");
	INNERDIV_MOD.newInnerDiv('listadoModelos',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaModelos').value,'Ver todos los modelos');
}
function verMasAnios()
{
	posicion=posicionElemento("listadoAnios_html");
	INNERDIV_MOD.newInnerDiv('listadoAnios',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaAnios').value,'Ver todos los a�os');
}

function verMasMarcas()
{
	posicion=posicionElemento("listadoMarcas_html");
	INNERDIV_MOD.newInnerDiv('listadoMarcas',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaMarcas').value,'Ver todos las marcas');
}


function accionBuscar()
{
	if ((document.getElementById("buscar").value=="�Qu� estas buscando?")||(document.getElementById("buscar").value==""))
		window.alert("Debes indicar un t�rmino de b�squeda v�lido");
	else
	{
		url=document.getElementById("url_actual").value;	

		if (url.indexOf("buscar=")==-1)			
			url=url+"&buscar="+document.getElementById("buscar").value
		else
			url=url.replace("buscar="+document.getElementById("busqueda_actual").value,"buscar="+document.getElementById("buscar").value)
		
		//window.alert(url);
		document.location.href="http://www.hispamercado.com.ve/"+url;
	}
}

function manejoBusqueda(donde)
{
	//window.alert(document.getElementById("buscar").value);
	if (donde=="adentro")
		if (document.getElementById("buscar").value=="�Qu� estas buscando?")
			document.getElementById("buscar").value="";
	
	if (donde=="afuera")
		if (document.getElementById("buscar").value=="")
			document.getElementById("buscar").value="�Qu� estas buscando?";
}

function validar(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) accionBuscar();
}

</SCRIPT>
</head>
<body>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="730" align="left" valign="top" ><div style="width:100%;"> <img src="img/logo_original.jpg" alt="" width="360" height="58" /> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span></div></td>
    <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
      <?
	
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
        <input name="buscar2" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event)" id="buscar2" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado" />
        &nbsp;
        <select name="categorias" id="categorias" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
          <option selected="selected" value="todas">Todas las categor&iacute;as</option>
          <?
				$query=operacionSQL("SELECT id,nombre FROM Categoria WHERE id<>160 AND id_categoria IS NULL");
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
          <input type="button" name="button2" id="button2" value="Buscar" onClick="listarRecientes()" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;" />
        </label>
      </div></td>
    </tr>
  </table>
</div>



<div align="center" style="margin-top:50px;">
  <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
    <tr>
      <td width="677" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio</b></a> &raquo; 
      <?
	  		if ( isset($_GET['id_cat']) )
			{
				$categoria=new Categoria($_GET['id_cat']);
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
			}	
	  ?>
      </td>
      <td width="323" align="right" valign="bottom"><input type="hidden" name="listaCiudades" id="listaCiudades">
        <input type="hidden" name="listaModelos" id="listaModelos">
        <input type="hidden" name="listaAnios" id="listaAnios">
      <input type="hidden" name="listaMarcas" id="listaMarcas"></td>
    </tr>
  </table>
</div>



<div style="margin:0 auto 0 auto; margin-top:10px; width:1000px; clear:both; display:table;">
<?
	
	$count_div=0;
	
	//AQUI ESTOY METIENDO LA CANITDAD DE ANUNCIOS POR CADA CATEGORIA HOJAS EN UN VECTOR CON EL ID DE CADA CATEGORIA COMO INDICE
	$cate_anuncios=array();
	$query_cat=operacionSQL($aux_cat);
	for ($i=0;$i<mysql_num_rows($query_cat);$i++)
	{
		$cate_anuncios[mysql_result($query_cat,$i,0)]=mysql_result($query_cat,$i,1);
	}
	
	
	
	
	// ------CATEGORIAS
	if (isset($_GET['id_cat'])==false)
	{
		$count_div++;
		echo '<div id="listado" style="margin-right:50px; width:auto;">
		
		
		<div style="margin-bottom:5px;" class="arial12Negro">Categorias</div>';
		
		$query=operacionSQL("SELECT id FROM Categoria WHERE id_categoria IS NULL ORDER BY orden ASC");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$cate=new Categoria(mysql_result($query,$i,0));
			
			
			$cuenta=0;
			$hijoss=$cate->hijos();			
			for ($e=0;$e<count($hijoss);$e++)
			{
				$id_hijo=$hijoss[$e];
				
				if (isset($cate_anuncios[$id_hijo]))
					$cuenta=$cuenta+$cate_anuncios[$id_hijo];
				
			}
			
			if ($cuenta>0)
				echo '<div style="margin-bottom:5px;">&raquo; <a href="'.$url_actual.'&id_cat='.$cate->id.'" class="LinkFuncionalidad12">'.$cate->nombre.' ('.$cuenta.')</a></div>';
		}
		
		echo '</div>';
		
	}
	else
	{
		//Existen hijos inmediatos?
		$cate=new Categoria($_GET['id_cat']);
		
		if ($cate->esHoja()==false)
		{
			
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;">
			
			<div style="margin-bottom:5px;" class="arial12Negro">Sub-categorias</div>';
			
			
			$hijos=$cate->hijosInmediatos();
						
			for ($i=0;$i<count($hijos);$i++)
			{
				$cate2=new Categoria($hijos[$i]);
				
				
				$cuenta=0;
				$hijoss=$cate2->hijos();			
				for ($e=0;$e<count($hijoss);$e++)
				{
					$id_hijo=$hijoss[$e];
					
					if (isset($cate_anuncios[$id_hijo]))
						$cuenta=$cuenta+$cate_anuncios[$id_hijo];				
				}
				
				
				$url=str_replace("id_cat=".$_GET['id_cat'],"id_cat=".$hijos[$i],$url_actual);
				if ($cuenta>0)
					echo '<div style="margin-bottom:5px;">&raquo; <a href="'.$url.'" class="LinkFuncionalidad12">'.$cate2->nombre.' ('.$cuenta.')</a></div>';
			}
			
			echo '</div>';
		}
		
	}






	//---TIPOS- DEPENDE DE QUE EXISTA UNA CATEGORIA SELECCIONADA
	if ( isset($_GET['id_cat'])==true )
		if ( isset($_GET['tipo'])==false ) // TIPO DE OPERACION NO SELECCIONADA
		{
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;">
			
			<div class="arial12Negro" style="margin-bottom:5px;">Tipo de operaci�n</div>';
			
			$query_tipo=operacionSQL($aux_tipo);
			
			for ($i=0;$i<mysql_num_rows($query_tipo);$i++)
			{
				$url=$url_actual."&tipo=".mysql_result($query_tipo,$i,0);
				echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_tipo,$i,0)." (".mysql_result($query_tipo,$i,1).")</a></div>";
			}
			
			echo '</div>';
			
			
		}
		else // TIPO DE OPERACION SI SELECCIONADA
		{
			
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;" class="arial12Gris">';
			
			$url=str_replace("tipo=".$_GET['tipo'],"",$url_actual);
			
			echo "<strong>Tipo de operaci�n: ".$_GET['tipo']." <a href='".$url."'> <img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			
			echo '</div>';
		}
		
		
		
		
		
		//CIUDADES
		$ciudades="";
		$ciudades_7="";
		if ( isset($_GET['ciudad'])==false )
		{
			$count_div++;
			
			echo '<div id="listado" style="margin-right:50px; width:auto;">
			
			<div class="arial12Negro" style="margin-bottom:5px;" id="listadoCiudades_html">Ciudades</div>';
			
			
			$query_ciudad=operacionSQL($aux_ciudad);
						
			for ($i=0;$i<mysql_num_rows($query_ciudad);$i++)
			{	
					$url=$url_actual."&ciudad=".mysql_result($query_ciudad,$i,0);
						
						
					$ciudades.="<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_ciudad,$i,0)." (".mysql_result($query_ciudad,$i,1).")</a></div>";		
			}
			
			
			echo "<SCRIPT LANGUAGE='JavaScript'>
						document.getElementById('listaCiudades').value='".str_replace("'",'"',"<p align='left'>".$ciudades)."</p>';					
				</SCRIPT>";
					
					
			if (mysql_num_rows($query_ciudad)<=7)
				echo $ciudades;
			else
			{
				for ($i=0;$i<7;$i++)
				{	
					$url=$url_actual."&ciudad=".mysql_result($query_ciudad,$i,0);	
						
						
					$ciudades_7.="<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_ciudad,$i,0)." (".mysql_result($query_ciudad,$i,1).")</a></div>";		
				}
				echo $ciudades_7;
				echo "<div style='margin-bottom:5px;'>&raquo; <a href='javascript:verMasCiudades()' class='LinkRojo13'><i>Ver mas ciudades</i></a></div>";
			}		
		
			echo '</div>';
		}
		else
		{
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;" class="arial12Gris">';
			
			$url=str_replace("ciudad=".$_GET['ciudad'],"",$url_actual);
			
			
			echo "<strong>Ciudad: ".$_GET['ciudad']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			echo '</div>';
			
		}
		
		





		//-----------------CASO DETALLES: OTROS INMUEBLES
		if (isset($_GET['id_cat']))
		if (($_GET['id_cat']==4)||($_GET['id_cat']==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		{
			
			if ( isset($_GET['m2'])==false )
			{
				$count_div++;
				echo '<div id="listado" style="margin-right:50px; width:auto;">
				
				
				<div class="arial12Negro" id="listadoCiudades_html" style="margin-bottom:5px;">Superficie</div>';
				
				$aux_aux=str_replace("WHERE","WHERE m2<50 AND",$aux);
				
				
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=menos50' class='LinkFuncionalidad12'>menos de 50 m2 (".mysql_num_rows($query_aux).")</a></div>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>=50 AND m2<=100 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=50-100' class='LinkFuncionalidad12'>50 - 100 m2 (".mysql_num_rows($query_aux).")</a></div>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>=100 AND m2<=150 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=100-150' class='LinkFuncionalidad12'>100 - 150 m2 (".mysql_num_rows($query_aux).")</a></div>";
			
				$aux_aux=str_replace("WHERE","WHERE m2>=150 AND m2<=200 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=150-200' class='LinkFuncionalidad12'>150 -200 m2 (".mysql_num_rows($query_aux).")</a></div>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>=200 AND m2<=300 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=200-300' class='LinkFuncionalidad12'>200 - 300 m2 (".mysql_num_rows($query_aux).")</a></div>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>300 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=mas300' class='LinkFuncionalidad12'>mas de 300 m2 (".mysql_num_rows($query_aux).")</a></div>";
					
					
				echo '</div>';
			}			
			else
			{
				if ($_GET['m2']=="menos50")	$leyenda="menos de 50 m2";
				if ($_GET['m2']=="50-100")	$leyenda="50 - 100 m2";
				if ($_GET['m2']=="100-150")	$leyenda="100 - 150 m2";
				if ($_GET['m2']=="150-200")	$leyenda="150 - 200 m2";
				if ($_GET['m2']=="200-250")	$leyenda="200 - 250 m2";
				if ($_GET['m2']=="250-300")	$leyenda="250 - 300 m2";
				if ($_GET['m2']=="mas300")	$leyenda="mas de 300 m2";

				
				
				$count_div++;
				echo '<div id="listado" style="margin-right:50px; width:auto;" class="arial12Gris">';
				
				$url=str_replace("m2=".$_GET['m2'],"",$url_actual);
				
				echo "<strong>Superficie: ".$leyenda." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
				
				echo '</div>';
			}
		}



		//-----------------CASO DETALLES: CASAS-APTOS DONDE ESTA EL PARAMETRO HABITACIONES
		if (isset($_GET['id_cat']))
		if (($id_cat==4)||($id_cat==3))
		{
			if ( isset($_GET['hab']) )
			{
				if ($_GET['hab']=="1")		$leyenda="1 habitaci�n";
				if ($_GET['hab']=="2")		$leyenda="2";
				if ($_GET['hab']=="3")		$leyenda="3";
				if ($_GET['hab']=="4")		$leyenda="4";
				if ($_GET['hab']=="5")		$leyenda="5";
				if ($_GET['hab']=="mas5")	$leyenda="mas de 5";
	
				
				$count_div++;
				echo '<div id="listado" style="margin-right:50px; width:auto;" class="arial12Gris">';
				
				
				$url=str_replace("hab=".$_GET['hab'],"",$url_actual);
				
				
				echo "<strong>Habitaciones: ".$leyenda." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
				
				
				echo '</div>';
			}
			else
			{				
				$count_div++;
				echo '<div id="listado" style="margin-right:50px; width:auto;">
				
				<div class="arial12Negro" style="margin-bottom:5px;">Habitaciones:</div>';
				
				$aux_aux=str_replace("WHERE","WHERE habitaciones=1 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=1' class='LinkFuncionalidad12'>1 habitaci�n (".mysql_num_rows($query_aux).")</a></div>";					
					
				$aux_aux=str_replace("WHERE","WHERE habitaciones=2 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=2' class='LinkFuncionalidad12'>2 habitaciones (".mysql_num_rows($query_aux).")</a></div>";
					
				$aux_aux=str_replace("WHERE","WHERE habitaciones=3 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=3' class='LinkFuncionalidad12'>3 habitaciones (".mysql_num_rows($query_aux).")</a></div>";
					
				$aux_aux=str_replace("WHERE","WHERE habitaciones=4 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=4' class='LinkFuncionalidad12'>4 habitaciones (".mysql_num_rows($query_aux).")</a></div>";
					
				$aux_aux=str_replace("WHERE","WHERE habitaciones=5 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=5' class='LinkFuncionalidad12'>5 habitaciones (".mysql_num_rows($query_aux).")</a></div>";
					
				$aux_aux=str_replace("WHERE","WHERE habitaciones>5 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=mas5' class='LinkFuncionalidad12'>mas de 5 habitaciones (".mysql_num_rows($query_aux).")</a></div>";
						
						
				echo '</div>';
			
			}
			
		}



	if (isset($_GET['id_cat']))
	if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
	{
		
		$anios="";				
		
		
		if (isset($_GET['anio']))
		{			
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;" class="arial12Gris">';
			
			$url=str_replace("anio=".$_GET['anio'],"",$url_actual);
			
			echo "<strong>A�o: ".$_GET['anio']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			echo '</div>';		
		}
		else
		{
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;">
			
			<div class="arial12Negro" id="listadoAnios_html" style="margin-bottom:5px;" >A�o: </div>';
					
					

			$query_anio=operacionSQL($aux_anio);
			for ($i=0;$i<mysql_num_rows($query_anio);$i++)
				$anios.="<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&anio=".mysql_result($query_anio,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_anio,$i,0)." (".mysql_result($query_anio,$i,1).")</a></div>";
						
			echo "<SCRIPT LANGUAGE='JavaScript'>
					document.getElementById('listaAnios').value='".str_replace("'",'"',"<p align='left'>".$anios."</p>")."';					
				</SCRIPT>";
			
			
			if (mysql_num_rows($query_anio)<=7)
				echo $anios;
			else
			{
				for ($i=0;$i<7;$i++)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&anio=".mysql_result($query_anio,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_anio,$i,0)." (".mysql_result($query_anio,$i,1).")</a></div>";


							
				echo "<div style='margin-bottom:5px;'>&raquo; <a href='javascript:verMasAnios()' class='LinkRojo13'><i>Ver mas a�os</i></a></div>";
			}				
		
			echo '</div>';
		}
		
		
		
		
		
		
		
		if (isset($_GET['marca']))
		{			
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;"  class="arial12Gris">';
			
			$url=str_replace("marca=".$_GET['marca'],"",$url_actual);
			
			
			echo "<strong>Marca: ".$_GET['marca']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			echo '</div>';
		}
		else
		{
			
			$marcas="";
			$count_div++;
			echo '<div id="listado" style="margin-right:50px; width:auto;">
			
			
			<div class="arial12Negro" id="listadoMarcas_html" style="margin-bottom:5px;">Marca: </div>';
	
			$query_marca=operacionSQL($aux_marca);
			for ($i=0;$i<mysql_num_rows($query_marca);$i++)
				$marcas.="<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&marca=".mysql_result($query_marca,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_marca,$i,0)." (".mysql_result($query_marca,$i,1).")</a></div>";
		
			echo "<SCRIPT LANGUAGE='JavaScript'>
					document.getElementById('listaMarcas').value='".str_replace("'",'"',"<p align='left'>".$marcas."</p>")."';					
			</SCRIPT>";
				
				
				
			if (mysql_num_rows($query_marca)<=7)
				echo $marcas;
			else
			{
				for ($i=0;$i<7;$i++)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&marca=".mysql_result($query_marca,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_marca,$i,0)." (".mysql_result($query_marca,$i,1).")</a></div>";
					
				echo "<div style='margin-bottom:5px;'>&raquo; <a href='javascript:verMasMarcas()' class='LinkRojo13'><i>Ver mas marcas</i></a></div>";
			}
			
			echo '</div>';
			
		}	
			
		
		
		
		
		
		
		
		if (isset($_GET['marca']))
		if (isset($_GET['modelo']))
		{
			$count_div++;
			
			echo '<div id="listado" style="margin-right:50px; width:auto;" class="arial12Gris">';
			
			$url=str_replace("modelo=".$_GET['modelo'],"",$url_actual);
				
			echo "<strong>Modelo: ".$_GET['modelo']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			
			echo '</span></div>';
		}
		else
		{			
			$count_div++;
			$modelos="";			
			
			
			echo '<div id="listado" style="margin-right:50px; width:auto;">
			
			
			<div class="arial12Negro" id="listadoModelos_html" style="margin-bottom:5px;" >Modelo </div>';
			
				
			$query_modelo=operacionSQL($aux_modelo);
			for ($i=0;$i<mysql_num_rows($query_modelo);$i++)
			{	
				$url=$url_actual."&modelo=".mysql_result($query_modelo,$i,0);				
				$modelos.="<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_modelo,$i,0)." (".mysql_result($query_modelo,$i,1).")</a></div>";			
			}
				
			echo "<SCRIPT LANGUAGE='JavaScript'>
					document.getElementById('listaModelos').value='".str_replace("'",'"',"<p align='left'>".$modelos."</p>")."';					
			</SCRIPT>";				
				
			if (mysql_num_rows($query_modelo)<=7)
				echo $modelos;
			else
			{
				for ($i=0;$i<7;$i++)
				{	
					$url=$url_actual."&modelo=".mysql_result($query_modelo,$i,0);				
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_modelo,$i,0)." (".mysql_result($query_modelo,$i,1).")</a></div>";			
				}
				echo "<div style='margin-bottom:5px;'>&raquo; <a href='javascript:verMasModelos()' class='LinkRojo13'><i>Ver mas modelos</i></a></div>";
			}
			
			echo '</div>';
		}
		
			
		
	}//FIN CASO CARROS

?>
</div>


<div id="contenedor_contenido" style="margin:0 auto 0 auto; margin-top:40px; width:1000px; clear:both">


<div id="contenedor_anuncios" style="margin:0 auto 0 auto; width:700px; float:left; ">
  
  		<div align="right" style="margin-bottom:5px; padding-right:15px;" class="arial13Negro">
  		  <?
	
	$primero=$factor*($parte-1);
	$ultimo=$primero+$factor;
	
	if ($ultimo>count($anuncios))
		$ultimo=count($anuncios);	
		
		
	echo ($primero+1)." - ".$ultimo. " de ".count($anuncios);
	
	?>
  		</div>
  
        <div>  
          <?
            $medio=intval(31/2);
            for ($i=$primero;$i<$ultimo;$i++)
            {		
                if (($i%2)==0)
                    $colorete="#F2F7E6";			
                else
                    $colorete="#FFFFFF";
                
               	$anuncio=new Anuncio($anuncios[$i]);
                echo $anuncio->armarAnuncio($colorete);		
            }
            
            if (count($anuncios)==0)
                echo "<table width='800' border='0' align='center' cellspacing='0'>
                      <tr>
                        <td align='center' class='arial13Gris'><b>no se encontraron resultados para tu b&uacute;squeda</b></td>
                      </tr>
                    </table>";
            
        ?>
        </div>
        
        <div style=" margin-top:10px;" align="center">
          <?
		
	if (count($anuncios)>0)
	{			
		$total=count($anuncios);
		$resto=$total%$factor;
		$entero=(int)($total/$factor);		
		
		//if ($_GET['id_cat']!="")
			//$actual="listado.php?id_cat=".$id_cat; 
		$actual=$url_actual;
		
		//cuando aparece el link anterior
		if ((($entero>1)||(($entero==1)&&($resto>0)))&&($parte!="1"))
			echo "<a href='".$actual."&parte=".($parte-1)."&factor=".$factor."' class='LinkFuncionalidad12'><< Anterior</a> | ";
		
		for ($i=0;$i<$entero;$i++)
		{
			$primero=($i*$factor)+1;
			$ultimo=($i+1)*$factor;
			
			$mostrar_aux=($i+1)."_".$factor;
						
			if (($i+1)!=$parte)
				echo "<a href='".$actual."&parte=".($i+1)."&factor=".$factor."' class='LinkFuncionalidad12'>".$primero." - ".$ultimo."</a>";
			else
				echo "<span class='arial12Negro'>".$primero." - ".$ultimo."</span>";
			
			if (!(($resto==0)&&(($i+1)==$entero)))
				echo " | ";
		}
		
		if ($resto>0)
		{	
			$primero=($i)*($factor+1);
			$ultimo=$total;
			
			$mostrar_aux=($i+1)."_".$mostrar['factor'];
						
			if (($i+1)!=$parte)
				echo "<a href='".$actual."&parte=".($i+1)."&factor=".$factor."' class='LinkFuncionalidad12'>".$primero." - ".$ultimo."</a>";
			else
				echo "<span class='arial12Negro'>".$primero." - ".$ultimo."</span>";
		}
	}
	
	if ($parte<($i))
		echo " | <a href='".$actual."&parte=".($parte+1)."&factor=".$factor."' class='LinkFuncionalidad12'>Siguiente >></a>";
	
	?>
        </div>
        
</div>


<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; width:274px; border:#999 1px solid; border-bottom:0px; float:left; margin-left:15px; margin-top:23px;"><strong><span class="arial15Negro">Conversaciones relacionadas</span></strong></div>

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