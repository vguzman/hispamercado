<? set_time_limit(0); ?>
<? include "../lib/class.php"; echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
<trovit>
<?
	
	//BUSCANDO APARTAMENTOS Y CASAS
	$query=operacionSQL("SELECT id FROM Anuncio WHERE (id_categoria=4 OR id_categoria=3) AND status_general='Activo' LIMIT 5");
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
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=1</picture_url><picture_title>'.$anuncio->titulo.'</picture_title></picture>';
		if ($anuncio->foto2=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=2</picture_url><picture_title>'.$anuncio->titulo.'</picture_title></picture>';
		if ($anuncio->foto3=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=3</picture_url><picture_title>'.$anuncio->titulo.'</picture_title></picture>';
		if ($anuncio->foto4=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=4</picture_url><picture_title>'.$anuncio->titulo.'</picture_title></picture>';
		if ($anuncio->foto5=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=5</picture_url><picture_title>'.$anuncio->titulo.'</picture_title></picture>';
		if ($anuncio->foto6=="SI")
			$picture.='<picture><picture_url>http://www.hispamercado.com.ve/lib/img.php?tipo=real&anuncio='.$anuncio->id.'&foto=6</picture_url><picture_title>'.$anuncio->titulo.'</picture_title></picture>';
		
		
		
		echo utf8_encode('
			<ad>
				<id>'.$anuncio->id.'</id>
				<url>'.$anuncio->armarEnlace().'</url>
				<title>'.$anuncio->titulo.'</title>
				<type>'.$type.'</type>
				<content>'.$anuncio->descripcionLimpia().'</content>
				<price>'.$anuncio->precio.'</price>
				<property_type>'.$property_type.'</property_type>
				<neighborhood >'.$neighborhood.'</neighborhood >
				<city>'.$ciudad.'</city>
				<region>'.$provincia.'</region>
				<floor_area unit="meters">'.$m2.'</floor_area>
				<rooms>'.$habitaciones.'</rooms>
				<pictures>'.$picture.'</pictures>
				<date>'.aaaammdd_ddmmaaaa($anuncio->fecha).'</date>
			</ad>');
	
	
	}
	 
?>
</trovit>