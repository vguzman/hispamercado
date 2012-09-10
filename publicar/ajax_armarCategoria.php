<?
	session_start();	
	header ("Cache-Control: no-cache, must-revalidate");	
	header('Content-Type: text/html; charset=iso-8859-1');
	include "../lib/class.php";
	
	$categorias_str="";
	
	
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
	echo "<table align='left' border='0' cellpadding='0' cellspacing='3' width='1000' style='padding-bottom:5px;'>
				<tbody>
				  <tr>
					<td valign='middle'align='left' class='arial13Negro' style='padding-left:8px;'>".$categorias_str." ".$tipo." (<a href='javascript:resetCategoria()' class='LinkFuncionalidad'><em>eliminar</em></a>)</td>					
				  </tr>
				</tbody>
			  </table>";



?>