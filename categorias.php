<?
	session_start();
	
	include "lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);
			
	
	$barra=barraPrincipal("");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title>Categor&iacute;as de anuncios clasificados en Venezuela</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">


<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>


<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">


</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="295" align="left"><a href="/"><img src="img/logo_290.JPG" alt="" width="290" height="46" b border="0"></a></td>
    <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></td>
    <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Sección en construcción')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="6" bgcolor="#FFFFFF">
  <tr>
    <td width="10">&nbsp;</td>
    <td width="777" align="right" class="Arial11Negro">&nbsp;</td>
    <td width="13">&nbsp;</td>
  </tr>
</table>
<? echo $barra; ?>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<div align="center">
  <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse ">
    <tr>
      <td width="633" align="left" valign="bottom"><a href="/"  class="LinkFuncionalidad13"><b>Inicio </b></a>&raquo; <span class="arial13Negro">Arbol de categor&iacute;as </span></td>
      <td width="155" align="right">&nbsp;      </td>
    </tr>
  </table>
  <table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor="#C8C8C8">
  <tr>
    <td height="1"></td>
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
				  <td width='250' align='left' class='arial13Negro' valign='top'>%primera%</td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left' class='arial13Negro' valign='top'>%segunda%</td>
				  <td width='15'>&nbsp;</td>
				  <td width='250' align='left' class='arial13Negro' valign='top'>%tercera%</td>
				  </tr>				
			  </table>";
		
		
		$query=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria IS NULL AND id_pais='".$id_pais."' ORDER by orden ASC");
		$total=mysql_num_rows($query);
		$bloques=(int)($total/3);
		$resto=$total%3;
		$indice=0;		
		
		for ($i=0;$i<$bloques;$i++)
		{
			$primera="";$segunda="";$tercera="";
			$primera_sub="";$segunda_sub="";$tercera_sub="";
			
			$id_primera=mysql_result($query,$indice,1);
			$cat_aux=new Categoria($id_primera);
			
			$enlace=$cat_aux->armarEnlace();
			
			$primera="<a href='".$enlace."' class='linkCategoriaPrincipal13'>".mysql_result($query,$indice,0)." (".$cat_aux->anunciosActivos().")</a>";			
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$cat_aux=new Categoria($id_sub_categoria);
				$enlace=$cat_aux->armarEnlace();
				
				$primera_sub.="» <a href='".$enlace."' class='linkCategoriaPrincipal13'>".$sub_nombre."  (".$cat_aux->anunciosActivos().")</a> <br> ";	
			}						
			
			$indice++;
						
			$id_segunda=mysql_result($query,$indice,1);
			$cat_aux=new Categoria($id_segunda);
			
			$enlace=$cat_aux->armarEnlace();
			
			$segunda="<a href='".$enlace."' class='linkCategoriaPrincipal13'>".mysql_result($query,$indice,0)." (".$cat_aux->anunciosActivos().")</a>";
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$cat_aux=new Categoria($id_sub_categoria);
				
				$enlace=$cat_aux->armarEnlace();
				
				$segunda_sub.="» <a href='".$enlace."' class='linkCategoriaPrincipal13'>".$sub_nombre." (".$cat_aux->anunciosActivos().")</a><br>";	
			}		
			
			$indice++;	
						
			
			
			$id_tercera=mysql_result($query,$indice,1);
			$cat_aux=new Categoria($id_tercera);
			
			$enlace=$cat_aux->armarEnlace();
			
			
			$tercera="<a href='".$enlace."' class='linkCategoriaPrincipal13'>".mysql_result($query,$indice,0)." (".$cat_aux->anunciosActivos().")</a>";
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$cat_aux=new Categoria($id_sub_categoria);
				
				$enlace=$cat_aux->armarEnlace();
				
				$tercera_sub.="» <a href='".$enlace."' class='linkCategoriaPrincipal13'>".$sub_nombre." (".$cat_aux->anunciosActivos().")</a><br>";	
			}		
			
			$indice++;				
			
			 
			 $result=ereg_replace("%primera%","<b>".$primera."</b><br>".$primera_sub."<br>%primera%",$result);
			 $result=ereg_replace("%segunda%","<b>".$segunda."</b><br>".$segunda_sub."<br>%segunda%",$result);
			 $result=ereg_replace("%tercera%","<b>".$tercera."</b><br>".$tercera_sub."<br>%tercera%",$result);
			  
			  
		}
		
		$result=ereg_replace("%primera%","",$result);
		$result=ereg_replace("%segunda%","",$result);
		$result=ereg_replace("%tercera%","",$result);
		echo $result;
		
		
		/*if ($resto==1)
		{
			$primera="<a class='Arial11Negro' href='".$id_pais."/listado/categoria_".mysql_result($query,$indice,1)."/mostrar_1_30'>".mysql_result($query,$indice,0)."</a>";
			$primera_sub="";
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				if ($len>60)
					break;
				$primera_sub.="<a class='Arial11Negro' href='".$id_pais."/listado/categoria_".$id_sub_categoria."/mostrar_1_30'>".$sub_nombre."</a> | ";	
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
					<td width='93%' valign='top' class='Arial11Negro'>".$primera_sub." <i><a class='Arial11Negro' href='".$id_pais."/listado/categoria_".$id_primera."/mostrar_1_30'>ver todas</a></i></td>
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
			
			$primera="<a class='Arial11Negro' href='".$id_pais."/listado/categoria_".mysql_result($query,$indice,1)."/mostrar_1_30'>".mysql_result($query,$indice,0)."</a>";
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
				$segunda_sub.="<a class='Arial11Negro' href='listado.php?pais=".$id_pais."&tipo=lista&id_cat=".$id_sub_categoria."&mostrar=1_30'>".$sub_nombre."</a> | ";	
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
	  	}*/
	  
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
    <td align="center" class="arial13Negro"><? echo $barraPaises; ?> </td>
  </tr>
</table>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3308629-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>
</body>
</html>
