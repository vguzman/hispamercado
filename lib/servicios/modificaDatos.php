<?
	session_start();

	include "../util.php";
	
	
	$user=$_SESSION['user'];
	
	$nombre_pais=nombrePais($_SESSION['pais']);
	
	$cliente=detallesCliente($_SESSION['user']);
	
	
	$id_provincia=$_POST['provincia'];
	
	
	
	if ($cliente['email']!=$_POST['email'])
	{
	
		$hoy=getdate();
		$fecha=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];		
		
		$verificacion=codigo_verificacion($fecha,session_id());
		
		operacionSQL("INSERT INTO temporal values('cambio_mail','".$_POST['email']."','".$cliente['email']."','".$verificacion."')");
		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: HispaMercado ".$nombre_pais." <info@hispamercado.com>\n";
		$headers .= "Reply-To: info@hispamercado.com";
				
		$contenido="<div align='center'>
				<table border='0' width='800' id='table1'>
					<tr>
						<td><font face='Arial' size='2'>Hola <b>".$cliente['nombre']."</b>,</font><p>
						<font face='Arial' size='2'>Muchas gracias por utilizar
						<a href='http://www.hispamercado.com/".$pais."/'>HispaMercado ".$nombre_pais."</a>.</font>
						<p><font size='2' face='Arial'>Has solicitado cambiar tu actual direcci&oacute;n de e-mail a la direcci&oacute;n<span style='background-color: #FFFF00'> <strong>".$_POST['email']."</strong></span></font><p>
						<p>
						<font face='Arial' size='2'>Para que el cambio de e-mail 
						se haga efectivo debes ingresar en el siguiente link:
						<a href='http://www.hispamercado.com/publicar/activaAnuncio.php?id='.$verificacion.''>
						http://www.hispamercado.com/validaciones/cambioMail.php?id=".$verificacion."</a></font></p>
						<p><font face='Arial' size='2'>Si no solicitaste este 
						cambio en los datos de tu cuenta te sugerimos que 
						modifiques tu contraseña para evitar accesos no 
						autorizados.</font></p>
						<p><font face='Arial' size='2'>Hasta luego...</font></p>		
						</td>
					</tr>
				</table>
			</div>";
		
		mail($cliente['email'],"Cambio de e-mail",$contenido,$headers);
		
		echo utf8_encode("<table width='500'border='0' align='center' cellpadding='2' cellspacing='0'  bgcolor='#FFCC33' style='border-collapse: collapse'>
			  <tr>
				<td align='center' width='450' class='arial11Negro'><div align='left'><strong>Tus datos fueron modificados correctamente, para que el cambio de e-mail se haga efectivo debes confirmarlo a través del mensaje que enviamos a tu actual dirección</strong></div></td>
			 	 <td align='center' width='50' class='arial11Negro'><div align='center'><strong><a href='javascript:window.history.go(0)'>regresar</a></strong></div></td>
			  </tr>
			</table>");
		
	}
	else
	{
		$aux="UPDATE cliente SET nombre='".$_POST['nombre']."',telefonos='".$_POST['telefonos']."',provincia=".$id_provincia.",ciudad='".$_POST['ciudad']."',direccion='".$_POST['direccion']."',web='".$_POST['web']."' WHERE user='".$user."'";
		operacionSQL(utf8_decode($aux));
		echo utf8_encode("<table width='350' border='0' align='center' cellpadding='2' cellspacing='0'  bgcolor='#FFCC33' style='border-collapse: collapse'>
			  <tr>
				<td align='center' width='300' class='arial11Negro'><div align='center'><strong>tus datos fueron modificados correctamente </strong></div></td>
			 	 <td align='center' width='50' class='arial11Negro'><div align='center'><strong><a href='javascript:window.history.go(0)'>regresar</a></strong></div></td>
			  </tr>
			</table>");
	}
?>