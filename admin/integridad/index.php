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

function filtro(sele)
{
	document.location.href='index.php?filtro='+sele.value;
}



function procesar(accion)
{
	if (accion=="reprobar_revision")
	{
		document.Forma.accion.value="reprobar_revision";
		document.Forma.submit();
	}
	if (accion=="marcar_verificado")
	{
		document.Forma.accion.value="marcar_verificado";
		document.Forma.submit();
	}
	if (accion=="eliminar")
	{
	
		var dec;
		dec=window.confirm("¿Seguro de eliminar?");
		if (dec==true)
		{
			document.Forma.accion.value="eliminar";
			document.Forma.submit();
		}
	}
	
}


function filtro_cat(filtro1,categoria)
{
	var aux=categoria.options[categoria.selectedIndex].value; 
	//document.location.href='index.php?filtro='+filtro1+"&categoria="+aux;
	window.alert(categoria.selectedIndex);
}

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
    <td align="left" valign="bottom" class="arial13Negro"><a href="../anuncios/" class="LinkFuncionalidad13">Anuncios</a>  &nbsp;&nbsp;<a href="../categorias/" class="LinkFuncionalidad13">Categorías</a>  &nbsp;&nbsp;<a href="../estadisticas/" class="LinkFuncionalidad13">Estadísticas</a>  &nbsp;&nbsp;<strong>Integridad</strong></td>
    <td align="right" class="arial13Negro">&nbsp;</td>
  </tr>
</table>
<table width="600" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="left" class="arial13Blanco" bgcolor="#009999"><strong>Ciudades</strong></td>
  </tr>
  
  <?
		
		$query=operacionSQL("SELECT DISTINCT(ciudad) FROM Anuncio WHERE status_general='Int_Ciu'");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
		
			$ciudad=mysql_result($query,$i,0);
		
			$query2=operacionSQL("SELECT id FROM Anuncio WHERE ciudad='".$ciudad."' AND status_general='Int_Ciu'");
			
			$anuncios="";
			for ($e=0;$e<mysql_num_rows($query2);$e++)
				$anuncios.="<a href='../../anuncio/?id=".mysql_result($query2,$e,0)."' target='_blank' class='LinkFuncionalidad13'>".mysql_result($query2,$e,0)."</a>, ";
			
			
			if (($i%2)==0)
				$colorete="#F2F7E6";			
			else
				$colorete="#FFFFFF";
			
			
			echo "<tr bgcolor='".$colorete."'>
					<td align='left' class='arial13Negro'><a href='ciudad_eliminarTemporal.php?nombre=".$ciudad."'><img src='../../img/Close-16x16.png' width='16' height='16' border=0></a> ".$ciudad.": ".$anuncios."</td>
				  </tr>";
	
	
		}
  
  ?>
</table>
</body>
</html>
