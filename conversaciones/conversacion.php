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
<base href="http://www.hispamercado.com.ve/conversaciones/" />

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<meta name="description" content="Publicar aviso clasificado gratis en cualquier ciudad de venezuela con fotos y videos. Publique su anuncio en solo 1 minuto">

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<script language="javascript" type="text/javascript" src="../lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/conversaciones.js"> </script>





<script language="javascript" type="text/javascript">

	


</script>







        

<title><? echo $conver->titulo ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<body>

<div id="fb-root"></div>




<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="730" align="left" valign="top" ><div style="width:100%;"> <a href="http://www.hispamercado.com.ve/"><img src="../img/logo_original.jpg" alt="" width="360" height="58" border="0"></a> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span> </div></td>
    <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
      <?
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	
	
	 ?>
      <table width="270" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
          <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="closeSession.php" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="../closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
        </tr>
      </table>
    </div>
      <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
        <div style="width:160px; height:26px; float:right; background-image:url(../img/fondo_fb.png); background-repeat:repeat;" align="left">
          <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede con Facebook</a></div>
        </div>
        <div style="width:26px; height:26px; float:right; background-image:url(../img/icon_facebook.png); background-repeat:no-repeat;"></div>
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
      <td width="320"><input type="button" name="button2" id="button2" value="Publicar Anuncio" onClick="document.location.href=''" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;">
        <input type="button" name="button2" id="button2" value="Iniciar conversaci&oacute;n" onClick="listarRecientes()" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;"></td>
      <td width="680"><div style="margin:0 auto 0 auto; width:100%; background-color:#D8E8AE; padding-top:3px; padding-bottom:3px; padding-left:5px;">
        <input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event)" id="buscar" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado">
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
          <input type="button" name="button" id="button" value="Buscar" onClick="listarRecientes()" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;">
        </label>
      </div></td>
    </tr>
  </table>
</div>
<div style="visibility:hidden; display:none;">
<img src="../img/bigrotation2.gif" width="32" height="32" ></div>
<div align="center" style="margin-top:50px;">
<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
      <tr>
        <td width="973" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio </b></a>&raquo; <a href="/" class="LinkFuncionalidad15"><b>Conversaciones</b></a><? $arbol=$cate->arbolDeHoja();
		
			for ($i=count($arbol)-1;$i>=0;$i--)
			{
				echo ' &raquo; <a href="" class="LinkFuncionalidad15"><b>'.$arbol[$i]['nombre'].'</b></a>';
				
				//echo $arbol[$i]['nombre']." - ";
			}
		
		
		
		 ?></td>
        <td width="27" align="right" valign="bottom">&nbsp;</td>
      </tr>
    </table>
</div>

<div style="width:1000px; margin:40px auto 0 auto">

<div style="width:700px; float:left; background-color:#F4F9E8; border-style:solid; border-color:#999; border-width:1px; margin-bottom:0px;">
	<div id="contenedor_conversacion" style="padding:20px;">  
      <table width="670" border="0" cellspacing="0" cellpadding="0">
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

<div class="fb-comments" data-href="http://www.hispamercado.com.ve/<? echo $conver->armarEnlace() ?>" notify="true" data-num-posts="100000" data-width="700" style="margin-top:15px;"></div>



</div>





<div style="width:270px; float:left; margin-left:25px;">


<div style="background-color:#D8E8AE; padding-top:5px; padding-bottom:5px; padding-left:5px; width:270px; border:#999 1px solid; border-bottom:0px;"><strong><span class="arial15Negro">Anuncios relacionados</span></strong></div>
<div id="comentario_dejado"></div>


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