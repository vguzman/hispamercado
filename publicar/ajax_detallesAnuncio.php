<?
	include "../lib/class.php";
	
	
	
	
		
	$id_cat=$_GET['id_cat'];
	$cates=explode(";",$id_cat);
	$id_cat=$cates[count($cates)-1];

	
	$urbanizacion="";
	$m2="";
	$hab="";
	$marca="";
	$modelo="";
	$anio2="";
	$kms="";
	
	if ($_GET['id_anuncio']!="NULL")
	{
		$aux="SELECT id FROM Anuncio WHERE codigo_verificacion='".$_GET['id_anuncio']."'";
		$query=operacionSQL($aux);
		if (mysql_num_rows($query)>0)
		{
			$anuncio=new Anuncio(mysql_result($query,0,0));
			
			if (($anuncio->id_categoria==4)||($anuncio->id_categoria==3))
			{
				$detalles=$anuncio->detalles();
				
				$urbanizacion=$detalles['urbanizacion'];
				$m2=$detalles['m2'];
				$hab=$detalles['habitaciones'];
				
			}
			if (($anuncio->id_categoria==5)||($anuncio->id_categoria==6)||($anuncio->id_categoria==7)||($anuncio->id_categoria==8)||($anuncio->id_categoria==9)||($anuncio->id_categoria==10)||($anuncio->id_categoria==3707))
			{
				$detalles=$anuncio->detalles();
				
				$urbanizacion=$detalles['urbanizacion'];
				$m2=$detalles['m2'];
			}
			if (($anuncio->id_categoria==11)||($anuncio->id_categoria==12)||($anuncio->id_categoria==13))
			{
				$detalles=$anuncio->detalles();
				
				$marca=$detalles['marca'];
				$modelo=$detalles['modelo'];
				$anio2=$detalles['anio'];
				$kms=$detalles['kms'];
			}
			
			
			
			
		}
	}
	
	
	if (($id_cat==4)||($id_cat==3))
		echo utf8_encode("<table width='1000' border='0' align='center' cellpadding='2' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='150' align='left' class='arial13Negro'>Urbanización <span class='arial13Rojo'>*</span></td>
				<td width='850' align='left'><input name='urbanizacion' type='text' id='urbanizacion' size='60' maxlength='255' value='".$urbanizacion."' /></td>
			  </tr>
			</table>
			<table width='1000' border='0' align='center' cellpadding='2' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='150' align='left' class='arial13Negro'>Superficie (m2) <span class='arial13Rojo'>*</span></td>
				<td width='150' align='left'><input name='superficie' type='text' id='superficie' size='8' value='".$m2."' /><br><span class='arial11Gris'>Formato 999.99</span></td>
				<td width='100' align='left' class='arial13Negro'>Habitaciones <span class='arial13Rojo'>*</span></td>
				<td width='600' align='left'><input name='habitaciones' type='text' id='habitaciones' size='3' value='".$hab."' /></td>
			  </tr>
			</table>");
	if (($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
		echo utf8_encode("<table width='1000' border='0' align='center' cellpadding='2' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='150' align='left' class='arial13Negro'>Urbanización <span class='arial13Rojo'>*</span></td>
				<td width='500' align='left'><input name='urbanizacion' type='text' id='urbanizacion' size='60' maxlength='255' value='".$urbanizacion."' /></td>
				<td width='120' align='left'><span class='arial13Negro'>Superficie (m2) <span class='arial13Rojo'>*</span></span></td>
				<td width='230' align='left'><input name='superficie' type='text' id='superficie' size='8' value='".$m2."' /><br><span class='arial11Gris'>Formato 999.99</span></td>
			  </tr>
			</table>");
	
	
	
	
	
	if (($id_cat==11)||($id_cat==12)||($id_cat==13))
	{
		$selec_marca="<select name='marca' id='marca' onchange='modelos(this)'>
						<option></option>";
		
		$query=operacionSQL("SELECT * FROM ConfigMarca");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			if (mysql_result($query,$i,1)==$marca)
				$selected="selected";
			else
				$selected="";
				
			$selec_marca.="<option value='".mysql_result($query,$i,0)."' ".$selected.">".mysql_result($query,$i,1)."</option>";
		}
		$selec_marca.="</select>";
		
		
		
		
		if ($modelo!="")
		{
			$selec_modelo="<select name='modelo' id='modelo'>
							<option></option>";
			
			$query=operacionSQL("SELECT * FROM ConfigModelo");
			for ($i=0;$i<mysql_num_rows($query);$i++)
			{
				if (mysql_result($query,$i,2)==$modelo)
					$selected="selected";
				else
					$selected="";
					
				$selec_modelo.="<option value='".mysql_result($query,$i,2)."' ".$selected.">".mysql_result($query,$i,2)."</option>";
			}
			$selec_modelo.="</select>";
		}
		else
		{
			$selec_modelo="<select name='modelo' id='modelo' class='arial13Negro'>
				<option>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</option>
				</select>";
		}
		
		
		
		
		$selec_anio="<select name='anio' id='anio'>
						<option></option>";
		$hoy = getdate();
		$anio=$hoy['year']-1;
		$z=0;
		while (true)
		{
			if ($anio==$anio2)
				$selected="selected";
			else
				$selected="";
			
			$selec_anio.="<option value='".$anio."' ".$selected.">".$anio."</option>";
			$anio--;
			
			
			$z++;			
			if ($z==100)
				break;
		}
		$selec_anio.="</select>";
		
		
		
		
		echo utf8_encode("<table width='1000' border='0' align='center' cellpadding='2' cellspacing='4' bgcolor='#F4F9E8'>
			  <tr>
				<td width='150' align='left' class='arial13Negro'>Marca <span class='arial13Rojo'>*</span></td>
				<td width='200' align='left'>".$selec_marca."<br><span class='arial11Gris'>Ejemplo: Chevrolet, Ford, Toyota</span></td>
				<td width='80' align='left' class='arial13Negro'>Modelo <span class='arial13Rojo'>*</span></td>
				<td width='170' align='left'>
				
				".$selec_modelo."
				<br><span class='arial11Gris'>Ejemplo: Corolla, Aveo, Explorer</span></td>
				
				<td width='40' align='left' class='arial13Negro'>Año <span class='arial13Rojo'>*</span></td>
				<td width='80' align='left'>".$selec_anio."<br><span class='arial11Gris'>Ej: 2009</span></td>
				<td width='100' align='left' class='arial13Negro'>Kilometraje <span class='arial13Rojo'>*</span></td>
				<td width='180' align='left'><input name='kms' type='text' id='kms' size='6' value='".$kms."' /></td>
			  </tr>
		</table>");

	}
?>