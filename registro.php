<?
	session_start();
	include "lib/class.php";

	 
	
	if (isset($_GET['code']))
	{
		$code=$_GET['code'];
		$state=$_GET['state'];
		
		if ($state==$_SESSION['state'])
		{
			$token_url="https://graph.facebook.com/oauth/access_token?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&client_secret=213d854b0e677a7e5b72b16ec8297325&code=".$code;
			
			$response = file_get_contents($token_url);
     		$params = null;
     		parse_str($response, $params);

			$access_token=$params['access_token'];
			$expires_token=$params['expires'];
			
			
			$graph_url = "https://graph.facebook.com/me?access_token=".$access_token; 
			$user = json_decode(file_get_contents($graph_url));

			
			$nombre=utf8_decode($user->name);
			//echo "<br>";
			$fb_nick=$user->username;
			//echo "<br>";
			$fb_id=$user->id;
			//echo "<br>";
			$email=$user->email;
			//echo "<br>";
			
			
			$query=operacionSQL("SELECT * FROM Usuario WHERE fb_id=".$fb_id);
			//NUEVO USUARIO
			if (mysql_num_rows($query)==0)
			{
				$_SESSION['puntos']=5;
				$_SESSION['puntos_tipo']="registro";
				
				
				$cookie=md5(uniqid(rand().$fb_id, TRUE));
				
				
				$aux="INSERT INTO Usuario VALUES (null,".$fb_id.",'".$fb_nick."','".$nombre."','".$email."','".$access_token."',NOW()+INTERVAL ".$expires_token." SECOND,'".$cookie."','A')";
				operacionSQL($aux);
				
				//BUSCANDO USUARIO NUEVO				
				$query2=operacionSQL("SELECT id FROM Usuario WHERE fb_id=".$fb_id);
				$id_usuario=mysql_result($query2,0,0);
				
				
				
				//INSERTANDO LAS OPCIONES
				operacionSQL("INSERT INTO UsuarioOpciones VALUES (".$id_usuario.",0,0,0,0)");
				
				
				
				//BUSCANDO ANUNCIOS CON ESE EMAIL
				operacionSQL("UPDATE Anuncio SET id_usuario=".$id_usuario." WHERE anunciante_email LIKE '%".$email."%'");
				
				
				
				
				$usuario_nuevo=new Usuario($id_usuario);
				$usuario_nuevo->puntosOperacion("registro",$id_usuario,5,0);
				
			
				
				$resul=email("Hispamercado","no-responder@hispamercado.com.ve",$nombre,$email,"Bienvenido a Hispamercado",utf8_decode("<p>Hola ".utf8_encode($nombre).", Bienvenido a Hispamercado!</p><p>A partir de ahora podras disfrutar de los beneficios de pertenecer a la comunidad Hispamercado.</p>
<p>&nbsp;</p>


<strong><table width='480' border='0' cellspacing='0' cellpadding='0' align='left' >
    <tr>
      <td><img src='http://www.hispamercado.com.ve/img/Apps-kmymoney-icon.png' width='60' height='60' /></td>
      <td><em>¡Gana puntos por participar!</em> Podras <a href='http://www.hispamercado.com.ve/programa-de-puntos.php' class='LinkFuncionalidad13'>ganar puntos</a> por todas tus actividades en Hispamercado que luego podras cambiar por destacar tus anuncios.</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width='60'><img src='http://www.hispamercado.com.ve/img/edit-icon-big.png' width='50' height='50' /></td>
      <td width='420'><em>¡Gestiona tus anuncios!</em> Podrás editar/eliminar tus anuncios y conversaciones de una manera mas cómoda y fácil</td>
    </tr>
    <tr>
      <td align='center'>&nbsp;</td>
      <td align='center'>&nbsp;</td>
    </tr>
    <tr>
      <td style='padding-top:10px;'><img src='http://www.hispamercado.com.ve/img/shopping-cart-icon.png' width='50' height='50' /></td>
      <td style='padding-top:10px;'><em>¡Crea una tienda!</em> Podrás registrar una tienda en Hispamercado con tu propia direccion Web para que tus clientes accedan facilmente a todos tus anuncions</td>
    </tr>
    <tr>
      <td align='center'>&nbsp;</td>
      <td align='center'>&nbsp;</td>
    </tr>
    <tr>
      <td style='padding-top:10px;'><img src='http://www.hispamercado.com.ve/img/elfeisbuk.png' width='50' height='50' /></td>
      <td style='padding-top:10px;'><em>¡Comparte con tus amigos!</em> Podrás configurar tu cuenta para que todos los anuncios o conversaciones que publiques se conpartan automáticamente en tu cuenta de Facebook</td>
    </tr>
    <tr>
      <td style='padding-top:10px;' align='center'>&nbsp;</td>
      <td style='padding-top:10px;' align='center'>&nbsp;</td>
    </tr>
    <tr>
      <td style='padding-top:10px;'><img src='http://www.hispamercado.com.ve/img/Clock-icon.png' width='50' height='50' /></td>
      <td style='padding-top:10px;'><em>¡Ahorra tiempo!</em> Si te molesta escribir una y otra vez tus datos de contacto cuando publicas un anuncion, podrás configurar tu cuenta para que esos datos se carguen de forma automática en el formulario de publicación</td>
    </tr>
    <tr>
      <td style='padding-top:10px;' align='center'>&nbsp;</td>
      <td style='padding-top:10px;' align='center'>&nbsp;</td>
    </tr>
  </table></strong>




<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>----------------<br>El equipo de Hispamercado</p>"));	
			}
			else
			{
				$id_usuario=mysql_result($query,0,0);
				$aux="UPDATE Usuario SET fb_token='".$access_token."', fb_token_expires=NOW()+INTERVAL ".$expires_token." SECOND WHERE fb_id=".$fb_id;
				operacionSQL($aux);
			}			
			
			
			//INICIANDO SESION
			$usuario=new Usuario($id_usuario);
			setcookie("hispacookie",$usuario->cookie,time() + (30*24*60*60),"/",".hispamercado.com.ve",false,true);
			
			
			if ($usuario->puntos()>=15)
			{
				$_SESSION['puntos']=0;
				$_SESSION['puntos_tipo']="mas15";
			}
		}
		
		
	}


	echo '<SCRIPT LANGUAGE="JavaScript">
			window.opener.history.go(0);
			window.close();
			</SCRIPT>';

?>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>