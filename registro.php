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
				
				
				
				
				$resul=email("Hispamercado","no-responder@hispamercado.com.ve",$nombre,$email,"Bienvenido a Hispamercado","<p>Hola ".$nombre.", Bienvenido a Hispamercado!</p><p>A partir de ahora podras disfrutar de los beneficios de pertenecer a la comunidad Hispamercado.</p><p>----------------<br>Hispamercado</p>");	
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