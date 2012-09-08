<?

function operacionSQL($aux)
{
	$link=mysql_connect ("localhost","hispamercado","h1sp@merc@do") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("hispamercado"); 
	
	$query=mysql_query($aux,$link);
	
	if (!($query))
		echo $error=mysql_error();
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


function checkSession()
{
	session_start();
	$_SESSION['state'] = md5(uniqid(rand(), TRUE));
	
	if (isset($_COOKIE['hispacookie']))
	{
		$query=operacionSQL("SELECT id FROM Usuario WHERE cookie='".$_COOKIE['hispacookie']."' AND fb_token_expires>NOW()");
		if (mysql_num_rows($query)>0)
			return mysql_result($query,0,0);
		else
			return false;
	}
	else
		return false;
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



function fechaBD()
{
	$hoy=getdate();
	return $fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']."-".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];	
}



function email($de_nombre,$de_mail,$para_nombre,$para_mail,$asunto,$contenido)
{
	require_once('phpmailer/class.phpmailer.php');
	
	
	$mail = new phpmailer;
	$mail-> IsAmazonSES();
	 
	$mail-> AddAmazonSESKey("AKIAIKJEDZCR36P7J6VQ", "XBjhARZ9sLz9Z+1vTMrfvuizt+/ECDY+/rVaZmXk");
	 
	$mail-> From = "info@hispamercado.com.ve";
	$mail-> FromName = "Hispamercado";
	 
	$mail-> AddAddress($para_mail, utf8_encode($para_nombre));
	$mail-> Subject = utf8_encode($asunto);
	$mail-> Body = utf8_encode($contenido);
	
	$mail->IsHTML(true);
	//$mail->SetLanguage('es','phpmailer/language/');
	$mail->CharSet = "UTF-8";

	
		
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



?>
