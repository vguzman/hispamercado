<?	
	include "../util.php";

	session_start();	

	$pais=$_SESSION['pais'];
	
	

	$id_1=$_POST['id_1'];	
	$tipo_1=$_POST['tipo_1'];
	$id_2=$_POST['id_2'];
	$tipo_2=$_POST['tipo_2'];
	$id_3=$_POST['id_3'];
	$tipo_3=$_POST['tipo_3'];
	$id_4=$_POST['id_4'];
	$tipo_4=$_POST['tipo_4'];
	$id_5=$_POST['id_5'];
	$tipo_5=$_POST['tipo_5'];
	$id_6=$_POST['id_6'];
	$tipo_6=$_POST['tipo_6'];
	
	$terminos=$_POST['terminos'];
	if ($terminos=="")
		$terminos="NULL";
	$email=$_POST['email'];
	$provincia=$_POST['provincia'];
	if ($provincia=="Todas")
		$provincia="NULL";	
	
	
	//Determinando el ID de la alerta
	$query=operacionSQL("SELECT max(id) FROM alerta");
	$max=mysql_result($query,0,0);
	$id_alerta=$max+1;	
	
	//Determinando el ID de verificación
	$hoy=getdate();
	$id_sesion=session_id();
	$fecha=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];	
	$verificacion=codigo_verificacion($fecha,$id_sesion);
	
		
	
	$aux="INSERT INTO alerta VALUES (".$id_alerta.",'".fechaBD()."','".$email."','".$verificacion."','".$pais."','".$provincia."','".$terminos."','Inactivo')";
	operacionSQL($aux);
		
	
	function id_categoria($cadenas)
	{
		$num="";
		$len=strlen($cadenas);
		for ($i=0;$i<$len;$i++)
		{			
			if ($cadenas[$i]==';')
			{				
				$num="";
			}
			else
				$num.=$cadenas[$i];
		}
		
		return $num;
	}
	
	
	if ($id_1!="NULL")
	{
		$id_1=id_categoria($id_1);
		operacionSQL("INSERT INTO alerta_categoria VALUES(".$id_alerta.",".$id_1.",'".$tipo_1."')");
	}	
	if ($id_2!="NULL")
	{
		$id_2=id_categoria($id_2);
		operacionSQL("INSERT INTO alerta_categoria VALUES(".$id_alerta.",".$id_2.",'".$tipo_2."')");
	}	
	if ($id_3!="NULL")
	{
		$id_3=id_categoria($id_3);
		operacionSQL("INSERT INTO alerta_categoria VALUES(".$id_alerta.",".$id_3.",'".$tipo_3."')");
	}	
	if ($id_4!="NULL")
	{
		$id_4=id_categoria($id_4);
		operacionSQL("INSERT INTO alerta_categoria VALUES(".$id_alerta.",".$id_4.",'".$tipo_4."')");
	}
	if ($id_5!="NULL")
	{
		$id_5=id_categoria($id_5);
		operacionSQL("INSERT INTO alerta_categoria VALUES(".$id_alerta.",".$id_5.",'".$tipo_5."')");
	}
	if ($id_6!="NULL")
	{
		$id_6=id_categoria($id_6);
		operacionSQL("INSERT INTO alerta_categoria VALUES(".$id_alerta.",".$id_6.",'".$tipo_6."')");
	}
	
	//Nombre pasis
	$query=operacionSQL("SELECT nombre FROM pais WHERE id='".$pais."'");
	$nombre_pais=mysql_result($query,0,0);
	
	
	//Ahora a enviar el mail
	$contenido="<div align='center'>
	<table border='0' width='800' id='table1' height='198'>
		<tr>
			<td><font face='Arial' size='2'>Hola,</font><p>
			<font face='Arial' size='2'>Hemos creado satisfactoriamente tu 
			alerta en
			<a href='http://www.hispamercado.com/".$pais."/'>
			HispaMercado ".$nombre_pais."</a>. </font></p>
			<p><font face='Arial' size='2'>Debes activarla ingresando en el 
			siguiente enlace:</font></p>
			<p align='center'><font face='Arial' size='2'>
			<a href='http://www.hispamercado.com/confirmaciones/activaAlerta.php?codigo=".$verificacion."'>
			<span style='background-color: #FFFF00'>http://www.hispamercado.com/confirmaciones/activaAlerta.php?codigo=".$verificacion."</span></a></font></p>
			<p><font face='Arial' size='2'>Si no has solicitado este e-mail por 
			favor haz caso omiso del mismo.</font></p>
			<p><font face='Arial' size='2'>Hasta luego....</font></td>
		</tr>
	</table>
</div>";
			
	$headers = "MIME-Version: 1.0\n";
	$headers .= "Content-type: text/html; charset=iso-8859-1\n";
	$headers .= "From: HispaMercado ".$nombre_pais." <info@hispamercado.com>\n";
	$headers .= "Reply-To: info@hispamercado.com";
	
	mail($email,"Activa tu alerta",$contenido,$headers);
	
	echo "<table width='500' height='21' border='0' align='center' cellpadding='2' cellspacing='0'  bgcolor='#FFFFEC' style='border-collapse: collapse'>
	  <tr>
		<td align='center' class='arial11Negro'><div align='center'><strong>Tu alerta ha sido creada, debes activarla a trav&eacute;s del link que ha sido enviado a tu e-mail </strong></div>
		<br><div align='center'><strong><a href='javascript:window.history.go(0)' class='LinkFuncionalidad'>regresar</a></strong></div></td>
	  </tr>
	</table>";
	
?>