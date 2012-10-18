<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Hispamercado</title>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="post" action="denunciar2.php">

<table width="350" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:15px; margin-top:20px; border-bottom-style:solid; border-bottom-color:#CCC; border-bottom-width:1px;">
    <tr>
      <td class="arial15Negro"><strong>Denunciar  anuncio</strong></td>
    </tr>
  </table>
<table width="350" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td class="arial13Negro" style="padding:10px;"><input type="radio" name="porque" id="porque" value="Este anuncio es de contenido inadecuado o ilegal(violencia explicita, pornografia infantil, etc)">
      Este anuncio es de contenido inadecuado o ilegal(violencia explicita, pornografia infantil, etc)
      <input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $_GET['id_anuncio'] ?>"></td>
  </tr>
  <tr>
    <td style="padding:10px;"><span class="arial13Negro">
      <input type="radio" name="porque" id="porque" value="Este anuncio usa fotografias y datos de caracter personal de una tercera persona">
Este anuncio usa fotografias y datos de caracter personal de una tercera persona</span></td>
  </tr>
  <tr>
    <td style="padding:10px;"><span class="arial13Negro">
      <input type="radio" name="porque" id="porque" value="Este anuncio es de contenido inadecuado (violencia explicita, pornografia infantil, etc)"> 
      Este anuncio se encuentra listado en una categor&iacute;a incorrecta
</span></td>
  </tr>
  <tr>
    <td style="padding:10px;"><span class="arial13Negro">
      <input type="radio" name="porque" id="porque" value="Este anuncio es SPAM<">
Este anuncio es SPAM</span></td>
  </tr>
  <tr>
    <td style="padding:10px;"><span class="arial13Negro">
      <input type="radio" name="porque" id="porque" value="Este anuncio carece de sentido">
Este anuncio carece de sentido</span></td>
  </tr>
  <tr>
    <td class="arial13Negro" style="padding:10px;">Comentario<br />
      <label for="comentario"></label>
      <textarea name="comentario" cols="40" rows="3" id="comentario"></textarea></td>
  </tr>
</table>
<table width="350" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:5px;">
    <tr>
      <td style="padding-top:5px;" align="center"><input type="submit" name="Submit" value="Enviar "></td>
    </tr>
  </table>
</form>
</body>
</html>
