<?
	session_start();
	if (session_is_registered('usuario'))
   		echo "<SCRIPT LANGUAGE='JavaScript'> location.href='../facturacion/'; </SCRIPT>";
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Mercasist</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="form1" method="post" action="inicioSesion.php">
  <table width="212" border="0" align="center" bgcolor="#E8E800" style="border-collapse: collapse">
    <tr>
      <td><div align="center"><b><font face="Tahoma" style="font-size: 10pt">Ingreso de Usuario</font></b></div></td>
    </tr>
  </table>
  <table width="212" border="0" align="center" id="table16">
    <tr>
      <td width="67"><font face="Tahoma" size="2">Usuario:</font></td>
      <td width="135"><font face="Tahoma">
        <input name="user" type="text" id="user" size="17">
      </font></td>
    </tr>
    <tr>
      <td width="67"><font face="Tahoma" size="2">Password:</font></td>
      <td><font face="Tahoma">
        <input name="pass" type="password" id="pass" size="17">
      </font></td>
    </tr>
  </table>
  <table width="212" border="0" align="center" id="table17">
    <tr>
      <td width="73">&nbsp;</td>
      <td width="129">
        <p align="left"><font face="Tahoma">
          <input type="submit" value="Entrar" name="B1">
      </font></td>
    </tr>
  </table>
  </form>
</body>
</html>
