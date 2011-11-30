<?
	session_start();
	
	include "../../lib/class.php";
	
	$cat=new Categoria($_GET['id_cat']);
?>

<form name="form1" method="post" action="editarCategoria2.php">
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td width="240"><label>
        <input name="nombre_categoria" type="text" id="nombre_categoria" size="40" value="<? echo utf8_encode($cat->nombre) ?>">
      </label></td>
      <td width="154"><label>
        <input type="submit" name="button" id="button" value="Editar">
        <input type="hidden" name="id_cat" id="id_cat" value="<? echo $cat->id ?>" />
      </label></td>
    </tr>
  </table>
</form>
