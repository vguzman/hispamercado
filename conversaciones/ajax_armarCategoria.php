<?
	header ("Cache-Control: no-cache, must-revalidate");	
	header('Content-Type: text/html; charset=iso-8859-1');
	include "../lib/class.php";
	
	$categorias_str="";
	
	$id=$_GET['id'];	
	$categoria=new Categoria($id);
	$arbol=$categoria->arbolDeHoja();
	
	for ($i=count($arbol)-1;$i>=0;$i--)
	{
		$categorias_str.="<a target='_blank' href='../conversaciones/index.php?id_cat=".$arbol[$i]['id']."' class='LinkFuncionalidad13'>".$arbol[$i]['nombre']."</a>";
		$categorias_str.=" &raquo; ";
	}
	echo "<table align='left' border='0' cellpadding='0' cellspacing='3' width='750' style='padding-bottom:5px;'>
				<tbody>
				  <tr>
					<td valign='middle'align='left' class='arial13Negro'>".$categorias_str." (<a href='javascript:resetCategoria()' class='LinkFuncionalidad'><em>eliminar</em></a>)</td>					
				  </tr>
				</tbody>
			  </table>";



?>

 <script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>