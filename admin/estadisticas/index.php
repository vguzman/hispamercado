<?
	session_start();
	include "../../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html><head>

<LINK REL="stylesheet" TYPE="text/css" href="../../lib/css/basicos.css">




<script type="text/javascript">
</script>



<title>Administracion hispamercado</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="800" height="101" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="190" align="center" class="arial15Negro">&nbsp;</td>
    <td width="410">&nbsp;</td>
    <td width="200" valign="top" align="right" class="arial13Negro">&nbsp;</td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td width="676">&nbsp;</td>
    <td width="124" align="right"><span class="arial13Gris"><span class="arial13Negro">
    </span></span></td>
  </tr>
  <tr>
    <td align="left" valign="bottom" class="arial13Negro"><a href="../anuncios/" class="LinkFuncionalidad13">Anuncios</a>  &nbsp;&nbsp;<a href="../categorias/" class="LinkFuncionalidad13">Categorías</a>  &nbsp;&nbsp;<strong>Estadísticas</strong></td>
    <td align="right" class="arial13Negro">&nbsp;</td>
  </tr>
</table>
<table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor="#C8C8C8">
  <tr>
    <td height="1"></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="0">
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
<table width="600" height="28" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#009999" style="border-collapse:collapse ">
  <tr>
    <td width="90" align="center" class="arial13Blanco"><strong>Fecha</strong></td>
    <td width="85" align="center" class="arial13Blanco"><strong>Con.</strong></td>
    <td width="85" align="center" class="arial13Blanco"><strong>No Con.</strong></td>
    <td width="85" align="center" class="arial13Blanco"><strong>Revisados</strong></td>
    <td width="85" align="center" class="arial13Blanco"><strong>No rev</strong></td>
    <td width="85" align="center" class="arial13Blanco"><strong>No refer.</strong></td>
    <td width="85" align="center" class="arial13Blanco"><strong>Total</strong></td>
  </tr>
</table>
<table width="600" border="1" align="center" cellpadding="0" cellspacing="0" style="border-collapse:collapse ">
  <?
  		$query=operacionSQL("SELECT DATE_FORMAT( fecha, '%Y-%m-%d' ) AS C, count( * ) FROM `Anuncio` GROUP BY C ORDER BY `C` DESC ");
		$query_confirmado=operacionSQL("SELECT DATE_FORMAT( fecha, '%Y-%m-%d' ) AS C, count( * ) FROM `Anuncio` WHERE status_general='Activo' GROUP BY C ORDER BY `C` DESC ");
		$query_no_confirmado=operacionSQL("SELECT DATE_FORMAT( fecha, '%Y-%m-%d' ) AS C, count( * ) FROM `Anuncio` WHERE status_general='Verificar' GROUP BY C ORDER BY `C` DESC ");
		$query_revisado=operacionSQL("SELECT DATE_FORMAT( fecha, '%Y-%m-%d' ) AS C, count( * ) FROM `Anuncio` WHERE status_revision='Revisado' GROUP BY C ORDER BY `C` DESC ");
		$query_no_revisado=operacionSQL("SELECT DATE_FORMAT( fecha, '%Y-%m-%d' ) AS C, count( * ) FROM `Anuncio` WHERE status_revision='Revision' GROUP BY C ORDER BY `C` DESC ");
		$query_no_referenciado=operacionSQL("SELECT DATE_FORMAT(A.fecha,'%Y-%m-%d') AS C,COUNT(*) FROM Anuncio A, Anuncio_Info B WHERE A.id=B.id_anuncio AND referencia='' GROUP BY C ORDER BY fecha DESC");
		
		for ($i=0;$i<600;$i++)
		{
			$confirmado=0;
			for ($e=0;$e<mysql_num_rows($query_confirmado);$e++)
				if (mysql_result($query_confirmado,$e,0)==mysql_result($query,$i,0))
					$confirmado=mysql_result($query_confirmado,$e,1);
			
			$no_confirmado=0;
			for ($e=0;$e<mysql_num_rows($query_no_confirmado);$e++)
				if (mysql_result($query_no_confirmado,$e,0)==mysql_result($query,$i,0))
					$no_confirmado=mysql_result($query_no_confirmado,$e,1);
					
			$revisado=0;
			for ($e=0;$e<mysql_num_rows($query_revisado);$e++)
				if (mysql_result($query_revisado,$e,0)==mysql_result($query,$i,0))
					$revisado=mysql_result($query_revisado,$e,1);
					
			$no_revisado=0;
			for ($e=0;$e<mysql_num_rows($query_no_revisado);$e++)
				if (mysql_result($query_no_revisado,$e,0)==mysql_result($query,$i,0))
					$no_revisado=mysql_result($query_no_revisado,$e,1);
					
			$no_referenciado=0;
			for ($e=0;$e<mysql_num_rows($query_no_referenciado);$e++)
				if (mysql_result($query_no_referenciado,$e,0)==mysql_result($query,$i,0))
					$no_referenciado=mysql_result($query_no_referenciado,$e,1);
			
			
			
			echo "<tr>
					<td width='90' align='center' class='arial13Negro'>".mysql_result($query,$i,0)."</td>
					<td width='85' align='center' class='arial13Negro'>".$confirmado."</td>
					<td width='85' align='center' class='arial13Negro'>".$no_confirmado."</td>
					<td width='85' align='center' class='arial13Negro'>".$revisado."</td>
					<td width='85' align='center' class='arial13Negro'>".$no_revisado."</td>
					<td width='85' align='center' class='arial13Negro'>".$no_referenciado."</td>
					<td width='85' align='center' class='arial13Negro'>".mysql_result($query,$i,1)."</td>
				  </tr>";
		}
  
  
  ?>
</table>
</body>
</html>
