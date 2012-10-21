<?
	include_once "class.php";
	include('sphinx/sphinxapi.php');
	
	
	
	function buscarSphinx($criterio,$categoria,$tipo_categoria,$ciudad,$superficie,$habitacion,$marca,$modelo,$anio,$match)
	{
		
		$tiempo_inicio = microtime(true);
		
		//GUARDANDO INFO DE BUSQUEDA
		$sesion=session_id();
		$query=operacionSQL("SELECT * FROM Busqueda WHERE id_sesion='".$sesion."' AND termino_busqueda='".trim($criterio)."'");
		if (mysql_num_rows($query)==0)
			operacionSQL("INSERT INTO Busqueda VALUES ('".$sesion."','".trim($criterio)."',NOW())");
		
		
		
		//PREPARANDO EL TERMINO PARA LA BUSQUEDA
		$palabras_criterio=desglosarPalabrasS($criterio);
		$palabras_criterio=filtrarConectivos($palabras_criterio);
		$criterio="";
		for ($i=0;$i<count($palabras_criterio);$i++)
			$criterio.=$palabras_criterio[$i]." ";
		
		
		
		
		//INICIANDO SPHINX
		$cl = new SphinxClient();
		$cl->SetServer( "localhost", 9312 );
		
		
		
		//TIPO DE MATCHING
		if ($match=="ALL")
			$cl->SetMatchMode( SPH_MATCH_ALL );
		if ($match=="ANY")
			$cl->SetMatchMode( SPH_MATCH_ANY );

			
			
		
		//FILTROS
		//-----CASO CATEGORIA
		if ($categoria!="NO")
		{
			$cat=new Categoria($categoria);
			$hijos=$cat->hijos();
			
			$filtro=array();
			
			for ($i=0;$i<count($hijos);$i++)
				array_push($filtro,$hijos[$i]);
				
			
			$cl->SetFilter('categoria_index',$filtro);
		}
		
		//------CASO TIPO CATEGORIA
		if ($tipo_categoria!="NO")
		{
			
			$cl->SetFilter('tipo_index_int' , array(crc32($tipo_categoria)) );
		}
		
		//------CASO CIUDAD
		if ($ciudad!="NO")
		{
			$cl->SetFilter('ciudad_index_int', array(crc32($ciudad)) );
		}
		
		//------CASO MARCAS DE CARROS
		if ($marca!="NO")
		{
			$cl->SetFilter('marca_index_int', array(crc32($marca)) );
		}
		
		//------CASO MARCAS DE CARROS
		if ($modelo!="NO")
		{
			$cl->SetFilter('modelo_index_int', array(crc32($modelo)) );
		}


		//------CASO MARCAS DE CARROS
		if ($anio!="NO")
		{
			$cl->SetFilter('anio_index', array( $anio ) );
		}

		
		//------CASO SUPERFICIE
		if ($superficie!="NO")
		{
			
			if ($superficie=="menos50")
			{
				$min="0";
				$max="49.99";
			}
			if ($superficie=="50-100")
			{
				$min="50";
				$max="99.99";
			}
			if ($superficie=="100-150")
			{
				$min="100";
				$max="149.99";
			}
			if ($superficie=="150-200")
			{
				$min="150";
				$max="199.99";
			}
			if ($superficie=="200-300")
			{
				$min="200";
				$max="299.99";
			}
			if ($superficie=="mas300")
			{
				$min="300";
				$max="9999999999";
			}
						
			$cl->SetFilterRange('superficie_index',$min,$max);
		}
		
		//------CASO HABITACIONES
		if ($habitacion!="NO")
		{
			
			if ($habitacion=="1")
				$cl->SetFilter('habitaciones_index', array( 1 ) );
			if ($habitacion=="2")
				$cl->SetFilter('habitaciones_index', array( 2 ) );
			if ($habitacion=="3")
				$cl->SetFilter('habitaciones_index', array( 3 ) );
			if ($habitacion=="4")
				$cl->SetFilter('habitaciones_index', array( 4 ) );
			if ($habitacion=="5")
				$cl->SetFilter('habitaciones_index', array( 5 ) );
			if ($habitacion=="mas5")
				$cl->SetFilterRange('habitaciones_index', 6 , 90000 );
						
		}
		
		
		
		
		
		//PESOS Y LIMITES
		$cl->SetFieldWeights( array ('titulo' => 7, 'anuncio' => 100 , 'descripcion' => 4, 'ciudad' => 10, 'urbanizacion' => 15, 'marca' => 15, 'modelo' => 15, 'anio' => 7) );
		$cl->SetLimits(0,10000,10000,10000);
		
					
		
		//BUSCANDO
		$result = $cl->Query( $criterio , 'hispamercado' );
		
		
		
		
		
		
		//ORGANIZANDO LAS CATEGORIAS PARA LUEGO....
		$categorias=array();
		if ($categoria=="NO")
		{
			$query=operacionSQL("SELECT id FROM Categoria WHERE id_categoria IS NULL");
			for ($i=0;$i<mysql_num_rows($query);$i++)
				$categorias[mysql_result($query,$i,0)]=0;
				
		}
		else
		{
			$cat=new Categoria($categoria);
					
			//VOY POR LOS HIJOS INMEDIATOS
			$hijos_inmediatos=$cat->hijosInmediatos();
			//LOS RECORRO Y CREO UN ARRAY INICIADO CON TODOS 0
			for ($i=0;$i<count($hijos_inmediatos);$i++)
			{
					$aux=$hijos_inmediatos[$i];
					$categorias[$aux]=0;
			}				
		}
		
		//ORGANIZANDO LAS SUPERFICIES
		$superficies['menos50']=0;
		$superficies['50-100']=0;
		$superficies['100-150']=0;
		$superficies['150-200']=0;
		$superficies['200-300']=0;
		$superficies['mas300']=0;
		
		//ORGANIZANDO HABITACIONES
		$habitaciones['1']=0;
		$habitaciones['2']=0;
		$habitaciones['3']=0;
		$habitaciones['4']=0;
		$habitaciones['5']=0;
		$habitaciones['mas5']=0;
		
		$marcas=array();
		$modelos=array();
		$anios=array();
		$tipos=array();
	
		
		
		
		$i=1;
		$z=0;
		$anuncios=array();$ciudades=array();
		if ($result['total']>0)
			foreach ( $result["matches"] as $doc => $docinfo ) 
			{		
				
				$atributos=$docinfo['attrs'];
				
				/*print_r($atributos);
				echo "<br><br><br><br>";*/
				
				
				//ORGANIZANDO LAS CIUDADADES
				$ciudad=$atributos['ciudad_index'];
				if (isset($ciudades[$ciudad])==false)
					$ciudades[$ciudad]=1;
				else
					$ciudades[$ciudad]=$ciudades[$ciudad]+1;
					
				
				
				//ORGANIZANDO LAS CATEGORIAS
				$cat_actual=new Categoria($atributos['categoria_index']);
				$arbol=$cat_actual->arbolDeHoja();
				for ($i=0;$i<count($arbol);$i++)
				{
					$id=$arbol[$i]['id'];
					if (isset($categorias[$id]))
						$categorias[$id]=$categorias[$id]+1;						
				}
				
				
				
				//ORGANIZANDO LOS TIPOS DE OPERACION
				$tipo=$atributos['tipo_index'];
				if (isset($tipos[$tipo])==false)
					$tipos[$tipo]=1;
				else
					$tipos[$tipo]=$tipos[$tipo]+1;
					
				
				
				//ORGANIZANDO LAS MARCAS DE CARROS
				$marca=trim($atributos['marca_index']);
				if ($marca!="")
					if (isset($marcas[$marca])==false)
						$marcas[$marca]=1;
					else
						$marcas[$marca]=$marcas[$marca]+1;
						
				
				//ORGANIZANDO LOS MODELOS DE CARRO
				$modelo=trim($atributos['modelo_index']);
				if ($modelo!="")
					if (isset($modelos[$modelo])==false)
						$modelos[$modelo]=1;
					else
						$modelos[$modelo]=$modelos[$modelo]+1;
						
						
				//ORGANIZANDO LOS ANIOS DE CARRO
				$anio=trim($atributos['anio_index']);
				if ($anio!="")
					if (isset($anios[$anio])==false)
						$anios[$anio]=1;
					else
						$anios[$anio]=$anios[$anio]+1;
						
				
				
				
				//ORGANIZANDO SUPERFICIES
				$superficie=trim($atributos['superficie_index']);
				if ($superficie!="")
				{
					if ($superficie<50)
					{
						$superficies['menos50']++;
						//echo $doc."<br>";
					}
					if (($superficie>=50)&&($superficie<100))
						$superficies['50-100']++;
					if (($superficie>=100)&&($superficie<150))
						$superficies['100-150']++;
					if (($superficie>=150)&&($superficie<200))
						$superficies['150-200']++;
					if (($superficie>=200)&&($superficie<300))
						$superficies['200-300']++;
					if ($superficie>=300)
						$superficies['mas300']++;
				}
				
				
				//ORGANIZANDO HABITACIONES
				$habitacion=trim($atributos['habitaciones_index']);
				if ($habitacion!="")
				{
					if ($habitacion==1)
						$habitaciones['1']++;
					if ($habitacion==2)
						$habitaciones['2']++;
					if ($habitacion==3)
						$habitaciones['3']++;
					if ($habitacion==4)
						$habitaciones['4']++;
					if ($habitacion==5)
						$habitaciones['5']++;
					if ($habitacion>5)
						$habitaciones['mas5']++;
					
				}			
				

				
						
				
				
				$anuncios[$z]=$doc;
				$z++;
				
				
				//echo $doc."<br>";
				
			}
			
			
		
		//ORDENANDO ALFABETICAMENTE LOS RESULTADOS
		ksort($ciudades);
		ksort($marcas);
		ksort($modelos);
		ksort($anios);
		
		
		$resul['anuncios']=$anuncios;
		$resul['ciudades']=$ciudades;
		$resul['categorias']=$categorias;
		$resul['tipos']=$tipos;
		$resul['marcas']=$marcas;
		$resul['modelos']=$modelos;
		$resul['anios']=$anios;
		$resul['habitaciones']=$habitaciones;
		$resul['superficies']=$superficies;
		
		
		
		return $resul;
		
		
		
		
		
		/*print_r($habitaciones);
		echo "<br><br><br><br>";*/
		
		
		
		//print_r($ciudades);
		
		
		
		/*echo "<br><br><br><br>";
		echo "fallo en Query: " . $cl->GetLastError() . "<br>";
		echo "WARNING: " . $cl->GetLastWarning() . "<br>";*/
		
		
		//return $anuncios;
		
		
		
	}
	
	
	
	//QUITA ACENTOS - QUITA ETIQUETAS HTML - LLEVA PALABRAS A MINUSCULAS - QUITA S AL FINAL DE LA PALABRA
	function desglosarPalabras($texto)
	{
		//QUITANDO STYLES AND SCRIPTS
		$texto=quitarBloques($texto,"<style>","</style>");
		$texto=quitarBloques($texto,"<xml>","</xml>");
		$texto=quitarBloques($texto,"<script>","</script>");
		
		
		//FILTRADO 1 - QUITANDO TODAS LAS ETIQUETAS DEL TEXTO ORIGINAL	.
		$descripcion="";	
		for ($i=0;$i<strlen($texto);$i++)
		{
			if ($texto[$i]!='<')
				$descripcion.=$texto[$i];
			else
				while ($texto[$i]!='>')
				{
					$i++;
					if ($i>=strlen($texto))
						break;
				}
		}
		
		//FLTRADO 2 - DIVIENDO LAS PALABRAS POR SIMBOLOS Y DECODIFICANDO CARACTERES HTML ESPACIALES
		$descripcion=html_entity_decode($descripcion);
		$descripcion=str_replace(chr(92),'',$descripcion);
		$caracteres=' |-|'.chr(160).'|,|_|<|>|/|=|:|"|\?|\+|\.|\*|\(|\)|;|¿|¡|!|%|°|º|&|\$|´|`|@|®|²|\||¨|\[|\]|€|ø|'.chr(13).'|'.chr(10).'|'.chr(39);
		
		$z=0;
		$contenido=split($caracteres,$descripcion);	
		for ($i=0;$i<count($contenido);$i++)
		{
			$palabra=trim($contenido[$i]);
			$palabra=limpiar_acentos($palabra);
			$palabra=strtolower($palabra);
			if (strlen($palabra)>0)
			{
				//echo $palabra."<br>";
				$resul[$z]=$palabra;
				$z++;
			}
		}
		
		
		
		//DESECHANDO PALABRAS CON CARACTERES EXTRAÑOS
		$resul2=array();
		$z=0;
		for ($i=0;$i<count($resul);$i++)
		{
			
			$palabra=$resul[$i];
			
			if	(preg_match('/^[a-zA-Z0-9ñÑ]+$/',$palabra)==1)
			{	
				$resul2[$z]=$palabra;
				$z++;
				//$palabra." ---- "."PALABRA EXTRAÑA<br><br><br>";
			}
		}
		
		
		$resul2=quitaS($resul2);
		return $resul2;		
	}
	
	
	
	//QUITA ACENTOS - QUITA ETIQUETAS HTML - LLEVA PALABRAS A MINUSCULAS - QUITA S AL FINAL DE LA PALABRA
	function desglosarPalabrasS($texto)
	{
		$resul=array();
		
		//QUITANDO STYLES AND SCRIPTS
		$texto=quitarBloques($texto,"<style>","</style>");
		$texto=quitarBloques($texto,"<xml>","</xml>");
		$texto=quitarBloques($texto,"<script>","</script>");
		
		
		//FILTRADO 1 - QUITANDO TODAS LAS ETIQUETAS DEL TEXTO ORIGINAL	.
		$descripcion="";	
		for ($i=0;$i<strlen($texto);$i++)
		{
			if ($texto[$i]!='<')
				$descripcion.=$texto[$i];
			else
				while ($texto[$i]!='>')
				{
					$i++;
					if ($i>=strlen($texto))
						break;
				}
		}
		
		//FLTRADO 2 - DIVIENDO LAS PALABRAS POR SIMBOLOS Y DECODIFICANDO CARACTERES HTML ESPACIALES
		$descripcion=html_entity_decode($descripcion);
		$descripcion=str_replace(chr(92),'',$descripcion);
		$caracteres=' |-|'.chr(160).'|,|_|<|>|/|=|:|"|\?|\+|\.|\*|\(|\)|;|¿|¡|!|%|°|º|&|\$|´|`|@|®|²|\||¨|\[|\]|€|ø|'.chr(13).'|'.chr(10).'|'.chr(39);
		
		$z=0;
		$contenido=split($caracteres,$descripcion);	
		for ($i=0;$i<count($contenido);$i++)
		{
			$palabra=trim($contenido[$i]);
			$palabra=limpiar_acentos($palabra);
			$palabra=strtolower($palabra);
			if (strlen($palabra)>0)
			{
				//echo $palabra."<br>";
				$resul[$z]=$palabra;
				$z++;
			}
		}
		
		
		
		//DESECHANDO PALABRAS CON CARACTERES EXTRAÑOS
		$resul2=array();
		$z=0;
		for ($i=0;$i<count($resul);$i++)
		{
			
			$palabra=$resul[$i];
			
			if	(preg_match('/^[a-zA-Z0-9ñÑ]+$/',$palabra)==1)
			{	
				$resul2[$z]=$palabra;
				$z++;
				//$palabra." ---- "."PALABRA EXTRAÑA<br><br><br>";
			}
		}
		
		
		return $resul2;		
	}
	
	
	
	
	
	
	
	function limpiar_acentos($s)
	{
		$s = ereg_replace("[áàâã]","a",$s);
		$s = ereg_replace("[ÁÀÂÃ]","A",$s);
		$s = ereg_replace("[ÍÌÎ]","I",$s);
		$s = ereg_replace("[íìî]","i",$s);
		$s = ereg_replace("[éèê]","e",$s);
		$s = ereg_replace("[ÉÈÊ]","E",$s);
		$s = ereg_replace("[óòôõ]","o",$s);
		$s = ereg_replace("[ÓÒÔÕ]","O",$s);
		$s = ereg_replace("[úùû]","u",$s);
		$s = ereg_replace("[ÚÙÛ]","U",$s);
		
		return $s;
	}
	
	function limpiarEnies($s)
	{
		$s=str_replace("ñ","n",$s);
		$s=str_replace("Ñ","n",$s);
		
		return $s;
	}
	
	function quitarBloques($texto,$inicio,$fin)
	{
		while (true)
		{
			if ((substr_count($texto,$inicio)>0)&&(substr_count($texto,$fin)>0))
			{
				$pos1=strpos($texto,$inicio);
				$pos2=strpos($texto,$fin);
				
				$bloque=substr($texto,$pos1,($pos2-$pos1+strlen($fin)));
				
				
				$texto=str_replace($bloque,'',$texto);
			}
			else
				break;
		}
		
		return $texto;
	}
	
	
	
	function filtrarConectivos($arreglo)
	{
		$resul=array();
		
		$z=0;
		for ($i=0;$i<count($arreglo);$i++)
		{
			if (($arreglo[$i]!="si")&&
			($arreglo[$i]!="no")&&($arreglo[$i]!="que")&&($arreglo[$i]!="sus")&&($arreglo[$i]!="en")&&
			($arreglo[$i]!="de")&&($arreglo[$i]!="lo")&&($arreglo[$i]!="del")&&
			($arreglo[$i]!="el")&&
			($arreglo[$i]!="la")&&
			($arreglo[$i]!="tu")&&
			($arreglo[$i]!="se")&&
			($arreglo[$i]!="su")&&
			($arreglo[$i]!="para")&&
			($arreglo[$i]!="las")&&
			($arreglo[$i]!="los")&&
			($arreglo[$i]!="por")&&
			($arreglo[$i]!="con")&&
			($arreglo[$i]!="sin")&&
			($arreglo[$i]!="a")&&
			($arreglo[$i]!="o")&&
			($arreglo[$i]!="y")&&
			($arreglo[$i]!="como"))
			{
				$resul[$z]=$arreglo[$i];
				$z++;
			}
		}
		
		return $resul;
	}
	
	
	function quitaS($arreglo)
	{
		for ($i=0;$i<count($arreglo);$i++)
		{
			$palabra=$arreglo[$i];			
			$len=strlen($palabra);
			
			
			if ($palabra[$len-1]=='s')
				$arreglo[$i]=substr($palabra,0,$len-1);
		}
		
		return $arreglo;
	}
	
	
?>