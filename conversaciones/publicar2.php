<?	
	include "../lib/class.php";
	require '../lib/facebook/src/facebook.php';
	$sesion=checkSession();	

	//CASOS USUARIO REGISTRADO
	if ($sesion!=false)
	{
		$usuario=new Usuario($sesion);
		$id_usuario=$usuario->id;
	}
	else
		$id_usuario="NULL";
		
	$id_sesion=session_id();
	$hoy=getdate();
	$fecha2=$hoy['year'].$hoy['mon'].$hoy['mday'].$hoy['hours'].$hoy['minutes'].$hoy['seconds'];	
	$verificacion=codigo_verificacion($fecha2,$id_sesion);
	
	if (isset($_POST['notificaciones']))
		$noti=1;
	else
		$noti=0;
	
	
	if ($_POST['tipo']=="new")
	{
	
		$query=operacionSQL("SELECT MAX(id) FROM Conversacion");
		$id_nuevo=mysql_result($query,0,0)+1;
		
		
		$aux="INSERT INTO Conversacion VALUES (".$id_nuevo.",'".$verificacion."',".$id_usuario.",".trim($_POST['categoria']).",NOW(),'".trim($_POST['titulo'])."','".trim($_POST['content'])."',".$noti.",1)";
		operacionSQL($aux);
	}
	else
	{
		$query=operacionSQL("SELECT id FROM Conversacion WHERE hash='".$_POST['hash']."'");
		$id_nuevo=mysql_result($query,0,0);
		
		operacionSQL("UPDATE Conversacion SET id_categoria=".trim($_POST['categoria']).", titulo='".trim($_POST['titulo'])."', descripcion='".trim($_POST['content'])."', notificaciones=".$noti." WHERE id=".$id_nuevo);
	}
	
	$conver=new Conversacion($id_nuevo);
	
	$opciones=$usuario->opciones();
		
	if ($opciones['fb_conversacion']=="1")
	{
			
		$facebook = new Facebook(array(
		  'appId'  => '119426148153054',
		  'secret' => '213d854b0e677a7e5b72b16ec8297325',
		));
		
	$result = $facebook->api( 
			'/me/feed/', 'post' ,
			array('access_token' => $usuario->fb_token, 'message' => "He iniciado una conversacion en Hispamercado. Participa!" , 'link' => 'http://www.hispamercado.com.ve/'.$conver->armarEnlace() , 'picture' => 'https://graph.facebook.com/'.$usuario->fb_nick.'/picture' ) 
		);
		
		
	}
	
	
	
	echo "<script type='text/javascript'>
			document.location.href='../".$conver->armarEnlace()."';
		</script>";

?>

<script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>