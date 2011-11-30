<?
	session_start();
	
	include "lib/class.php";
	
	
	if (isset($_SESSION['nick_gestion'])==false)
		echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='index.php';			
			</SCRIPT>";
	
	
	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);
			
	
	$barra=barraPrincipal("");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
			
//--------------------------------------------------------------------------------------------------------

	$url_actual="listado.php?";
	
	
	$aux="SELECT id FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
	$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo' AND (id=99999999";	
	$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
	
	
	
	if ($_GET['id_cat']!="")
	{
		$url_actual.="id_cat=".$_GET['id_cat'];		
		$id_cat=$_GET['id_cat'];
		
		
		if (($id_cat==4)||($id_cat==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		{
			$aux="SELECT id FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";	
			$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
		}
		
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{
			$aux="SELECT id FROM Anuncio,Anuncio_Detalles_Vehiculos  WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos  WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";	
			$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_marca="SELECT marca,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_anio="SELECT anio,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_modelo="SELECT modelo,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
		}
		
		
		$categoria=new Categoria($id_cat);
		$hijos=$categoria->hijos();		
		
		for ($i=0;$i<count($hijos);$i++)
		{
			$aux.=" OR id_categoria=".$hijos[$i];
			$aux_tipo.=" OR id_categoria=".$hijos[$i];
			$aux_ciudad.=" OR id_categoria=".$hijos[$i];
			$aux_marca.=" OR id_categoria=".$hijos[$i];
			$aux_anio.=" OR id_categoria=".$hijos[$i];
			$aux_modelo.=" OR id_categoria=".$hijos[$i];
		}
	}
	if ($_GET['tipo']!="")
	{
		$url_actual.="&tipo=".$_GET['tipo'];		
		$aux.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_tipo.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_ciudad.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_marca.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_anio.=") AND (tipo_categoria='".$_GET['tipo']."'";
		$aux_modelo.=") AND (tipo_categoria='".$_GET['tipo']."'";
		
	}
	if ($_GET['ciudad']!="")
	{
		$url_actual.="&ciudad=".$_GET['ciudad'];
		$aux.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_tipo.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_ciudad.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_marca.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_anio.=") AND (ciudad='".$_GET['ciudad']."'";
		$aux_modelo.=") AND (ciudad='".$_GET['ciudad']."'";
	}
	if ($_GET['m2']!="")
	{
		$url_actual.="&m2=".$_GET['m2'];
		
		if ($_GET['m2']=="menos50")	$aux_aux=") AND (m2<50";
		if ($_GET['m2']=="50-100")	$aux_aux=") AND (m2>=50) AND (m2<=100";
		if ($_GET['m2']=="100-150")	$aux_aux=") AND (m2>=100) AND (m2<=150";
		if ($_GET['m2']=="150-200")	$aux_aux=") AND (m2>=150) AND (m2<=200";
		if ($_GET['m2']=="200-250")	$aux_aux=") AND (m2>=200) AND (m2<=250";
		if ($_GET['m2']=="250-300")	$aux_aux=") AND (m2>=250) AND (m2<=300";
		if ($_GET['m2']=="mas300")	$aux_aux=") AND (m2>50";
		
		
		$aux.=$aux_aux;
		$aux_tipo.=$aux_aux;
		$aux_ciudad.=$aux_aux;
	}
	if ($_GET['hab']!="")
	{
		$url_actual.="&hab=".$_GET['hab'];
		
		if ($_GET['hab']=="1")	$aux_aux=") AND (habitaciones=1";
		if ($_GET['hab']=="2")	$aux_aux=") AND (habitaciones=2";
		if ($_GET['hab']=="3")	$aux_aux=") AND (habitaciones=3";
		if ($_GET['hab']=="4")	$aux_aux=") AND (habitaciones=4";
		if ($_GET['hab']=="5")	$aux_aux=") AND (habitaciones=5";
		if ($_GET['hab']=="mas5")	$aux_aux=") AND (habitaciones>5";
		
		
		$aux.=$aux_aux;
		$aux_tipo.=$aux_aux;
		$aux_ciudad.=$aux_aux;
	}
	if ($_GET['marca']!="")
	{
		$url_actual.="&marca=".$_GET['marca'];
		
		$aux.=") AND (marca='".$_GET['marca']."'";
		$aux_tipo.=") AND (marca='".$_GET['marca']."'";
		$aux_ciudad.=") AND (marca='".$_GET['marca']."'";
		$aux_marca.=") AND (marca='".$_GET['marca']."'";
		$aux_anio.=") AND (marca='".$_GET['marca']."'";
		$aux_modelo.=") AND (marca='".$_GET['marca']."'";
		
	}
	if ($_GET['anio']!="")
	{
		$url_actual.="&anio=".$_GET['anio'];
		
		$aux.=") AND (anio=".$_GET['anio'];
		$aux_tipo.=") AND (anio=".$_GET['anio'];
		$aux_ciudad.=") AND (anio=".$_GET['anio'];
		$aux_marca.=") AND (anio=".$_GET['anio'];
		$aux_anio.=") AND (anio=".$_GET['anio'];
		$aux_modelo.=") AND (anio=".$_GET['anio'];
	}
	if ($_GET['modelo']!="")
	{
		$url_actual.="&modelo=".$_GET['modelo'];
		
		$aux.=") AND (modelo='".$_GET['modelo']."'";
		$aux_tipo.=") AND (modelo='".$_GET['modelo']."'";
		$aux_ciudad.=") AND (modelo='".$_GET['modelo']."'";
		$aux_marca.=") AND (modelo='".$_GET['modelo']."'";
		$aux_anio.=") AND (modelo='".$_GET['modelo']."'";
		$aux_modelo.=") AND (modelo='".$_GET['modelo']."'";
	}
	
	$aux.=") ORDER BY fecha DESC";
	$aux_tipo.=") GROUP BY tipo_categoria ORDER BY C DESC";
	$aux_ciudad.=") GROUP BY ciudad ORDER BY ciudad ASC";
	//echo "<br><br>";
	$aux_marca.=") GROUP BY marca ORDER BY marca ASC";
	//echo "<br><br>";
	$aux_anio.=") GROUP BY anio ORDER BY anio DESC";
	$aux_modelo.=") GROUP BY modelo ORDER BY modelo ASC";
			
			
			
	
	
//-----------------------------------------------------------------------------------------------	
	if ($_GET['id_cat']==NULL)
	{		
		$aux="SELECT id FROM Anuncio WHERE status_general='Activo'";
		$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo'";
		
		if ($_GET['ciudad']!="")
			$aux.=" AND ciudad='".$_GET['ciudad']."'";
		
		$aux.=" ORDER BY fecha DESC";
	}	
	
	
	$query=operacionSQL($aux);
	//METIENDO TODOS LOS ANUNCIOS EN UN VECTOR
	for ($i=0;$i<mysql_num_rows($query);$i++)
		$anuncios[$i]=mysql_result($query,$i,0);
	


 


//--------------------------------CASO DE CATEGORIAS Y BUSQUEDA - FACIL---------------------------------------
	if (($_GET['id_cat']!="")&&($_GET['buscar']!=""))
	{
		$url_actual.="&buscar=".$_GET['buscar'];
		
		$aux="SELECT id FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
		$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo' AND (id=99999999";	
		$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
																								 
																								 
		if (($id_cat==4)||($id_cat==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		{
			$aux="SELECT id FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";	
			$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Inmuebles WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
		}		
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{
			$aux="SELECT id FROM Anuncio,Anuncio_Detalles_Vehiculos  WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_tipo="SELECT tipo_categoria,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos  WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";	
			$aux_ciudad="SELECT ciudad,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_marca="SELECT marca,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_anio="SELECT anio,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
			$aux_modelo="SELECT modelo,COUNT(*) AS C FROM Anuncio,Anuncio_Detalles_Vehiculos WHERE id=id_anuncio AND status_general='Activo' AND (id=99999999";
		}

		
		$anuncios=buscar($anuncios,$_GET['buscar']);
		
		
		//QUE BARBARIDAD
		if (count($anuncios)>0)
		{
			for ($i=0;$i<count($anuncios);$i++)
			{
				$aux.=" OR id=".$anuncios[$i];
				$aux_tipo.=" OR id=".$anuncios[$i];
				$aux_ciudad.=" OR id=".$anuncios[$i];
			}
		}
		
		
		$aux.=") ORDER BY fecha DESC";
		$aux_tipo.=") GROUP BY tipo_categoria ORDER BY C DESC";
		$aux_ciudad.=") GROUP BY ciudad ORDER BY ciudad ASC";
	}
//----------------------------------------------------------------------------------------------	
	
	if (($_GET['id_cat']==NULL)&&($_GET['buscar']!=""))
	{
		$url_actual.="&buscar=".$_GET['buscar'];
		
		$anuncios=buscar($anuncios,$_GET['buscar']);
		
		if ($_GET['ciudad']==NULL)
		{
			if (count($anuncios)>0)
			{
				$aux_ciudad.=" AND (id=9999999 ";
				for ($i=0;$i<count($anuncios);$i++)
					$aux_ciudad.=" OR id=".$anuncios[$i];
			}
			$aux_ciudad.=") GROUP BY ciudad";
		}		
	}
	if (($_GET['id_cat']==NULL)&&($_GET['ciudad']==NULL)&&($_GET['buscar']==NULL))
		$aux_ciudad.=" GROUP BY ciudad";





	
	
//--------------------------------------------------------
	if ($_GET['factor']=="")
		$factor=30;
	else
	{
		$factor=$_GET['factor'];
		$url_actual.="&factor=".$_GET['factor'];
	}	
	if ($_GET['parte']=="")
		$parte=1;
	else
		$parte=$_GET['parte'];
//---------------------------------------------------------





	
//----------------------------------------------ARMANDO TITULO--------------------------
	$titulo="Anuncios clasificados";
	if ($_GET['id_cat']!="")
	{
		$titulo.=", ";
		
		$arbol=$categoria->arbolDeHoja();
		for ($i=count($arbol)-1;$i>=0;$i--)
			$titulo.=$arbol[$i]['nombre']." - ";
			
		$titulo=substr($titulo,0,strlen($titulo)-3);
	}	
	
	if ($_GET['tipo']!="") $titulo.=", ".$_GET['tipo'];
	if ($_GET['ciudad']!="") $titulo.=", ".$_GET['ciudad']; else $titulo.=", Venezuela"
//------------------------------------------------------------------------------------------	
	
	
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<title><? echo $titulo ?></title>



<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<meta name="description" content="<? echo $titulo ?>">

<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">


<SCRIPT LANGUAGE="JavaScript" src="lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/favoritos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/basicos.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="lib/js/InnerDivMod.js"></SCRIPT>

<SCRIPT LANGUAGE="JavaScript">

function verMasCiudades()
{
	posicion=posicionElemento("listadoCiudades_html");
	INNERDIV_MOD.newInnerDiv('listadoCiudades',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaCiudades').value,'Ver todas las ciudades');
}
function verMasModelos()
{
	posicion=posicionElemento("listadoModelos_html");
	INNERDIV_MOD.newInnerDiv('listadoModelos',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaModelos').value,'Ver todos los modelos');
}
function verMasAnios()
{
	posicion=posicionElemento("listadoAnios_html");
	INNERDIV_MOD.newInnerDiv('listadoAnios',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaAnios').value,'Ver todos los a�os');
}

function verMasMarcas()
{
	posicion=posicionElemento("listadoMarcas_html");
	INNERDIV_MOD.newInnerDiv('listadoMarcas',posicion['left'],posicion['top']+15,200,140,document.getElementById('listaMarcas').value,'Ver todos las marcas');
}


function accionBuscar()
{
	if ((document.getElementById("buscar").value=="�Qu� estas buscando?")||(document.getElementById("buscar").value==""))
		window.alert("Debes indicar un t�rmino de b�squeda v�lido");
	else
	{
		url=document.getElementById("url_actual").value;	

		if (url.indexOf("buscar=")==-1)			
			url=url+"&buscar="+document.getElementById("buscar").value
		else
			url=url.replace("buscar="+document.getElementById("busqueda_actual").value,"buscar="+document.getElementById("buscar").value)
		
		document.location.href=url;
	}
}

function manejoBusqueda(donde)
{
	//window.alert(document.getElementById("buscar").value);
	if (donde=="adentro")
		if (document.getElementById("buscar").value=="�Qu� estas buscando?")
			document.getElementById("buscar").value="";
	
	if (donde=="afuera")
		if (document.getElementById("buscar").value=="")
			document.getElementById("buscar").value="�Qu� estas buscando?";
}

function validar(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) accionBuscar();
}



function gestionProcesar(accion)
{
	document.Forma.action="gestion_accion.php?accion="+accion;
	document.Forma.submit();
}

</SCRIPT>
</head>
<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="295" align="left"><a href="/"><img src="img/logo_290.JPG" alt="" width="290" height="46" border="0"></a></td>
    <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></td>
    <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Secci�n en construcci�n')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
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
    <td><input type="hidden" name="listaCiudades" id="listaCiudades">
    <input type="hidden" name="listaModelos" id="listaModelos">
    <input type="hidden" name="listaAnios" id="listaAnios">
    <input type="hidden" name="listaMarcas" id="listaMarcas"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td width="800" valign="bottom" align="left" class="arial13Negro"><? 

	if ($_GET['id_cat']!="")
	{
		$categoria=new Categoria($_GET['id_cat']);
		$arbol=$categoria->arbolDeHoja();
		$niveles=count($arbol);
	}	
	
	echo "<a class='LinkFuncionalidad13' href='/'><b>Inicio</b></a>";
	echo " &raquo; ";
	
	for ($i=($niveles-1);$i>=0;$i--)
	{
		echo "<a class='LinkFuncionalidad13' href='listado.php?id_cat=".$arbol[$i]['id']."'><b>".$arbol[$i]['nombre']."</b></a>";
		if ($i>0)
			echo " &raquo; ";
	}
	
	?></td>
  </tr>
</table>
<table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor="#C8C8C8">
  <tr>
    <td height="1"></td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <?
		
			if ($_GET['id_cat']!="")
			{
				$query_aux=operacionSQL($aux);
				for ($i=0;$i<mysql_num_rows($query_aux);$i++)
				{
					$anuncio=new Anuncio(mysql_result($query_aux,$i,0));
					$cuenta[$anuncio->id_categoria]=$cuenta[$anuncio->id_categoria]+1;		
				}
				
				$id_cat=$_GET['id_cat'];
				$categoria=new Categoria($id_cat);
				
				$hijos=$categoria->hijosInmediatos();
				for ($i=0;$i<count($hijos);$i++)
				{
					$categoria_aux=new Categoria($hijos[$i]);
					if ($categoria_aux->esHoja()==false)
					{
						$hijitos=$categoria_aux->hijosInmediatos();
						for ($e=0;$e<count($hijitos);$e++)
						{
							$cuenta[$categoria_aux->id]=$cuenta[$categoria_aux->id]+$cuenta[$hijitos[$e]];	
						}
					}
				}
				
				
				
				if (count($hijos)>0)
					echo "<td width='300' align='left' valign='top' class='arial12Negro'>Subcategorias:<br>";
				
				for ($i=0;$i<count($hijos);$i++)
				{					
					$categoria_aux=new Categoria($hijos[$i]);
					//echo $categoria_aux->nombre."<br>";
					if ($categoria_aux->anunciosActivos()>0)
						if ($cuenta[$categoria_aux->id]>0)
						{
							$url=str_replace("id_cat=".$_GET['id_cat'],"id_cat=".$hijos[$i],$url_actual);
							echo "&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".$categoria_aux->nombre." (".$cuenta[$categoria_aux->id].")</a><br>";
						}
				}
				
				if (count($hijos)>0)
					echo "</td>";		 
			 }
			 else
			 {
				 echo "<td width='300' align='left' valign='top' class='arial12Negro'>Categor�as:<br>";
				 for ($i=0;$i<count($anuncios);$i++)
				 {
					 $anuncio=new Anuncio($anuncios[$i]);
					 $id_cat_aux=$anuncio->id_categoria;
					 $cat=new Categoria($id_cat_aux);
					 $id_cat_aux=$cat->patriarca();
					 $cuenta[$id_cat_aux]=$cuenta[$id_cat_aux]+1;					 
				 }
				 
				arsort($cuenta);
				while (list($i,$valor)=each($cuenta))
				{
					$cat=new Categoria($i);
					echo "&raquo; <a href='".$url_actual."&id_cat=".$cat->id."' class='LinkFuncionalidad12'>".$cat->nombre." (".$valor.")</a><br>";
				}
				 
				 
				echo "</td>";
				 
				 
			 }
	
		?>
    <td width="203" height="18" align="left" valign="top" class="arial12Negro"><? 
	
	if ($_GET['id_cat']!="")
	{
		if ($_GET['tipo']!="")
		{
			$url=str_replace("tipo=".$_GET['tipo'],"",$url_actual);
			echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
				  <tr>
					<td align='left' valign='bottom' class='arial12Gris'><strong>Tipo: ".$_GET['tipo']." <a href='".$url."'><img src='img/Windows-Close-Program-16x16.png' width='13' height='13' alt='Eliminar filtro' border='0'></a></strong></td>
					</tr>
				</table>";
		}
		else
		{
			echo "Tipos:<br>";
		
			$query_tipo=operacionSQL($aux_tipo);
			
			for ($i=0;$i<mysql_num_rows($query_tipo);$i++)
			{
				$url=$url_actual."&tipo=".mysql_result($query_tipo,$i,0);				
				echo "&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_tipo,$i,0)." (".mysql_result($query_tipo,$i,1).")</a><br>";
			}
		}
	}
	
	
		
		
		
			//-----------------CASO DETALLES: CARROS
			if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
			{				
				if ($_GET['anio']!="")
				{			
					$url=str_replace("anio=".$_GET['anio'],"",$url_actual);
					echo "<br><table width='100%' border='0' cellpadding='0' cellspacing='0'>
							  <tr>
								<td align='left' valign='bottom' class='arial12Gris'><strong>A�o: ".$_GET['anio']." <a href='".$url."'><img src='img/Windows-Close-Program-16x16.png' width='13' height='13' alt='Eliminar filtro' border='0'></a></strong></td>
								</tr>
							</table>";
				}
				else
				{
					echo "<br><span id='listadoAnios_html'>A�o:</span><br>";
					
					
					
					//echo $aux_anio."<br><br><br>";
					
					$query_anio=operacionSQL($aux_anio);
					for ($i=0;$i<mysql_num_rows($query_anio);$i++)
						$anios.="&raquo; <a href='".$url_actual."&anio=".mysql_result($query_anio,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_anio,$i,0)." (".mysql_result($query_anio,$i,1).")</a><br>";
						
					echo "<SCRIPT LANGUAGE='JavaScript'>
						document.getElementById('listaAnios').value='".str_replace("'",'"',$anios)."';					
				</SCRIPT>";
				
					if (mysql_num_rows($query_anio)<=7)
						echo $anios;
					else
					{
						for ($i=0;$i<7;$i++)
							echo "&raquo; <a href='".$url_actual."&anio=".mysql_result($query_anio,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_anio,$i,0)." (".mysql_result($query_anio,$i,1).")</a><br>";
							
						echo "&raquo; <a href='javascript:verMasAnios()' class='LinkRojo13'><i>Ver mas a�os</i></a><br>";
					}				
				}
			}
		
	?></td>
    <td width="190" align="left" valign="top" class="arial12Negro">
      <?	
			
			//------------------CASO CIUDADES
			if ($_GET['ciudad']!="")
			{
				$url=str_replace("ciudad=".$_GET['ciudad'],"",$url_actual);
				echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
					  <tr>
						<td align='left' valign='bottom' class='arial12Gris'><strong>Ciudad: ".$_GET['ciudad']." <a href='".$url."'><img src='img/Windows-Close-Program-16x16.png' width='13' height='13' alt='Eliminar filtro' border='0'></a></strong></td>
						</tr>
					</table>";
			}
			else
			{			
				echo "<span id='listadoCiudades_html'>Ciudades:</span><br>";				
				
				
				//echo $aux_ciudad."<br><br><br><br>";
				$query_ciudad=operacionSQL($aux_ciudad);
				
				
				for ($i=0;$i<mysql_num_rows($query_ciudad);$i++)
				{	
						$url=$url_actual."&ciudad=".mysql_result($query_ciudad,$i,0);				
						$ciudades.="&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_ciudad,$i,0)." (".mysql_result($query_ciudad,$i,1).")</a><br>";		
				}
				echo "<SCRIPT LANGUAGE='JavaScript'>
						document.getElementById('listaCiudades').value='".str_replace("'",'"',$ciudades)."';					
				</SCRIPT>";
					
					
				if (mysql_num_rows($query_ciudad)<=7)
					echo $ciudades;
				else
				{
					for ($i=0;$i<7;$i++)
					{	
						$url=$url_actual."&ciudad=".mysql_result($query_ciudad,$i,0);				
						$ciudades_7.="&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_ciudad,$i,0)." (".mysql_result($query_ciudad,$i,1).")</a><br>";		
					}
					echo $ciudades_7;
					echo "&raquo; <a href='javascript:verMasCiudades()' class='LinkRojo13'><i>Ver mas ciudades</i></a><br>";
				}			
			}
			
			
	
	?></td>
    <td width="215" align="left" valign="top" class="arial12Negro">    <?
		
		
		
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{

			if ($_GET['marca']!="")
			{			

				$url=str_replace("marca=".$_GET['marca'],"",$url_actual);
				echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
						  <tr>
							<td align='left' valign='bottom' class='arial12Gris'><strong>Marca: ".$_GET['marca']." <a href='".$url."'><img src='img/Windows-Close-Program-16x16.png' width='13' height='13' alt='Eliminar filtro' border='0'></a></strong></td>
							</tr>
						</table>";
			}
			else
			{
				echo "<span id='listadoMarcas_html'>Marca:</span><br>";
	
				$query_marca=operacionSQL($aux_marca);
				for ($i=0;$i<mysql_num_rows($query_marca);$i++)
					$marcas.="&raquo; <a href='".$url_actual."&marca=".mysql_result($query_marca,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_marca,$i,0)." (".mysql_result($query_marca,$i,1).")</a><br>";
			
				echo "<SCRIPT LANGUAGE='JavaScript'>
						document.getElementById('listaMarcas').value='".str_replace("'",'"',$marcas)."';					
				</SCRIPT>";
				
				
				
				if (mysql_num_rows($query_marca)<=7)
					echo $marcas;
				else
				{
					for ($i=0;$i<7;$i++)
						echo "&raquo; <a href='".$url_actual."&marca=".mysql_result($query_marca,$i,0)."' class='LinkFuncionalidad12'>".mysql_result($query_marca,$i,0)." (".mysql_result($query_marca,$i,1).")</a><br>";
					
					echo "&raquo; <a href='javascript:verMasMarcas()' class='LinkRojo13'><i>Ver mas marcas</i></a><br>";
				}
			}
		}
		
		
		
		
		
				//-----------------CASO DETALLES: OTROS INMUEBLES
		if (($_GET['id_cat']==4)||($_GET['id_cat']==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		{
			if ($_GET['m2']!="")
			{
				if ($_GET['m2']=="menos50")	$leyenda="menos de 50 m2";
				if ($_GET['m2']=="50-100")	$leyenda="50 - 100 m2";
				if ($_GET['m2']=="100-150")	$leyenda="100 - 150 m2";
				if ($_GET['m2']=="150-200")	$leyenda="150 - 200 m2";
				if ($_GET['m2']=="200-250")	$leyenda="200 - 250 m2";
				if ($_GET['m2']=="250-300")	$leyenda="250 - 300 m2";
				if ($_GET['m2']=="mas300")	$leyenda="mas de 300 m2";

				
				$url=str_replace("m2=".$_GET['m2'],"",$url_actual);
				echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
					  <tr>
						<td align='left' valign='bottom' class='arial12Gris'><strong>Superficie: ".$leyenda." <a href='".$url."'><img src='img/Windows-Close-Program-16x16.png' width='13' height='13' alt='Eliminar filtro' border='0'></a></strong></td>
						</tr>
					</table>";
			}
			else
			{			
								
				echo "Superficie:<br>";
				
				$aux_aux=str_replace("WHERE","WHERE m2<50 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "&raquo; <a href='".$url_actual."&m2=menos50' class='LinkFuncionalidad12'>menos de 50 m2 (".mysql_num_rows($query_aux).")</a><br>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>=50 AND m2<=100 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "&raquo; <a href='".$url_actual."&m2=50-100' class='LinkFuncionalidad12'>50 - 100 m2 (".mysql_num_rows($query_aux).")</a><br>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>=100 AND m2<=150 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "&raquo; <a href='".$url_actual."&m2=100-150' class='LinkFuncionalidad12'>100 - 150 m2 (".mysql_num_rows($query_aux).")</a><br>";
			
				$aux_aux=str_replace("WHERE","WHERE m2>=150 AND m2<=200 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "&raquo; <a href='".$url_actual."&m2=150-200' class='LinkFuncionalidad12'>150 -200 m2 (".mysql_num_rows($query_aux).")</a><br>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>=200 AND m2<=300 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "&raquo; <a href='".$url_actual."&m2=200-300' class='LinkFuncionalidad12'>200 - 300 m2 (".mysql_num_rows($query_aux).")</a><br>";
				
				$aux_aux=str_replace("WHERE","WHERE m2>300 AND",$aux);
				$query_aux=operacionSQL($aux_aux);
				if (mysql_num_rows($query_aux)>0)
					echo "&raquo; <a href='".$url_actual."&m2=mas300' class='LinkFuncionalidad12'>mas de 300 m2 (".mysql_num_rows($query_aux).")</a><br>";
		
			}
		
		}

		
		
		
	?></td>
    <td width="192" align="left" valign="top" class="arial12Negro"><?
    
	
			//-----------------CASO DETALLES: CARROS
		if ($_GET['marca']!="")
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{
			if ($_GET['modelo']!="")
			{
				$url=str_replace("modelo=".$_GET['modelo'],"",$url_actual);
				echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
					  <tr>
						<td align='left' valign='bottom' class='arial12Gris'><strong>Modelo: ".$_GET['modelo']." <a href='".$url."'><img src='img/Windows-Close-Program-16x16.png' width='13' height='13' alt='Eliminar filtro' border='0'></a></strong></td>
						</tr>
					</table>";
			}
			else
			{			
				echo "<span id='listadoModelos_html'>Modelo:</span><br>";
				
				$query_modelo=operacionSQL($aux_modelo);
				for ($i=0;$i<mysql_num_rows($query_modelo);$i++)
				{	
					$url=$url_actual."&modelo=".mysql_result($query_modelo,$i,0);				
					$modelos.="&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_modelo,$i,0)." (".mysql_result($query_modelo,$i,1).")</a><br>";			
				}
				
				echo "<SCRIPT LANGUAGE='JavaScript'>
						document.getElementById('listaModelos').value='".str_replace("'",'"',$modelos)."';					
				</SCRIPT>";				
				
				if (mysql_num_rows($query_modelo)<=7)
					echo $modelos;
				else
				{
					for ($i=0;$i<7;$i++)
					{	
						$url=$url_actual."&modelo=".mysql_result($query_modelo,$i,0);				
						echo "&raquo; <a href='".$url."' class='LinkFuncionalidad12'>".mysql_result($query_modelo,$i,0)." (".mysql_result($query_modelo,$i,1).")</a><br>";			
					}
					echo "&raquo; <a href='javascript:verMasModelos()' class='LinkRojo13'><i>Ver mas modelos</i></a><br>";
				}				
			}
		}
		
		
		
			//-----------------CASO DETALLES: CASAS-APTOS
			if (($id_cat==4)||($id_cat==3))
			{
				if ($_GET['hab']!="")
				{
					if ($_GET['hab']=="1")		$leyenda="1 habitaci�n";
					if ($_GET['hab']=="2")		$leyenda="2";
					if ($_GET['hab']=="3")		$leyenda="3";
					if ($_GET['hab']=="4")		$leyenda="4";
					if ($_GET['hab']=="5")		$leyenda="5";
					if ($_GET['hab']=="mas5")	$leyenda="mas de 5";
	
					
					$url=str_replace("hab=".$_GET['hab'],"",$url_actual);
					echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>
						  <tr>
							<td align='left' valign='bottom' class='arial12Gris'><strong>Habitaciones: ".$leyenda." <a href='".$url."'><img src='img/Windows-Close-Program-16x16.png' width='13' height='13' alt='Eliminar filtro' border='0'></a></strong></td>
							</tr>
						</table>";
				}
				else
				{				
					echo "Habitaciones:<br>";
					
					$aux_aux=str_replace("WHERE","WHERE habitaciones=1 AND",$aux);
					$query_aux=operacionSQL($aux_aux);
					if (mysql_num_rows($query_aux)>0)
						echo "&raquo; <a href='".$url_actual."&hab=1' class='LinkFuncionalidad12'>1 habitaci�n (".mysql_num_rows($query_aux).")</a><br>";					
					
					$aux_aux=str_replace("WHERE","WHERE habitaciones=2 AND",$aux);
					$query_aux=operacionSQL($aux_aux);
					if (mysql_num_rows($query_aux)>0)
						echo "&raquo; <a href='".$url_actual."&hab=2' class='LinkFuncionalidad12'>2 habitaciones (".mysql_num_rows($query_aux).")</a><br>";
					
					$aux_aux=str_replace("WHERE","WHERE habitaciones=3 AND",$aux);
					$query_aux=operacionSQL($aux_aux);
					if (mysql_num_rows($query_aux)>0)
						echo "&raquo; <a href='".$url_actual."&hab=3' class='LinkFuncionalidad12'>3 habitaciones (".mysql_num_rows($query_aux).")</a><br>";
					
					$aux_aux=str_replace("WHERE","WHERE habitaciones=4 AND",$aux);
					$query_aux=operacionSQL($aux_aux);
					if (mysql_num_rows($query_aux)>0)
						echo "&raquo; <a href='".$url_actual."&hab=4' class='LinkFuncionalidad12'>4 habitaciones (".mysql_num_rows($query_aux).")</a><br>";
					
					$aux_aux=str_replace("WHERE","WHERE habitaciones=5 AND",$aux);
					$query_aux=operacionSQL($aux_aux);
					if (mysql_num_rows($query_aux)>0)
						echo "&raquo; <a href='".$url_actual."&hab=5' class='LinkFuncionalidad12'>5 habitaciones (".mysql_num_rows($query_aux).")</a><br>";
					
					$aux_aux=str_replace("WHERE","WHERE habitaciones>5 AND",$aux);
					$query_aux=operacionSQL($aux_aux);
					if (mysql_num_rows($query_aux)>0)
						echo "&raquo; <a href='".$url_actual."&hab=mas5' class='LinkFuncionalidad12'>mas de 5 habitaciones (".mysql_num_rows($query_aux).")</a><br>";
			
				}
			
			}
	
	?></td>
    

  </tr>
</table>
<table width="800" border="0" align="center" cellspacing="2">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right" class="arial13Negro">&nbsp;</td>
  </tr>
</table>
<table width="800" height="30" border="0" align="center" cellpadding="4" cellspacing="0" bgcolor="#D8E8AE"; style="border-collapse:collapse " >
  <tr>
    <td width="497" align="left" valign="middle" class="arial13Mostaza"><input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event)" id="buscar" style="font-size:12px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C" value="<? if ($_GET['buscar']!="") echo $_GET['buscar']; else echo "�Qu� estas buscando?" ?>" size="30">
      <label>
        <input type="button" name="button" id="button" value="Buscar" onClick="accionBuscar()" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; font-weight:bold;">
        <input type="hidden" name="url_actual" id="url_actual" value="<? echo $url_actual ?>">
        <input type="hidden" name="busqueda_actual" id="busqueda_actual" value="<? echo $_GET['buscar'] ?>">
    </label></td>
    <td width="287" align="right" valign="middle" class="arial12Negro"><b>
      <?
	
	$primero=$factor*($parte-1);
	$ultimo=$primero+$factor;
	
	if ($ultimo>count($anuncios))
		$ultimo=count($anuncios);	
		
		
	echo ($primero+1)." - ".$ultimo. " de ".count($anuncios);
	
	?>
    </b></td>
  </tr>
</table><form name="Forma"  method="POST" action="">
<?	
	
	$id_anuncios="";
	for ($i=$primero;$i<$ultimo;$i++)
	{		
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
			
		$anuncio=new Anuncio($anuncios[$i]);		
		echo $anuncio->armarAnuncioGestion($colorete);
		
		
		
		
		$id_anuncios.=$anuncio->id.";";
	}
	
	if (count($anuncios)==0)
		echo "<table width='800' border='0' align='center' cellspacing='0'>
			  <tr>
				<td align='center' class='arial13Gris'><b>no se encontraron resultados para tu b&uacute;squeda</b></td>
			  </tr>
			</table>";
	
?>

<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><label><span class="arial13Mostaza">
      <select name="categorias" id="categorias" style="font-size:12px; font-family:Arial, Helvetica, sans-serif">
        
        <?
	  	$aux="SELECT id,nombre FROM Categoria WHERE id_pais='".$id_pais."' AND id_categoria IS NULL";
		$query=operacionSQL($aux);
		$total=mysql_num_rows($query);	
		
		for ($i=0;$i<$total;$i++)
		{
			$categoria=new Categoria(mysql_result($query,$i,0));
			
			echo "<option value='".mysql_result($query,$i,0)."' >&raquo; ".mysql_result($query,$i,1)."</option>";
			
			
			
			$query2=operacionSQL("SELECT nombre,id FROM Categoria WHERE id_categoria=".mysql_result($query,$i,0)." ORDER BY orden ASC");
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$id_sub_categoria=mysql_result($query2,$e,1);
				$sub_nombre=mysql_result($query2,$e,0);
				
				$categoria=new Categoria($id_sub_categoria);
				echo "<option value='".$id_sub_categoria."'>&raquo;&raquo;&raquo;&raquo; ".$sub_nombre."</option>";
				
				
				$aux="SELECT nombre,id FROM Categoria WHERE id_categoria=".$id_sub_categoria." ORDER BY orden ASC";
				$query3=operacionSQL($aux);
				for ($j=0;$j<mysql_num_rows($query3);$j++)
				{
					$id_sub_categoria=mysql_result($query3,$j,1);
					$sub_nombre=mysql_result($query3,$j,0);
					
					$categoria=new Categoria($id_sub_categoria);
					echo "<option value='".$id_sub_categoria."'>&raquo;&raquo;&raquo;&raquo;&raquo;&raquo;&raquo; ".$sub_nombre."</option>";
					
				}
				
			}
			
			
		}
		?>
      </select>
    </span><br>
      <input type="button" name="button2" id="button2" value="Cambiar categoria" onClick="gestionProcesar('cambiar_categoria')">
    </label></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><input type="hidden" name="anuncios" id="anuncios" value="<? echo $id_anuncios ?>"></td>
  </tr>
</table>
</form>
<div align="center">
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="8">
    <tr>
      <td align="center" class="Arial13Negro2"></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" class="Arial13Negro2"></td>
    </tr>
  </table>
</div>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><?
		
	if (count($anuncios)>0)
	{			
		$total=count($anuncios);
		$resto=$total%$factor;
		$entero=(int)($total/$factor);		
		
		//if ($_GET['id_cat']!="")
			//$actual="listado.php?id_cat=".$id_cat; 
		$actual=$url_actual;
		
		//cuando aparece el link anterior
		if ((($entero>1)||(($entero==1)&&($resto>0)))&&($parte!="1"))
			echo "<a href='".$actual."&parte=".($parte-1)."&factor=".$factor."' class='LinkFuncionalidad12'><< Anterior</a> | ";
		
		for ($i=0;$i<$entero;$i++)
		{
			$primero=($i*$factor)+1;
			$ultimo=($i+1)*$factor;
			
			$mostrar_aux=($i+1)."_".$factor;
						
			if (($i+1)!=$parte)
				echo "<a href='".$actual."&parte=".($i+1)."&factor=".$factor."' class='LinkFuncionalidad12'>".$primero." - ".$ultimo."</a>";
			else
				echo "<span class='arial12Negro'>".$primero." - ".$ultimo."</span>";
			
			if (!(($resto==0)&&(($i+1)==$entero)))
				echo " | ";
		}
		
		if ($resto>0)
		{	
			$primero=($i)*($factor+1);
			$ultimo=$total;
			
			$mostrar_aux=($i+1)."_".$mostrar['factor'];
						
			if (($i+1)!=$parte)
				echo "<a href='".$actual."&parte=".($i+1)."&factor=".$factor."' class='LinkFuncionalidad12'>".$primero." - ".$ultimo."</a>";
			else
				echo "<span class='arial12Negro'>".$primero." - ".$ultimo."</span>";
		}
	}
	
	if ($parte<($i))
		echo " | <a href='".$actual."&parte=".($parte+1)."&factor=".$factor."' class='LinkFuncionalidad12'>Siguiente >></a>";
	
	?></td>
  </tr>
</table>
<table width="400" border="0" align="center" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF">
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
</body>
</html>