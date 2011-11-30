<?	
	session_start();
	
	include "lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);
			
	
	$barra=barraPrincipal("");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>Hispamercado <? echo $pais->nombre ?> - Sugerencias</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">


<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>

<SCRIPT LANGUAGE="JavaScript">

function enviarSugerencia() 
{
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange;
		
	req.open("POST","lib/servicios/requerir.php?que=sugerencia",true);
	req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	req.send("que=sugerencia&nombre="+document.FormaSugerencia.nombre.value+"&mail="+document.FormaSugerencia.mail.value+"&contenido="+document.FormaSugerencia.sugerencia.value);
} 
 
function processStateChange()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			window.alert("Tu sugerencia fue enviada y en breve será contestada. Muchas gracias");			
			window.history.go(0);		
		} 
		else 
			alert("Problema");      
	}
}
</SCRIPT>

</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="295" align="left"><a href="/"><img src="img/logo_290.JPG" alt="" width="290" height="46" border="0"></a></td>
    <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></td>
    <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Secci&oacute;n en construcci&oacute;n')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="6" bgcolor="#FFFFFF">
  <tr>
    <td width="10">&nbsp;</td>
    <td width="777" align="right" class="Arial11Negro">&nbsp;</td>
    <td width="13">&nbsp;</td>
  </tr>
</table>
<? echo $barra; ?>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div align="center">
<table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse ">
  <tr>
    <td width="633" align="left" valign="bottom" class="arial13Negro"><a href="/" class="LinkFuncionalidad13"><b>Inicio </b></a>&raquo; <span class="Arial13Negro1">Sugerencias</span></td>
    </tr>
</table>
<table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor="#C8C8C8">
  <tr>
    <td height="1"></td>
  </tr>
</table>
</div>
<form name="FormaSugerencia" method="post" action="">
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td id="contenido"><table width="800" border="0" align="center">
        <tr>
          <td class="arial13Negro" align="left">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td class="arial13Negro" align="left">&nbsp;</td>
          <td valign="middle">&nbsp;</td>
        </tr>
        <tr>
          <td width="96" class="arial13Negro" align="left">Tu nombre:</td>
          <td width="694" valign="middle"><input name="nombre" type="text" id="nombre" size="40"></td>
        </tr>
        <tr>
          <td class="arial13Negro" align="left">Tu e-mail:</td>
          <td> <span class="Arial13Rojo" id="mensaje_email">
            <input name="mail" type="text" id="mail" size="40">
          </span></td>
        </tr>
        <tr>
          <td class="arial13Negro" align="left">Tu sugerencia:</td>
          <td> <span class="Arial13Rojo" id="mensaje_email2">
            <textarea name="sugerencia" cols="40" rows="6" id="sugerencia"></textarea>
          </span></td>
        </tr>
        <tr>
          <td></td>
          <td class="Arial13Negro" id="asociar_anuncios"></td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center" id="ubicaboton"><input type="button" name="boton2" value="Enviar" onClick="enviarSugerencia()"></td>
    </tr>
  </table>
</form>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td align="center"><span class="arial13Negro"><? echo $barraPaises; ?></span></td>
  </tr>
</table>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>