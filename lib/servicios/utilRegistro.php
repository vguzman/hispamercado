<?
	session_start();
	header("Cache-control: private");
	
	include "../util.php";
	
	
	$pais=$_SESSION['pais'];
	
	
	//SACA NOMBRE PAIS
	$query=operacionSQL("SELECT nombre FROM pais WHERE id='".$pais."'");
	$nombre_pais=mysql_result($query,0,0);
	
		
		
	function userExiste($user)
	{
		$query=operacionSQL("SELECT * FROM cliente WHERE user='".$user."'");
		if (mysql_num_rows($query)==1)
			return "true";
		else
			return "false";
	}
	function emailExiste($email)
	{
		$aux="SELECT * FROM cliente WHERE email='".$email."'";
		$query=operacionSQL($aux);
		if (mysql_num_rows($query)>0)
			return "true";
		else
			return "false";
	}
	function anunciosAsociados($email)
	{
		$query=operacionSQL("SELECT * FROM anuncio WHERE email='".$email."'");
		if (mysql_num_rows($query)>1)
			return "true";
		else
			return "false";
	}
	
	
	if ($_POST['veri']=="user")
		echo userExiste($_POST['user']);
	
	if ($_POST['veri']=="email")
		echo emailExiste($_POST['email']); 
		
	if ($_POST['veri']=="anuncios")
		echo anunciosAsociados($_POST['email']); 
		
	if ($_POST['veri']=="procesar")
	{
		//Si tiene anuncios o alertas creados con este e-mail se asocian a la nueva cuenta
		operacionSQL("UPDATE anuncio SET usuario='".$_POST['user']."' WHERE email='".$_POST['email']."'");
		operacionSQL("UPDATE alerta SET usuario='".$_POST['user']."' WHERE email='".$_POST['email']."'");
			
		
		
		//Determinando el ID de verificación
		$hoy=getdate();
		$id_sesion=session_id();
		$fecha=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];	
		$verificacion=codigo_verificacion($fecha,$id_sesion);
		
		
		$hoy=getdate();
		$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];		
		
		$aux="INSERT INTO cliente VALUES ('".$_POST['user']."','".$_POST['email']."','".$_POST['nombre']."',NULL,'".md5($_POST['pass'])."',".$_POST['provincia'].",'".$_POST['ciudad']."',NULL,'".$verificacion."','".$fecha."','".$pais."',NULL)";
		operacionSQL(utf8_decode($aux));
		
		$aux="INSERT INTO usuario_opciones VALUES ('".$_POST['user']."','NO')";
		operacionSQL($aux);
		
				
		
		//Determinando nombre provincia
		$query=operacionSQL("SELECT nombre FROM provincia WHERE id=".$_POST['provincia']);	
		$nombre_provincia=mysql_result($query,0,0);
			
		
		$contenido="<div align='center'>
				<table border='0' width='700' id='table1'>
					<tr>
						<td><font face='Arial' size='2'>Hola <b>".$_POST['nombre']."</b>,</font><p>
						<font face='Arial' size='2'>Tu cuenta en 
						<a href='http://www.hispamercado.com/".$pais."/'>Hispamercado ".$nombre_pais."</a> se ha 
						creado satisfactoriamente con los siguientes datos:</font></p>
						<table width='500' border='0' align='center' bgcolor='#FFFFEC'>
					<tr>
					  <td><b><font face='Arial' size='2'>Nombre completo:</font></b></td>
					  <td valign='middle'><font face='Arial' size='2'>".$_POST['nombre']."</font></td>
					</tr>
					<tr>
					  <td width='161'><b><font face='Arial' size='2'>Id de usuario :</font></b></td>
					  <td width='329' valign='middle'><font face='Arial' size='2'>".$_POST['user']."</font></td>
					</tr>
					<tr>
					  <td><b><font face='Arial' size='2'>E-mail:</font></b></td>
					  <td><font face='Arial' size='2'>".$_POST['email']."</font></td>
					</tr>
					<tr>
					  <td><b><font face='Arial' size='2'>Contrase&ntilde;a:</font></b></td>
					  <td><font face='Arial' size='2'>".$_POST['pass']."</font></td>
					</tr>
					<tr>
					  <td><b><font face='Arial' size='2'>Provincia:</font></b></td>
					  <td><font face='Arial' size='2'>".$nombre_provincia."</font></td>
					</tr>
					<tr>
					  <td><b><font face='Arial' size='2'>Ciudad:</font></b></td>
					  <td><font face='Arial' size='2'>".$_POST['ciudad']."</font></td>
					</tr>
				  </table>
						<p><font face='Arial' size='2'>Para confirmar tu registro debes acceder al siguiente link
						<a href='http://www.hispamercado.com/activarUsuario.php?codigo=".$verificacion."'>
						http://www.hispamercado.com/activarUsuario.php?codigo=".$verificacion."</a></font></p>
						<p><font face='Arial' size='2'>Si este e-mail no fue solicitado por ti, por favor haz caso omiso 
						del mismo.</font></p>
						<p><font face='Arial' size='2'>Hasta luego...</font></td>
					</tr>
				</table>
			</div>";

		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: HispaMercado ".$nombre_pais." <info@hispamercado.com>\n";
		$headers .= "Reply-To: info@hispamercado.com";
		
		//mail($_POST['email'],"Verificación de registro de usuario",$contenido,$headers);
		email("HispaMercado ".$nombre_pais,"info@hispamercado.com",$_POST['nombre'],$_POST['email'],"Verificación de registro de usuario",$contenido);	
		mail("vmgafrm@gmail.com","Nuevo usuario registrado",$contenido,$headers);
		
		
		
		echo "<b>Su cuenta se ha creado satisfactoriamente, para completar el proceso debes activarlo a trav&eacute;s del link que ha sido enviado a tu e-mail</b>";
	}
?>