<?

function operacionSQL($aux)
{
	$link=mysql_connect ("localhost","hispamercado","h1sp@merc@do") or die ('I cannot connect to the database because: ' . mysql_error());
	mysql_select_db ("hispamercado"); 
	
	$query=mysql_query($aux,$link);
	
	if (!($query))
	{
		echo $error=mysql_error();
		mysql_close($link);
	}
	else
	{	
		mysql_close($link);
		return $query;		
	}
	
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



function categorias_principales()
{
	$query=operacionSQL("SELECT id,nombre FROM Categoria WHERE id_categoria IS NULL ORDER BY orden");
	$total=mysql_num_rows($query);	
		
	for ($i=0;$i<$total;$i++)
	{
		$categorias[$i]['id']=mysql_result($query,$i,0);
		$categorias[$i]['nombre']=mysql_result($query,$i,1);
	}
	
	return $categorias;
}


function validarEmail($email)
{
	$email=trim($email);
	if (preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$email))
		return 1;
	else
		return 0;
	
}


function footer()
{
	$cadena='<div id="footer_social" style="margin:0 auto 0 auto; width:1000px;; margin-top:80px; padding-top:5px;" >

 <table width="230" border="0" cellspacing="0" cellpadding="0" style="float:left; margin-left:480px;">
                    <tr>
                      <td  height="25" class="arial11Negro" ><strong>Danos tu opini&oacute;n sobre Hispamercado</strong></td>
                    </tr>
                  </table>

<table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                    <tr>
                      <td width="30"><img src="http://www.hispamercado.com.ve/img/social-facebook-box-blue-icon.png" alt="" width="25" height="25" /></td>
                      <td width="70"><strong><a class="LinkFuncionalidad" href="http://www.facebook.com/Hispamercado" target="_blank">Facebook</a></strong></td>
                    </tr>
                  </table>
                  
                  <table width="100" border="0" cellspacing="0" cellpadding="0" style="float:left;" >
                     <tr>
                       <td width="30"><img src="http://www.hispamercado.com.ve/img/social-twitter-box-blue-icon.png" width="25" height="25" /></td>
                       <td width="70"><strong><a class="LinkFuncionalidad" href="http://twitter.com/hispamercado" target="_blank">Twitter</a></strong></td>
                     </tr>
                   </table>
                   
                   <table width="81" border="0" cellspacing="0" cellpadding="0" style="float:left;">
                     <tr>
                       <td width="30"><img src="http://www.hispamercado.com.ve/img/Email-icon.png" width="25" height="25"></td>
                       <td width="51"><strong><a class="LinkFuncionalidad" href="mailto:info@hispamercado.com.ve">E-mail</a></strong></td>
                     </tr>
                   </table>
	
</div>


<div id="footer_vision" style="margin:0 auto 0 auto; width:1000px; padding-left:40px; padding-right:40px; padding-top:15px; padding-bottom:15px; background-color:#77773C; clear:both; text-align:justify;" class="arial13Blanco">
  En Hispamercado creemos que la compra y venta de productos y servicios es una experiencia social. Cuando queremos comprar o vender un producto solemos pedir la opini&oacute;n de amigos o familiares que pueden tener mas conocimientos sobre el tema. Con Hispamercado queremos llevar esa experiencia a Internet, no pretendemos ser un simple portal de clasificados en l&iacute;nea, queremos construir una comunidad de usuarios que interactuen alrededor de los anuncios. Anunciate en Hispamercado y comparte tus opiniones y dudas con la comunidad.
</div>';


	return $cadena;
	
}



?>
