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
	var $id_provincia;
	var $id_pais;
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
		$this->id_provincia=mysql_result($query,0,11);
		$this->id_pais=mysql_result($query,0,12);
		$this->foto1=mysql_result($query,0,13);
		$this->foto2=mysql_result($query,0,14);
		$this->foto3=mysql_result($query,0,15);
		$this->foto4=mysql_result($query,0,16);
		$this->foto5=mysql_result($query,0,17);
		$this->foto6=mysql_result($query,0,18);
		$this->video_youtube=mysql_result($query,0,19);
		$this->anunciante_email=mysql_result($query,0,20);
		$this->anunciante_nombre=mysql_result($query,0,21);
		$this->anunciante_telefonos=mysql_result($query,0,22);
		$this->status_general=mysql_result($query,0,23);
		$this->status_revision=mysql_result($query,0,24);
		
		//echo $this->id."<br>";
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
		$palabras=desglosarPalabras($titulo);
		
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
		
		if ($this->id_provincia=="")
			$provincia="";
		else
		{	
			$provincia=new Provincia($this->id_provincia);
			$provincia=", ".$provincia->nombre;
		}
		
		//$provincia=new Provincia($this->id_provincia);		
		
		if ($this->compruebaFavorito($_COOKIE['hispamercado_favoritos'])==0)
			$favoritos="<a href='javascript:aFavoritos(".$this->id.",".chr(34).chr(34).")'><img src='img/favorito0.gif' title='A&ntilde;adir a favoritos' width='26' height='25' border='0'></a>";
		else	
			$favoritos="<a href='javascript:quitaFavoritos(".$this->id.",".chr(34).chr(34).")'><img src='img/favorito1.gif' title='Quitar de favoritos' width='26' height='25' border='0'></a>";

		
		if (($this->precio=="")||($this->precio==0))
			$precio="no indicado";
		else
			$precio=number_format($this->precio,2,",",".")." ".$this->moneda;
			
			
		
		//ARMANDO ENLADE
		$enlace=$this->armarEnlace();
		
				
		$anuncio="<table id='contenedor_principal' width='800' height='80' border='0' align='center' cellpadding='0' cellspacing='2' bgcolor='".$color."'>
				  <tr>
					<td id='anuncio_imagen' width='90' align='center'><a href='".$enlace."'><img border='0' src='lib/img.php?tipo=lista&anuncio=".$this->id."' alt='".$this->titulo."' title='".$this->titulo."'></a></td>
					<td id='anuncio_contenido' width='682'><table width='670'  border='0' align='center' cellpadding='0' cellspacing='0'>
						<tr>
						  <td height='60' valign='top' align='left'><a href='".$enlace."' class='LinkArticulo'>".$this->titulo."</a></td>
						</tr>
						<tr>
						  <td align='left' class='arial13Negro'><b>Fecha:</b> ".aaaammdd_ddmmaaaa($this->fecha)." | <b>Ubicaci&oacute;n:</b> ".$this->ciudad.$provincia." | <b>Precio:</b> ".$precio." | <b>Tipo:</b> ".$this->tipo_categoria."</td>
						</tr>
					</table></td>
					<td width='28' align='center' id='anuncio_contenido'><table width='100%' height='71'  border='0' cellpadding='0' cellspacing='0'>
						<tr>
						  <td valign='top' id='favorito_".$this->id."'>".$favoritos."</td>
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


	function armarAnuncioGestion($color)
	{
		
		if ($this->id_provincia=="")
			$provincia="";
		else
		{	
			$provincia=new Provincia($this->id_provincia);
			$provincia=", ".$provincia->nombre;
		}
		
		//$provincia=new Provincia($this->id_provincia);		
		
		/*if ($this->compruebaFavorito($_COOKIE['hispamercado_favoritos'])==0)
			$favoritos="<a href='javascript:aFavoritos(".$this->id.",".chr(34).chr(34).")'><img src='img/favorito0.gif' title='A&ntilde;adir a favoritos' width='26' height='25' border='0'></a>";
		else	
			$favoritos="<a href='javascript:quitaFavoritos(".$this->id.",".chr(34).chr(34).")'><img src='img/favorito1.gif' title='Quitar de favoritos' width='26' height='25' border='0'></a>";*/

		
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
	
	
	
	function metainformacion2()
	{
		$palabras_titulo=desglosarPalabras($this->titulo);
		//$palabras_titulo=filtrarConectivos($palabras_titulo);
		
		$palabras_descripcion=desglosarPalabras($this->descripcion);
		//$palabras_descripcion=filtrarConectivos($palabras_descripcion);
		
		
		
		$detalles=$this->ciudad;
		$pro=new Provincia($this->id_provincia);
		$detalles.=" ".$pro->nombre;		
		$id_cat=$this->id_categoria;
		
		
		//CASO INMUEBLES
		if (($id_cat==4)||($id_cat==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707)||($id_cat==3707))
		{
			$aux=$this->detalles();
			$detalles.=" ".$aux['urbanizacion'];
			
		}
		//CASO VEHICULOS
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{
			$aux=$this->detalles();
			$detalles.=" ".$aux['marca'];
			$detalles.=" ".$aux['modelo'];
			$detalles.=" ".$aux['anio'];
		}
		
		$palabras_detalles=desglosarPalabras($detalles);
		$palabras_detalles=filtrarConectivos($palabras_detalles);
		
		
		for ($i=0;$i<count($palabras_titulo);$i++)
			$titulo.=$palabras_titulo[$i]." ";
		
		for ($i=0;$i<count($palabras_descripcion);$i++)
			$descripcion.=$palabras_descripcion[$i]." ";
		
		for ($i=0;$i<count($palabras_detalles);$i++)
			$detalles_aux.=$palabras_detalles[$i]." ";
		
		
		$query=operacionSQL("SELECT * FROM AnuncioMetainformacion WHERE id_anuncio=".$this->id);
		if (mysql_num_rows($query)==0)
			operacionSQL("INSERT INTO AnuncioMetainformacion VALUES (".$this->id.",'".$titulo."','".$descripcion."','".$detalles_aux."')");
		else
			operacionSQL("UPDATE AnuncioMetainformacion SET titulo='".$titulo."', descripcion='".$descripcion."', detalles='".$detalles_aux."' WHERE id_anuncio=".$this->id);

		//return $titulo." ".$descripcion." ".$detalles_aux;
	
	}
	
	
	function metainformacion()
	{
		$palabras_titulo=desglosarPalabras($this->titulo);
		$palabras_titulo=filtrarConectivos($palabras_titulo);
		
		$palabras_descripcion=desglosarPalabras($this->descripcion);
		$palabras_descripcion=filtrarConectivos($palabras_descripcion);
		
		
		
		$ciudad=$this->ciudad;
		$pro=new Provincia($this->id_provincia);
		$ciudad.=" ".$pro->nombre;		
		
		
		
		$id_cat=$this->id_categoria;
		
		$urbanizacion="";
		$marca="";
		$modelo="";
		$anio="";
		
		
		//CASO INMUEBLES
		if (($id_cat==4)||($id_cat==3)||($id_cat==5)||($id_cat==6)||($id_cat==7)||($id_cat==8)||($id_cat==9)||($id_cat==10)||($id_cat==3707)||($id_cat==3707))
		{
			$aux=$this->detalles();
			$urbanizacion=$aux['urbanizacion'];
			
		}
		//CASO VEHICULOS
		if (($id_cat==11)||($id_cat==12)||($id_cat==16)||($id_cat==13)||($id_cat==14))
		{
			$aux=$this->detalles();
			$marca=$aux['marca'];
			$modelo=$aux['modelo'];
			$anio=$aux['anio'];
		}
		
		
		
		$palabras_urbanizacion=desglosarPalabras($urbanizacion);
		$palabras_marca=desglosarPalabras($marca);
		$palabras_modelo=desglosarPalabras($modelo);
		$palabras_anio=desglosarPalabras($anio);
		
		
		$urbanizacion="";
		$marca="";
		$modelo="";
		$anio="";

		
		
		for ($i=0;$i<count($palabras_titulo);$i++)
			$titulo.=$palabras_titulo[$i]." ";
		
		for ($i=0;$i<count($palabras_descripcion);$i++)
			$descripcion.=$palabras_descripcion[$i]." ";
		
		for ($i=0;$i<count($palabras_urbanizacion);$i++)
			$urbanizacion.=$palabras_urbanizacion[$i]." ";
			
		for ($i=0;$i<count($palabras_marca);$i++)
			$marca.=$palabras_marca[$i]." ";
		
		for ($i=0;$i<count($palabras_modelo);$i++)
			$modelo.=$palabras_modelo[$i]." ";
			
		for ($i=0;$i<count($palabras_anio);$i++)
			$anio.=$palabras_anio[$i]." ";
			
			
		
		
		
		
		$query=operacionSQL("SELECT * FROM AnuncioMetainformacion WHERE id_anuncio=".$this->id);
		if (mysql_num_rows($query)==0)
			operacionSQL("INSERT INTO AnuncioMetainformacion VALUES (".$this->id.",'".$titulo."','".$descripcion."','".$ciudad."','".$urbanizacion."','".$marca."','".$modelo."','".$anio."')");
		else
			operacionSQL("UPDATE AnuncioMetainformacion SET titulo='".$titulo."', descripcion='".$descripcion."', ciudad='".$ciudad."', urbanizacion='".$urbanizacion."', marca='".$marca."', modelo='".$modelo."', anio='".$anio."' WHERE id_anuncio=".$this->id);

		//return $titulo." ".$descripcion." ".$detalles_aux;
	
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
	var $id_pais;
	
	function Categoria($id)
	{
		$query=operacionSQL("SELECT * FROM Categoria WHERE id=".$id);
		
		$this->id=$id;
		$this->nombre=mysql_result($query,0,1);
		$this->id_categoria=mysql_result($query,0,2);
		$this->orden=mysql_result($query,0,3);
		$this->id_pais=mysql_result($query,0,4);		
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
			$palabras=desglosarPalabras($nombre_cat);
			
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
	var $user;
	var $email;
	var $nombre;
	var $telefonos;
	var $provincia;
	var $ciudad;
	var $direccion;
	var $validado;
	var $fecha_registro;
	var $pais;
	var $web;


	function Usuario($id)
	{
		$query=operacionSQL("SELECT * FROM Usuario WHERE id=".$id);
		
		$this->id=$id;
		$this->user=mysql_result($query,0,1);
		$this->email=mysql_result($query,0,2);
		$this->nombre=mysql_result($query,0,3);
		$this->telefonos=mysql_result($query,0,4);
		$this->provincia=mysql_result($query,0,6);
		$this->ciudad=mysql_result($query,0,7);
		$this->direccion=mysql_result($query,0,8);	
		$this->validado=mysql_result($query,0,9);
		$this->fecha_registro=mysql_result($query,0,10);
		$this->pais=mysql_result($query,0,11);
		$this->web=mysql_result($query,0,12);		
	}
	
	function numAnunciosActivos()
	{
		$aux="SELECT count(*) FROM Anuncio WHERE id_usuario='".$this->id."' AND status_general='Activo'";
		$query=operacionSQL($aux);
		return mysql_result($query,0,0);
	}
	
	
}


//****************************************************************************************

class Pais
{
	var $id;
	var $nombre;
	var $gmt;
	var $dominio;
	var $status;
		
	
	function Pais($id)
	{
		$query=operacionSQL("SELECT * FROM Pais WHERE id='".$id."'");
		
		$this->id=$id;
		$this->nombre=mysql_result($query,0,1);
		$this->gmt=mysql_result($query,0,2);
		$this->dominio=mysql_result($query,0,3);
		$this->status=mysql_result($query,0,3);
	}
	
	function monedas()
	{
		$query=operacionSQL("SELECT moneda FROM Pais_Moneda WHERE id_pais='".$this->id."' ORDER BY orden ASC");
		for ($i=0;$i<mysql_num_rows($query);$i++)
			$arreglo[$i]=mysql_result($query,$i,0);
	
		return $arreglo;
	}

}

//****************************************************************************************

class Provincia
{
	var $id;
	var $id_pais;
	var $nombre;
	var $status;
		
	
	function Provincia($id)
	{
		$query=operacionSQL("SELECT * FROM Provincia WHERE id='".$id."'");
		
		$this->id=$id;
		$this->id_pais=mysql_result($query,0,1);		
		$this->nombre=mysql_result($query,0,2);
		$this->status=mysql_result($query,0,3);
	}

}

//****************************************************************************************

class Tienda
{
	var $id;
	var $usuario;
	var $logo;
	var $descripci�n;
	
	function Tienda($id)
	{
		$aux="SELECT * FROM Tienda WHERE id=".$id;
		$query=operacionSQL($aux);
		
		$this->id=$id;
		$this->id_usuario=mysql_result($query,0,1);
		$this->logo=mysql_result($query,0,2);
		$this->descripcion=mysql_result($query,0,3);
	}	
	
	function armaTienda()
	{
		$usuario=new Usuario($this->id_usuario);
		
		return "<table width='800' height='70'  border='0' align='center' cellpadding='0' cellspacing='0'>
		  <tr>
			<td width='150' valign='center' align='center'><a href='tienda.php?user=".strtolower($usuario->user)."'><img src='lib/logo.php?tienda=".strtolower($usuario->user)."' border='0'></a></td>
			<td width='650' class='arial11Negro'><table width='640' border='0' align='center' cellpadding='0' cellspacing='3'>
			  <tr>
				<td><a href='tienda.php?user=".strtolower($usuario->user)."'><strong>".$usuario->nombre."</strong></a></td>
			  </tr>
			  <tr>
				<td>".substr($this->descripcion,0,245)."...</td>
			  </tr>
			  <tr>
				<td><b>".$usuario->ciudad.", ".$usuario->provincia."</b></td>
			  </tr>
			  <tr>
				<td><div align='right'><span class='arial11Rojo'><b>".$usuario->numAnunciosActivos()." anuncios publicados</b></span></div></td>
			  </tr>
			</table></td>
		  </tr>
		</table>
		<table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor='#C8C8C8'>
			<tr>
				<td height='1'></td>
			</tr>
		</table>";
	}
	
	function politicas()
	{
		$arreglo=array();
		$aux="SELECT * FROM Tienda_Politicas WHERE id_tienda=".$this->id;
		$query=operacionSQL($aux);
		
		for ($i=0;$i<mysql_num_rows($query);$i++)
			$arreglo[$i]=mysql_result($query,$i,1);
		
		return $arreglo;
	}	
	
}



?>