<?
	include_once "class.php";
	include('sphinx/sphinxapi.php');
	
	
	
	function buscarSphinx($universo,$criterio)
	{
		
		$tiempo_inicio = microtime(true);
		
		//GUARDANDO INFO DE BUSQUEDA
		$sesion=session_id();
		$query=operacionSQL("SELECT * FROM AnuncioBusqueda WHERE id_sesion='".$sesion."' AND termino_busqueda='".trim($criterio)."'");
		if (mysql_num_rows($query)==0)
			operacionSQL("INSERT INTO AnuncioBusqueda VALUES ('".$sesion."','".trim($criterio)."',NOW())");
		
		
		
		//PREPARANDO EL TERMINO PARA LA BUSQUEDA
		$palabras_criterio=desglosarPalabrasS($criterio);
		$palabras_criterio=filtrarConectivos($palabras_criterio);
		$criterio="";
		for ($i=0;$i<count($palabras_criterio);$i++)
			$criterio.=$palabras_criterio[$i]." ";
		
		
		
		//------------------------------------------------FASE SPHINX
		
		//FILTRANDO UNIVERSO
		/*$filtro=array();
		for ($i=0;$i<count($universo);$i++)
			array_push($filtro,$universo[$i]);*/
		
		
		$cl = new SphinxClient();
		$cl->SetServer( "localhost", 9312 );
		$cl->SetMatchMode( SPH_MATCH_ALL );
		$cl->SetFilter('anuncio' , $universo);
		//$cl->SetFieldWeights( array ('b.titulo' => 10, 'b.descripcion' => 5, 'b.ciudad' => 6, 'b.urbanizacion' => 8, 'b.marca' => 8, 'b.modelo' => 8, 'b.anio' => 1) );
		$cl->SetLimits(0,10000,10000,10000);
		
		
					
		//echo $criterio;
		
		
		$result = $cl->Query( $criterio , 'hispamercado' );
		//print_r($result);
		echo $result['total']."<br><br><br>";
		
		$i=1;		
		if ($result['total']>0)
			foreach ( $result["matches"] as $doc => $docinfo ) 
			{
				echo $i." - ".$doc." --- ";
				echo $docinfo['weight']."<br><br><br>";
				$i++;
			}
		
		
		
		
		echo "<br><br><br><br>";
		echo "fallo en Query: " . $cl->GetLastError() . "<br>";
		echo "WARNING: " . $cl->GetLastWarning() . "<br>";
		
		/*if (count($result["matches"])>0)
		{
			$z=0;
			$anuncios=array();
			foreach ( $result["matches"] as $doc => $docinfo ) 
			{
				$anuncios[$z]=$doc;
				$z++;		
			}
		}
		
		$tiempo_fin = microtime(true);
		
		
		return $anuncios;*/
		
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
		$caracteres=' |-|'.chr(160).'|,|_|<|>|/|=|:|"|\?|\+|\.|\*|\(|\)|;|�|�|!|%|�|�|&|\$|�|`|@|�|�|\||�|\[|\]|�|�|'.chr(13).'|'.chr(10).'|'.chr(39);
		
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
		
		
		
		//DESECHANDO PALABRAS CON CARACTERES EXTRA�OS
		$resul2=array();
		$z=0;
		for ($i=0;$i<count($resul);$i++)
		{
			
			$palabra=$resul[$i];
			
			if	(preg_match('/^[a-zA-Z0-9��]+$/',$palabra)==1)
			{	
				$resul2[$z]=$palabra;
				$z++;
				//$palabra." ---- "."PALABRA EXTRA�A<br><br><br>";
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
		$caracteres=' |-|'.chr(160).'|,|_|<|>|/|=|:|"|\?|\+|\.|\*|\(|\)|;|�|�|!|%|�|�|&|\$|�|`|@|�|�|\||�|\[|\]|�|�|'.chr(13).'|'.chr(10).'|'.chr(39);
		
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
		
		
		
		//DESECHANDO PALABRAS CON CARACTERES EXTRA�OS
		$resul2=array();
		$z=0;
		for ($i=0;$i<count($resul);$i++)
		{
			
			$palabra=$resul[$i];
			
			if	(preg_match('/^[a-zA-Z0-9��]+$/',$palabra)==1)
			{	
				$resul2[$z]=$palabra;
				$z++;
				//$palabra." ---- "."PALABRA EXTRA�A<br><br><br>";
			}
		}
		
		
		return $resul2;		
	}
	
	
	
	
	
	
	
	function limpiar_acentos($s)
	{
		$s = ereg_replace("[����]","a",$s);
		$s = ereg_replace("[����]","A",$s);
		$s = ereg_replace("[���]","I",$s);
		$s = ereg_replace("[���]","i",$s);
		$s = ereg_replace("[���]","e",$s);
		$s = ereg_replace("[���]","E",$s);
		$s = ereg_replace("[����]","o",$s);
		$s = ereg_replace("[����]","O",$s);
		$s = ereg_replace("[���]","u",$s);
		$s = ereg_replace("[���]","U",$s);
		
		return $s;
	}
	
	function limpiarEnies($s)
	{
		$s=str_replace("�","n",$s);
		$s=str_replace("�","n",$s);
		
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