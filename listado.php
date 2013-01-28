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
		if ($_GET['m2']=="200-300")	$aux_aux=") AND (m2>=200) AND (m2<=300";
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
	
	
	//echo "<br><br><br>".$aux."<br><br><br>";
	
	if (isset($_GET['id_cat'])==false)
		$aux=str_replace("ORDER BY","AND (id_categoria<>160 AND id_categoria<>164  AND id_categoria<>165  AND id_categoria<>3820) ORDER BY ",$aux);
	
	
	//echo "<br><br><br>".$aux."<br><br><br>";
	
	$query=operacionSQL($aux);
	//METIENDO TODOS LOS ANUNCIOS EN UN VECTOR
	for ($i=0;$i<mysql_num_rows($query);$i++)
		$anuncios[$i]=mysql_result($query,$i,0);
	


	//TRATANDO TEMA DE LA BUSQUEDA
	if (isset($_GET['buscar']))
	{		
		$url_actual.="&buscar=".trim($_GET['buscar']);
		
		if (isset($_GET['id_cat']))
			$cat_busqueda=$_GET['id_cat'];
		else
			$cat_busqueda="NO";
			
			
		if (isset($_GET['ciudad']))
			$ciudad=$_GET['ciudad'];
		else
			$ciudad="NO";
			
						
		if (isset($_GET['tipo']))
			$tipo=$_GET['tipo'];
		else
			$tipo="NO";
			
			
		if (isset($_GET['m2']))
			$m2=$_GET['m2'];
		else
			$m2="NO";
			
			
		if (isset($_GET['hab']))
			$hab=$_GET['hab'];
		else
			$hab="NO";
			
			
		if (isset($_GET['marca']))
			$marca=$_GET['marca'];
		else
			$marca="NO";
			
			
		
		if (isset($_GET['modelo']))
			$modelo=$_GET['modelo'];
		else
			$modelo="NO";			
			
		
		if (isset($_GET['anio']))
			$anio=$_GET['anio'];
		else
			$anio="NO";
			
			
		$resul=buscarSphinx(trim($_GET['buscar']),$cat_busqueda,$tipo,$ciudad,$m2,$hab,$marca,$modelo,$anio,"ALL","ORG");			
		
		$anuncios=$resul['anuncios'];
		
	}



	
	
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
<link href="lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<script src="lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="lib/facebox/src/facebox.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>

<SCRIPT LANGUAGE="JavaScript" >

	jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'lib/facebox/src/loading.gif',
        closeImage   : 'lib/facebox/src/closelabel.png'
      })
    })
	

</SCRIPT>
</head>


<body onLoad="<?
if (isset($_SESSION['puntos'])) 
{
	echo "callFaceboxPuntos('../puntosGanados.php?puntos=".$_SESSION['puntos']."&tipo=".$_SESSION['puntos_tipo']."')";
	unset($_SESSION['puntos']);
	unset($_SESSION['puntos_tipo']);
}
?>">
<div id="hidden_clicker" style="display:none;"> 
	<a id="hiddenclicker" href="http://asdf.com" rel="facebox" >Hidden Clicker</a>
</div>

<div id="wrapper">
 <div id="header">
   <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
       <td width="730" align="left" valign="top" ><div style="width:100%;"> <a href="/"><img src="img/logo_original.jpg" alt="" width="360" height="58" border="0" /></a> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span></div></td>
       <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
         <?
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
		
	 ?>
         <table width="270" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td width="40" align="left"><? if (isset($user)) echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
             <td width="230" align="left" ><strong>
               <? if (isset($user)) echo $user->nombre ?>
               &nbsp;&nbsp;&nbsp;</strong><a href="cuenta/index.php?d=<? echo time() ?>" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
           </tr>
         </table>
         <table width="270" border="0" cellspacing="0" cellpadding="0">
           <tr>
             <td  align="right" class="arial11Mostaza" style=" padding-right:38px;">&iexcl;Tienes
               <? if (isset($user)) echo $user->puntos() ?>
               puntos acumulados!</td>
           </tr>
         </table>
       </div>
         <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
           <div style="width:210px; height:26px; float:right; background-image:url(img/fondo_fb.png); background-repeat:repeat;" align="left">
             <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email,publish_stream&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede/Reg&iacute;strate con Facebook</a></div>
           </div>
           <div style="width:26px; height:26px; float:right; background-image:url(img/icon_facebook.png); background-repeat:no-repeat;"></div>
         </div></td>
     </tr>
   </table>
   <div style="margin-top:50px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;"><a href="gestionAnuncio.php" class="LinkFuncionalidad17">Mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="conversaciones/" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="tiendas/" class="LinkFuncionalidad17">Tiendas</a>&nbsp;&nbsp;|&nbsp;&nbsp;<strong><a href="programa-de-puntos.php" class="LinkNaranja15">Programa de puntos</a></strong><a href="tiendas/" class="LinkNaranja15"> </a></td>
    </tr>
  </table>
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="320"><input type="button" name="button2" id="button2" value="Publicar Anuncio" onClick="document.location.href='../publicar/'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;">
        <input type="button" name="button2" id="button2" value="Iniciar conversaci&oacute;n" onClick="document.location.href='../conversaciones/publicar.php'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;"></td>
      <td width="680"><div style="margin:0 auto 0 auto; width:100%; background-color:#D8E8AE; padding-top:3px; padding-bottom:3px; padding-left:5px;">
        <input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event,'../')" id="buscar" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado">
        &nbsp;
        <select name="categorias" id="categorias" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
          <option selected value="todas">Todas las categor&iacute;as</option>
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
          <input type="button" name="button" id="button" value="Buscar" onClick="buscar('../')" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;">
        </label>
      </div></td>
    </tr>
  </table>
</div>
</div>


<div id="content">
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
  
  
  
  	<?
	
				/*if (((isset($_GET['id_cat']))&&($_GET['id_cat']!=160)&&($_GET['id_cat']!=164)&&($_GET['id_cat']!=165)&&($_GET['id_cat']!=3820))||(isset($_GET['id_cat'])==false))
					echo '<div id="ad_top" style="margin:0 auto 0 auto; width:800px; margin-top:20px;">
					<script type="text/javascript"><!--
						google_ad_client = "ca-pub-8563690485788309";
						google_ad_slot = "3887529851";
						google_ad_width = 728;
						google_ad_height = 90;
						//-->
						</script>
						<script type="text/javascript"
						src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
						</script>
					</div>';*/
	
	
	?>

		

  
  
</div>
<div id="contenedor_contenido" style="margin:0 auto 0 auto; margin-top:40px; width:1030px; display:table;">
  
  
  
  <div style="width:330px; margin-right:15px; margin-top:23px; float:left; display:table;">

<?

	//AQUI ESTOY METIENDO LA CANITDAD DE ANUNCIOS POR CADA CATEGORIA HOJAS EN UN VECTOR CON EL ID DE CADA CATEGORIA COMO INDICE
	$cate_anuncios=array();
	$query_cat=operacionSQL($aux_cat);
	for ($i=0;$i<mysql_num_rows($query_cat);$i++)
		$cate_anuncios[mysql_result($query_cat,$i,0)]=mysql_result($query_cat,$i,1);
	
	
	
	if (isset($_GET['buscar']))
	{
		echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
				
				$url=str_replace("buscar=".$_GET['buscar'],"",$url_actual);
				
				echo "<strong>Buscar: ".trim($_GET['buscar'])." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
				
				echo '</div></div>';
	
	}
	
	
	
	
	// ------CATEGORIAS
	if (isset($_GET['id_cat'])==false)
	{
			echo '<div style="margin-bottom:20px;">
			<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Categorías</strong></div>
			<div style="border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
		
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
			
			//PERFECTO-SOY UN GENIO
			if (isset($_GET['buscar']))
			{	
				$categorias5=$resul['categorias'];
				$cuenta=$categorias5[$cate->id];
			}
			
			if ($cuenta>0)
				echo '<div style="margin-bottom:5px;">&raquo; <a href="'.$url_actual.'&id_cat='.$cate->id.'" class="LinkFuncionalidad12">'.$cate->nombre.' ('.$cuenta.')</a></div>';
		}
		
		echo '</div></div>';
		
	}
	else
	{
		//Existen hijos inmediatos?
		$cate=new Categoria($_GET['id_cat']);
		
		
		
		echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
		
		if ($cate->esPadre()==false)	
			$url=str_replace("id_cat=".$_GET['id_cat'],"id_cat=".$cate->padre(),$url_actual);
		else
		{
			$url=str_replace("id_cat=".$_GET['id_cat'],"",$url_actual);
			
			if (isset($_GET['tipo']))
				$url=str_replace("tipo=".$_GET['tipo'],"",$url);
				
			
		}
		
		if (isset($_GET['m2']))
			$url=str_replace("m2=".$_GET['m2'],"",$url);
			
		if (isset($_GET['hab']))
			$url=str_replace("hab=".$_GET['hab'],"",$url);
				
		if (isset($_GET['marca']))
			$url=str_replace("marca=".$_GET['marca'],"",$url);
		
		if (isset($_GET['modelo']))
			$url=str_replace("modelo=".$_GET['modelo'],"",$url);
		
		if (isset($_GET['anio']))
			$url=str_replace("anio=".$_GET['anio'],"",$url);
			
					
		echo "<strong>Categoría: ".$categoria->nombre." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong></div></div>";
				
		
		
		if ($cate->esHoja()==false)
		{
			echo '<div style="margin-bottom:20px;">
			<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Sub-categorías</strong></div>
			<div style="border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
			
			
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
				
				
				if (isset($_GET['buscar']))
				{	
					$categorias5=$resul['categorias'];
					$cuenta=$categorias5[$cate2->id];
				}
				
				
				$url=str_replace("id_cat=".$_GET['id_cat'],"id_cat=".$hijos[$i],$url_actual);
				if ($cuenta>0)
					echo '<div style="margin-bottom:5px;">&raquo; <a href="'.$url.'" class="LinkFuncionalidad12">'.$cate2->nombre.' ('.$cuenta.')</a></div>';
			}
			
			echo '</div></div>';
		}
		
		
	}
	
	
	
	//---TIPOS- DEPENDE DE QUE EXISTA UNA CATEGORIA SELECCIONADA
	if ( isset($_GET['id_cat'])==true )
		if ( isset($_GET['tipo'])==false ) // TIPO DE OPERACION NO SELECCIONADA
		{
			echo '<div style="margin-bottom:20px;">
			
			<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Tipo de operación</strong></div>
			
			<div style="border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
			
			
			if (isset($_GET['buscar']))
			{	
					$tipos=$resul['tipos'];
					
					foreach ( $tipos as $doc => $docinfo )
					{
						$url=$url_actual."&tipo=".$doc;
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".$doc." (".$docinfo.")</a></div>";
					}
			}
			else
			{
			
				$query_tipo=operacionSQL($aux_tipo);			
				for ($i=0;$i<mysql_num_rows($query_tipo);$i++)
				{
					$url=$url_actual."&tipo=".mysql_result($query_tipo,$i,0);
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_tipo,$i,0)." (".mysql_result($query_tipo,$i,1).")</a></div>";
				}
			
			}
			echo '</div></div>';
			
			
		}
		else // TIPO DE OPERACION SI SELECCIONADA
		{
			echo '<div style="margin-bottom:20px;" class="arial12Gris">
			
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
			
			$url=str_replace("tipo=".$_GET['tipo'],"",$url_actual);
			
			echo "<strong>Tipo de operación: ".$_GET['tipo']." <a href='".$url."'> <img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			
			echo '</div></div>';
		}
		
		
		
		
		//CIUDADES
		$ciudades="";
		$ciudades_7="";
		if ( isset($_GET['ciudad'])==false )
		{
			$query_ciudad=operacionSQL($aux_ciudad);
			$scroll='';
			
			
			if (isset($_GET['buscar']))
			{	
				$ciudades=$resul['ciudades'];
				$cuenta=count($ciudades);
			}
			else
				$cuenta=mysql_num_rows($query_ciudad);
			
			if ($cuenta>8)
				$scroll='overflow:scroll; overflow-x:hidden; height:200px;';
			
			echo '<div style="margin-bottom:20px;">
			
			<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Ciudad</strong></div>
			
			<div style="'.$scroll.' border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
			
			if (isset($_GET['buscar']))
			{
				$ciudades=$resul['ciudades'];
					
				foreach ( $ciudades as $doc => $docinfo )
				{
					$url=$url_actual."&ciudad=".$doc;
					
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".$doc." (".$docinfo.")</a></div>";
				}
			}
			else			
				for ($i=0;$i<mysql_num_rows($query_ciudad);$i++)
				{	
						$url=$url_actual."&ciudad=".mysql_result($query_ciudad,$i,0);
							
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_ciudad,$i,0)." (".mysql_result($query_ciudad,$i,1).")</a></div>";		
				}
			
			
			
			echo '</div></div>';
		}
		else
		{
			echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
			
			$url=str_replace("ciudad=".$_GET['ciudad'],"",$url_actual);
			
			
			echo "<strong>Ciudad: ".$_GET['ciudad']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			echo '</div></div>';
			
		}
		
		
		
				//-----------------CASO DETALLES: OTROS INMUEBLES
		if (isset($_GET['id_cat']))
		if (($_GET['id_cat']==4)||($_GET['id_cat']==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		{
			
			if ( isset($_GET['m2'])==false )
			{
				echo '<div style="margin-bottom:20px;">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Superficie</strong></div>
				<div style="border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
				
				
				if (isset($_GET['buscar']))
				{
					$superficies=$resul['superficies'];
					
					if ($superficies['menos50']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=menos50' class='LinkFuncionalidad12'>menos de 50 m2 (".$superficies['menos50'].")</a></div>";
					
					if ($superficies['50-100']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=50-100' class='LinkFuncionalidad12'>50 - 100 m2 (".$superficies['50-100'].")</a></div>";
					
					if ($superficies['100-150']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=100-150' class='LinkFuncionalidad12'>100 - 150 m2 (".$superficies['100-150'].")</a></div>";
				
					if ($superficies['150-200']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=150-200' class='LinkFuncionalidad12'>150 -200 m2 (".$superficies['150-200'].")</a></div>";
					
					if ($superficies['200-300']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=200-300' class='LinkFuncionalidad12'>200 - 300 m2 (".$superficies['200-300'].")</a></div>";
					
					if ($superficies['mas300']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&m2=mas300' class='LinkFuncionalidad12'>mas de 300 m2 (".$superficies['mas300'].")</a></div>";

					
				}
				else
				{	
					//echo "<br>";
					$aux_aux=str_replace("WHERE","WHERE m2<50 AND",$aux);
					//echo "<br>";
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
				
				}
					
					
				echo '</div></div>';
			}			
			else
			{
				if ($_GET['m2']=="menos50")	$leyenda="menos de 50 m2";
				if ($_GET['m2']=="50-100")	$leyenda="50 - 100 m2";
				if ($_GET['m2']=="100-150")	$leyenda="100 - 150 m2";
				if ($_GET['m2']=="150-200")	$leyenda="150 - 200 m2";
				if ($_GET['m2']=="200-300")	$leyenda="200 - 300 m2";
				if ($_GET['m2']=="mas300")	$leyenda="mas de 300 m2";

				
				
			echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
				
				$url=str_replace("m2=".$_GET['m2'],"",$url_actual);
				
				echo "<strong>Superficie: ".$leyenda." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
				
				echo '</div></div>';
			}
		}

		


		//-----------------CASO DETALLES: CASAS-APTOS DONDE ESTA EL PARAMETRO HABITACIONES
	if (isset($_GET['id_cat']))
		if (($id_cat==4)||($id_cat==3))
		{
			if ( isset($_GET['hab']) )
			{
				if ($_GET['hab']=="1")		$leyenda="1 habitación";
				if ($_GET['hab']=="2")		$leyenda="2";
				if ($_GET['hab']=="3")		$leyenda="3";
				if ($_GET['hab']=="4")		$leyenda="4";
				if ($_GET['hab']=="5")		$leyenda="5";
				if ($_GET['hab']=="mas5")	$leyenda="mas de 5";
	
				
			echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
				
				
				$url=str_replace("hab=".$_GET['hab'],"",$url_actual);
				
				
				echo "<strong>Habitaciones: ".$leyenda." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
				
				
				echo '</div></div>';
			}
			else
			{				
				echo '<div style="margin-bottom:20px;">
					<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Habitaciones</strong></div>
					<div style="border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
				
				if (isset($_GET['buscar']))
				{
					$habitaciones=$resul['habitaciones'];
					
					//print_r($habitaciones);
					
					if ($habitaciones['1']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=1' class='LinkFuncionalidad12'>1 habitación (".$habitaciones['1'].")</a></div>";	
					if ($habitaciones['2']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=2' class='LinkFuncionalidad12'>2 habitaciones (".$habitaciones['2'].")</a></div>";	
					if ($habitaciones['3']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=3' class='LinkFuncionalidad12'>3 habitaciones (".$habitaciones['3'].")</a></div>";	
					if ($habitaciones['4']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=4' class='LinkFuncionalidad12'>4 habitaciones (".$habitaciones['4'].")</a></div>";	
					if ($habitaciones['5']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=5' class='LinkFuncionalidad12'>5 habitaciones (".$habitaciones['5'].")</a></div>";	
					if ($habitaciones['mas5']>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=mas5' class='LinkFuncionalidad12'>mas de 5 habitaciones (".$habitaciones['mas5'].")</a></div>";
					
				}
				else
				{
					$aux_aux=str_replace("WHERE","WHERE habitaciones=1 AND",$aux);
					$query_aux=operacionSQL($aux_aux);
					if (mysql_num_rows($query_aux)>0)
						echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&hab=1' class='LinkFuncionalidad12'>1 habitación (".mysql_num_rows($query_aux).")</a></div>";					
						
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
				}
						
				echo '</div></div>';
			
			}
			
		}


		
	if (isset($_GET['id_cat']))
	if (($id_cat==11)||($id_cat==12)||($id_cat==13))
	{
		$anios="";				
		
		if (isset($_GET['anio']))
		{			
			echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
			
			$url=str_replace("anio=".$_GET['anio'],"",$url_actual);
			
			echo "<strong>Año ".$_GET['anio']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			echo '</div></div>';		
		}
		else
		{
			if (isset($_GET['buscar']))
			{
				$anios=$resul['anios'];
				$cuenta=count($anios);
			}
			else
			{
				$query_anio=operacionSQL($aux_anio);
				$cuenta=mysql_num_rows($query_anio);
			}
			
			
			
			$scroll='';
			if ($cuenta>8)
				$scroll='overflow:scroll; overflow-x:hidden; height:200px;';
			
			
			
			echo '<div style="margin-bottom:20px;">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Año</strong></div>
				<div style="'.$scroll.' border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
				
			
					
			if (isset($_GET['buscar']))
				foreach ( $anios as $doc => $docinfo )
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&anio=".$doc."' class='LinkFuncionalidad12'>".$doc." (".$docinfo.")</a></div>";
			else
				for ($i=0;$i<mysql_num_rows($query_anio);$i++)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&anio=".mysql_result($query_anio,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_anio,$i,0)." (".mysql_result($query_anio,$i,1).")</a></div>";
						
		
			echo '</div></div>';
		}
		
		
		
		
		
		
		
		if (isset($_GET['marca']))
		{			
			echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
			
			$url=str_replace("marca=".$_GET['marca'],"",$url_actual);
			
			
			echo "<strong>Marca: ".$_GET['marca']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			echo '</div></div>';
		}
		else
		{			
			if (isset($_GET['buscar']))
			{
				$marcas=$resul['marcas'];
				$cuenta=count($marcas);
			}
			else
			{
				$query_marca=operacionSQL($aux_marca);
				$cuenta=mysql_num_rows($query_marca);
			}
			
			
			
			
			$scroll='';
			if ($cuenta>8)
				$scroll='overflow:scroll; overflow-x:hidden; height:200px;';
			
			
			echo '<div style="margin-bottom:20px;">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Marca</strong></div>
				<div style="'.$scroll.' border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
			
			if (isset($_GET['buscar']))
				foreach ( $marcas as $doc => $docinfo )
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&marca=".$doc."' class='LinkFuncionalidad12'>".$doc." (".$docinfo.")</a></div>";
			else
				for ($i=0;$i<mysql_num_rows($query_marca);$i++)
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url_actual."&marca=".mysql_result($query_marca,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_marca,$i,0)." (".mysql_result($query_marca,$i,1).")</a></div>";
		
				
			echo '</div></div>';
			
		}	
			
	
		
		if (isset($_GET['marca']))
		if (isset($_GET['modelo']))
		{
			echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
			
			
			$url=str_replace("modelo=".$_GET['modelo'],"",$url_actual);
				
			echo "<strong>Modelo: ".$_GET['modelo']." <a href='".$url."'><img src='img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong>";
			
			echo '</div></div>';
		}
		else
		{			
			if (isset($_GET['buscar']))
			{
				$modelos=$resul['modelos'];
				$cuenta=count($modelos);
			}
			else
			{
				$query_modelo=operacionSQL($aux_modelo);
				$cuenta=mysql_num_rows($query_modelo);
			}
			
			$scroll='';
			if ($cuenta>8)
				$scroll='overflow:scroll; overflow-x:hidden; height:200px;';		
			
			
			echo '<div style="margin-bottom:20px;">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Modelo</strong></div>
				<div style="'.$scroll.' border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';			
				
			
			
			if (isset($_GET['buscar']))
				foreach ( $modelos as $doc => $docinfo )
				{	
					$url=$url_actual."&modelo=".$doc;				
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".$doc." (".$docinfo.")</a></div>";			
				}	
			else
				for ($i=0;$i<mysql_num_rows($query_modelo);$i++)
				{	
					$url=$url_actual."&modelo=".mysql_result($query_modelo,$i,0);				
					echo "<div style='margin-bottom:5px;'>&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_modelo,$i,0)." (".mysql_result($query_modelo,$i,1).")</a></div>";			
				}				
		
			
			echo '</div></div>';
		}
		
			
		
	}//FIN CASO CARROS


?>



<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px; margin-top:20px;"><strong><span class="arial15Negro">Conversaciones mas activas</span></strong></div>

<div style="border-left:#999 1px solid; border-right:#999 1px solid;">
        <?
			if (isset($_GET['id_cat'])==false)
				$query=operacionSQL("SELECT id FROM Conversacion WHERE status=1");
			else
			{
				$cate=new Categoria($_GET['id_cat']);
				$hijos=$cate->hijos();
				
				$bloque="(";
				for ($i=0;$i<count($hijos);$i++)
				{
					if ((count($hijos)-1)==$i)
						$bloque.="id_categoria=".$hijos[$i].") ";
					else
						$bloque.="id_categoria=".$hijos[$i]." OR ";
				}
				
				$query=operacionSQL("SELECT id FROM Conversacion WHERE status=1 AND ".$bloque);
				
			}
			
			
			
			$resul=array();
			for ($i=0;$i<mysql_num_rows($query);$i++)
			{
				$conver=new Conversacion(mysql_result($query,$i,0));
				$resul[$conver->id]=$conver->comentariosRecibidos();
			}
			
			arsort($resul);
			
			$z=0;
			foreach ($resul as $key => $val) 
			{
				$conver=new Conversacion($key);
				$usuario=new Usuario($conver->id_usuario);
				
				if (($i%2)==0)
					$colorete="#FFFFFF";			
				else
					$colorete="#F2F7E6";
				
				
				echo '<table width="323" height="70" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#999 1px solid; background-color:'.$colorete.';">
					  <tr>
						<td width="70" align="center">
						<a href="'.$conver->armarEnlace().'" target="_blank">
							
							<img src="https://graph.facebook.com/'.$usuario->fb_nick.'/picture" border=0 alt="'.$conver->titulo.'" title="'.$conver->titulo.'" width="50" heigth="50" /> 
						</a>
						</td>
						<td width="253" style="padding-bottom:5px; padding-top:5px;">
						
						<div>
							<a href="'.$conver->armarEnlace().'" class="tituloAnuncioChico" target="_blank">'.(substr($conver->titulo,0,150)).'</a>
						</div>
						
						<div class=" arial11Negro" align="right" style="padding-right:5px; margin-top:10px;">
							<em>'.$conver->comentariosRecibidos().' comentarios</em>
						</div>
						
						</td>
					  </tr>
					</table>';
					
				$z++;
				if ($z>7)
					break;	
						
			}
				
		?>
       
    
    <div align="center" style="background-color:#F2F7E6; border-bottom:#999 1px solid; padding-bottom:10px; padding-top:10px; ">
    <a href="conversaciones/publicar.php" class="LinkFuncionalidad17" target="_blank">
        <strong><< Iniciar Conversación >></strong></a>
    </div>
    
    </div>
  




  </div>






<div id="contenedor_anuncios" style="margin:0 auto 0 auto; width:680px; float:left; display:table;">
  
          
        <div align="right" style="margin-bottom:5px; padding-right:15px;" class="arial13Negro">
        
        
  		  <?
		  
		  
	if ((isset($anuncios))&&($parte==1))
	{
		$z=0;
		$destacados=array();
		$query=operacionSQL("SELECT id_anuncio FROM AnuncioDestacado WHERE NOW()<fecha_hasta ORDER BY visualizaciones ASC");
		 for ($i=0;$i<mysql_num_rows($query);$i++)
		 {
			 
			 $elemento=mysql_result($query,$i,0);
			 $buscar=array_search($elemento,$anuncios);
			
			 if ($buscar!=NULL)
			 {
				$destacados[$z]=$elemento;
			 	$z++;
				
				
				unset($anuncios[$buscar]);
				$anuncios=array_values($anuncios);	
			 }
			 
			 if ($anuncios[0]==$elemento)
			 {
				$destacados[$z]=$elemento;
			 	$z++;
				
				
				unset($anuncios[0]);				
				$anuncios=array_values($anuncios);
			 }
			 
			 if ($z==5)
			 	break;
				 
				 
		}		
	
	
	if ($z<5)
	{
		$query=operacionSQL("SELECT id_anuncio FROM AnuncioVisitaResumen ORDER BY cuenta DESC");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$elemento=mysql_result($query,$i,0);
			$buscar=array_search($elemento,$anuncios);
			
			if ($buscar!=NULL)
			 {
				$destacados[$z]=$elemento;
			 	$z++;
				
				unset($anuncios[$buscar]);
				$anuncios=array_values($anuncios);
			 }
			 
			 if ($anuncios[0]==$elemento)
			 {
				$destacados[$z]=$elemento;
			 	$z++;
				
				unset($anuncios[0]);	
				$anuncios=array_values($anuncios);
			 }
			 
			 if ($z==5)
			 	break;
			
		}		
	}
		  
			$anuncios=array_values($anuncios);
	}  
	
	
	if (isset($anuncios))
	{
			
		$primero=$factor*($parte-1);
		$ultimo=$primero+$factor;
				

		if ($ultimo>count($anuncios))
			$ultimo=count($anuncios);	
					
					
		echo ($primero+1)." - ".$ultimo. " de ".count($anuncios);
			
	}
		  
	
	?>
  		</div>
        
        <div <? if (!((isset($anuncios))&&($primero==0))) echo 'style=" display:none;"'; ?>>
        <div style="margin:0 auto 0 auto; width:642px; padding:8px; height:20px; background-color:#D8E8AE;" class="arial15Negro">
        
        	<span style="float:left;"><strong>Anuncios  destacados</strong></span>         
        	<span style="float:right;"><a href="programa-de-puntos.php" class="LinkFuncionalidad15"><strong>¿Quieres destacar tus anuncios?</strong></a></span>
            
            
        </div>   
  
  		 <div style=" margin:0 auto 0 auto; border-width:4px; border-style:solid; border-color:#D8E8AE; border-top:0px; margin-bottom:30px; width:650px; clear:both;">
         
         <?
			
			if (isset($anuncios))
			{
				for ($i=0;$i<count($destacados);$i++)
				{		
					if (($i%2)==0)
						$colorete="#F2F7E6";			
					else
						$colorete="#FFFFFF";
					
					$anuncio=new Anuncio($destacados[$i]);
					$contenido=$anuncio->armarAnuncio($colorete);
					
					
					
					echo $contenido;
					
					
					operacionSQL("UPDATE AnuncioDestacado SET visualizaciones=visualizaciones+1 WHERE id_anuncio=".$anuncio->id);	
				}
			}
			
			
			?>
         
         </div>
         </div>
         
  			
  
        <div>  
          <?
		  	
			
			if (isset($anuncios))
			{
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
			}
            
			if (!(isset($anuncios)))	         
    	        echo "<div class='arial13Gris' align='center' style='margin-top:20px;'><strong>no se encontraron resultados para tu b&uacute;squeda</strong></div>";
            
        ?>
        </div>
        
        <div style="margin-top:20px; " align="center">
          <?
	if (isset($anuncios))
	if (count($anuncios)>0)
	{			
		$total=count($anuncios);
		$resto=$total%$factor;
		$entero=(int)($total/$factor);	
		
		
		$bloques=$entero;
		if ($resto>0)
			$bloques++;
		
		$actual=$url_actual;
		
		//cuando aparece el link anterior
		if ($parte > 1)
			echo "<a href='".$actual."&parte=".($parte-1)."&factor=".$factor."' class='LinkFuncionalidad15'><strong><< Anterior</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
		
		
		if ($parte>=5)
		{
			$from=$parte-4;
			$to=$parte+4;
		}
		else
		{
			$from=1;
			$to=10;
		}
		
		
		
		if ($to>$bloques)
			$to=$bloques;
			
		if (($to-$from)<8)
			if ($to-8>0)
				$from=$to-8;
			else
				$from=1;
			
		//echo "*****".($to-$from)."*****";
		
		
		
		
		
		for ($i=$from;$i<=$to;$i++)
		{
			if ($i!=$parte)
				echo "<a href='".$actual."&parte=".$i."&factor=".$factor."' class='LinkFuncionalidad15'><strong>".$i."</strong></a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			else
				echo "<span class='arial15Negro'><strong>".$i."</strong></span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			
			
		}
		
		if ( $parte < $to )
			echo "<a href='".$actual."&parte=".($parte+1)."&factor=".$factor."' class='LinkFuncionalidad15'><strong>Siguiente >></strong></a>";	
	
	}
	
	
	
	?></div>
        
</div>
</div>


</div>

    	<div id="footer" >
        <? echo footer() ?> 
	</div>
</div>





</body>
</html>


<?

	mysql_free_result($query);
	mysql_free_result($query_anio);
	mysql_free_result($query_aux);
	mysql_free_result($query_cat);
	mysql_free_result($query_ciudad);
	mysql_free_result($query_marca);
	mysql_free_result($query_modelo);
	mysql_free_result($query_tipo);
	
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