<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	
	
	if (isset($_GET['id_cat'])==false)
	{
		$conversaciones=array();
		
		$query=operacionSQL("SELECT id_conversacion,COUNT(*) AS C FROM ConversacionComentario A, Conversacion B WHERE B.status=1 AND A.id_conversacion=B.id GROUP BY id_conversacion ORDER BY C DESC");
		
		for ($i=0;$i<mysql_num_rows($query);$i++)
			$conversaciones[$i]=mysql_result($query,$i,0);
			
		$query=operacionSQL("SELECT id FROM Conversacion WHERE status=1 AND id NOT IN (SELECT id_conversacion FROM ConversacionComentario)");
		$z=count($conversaciones);
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$conversaciones[$z]=mysql_result($query,$i,0);
			$z++;
		}
	}
	else
	{
		$cate=new Categoria($_GET['id_cat']);
		$hijos=$cate->hijos();
		
		$conversaciones=array();
		
		$aux="SELECT id_conversacion,COUNT(*) AS C FROM ConversacionComentario A, Conversacion B WHERE B.status=1 AND bloque AND A.id_conversacion=B.id GROUP BY id_conversacion ORDER BY C DESC";
		
		$bloque="(";
		for ($i=0;$i<count($hijos);$i++)
		{
			if ((count($hijos)-1)==$i)
				$bloque.="id_categoria=".$hijos[$i].") ";
			else
				$bloque.="id_categoria=".$hijos[$i]." OR ";
		}
		
		$aux=str_replace("bloque",$bloque,$aux);
		
			
		$query=operacionSQL($aux);
		
		for ($i=0;$i<mysql_num_rows($query);$i++)
			$conversaciones[$i]=mysql_result($query,$i,0);
			
		$query=operacionSQL("SELECT id FROM Conversacion WHERE status=1 AND ".$bloque." AND id NOT IN (SELECT id_conversacion FROM ConversacionComentario)");
		$z=count($conversaciones);
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$conversaciones[$z]=mysql_result($query,$i,0);
			$z++;
		}
	}
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>


<meta name="description" content="Avisos clasificados gratuitos en toda Venezuela, avanzadas herramientas de publicación y búsqueda. Inmuebles: Apartamentos, Casas, Oficinas, Locales comerciales. Vehículos: Carros, Camionetas, Motos, Repuestos. Celulares, Video juegos, Ropa, Negocios, Servicios, Mascotas y mucho mas">
<meta name="keywords" content="clasificados, anuncios, avisos, gratis, tiendas, comercio, venta, compra, alquiler, vehiculos, carros, inmuebles, electronicos, videojuegos, computacion">



<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">
<link href="../lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />
<script src="../lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="../lib/facebox/src/facebox.js" type="text/javascript"></script>

<script src="../lib/js/basicos.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript">

jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../lib/facebox/src/loading.gif',
        closeImage   : '../lib/facebox/src/closelabel.png'
      })
    })
	

</SCRIPT>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Conversaciones - Preguntale o comparte tus ideas con la comunidad Hispamercado</title>
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
       <td width="730" align="left" valign="top" ><div style="width:100%;"> <a href="..//"><img src="../img/logo_original.jpg" alt="" width="360" height="58" border="0" /></a> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span></div></td>
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
               &nbsp;&nbsp;&nbsp;</strong><a href="../cuenta/index.php?d=<? echo time() ?>&amp;path=../" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="../closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
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
           <div style="width:210px; height:26px; float:right; background-image:url(../img/fondo_fb.png); background-repeat:repeat;" align="left">
             <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email,publish_stream&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede/Reg&iacute;strate con Facebook</a></div>
           </div>
           <div style="width:26px; height:26px; float:right; background-image:url(../img/icon_facebook.png); background-repeat:no-repeat;"></div>
         </div></td>
     </tr>
   </table>
   <div style="margin-top:50px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;"><a href="../gestionAnuncio.php" class="LinkFuncionalidad17">Mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="../conversaciones/" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="../tiendas/" class="LinkFuncionalidad17">Tiendas</a>&nbsp;&nbsp;|&nbsp;&nbsp;<strong><a href="../programa-de-puntos.php" class="LinkNaranja15">Programa de puntos</a></strong></td>
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

</div>


<div id="content">


<div align="center" style="margin-top:50px;">
  <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
    <tr>
      <td width="713" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio</b></a> &raquo;
        <a href="index.php" class="LinkFuncionalidad15"><b>Conversaciones &raquo;
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
					
					echo "<a class='LinkFuncionalidad15' href='index.php?id_cat=".$cat->id."'>".$arbol[$i]['nombre']."</a>";
					if ($i>0)
						echo " &raquo; ";
				}
			}	
	  ?>
        </b></a></td>
      <td width="287" align="right" valign="bottom">&nbsp;</td>
    </tr>
  </table>
</div>

<div style="margin-top:40px;">
  

  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="330" valign="top"><?
	
	if (isset($_GET['id_cat'])==false)
	{
		echo '<div style="margin-bottom:30px;">
			<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Categorías</strong></div>
			<div style="border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
		
		$query=operacionSQL("SELECT id FROM Categoria WHERE id_categoria IS NULL ORDER BY orden ASC");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$cate=new Categoria(mysql_result($query,$i,0));
			
			$hijos=$cate->hijos();
				
			$aux="SELECT COUNT(*) FROM Conversacion WHERE status=1 AND (";
			for ($e=0;$e<count($hijos);$e++)
				if ((count($hijos)-1)==$e)
					$aux.="id_categoria=".$hijos[$e].") ";
				else
					$aux.="id_categoria=".$hijos[$e]." OR ";
			
			$query2=operacionSQL($aux);
			if (mysql_result($query2,0,0)!="0")
				echo '<div style="margin-bottom:5px;">&raquo; <a href="index.php?id_cat='.$cate->id.'" class="LinkFuncionalidad12">'.$cate->nombre.' ('.mysql_result($query2,0,0).')</a></div>';
			
		}
		
		echo '</div></div>';
		
		
		
	}
	else
	{
		$cate1=new Categoria($_GET['id_cat']);
		
		if ($cate1->esPadre()==false)	
			$url="index.php?id_cat=".$cate1->padre();
		else
			$url="index.php";
		
		
		echo '<div style="margin-bottom:20px;" class="arial12Gris">
				<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid;" class="arial15Negro"><strong></strong>';
				
		echo "<strong>Categoría: ".$cate1->nombre." <a href='".$url."'><img src='../img/delete-icon.png' width='15' height='15' alt='Eliminar filtro' border='0'></a></strong></div></div>";
				
		
		
		
		if ($cate1->esHoja()==false)
		{
			echo '<div style="margin-bottom:30px;">
			<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;" class="arial15Negro"><strong>Categorías</strong></div>
			<div style="border:#999 1px solid; border-top:0px; padding:10px; background-color:#F4F9E8;">';
			
			$inmediatos=$cate1->hijosInmediatos();
			
			
			for ($i=0;$i<count($inmediatos);$i++)
			{
				
				$cate=new Categoria($inmediatos[$i]);			
				$hijos=$cate->hijos();
					
				$aux="SELECT COUNT(*) FROM Conversacion WHERE status=1 AND (";
				for ($e=0;$e<count($hijos);$e++)
					if ((count($hijos)-1)==$e)
						$aux.="id_categoria=".$hijos[$e].") ";
					else
						$aux.="id_categoria=".$hijos[$e]." OR ";
				
				$query2=operacionSQL($aux);
				if (mysql_result($query2,0,0)!="0")
					echo '<div style="margin-bottom:5px;">&raquo; <a href="index.php?id_cat='.$cate->id.'" class="LinkFuncionalidad12">'.$cate->nombre.' ('.mysql_result($query2,0,0).')</a></div>';
			}
				
				
			echo '</div></div>';
		}
		
		
	}



?>
    
    
    <div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px; margin-top:30px;"><strong><span class="arial15Negro">Anuncios relacionados mas activos</span></strong></div>
    
    <div style="border-left:#999 1px solid; border-right:#999 1px solid;">
        
        <?
			
			if (isset($_GET['id_cat'])==false)			
				$query=operacionSQL("SELECT id_anuncio,COUNT(*) AS C FROM AnuncioVisita A, Anuncio B WHERE A.id_anuncio=B.id AND (B.id_categoria<>3820 AND B.id_categoria<>164 AND B.id_categoria<>165) AND B.status_general='Activo' GROUP BY id_anuncio ORDER BY C DESC LIMIT 5");
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
				
				$query=operacionSQL("SELECT id_anuncio,COUNT(*) AS C FROM AnuncioVisita A, Anuncio B WHERE A.id_anuncio=B.id AND ".$bloque." AND (B.id_categoria<>3820 AND B.id_categoria<>164 AND B.id_categoria<>165) GROUP BY id_anuncio ORDER BY C DESC LIMIT 5");
				
			}
			
			
			
			for ($i=0;$i<mysql_num_rows($query);$i++)
			{
				$anuncio=new Anuncio(mysql_result($query,$i,0));
				
				if (($i%2)==0)
					$colorete="#F2F7E6";
				else
					$colorete="#FFFFFF";		
				
				echo '<table width="380" height="70" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#999 1px solid; background-color:'.$colorete.';">
					  <tr>
						<td width="80" align="center">
						<a href="../'.$anuncio->armarEnlace().'" target="_blank">
							<img src="../lib/img.php?tipo=mini&anuncio='.$anuncio->id.'&foto=1" border=0 alt="'.$anuncio->titulo.'" title="'.$anuncio->titulo.'"> </img>
						</a>
						</td>
						<td width="300" style="padding-bottom:5px; padding-top:5px;">
						
						<div>
							<a href="../'.$anuncio->armarEnlace().'" class="tituloAnuncioChico" target="_blank">'.ucwords(strtolower(substr($anuncio->titulo,0,150))).'</a>
						</div>
						
						<div class=" arial11Negro" align="right" style="padding-right:5px; margin-top:10px;">
							<em>'.mysql_result($query,$i,1).' visitas</em>
						</div>
						
						</td>
					  </tr>
					</table>';		
				
			}
        
		
		?>
        <table width="380" border="0" cellspacing="0" cellpadding="0" style="background-color:#F2F7E6; border-bottom:#999 1px solid;">
					  <tr>
						<td align="center" style="padding-bottom:10px; padding-top:10px; "><a href="../publicar/" class="LinkFuncionalidad17" target="_blank">
                        <strong><< Publicar Anuncio >></strong></a></td>
					  </tr>
					 </table>
       </div>
       
       
    </td>
    <td width="670" valign="top">
    
    
    <?
		for ($i=0;$i<count($conversaciones);$i++)
		{
			$conver=new Conversacion($conversaciones[$i]);
			$usuario=new Usuario($conver->id_usuario);
			
			 if (($i%2)==0)
				$colorete="#F2F7E6";
			else
				$colorete="#FFFFFF";
			
			
			echo '<table width="600" border="0" cellspacing="0" cellpadding="0" align="right" style="border-bottom:#C8C8C8 1px solid; background-color:'.$colorete.'">
					  <tr>
						<td height="100" width="70" align="center"><img src="https://graph.facebook.com/'.$usuario->fb_nick.'/picture" /></td>
						<td width="530">
						
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td valign="top" height="60" style="padding-top:5px;"><a href="../'.$conver->armarEnlace().'" class="tituloAnuncio">'.$conver->titulo.'</a><br>
								<span class="arial13Negro"><em>'.$conver->comentariosRecibidos().' comentarios recibidos</em></span>
								</td>
							  </tr>
							  <tr>
								<td valign="bottom" height="40" class="arial15Negro" style="padding-bottom:5px;"><em>Publicado por '.$usuario->nombre.' hace '.$conver->tiempoHace().'</em></td>
							  </tr>
							</table>
						</td>
					  </tr>
					</table>';
		}
	
	
	?>
   

    
    
    </td>
          </tr>
        </table>
    
    </td>
  </tr>
</table>

</div>


</div>

    	<div id="footer" style=" margin-top:80px;">
        <? echo footer() ?> 
	</div>
</div>


</body>
</html>

<script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>
