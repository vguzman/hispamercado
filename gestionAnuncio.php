<?	
	include "lib/class.php";	
	
	$sesion=checkSession();	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>





<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">
<link href="lib/facebox/src/facebox.css" media="screen" rel="stylesheet" type="text/css" />

<script src="lib/facebox/lib/jquery.js" type="text/javascript"></script>
<script src="lib/facebox/src/facebox.js" type="text/javascript"></script>
<script language="javascript" type="text/javascript" src="lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript">

	jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loadingImage : 'lib/facebox/src/loading.gif',
        closeImage   : 'lib/facebox/src/closelabel.png'
      })
    })
	
	
	function procesar()
	{
		var patron_email=/^[^@ ]+@[^@ ]+.[^@ .]+$/;
		if (patron_email.test(document.Forma.email.value)==false)
			window.alert("Debe indicar un e-mail v�lido");
		else
			document.Forma.submit();
	}
	


	


</script>





<title>Gestionar mis anuncios clasificados</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


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
      <td width="320"><input type="button" name="button2" id="button2" value="Publicar Anuncio" onClick="document.location.href='publicar/'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;">
        <input type="button" name="button2" id="button2" value="Iniciar conversaci&oacute;n" onClick="document.location.href='conversaciones/publicar.php'" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;"></td>
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
      </div></td>
    </tr>
  </table>
</div>

</div>



<div id="content">
<div align="center" style="margin-top:50px;">
<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
      <tr>
        <td width="220" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio </b></a>&raquo; Gestionar mis anuncios</td>
        <td width="580" align="right" valign="bottom">&nbsp;</td>
      </tr>
    </table>
 
</div>


<div style="margin-top:50px;">
<form name="Forma" method="post" action="gestionAnuncioProcess.php">

<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8" style=" border-style:solid; border-color:#999; border-width:1px;" >
	<tr>
	  <td align="left" class="arial13Negro" style="padding:15px;">Te enviaremos a tu e-mail los enlaces para que puedas gestionar todos los anuncios que hayas publicado en Hispamercado</td>
	  </tr>
	<tr>
          <td align="left" class="arial13Negro" style="padding:15px; border-top-width:1px; border-top-style:dashed; border-color:#999;"><strong>Ingresa el e-mail que utilizaste para publicar tus anuncios     </strong>
            <input name="email" type="text" id="email" size="60" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;">  <input type="button" name="Submit2" value="Gestionar anuncios" style="font-family:Arial, Helvetica, sans-serif; font-size:13px;" onClick="procesar()">
          </td>
	</tr>
	<?
      		if ($sesion==false)
				echo '
				<tr>
	  <td align="center" class="arial13Negro" style="padding:15px; border-top-width:1px; border-top-style:dashed; border-color:#999;">
				<a href="beneficiosRegistro.php?state='.$_SESSION['state'].'" rel="facebox" class="LinkRojo13"><strong>Conoce los beneficios de registrarte en Hispamercado</strong></a>
				</td>
	  </tr>';
	  ?>
	  
</table>
</form>
</div>


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