<?
	include "../util.php";
	
	session_start();
	//$captcha=$_SESSION['captcha2'];
		
	$id_anuncio=$_SESSION['id_anuncio'];
	
	header ("Cache-Control: no-cache, must-revalidate");
	header('Content-Type: text/html; charset=iso-8859-1');
	
	if ($tipo=="requerir")
	{
		//*****************ARMA CAPTCHA*************************************************
		$fecha2=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];	
		$palabra=codigo_verificacion($fecha2,session_id());	
		$conter=strlen($palabra);
		$palabra2="";
		for ($i=0;$i<5;$i++)
		{
			while (true)
			{
				$caracter=$palabra[rand(0,$conter-1)];
				if (($caracter!='1')&&($caracter!='9')&&($caracter!='7')&&($caracter!='0')&&($caracter!='o')&&($caracter!='O'))
					break;
			}
			$palabra2.=$caracter;
		}	
		$_SESSION['captcha']=strtoupper($palabra2);	
		$_SESSION['captcha2']=strtoupper($palabra2);
		//setcookie("captcha",strtoupper($palabra2),time()+3600);
		//********************************************************************************		
		$hoy=getdate();
		$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];		
		
		if ($que=="amigo")
			echo "<table width='299' border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000' bgcolor='#FFFFCC' style='border-collapse:collapse '>
					<tr>
					  <td width='484' align='center'>
						<table width='299' border='0' align='center' cellpadding='0' cellspacing='0' style='border-collapse:collapse '>
						  <tr>
							<td width='484' align='center' class='Arial13Negro'><b>Recomendar a un amigo</b></td>
						  </tr>
						</table>
						<table width='299' border='0' align='center' cellspacing='3' style='border-collapse: collapse'>
						  <tr>
							<td></td>
						  </tr>
						</table>
						<table width='311' border='0' align='center'>
						  <tr>
							<td width='94' class='Arial13Negro' align='left'>Tu nombre</td>
							<td width='207' align='left'><input name='tunombre' type='text' size='30'></td>
						  </tr>
						  <tr>
							<td class='Arial13Negro' align='left'>Para (e-mail)</td>
							<td align='left'><input name='para' type='text' size='30'></td>
						  </tr>
						  <tr>
							<td valign='top' class='Arial13Negro' align='left'>Verificaci&oacute;n</td>
							<td valign='middle' align='left'>
							  <div align='left'>
								  <input name='captcha' type='text' size='5' maxlength='5'>
								  <img src='lib/captcha/captcha.php?xyz=".$fecha."'></div>
							</td>
						  </tr>
						</table><table width='299' border='0' align='center' cellspacing='3' style='border-collapse: collapse'>
						  <tr>
							<td></td>
						  </tr>
						</table><table width='299' border='0' align='center' cellspacing='0' style='border-collapse: collapse'>
						  <tr>
							<td align='center'><input type='button' name='boton_enviar' value='Enviar' onclick='ejecutaAccionAnuncio(".chr(34)."amigo".chr(34).",".$id_anuncio.")'></td>
						  </tr>
						</table>
					  </td>
					</tr>
				  </table>";
			
			if ($que=="anunciante")
				echo "<table width='299' border='0' align='center' cellpadding='0' cellspacing='0' bordercolor='#000000' bgcolor='#FFFFCC' style='border-collapse:collapse '>
					<tr>
					  <td width='484' align='center'>
						<table width='299' border='0' align='center' cellpadding='0' cellspacing='0' style='border-collapse:collapse '>
						  <tr>
							<td width='484' align='center' class='Arial13Negro'><b>Contactar al anunciante </b></td>
						  </tr>
						</table>
						<table width='299' border='0' align='center' cellspacing='3' style='border-collapse: collapse'>
						  <tr>
							<td></td>
						  </tr>
						</table>
						<table width='311' border='0' align='center'>
						  <tr>
							<td width='94' class='Arial13Negro' align='left'>Tu nombre</td>
							<td width='207' align='left'><input name='tunombre' type='text' size='30'></td>
						  </tr>
						  <tr>
							<td class='Arial13Negro' align='left'>Tu e-mail </td>
							<td align='left'><input name='tuemail' type='text' size='30'></td>
						  </tr>
						  <tr>
						    <td class='Arial13Negro' align='left'>Mensaje</td>
						    <td align='left'><textarea name='mensaje' cols='24' rows='5'></textarea></td>
					      </tr>
						  <tr>
							<td valign='top' class='Arial13Negro' align='left'>Verificaci&oacute;n</td>
							<td valign='middle' align='left'>
							  <div align='left'>
								  <input name='captcha' type='text' size='5' maxlength='5'>
								  <img src='lib/captcha/captcha.php'></div>
							</td>
						  </tr>
						</table>
						<table width='299' border='0' align='center' cellspacing='3' style='border-collapse: collapse'>
						  <tr>
							<td></td>
						  </tr>
						</table><table width='299' border='0' align='center' cellspacing='0' style='border-collapse: collapse'>
						  <tr>
							<td align='center'><input type='button' name='boton_enviar' value='Enviar' onclick='ejecutaAccionAnuncio(".chr(34)."anunciante".chr(34).",".$id_anuncio.")'></td>
						  </tr>
						</table>
					  </td>
					</tr>
				  </table>";
	}
	
	
	if ($tipo=="ejecutar")
	{
		$captcha=$_SESSION['captcha2'];
		$captcha_recibido=strtoupper($_POST['captcha']);
		
		if ($captcha==$captcha_recibido)
		{
			if ($que=="amigo")
			{			
				$headers = "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/html; charset=iso-8859-1\n";
				$headers .= "From: HispaMercado ".nombrePais($_SESSION['pais'])." <info@hispamercado.com>\n";
				$headers .= "Reply-To: info@hispamercado.com";			
				
				$id_anuncio=$_POST['id_anuncio'];
				
				$query=operacionSQL("SELECT tipo FROM anuncio_categoria WHERE id_anuncio=".$id_anuncio);
				$tipo=mysql_result($query,0,0);
				
				$anuncio=arma_anuncio($_POST['id_anuncio'],"#FFFFD2",$_SESSION['pais'],$tipo);
				$anuncio=ereg_replace("lib/img.php","http://gator257.hostgator.com/~vmgafrm/detodoaqui/lib/img.php",$anuncio);
				$anuncio=ereg_replace("<img src='img/favorito0.gif' title='A&ntilde;adir a favoritos' width='26' height='25' border='0'>","",$anuncio);
				$anuncio=ereg_replace("<img src='img/favorito1.gif' title='Quitar de favoritos' width='26' height='25' border='0'>","",$anuncio);
				$anuncio=ereg_replace("<img src='img/ver.gif' width='28' height='29' border='0' title='Ver anuncio'>","",$anuncio);
				$anuncio=ereg_replace("javascript:verAnuncio","http://gator257.hostgator.com/~vmgafrm/detodoaqui/anuncio.php?pais=".$_SESSION['pais']."&id=".$_POST['id_anuncio'],$anuncio);
				$anuncio=str_replace("(".chr(34).$_SESSION['pais'].chr(34).",".$id_anuncio.")","",$anuncio);			
				$anuncio=str_replace("http://gator257.hostgator.com/~vmgafrm/detodoaqui/anuncio.php?pais=".$_SESSION['pais']."&id=".$_POST['id_anuncio'],"http://www.hispamercado.com/".$_SESSION['pais']."/anuncio_".$_POST['id_anuncio'],$anuncio);
				
				$raya="<table width='800' border='0' align='center' bordercolor='#C8C8C8' bgcolor='#C8C8C8' style='border-collapse: collapse'>
						<tr>
							<td></td>
						</tr></table>";
				$contenido="<table width='800' border='0' align='center'>
						  <tr>
							<td><p><font face='Arial' style='font-size: 9pt'>Saludos,</font></p>
							  <p><font face='Arial' style='font-size: 9pt'>Tu amigo <strong>".utf8_decode($_POST['tunombre'])."</strong> te invita a que mires el siguiente anuncio publicado en el portal <a href='http://www.hispamercado.com/".$_SESSION['pais']."/' target='_blank'>HispaMercado ".nombrePais($_SESSION['pais'])."</a>.</font></p>
							  <p>".$raya.$anuncio."</p>
							<p><font face='Arial' style='font-size: 9pt'>Hasta luego. </font></p></td>
						  </tr>
						</table>";
						
				//mail($_POST['para'],utf8_decode($_POST['tunombre'])." te recomienda este anuncio",$contenido,$headers);				
				
				$nombre_pais=nombrePais($_SESSION['pais']);
				$para_nombre=utf8_decode($_POST['tunombre']);
				$para_email=$_POST['para'];
				$asunto=utf8_decode($_POST['tunombre'])." te recomienda este anuncio";
				
				email("HispaMercado ".$nombre_pais,"info@hispamercado.com",$para_nombre,$para_email,$asunto,$contenido);
				
				echo "<table width='310' border='0' align='center' bgcolor='#FFCC00'>
					  <tr>
						<td class='Arial11Negro' align='center'><b>Tu recomendación fue enviada exitosamente</b></td>
					  </tr>
					</table>";
			}	
			if ($que=="anunciante")
			{
				$id_anuncio=$_POST['id_anuncio'];
				
				$anunciante=detallesAnunciante($id_anuncio);
				$nombre_anunciante=$anunciante['nombre'];
				$mail_anunciante=$anunciante['email'];				
				
				//***Comprobar que se recibieron todos los datos
				$test=true;
				if ($tunombre=="")
				{
					echo "Debe introducir su nombre";
					$test=false;
				}else
				if ($tuemail=="")
				{
					echo "Debe introducir su e-mail";
					$test=false;
				}else
				if ($mensaje=="")
				{
					echo "Debe introducir un mensaje";
					$test=false;
				}
				//**************************************************
				
				
				if ($test==true)
				{	
					$tunombre=utf8_decode($_POST['tunombre']);
					$tuemail=utf8_decode($_POST['tuemail']);
					$mensaje=utf8_decode($_POST['mensaje']);
					
					$headers = "MIME-Version: 1.0\n";
					$headers .= "Content-type: text/html; charset=iso-8859-1\n";
					$headers .= "From: HispaMercado ".nombrePais($_SESSION['pais'])." <info@hispamercado.com>\n";
					$headers .= "Reply-To: info@hispamercado.com";
					
					$contenido="<table border='0' width='600' id='table2'>
								<tr>
									<td><font face='Arial' style='font-size: 9pt'>Hola ".$nombre_anunciante.",</font><p>
									<font face='Arial' style='font-size: 9pt'>Hemos recibido el 
									siguiente mensaje para ti en referencia a <a href='http://www.hispamercado.com/".$pais."/anuncio_".$id_anuncio."'>tu anuncio</a> en <a href='http://www.hispamercado.com/".$pais."/'>HispaMercado ".nombrePais($_SESSION['pais'])."</a>:</font></p>
						<table border='1' width='379' id='table3' style='border-collapse: collapse' bgcolor='#FFFFCC' height='110'>
							<tr>
								<td width='63' height='26'>
								<font face='Arial' style='font-size: 9pt; font-weight: 700'>De:</font></td>
								<td height='26'><font face='Arial' style='font-size: 9pt'>".$tunombre." (<a href='mailto:".$tuemail."'>".$tuemail."</a>)</font></td>
							</tr>
							<tr>
								<td width='63'>
								<font face='Arial' style='font-size: 9pt; font-weight: 700'>Mensaje:</font></td>
								<td><font face='Arial' style='font-size: 9pt'>".$mensaje."</font></td>
							</tr>
						</table>
									<p><font face='Arial' style='font-size: 9pt'>Te recomendamos que te 
									comuniques a la brevedad con el remitente de este mensaje.</font></p>
									<p><font face='Arial' style='font-size: 9pt'>Hasta luego.</font></td>
								</tr>
							</table>";
							
					//mail($mail_anunciante,"Has recibido un mensaje en tu anuncio",$contenido,$headers);
					
					$nombre_pais=nombrePais($_SESSION['pais']);
					email("HispaMercado ".$nombre_pais,"info@hispamercado.com",$nombre_anunciante,$mail_anunciante,"Has recibido un mensaje en tu anuncio",$contenido);
															
					echo "<table width='310' border='0' align='center' bgcolor='#FFCC00'>
						  <tr>
							<td class='Arial11Negro' align='center'><b>Tu mensaje fue enviado exitosamente</b></td>
						  </tr>
						</table>";
				}
			}
		}
		else
			echo "error captcha";
	}
	

?>