<?	
	include "lib/class.php";
	$sesion=checkSession();
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<title>Anuncios clasificados gratis en Venezuela - Avisos Clasificados gratuitos - Inmuebles, Carros, Negocios, Servicios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<meta name="description" content="Avisos clasificados gratuitos en toda Venezuela, avanzadas herramientas de publicación y búsqueda. Inmuebles: Apartamentos, Casas, Oficinas, Locales comerciales. Vehículos: Carros, Camionetas, Motos, Repuestos. Celulares, Video juegos, Ropa, Negocios, Servicios, Mascotas y mucho mas">


<meta name="verify-v1" content="A0OJoF0jubwVRFX6Y9ebASAdD2xkJRU80LMv03zZ9rA=" />
<meta name="verify-v1" content="ls7ijapXvkJEEwrjEulO+q86aItcn2hgeXrQI8dASls=" />
<meta name="keywords" content="clasificados, anuncios, avisos, gratis, tiendas, comercio, venta, compra, alquiler, vehiculos, carros, inmuebles, electronicos, videojuegos, computacion">

<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">
<link href="lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />


<script src="lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="lib/facebox/src/facebox.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/URLencode.js"></SCRIPT>



<SCRIPT LANGUAGE="JavaScript">

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
    <td width="730" align="left" valign="top" >
    <div style="width:100%;">
    <a href="/"><img src="img/logo_original.jpg" width="360" height="58" border="0"></a> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span>
    </div>
      
    </td>
    <td width="270" valign="top" align="right">
    
    
   
    
    <div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
	
	
	<?
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
		
	 ?> 
     
     <table width="270" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="40" align="left"><? if (isset($user)) echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
    <td width="230" align="left" ><strong><? if (isset($user)) echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="cuenta/index.php?d=<? echo time() ?>" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
  </tr>
</table>
  <table width="270" border="0" cellspacing="0" cellpadding="0">
   <tr>
    <td  align="right" class="arial11Mostaza" style=" padding-right:38px;">¡Tienes <? if (isset($user)) echo $user->puntos() ?> puntos acumulados!</td>
  </tr>
     </table>
     
     </div>
    
    <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
        <div style="width:210px; height:26px; float:right; background-image:url(img/fondo_fb.png); background-repeat:repeat;" align="left">
            <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email,publish_stream&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede/Reg&iacute;strate con Facebook</a></div>
        </div>       
        <div style="width:26px; height:26px; float:right; background-image:url(img/icon_facebook.png); background-repeat:no-repeat;"></div>
    </div>
 </td>
  	
  
  
  
  
  </tr>
</table>


<div style="margin-top:50px;">    
    
<table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;">
      <a href="gestionAnuncio.php" class="LinkFuncionalidad17">Mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="conversaciones/" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="tiendas/" class="LinkFuncionalidad17">Tiendas</a>&nbsp;&nbsp;|&nbsp;&nbsp;<strong><a href="programa-de-puntos.php" class="LinkNaranja15">Programa de puntos</a></strong></td>
  </tr>
</table>
    <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
      <tr>
        <td width="320">
        <input type="button" name="button2" id="button2" value="Publicar Anuncio" onClick="document.location.href='publicar/'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;">
        <input type="button" name="button2" id="button2" value="Iniciar conversación" onClick="document.location.href='conversaciones/publicar.php'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;">
        
        </td>
        
        
        
        <td width="680"><div style="margin:0 auto 0 auto; width:100%; background-color:#D8E8AE; padding-top:3px; padding-bottom:3px; padding-left:5px;">
       
<input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event,'')" id="buscar" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado">
      &nbsp;
      <select name="categorias" id="categorias" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
        <option selected value="todas">Todas las categor&iacute;as</option>
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
        <input type="button" name="button" id="button" value="Buscar" onClick="buscar('')" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;">
      </label>
      </div>
     </td>
      </tr>
</table>
</div>
</div>

<div id="content">

    
    <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:50px;">
  <tr>
  <td width="320" valign="top">
    	
        <? $padre=new Categoria("1"); ?>	
         <ul style="list-style:none; margin:0px; padding:0px;">
        	<li><a href="<? echo $padre->armarEnlace() ?>" class="LinkFuncionalidad17"><strong><? echo $padre->nombre ?> (<? echo $padre->anunciosActivosCache() ?>)</strong></a></li>
        	<?	
				$aux="SELECT id FROM Categoria WHERE id_categoria=".$padre->id;
				$query=operacionSQL($aux);
				//echo mysql_num_rows($query);
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$hijo=new Categoria(mysql_result($query,$i,0));
					echo '<li style="padding-left:7px; padding-top:5px;"><a href="'.$hijo->armarEnlace().'" class="LinkFuncionalidad14">'.$hijo->nombre.' ('.$hijo->anunciosActivosCache().')</a></li>';
					
				}
			?>
        </ul>
        
        
        
        
        
         <ul style="list-style:none; margin-top:25px; padding:0px;">
         	<? $padre=new Categoria("112"); ?>	
        	<li><a href="<? echo $padre->armarEnlace() ?>" class="LinkFuncionalidad17"><strong><? echo $padre->nombre ?> (<? echo $padre->anunciosActivosCache() ?>)</strong></a></li>
        	<?	
				$aux="SELECT id FROM Categoria WHERE id_categoria=".$padre->id;
				$query=operacionSQL($aux);
				//echo mysql_num_rows($query);
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$hijo=new Categoria(mysql_result($query,$i,0));
					echo '<li style="padding-left:7px; padding-top:5px;"><a href="'.$hijo->armarEnlace().'" class="LinkFuncionalidad14">'.$hijo->nombre.' ('.$hijo->anunciosActivosCache().')</a></li>';
					
				}
			?>
        </ul>
        
        
        
        	
         <ul style="list-style:none; margin-top:25px; padding:0px;">
         	<? $padre=new Categoria("3787"); ?>
        	<li><a href="<? echo $padre->armarEnlace() ?>" class="LinkFuncionalidad17"><strong><? echo $padre->nombre ?> (<? echo $padre->anunciosActivosCache() ?>)</strong></a></li>
        	<?	
				$aux="SELECT id FROM Categoria WHERE id_categoria=".$padre->id;
				$query=operacionSQL($aux);
				//echo mysql_num_rows($query);
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$hijo=new Categoria(mysql_result($query,$i,0));
					echo '<li style="padding-left:7px; padding-top:5px;"><a href="'.$hijo->armarEnlace().'" class="LinkFuncionalidad14">'.$hijo->nombre.' ('.$hijo->anunciosActivosCache().')</a></li>';
					
				}
			?>
        </ul>
        
        
        
        <ul style="list-style:none; margin-top:25px; padding:0px;">
           <? $padre=new Categoria("160"); ?>
           <li><a href="<? echo $padre->armarEnlace() ?>" class="LinkFuncionalidad17"><strong><? echo $padre->nombre ?> (<? echo $padre->anunciosActivosCache() ?>)</strong></a></li>
        	<?	
				$aux="SELECT id FROM Categoria WHERE id_categoria=".$padre->id;
				$query=operacionSQL($aux);
				//echo mysql_num_rows($query);
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$hijo=new Categoria(mysql_result($query,$i,0));
					echo '<li style="padding-left:7px; padding-top:5px;"><a href="'.$hijo->armarEnlace().'" class="LinkFuncionalidad14">'.$hijo->nombre.' ('.$hijo->anunciosActivosCache().')</a></li>';
					
				}
			?>
        </ul>
    
    
    
    
    </td>
    <td width="300" valign="top">
    
    
    	<? $padre=new Categoria("2"); ?>	
         <ul style="list-style:none; margin:0px; padding:0px;">
        	<li><a href="<? echo $padre->armarEnlace() ?>" class="LinkFuncionalidad17"><strong><? echo $padre->nombre ?> (<? echo $padre->anunciosActivosCache() ?>)</strong></a></li>
        	<?	
				$aux="SELECT id FROM Categoria WHERE id_categoria=".$padre->id;
				$query=operacionSQL($aux);
				//echo mysql_num_rows($query);
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$hijo=new Categoria(mysql_result($query,$i,0));
					echo '<li style="padding-left:7px; padding-top:5px;"><a href="'.$hijo->armarEnlace().'" class="LinkFuncionalidad14">'.$hijo->nombre.' ('.$hijo->anunciosActivosCache().')</a></li>';
					
				}
			?>
        </ul>
    

			
      <ul style="list-style:none; margin-top:25px; padding:0px;">
   	<? $padre=new Categoria("5000"); ?>
        	<li><a href="<? echo $padre->armarEnlace() ?>" class="LinkFuncionalidad17"><strong><? echo $padre->nombre ?> (<? echo $padre->anunciosActivosCache() ?>)</strong></a></li>
        	<?	
				$aux="SELECT id FROM Categoria WHERE id_categoria=".$padre->id;
				$query=operacionSQL($aux);
				//echo mysql_num_rows($query);
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$hijo=new Categoria(mysql_result($query,$i,0));
					echo '<li style="padding-left:7px; padding-top:5px;"><a href="'.$hijo->armarEnlace().'" class="LinkFuncionalidad14">'.$hijo->nombre.' ('.$hijo->anunciosActivosCache().')</a></li>';
					
				}
			?>
        </ul>


		
         <ul style="list-style:none; margin-top:25px; padding:0px;">
           <? $padre=new Categoria("127"); ?>
           <li><a href="<? echo $padre->armarEnlace() ?>" class="LinkFuncionalidad17"><strong><? echo $padre->nombre ?> (<? echo $padre->anunciosActivosCache() ?>)</strong></a></li>
        	<?	
				$aux="SELECT id FROM Categoria WHERE id_categoria=".$padre->id;
				$query=operacionSQL($aux);
				//echo mysql_num_rows($query);
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$hijo=new Categoria(mysql_result($query,$i,0));
					echo '<li style="padding-left:7px; padding-top:5px;"><a href="'.$hijo->armarEnlace().'" class="LinkFuncionalidad14">'.$hijo->nombre.' ('.$hijo->anunciosActivosCache().')</a></li>';
					
				}
			?>
        </ul>


    
    </td>
    
    
    <td width="380" valign="top">
    
    	<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px;"><strong><span class="arial15Negro">Anuncios destacados</span></strong></div>
        <div>
        
        <?
			
			$z=0;
			$destacados=array();
			
			$query=operacionSQL("SELECT id_anuncio FROM AnuncioDestacado WHERE NOW()<fecha_hasta ORDER BY visualizaciones ASC LIMIT 5");
			for ($i=0;$i<mysql_num_rows($query);$i++)
			{
				$destacados[$z]=mysql_result($query,$i,0);
				$z++;
			}
			//echo count($destacados);
			
			
			if (count($destacados)<5)
			{
				$query=operacionSQL("SELECT id_anuncio,COUNT(*) AS C FROM AnuncioVisita A, Anuncio B WHERE A.id_anuncio=B.id AND (B.id_categoria<>3820 AND B.id_categoria<>164 AND B.id_categoria<>165) AND B.status_general='Activo' GROUP BY id_anuncio ORDER BY C DESC LIMIT ".(6-$z));
				
				
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					$destacados[$z]=mysql_result($query,$i,0);
					$z++;
				}
			}
			
			for ($i=0;$i<count($destacados);$i++)
			{
				$anuncio=new Anuncio($destacados[$i]);
				
				
				
				if (($i%2)==0)
					$colorete="#F2F7E6";			
				else
					$colorete="#FFFFFF";
				
				
				echo '<table width="380" height="70" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#C8C8C8 1px solid; background-color:'.$colorete.';">
					  <tr>
						<td width="80" align="center">
						<a href="'.$anuncio->armarEnlace().'">
							<img src="lib/img.php?tipo=mini&anuncio='.$anuncio->id.'&foto=1" border=0 alt="'.$anuncio->titulo.'" title="'.$anuncio->titulo.'"> </img>
						</a>
						</td>
						<td width="300" style="padding-bottom:5px; padding-top:5px;">
						
						<div>
							<a href="'.$anuncio->armarEnlace().'" class="tituloAnuncioChico">'.ucwords(strtolower(substr($anuncio->titulo,0,150))).'</a>
						</div>
						
						<div class=" arial11Negro" align="right" style="padding-right:5px; margin-top:10px;">
							<em>'.$anuncio->visitas().' visitas</em>
						</div>
						
						</td>
					  </tr>
					</table>';	
					
					
				operacionSQL("UPDATE AnuncioDestacado SET visualizaciones=visualizaciones+1 WHERE id_anuncio=".$anuncio->id);	
				
			}
        
		
		?>
         <div align="center" style="background-color:#F2F7E6; border-bottom:#C8C8C8 1px solid; padding-bottom:10px; padding-top:10px; ">
    <a href="programa-de-puntos.php" class="LinkFuncionalidad17">
        <strong> &iquest;Quieres ver tu anuncio aqu&iacute;?</strong></a></div>
       </div>
       
       
       <div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; margin-top:50px;"><strong><span class="arial15Negro">Conversaciones mas activas</span></strong></div>
       <div>
        
        <?
			$query=operacionSQL("SELECT id FROM Conversacion WHERE status=1");
			
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
					$colorete="#F2F7E6";			
				else
					$colorete="#FFFFFF";
				
				
				echo '<table width="380" height="70" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#C8C8C8 1px solid; background-color:'.$colorete.';">
					  <tr>
						<td width="80" align="center">
						<a href="'.$conver->armarEnlace().'">
							
							<img src="https://graph.facebook.com/'.$usuario->fb_nick.'/picture" border=0 alt="'.$conver->titulo.'" title="'.$conver->titulo.'" /> 
						
						</a>
						</td>
						<td width="300" style="padding-bottom:5px; padding-top:5px;">
						
						<div>
							<a href="'.$conver->armarEnlace().'" class="tituloAnuncioChico">'.(substr($conver->titulo,0,150)).'</a>
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
        <div align="center" style="background-color:#F2F7E6; border-bottom:#C8C8C8 1px solid; padding-bottom:10px; padding-top:10px; ">
    <a href="conversaciones/publicar.php" class="LinkFuncionalidad17" >
        <strong><< Iniciar Conversación >></strong></a>
    </div>
       </div>
       
    
    </td>
  </tr>
</table>

</div>

    <div id="footer" style=" margin-top:80px;">
        <? echo footer() ?> 
	</div>
    
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