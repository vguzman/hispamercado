<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
</STYLE>

<SCRIPT LANGUAGE="JavaScript">
function cargando(boton)
{
	if (document.FormaFoto.ruta.value=="")
		window.alert("Debe seleccionar una imagen");
	else
	{
		boton.disabled=true;
		boton.value="cargando...";
		document.FormaFoto.submit();
	}
}
</SCRIPT>

<title>Subir foto</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
<form name="FormaFoto" method="post" action="subirFoto2.php" enctype="multipart/form-data">
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="6">
    <tr>
      <td><div align="left"><font face="Arial" size="2" color="#008000">Formatos permitidos: JPEG, PNG y GIF</font></div></td>
    </tr>
  </table>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="6">
      <tr>
        <td width="250"><input name="ruta" type="file" id="ruta" size="25"></td>
      </tr>
  </table>
    <table width="300" border="0" align="center" cellpadding="0" cellspacing="6">
      <tr>
        <td><input type="button" name="Submit2" value="Aceptar" onClick="cargando(this)">
        <input name="foto" type="hidden" id="foto" value="<?php echo $_GET['foto']; ?>">
        <input type="hidden" name="code" id="code" value="<?php echo $_GET['code']; ?>"></td>
      </tr>
    </table>
</form>
</body>
</html>