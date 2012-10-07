<?
	
include_once "util.php";	
include_once "busqueda.php";
	
class Anuncio
{		
	var $id;
	var $codigo_verificacion;
	var $id_categoria;
	var $tipo_categoria;
	var $id_usuario;
	var $fecha;
	var $titulo;	
	var $descripcion;
	var $precio;
	var $moneda;
	var $ciudad;
	var $foto1;
	var $foto2;
	var $foto3;
	var $foto4;	
	var $foto5;
	var $foto6;
	var $video_youtube;
	var $anunciante_nombre;
	var $anunciante_email;
	var $anunciante_telefonos;	
	var $status_general;
	var $status_revision;
	
		
	function Anuncio($id)
	{
		$aux="SELECT * FROM Anuncio WHERE id=".$id;
		//echo $aux."<br><br><br>";
		$query=operacionSQL($aux);
				
		$this->id=$id;
		//echo "<br>";
		$this->codigo_verificacion=mysql_result($query,0,1);
		$this->id_categoria=mysql_result($query,0,2);
		$this->tipo_categoria=mysql_result($query,0,3);
		$this->id_usuario=mysql_result($query,0,4);
		$this->fecha=mysql_result($query,0,5);
		$this->titulo=stripslashes(mysql_result($query,0,6));
		$this->descripcion=stripslashes(mysql_result($query,0,7));
		$this->precio=mysql_result($query,0,8);
		$this->moneda=mysql_result($query,0,9);
		$this->ciudad=mysql_result($query,0,10);
		$this->foto1=mysql_result($query,0,11);
		$this->foto2=mysql_result($query,0,12);
		$this->foto3=mysql_result($query,0,13);
		$this->foto4=mysql_result($query,0,14);
		$this->foto5=mysql_result($query,0,15);
		$this->foto6=mysql_result($query,0,16);
		$this->video_youtube=mysql_result($query,0,17);
		$this->anunciante_email=mysql_result($query,0,18);
		$this->anunciante_nombre=mysql_result($query,0,19);
		$this->anunciante_telefonos=mysql_result($query,0,20);
		$this->status_general=mysql_result($query,0,21);
		$this->status_revision=mysql_result($query,0,22);
		
		//echo $this->id."<br>";
	}
	
	function tiempoHace()
	{
		$query=operacionSQL("SELECT TIMEDIFF(NOW(),'".$this->fecha."')");
		$horas=substr(mysql_result($query,0,0),0,2);
		
		if ($horas<=0)
			return "menos de una hora";
		if ($horas<24)
			return $horas." horas";
		else
		{
			$query=operacionSQL("SELECT DATEDIFF(NOW(),'".$this->fecha."')");
			$dias=mysql_result($query,0,0);
			return $dias." dias";
		}
	}
	
	function visitas()
	{
		$query=operacionSQL("SELECT cuenta FROM AnuncioVisitaResumen WHERE id_anuncio=".$this->id);
		if (mysql_num_rows($query)==0)
			$visitas_archivo=0;
		else
			$visitas_archivo=mysql_result($query,0,0);
			
			
		$query=operacionSQL("SELECT COUNT(*) FROM AnuncioVisita WHERE id_anuncio=".$this->id);
		$visitas_recientes=mysql_result($query,0,0);


		return $visitas_archivo+$visitas_recientes;			
			
	}
	
	function tamanoFoto($foto)
	{
		$destino="../img/img_bank/".$this->id."_".$foto;
		error_reporting(0);
		$info = getimagesize($destino);
		
		if ($info==NULL)
		{
			return "no";
		}
		else
		{
			switch ($info[2]) 
			{
				case 1:
					$original = imagecreatefromgif($destino); break;
				case 2:
					$original = imagecreatefromjpeg($destino); break;
				case 3:
					$original = imagecreatefrompng($destino); break;				
			}
			
			$original_w = imagesx($original);
			$original_h = imagesy($original);
			
			if (($original_w<=800)&&($original_h<=500))
			{
				$muestra_h=$original_h;
				$muestra_w=$original_w;
			}
			else
			{
				if($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*500);
						$muestra_h=500;
						
						if ($muestra_w>800)
						{
							$muestra_w=800;
							$muestra_h=intval(($original_h/$original_w)*800);
						}
				}
				if($original_w>$original_h) 
				{
						$muestra_w=800;
						$muestra_h=intval(($original_h/$original_w)*800);
						
						if ($muestra_h>500)
						{
							$muestra_w = intval(($original_w/$original_h)*500);
							$muestra_h=500;	
						}
				}
				if($original_w==$original_h) 
				{
						$muestra_w=500;
						$muestra_h=500;
				}
				
								
			}
		}
		
		$resul['w']=$muestra_w;
		$resul['h']=$muestra_h;
		
		return $resul;
		
	}
	
	
	
	function tamanoFotoLista()
	{
		$foto="1";
		$destino="img/img_bank/".$this->id."_1";
		error_reporting(0);
		$info = getimagesize($destino);
		
		if ($info==NULL)
			return "no";
		else
		{		
			switch ($info[2]) 
			{
				case 1:
					$original = imagecreatefromgif($destino); break;
				case 2:
					$original = imagecreatefromjpeg($destino); break;
				case 3:
					$original = imagecreatefrompng($destino); break;				
			}
			
			$original_w = imagesx($original);
			$original_h = imagesy($original);
			
			
			if (($original_w<=145)&&($original_h<=135))
			{
				$muestra_h=$original_h;
				$muestra_w=$original_w;
			}
			else
			{
				if($original_w<$original_h) 
				{
						$muestra_w = intval(($original_w/$original_h)*135);
						$muestra_h=135;
						
						if ($muestra_w>145)
						{
							$muestra_w=145;
							$muestra_h=intval(($original_h/$original_w)*145);
						}
				}
				if($original_w>$original_h) 
				{
						$muestra_w=145;
						$muestra_h=intval(($original_h/$original_w)*145);
						
						if ($muestra_h>135)
						{
							$muestra_w = intval(($original_w/$original_h)*135);
							$muestra_h=135;	
						}
				}
				if($original_w==$original_h) 
				{
						$muestra_w=135;
						$muestra_h=135;
				}
				
								
			}
		}
		
		
		$resul['w']=$muestra_w;
		$resul['h']=$muestra_h;
		
		return $resul;
	}
	
	
	function descripcionLimpia()
	{
		$texto=$this->descripcion;
		
		
		//QUITANDO STYLES AND SCRIPTS
		$texto=quitarBloques($this->descripcion,"<style>","</style>");
		$texto=quitarBloques($texto,"<xml>","</xml>");
		$texto=quitarBloques($texto,"<script>","</script>");
		
		
		$descripcion="";	
		for ($i=0;$i<strlen($texto);$i++)
		{
			if ($texto[$i]!='<')
			{
				$descripcion.=$texto[$i];
			}
			else
				while ($texto[$i]!='>')
				{
					$i++;
					if ($i>=strlen($texto))
						break;
				}
		}
		
		$descripcion=html_entity_decode($descripcion);
		$descripcion=str_replace(chr(92),'',$descripcion);
		$caracteres=' |-|'.chr(160).'|,|_|<|>|/|=|:|"|\?|\+|\.|\*|\(|\)|;|¿|¡|!|%|°|º|&|\$|´|`|@|®|²|\||¨|\[|\]|€|ø|'.chr(13).'|'.chr(10).'|'.chr(39);
		
		$z=0;
		$contenido=split($caracteres,$descripcion);	
		$descripcion2="";
		for ($i=0;$i<count($contenido);$i++)
		{
			$palabra=trim($contenido[$i]);
			$palabra=limpiar_acentos($palabra);
			//$palabra=strtolower($palabra);
			if (strlen($palabra)>0)
			{
				$descripcion2.=$palabra." ";;
			}
		}
		
		$descripcion=strtolower($descripcion2);
		$descripcion=ucwords($descripcion);
		
		return $descripcion;
	}
	
	
	
	
	function compruebaFavorito($codigo)
	{
		$aux="SELECT * FROM Favoritos WHERE sesion='".$codigo."' AND id_anuncio=".$this->id;
		$query=operacionSQL($aux);
		return mysql_num_rows($query);
	}
	
	
	
	
	function armarEnlace()
	{
		$titulo=limpiarEnies($this->titulo);
		$palabras=desglosarPalabrasS($titulo);
		
		$enlace="";
		
		for ($j=0;$j<count($palabras);$j++)
			$enlace.=$palabras[$j]."-";
		
		
		$enlace=substr($enlace,0,200);
		
		$len=strlen($enlace);
		if ($enlace[$len-1]!='-')
			$enlace.="-anuncio-".$this->id;
		else
			$enlace.="anuncio-".$this->id;
		
				
		return $enlace;
	}
	
	
	function armarAnuncio($color)
	{
		//ARMANDO ENLACE
		$enlace=$this->armarEnlace();
		
		$medida=$this->tamanoFotoLista();
		$h=$medida['h'];
		
		$precio="";
		if ((trim($this->precio)!='')&&($this->precio>0)) 
			$precio='Bs '.number_format($this->precio,2,',','.');
			
			
			
		//DETALLES DE ANUNCIOS ESPECIFICOS
		$arreglo=$this->detalles();
		$id_cat=$this->id_categoria;
		$detalles="";
		if (($id_cat==4)||($id_cat==3))
			$detalles="Urbanización ".$arreglo['urbanizacion']."&nbsp;&nbsp;&nbsp; "."Superficie ".$arreglo['m2']." m2&nbsp;&nbsp;&nbsp; "."Habitaciones ".$arreglo['habitaciones'];
		
		
		if (($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707))
			$detalles="Urbanización ".$arreglo['urbanizacion']."&nbsp;&nbsp;&nbsp; "."Superficie ".$arreglo['m2']." m2";
		
		
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
			$detalles="Marca ".$arreglo['marca']."&nbsp;&nbsp;&nbsp; "."Modelo ".$arreglo['modelo']."&nbsp;&nbsp;&nbsp; "."Año ".$arreglo['anio'];
			
		
		//Anuncio con video
		$video="";
		if (trim($this->video_youtube)!="")
			$video="<div style='margin-bottom:2px;'>
						 <span class='arial13Mostaza'><em>Anuncio con video</em></span> <img src='../img/youtube.png' width='16' height='16' />
					</div>";
			
		
		$anuncio="<div style='margin:0 auto 0 auto; position:relative; width:700px; border-bottom:#C8C8C8 1px solid; background-color:".$color."; display:table; '>
	
					<table width='700' border='0' cellspacing='0' cellpadding='0' align='center'>
					  <tr>
						<td width='130' height='120' align='center' valign='middle' style='padding-bottom:7px; padding-top:7px;'><a href='".$enlace."'><img src='lib/img.php?tipo=lista&anuncio=".$this->id."&foto=1' border='0' alt='".$this->titulo."' title='".$this->titulo."' /></a></td>
						<td width='580'>
								<table width='570' height='120' border='0' cellspacing='0' cellpadding='0'>
								  <tr>
									<td height='40' valign='top'>
									
											<div style='margin-left:10px;' >
												<a href='".$enlace."' class='tituloAnuncio'>".$this->titulo."</a>
											</div>
								
											<div style='margin-left:10px; '>
												<span class='arial13Negro'><em>".$detalles."</em></span>
											</div>
									</td>
								  </tr>
								  <tr>
									<td height='25' valign='bottom'>
											<div style='margin-left:10px; margin-top:35px;'>
												".$video."
											</div>
										
											<div style='margin-left:10px;'>
												<span class='arial15Negro' style='float:left;'><em>Publicado hace ".$this->tiempoHace()." en ".$this->ciudad."</em></span>
												<span class='arial15RojoPrecio' style='float:right; padding-right:5px;'><strong>".$precio."</strong></span>
											</div>
									</td>
								  </tr>
								</table>
						</td>
					  </tr>
					</table>
				</div>";
				
		return $anuncio;
	}


	function armarAnuncioGestion($color)
	{
		
		if ($this->id_provincia=="")
			$provincia="";
		else
		{	
			$provincia=new Provincia($this->id_provincia);
			$provincia=", ".$provincia->nombre;
		}

		
		if ($this->precio=="")
			$precio="no especificado";
		else
			$precio=$this->precio." ".$this->moneda;
				
		$anuncio="<table id='contenedor_principal' width='800' height='80' border='0' align='center' cellpadding='0' cellspacing='2' bgcolor='".$color."'>
				  <tr>
					<td id='anuncio_imagen' width='90' align='center'><a href='anuncio/?id=".$this->id."'><img border='0' src='lib/img.php?tipo=lista&anuncio=".$this->id."' alt='".$this->titulo."' title='".$this->titulo."'></a></td>
					<td id='anuncio_contenido' width='682'><table width='670'  border='0' align='center' cellpadding='0' cellspacing='0'>
						<tr>
						  <td height='60' valign='top' align='left'><a href='anuncio/?id=".$this->id."' class='LinkArticulo'>".$this->titulo."</a></td>
						</tr>
						<tr>
						  <td align='left' class='arial13Negro'><b>Fecha:</b> ".aaaammdd_ddmmaaaa($this->fecha)." | <b>Ubicaci&oacute;n:</b> ".$this->ciudad.$provincia." | <b>Precio:</b> ".$precio." | <b>Tipo:</b> ".$this->tipo_categoria."</td>
						</tr>
					</table></td>
					<td width='28' align='center' id='anuncio_contenido'><table width='100%' height='71'  border='0' cellpadding='0' cellspacing='0'>
						<tr>
						  <td valign='top' id='favorito_".$this->id."'><input name='check_".$this->id."' type='checkbox' id='check_".$this->id."' value='SI'></td>
						</tr>
						<tr>
						  <td height='37' valign='bottom' id='favorito_".$this->id."'></td>
						</tr>
					</table></td>
				  </tr>
				</table>";		
			
			return $anuncio.="<table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor='#C8C8C8'>
							  <tr>
								<td height='1'></td>
							  </tr>
							</table>";	
	
	
	}






	function numeroFotos()
	{
		$num=0;
		if ($this->foto1=="SI")
			$num++;
		if ($this->foto2=="SI")
			$num++;
		if ($this->foto3=="SI")
			$num++;
		if ($this->foto4=="SI")
			$num++;
		if ($this->foto5=="SI")
			$num++;
		if ($this->foto6=="SI")
			$num++;
			
		return $num;
	}
	
	function detalles()
	{
		if (($this->id_categoria==4)||($this->id_categoria==3))
		{
			$query=operacionSQL("SELECT urbanizacion,m2,habitaciones FROM Anuncio_Detalles_Inmuebles WHERE id_anuncio=".$this->id);
			$arreglo['urbanizacion']=mysql_result($query,0,0);
			$arreglo['m2']=mysql_result($query,0,1);
			$arreglo['habitaciones']=mysql_result($query,0,2);
			
			return $arreglo;			
		}
		if (($this->id_categoria==5)||($this->id_categoria==6)||($this->id_categoria==7)||($this->id_categoria==8)||($this->id_categoria==9)||($this->id_categoria==10)||($this->id_categoria==3707))
		{
			//echo $this->id."<br><br>";
			$query=operacionSQL("SELECT urbanizacion,m2 FROM Anuncio_Detalles_Inmuebles WHERE id_anuncio=".$this->id);
			$arreglo['urbanizacion']=mysql_result($query,0,0);
			$arreglo['m2']=mysql_result($query,0,1);
			
			return $arreglo;	
		}
		if (($this->id_categoria==11)||($this->id_categoria==12)||($this->id_categoria==16)||($this->id_categoria==13)||($this->id_categoria==14))
		{
			$aux="SELECT marca,modelo,kms,anio FROM Anuncio_Detalles_Vehiculos WHERE id_anuncio=".$this->id;
			$query=operacionSQL($aux);
			$arreglo['marca']=mysql_result($query,0,0);
			$arreglo['modelo']=mysql_result($query,0,1);
			$arreglo['kms']=mysql_result($query,0,2);
			$arreglo['anio']=mysql_result($query,0,3);
			
			return $arreglo;	
		}
	}
	
	function comentarios()
	{
		$aux="SELECT * FROM Anuncio_Comentario WHERE (status='Por revisar' OR status='Revisado') AND id_anuncio=".$this->id." ORDER BY fecha DESC";
		$query=operacionSQL($aux);
		
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$arreglo[$i]['id']=mysql_result($query,$i,0);
			$arreglo[$i]['fecha']=mysql_result($query,$i,2);
			$arreglo[$i]['comentario']=mysql_result($query,$i,3);
			$arreglo[$i]['respuesta']=mysql_result($query,$i,4);
			$arreglo[$i]['de_nombre']=mysql_result($query,$i,5);
			$arreglo[$i]['de_email']=mysql_result($query,$i,6);
		}
		return $arreglo;
	}
	
	function busqueda($criterio)
	{
		$suma=0;
		$criterio=desglosarPalabras($criterio);
		$criterio_filtrado=filtrarConectivos($criterio);
		
		
		//ANALIZANDO TITULO
		//--OCURRENCIAS PALABRAS
		$palabras_titulo=desglosarPalabras($this->titulo);
		$palabras_titulo_filtrado=filtrarConectivos($palabras_titulo);
		$suma=$suma+valoracionOcurrencias($criterio_filtrado,$palabras_titulo_filtrado,1);
		//--OCURRENCIAS TODA LA FRASE
		$suma=$suma+(evaluarCriterioCompletoSinFiltro($criterio,$palabras_titulo)*4);

		
		//ANALIZANDO DESCRIPCION 
		//--OCURRENCIAS PALABRAS
		$palabras_descripcion=desglosarPalabras($this->descripcion);
		$palabras_descripcion_filtrado=filtrarConectivos($palabras_descripcion);
		$suma=$suma+valoracionOcurrencias($criterio_filtrado,$palabras_descripcion_filtrado,0.25);
		//--OCURRENCIAS TODA LA FRASE
		$suma=$suma+(evaluarCriterioCompletoSinFiltro($criterio,$palabras_descripcion)*1);
		
		
		//CASO INMUEBLES
		if (($this->id_categoria==4)||($this->id_categoria==3)||($this->id_categoria==5)||($this->id_categoria==6)||($this->id_categoria==7)||($this->id_categoria==8)||($this->id_categoria==9)||($this->id_categoria==10)||($this->id_categoria==3707))
		{
			$detalles=$this->detalles();
			$urb=$detalles['urbanizacion'];
			$urb=desglosarPalabras($urb);
			
			$suma=$suma+valoracionOcurrencias($criterio_filtrado,$urb,1);
		}	
		
		
		return $suma;
	}
	
	
	
	
	
	function metainformacion()
	{
		$palabras_titulo=desglosarPalabrasS($this->titulo);
		$palabras_titulo=filtrarConectivos($palabras_titulo);
		
		$palabras_descripcion=desglosarPalabrasS($this->descripcion);
		$palabras_descripcion=filtrarConectivos($palabras_descripcion);
		
		
		
		$id_cat=$this->id_categoria;
		
		$urbanizacion="";
		$marca="";
		$modelo="";
		$anio="";
		$superficie="NULL";
		$habitaciones="NULL";
		
		
		//CASO INMUEBLES
		if (($id_cat==4)||($id_cat==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707)||($id_cat==3707))
		{
			$aux=$this->detalles();
			$urbanizacion=$aux['urbanizacion'];
			$superficie=$aux['m2'];
			
			if (isset($aux['habitaciones']))
				$habitaciones=$aux['habitaciones'];
				
			
		}
		//CASO VEHICULOS
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{
			$aux=$this->detalles();
			$marca=$aux['marca'];
			$modelo=$aux['modelo'];
			$anio=$aux['anio'];
		}
		
		
		
		$palabras_urbanizacion=desglosarPalabrasS($urbanizacion);
		/*$palabras_marca=desglosarPalabrasS($marca);
		$palabras_modelo=desglosarPalabrasS($modelo);
		$palabras_anio=desglosarPalabrasS($anio);*/
		
		
		
		$urbanizacion="";
		$ciudad="";
		$titulo="";
		$descripcion="";

		
		
		for ($i=0;$i<count($palabras_titulo);$i++)
			$titulo.=$palabras_titulo[$i]." ";
		
		for ($i=0;$i<count($palabras_descripcion);$i++)
			$descripcion.=$palabras_descripcion[$i]." ";
		
		for ($i=0;$i<count($palabras_urbanizacion);$i++)
			$urbanizacion.=$palabras_urbanizacion[$i]." ";
			
		/*for ($i=0;$i<count($palabras_marca);$i++)
			$marca.=$palabras_marca[$i]." ";
		
		for ($i=0;$i<count($palabras_modelo);$i++)
			$modelo.=$palabras_modelo[$i]." ";
			
		for ($i=0;$i<count($palabras_anio);$i++)
			$anio.=$palabras_anio[$i]." ";*/
			
		
			
			
		
		
		
		
		$query=operacionSQL("SELECT * FROM AnuncioMetainformacion WHERE id_anuncio=".$this->id);
		if (mysql_num_rows($query)==0)
		{
			//echo "<br><br>";
			$aux="INSERT INTO AnuncioMetainformacion VALUES (".$this->id.",".$this->id_categoria.",'".$this->tipo_categoria."','".$titulo."','".$descripcion."','".$this->ciudad."','".$urbanizacion."',".$superficie.",".$habitaciones.",'".$marca."','".$modelo."','".$anio."')";
			//echo "<br><br>";
			operacionSQL($aux);
		}	
		else
		{
			//echo "<br><br>";
			$aux="UPDATE AnuncioMetainformacion SET titulo='".$titulo."', id_categoria=".$this->id_categoria.", tipo_categoria='".$this->tipo_categoria."', descripcion='".$descripcion."', ciudad='".$this->ciudad."', urbanizacion='".$urbanizacion."', superficie=".$superficie.", habitaciones=".$habitaciones.", marca='".$marca."', modelo='".$modelo."', anio='".$anio."' WHERE id_anuncio=".$this->id;
			//echo "<br><br>";
			operacionSQL($aux);
		}

	
	}
	
	
	
	
	
	function textoDescripcion()
	{
		$texto=$this->descripcion;
		for ($i=0;$i<strlen($texto);$i++)
		{
			if ($texto[$i]!='<')
				$descripcion.=$texto[$i];
			else
				while ($texto[$i]!='>')
					$i++;
		}
		
		return $descripcion;
	}
	
	
	function eliminar()
	{
		//Eliminando anuncio
		operacionSQL("DELETE FROM Anuncio WHERE id=".$this->id);
		//Eliminando comentarios
		operacionSQL("DELETE FROM Anuncio_Comentario WHERE id_anuncio=".$this->id);
		//Eliminando comentarios
		operacionSQL("DELETE FROM Anuncio_Detalles_Inmuebles WHERE id_anuncio=".$this->id);
		//Eliminando comentarios
		operacionSQL("DELETE FROM Anuncio_Detalles_Vehiculos WHERE id_anuncio=".$this->id);
		//Eliminando comentarios
		operacionSQL("DELETE FROM Anuncio_Info WHERE id_anuncio=".$this->id);
		//Eliminando comentarios
		operacionSQL("DELETE FROM AnuncioMensaje WHERE id_anuncio=".$this->id);
		//Eliminando comentarios
		operacionSQL("DELETE FROM AnuncioMetainformacion WHERE id_anuncio=".$this->id);
		//Eliminando comentarios
		operacionSQL("DELETE FROM AnuncioVisita WHERE id_anuncio=".$this->id);
		
		
		//ELIMINANDO FOTOS
		if ($this->foto1=="SI")
			unlink("/mnt/hispamercado/img/img_bank/".$this->id."_1");
		if ($this->foto2=="SI")
			unlink("/mnt/hispamercado/img/img_bank/".$this->id."_2");	
		if ($this->foto3=="SI")
			unlink("/mnt/hispamercado/img/img_bank/".$this->id."_3");
		if ($this->foto4=="SI")
			unlink("/mnt/hispamercado/img/img_bank/".$this->id."_4");
		if ($this->foto5=="SI")
			unlink("/mnt/hispamercado/img/img_bank/".$this->id."_5");
		if ($this->foto6=="SI")
			unlink("/mnt/hispamercado/img/img_bank/".$this->id."_6");

	}
	
	
	
	function inactivar($revision)
	{
		operacionSQL("UPDATE Anuncio_Info SET fecha_inactivo=CURDATE() WHERE id_anuncio=".$this->id);
		operacionSQL("UPDATE Anuncio SET status_general='Inactivo', status_revision='".$revision."' WHERE id=".$this->id);
	}
}



class Categoria
{
	var $id;
	var $nombre;
	var $id_categoria;
	var $orden;
	
	function Categoria($id)
	{
		$query=operacionSQL("SELECT * FROM Categoria WHERE id=".$id);
		
		$this->id=$id;
		$this->nombre=mysql_result($query,0,1);
		$this->id_categoria=mysql_result($query,0,2);
		$this->orden=mysql_result($query,0,3);
	}
	
	
	function armarEnlace()
	{
		$arbol=$this->arbolDeHoja();
		$niveles=count($arbol);
		
		$enlace="";
		for ($i=($niveles-1);$i>=0;$i--)
		{
			$nombre_cat=$arbol[$i]['nombre'];
			$nombre_cat=limpiarEnies($nombre_cat);
			$palabras=desglosarPalabrasS($nombre_cat);
			
			for ($e=0;$e<count($palabras);$e++)
			{
				$enlace.=$palabras[$e]."-";
			}		
		}
		
		return $enlace.="cat-".$this->id."/";
	}
	
	function esPadre()
	{
		$query=operacionSQL("SELECT id FROM `Categoria` WHERE id_categoria IS NULL");
		$num=mysql_num_rows($query);
		
		for ($i=0;$i<$num;$i++)
			if (mysql_result($query,$i,0)==$this->id)
				return true;
		
		return false;
		
	}
	
	function esHoja()
	{
		$query=operacionSQL("SELECT * FROM `Categoria` WHERE id_categoria=".$this->id);
		if (mysql_num_rows($query)>0)
			return false;
		else
			return true;
	}
	
	
	function arbolDeHoja()
	{
		$aux="SELECT id_categoria FROM Categoria WHERE id_categoria IS NULL AND id=".$this->id;
		$query=operacionSQL($aux);
		
		if (mysql_num_rows($query)>0)
		{
			$arbol[0]['id']=$this->id;
			$arbol[0]['nombre']=$this->nombre;
			
			return $arbol;
		}	
		
		$query=operacionSQL("SELECT id_categoria FROM Categoria WHERE id=".$this->id);	
		$id1=mysql_result($query,0,0);
		
		$tercera=false;	
		$aux="SELECT id_categoria FROM Categoria WHERE id=".$id1." AND id_categoria IS NULL";
		$query=operacionSQL($aux);

		if (mysql_num_rows($query)==0)
		{
			$query=operacionSQL("SELECT id_categoria FROM Categoria WHERE id=".$id1);
			$id2=mysql_result($query,0,0);
			$tercera=true;
		}
		
		$arbol[0]['id']=$this->id;
		$arbol[0]['nombre']=$this->nombre;
		
		$categoria1=new Categoria($id1);
		$arbol[1]['id']=$id1;
		$arbol[1]['nombre']=$categoria1->nombre;
		
		if ($tercera)
		{
			$categoria2=new Categoria($id2);
			$arbol[2]['id']=$id2;
			$arbol[2]['nombre']=$categoria2->nombre;
		}	
		
		
		return $arbol;
	}
	
	function hijos()
	{	
		$query=operacionSQL("SELECT id FROM Categoria WHERE id_categoria=".$this->id);
		$num=mysql_num_rows($query);
		
		$indice=0;
		$categorias[$indice]=$this->id;
		$indice++;	
		
		for ($i=0;$i<$num;$i++)
		{
			$categorias[$indice]=mysql_result($query,$i,0);
			$indice++;
			
			$query2=operacionSQL("SELECT id FROM Categoria WHERE id_categoria=".mysql_result($query,$i,0));
			for ($e=0;$e<mysql_num_rows($query2);$e++)
			{
				$categorias[$indice]=mysql_result($query2,$e,0);
				$indice++;
					
				$query3=operacionSQL("SELECT id FROM Categoria WHERE id_categoria=".mysql_result($query2,$e,0));
				for ($j=0;$j<mysql_num_rows($query3);$j++)
				{
					$categorias[$indice]=mysql_result($query3,$j,0);
					$indice++;
				}
			}
		}
		
		return $categorias;
	}
	
	function hijosInmediatos()
	{
		$query=operacionSQL("SELECT id FROM Categoria WHERE id_categoria=".$this->id);
		$num=mysql_num_rows($query);
		
		$indice=0;
		$categorias=array();
		
		for ($i=0;$i<$num;$i++)
		{
			$categorias[$indice]=mysql_result($query,$i,0);
			$indice++;
		}
		
		return $categorias;
	}
	
	function anunciosActivos()
	{
		$hijos=$this->hijos();		
		$suma=0;
		for ($i=0;$i<count($hijos);$i++)
		{
			$aux="SELECT COUNT(*) FROM Anuncio WHERE status_general='Activo' AND id_categoria=".$hijos[$i];
			$query=operacionSQL($aux);
			$suma=$suma+mysql_result($query,0,0);
		}
		
		return $suma;	
	}
	
	function anunciosActivosCache()
	{
		$query=operacionSQL("SELECT cantidad FROM CategoriaAnunciosActivos WHERE id_categoria=".$this->id);
		
		return mysql_result($query,0,0);
	}
	
	
	function patriarca()
	{
		$id_actual=$this->id;
		while (true)
		{
			$query=operacionSQL("SELECT id_categoria FROM Categoria WHERE id=".$id_actual);
			if (mysql_result($query,0,0)=="")
				return $id_actual;
			else
				$id_actual=mysql_result($query,0,0);
		}
	}
	
	
	function acciones()
	{
		$query=operacionSQL("SELECT nombre FROM Categoria_Accion WHERE id_categoria=".$this->id);
		for ($e=0;$e<mysql_num_rows($query);$e++)
			$arre[$e]=mysql_result($query,$e,0);
		
		return $arre;

	}
	
	
}


class Usuario
{
	var $id;
	var $fb_id;
	var $fb_nick;
	var $nombre;
	var $email;
	var $fb_token;
	var $fb_token_expires;
	var $cookie;
	var $status;


	function Usuario($id)
	{
		$query=operacionSQL("SELECT * FROM Usuario WHERE id=".$id);
		
		$this->id=$id;
		$this->fb_id=mysql_result($query,0,1);
		$this->fb_nick=mysql_result($query,0,2);
		$this->nombre=mysql_result($query,0,3);
		$this->email=mysql_result($query,0,4);
		$this->fb_token=mysql_result($query,0,5);
		$this->fb_token_expires=mysql_result($query,0,6);
		$this->cookie=mysql_result($query,0,7);	
		$this->status=mysql_result($query,0,8);
	}
	
	function idTienda()
	{
		$query=operacionSQL("SELECT id FROM Tienda WHERE id_usuario=".$this->id);
		
		if (mysql_num_rows($query)>0)
			return mysql_result($query,0,0);
		else
			return false;
	}
}


//****************************************************************************************



class Tienda
{
	var $id;
	var $id_usuario;
	var $nick;
	var $nombre;
	var $descripcion;
	var $logo;
	var $status;
	
	function Tienda($id)
	{
		$aux="SELECT * FROM Tienda WHERE id=".$id;
		$query=operacionSQL($aux);
		
		$this->id=$id;
		$this->id_usuario=mysql_result($query,0,1);
		$this->nick=mysql_result($query,0,2);
		$this->nombre=mysql_result($query,0,3);
		$this->descripcion=mysql_result($query,0,4);
		$this->logo=mysql_result($query,0,5);
		$this->status=mysql_result($query,0,6);
	}	
}




class Conversacion
{
	var $id;
	var $id_usuario;
	var $id_categoria;
	var $fecha;
	var $anunciante_nombre;
	var $anunciante_email;
	var $titulo;
	var $descripcion;
	var $notificaciones;
	var $status;
	
	function Conversacion($id)
	{
		$aux="SELECT * FROM Conversacion WHERE id=".$id;
		$query=operacionSQL($aux);
		
		$this->id=$id;
		$this->id_usuario=mysql_result($query,0,1);
		$this->id_categoria=mysql_result($query,0,2);
		$this->fecha=mysql_result($query,0,3);
		$this->anunciante_nombre=mysql_result($query,0,4);
		$this->anunciante_email=mysql_result($query,0,5);
		$this->titulo=mysql_result($query,0,6);
		$this->descripcion=mysql_result($query,0,7);
		$this->notificaciones=mysql_result($query,0,8);
		$this->status=mysql_result($query,0,9);
	}
	
	function tiempoHace()
	{
		$query=operacionSQL("SELECT TIMEDIFF(NOW(),'".$this->fecha."')");
		$horas=substr(mysql_result($query,0,0),0,2);
		
		if ($horas<=0)
			return "menos de una hora";
		if ($horas<24)
			return $horas." horas";
		else
		{
			$query=operacionSQL("SELECT DATEDIFF(NOW(),'".$this->fecha."')");
			$dias=mysql_result($query,0,0);
			return $dias." dias";
		}
	}
	
	function armarEnlace()
	{
		$titulo=limpiarEnies($this->titulo);
		$palabras=desglosarPalabrasS($titulo);
		
		$enlace="";
		
		for ($j=0;$j<count($palabras);$j++)
			$enlace.=$palabras[$j]."-";
		
		
		$enlace=substr($enlace,0,200);
		
		$len=strlen($enlace);
		if ($enlace[$len-1]!='-')
			$enlace.="-conversacion-".$this->id;
		else
			$enlace.="conversacion-".$this->id;
		
				
		return $enlace;
	}
	
	
}



?>