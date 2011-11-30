<?
	//PROCESO DE INICIO DE SESION
	session_start();
	
	include "lib/util.php";
	
	
	
	if (isset($_GET['pais']))
		$_SESSION['pais']=$_GET['pais'];	
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>
				location.href='selecPais.php';
			</script>";
			
	
	
	if (isset($_COOKIE['detodoaqui']))
		$sesion_vieja=$_COOKIE['detodoaqui'];
	setcookie("detodoaqui",session_id(),time()+30*24*60*60);
	operacionSQL("UPDATE favoritos SET sesion='".session_id()."' WHERE sesion='".$sesion_vieja."'");
	
	
	
	
	$_SESSION['pais']=$nombre_pais;	
	if (isset($_COOKIE['detodoaqui']))
		$sesion_vieja=$_COOKIE['detodoaqui'];
	setcookie("detodoaqui",session_id(),time()+30*24*60*60);
	
		
	
	$pais=$_GET['pais'];
	
	//SACA NOMBRE PAIS
	$query=operacionSQL("SELECT nombre FROM pais WHERE id='".$pais."'");
	$nombre_pais=mysql_result($query,0,0);
	
	
	//PROCESO DE INICIO DE SESION
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<base href="http://www.hispamercado.com/">
<title>HispaMercado <? echo $nombre_pais; ?> (BETA) - Anuncios clasificados sin comisiones ni complicaciones</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<SCRIPT LANGUAGE="JavaScript">
function publicar(pais)
{
	window.open("http://www.hispamercado.com/"+pais+"/publicar/","publicar","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=650,height=630");
}

function gestionar(pais)
{
	window.open("http://www.hispamercado.com/"+pais+"/gestionar/","gestionar","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=650,height=630");
}
function alertas(pais)
{
		window.open("http://www.hispamercado.com/"+pais+"/alertas/","alertas","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=480,height=450");
}
</SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/listados.js"></SCRIPT>

<style type="text/css">
body {
	margin-top: 6px;
	background-color: #FFFFFF;
	background-image: url();
}


a.menus {font-family: Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:13px; text-decoration:none}
a.menus:hover {font-family: Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:13px; text-decoration:none; font-weight:bold}

a.menus2 {font-family: Arial, Helvetica, sans-serif; color:#585247; font-size:13px; text-decoration:none}
a.menus2:hover {font-family: Arial, Helvetica, sans-serif; color:#0066FF; font-size:13px; text-decoration:none}

.Estilo1 {font-family: Arial, Helvetica, sans-serif; color:#FFFFFF; font-size:13px; text-decoration:none}

.Estilo2 {font-family: Arial, Helvetica, sans-serif; color:#583A1D; font-size:13px;}
.link_paises {font-family: Arial, Helvetica, sans-serif; font-size:12px;}
.Arial13Gris {font-family: Arial, Helvetica, sans-serif; color:#666666; font-size:13px; text-decoration:none}

.Estilo3 {font-family: Arial, Helvetica, sans-serif; font-size:11px;}
.Arial13Link {font-family: Arial, Helvetica, sans-serif; font-size:13px; color:#0000FF; text-decoration:none}
.Arial13Negro {font-family: Arial, Helvetica, sans-serif; font-size:13px; color:#000000 text-decoration:none}
.Arial11Negro2 {font-family: Arial, Helvetica, sans-serif; font-size:11px; color:#000000 text-decoration:none}
.Estilo6 {
	font-size:13px;
	text-decoration:none;
	font-family: Arial, Helvetica, sans-serif;
	color: #00FF66;
}
.Estilo7 {color: #FFFFFF}

.Arial11Negro {font-family: Arial, Helvetica, sans-serif; font-size:11px; color:#003399; text-decoration:none}
a.Arial11Negro:hover {font-family: Arial, Helvetica, sans-serif; font-size:11px; color:#003399; text-decoration:underline}
</STYLE>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="212" align="center"><div align="left"><a href="http://www.hispamercado.com/<? echo $pais; ?>/"><img src="img/logo10.jpg" width="199" height="61" border="0"></a></div></td>
    <td width="368" align="center">
      <form name="Forma" onSubmit="return false">
        <table width="350" border="0" align="left" cellpadding="0" cellspacing="0">
          <tr>
            <td width="350"><input name="busqueda" type="text" size="30" onKeyPress="validarBuscar(event,'<? echo $pais; ?>','no')">
                <input type="button" name="boton" value="Buscar anuncio" onClick="buscar('<? echo $pais; ?>','no')"></td>
          </tr>
        </table>
    </form></td>
    <td width="220" align="right" valign="top"><a href="dsafsa" class="Estilo3">T&eacute;rminos del Servicio</a> <span class="Estilo3">|</span> <a href="asdas" class="Estilo3">Sugerencias</a><span class="Estilo3"> </span></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" background="img/fondo_barra4.jpg">
  <tr>
    <td height="35"><div align="center"></div>
        <div align="center"><span class="menus2"><a href="javascript:publicar('<? echo $pais; ?>')" class="menus2"><strong>Colocar anuncio GRATIS</strong></a> | <a href="javascript:gestionar('<? echo $pais; ?>')" class="menus2"><strong>Gestionar mis anuncios</strong></a> | <a href="<? echo $pais; ?>/favoritos/" class="menus2"><strong>Mis anuncios favoritos</strong></a> | <a href="javascript:alertas('<? echo $pais; ?>')" class="menus2"><strong>Alertas</strong></a></span></div></td>
  </tr>
</table>
<table width="100" border="0" align="center" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div align="center">
  <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse ">
    <tr>
      <td width="633" align="left" valign="bottom"><a href="<? echo $pais; ?>/" class="Arial13Link"><b>Inicio </b></a>&raquo; <span class="Arial13Negro">Arbol de categor&iacute;as </span></td>
      <td width="155" align="right">&nbsp;      </td>
    </tr>
  </table>
  <table width='800' border='0' align='center' bordercolor='#C8C8C8' bgcolor='#C8C8C8' style='border-collapse: collapse'>
    <tr>
      <td></td>
    </tr>
  </table>
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<?
	  	
		$result="<table width='780' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
				  <td width='250' align='left' class='Arial11Negro2' valign='top'>%primera%</td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left' class='Arial11Negro2' valign='top'>%segunda%</td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left' class='Arial11Negro2' valign='top'>%tercera%</td>
				  </tr>				
			  </table>";
		
		
		$query=operacionSQL("SELECT nombre,id FROM categoria WHERE id_categoria IS NULL AND id_pais='".$pais."' ORDER by orden ASC");
		$total=mysql_num_rows($query);
		$bloques=(int)($total/3);
		$resto=$total%3;
		$indice=0;		
		
		for ($i=0;$i<$bloques;$i++)
		{
			$primera="";$segunda="";$tercera="";
			$primera_sub="";$segunda_sub="";$tercera_sub="";
			
			$id_primera=mysql_result($query,$indice,1);
			
			$primera="<a href='".$pais."/listado/categoria_".mysql_result($query,$indice,1)."/mostrar_1_30'>".mysql_result($query,$indice,0)."</a>";			
			$query2=operacionSQL("SELECT nombre,id FROM categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$primera_sub.="&nbsp;&nbsp;<a href='".$pais."/listado/categoria_".$id_sub_categoria."/mostrar_1_30'>".$sub_nombre."</a> <br> ";	
			}						
			
			$indice++;
			
			
			$id_segunda=mysql_result($query,$indice,1);
			
			$segunda="<a href='".$pais."/listado/categoria_".mysql_result($query,$indice,1)."/mostrar_1_30'>".mysql_result($query,$indice,0)."</a>";
			$query2=operacionSQL("SELECT nombre,id FROM categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$segunda_sub.="&nbsp;&nbsp;<a href='".$pais."/listado/categoria_".$id_sub_categoria."/mostrar_1_30'>".$sub_nombre."</a><br>";	
			}		
			
			$indice++;	
						
			
			
			$id_tercera=mysql_result($query,$indice,1);
			
			$tercera="<a href='".$pais."/listado/categoria_".mysql_result($query,$indice,1)."/mostrar_1_30'>".mysql_result($query,$indice,0)."</a>";
			$query2=operacionSQL("SELECT nombre,id FROM categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$tercera_sub.="&nbsp;&nbsp;<a href='".$pais."/listado/categoria_".$id_sub_categoria."/mostrar_1_30'>".$sub_nombre."</a><br>";	
			}		
			
			$indice++;				
			
			/*echo "<table width='780' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
				  <td width='250' align='left' class='Arial11Negro2'><b>".$primera."</b><br>".$primera_sub."</td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left' class='Arial11Negro2'><b>".$segunda."</b><br>".$segunda_sub."</td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left' class='Arial11Negro2'><b>".$tercera."</b><br>".$tercera_sub."</td>
				  </tr>				
			  </table>";*/
			 
			 $result=ereg_replace("%primera%","<b>".$primera."</b><br>".$primera_sub."<br>%primera%",$result);
			 $result=ereg_replace("%segunda%","<b>".$segunda."</b><br>".$segunda_sub."<br>%segunda%",$result);
			 $result=ereg_replace("%tercera%","<b>".$tercera."</b><br>".$tercera_sub."<br>%tercera%",$result);
			  
			  
		}
		
		$result=ereg_replace("%primera%","",$result);
		$result=ereg_replace("%segunda%","",$result);
		$result=ereg_replace("%tercera%","",$result);
		echo $result;
		
		
		if ($resto==1)
		{
			$primera="<a class='Arial11Negro' href='".$pais."/listado/categoria_".mysql_result($query,$indice,1)."/mostrar_1_30'>".mysql_result($query,$indice,0)."</a>";
			$primera_sub="";
			$query2=operacionSQL("SELECT nombre,id FROM categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				if ($len>60)
					break;
				$primera_sub.="<a class='Arial11Negro' href='".$pais."/listado/categoria_".$id_sub_categoria."/mostrar_1_30'>".$sub_nombre."</a> | ";	
			}		
			
			echo "<table width='780' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
				  <td width='250' align='left' class='Arial11Negro'><b>&#9658; ".$primera."</b></td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left'><b><font face='Arial' size='2'></font></b></td>
				  <td width='15'>&nbsp;</td>
				  <td width='250'  align='left'><b><font face='Arial' size='2'></font></b></td>
				  </tr>
				<tr>
				  <td align='left' width='250' valign='top'><table width='100%'  border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td width='7%'></td>
					<td width='93%' valign='top' class='Arial11Negro'>".$primera_sub." <i><a class='Arial11Negro' href='".$pais."/listado/categoria_".$id_primera."/mostrar_1_30'>ver todas</a></i></td>
				  </tr>
				</table></td>
				  <td  align='left' width='15'>&nbsp;</td>
				  <td  align='left' width='250'></td>
				  <td  align='left' width='15'>&nbsp;</td>
				  <td  align='left' width='250'></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
			  </table>";
			
		}
		if ($resto==2)
		{			
			$primera_sub="";$segunda_sub="";
			
			$primera="<a class='Arial11Negro' href='".$pais."/listado/categoria_".mysql_result($query,$indice,1)."/mostrar_1_30'>".mysql_result($query,$indice,0)."</a>";
			$query2=operacionSQL("SELECT nombre,id FROM categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				if ($len>60)
					break;
				$primera_sub.="<a class='Arial11Negro' href='".$pais."/listado/categoria_".$id_sub_categoria."/mostrar_1_30'>".$sub_nombre."</a> | ";	
			}			
			
			$indice++;
			$segunda="<a class='Arial11Negro' href='listado.php?pais=".$pais."&tipo=lista&id_cat=".mysql_result($query,$indice,1)."&mostrar=1_30'>".mysql_result($query,$indice,0)."</a>";
			$query2=operacionSQL("SELECT nombre,id FROM categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				if ($len>60)
					break;
				$segunda_sub.="<a class='Arial11Negro' href='listado.php?pais=".$pais."&tipo=lista&id_cat=".$id_sub_categoria."&mostrar=1_30'>".$sub_nombre."</a> | ";	
			}			
			
			echo "<table width='780' border='0' cellspacing='0' cellpadding='0' align='center'>
				<tr>
				  <td width='250' align='left' class='Arial11Negro'><b>&#9658; ".$primera."</b></td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left' class='Arial11Negro'><b>&#9658;</font> ".$segunda."</b></td>
				  <td width='15'>&nbsp;</td>
				  <td width='250'  align='left'></td>
				  </tr>
				<tr>
				  <td align='left' width='250' valign='top'><table width='100%'  border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td width='7%'></td>
					<td width='93%' valign='top' class='Arial11Negro'>".$primera_sub." <i><a class='Arial11Negro' href='".$pais."/listado/categoria_".$id_primera."/mostrar_1_30'>ver todas</a></i></td>
				  </tr>
				</table></td>
				  <td  align='left' width='15'>&nbsp;</td>
				  <td  align='left' width='250' valign='top'><table width='100%'  border='0' cellspacing='0' cellpadding='0'>
				  <tr>
					<td width='7%'></td>
					<td width='93%' valign='top' class='Arial11Negro'>".$segunda_sub." <i><a class='Arial11Negro' href='".$pais."/listado/categoria_".$id_segunda."/mostrar_1_30'>ver todas</a></i></td>
				  </tr>
				</table></td>
				  <td  align='left' width='15'>&nbsp;</td>
				  <td  align='left' width='250' valign='top'></td>
				</tr>
				<tr>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				  <td>&nbsp;</td>
				</tr>
			  </table>";
	  	}
	  
	  ?>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
  <tr>
    <td align="center"><span class="link_paises">
      <?php		
		$query=operacionSQL("SELECT id,nombre FROM pais");
		$total=mysql_num_rows($query);
		
		for ($i=0;$i<$total;$i++)
		{			
			if ($pais!=mysql_result($query,$i,0))
			{
				echo "<a href='index.php?pais=".mysql_result($query,$i,0)."'>".mysql_result($query,$i,1)."</a> ";
				
			}
			else
			{
				echo "<b>".mysql_result($query,$i,1)."</b> ";
			}
			if ($i+1<$total)
				echo "| ";
		}		
	?>
    </span></td>
  </tr>
</table>
</body>
</html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>