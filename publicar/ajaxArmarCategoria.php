<?
	session_start();	
	header ("Cache-Control: no-cache, must-revalidate");	
	header('Content-Type: text/html; charset=iso-8859-1');
	include "../class.php";	
	
	$id=$_GET['id'];	
	$tipo=$_GET['tipo'];
	
	$cates=explode(";",$id);
	$categorias_str.=" &raquo; ";
	for ($i=0;$i<count($cates);$i++)
	{
		$categoria=new Categoria($cates[$i]);
		$categorias_str.="<a target='_blank' href='../listado.php?id_cat=".$categoria->id."' class='LinkFuncionalidad13'>".$categoria->nombre."</a>";
		$categorias_str.=" &raquo; ";
	}
	echo "<table align='left' border='0' cellpadding='0' cellspacing='3' width='800'>
				<tbody>
				  <tr>
					<td valign='middle' width='750' align='left' class='arial13Negro'>".$categorias_str." ".$tipo."</td>					
					<td valign='bottom' width='30' align='left'><a href='javascript:resetCategoria()'><img src='../img/x.GIF' alt='Eliminar categor&iacute;a' border='0' height='15' width='16'></a></td>
				  </tr>
				</tbody>
			  </table>";



?>