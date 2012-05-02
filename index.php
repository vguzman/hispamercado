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


<title>Anuncios clasificados gratis en <? echo $pais->nombre ?> - Avisos Clasificados gratuitos - Inmuebles, Carros, Negocios, Servicios</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<meta name="description" content="Avisos clasificados gratuitos en toda Venezuela, avanzadas herramientas de publicación y búsqueda. Inmuebles: Apartamentos, Casas, Oficinas, Locales comerciales. Vehículos: Carros, Camionetas, Motos, Repuestos. Celulares, Video juegos, Ropa, Negocios, Servicios, Mascotas y mucho mas">


<meta name="verify-v1" content="A0OJoF0jubwVRFX6Y9ebASAdD2xkJRU80LMv03zZ9rA=" />
<meta name="verify-v1" content="ls7ijapXvkJEEwrjEulO+q86aItcn2hgeXrQI8dASls=" />
<meta name="keywords" content="clasificados, anuncios, avisos, gratis, tiendas, comercio, venta, compra, alquiler, vehiculos, carros, inmuebles, electronicos, videojuegos, computacion">


<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">


<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/URLencode.js"></SCRIPT>

<SCRIPT LANGUAGE="JavaScript">

function listarRecientes() 
{		
	document.getElementById("anuncios_recientes").innerHTML="<div align='center'><img src='img/ajax-loader1.gif' width='110' height='75'></div>";
	
	if (document.getElementById("buscar").value=="Búsqueda rápida...")
		document.getElementById("buscar").value="";
	
	categoria=document.getElementById("categorias");
	ciudad=document.getElementById("ciudades");
	buscar=document.getElementById("buscar");
		
	var url="ajaxRecientes.php?id_cat="+categoria.options[categoria.selectedIndex].value+"&ciudad="+ciudad.options[ciudad.selectedIndex].value+"&buscar="+buscar.value;
	
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange;
	req.open("GET",url, true);
	req.send(null);	
} 

function manejoBusqueda(donde)
{
	if (donde=="adentro")
		if (document.getElementById("buscar").value=="Búsqueda rápida...")
			document.getElementById("buscar").value="";
	
	if (donde=="afuera")
		if (document.getElementById("buscar").value=="")
			document.getElementById("buscar").value="Búsqueda rápida...";
}

function validar(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) listarRecientes();
}


function processStateChange()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("anuncios_recientes").innerHTML=req.responseText;						
		} 
		else 
			alert("Problema");      
	}
}
</SCRIPT>
</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="295" align="left"><img src="img/logo_290.JPG" width="290" height="46"></td>
    <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></td>
    <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Sección en construcción')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
  </tr>
</table>
<table width="800" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><div id="fb-root"></div><script src="http://connect.facebook.net/es_ES/all.js#appId=119426148153054&amp;xfbml=1"></script><fb:like href="http://www.hispamercado.com.ve/" send="false" layout="button_count" width="110" show_faces="true" font="arial"></fb:like></div>
    </td>
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
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><div align="center">
        <table width="100" border="0" cellspacing="0" cellpadding="0">
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
			
			$primera="<a href='".$enlace."' class='LinkFuncionalidad12'>".mysql_result($query,$indice,0)." (".$cat_aux->anunciosActivosCache().")</a>";			
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$cat_aux=new Categoria($id_sub_categoria);
				$enlace=$cat_aux->armarEnlace();
				
				$primera_sub.="&raquo; <a href='".$enlace."' class='LinkFuncionalidad12'>".$sub_nombre."  (".$cat_aux->anunciosActivosCache().")</a> <br> ";	
			}						
			
			$indice++;
						
			$id_segunda=mysql_result($query,$indice,1);
			$cat_aux=new Categoria($id_segunda);
			
			$enlace=$cat_aux->armarEnlace();
			
			$segunda="<a href='".$enlace."' class='LinkFuncionalidad12'>".mysql_result($query,$indice,0)." (".$cat_aux->anunciosActivosCache().")</a>";
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$cat_aux=new Categoria($id_sub_categoria);
				
				$enlace=$cat_aux->armarEnlace();
				
				$segunda_sub.="&raquo; <a href='".$enlace."' class='LinkFuncionalidad12'>".$sub_nombre." (".$cat_aux->anunciosActivosCache().")</a><br>";	
			}		
			
			$indice++;	
						
			
			
			$id_tercera=mysql_result($query,$indice,1);
			$cat_aux=new Categoria($id_tercera);
			
			$enlace=$cat_aux->armarEnlace();
			
			
			$tercera="<a href='".$enlace."' class='LinkFuncionalidad12'>".mysql_result($query,$indice,0)." (".$cat_aux->anunciosActivosCache().")</a>";
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$indice,1)." ORDER BY orden ASC");
			$len=0;
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				$len=$len+strlen($sub_nombre);
				
				$cat_aux=new Categoria($id_sub_categoria);
				
				$enlace=$cat_aux->armarEnlace();
				
				$tercera_sub.="&raquo; <a href='".$enlace."' class='LinkFuncionalidad12'>".$sub_nombre." (".$cat_aux->anunciosActivosCache().")</a><br>";	
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
    </div></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
  </tr>
</table>
<table width="300" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>


<table width="800" height="38" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#D8E8AE"; style="border-collapse:collapse " >
  <tr>
    <td width="672" align="left" valign="middle" class="arial13Mostaza">
      <input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event)" id="buscar" style="font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C" value="B&uacute;squeda r&aacute;pida..." size="20">
      &nbsp;
      
      <select name="categorias" id="categorias" style="font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C">
        <option selected value="todas">Todas las categor&iacute;as</option>
        <?
	  	$aux="SELECT id,nombre FROM Categoria WHERE id_pais='".$id_pais."' AND id<>160 AND id_categoria IS NULL";
		$query=operacionSQL($aux);
		$total=mysql_num_rows($query);	
		
		for ($i=0;$i<$total;$i++)
		{
			$categoria=new Categoria(mysql_result($query,$i,0));
			
			//if ($categoria->anunciosActivos()>0)
			echo "<option value='".mysql_result($query,$i,0)."'style='font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C'>".mysql_result($query,$i,1)."</option>";
			
			
			
			
			
			
		}
		?>
        </select>
      &nbsp;
      <select name="ciudades" id="ciudades" style="font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C">
        <option selected value='todas' style='font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C'>Todas las ciudades</option>
        <option value='Fuera del país'style='font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C'>Fuera del país</option>
        <?
		
		//-----EXCLUYENDO CATEGORIA ADULTOS
	$cat=new Categoria(160);
	$hijos=$cat->hijos();
	
	$parche="";
	for ($i=0;$i<count($hijos);$i++)
		$parche.=" AND id_categoria<>".$hijos[$i];
	//-----------
		
		
	  	$query=operacionSQL("SELECT ciudad,COUNT(*) FROM Anuncio WHERE status_general='Activo' AND ciudad<>'Fuera del país' ".$parche." GROUP BY ciudad ORDER BY ciudad ASC");
				
		for ($i=0;$i<mysql_num_rows($query);$i++)
			echo "<option value='".mysql_result($query,$i,0)."' style='font-size:15px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C'>".mysql_result($query,$i,0)."</option>";
		
	  ?>
      </select>
      &nbsp;
      <label>
        <input type="button" name="button" id="button" value="Buscar" onClick="listarRecientes()" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
      </label></td>
    </tr>
</table>

<div style="margin:0 auto 0 auto; width:800px; margin-bottom:50px;" id="anuncios_recientes">

<?
	
	$aux="SELECT id FROM Anuncio WHERE id_pais='".$pais->id."' AND status_general='Activo' ".$parche." ORDER BY fecha DESC LIMIT 0,20";
	$query=operacionSQL($aux);
	$total=mysql_num_rows($query);	
	
	for ($i=0;$i<$total;$i++)
	{	
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
		
		$anuncio=new Anuncio(mysql_result($query,$i,0));		
		echo $anuncio->armarAnuncio($colorete);
	}
	
?>

</div>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>


</body>
</html>
