<?
	session_start();
	
	include "../lib/class.php";	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">


<base href="http://www.hispamercado.com.ve/anuncio/" />
<title>Hispamercado</title>


</head>
<body >

<form name="Forma_Contacto" method="post" action="contactarAnunciante2.php">
  <table width="370" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:15px; margin-top:20px; border-bottom-style:solid; border-bottom-color:#CCC; border-bottom-width:1px;">
    <tr>
      <td class="arial15Negro"><strong>Contactar al anunciante</strong></td>
    </tr>
  </table>
  <table width="370" border="0px" align="center" cellpadding="2px" cellspacing="4px" >
    <tr>
      <td align="left" class="arial13Negro">Tu nombre<input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $_GET['id_anuncio'] ?>"></td>
      <td><input name="tu_nombre" type="text" id="tu_nombre" size="30" maxlength="100"></td>
    </tr>
    <tr>
      <td width="104" align="left" class="arial13Negro">Tu e-mail </td>
      <td width="246"><input name="tu_email" type="text" id="tu_email" size="30" maxlength="100"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Mensaje</td>
      <td><textarea name="comentario" cols="27" rows="7" id="comentario"></textarea></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Ingresa código</td>
      <td><img id="captcha" src="../lib/securimage/securimage_show.php" alt="Codigo de validacion" />
      <br>
<input type="text" name="captcha_code" size="10" maxlength="6" />     
      <a href="#" onclick="document.getElementById('captcha').src = '../lib/securimage/securimage_show.php?' + Math.random(); return false"><img src="../img/refresh_captcha.gif" alt="Refrescar imagen" border="0" /></a></td>
    </tr>
  </table>
  <table width="370" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:20px;">
    <tr>
      <td align="center"><input type="button" name="button" id="button" value="Enviar consulta" onClick="validarContacto()"></td>
    </tr>
  </table>
</form>


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