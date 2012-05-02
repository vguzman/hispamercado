<?
	session_start();
	set_time_limit(0);
	
	header ("Cache-Control: no-cache, must-revalidate");
	header('Content-Type: text/html; charset=iso-8859-1');
	
	include "lib/class.php";
		
	$id_cat=$_GET['id_cat'];
	$ciudad=$_GET['ciudad'];
	$buscar=$_GET['buscar'];
		
	$url="listado.php?";
	
	if ($id_cat!="todas")
	{
		$url.="id_cat=".$id_cat;
		$aux="SELECT id FROM Anuncio WHERE status_general='Activo' AND (id=99999999";
		
		$categoria=new Categoria($id_cat);
		$hijos=$categoria->hijos();		
		
		for ($i=0;$i<count($hijos);$i++)
			$aux.=" OR id_categoria=".$hijos[$i];
	}
	else
	{
		$aux="SELECT id FROM Anuncio WHERE status_general='Activo' AND (id>=0";
	}
	
	if ($ciudad!="todas")
	{
		$url.="&ciudad=".$ciudad;
		$aux.=" ) AND ciudad='".$ciudad."'";
	}
	else
		$aux.=")";	
		
	
	

//----------------EXCLUYENDO CATEGORIA ADULTOS
	$cat=new Categoria(160);
	$hijos=$cat->hijos();
	
	$parche="";
	for ($i=0;$i<count($hijos);$i++)
		$parche.=" AND id_categoria<>".$hijos[$i];
//------------------------------
	
	
	$aux.=$parche." ORDER BY fecha DESC";
	
	
	//echo $aux;
	
	
	$query=operacionSQL($aux);
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
		$anuncios[$i]=mysql_result($query,$i,0);
	
	
	

	if ($buscar!="")
	{	
		$url.="&buscar=".$buscar;
		
		$resul=buscarSphinx($anuncios,$buscar);
		$anuncios=$resul;
	}
	
	
	
	if (count($anuncios)==0)
		echo "<table width='800' border='0' align='center' cellspacing='0'>
				 <tr>
					<td align='center' class='arial13Gris'><b>no se encontraron resultados para tu b&uacute;squeda</b></td>
				  </tr>
				</table>";	
	else
		echo "<table width='800' border='0' align='center' cellpadding='0' cellspacing='0'>
			  <tr>
				<td align='right' class='arial11Negro'><b>".count($anuncios)." resultados (<a href='".$url."' class='LinkFuncionalidad'>ver resultados completos</a>)</b></td>
			  </tr>
			</table>";
			
	
	if (count($anuncios)>20)
		$num=20;
	else
		$num=count($anuncios);
		
	for ($i=0;$i<$num;$i++)
	{
		$anuncio=new Anuncio($anuncios[$i]);
		
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
		
		echo $anuncio->armarAnuncio($colorete);
	}
	
	
?>