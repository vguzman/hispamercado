<?

function operacionSQL($aux)
{
	$link=mysql_connect ("localhost","hispamercado","h1sp@merc@do") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("hispamercado"); 
	
	$query=mysql_query($aux,$link);
		
	if (!($query))
		echo mysql_error();
	else
		return $query;	
}


function operacionSQLSpam($aux)
{
	$link=mysql_connect ("74.52.154.242","vmgafrm_root","21381665") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("vmgafrm_spam"); 
	
	$query=mysql_query($aux,$link);
		
	if (!($query))
		echo mysql_error();
	else
		return $query;	
}



function bloquearEmail($email)
{
	
	
	$query=operacionSQL("SELECT id FROM Anuncio WHERE status_general<>'Inactivo' AND anunciante_email='".$email."'");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		
		$id_anuncio=mysql_result($query,$i,0);
		$anuncio=new Anuncio($id_anuncio);
		$anuncio->inactivar("Reprobado");	
		
	}
	
	
	
	operacionSQL("INSERT INTO EmailsBloqueados VALUES ('".$email."')");
	
	
	
	
	
	
}


function verificaPais()
{
	if (substr_count($_SERVER['HTTP_HOST'],"hispamercado.com.ve")>0)
		return "venezuela";	
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>
				location.href='http://www.hispamercado.com.ve/';
			</script>";
}

function barraPrincipal($nivel)
{
	return "<table width='810' border='0' align='center' cellpadding='0' cellspacing='0' background='".$nivel."img/fondo_barra4.jpg'>
			  <tr>
				<td height='35' class='barraPrincipal' align='center'><a href='".$nivel."publicar/' class='barraPrincipal'><b>Publicar anuncio GRATIS</b></a> | <a href='".$nivel."gestionar/' class='barraPrincipal'><strong>Gestionar mis anuncios</strong></a> | <a href='".$nivel."favoritos.php' class='barraPrincipal'><b>Mis anuncios favoritos</b></a> | <a href='javascript:enConstruccion()'class='barraPrincipal'><strong>Alertas</strong></a></td>
			  </tr>
			</table>";
}

function barraLogueo()
{
	if (isset($_SESSION['user'])) 
		return "Logueado como <b>".$_SESSION['user']."</b> (<a href='cerrarSesion.php' class='LinkFuncionalidad'>salir</a>)<br>";
	else
		return "<a href='javascript:clik_entrar()' class='LinkFuncionalidad'><b>Entrar</b></a> | <a href='javascript:clik_entrar()' class='LinkFuncionalidad'><b>Reg&iacute;strate</b></a> | ";
}


function barraPaises($id_pais)
{
	$query=operacionSQL("SELECT id,nombre,dominio FROM Pais WHERE status='Activo'");
	$total=mysql_num_rows($query);
		
	$barra="";
	for ($i=0;$i<$total;$i++)
	{			
		if ($id_pais!=mysql_result($query,$i,0))
		{
			$barra.="<a href='".mysql_result($query,$i,0)."/' class='LinkFuncionalidad13'>".mysql_result($query,$i,1)."</a> ";
		}
		else
		{
			$barra.="<b>".mysql_result($query,$i,1)."</b> ";
		}
		if ($i+1<$total)
			$barra.="| ";			
	}
	
	return $barra;			
}

function cookieSesion($codigo,$dominio)
{
	if (isset($_COOKIE['hispamercado_favoritos'])==false)
		setcookie("hispamercado_favoritos",$codigo,time()+2500000,"/",$dominio);		
}
	
function nombrePais($id)
{
	$query=operacionSQL("SELECT nombre FROM pais WHERE id='".$id."'");
	return $nombre_pais=mysql_result($query,0,0);
}	
	
function dameMes($mes)
{
	if ($mes==1)
		return "enero";
	if ($mes==2)
		return "febrero";
	if ($mes==3)
		return "marzo";
	if ($mes==4)
		return "abril";
	if ($mes==5)
		return "mayo";
	if ($mes==6)
		return "junio";
	if ($mes==7)
		return "julio";
	if ($mes==8)
		return "agosto";
	if ($mes==9)
		return "septiembre";
	if ($mes==10)
		return "octubre";
	if ($mes==11)
		return "noviembre";
	if ($mes==12)
		return "diciembre";	
}



function categorias_principales($pais)
{
	$query=operacionSQL("SELECT id,nombre FROM Categoria WHERE id_categoria IS NULL AND id_pais='".$pais."'");
	$total=mysql_num_rows($query);	
		
	for ($i=0;$i<$total;$i++)
	{
		$categorias[$i]['id']=mysql_result($query,$i,0);
		$categorias[$i]['nombre']=mysql_result($query,$i,1);
	}
	
	return $categorias;
}


function arma_anuncio_usuario($id,$color,$pais,$tipo)
{	
	$aux="SELECT texto,DATE_FORMAT(fecha,'%d-%m-%Y'),ciudad,provincia,precio,moneda,id,status FROM anuncio WHERE id=".$id;	
	$query=operacionSQL($aux);	
	
	//ESTE PEDACITO ES PARA VER SI YA ESTA EN FAVORITOS
	$query2=operacionSQL("SELECT * FROM favoritos WHERE id_anuncio=".mysql_result($query,0,6)." AND sesion='".session_id()."'");
	if (mysql_num_rows($query2)==1)
		$favoritos="<a href='javascript:quitaFavoritos(".mysql_result($query,0,6).")'><img src='img/favorito1.gif' title='Quitar de favoritos' width='26' height='25' border='0'></a>";
	else
		$favoritos="<a href='javascript:aFavoritos(".mysql_result($query,0,6).")'><img src='img/favorito0.gif' title='A&ntilde;adir a favoritos' width='26' height='25' border='0'></a>";
	//*********************************************************************	
		
	
	//*******************************************************************
	if (mysql_result($query,0,7)=="Activo")
	{
		$extender="<a href='javascript:extender(".mysql_result($query,0,6).")' class='Arial11Azul'>Extender</a>";
		$finalizar="<a href='javascript:finalizar(".mysql_result($query,0,6).")' class='Arial11Azul'>Finalizar</a>";
	}
	else
	{
		$extender="Extender";
		$finalizar="<a href='javascript:reactivar(".mysql_result($query,0,6).")' class='Arial11Azul'>Reactivar</a>";
	}
	//*************************************************************************
	
		
	if (mysql_result($query,0,4)=="")
		$precio="no especificado";
	else
		$precio=mysql_result($query,0,5)." ".mysql_result($query,$i,4);
		
	if (strlen(mysql_result($query,0,0))<=250)
		$texto=mysql_result($query,0,0);
	else
		$texto=substr(mysql_result($query,0,0),0,250)."<a style='color: #000000; text-decoration: none; font-weight: 700' href=javascript:verAnuncio(".chr(34).$pais.chr(34).",".mysql_result($query,0,6).")'>...</a>";
	
	$anuncio="<table id='contenedor_principal' width='800' height='80' border='0' align='center' cellpadding='0' cellspacing='2' bgcolor='".$color."'>
			  <tr>
				<td id='anuncio_imagen' width='90' align='center'><a href='javascript:verAnuncio(".chr(34).$pais.chr(34).",".mysql_result($query,0,6).")'><img border='0' src='lib/img.php?tipo=lista&anuncio=".mysql_result($query,0,6)."' alt='Ver anuncio'></a></td>
				<td id='anuncio_contenido' width='660'><table width='645'  border='0' align='left' cellpadding='0' cellspacing='0'>
					<tr>
					  <td height='60' valign='top'><div align='justify'><font size='2' face='Arial'>".$texto."</font></div></td>
					</tr>
					<tr>
					  <td><font face='Arial' style='font-size: 8pt'><b>Fecha:</b> ".mysql_result($query,0,1)." | <b>Ubicaci&oacute;n:</b> ".mysql_result($query,0,2).", ".mysql_result($query,0,3)." | <b>Precio:</b> ".$precio." | <b>Tipo:</b> ".$tipo."</font></td>
					</tr>
				</table></td>
				<td width='50' align='center' id='anuncio_acciones'><table width='50' border='0' cellpadding='0' cellspacing='3' align='right'>
                  <tr>
                    <td width='50' align='left'><a href='javascript:gestion(".chr(34)."modificar".chr(34).",".$id.")' class='Arial11Azul'>Modificar</a></td>
                  </tr>
                  <tr>
                    <td  align='left' class='Estilo3'>".$extender."</td>
                  </tr>
                  <tr>
                    <td align='left'>".$finalizar."</td>
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

function hijos_hijos($id_cat)
{	
	$query=operacionSQL("SELECT id FROM categoria WHERE id_categoria=".$id_cat);
	$num=mysql_num_rows($query);
	
	$indice=0;
	$categorias[$indice]=$id_cat;
	$indice++;	
	
	for ($i=0;$i<$num;$i++)
	{
		$categorias[$indice]=mysql_result($query,$i,0);
		$indice++;
		
		$query2=operacionSQL("SELECT id FROM categoria WHERE id_categoria=".mysql_result($query,$i,0));
		for ($e=0;$e<mysql_num_rows($query2);$e++)
		{
			$categorias[$indice]=mysql_result($query2,$e,0);
			$indice++;
				
			$query3=operacionSQL("SELECT id FROM categoria WHERE id_categoria=".mysql_result($query2,$e,0));
			for ($j=0;$j<mysql_num_rows($query3);$j++)
			{
				$categorias[$indice]=mysql_result($query3,$j,0);
				$indice++;
			}
		}
	}
	
	return $categorias;
}


function dame_padre($id_categoria)
{
	$id_padre=$id_categoria;
	
	$aux="SELECT id_categoria FROM categoria WHERE id_categoria IS NOT NULL AND id=".$id_categoria;
	$query=operacionSQL($aux);
	if (mysql_num_rows($query)>0)
	{
		$id_padre=mysql_result($query,0,0);
		$aux="SELECT id_categoria FROM categoria WHERE id_categoria IS NOT NULL AND id=".$id_padre;
		$query=operacionSQL($aux);
		if (mysql_num_rows($query)>0)
			$id_padre=mysql_result($query,0,0);
	}
	$aux="SELECT nombre FROM categoria WHERE id=".$id_padre;
	$query=operacionSQL($aux);
	
	$resultado['id']=$id_padre;
	$resultado['nombre']=mysql_result($query,0,0);
	
	return $resultado;	
}


function acciones_categoria($id_categoria)
{
	$id_padre=$id_categoria;
	
	$aux="SELECT id_categoria FROM categoria WHERE id_categoria IS NOT NULL AND id=".$id_categoria;
	$query=operacionSQL($aux);
	if (mysql_num_rows($query)>0)
	{
		$id_padre=mysql_result($query,0,0);
		$aux="SELECT id_categoria FROM categoria WHERE id_categoria IS NOT NULL AND id=".$id_padre;
		$query=operacionSQL($aux);
		if (mysql_num_rows($query)>0)
			$id_padre=mysql_result($query,0,0);
	}
	
	//Ya tengo el padre, ahora voy por las acciones
	
	$aux="SELECT nombre FROM accion WHERE id_categoria=".$id_padre;
	$query=operacionSQL($aux);
	for ($i=0;$i<mysql_num_rows($query);$i++)
		$acciones[$i]=mysql_result($query,$i,0);
		
	return $acciones;	
}


function motorBusqueda($busqueda,$id_cat,$accion,$provincia,$pais)
{
	//----------Busqueda coincide exactamente con alguna parte--------------
	if ($id_cat!="NULL")
	{
		$arbol=hijos_hijos($id_cat);
		$hijos=count($arbol);
		
		if ($hijos>1)
			$aux="SELECT A.id_anuncio,A.tipo,A.id_categoria FROM anuncio_categoria A, anuncio B, categoria C WHERE A.id_anuncio=B.id AND B.pais='".$pais."' AND A.id_categoria=C.id AND C.id_categoria=".$id_cat." AND B.status='Activo' AND MATCH(ciudad,provincia,texto)
			AGAINST ('".chr(34).$busqueda.chr(34)."' IN BOOLEAN MODE)";		
		else
			$aux="SELECT A.id_anuncio,A.tipo,A.id_categoria FROM anuncio_categoria A, anuncio B, categoria C WHERE A.id_anuncio=B.id AND B.pais='".$pais."' AND A.id_categoria=C.id AND A.id_categoria=".$id_cat." AND B.status='Activo' AND MATCH(ciudad,provincia,texto)
			AGAINST ('".chr(34).$busqueda.chr(34)."' IN BOOLEAN MODE)";		
		if ($accion!="NULL")
			$aux.=" AND A.tipo='".$accion."'";
		if ($provincia!="NULL")
			$aux.=" AND B.provincia='".$provincia."'";		

	}
	else
	{
		$aux="SELECT A.id_anuncio,A.tipo,A.id_categoria FROM anuncio_categoria A, anuncio B WHERE A.id_anuncio=B.id AND B.pais='".$pais."'  AND B.status='Activo' AND MATCH(ciudad,provincia,texto)
			AGAINST ('".chr(34).$busqueda.chr(34)."' IN BOOLEAN MODE)";		
		if ($accion!="NULL")
			$aux.=" AND A.tipo='".$accion."'";
		if ($provincia!="NULL")
			$aux.=" AND B.provincia='".$provincia."'";		
	}
	//echo $aux."<br><br>";
	$query=operacionSQL($aux);
	$num=mysql_num_rows($query);
	
	$indice=0;
	for ($i=$num-1;$i>=0;$i--)
	{	
		$resultado[$indice]['id']=mysql_result($query,$i,0);
		$resultado[$indice]['tipo']=mysql_result($query,$i,1);
		$resultado[$indice]['id_cat']=mysql_result($query,$i,2);
		$indice++;
	}		
	
	
	//----------Busqueda coincide con algunas palabras--------------
	
	if ($id_cat!="NULL")
	{
		$arbol=hijos_hijos($id_cat);
		$hijos=count($arbol);
		
		if ($hijos>1)
			$aux="SELECT A.id_anuncio,A.tipo,A.id_categoria FROM anuncio_categoria A, anuncio B, categoria C WHERE A.id_anuncio=B.id AND A.id_categoria=C.id AND B.status='Activo' AND B.pais='".$pais."' AND C.id_categoria=".$id_cat." AND MATCH(ciudad,provincia,texto)
			AGAINST ('".$busqueda."' IN BOOLEAN MODE)";		
		else
			$aux="SELECT A.id_anuncio,A.tipo,A.id_categoria FROM anuncio_categoria A, anuncio B, categoria C WHERE A.id_anuncio=B.id AND A.id_categoria=C.id AND B.status='Activo' AND B.pais='".$pais."' AND A.id_categoria=".$id_cat." AND MATCH(ciudad,provincia,texto)
			AGAINST ('".$busqueda."' IN BOOLEAN MODE)";	
		if ($accion!="NULL")
			$aux.=" AND A.tipo='".$accion."'";
		if ($provincia!="NULL")
			$aux.=" AND B.provincia='".$provincia."'";		

	}
	else
	{
		$aux="SELECT A.id_anuncio,A.tipo,A.id_categoria FROM anuncio_categoria A, anuncio B WHERE A.id_anuncio=B.id AND B.pais='".$pais."' AND B.status='Activo' AND MATCH(ciudad,provincia,texto)
			AGAINST ('".$busqueda."' IN BOOLEAN MODE)";		
		if ($accion!="NULL")
			$aux.=" AND A.tipo='".$accion."'";
		if ($provincia!="NULL")
			$aux.=" AND B.provincia='".$provincia."'";		
	}	
	//echo $aux."<br><br>";
	$query=operacionSQL($aux);
	$num=mysql_num_rows($query);	
	
	for ($i=$num-1;$i>=0;$i--)
	{	
		$resultado[$indice]['id']=mysql_result($query,$i,0);
		$resultado[$indice]['tipo']=mysql_result($query,$i,1);
		$resultado[$indice]['id_cat']=mysql_result($query,$i,2);
		$indice++;
	}
	
	//Depuración de resultados repetidos
	$indice=0;
	for ($i=0;$i<count($resultado);$i++)
	{	
		$esta=false;
		for ($w=0;$w<count($anuncios);$w++)
		{
			if (($anuncios[$w]['id']==$resultado[$i]['id'])&&($anuncios[$w]['id_cat']==$resultado[$i]['id_cat']))
			$esta=true;
		}				
		if ($esta==false)
		{
			$anuncios[$indice]['id']=$resultado[$i]['id'];
			$anuncios[$indice]['nombre']=$resultado[$i]['nombre'];
			$anuncios[$indice]['tipo']=$resultado[$i]['tipo'];
			$anuncios[$indice]['id_cat']=$resultado[$i]['id_cat'];
			$indice++;			
		}
	}
	//Fin depuración
	
	return $anuncios;
}




function codigo_verificacion($fecha,$comprador)
{		
	$fecha_final=$fecha;		
	$len1=strlen($comprador);
	$len2=strlen($fecha_final);
	$len1=$len1-1;
	$len2=$len2-1;
	$id="";
	$x=0;
	$y=0;
	while (($x==0)||($y==0))
	{
		if ($len1>=0)
		{
			$id.=$comprador[$len1];
			$len1--;			
		}
		else
			$x=1;
		if ($len2>=0)
		{
			$id.=$fecha_final[$len2];
			$len2--;			
		}
		else
			$y=1;		
	}	
	return $id;
}
	









function tablaOpciones($user)
{
	$query=operacionSQL("SELECT * FROM usuario_opciones WHERE user='".$user."'");
	$tabla['tienda']=mysql_result($query,0,1);
	
	return $tabla;
}

function numAnunciosUsuario($usuario)
{
	$aux="SELECT count(*) FROM anuncio WHERE usuario='".$usuario."' AND status='Activo'";
	$query=operacionSQL($aux);
	return mysql_result($query,0,0);
}



function fechaBD()
{
	$hoy=getdate();
	return $fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']."-".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];	
}



function email($de_nombre,$de_mail,$para_nombre,$para_mail,$asunto,$contenido)
{
	
	include_once('phpmailer/class.phpmailer.php');
	include("phpmailer/class.smtp.php");

	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port 
	
	$mail->Username   = "info@hispamercado.com.ve";  // GMAIL username
	$mail->Password   = "21381665";            // GMAIL password
	

	$mail->From=$de_mail;
	$mail->FromName=$de_nombre;
	$mail->Subject=$asunto;
	$mail->Body=$contenido;                      //HTML Body
	$mail->AltBody=$contenido;
	
	$mail->WordWrap   = 50; // set word wrap
	
	$mail->AddAddress($para_mail,$para_nombre);
	$mail->AddReplyTo($de_mail,$de_nombre);
	//$mail->AddAttachment("/path/to/file.zip");             // attachment
	//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment
	
	$mail->IsHTML(true); // send as HTML
	
	if(!$mail->Send()) 
		return 0;
	else 
		return 1;
	
}



function email2($de_nombre,$de_mail,$para_nombre,$para_mail,$asunto,$contenido)
{
	
	include_once('phpmailer/class.phpmailer.php');
	include("phpmailer/class.smtp.php");

	$mail = new PHPMailer();
	
	$mail->IsSMTP();
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
	$mail->Host       = "ve.smtp.mail.yahoo.com";      // sets GMAIL as the SMTP server
	$mail->Port       = 465;                   // set the SMTP port 
	
	$mail->Username   = "hispamercado@yahoo.com.ve";  // GMAIL username
	$mail->Password   = "21381665";            // GMAIL password
	

	$mail->From=$de_mail;
	$mail->FromName=$de_nombre;
	$mail->Subject=$asunto;
	$mail->Body=$contenido;                      //HTML Body
	$mail->AltBody=$contenido;
	
	$mail->WordWrap   = 50; // set word wrap
	
	$mail->AddAddress($para_mail,$para_nombre);
	$mail->AddReplyTo($de_mail,$de_nombre);
	//$mail->AddAttachment("/path/to/file.zip");             // attachment
	//$mail->AddAttachment("/path/to/image.jpg", "new.jpg"); // attachment
	
	$mail->IsHTML(true); // send as HTML
	
	if(!$mail->Send()) 
		return 0;
	else 
		return 1;
	
}



function ddmmaaaa_aaaammdd($fecha)
{
   	$fecha_conv="";
	$fecha_conv.=$fecha[6];
	$fecha_conv.=$fecha[7];
	$fecha_conv.=$fecha[8];
	$fecha_conv.=$fecha[9];
	$fecha_conv.="-".$fecha[3].$fecha[4]."-".$fecha[0].$fecha[1]." ";
	$fecha_conv.=$fecha[11].$fecha[12].$fecha[13].$fecha[14].$fecha[15].$fecha[16].$fecha[17].$fecha[18];
	return $fecha_conv;
}
	
function aaaammdd_ddmmaaaa($fecha)
{	
	$ano=substr($fecha,0,4);
	$mes=substr($fecha,5,2);
	$dia=substr($fecha,8,2);
	
	return $dia."-".$mes."-".$ano;
}




//***************************************************************SEGMENTO BUSQUEDA



function contarOcurrencias($palabra,$texto)
{
	$z=0;
	for ($i=0;$i<count($texto);$i++)
		if ($texto[$i]==$palabra) 
			$z++;
			
	return $z;
}

function primeraOcurrencia($palabra,$texto)
{
	for ($i=0;$i<count($texto);$i++)
		if ($texto[$i]==$palabra) 
			return $i+1;
}

function evaluarCriterioCompletoSinFiltro($criterio,$texto)
{
	$texto_criterio="-";
	$texto_texto="-";
	
	for ($i=0;$i<count($criterio);$i++)
		$texto_criterio.=$criterio[$i]."-";
	
	for ($i=0;$i<count($texto);$i++)
		$texto_texto.=$texto[$i]."-";
		
	return substr_count($texto_texto,$texto_criterio);
}


function valoracionOcurrencias($criterio,$texto,$valor)
{
	$suma=0;
	
	//PARTE FACIL---OCURRENCIAS DE LA PALABRA MULTIPLICADO POR LA VALORACION
	for ($i=0;$i<count($criterio);$i++)
	{
		$ocu=contarOcurrencias($criterio[$i],$texto);
		$suma=$suma+($ocu*$valor);		
	}
	
	
	return $suma;
}




?>
