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


function filtrar()
{
	var status=document.Forma.status;	
	var valor_status=status.options[status.selectedIndex].value; 
	
	var valor_anunciante=document.Forma.anunciante.value;
	
	var valor_anuncio=document.Forma.anuncio.value;
	
	document.location.href='index.php?status='+valor_status+"&anunciante="+valor_anunciante+"&anuncio="+valor_anuncio;
	
	//window.alert(valor_status);
	//window.alert(valor_anunciante);
	
	//window.alert("asdsadsadasdasdsadasdasdasad");
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
    <td align="left" valign="bottom" class="arial13Negro"><strong>Anuncios</strong>  &nbsp;&nbsp;<a href="../categorias/" class="LinkFuncionalidad13">Categorías</a>  &nbsp;&nbsp;<a href="../estadisticas/" class="LinkFuncionalidad13">Estadísticas</a>  &nbsp;<a href="../integridad/" class="LinkFuncionalidad13">Integridad</a></td>
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
    <td align="right"><select name="filtro" id="filtro">
      <option> </option>
      <option>Todos</option>
      <option>Activos-Revision</option>
    </select></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<form name="Forma" method="post" action="procesar.php">

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="356" align="left" class="arial13Negro"><p>Status
      <select name="status" id="status" ">
        <option></option>
        <option value="act" <? if ($_GET['status']=="act") echo "selected" ?> >Activos</option>
        <option value="acreno" <? if ($_GET['status']=="acreno") echo "selected" ?> >Activos-Revision</option>
        <option value="acresi" <? if ($_GET['status']=="acresi") echo "selected" ?>>Activos-Revisados</option>
        <option value="nocon" <? if ($_GET['status']=="nocon") echo "selected" ?>>No confirmados</option>
      </select>
      <br><br>
      Anunciante: 
      <label for="anunciante"></label>
      <input name="anunciante" type="text" id="anunciante" value="<? echo $_GET['anunciante'] ?>">
    </p>
      <p>Anuncio 
        <label for="anuncio"></label>
        <input name="anuncio" type="text" id="anuncio" size="5" value="<? echo $_GET['anuncio'] ?>">
      </p>
      <p>
        <input type="button" name="button3" id="button3" value="Filtrar" onClick="filtrar()">
      </p></td>
    <td width="444" align="right" class="arial13Negro"><?
	
	
	$aux="SELECT id FROM Anuncio WHERE id<0 ";
	
	
	if ($_GET['status']!="")
	{
		if ($_GET['status']=="act")
			$aux.="OR (status_general='Activo') ";
		if ($_GET['status']=="acreno")
			$aux.="OR (status_general='Activo' AND status_revision='Revision') ";
		if ($_GET['status']=="acresi")
			$aux.="OR (status_general='Activo' AND status_revision='Revisado') ";
		if ($_GET['status']=="nocon")
			$aux.="OR (status_general='verificar') ";
			
	}
	if ($_GET['anunciante']!="")
	{
		$aux.=" OR (anunciante_email='".trim($_GET['anunciante'])."')";
	}
	if ($_GET['anuncio']!="")
	{
		$aux.=" OR (id='".trim($_GET['anuncio'])."')";
	}

	$aux.=" ORDER BY fecha DESC";
	
		
	echo "<br><br>";
	echo $aux;
	echo "<br><br>";
	
	$query=operacionSQL($aux);
	
	echo mysql_num_rows($query)." resultados" ?></td>
  </tr>
</table>
<table width="794" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#FFFFFF" bgcolor="#009999" style="border-collapse:collapse ">
  <tr>
    <td width="20" align="center" class="arial13Blanco"><input type="checkbox" name="checkbox" id="checkbox"></td>
    <td width="45" align="center" class="arial13Blanco"><strong>Id</strong></td>
    <td width="90" align="center" class="arial13Blanco"><strong>Fecha</strong></td>
    <td width="506" align="center" class="arial13Blanco"><strong>Anuncio
      <input type="hidden" name="query" id="query" value="<? echo $aux ?>">
    </strong></td>
    <td width="121" align="center" class="arial13Blanco"><strong>Acciones</strong></td>
  </tr>
</table>
<?
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
		
		$anuncio=new Anuncio(mysql_result($query,$i,0));


		echo "<table width='794' height='24' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='".$colorete."' style='border-collapse:collapse '>
  <tr>
    <td width='20' align='center' class='arial13Negro'><input type='checkbox' name='anuncio_".$anuncio->id."' id='anuncio_".$anuncio->id."' value='SI'></td>
    <td width='80' align='center' class='arial13Negro'>".$anuncio->id."</td>
    <td width='90' align='left' class='arial13Negro'>".aaaammdd_ddmmaaaa($anuncio->fecha)."</td>
    <td width='471' align='left' class='arial13Negro'><a href='../../anuncio/?id=".$anuncio->id."' class='LinkFuncionalidad13' target='_blank'>".$anuncio->titulo."</a></td>
    <td width='121' align='center' class='arial13Negro'><a href='redirect.php?codigo=".$anuncio->codigo_verificacion."' class='LinkFuncionalidad' target='_blank'>Revisar</a></td>
  </tr>
</table>";


	}

?>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><label>
      <input type="hidden" name="accion" id="accion">
      <input type="button" name="boton_eliminar" id="boton_eliminar" value="Eliminar" <? if ($_GET['status']=="nocon") echo "enabled";else echo "disabled"  ?> onClick="procesar('eliminar')">&nbsp;&nbsp;&nbsp;
      <input type="button" name="button" id="button" value="Marcar verificado" <? if ($_GET['status']=="nocon") echo "enabled";else echo "disabled"  ?> onClick="procesar('marcar_verificado')">&nbsp;&nbsp;&nbsp;
      <input type="button" name="button2" id="button2" value="Reprobar revision" <? if ($_GET['status']=="acreno") echo "enabled";else echo "disabled"  ?> onClick="procesar('reprobar_revision')">
    </label></td>
  </tr>
</table>
</form>
</body>
</html>
