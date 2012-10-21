<?
	header ("Cache-Control: no-cache, must-revalidate");
	include "../lib/class.php";
	
	$url=$_GET['url'];
	
	//SACANDO EL ID DE LA CONVERSACION
	$id_conversacion=explode("conversacion-",$url);
	$conversacion=new Conversacion($id_conversacion[1]);
	
	
	$graph_url="https://graph.facebook.com/comments/?ids=".$url."&limit=100000";
	$comments = json_decode(file_get_contents($graph_url));
	$comentarios=$comments->$url->comments->data;
	
	
	//AHORA BUSCO LOS COMENTARIOS DE ESA CONVERSACION
	$query=operacionSQL("SELECT id_fb,id FROM ConversacionComentario WHERE id_conversacion=".$conversacion->id);
	for ($j=0;$j<mysql_num_rows($query);$j++)
	{
		$id_actual=mysql_result($query,$j,0);
		$id_interno=mysql_result($query,$j,1);
		
		
		//AHORA VOY A RECORRER TODOS LOS COMENTARIOS DE LA PAGINA EN BUSCA DEL ACTUAL
		$presente=false;
		for ($i=0;$i<count($comentarios);$i++)
		{
			$fb_id=$comentarios[$i]->id;
			
			if ($fb_id==$id_actual)
				$presente=true;
		
		
		
			if (isset($comentarios[$i]->comments->data))
			{
				$subcomentarios=$comentarios[$i]->comments->data;
				for ($e=0;$e<count($subcomentarios);$e++)
				{
					$fb_id=$subcomentarios[$e]->id;
					if ($fb_id==$id_actual)
						$presente=true;
				}
				
			}
		
		}
		
		//ESTE FUE EL QUE SE ELIMINO
		if ($presente==false)
		{
			operacionSQL("DELETE FROM ConversacionComentario WHERE id_fb='".$id_actual."'");
		
			//ELIMINO TODOS AQUELLOS CUYO PADRE ES EL QUE ESTOY ELIMINANDO
			operacionSQL("DELETE FROM ConversacionComentario WHERE id_comentario_padre=".$id_interno);
		}
			
	}
	
	
?>

 <script type="text/javascript">
	  window.___gcfg = {lang: 'es'};
	
	  (function() {
		var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
		po.src = 'https://apis.google.com/js/plusone.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
	  })();
	</script>