<?
	set_time_limit(0);
	
	if ($_GET['hash']!="conejitoblanco")
		exit;
	
	
	include "../../lib/class.php";
	
	//email("Hispamercado","no-responder@hispamercado.com.ve","Victor Guzman","vmgafrm@gmail.com","Ejecutando email de visitas","Hola mundo!");
	
	
	$z=0;	
	$datos=array();
	$query=operacionSQL("SELECT id_anuncio,COUNT(*) AS C FROM AnuncioVisita GROUP BY id_anuncio ORDER BY C DESC");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		$id_anuncio=mysql_result($query,$i,0);
		$cuenta=mysql_result($query,$i,1);
		
		//echo $z.") ".$email." --- ".$cuenta."<br>";
		if ($cuenta<5)
			break;
		
		$query2=operacionSQL("SELECT id FROM Anuncio WHERE id=".$id_anuncio);
		if (mysql_num_rows($query2)>0)
		{
			
			$anuncio=new Anuncio($id_anuncio);
			$email=strtolower(trim($anuncio->anunciante_email));
			
			if (validarEmail($email)==1)
				if (isset($datos[$email])==false)
					$datos[$email]=$cuenta;
				else
					$datos[$email]=$datos[$email]+$cuenta;
		}
		
	}
	arsort($datos);
	$z=1;
	foreach ( $datos as $doc => $docinfo )
	{	
		$z++;
		echo $z.") ".$doc." - ".$docinfo."<br>";
		
		$mensaje='<p>Hola fulano,</p>
		<p>Este es el comportamiento de tus anuncios durante esta ultima semana.</p>
		
<table width="600" border="0z cellspacing="0" cellpadding="0" style="font-size:14px">
			%anuncios%
			</table>
			<p><strong>Ahora Hispamercado te ofrece una nueva funcionalidad para que tengas una Tienda en linea y puedas promocionar tus productos y servicios de una manera mas efectiva.</strong></p>
			
			<p>Si deseas dar de baja alguno de tus anuncios entra en hispamercado, accede al link <a href="http://www.hispamercado.com.ve/gestionAnuncio.php">Gestionar mis anuncios</a>, introduce tu email y recibiras un enlace para que puedas editar tus anuncios. Tambien puedes registrarte y gestionar todas tus actividades en Hispamercado de una manera mas efectiva</p>
			<p>  Muchas gracias por usar Hispamercado! </p>
			<p>&nbsp;</p>
			<p>----<br />
			Hispamercado<br />
			<a href="http://www.hispamercado.com.ve/">www.hispamercado.com.ve</a></p>';
		
		
		
		$query=operacionSQL("SELECT id_anuncio,COUNT(*) AS C FROM AnuncioVisita A, Anuncio B WHERE A.id_anuncio=B.id AND LOWER(trim(B.anunciante_email))='".$doc."' GROUP BY id_anuncio ORDER BY C DESC");
		$texto='';
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			if (($i%2)==0)
				$colorete="#F2F7E6";			
			else
				$colorete="#FFFFFF";
				
			
			$anuncio=new Anuncio(mysql_result($query,$i,0));
			$texto.='<tr bgcolor="'.$colorete.'">
				<td width="81" height="16" align="center"><a href="http://www.hispamercado.com.ve/'.$anuncio->armarEnlace().'"><img src="http://www.hispamercado.com.ve/lib/img.php?tipo=mini&anuncio='.$anuncio->id.'&foto=1" border="0" /></a></td>
				<td width="430"><a href="http://www.hispamercado.com.ve/'.$anuncio->armarEnlace().'">'.$anuncio->titulo.'</a></td>
				<td width="89">'.number_format(mysql_result($query,$i,1),0,',','.').' visitas</td>
			  </tr>';
		}
		
		$mensaje=str_replace("fulano",$anuncio->anunciante_nombre,$mensaje);
		$mensaje=str_replace("%anuncios%",$texto,$mensaje);
		$asunto="Has recibido ".$docinfo." visitas esta semana en tus anuncios";
		
		/*echo $asunto."<br>";
		echo $mensaje;
		echo "<br><br><br><br>";
		
		
		echo $anuncio->anunciante_email."<br>";*/
		email("Hispamercado","info@hispamercado.com.ve",$anuncio->anunciante_nombre,$doc,$asunto,$mensaje);
		
	}
	
	
	
	
?>