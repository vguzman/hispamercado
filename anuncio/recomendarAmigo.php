<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Hispamercado</title>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="post" action="recomendarAmigo2.php">

<table width="350" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-bottom:15px; margin-top:20px; border-bottom-style:solid; border-bottom-color:#CCC; border-bottom-width:1px;">
    <tr>
      <td class="arial15Negro"><strong>Recomendar a un amigo</strong></td>
    </tr>
  </table>
  <table width="350" border="0" align="center" cellpadding="0" cellspacing="4">
    <tr>
      <td width="134" align="left" class="arial13Negro">Tu nombre: </td>
      <td width="188"><input name="tu_nombre" type="text" size="30" id="nombre">
      <input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $_GET['id_anuncio'] ?>"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">E-mail de tu amigo: </td>
      <td><input name="email_amigo" type="text" size="30" id="email_amigo"></td>
    </tr>
  </table>
  <table width="350" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:5px;">
    <tr>
      <td style="padding-top:5px;" align="left"><input type="submit" name="Submit" value="Enviar recomendaci&oacute;n"></td>
    </tr>
  </table>
</form>
</body>
</html>