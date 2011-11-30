<?
	include "../lib/class.php";
	
	$id_cat=$_GET['id_cat'];
	$cates=explode(";",$id_cat);
	$id_cat=$cates[count($cates)-1];

	if (($id_cat==4)||($id_cat==3))
		echo utf8_encode("<table width='800' border='0' align='center' cellpadding='0' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='110' align='left' class='arial13Negro'>Urbanización <span class='arial13Rojo'>*</span></td>
				<td width='690' align='left'><input name='urbanizacion' type='text' id='urbanizacion' size='60' maxlength='255' /></td>
			  </tr>
			</table>
			<table width='800' border='0' align='center' cellpadding='0' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='109' align='left' class='arial13Negro'>Superficie (m2) <span class='arial13Rojo'>*</span></td>
				<td width='121' align='left'><input name='superficie' type='text' id='superficie' size='8' /><br><span class='arial11Gris'>Formato 999.99</span></td>
				<td width='86' align='left' class='arial13Negro'>Habitaciones <span class='arial13Rojo'>*</span></td>
				<td width='444' align='left'><input name='habitaciones' type='text' id='habitaciones' size='3' /></td>
			  </tr>
			</table>");
	if (($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		echo utf8_encode("<table width='800' border='0' align='center' cellpadding='0' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='112' align='left' class='arial13Negro'>Urbanización <span class='arial13Rojo'>*</span></td>
				<td width='410' align='left'><input name='urbanizacion' type='text' id='urbanizacion' size='60' maxlength='255' /></td>
				<td width='99' align='left'><span class='arial13Negro'>Superficie (m2) <span class='arial13Rojo'>*</span></span></td>
				<td width='159' align='left'><input name='superficie' type='text' id='superficie' size='8' /><br><span class='arial11Gris'>Formato 999.99</span></td>
			  </tr>
			</table>");
	if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		echo utf8_encode("<table width='800' border='0' align='center' cellpadding='0' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='112' align='left' class='arial13Negro'>Marca <span class='arial13Rojo'>*</span></td>
				<td width='170' align='left'><input name='marca' type='text' id='marca' size='20' maxlength='255' /><br><span class='arial11Gris'>Ejemplo: Chevrolet, Ford, Toyota</span></td>
				<td width='53' align='left' class='arial13Negro'>Modelo <span class='arial13Rojo'>*</span></td>
				<td width='170' align='left'><input name='modelo' type='text' id='modelo' size='20' maxlength='255' /><br><span class='arial11Gris'>Ejemplo: Corolla, Aveo, Explorer</span></td>
				<td width='39' align='left' class='arial13Negro'>Año <span class='arial13Rojo'>*</span></td>
				<td width='62' align='left'><input name='anio' type='text' id='anio' size='4' /><br><span class='arial11Gris'>Ej: 2009</span></td>
				<td width='84' align='left' class='arial13Negro'>Kilometraje <span class='arial13Rojo'>*</span></td>
				<td width='71' align='left'><input name='kms' type='text' id='kms' size='6' /></td>
			  </tr>
		</table>");


?>