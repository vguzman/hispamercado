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


<base href="http://www.hispamercado.com.ve/anuncio/" />



<title><? echo $anuncio->titulo." - ".$anuncio->ciudad ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="<? echo $anuncio->textoDescripcion() ?>">


<link rel="image_src" href="http://www.hispamercado.com.ve/lib/img.php?tipo=anuncio&anuncio=<? echo $anuncio->id ?>&foto=1" />



<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">
<link href="../lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />


<script src="../lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="../lib/facebox/src/facebox.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/basicos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/anuncios.js"></SCRIPT>


<SCRIPT LANGUAGE="JavaScript">


function validando(e,path) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) buscando(path);
}


function buscando(path) 
{		
	//window.alert("adfsadjfhsdkjhfkjdshfjkdshfkjds");
	
	if (document.getElementById("buscar").value=="Buscar en Hispamercado")
		document.getElementById("buscar").value="";
	
	categoria=document.getElementById("categorias");
	ciudad=document.getElementById("ciudades");
	buscar=document.getElementById("buscar");
		
	var url="listado.php?";
	if (categoria.options[categoria.selectedIndex].value!="todas")
		url=url+"id_cat="+categoria.options[categoria.selectedIndex].value;
	if (ciudad.options[ciudad.selectedIndex].value!="todas")
		url=url+"&ciudad="+ciudad.options[ciudad.selectedIndex].value;
	if (trim(buscar.value)!="")
		url=url+"&buscar="+trim(buscar.value);

	
	window.alert(path+url);
	document.location.href=path+url;
}

jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../lib/facebox/src/loading.gif',
        closeImage   : '../lib/facebox/src/closelabel.png'
      })
    })
	

</SCRIPT>


</head>
<body>
<div id="fb-root"></div>

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="730" align="left" valign="top" ><div style="width:100%;"> <a href="..//"><img src="../img/logo_original.jpg" alt="" width="360" height="58" border="0"></a> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span> </div></td>
      <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
        <?
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	
	
	 ?>
        <table width="270" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
            <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="../cuenta/index.php?d=<? echo time() ?>&path=../" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="../closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
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
            <input type="button" name="button" id="button" value="Buscar" onclick="buscar('../')" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;" />
          </label>
        </div></td>
      </tr>
    </table>
  </div>
  <form name="Forma" method="post" action="">
  <div style=" margin:0 auto 0 auto; margin-top:50px; border-collapse:collapse; border-bottom:#C8C8C8 1px solid; width:1000px; padding-left:5px;  ">

  <a href="/" class="LinkFuncionalidad15"><b>Inicio</b></a> &raquo;  <?

				$categoria=new Categoria($anuncio->id_categoria);
				$arbol=$categoria->arbolDeHoja();
				$niveles=count($arbol);
				
				for ($i=($niveles-1);$i>=0;$i--)
				{
					$cat=new Categoria($arbol[$i]['id']);
					$enlace=$cat->armarEnlace();
					
					echo "<a class='LinkFuncionalidad15' href='../".$enlace."'><b>".$arbol[$i]['nombre']."</b></a>";
					if ($i>0)
						echo " &raquo; ";
				}

	  ?>
  
  <span style="margin:0 auto 0 auto; width:800px;">
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
</span></div>
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:25px;">
    <tr>
      <td width="700">
      
      		  <table width="700" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:0px; margin-top:40px;">
      <tr>
        <td width="506">
        
        
       <div style="float:left; margin-right:15px;"><div class="g-plusone" data-size="medium" data-annotation="none"></div></div> 
        
    <div style="float:left; ">
    <script src="http://connect.facebook.net/es_ES/all.js#appId=119426148153054&amp;xfbml=1"></script><fb:like href="http://<? echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>" send="false" layout="button_count" width="110" show_faces="true" font="arial"></fb:like>
    </div>
    
    
    <div class="fb-send" style="margin-left:15px; margin-right:15px; float:left;" data-href="http://<? echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>"></div>
    
    
      
    
    <div style="float:left;"><a href="https://twitter.com/share" class="twitter-share-button" data-via="hispamercado" data-lang="es">Twittear</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>
    
    
    
    
    </td>
    <td width="194" valign="bottom" align="right">&nbsp;</td>
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
    <table width="700" height="320" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8">
  <tr>
    <td width="363" valign="center">
    
    	
        
        
        <div id="fotofoto1" align="center" >
        	<a href="verFoto.php?anuncio=<? echo $id_anuncio; ?>&foto=1" rel="facebox" ><img src="../lib/img.php?tipo=anuncio&anuncio=<? echo $id_anuncio; ?>&foto=1" border="0"></a>
        </div>
        
        
        <div style="display:none;" id="fotofoto2" align="center">
        	<a href="verFoto.php?anuncio=<? echo $id_anuncio; ?>&foto=2" rel="facebox" ><img src="../lib/img.php?tipo=anuncio&anuncio=<? echo $id_anuncio; ?>&foto=2" border="0"></a>
           </div>
           
        <div style="display:none;" id="fotofoto3" align="center">
            <a href="verFoto.php?anuncio=<? echo $id_anuncio; ?>&foto=3" rel="facebox" ><img src="../lib/img.php?tipo=anuncio&anuncio=<? echo $id_anuncio; ?>&foto=3" border="0"></a>
            </div>
            
        <div style="display:none;" id="fotofoto4" align="center">
            <a href="verFoto.php?anuncio=<? echo $id_anuncio; ?>&foto=4" rel="facebox" ><img src="../lib/img.php?tipo=anuncio&anuncio=<? echo $id_anuncio; ?>&foto=4" border="0"></a>
            </div>
            
        <div style="display:none;" id="fotofoto5" align="center">
            <a href="verFoto.php?anuncio=<? echo $id_anuncio; ?>&foto=5" rel="facebox" ><img src="../lib/img.php?tipo=anuncio&anuncio=<? echo $id_anuncio; ?>&foto=5" border="0"></a>
            </div>
            
        <div style="display:none;" id="fotofoto6" align="center">
            <a href="verFoto.php?anuncio=<? echo $id_anuncio; ?>&foto=6" rel="facebox" ><img src="../lib/img.php?tipo=anuncio&anuncio=<? echo $id_anuncio; ?>&foto=6" border="0"></a>            
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
	
	
	if (($id_cat==11)||($id_cat==12)||($id_cat==13))
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
				<td align='left' class='arial13Negro'>".number_format($arreglo['kms'],0,".",".")."</td>
			  </tr>
			</table>";
			
	if (($id_cat>=5001)&&($id_cat<=5021))
	{
		if ($arreglo['jornada']=="completo")
			$jornada="Tiempo completo";
		else
			$jornada="Medio tiempo";
			
		if ($arreglo['salario']=="")
			$salario="no indicado";
		else
			$salario=$arreglo['salario'];
			
			
		
		echo "<table width='95%' border='0' align='right' cellpadding='0' cellspacing='4' style='margin-top:10px; clear:both;'>
			  <tr>
				<td width='25%' align='left' class='arial13Negro'><em>Jornada</em></td>
				<td width='75%' align='left' class='arial13Negro'>".$jornada."</td>
			  </tr>
			   <tr>			
				<td align='left' class='arial13Negro'><em>Experiencia</em></td>
				<td align='left' class='arial13Negro'>".$arreglo['experiencia']." años</td>				
			  </tr>
			   <tr>			
				<td align='left' class='arial13Negro'><em>Salario</em></td>
				<td align='left' class='arial13Negro'>".number_format($salario,2,',','.')."</td>
			  </tr>
			</table>";
	}
	
?>
    
    
    <table width="95%" border="0" cellspacing="4" cellpadding="0" align="right" style="margin-top:10px; clear:both;">
      <tr>
        <td width="25%" class="arial13Negro"><em>Anunciante</em></td>
        <td width="75%" class="arial13Negro"><span class="arial13Negro"><? echo $anuncio->anunciante_nombre ?></span></td>
      </tr>
      <tr>
        <td class="arial13Negro"><em>Ubicaci&oacute;n</em></td>
        <td><span class="arial13Negro"><? echo $anuncio->ciudad ?></span></td>
      </tr>
      <tr>
        <td class="arial13Negro"><em>Tel&eacute;fonos</em></td>
        <td class="arial13Negro"><? if (trim($anuncio->anunciante_telefonos)!="") echo $anuncio->anunciante_telefonos; else echo "no indicado"; ?></td>
      </tr>
    </table>
    
    
     <table width="95%" border="0" cellspacing="4" cellpadding="0" align="right" style="margin-top:10px; clear:both;">
      <tr>
        <td class="arial11Negro" ><strong><em>Publicado hace <? echo $anuncio->tiempoHace(); ?></em></strong></td>
      </tr>
      <tr>
        <td class="arial11Negro"><strong><em><? echo $anuncio->visitas() ?> visitas recibidas</em></strong></td>
      </tr>
    </table>
    
    
    <table width="95%" border="0" cellspacing="0" cellpadding="0" align="right" style="clear:both;">
  <tr>
    <td><div style="margin:0 auto 0 auto; width:100%; border-bottom:#D2D2D2 dashed 2px; margin-bottom:5px; margin-top:15px;"></div></td>
  </tr>
</table>
    
    <table width="250" border="0" cellspacing="0" cellpadding="0" align="left" style="clear:both; margin-left:25px;">
      <tr>
        <td align="left" width="35"><a href="contactarAnunciante.php?id_anuncio=<? echo $id_anuncio ?>" rel="facebox"><img src="../img/Email-icon.png" width="32" height="32" border="0"></a></td>
        <td align="left" width="215" style="padding-left:10px;"><a href="contactarAnunciante.php?id_anuncio=<? echo $id_anuncio ?>" rel="facebox" class="LinkFuncionalidad13">Contactar al anunciante</a></td>
        </tr>
      <tr>
        <td  align="left"><a href="recomendarAmigo.php?id_anuncio=<? echo $id_anuncio ?>" rel="facebox"><img src="../img/email-to-friend-icon.png" width="32" height="32" border="0"></a></td>
        <td  align="left" style="padding-left:10px;"><a href="recomendarAmigo.php?id_anuncio=<? echo $id_anuncio ?>" class="LinkFuncionalidad13" id="recomendar2" rel="facebox">Recomendar a un amigo</a></td>
        </tr>
      <tr>
        <td align="left"><a href="denunciar.php?id_anuncio=<? echo $id_anuncio ?>" rel="facebox"><img src="../img/Sign-Alert-icon.png" width="32" height="32" border="0"></a></td>
        <td align="left" style="padding-left:10px;"><a href="denunciar.php?id_anuncio=<? echo $id_anuncio ?>" rel="facebox" class="LinkFuncionalidad13" id="denunciar">Denunciar este anuncio</a></td>
      </tr>
    </table>
    
    </td>
  </tr>
    </table>
    <table width="700" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#F4F9E8">
      <tr>
        <td><div style="overflow:scroll; width:695px; overflow-y:hidden;"><?  
		
		$descripcion=$anuncio->descripcion;
		$descripcion=str_replace("<script>","",$descripcion);
		$descripcion=str_replace("<style>","",$descripcion);
		$descripcion=str_replace("<iframe>","",$descripcion);
		$descripcion=str_replace("<?","",$descripcion);
		$descripcion=str_replace("<?php","",$descripcion);
		
		echo $descripcion;
		
		
		 ?></div></td>
      </tr>
    </table>
   
<table width="700" border="0" align="center" cellpadding="0" cellspacing="0" bordercolor="#F4F9E8">
      <tr>
        <td valign="top"><div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#xfbml=1"></script><fb:comments href="<? echo $url_completa ?>" num_posts="5" width="700"></fb:comments></td>
    </tr>
    </table> 

      
      </td>
      <td width="300" valign="top">
      
      <div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; width:300px; margin-left:20px; margin-top:60px;"><strong><span class="arial15Negro">Conversaciones mas activas</span></strong></div>
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
					
					
					echo '<table width="305" height="70" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#C8C8C8 1px solid; background-color:'.$colorete.'; ">
						  <tr>
							<td width="50" align="center">
							<a href="../'.$conver->armarEnlace().'" target="_blank">
								
								<img src="https://graph.facebook.com/'.$usuario->fb_nick.'/picture" border=0 alt="'.$conver->titulo.'" title="'.$conver->titulo.'" width="30" heigth="30" /> 
							</a>
							</td>
							<td width="255" style="padding-bottom:5px; padding-top:5px;">
							
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
        <table width="305" border="0" cellspacing="0" cellpadding="0" style="background-color:#F2F7E6; border-bottom:#C8C8C8 1px solid;">
	<tr>
		<td align="center" style="padding-bottom:10px; padding-top:10px; "><a href="../conversaciones/publicar.php" class="LinkFuncionalidad17" target="_blank">
        <strong><< Iniciar Conversación >></strong></a></td>
	</tr>
	</table>
      </div>
      
      </td>
    </tr>
  </table>

</form>


 <script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>

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
