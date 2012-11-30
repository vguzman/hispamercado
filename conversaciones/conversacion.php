<?	
	include "../lib/class.php";
	$sesion=checkSession();	
	
		
	if ($sesion!=false)
		$usuario=new Usuario($sesion);
		
	$id_con=$_GET['id_con'];
	$query=operacionSQL("SELECT id FROM Conversacion WHERE id=".$id_con);
	if (mysql_num_rows($query)==0)
	{
		echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='../index.php';			
			</SCRIPT>";
		exit;
	}
	
	
	
	$url=$_SERVER['REQUEST_URI'];
	if (substr_count($url,"?id_con=")>0)
	{
		$aux=explode("id_con=",$url);
		
		$conversacion=new Conversacion($aux[1]);
		echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='http://www.hispamercado.com.ve/".$conversacion->armarEnlace()."';			
			</SCRIPT>";
			
		exit;
		
	}
	
	
	
	$conver=new Conversacion($id_con);
	$cate=new Categoria($conver->id_categoria);
	$user_conver=new Usuario($conver->id_usuario);
		
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<base href="http://www.hispamercado.com.ve/conversaciones/" />
<meta name="description" content="<? echo $conver->textoDescripcion() ?>">


<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">
<link href="../lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />


<script src="../lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="../lib/facebox/src/facebox.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="../lib/js/conversaciones.js"> </script>
<script src="../lib/js/basicos.js" type="text/javascript"></script>
<script src="../lib/js/ajax.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript">

function bloquearUsuario(codigo)
{
	var dec=window.confirm("¿Segudo de bloquear este usuario?");
	if (dec==true)
	{
		var dec=window.confirm("¿Segudo de bloquear este usuario?");
			if (dec==true)
				document.location.href='http://www.hispamercado.com.ve/conversaciones/adminGestion.php?codigo='+codigo+'&accion=bloquear';
	}		
}



jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../lib/facebox/src/loading.gif',
        closeImage   : '../lib/facebox/src/closelabel.png'
      })
    })
	

</SCRIPT>



<title><? echo $conver->titulo ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<body>


<div id="wrapper">
 <div id="header">

<div id="fb-root"></div>
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
          <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
          <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="../cuenta/index.php?d=<? echo time() ?>&amp;path=../" rel="facebox" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="../closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
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

</div>


<div id="content">


<div style="visibility:hidden; display:none;">
<img src="../img/bigrotation2.gif" width="32" height="32" ></div>
<div align="center" style="margin-top:50px;">
<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
      <tr>
        <td width="973" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio </b></a>&raquo; <a href="index.php" class="LinkFuncionalidad15"><b>Conversaciones</b></a><? $arbol=$cate->arbolDeHoja();
		
			for ($i=count($arbol)-1;$i>=0;$i--)
			{
				echo ' &raquo; <a href="index.php?id_cat='.$arbol[$i]['id'].'" class="LinkFuncionalidad15"><b>'.$arbol[$i]['nombre'].'</b></a>';
				
				//echo $arbol[$i]['nombre']." - ";
			}
		
		
		
		 ?></td>
        <td width="27" align="right" valign="bottom">&nbsp;</td>
      </tr>
  </table>
</div>


<div style="margin:0 auto 0 auto; width:800px; margin-top:30px; margin-bottom:30px; <? if (isset($_SESSION['nick_gestion'])) echo ""; else echo "display:none;"; ?> ">
    <p><strong>Super gestion: <? echo "<em>".$conver->status."</em>" ?></strong></p>
    <p>
    
    	<a href="adminGestion.php?codigo=<? echo $conver->id ?>&accion=inactivar" class="LinkFuncionalidad13">Inactivar conversación</a><br>
        <a href="adminGestion.php?codigo=<? echo $conver->id ?>&accion=editar" class="LinkFuncionalidad13">Editar conversación</a><br>
        <a href="javascript:bloquearUsuario(<? echo $conver->id ?>)" class="LinkFuncionalidad13">Bloquear usuario</a>
    
    </p>
  </div>


<div style="width:1000px; margin:60px auto 0 auto">

<div>

		 <div style="float:left; margin-right:15px;"><div class="g-plusone" data-size="medium" data-annotation="none"></div></div> 
         

	 <div style="float:left; ">
            <script src="http://connect.facebook.net/es_ES/all.js#appId=119426148153054&amp;xfbml=1"></script><fb:like href="http://<? echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>" send="false" layout="button_count" width="110" show_faces="true" font="arial"></fb:like>
            </div>
            
            
            <div class="fb-send" style="margin-left:15px; margin-right:15px; float:left;" data-href="http://<? echo $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']  ?>"></div>
            
           
            
            <div style="float:left;"><a href="https://twitter.com/share" class="twitter-share-button" data-via="hispamercado" data-lang="es">Twittear</a>
        <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script></div>

</div>

<div style="clear:both; display:table;">
<div style="width:650px; float:left; background-color:#F4F9E8; border-style:solid; border-color:#999; border-width:1px; ">
	<div id="contenedor_conversacion" style="padding:20px;">  
      <table width="620" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="130" align="center" valign="top">
          
          <div><img src='https://graph.facebook.com/<? echo $user_conver->fb_nick ?>/picture' /></div>
          <div class="arial13Negro" style="margin-top:5px;"><strong><? echo $user_conver->nombre ?></strong></div>
            
          </td>
          <td width="540" valign="top">
          
                <div align="center" class="arial17Negro"><strong><? echo $conver->titulo ?></strong></div>
                
                <div class="arial11Gris" align="right" style="padding-right:15px; margin-top:10px;"><em>Publicado hace <? echo $conver->tiempoHace() ?></em></div>
                
                <div class="arial13Negro" style="margin-top:20px; padding-left:15px;"><? echo $conver->descripcion ?></div>
          
          </td>
        </tr>
      </table>
	</div>

<div class="fb-comments" data-href="http://www.hispamercado.com.ve/<? echo $conver->armarEnlace() ?>" notify="true" data-num-posts="100000" data-width="650" style="margin-top:15px;"></div>



</div>





<div style="width:320px; float:left; margin-left:25px;">


<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; border:#999 1px solid; border-bottom:0px;"><strong><span class="arial15Negro">Anuncios relacionados</span></strong></div>



<div style="border-left:#999 1px solid; border-right:#999 1px solid;">
        
        <?
			$resul=buscarSphinx($conver->titulo,$conver->id_categoria,"NO","NO","NO","NO","NO","NO","NO","ANY","REL");
			$anuncios=$resul['anuncios'];
				
			if (count($resul)==0)
			{
				$cate=new Categoria($conver->id_categoria);
				$hijos=$cate->hijos();
					
				$bloque="(";
				for ($i=0;$i<count($hijos);$i++)
				{
					if ((count($hijos)-1)==$i)
						$bloque.="id_categoria=".$hijos[$i].") ";
					else
						$bloque.="id_categoria=".$hijos[$i]." OR ";
				}
					
				$query=operacionSQL("SELECT id_anuncio,COUNT(*) AS C FROM AnuncioVisita A, Anuncio B WHERE A.id_anuncio=B.id AND ".$bloque." AND (B.id_categoria<>3820 AND B.id_categoria<>164 AND B.id_categoria<>165) AND B.status_general='Activo' GROUP BY id_anuncio ORDER BY C DESC LIMIT 5");
					
				$anuncios=array();
				for ($i=0;$i<mysql_num_rows($query);$i++)
					array_push($anuncios,mysql_result($query,$i,0));
				
			}
			
			if (count($anuncios)>5)
				$top=5;
			else
				$top=count($anuncios);
			for ($i=0;$i<$top;$i++)
			{
				$anuncio=new Anuncio($anuncios[$i]);
				
				if (($i%2)==0)
					$colorete="#FFFFFF";			
				else
					$colorete="#F2F7E6";
				
				
				echo '<table width="318" height="70" border="0" cellspacing="0" cellpadding="0" style="border-bottom:#999 1px solid; background-color:'.$colorete.';">
					  <tr>
						<td width="78" align="center">
						<a href="../'.$anuncio->armarEnlace().'" target="_blank">
							<img src="../lib/img.php?tipo=mini&anuncio='.$anuncio->id.'&foto=1" border=0 alt="'.$anuncio->titulo.'" title="'.$anuncio->titulo.'"> </img>
						</a>
						</td>
						<td width="240" style="padding-bottom:5px; padding-top:5px;">
						
						<div>
							<a href="../'.$anuncio->armarEnlace().'" class="tituloAnuncioChico" target="_blank">'.ucwords(strtolower(substr($anuncio->titulo,0,150))).'</a>
						</div>
						
						<div class=" arial11Negro" align="right" style="padding-right:5px; margin-top:10px;">
							<em>'.$anuncio->visitas().' visitas</em>
						</div>
						
						</td>
					  </tr>
					</table>';		
				
			}
        
		
		?>
        
        <table width="318" border="0" cellspacing="0" cellpadding="0" style="background-color:#F2F7E6; border-bottom:#999 1px solid;">
		  <tr>
			<td align="center" style="padding-bottom:10px; padding-top:10px; "><a href="../publicar/" class="LinkFuncionalidad17" target="_blank">
               <strong><< Publicar Anuncio >></strong></a></td>
			</tr>
		</table>
        
       </div>



</div>

</div>
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


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>