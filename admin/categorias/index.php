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




<SCRIPT LANGUAGE="JavaScript" src="../../lib/js/InnerDiv.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../../lib/js/basicos.js"></SCRIPT>
<script type="text/javascript">
	
	function agregarSubcategoria(id_cat)
	{
		window.open("agregarSubcategoria.php?id_cat="+id_cat,"agregarCategoria_"+id_cat,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=750,height=160");
	}
	
	
	function editarCategoria(id)
	{
		posicion=posicionElemento("html_cat_"+id);
		INNERDIV.newInnerDiv('editar_categoria_'+id,500,posicion['top']-10,450,120,'editarCategoria.php?id_cat='+id+"&adsad=",'Editar categoría');
	}
	
	function eliminarCategoria(id)
	{
		var dec=window.confirm("¿Seguro de eliminar esta categoría?");
		if (dec==true)
			document.location.href="eliminarCategoria.php?id_cat="+id;
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
    <td align="left" valign="bottom" class="arial13Negro"><a href="../anuncios/" class="LinkFuncionalidad13">Anuncios</a> &nbsp;&nbsp;<strong>Categorías</strong></td>
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
<?
	$query=operacionSQL("SELECT id FROM Categoria WHERE id_categoria IS NULL AND id_pais='venezuela' ORDER BY orden ASC");
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
		
		$acciones="";
		$cat=new Categoria(mysql_result($query,$i,0));
		$acc=$cat->acciones();
		for ($e=0;$e<count($acc);$e++)
			$acciones.=$acc[$e].", ";
		
		
		
		$sub_html="";
		$hijos=$cat->hijosInmediatos();
		for ($e=0;$e<count($hijos);$e++)
		{
			$cat2=new Categoria($hijos[$e]);
			$sub_html.="<span id='html_cat_".$cat2->id."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;» ".$cat2->nombre." (".$cat2->anunciosActivos().") (<a href='javascript:agregarSubcategoria(".$cat2->id.")' class='LinkFuncionalidad'>Agregar subcategoria</a> | <a href='javascript:editarCategoria(".$cat2->id.")' class='LinkFuncionalidad'>Editar</a> | <a href='javascript:eliminarCategoria(".$cat2->id.")' class='LinkFuncionalidad'>Eliminar</a>)</span> <span class='arial11Verde'>(Orden: <a href='' class='LinkFuncionalidad'>".$cat2->orden."</a>)</span><br>";
			
			if ($cat2->esHoja()==false)
			{
				$hijos2=$cat2->hijosInmediatos();
				for ($j=0;$j<count($hijos2);$j++)
				{
					$cat3=new Categoria($hijos2[$j]);
					$sub_html.="<span id='html_cat_".$cat3->id."'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;» ".$cat3->nombre." (".$cat3->anunciosActivos().") (<a href='javascript:editarCategoria(".$cat3->id.")' class='LinkFuncionalidad'>Editar</a> | <a href='javascript:eliminarCategoria(".$cat3->id.")' class='LinkFuncionalidad'>Eliminar</a>)</span> <span class='arial11Verde'>(Orden: <a href='' class='LinkFuncionalidad'>".$cat3->orden."</a>)</span><br>";
				}
			}
		}
		
		
		
		
		echo "<table width='800' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='".$colorete."'>
			  <tr>
				<td align='left' class='arial13Negro' id='html_cat_".$cat->id."'><b>» ".$cat->nombre." (".$cat->anunciosActivos().")</b> (<a href='javascript:agregarSubcategoria(".$cat->id.")' class='LinkFuncionalidad'>Agregar subcategoria</a> | <a href='' class='LinkFuncionalidad'>Acciones</a> | <a href='javascript:eliminarCategoria(".$cat->id.")' class='LinkFuncionalidad'>Eliminar</a> | <a href='javascript:editarCategoria(".$cat->id.")' class='LinkFuncionalidad'>Editar</a>)  <span class='arial11Verde'>(Orden: <a href='' class='LinkFuncionalidad'>".$cat->orden."</a>)</span><br>&nbsp;&nbsp;&nbsp;<span class='arial11Gris'>".$acciones."</span></td>				
			  </tr>
			  <tr>
				<td align='left' class='arial13Negro'>".$sub_html."</td>				
			  </tr>
			</table>";
	}

?>
</body>
</html>
