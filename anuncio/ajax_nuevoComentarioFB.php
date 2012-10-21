<?
	header ("Cache-Control: no-cache, must-revalidate");
	include "../lib/class.php";
	$sesion=checkSession();	

	//CASOS USUARIO REGISTRADO
	if ($sesion!=false)
	{
		$usuario=new Usuario($sesion);
		$id_usuario=$usuario->id;
	}
	else
		$id_usuario="NULL";
	
	$url=$_GET['url'];
	
	//SACANDO EL ID DE LA CONVERSACION
	$id_conversacion=explode("anuncio-",$url);
	$anuncio=new Anuncio($id_conversacion[1]);
	
	
	
	$graph_url="https://graph.facebook.com/comments/?ids=".$url."&limit=100000";
	$comments = json_decode(file_get_contents($graph_url));
	
	
	$comentarios=$comments->$url->comments->data;
	
	for ($i=0;$i<count($comentarios);$i++)
	{
		$fb_id=$comentarios[$i]->id;
		//echo "<br>";
		$de_id=$comentarios[$i]->from->id;
		//echo "<br>";
		$de_nombre=utf8_decode($comentarios[$i]->from->name);
		//echo "<br>";		
		$mensaje=$comentarios[$i]->message;
		//echo "<br>";
		$hora=$comentarios[$i]->created_time;
		//echo "<br>";
		
		$aux=explode("T",$hora);
		$hora=$aux[0]." ".$aux[1];
		$aux=explode("+",$hora);
		$hora=$aux[0];
		
		
		//VERIFICO QUE USUARIO DE FB YA SE ENCUENTRE REGISTRADO
		$query=operacionSQL("SELECT id FROM Usuario WHERE fb_id='".$de_id."'");
		if (mysql_num_rows($query)>0)
			$id_usuario=mysql_result($query,0,0);
			
		
		//PRIMERO COMRUEBO QUE NO SE HAYA CARGADO
		$query=operacionSQL("SELECT id FROM Anuncio_Comentario WHERE id_fb='".$fb_id."'");
		if (mysql_num_rows($query)==0)
			operacionSQL("INSERT INTO Anuncio_Comentario VALUES (null,".$anuncio->id.",'".$fb_id."',".$id_usuario.",NULL,('".$hora."' - INTERVAL 270 MINUTE),'".$mensaje."','".$de_nombre."','".$de_id."',1)");
		
		
		if (isset($comentarios[$i]->comments->data))
		{
			$subcomentarios=$comentarios[$i]->comments->data;
			for ($e=0;$e<count($subcomentarios);$e++)
			{
				$fb_id=$subcomentarios[$e]->id;
				//echo "<br>";
				$de_id=$subcomentarios[$e]->from->id;
				//echo "<br>";
				$de_nombre=utf8_decode($subcomentarios[$e]->from->name);
				//echo "<br>";		
				$mensaje=$subcomentarios[$e]->message;
				//echo "<br>";
				$hora=$subcomentarios[$e]->created_time;
				//echo "<br>";
				$aux=explode("T",$hora);
				$hora=$aux[0]." ".$aux[1];
				$aux=explode("+",$hora);
				$hora=$aux[0];
				
				//BUSCANDO EL ID DEL PADRE
				$query=operacionSQL("SELECT id FROM Anuncio_Comentario WHERE id_fb='".$comentarios[$i]->id."'");
				$id_padre=mysql_result($query,0,0);
				
				
				//VERIFICO QUE USUARIO DE FB YA SE ENCUENTRE REGISTRADO
				$query=operacionSQL("SELECT id FROM Usuario WHERE fb_id='".$de_id."'");
				if (mysql_num_rows($query)>0)
					$id_usuario=mysql_result($query,0,0);
					
				
				//PRIMERO COMRUEBO QUE NO SE HAYA CARGADO
				$query=operacionSQL("SELECT id FROM Anuncio_Comentario WHERE id_fb='".$fb_id."'");
				if (mysql_num_rows($query)==0)
					operacionSQL("INSERT INTO Anuncio_Comentario VALUES (null,".$anuncio->id.",'".$fb_id."',".$id_usuario.",".$id_padre.",('".$hora."' - INTERVAL 270 MINUTE),'".$mensaje."','".$de_nombre."','".$de_id."',1)");
				
			}
			
		}	
	}
	
	
	$mensaje='<p>Hola '.$anuncio->anunciante_nombre.',</p>
				<p>Has recibido un comentario en tu anuncio Hispamercado (<em>'.$anuncio->titulo.'</em>).</p>
				<p>Para ver y responder a todos tus comentarios ve directamente a link de tu anuncio</p>
				<p><a href="http://www.hispamercado.com.ve/'.$anuncio->armarEnlace().'">http://www.hispamercado.com.ve/'.$anuncio->armarEnlace().'</a></p>
				<p>Gracias por usar Hispamercado!</p>';
		email("Hispamercado","info@hispamercado.com.ve",$anuncio->anunciante_nombre,$anuncio->anunciante_email,utf8_decode("Has recibido un nuevo comentario en tu anuncio"),$mensaje);
	
	


?>


 <script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>