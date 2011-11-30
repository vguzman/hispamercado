<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Documento sin t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="post" action="recomendarAmigo2.php">
  <table width="350" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td width="126" align="left" class="arial13Negro">Tu nombre: </td>
      <td width="216"><input name="tu_nombre" type="text" size="30" id="nombre">
      <input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $_GET['id_anuncio'] ?>"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">E-mail de tu amigo: </td>
      <td><input name="email_amigo" type="text" size="30" id="email_amigo"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar recomendaci&oacute;n"></td>
    </tr>
  </table>
</form>
</body>
</html>
