<? set_time_limit(0); ?>
<? include "../lib/class.php"; echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<ads>
<?
	//BUSCANDO APARTAMENTOS Y CASAS
	$query=operacionSQL("SELECT id FROM Anuncio WHERE (id_categoria=4 OR id_categoria=3) AND status_general='Activo'");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$anuncio=new Anuncio(mysql_result($query,$i,0));
		
		if (($anuncio->tipo_categoria=="Venta")||($anuncio->tipo_categoria=="Traspaso")||($anuncio->tipo_categoria=="Compra"))
			$type="For Sale";
		else
			$type="For Rent";
			
		if ($anuncio->id_categoria=="3")
			$property_type="Apartamento";
		if ($anuncio->id_categoria=="4")
			$property_type="Casa";
		
		$propiedades=$anuncio->detalles();
		$neighborhood=$propiedades['urbanizacion'];
		$m2=$propiedades['m2'];
		$habitaciones=$propiedades['habitaciones'];
		
		$aux=explode(",",$anuncio->ciudad);
		$ciudad=trim($aux[0]);
		$provincia=trim($aux[1]);
		//$provincia=new Provincia($anuncio->id_provincia);
		//$anuncio->id_provincia;
		
		//FOTOS
		$picture="";
		if ($anuncio->foto1=="SI")
			$picture.='<picture>
						<picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=1</picture_url><picture_title>'.utf8_encode($anuncio->titulo).'</picture_title></picture>';
		if ($anuncio->foto2=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=2</picture_url><picture_title>'.utf8_encode($anuncio->titulo).'</picture_title></picture>';
		if ($anuncio->foto3=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=3</picture_url><picture_title>'.utf8_encode($anuncio->titulo).'</picture_title></picture>';
		if ($anuncio->foto4=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=4</picture_url><picture_title>'.utf8_encode($anuncio->titulo).'</picture_title></picture>';
		if ($anuncio->foto5=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=5</picture_url><picture_title>'.utf8_encode($anuncio->titulo).'</picture_title></picture>';
		if ($anuncio->foto6=="SI")
			$picture.='<picture>
					<picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=6</picture_url>
					<picture_title>'.utf8_encode($anuncio->titulo).'</picture_title>
				</picture>';
		
		
		$fecha=str_replace("-","/",aaaammdd_ddmmaaaa($anuncio->fecha));
		
		echo '<ad>
				<id>'.$anuncio->id.'</id>
				<url>http://www.hispamercado.com.ve/'.$anuncio->armarEnlace().'</url>
				<title>'.utf8_encode($anuncio->titulo).'</title>
				<type>'.$type.'</type>
				<content>'.utf8_encode($anuncio->descripcionLimpia()).'</content>
				<price>'.$anuncio->precio.'</price>
				<property_type>'.$property_type.'</property_type>
				<neighborhood>'.utf8_encode($neighborhood).'</neighborhood>
				<city>'.utf8_encode($ciudad).'</city>
				<region>'.utf8_encode($provincia).'</region>
				<floor_area unit="meters">'.$m2.'</floor_area>
				<rooms>'.$habitaciones.'</rooms>
				<pictures>'.$picture.'</pictures>
				<date>'.$fecha.'</date>
			</ad>';
	
	
	}
?>
</ads>