<?	
	include "../lib/class.php";
	$sesion=checkSession();	
	
	
	$pre_email="";
	$pre_nombre="";
	//CASOS USUARIO REGISTRADO
	if ($sesion!=false)
	{
		$usuario=new Usuario($sesion);
		
		$pre_email=$usuario->email;
		$pre_nombre=$usuario->nombre;	
	}
	else
	{
		echo "<SCRIPT LANGUAGE='JavaScript'>		
				window.alert('Debes estar logueado para iniciar una conversación');
				document.location.href='../';			
			</SCRIPT>";
		
		exit;
	}
	
	
	$pre_titulo="";
	$pre_descripcion="";
	$pre_cate="";
	$pre_notif="";
	$pre_hash="";
	
	$pre_categoria="";
	$pre_categoria_aux="";
	
	if (isset($_GET['edit']))
	{
		$query=operacionSQL("SELECT id FROM Conversacion WHERE hash='".$_GET['edit']."'");
		if (mysql_num_rows($query)==0)
		{
			echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='../';			
			</SCRIPT>";
			exit;
		}
		$id_conversacion=mysql_result($query,0,0);
		
		$conversacion=new Conversacion($id_conversacion);
		$pre_titulo=$conversacion->titulo;
		$pre_descripcion=$conversacion->descripcion;
		$pre_cate='onLoad="armarCategoria('.$conversacion->id_categoria.')"';
		
		if ($conversacion->notificaciones=="1")
			$pre_notif="checked";
			
		$pre_categoria=$conversacion->id_categoria;
		$pre_categoria_aux="SI";
		$pre_hash=$conversacion->hash;
		
	}
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<meta name="description" content="Inciar conversacion">

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">
<link href="../lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />


<script src="../lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="../lib/facebox/src/facebox.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="../lib/js/conversaciones.js"> </script>
<script src="../lib/js/basicos.js" type="text/javascript"></script>
<SCRIPT LANGUAGE="JavaScript">

jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : '../lib/facebox/src/loading.gif',
        closeImage   : '../lib/facebox/src/closelabel.png'
      })
    })
	

</SCRIPT>



        

<title>Iniciar conversacion</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body <? echo $pre_cate ?>>
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
<div style="visibility:hidden; display:none;">
<img src="../img/bigrotation2.gif" width="32" height="32" ></div>
<div align="center" style="margin-top:50px;">
<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
      <tr>
        <td width="347" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio </b></a>&raquo; <a href="" class="LinkFuncionalidad15"><b>Iniciar conversación</b></a></td>
        <td width="653" align="right" valign="bottom">&nbsp;</td>
      </tr>
    </table>
</div>

<div style=" margin-top:40px;">
<form name="Forma" method="post" action="publicar2.php">
  <div style="border:#999 1px solid; width:970px; margin:0 auto 0 auto; padding:15px; background-color:#F4F9E8;">
    
    
    
    <table width="950" border="0" align="center" cellpadding="2" cellspacing="4">
    <tr>
      <td align="left" class="arial13Negro">Categor&iacute;a <span class="arial13Rojo">*
        <input type="hidden" name="categoria" id="categoria" value="<? echo $pre_categoria ?>" />
        <strong>
        <input type="hidden" name="categoriaux" id="categoriaux" value="<? echo $pre_categoria_aux ?>" />
        </strong></span></td>
      <td align="left" id="contenido_categoria">
      
      		<div style="float:left; width:auto; display:table;" class="arial11Negro" id="div_1">
            
       		  <select name="selec_1" size="6" id="selec_1" onChange="manejoSeleCat(this)" style="float:left;">
                <?			
                $categorias=categorias_principales();			
                $total=sizeof($categorias);
                for ($i=0;$i<$total;$i++)
                    echo "<option value='".$categorias[$i]['id']."'>".$categorias[$i]['nombre']."</option>";			
            ?>
              </select>
              
              <div style="float:left; width:5px; padding-top:50px; margin-left:3px; margin-right:3px; width:auto;" class="arial13Negro">&raquo;</div>
            
            </div>
            <div style="float:left; width:auto;  display:none;" class="arial11Negro" id="div_2"></div>
            <div style="float:left; width:auto;  display:none;" class="arial11Negro" id="div_3"></div>
            <div style="float:left; width:auto;  display:none;" class="arial11Negro" id="div_4"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_5"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_6"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_7"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_8"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_9"></div></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro"> T&iacute;tulo <span class="arial13Rojo">*</span></td>
      <td align="left"><input name="titulo" type="text" id="titulo" value="<? echo $pre_titulo ?>" size="100" maxlength="150" ><br />
        <span class="arial13Gris">¡Haz una pregunta o una afirmación sobre el tema de tu inter&eacute;s!</span></td>
    </tr>
    <tr>
      <td width="154" align="left" valign="top" class="arial13Negro">Descripci&oacute;n (<em>opcional</em>)</td>
      <td width="776" align="left"><textarea name="content" cols="77" rows="5" id="content"><? echo $pre_descripcion ?></textarea><br />
	  <span class="arial13Gris">Si con el título de la conversación se entiende tu idea puedes dejar este campo vacío</span></td>
    </tr>
    </table>
    <div align="center" class="arial11Negro" style="margin-top:20px;">
    
    <input type="checkbox" name="notificaciones" id="notificaciones" value="SI" <? echo $pre_notif ?>>
    Recibir una notificaci&oacute;n por e-mail cada vez que se reciba un nuevo comentario
    
    </div>
    <div align="center" style="margin-top:10px;">
      <input type="hidden" name="hash" id="hash" value="<? echo $pre_hash ?>">
      <input type="hidden" name="tipo" id="tipo" value="<?
	  	if (isset($_GET['edit']))
			echo "edit";
		else
			echo "new";
	  
	   ?>">
      <input type="button" name="Submit" value="<?
	  	if (isset($_GET['edit']))
			echo "Editar conversaci&oacute;n";
		else
			echo "Iniciar conversaci&oacute;n";
	  
	   ?>" onClick="colocar()" style="font-size:18px; font-family:Arial, Helvetica, sans-serif;">
    </div>
  </div>
</form>
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