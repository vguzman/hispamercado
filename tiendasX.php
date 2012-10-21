<?	
	include "lib/class.php";
	$sesion=checkSession();
	
	
	
	//PRIMERO SACO LOS USUARIOS DE LAS TIENDAS ACTIVAS
	$query=operacionSQL("SELECT id_usuario FROM Tienda WHERE status=1");
	$user_sql="(";
	for ($i=0;$i<mysql_num_rows($query);$i++)
		$user_sql.="id_usuario=".mysql_result($query,$i,0)." OR ";
	$user_sql.="id_usuario=0)";
	
	
	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<base href="http://www.hispamercado.com.ve/" />

<meta name="description" content="Avisos clasificados gratuitos en toda Venezuela, avanzadas herramientas de publicación y búsqueda. Inmuebles: Apartamentos, Casas, Oficinas, Locales comerciales. Vehículos: Carros, Camionetas, Motos, Repuestos. Celulares, Video juegos, Ropa, Negocios, Servicios, Mascotas y mucho mas">
<meta name="keywords" content="clasificados, anuncios, avisos, gratis, tiendas, comercio, venta, compra, alquiler, vehiculos, carros, inmuebles, electronicos, videojuegos, computacion">



<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">
<link href="lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<script src="lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="lib/facebox/src/facebox.js" type="text/javascript"></script>
<script src="lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="lib/facebox/src/facebox.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>


<SCRIPT LANGUAGE="JavaScript" >

	jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'lib/facebox/src/loading.gif',
        closeImage   : 'lib/facebox/src/closelabel.png'
      })
    })
	

</SCRIPT>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Hispamercado - Tiendas</title>
</head>

<body>
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
          <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
          <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="cuenta/index.php?d=<? echo time() ?>" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
        </tr>
      </table>
    </div>
      <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
        <div style="width:160px; height:26px; float:right; background-image:url(img/fondo_fb.png); background-repeat:repeat;" align="left">
          <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email,publish_stream&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede con Facebook</a></div>
        </div>
        <div style="width:26px; height:26px; float:right; background-image:url(img/icon_facebook.png); background-repeat:no-repeat;"></div>
      </div></td>
  </tr>
</table>
<div style="margin-top:50px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;"><a href="gestionAnuncio.php" class="LinkFuncionalidad17">Gestionar mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="conversaciones/" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="tiendas/" class="LinkFuncionalidad17">Tiendas</a></td>
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
          <input type="button" name="button" id="button" value="Buscar" onclick="buscar('../')" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;" />
        </label>
      </div></td>
    </tr>
  </table>
</div>
<div align="center" style="margin-top:50px;">
  <table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
    <tr>
      <td width="347" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio</b></a> &raquo;
        <a href="tiendas/" class="LinkFuncionalidad15"><b>Tiendas</b></a></td>
      <td width="653" align="right" valign="bottom">&nbsp;</td>
    </tr>
  </table>
</div>
<div style="margin-top:30px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="300" valign="top">
	
	<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; width:273px; border:#999 1px solid; border-bottom:0px;"><strong><span class="arial15Negro">Categor&iacute;as</span></strong></div>
	
    
    <div style="border:#999 1px solid; width:258px; border-top:0px; padding:10px; background-color:#F4F9E8;">
	<?
			$padres=array();
			
			$query=operacionSQL("SELECT id FROM Categoria WHERE id_categoria IS NULL");
			for ($i=0;$i<mysql_num_rows($query);$i++)
				$padres[mysql_result($query,$i,0)]=0;			
			
			
			$aux="SELECT id_categoria FROM Anuncio WHERE status_general='Activo' AND ".$user_sql;
			//echo "<br><br>";
			$query=operacionSQL($aux);
			for ($i=0;$i<mysql_num_rows($query);$i++)
			{
				$cate=new Categoria(mysql_result($query,$i,0));
				$padres[$cate->patriarca()]=$padres[$cate->patriarca()]+1;
			}
			
			arsort($padres);
			foreach($padres as $indice => $valor) 
			{
				$cate=new Categoria($indice);
				if ($valor>0)
					if (isset($_GET['cat']))
						if ($_GET['cat']==$cate->id)
							echo "<div style='padding-bottom:5px; padding-top:5px;' class='arial13Negro'><strong>".$cate->nombre." (".$valor.")</strong></div>";
						else
							echo "<div style='padding-bottom:5px; padding-top:5px;'><a href='tiendas/".$cate->id."/' class='LinkFuncionalidad13'><strong>".$cate->nombre." (".$valor.")</strong></a></div>";
					else
						echo "<div style='padding-bottom:5px; padding-top:5px;'><a href='tiendas/".$cate->id."/' class='LinkFuncionalidad13'><strong>".$cate->nombre." (".$valor.")</strong></a></div>";
			
			
				
				$hijos=$cate->hijosInmediatos();
				
				for ($i=0;$i<count($hijos);$i++)
				{
					$subcate=new Categoria($hijos[$i]);
					if ($subcate->esHoja()==true)
					{
						$query=operacionSQL("SELECT count(*) FROM Anuncio WHERE status_general='Activo' AND id_categoria=".$subcate->id." AND ".$user_sql);
						$suma=mysql_result($query,0,0);
						
						
					
					
					}
					else
					{
						$subhijos=$subcate->hijosInmediatos();
						$suma=0;
						for ($e=0;$e<count($subhijos);$e++)
						{
							$query=operacionSQL("SELECT count(*) FROM Anuncio WHERE status_general='Activo' AND id_categoria=".$subhijos[$e]." AND ".$user_sql);
							$suma=$suma+mysql_result($query,0,0);
						}
					}
					
					
					if ($suma>0)
						if (isset($_GET['cat']))
							if ($_GET['cat']==$subcate->id)
								echo '<div style="padding-left:10px; padding-bottom:5px; padding-top:5px;">&raquo; <span class="arial13Negro">'.$subcate->nombre.' ('.$suma.')</span></div>';
							else			
								echo '<div style="padding-left:10px; padding-bottom:5px; padding-top:5px;">&raquo; <a href="tiendas/'.$subcate->id.'/" class="LinkFuncionalidad13">'.$subcate->nombre.' ('.$suma.')</a></div>';
							else
								echo '<div style="padding-left:10px; padding-bottom:5px; padding-top:5px;">&raquo; <a href="tiendas/'.$subcate->id.'/" class="LinkFuncionalidad13">'.$subcate->nombre.' ('.$suma.')</a></div>';
					
					
					
				}
				
				
			}

			
	
	?>
    </div>
    </td>
    <td width="700" valign="top">
    
    	<?
		
				if (isset($_GET['cat']))
				{
					$cate_anuncio=new Categoria($_GET['cat']);
					$hijos=$cate_anuncio->hijos();
					
					$concat="";
					for ($i=0;$i<count($hijos);$i++)
						$concat.="id_categoria=".$hijos[$i]." OR ";
					
					$concat="(".$concat;
					$concat.="id_categoria=-1515)";
					
					
					$aux="SELECT DISTINCT(id_usuario) FROM Anuncio WHERE status_general='Activo' AND ".$concat." AND ".$user_sql;
					$query=operacionSQL($aux);
					
				}
				else
				{
					$aux="SELECT DISTINCT(id_usuario) FROM Anuncio WHERE status_general='Activo' AND ".$user_sql;
					$query=operacionSQL($aux);				
				}
				
				
				for ($i=0;$i<mysql_num_rows($query);$i++)
				{
					if (($i%2)==0)
						$colorete="#F2F7E6";			
					else
						$colorete="#FFFFFF";
						
					
					$query2=operacionSQL("SELECT id FROM Tienda WHERE id_usuario=".mysql_result($query,$i,0));
					$tienda=new Tienda(mysql_result($query2,0,0));
					
					
					echo '
				<div style="margin-bottom:20px;">
					<div class="arial15Negro" style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:15px; padding-right:15px; border:#999 1px solid; border-bottom:0px;">
							<strong>'.$tienda->nombre.'</strong>
							
							<a class="LinkFuncionalidad13" href="'.$tienda->nick.'/" style="float:right;"><strong>Ir a tienda</strong></a>
						</div>
					
					<div style="border:#999 1px solid; border-top:0px; padding:10px;" class="arial13Negro">
						<table width="650" border="0" cellspacing="0" cellpadding="0" align="center">
						  <tr>
							<td width="50"><a href="'.$tienda->nick.'/"><img src="img/img_bank/tiendaLogo/'.$tienda->id.'_muestra" border="0" /></a></td>
							<td width="650" style="padding-left:10px;">'.$tienda->descripcion.'</td>
						  </tr>
						</table>       
					</div>
				</div>	
					';
						
					
				
				}
			
		
		?>
        
        
            
            
            </td>
          </tr>
        </table>
    
    </td>
  </tr>
</table>

</div>


<div style="margin:0 auto 0 auto; width:1000px;; margin-top:80px; padding-top:5px;" >

 <table width="230" border="0" cellspacing="0" cellpadding="0" style="float:left; margin-left:470px;">
                    <tr>
                      <td  height="25" class="arial11Negro" ><strong>Danos tu opini&oacute;n sobre Hispamercado</strong></td>
                    </tr>
                  </table>

<table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                    <tr>
                      <td width="30"><img src="img/social-facebook-box-blue-icon.png" alt="" width="25" height="25" /></td>
                      <td width="70"><strong><a class="LinkFuncionalidad" href="http://www.facebook.com/Hispamercado" target="_blank">Facebook</a></strong></td>
                    </tr>
                  </table>
                  
                  <table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;" >
                     <tr>
                       <td width="30"><img src="img/social-twitter-box-blue-icon.png" width="25" height="25" /></td>
                       <td width="70"><strong><a class="LinkFuncionalidad" href="http://twitter.com/hispamercado" target="_blank">Twitter</a></strong></td>
                     </tr>
                   </table>
                   
                   <table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                     <tr>
                       <td width="30"><img src="img/Email-icon.png" width="25" height="25"></td>
                       <td width="70"><strong><a class="LinkFuncionalidad" href="mailto:info@hispamercado.com.ve">E-mail</a></strong></td>
                     </tr>
                   </table>
	
</div>
<div style="margin:0 auto 0 auto; width:1000px; padding-left:40px; padding-right:40px; padding-top:10px; border-top:1px solid #77773C; clear:both; text-align:justify;"class="arial11Gris">
 <strong>En Hispamercado creemos que la compra y venta de productos y servicios es una experiencia social. Cuando queremos comprar o vender un producto solemos pedir la opini&oacute;n de amigos o familiares que pueden tener mas conocimientos sobre el tema. Con Hispamercado queremos llevar esa experiencia a Internet, no pretendemos ser un simple portal de clasificados en l&iacute;nea, queremos construir una comunidad de usuarios que interactuen alrededor de los anuncios. Anunciate en Hispamercado y comparte tus opiniones y dudas con la comunidad.</strong>
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