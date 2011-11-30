<?
	include "../../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);

?>

<form id="form1" name="form1" method="post" action="gestion_ubicacion2.php">
<table width="387" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F4F9E8">
  <tr>
    <td width="65" align="left" class="arial13Negro">Ciudad <span class="arial13Rojo">*</span></td>
    <td width="302" align="left"><input name="ciudad" type="text" id="ciudad" size="30" maxlength="255" value="<? echo $_GET['ciudad'] ?>">
      <input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $_GET['id_anuncio'] ?>" />
      <br>
      <input name="ubicacion_fuera" type="checkbox" id="ubicacion_fuera" onClick="control_ubicacion('fuera')" value="SI">
      <span class="arial11Negro">Fuera del pa&iacute;s</span></td>
  </tr>
  <tr>
    <td align="left" class="arial13Negro">Estado <span class="arial13Rojo">*</span></td>
    <td align="left"><select name="provincia" id="provincia">
      <option selected> </option>
      <?
	  	$query=operacionSQL("SELECT id FROM Provincia WHERE id_pais='".$id_pais."'");
		
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$provincia=new Provincia(mysql_result($query,$i,0));
			
			if ($provincia->id==$_GET['provincia'])
				echo "<option value='".$provincia->id."' selected>".$provincia->nombre."</option>";
			else
				echo "<option value='".$provincia->id."'>".$provincia->nombre."</option>";
		}
	  ?>
    </select></td>
  </tr>
</table>
<p align="center">
  <label>
    <input type="submit" name="button" id="button" value="Guardar cambios" />
  </label>
</form>
&nbsp;</p>

