<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
		
	$datos=$user->opciones();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">
<link type="text/css" rel="stylesheet" href="../publicar/suggest/css/autocomplete.css"></link>

<script language="javascript" type="text/javascript">
</script>

<script src="../publicar/suggest/js/jquery-1.4.2.min.js"></script>
<script src="../publicar/suggest/js/autocomplete.jquery.js"></script>
 <script>
            $(document).ready(function(){
                /* Una vez que se cargo la pagina , llamo a todos los autocompletes y
                 * los inicializo */
                $('.autocomplete').autocomplete();
            });
        </script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Hispamercado</title>
</head>

<body>

<table width="500" border="0" cellspacing="0" cellpadding="0" align="center" style="margin-top:30px; margin-bottom:10px;" >
<tr>
  <td width="30" class=" arial15Verde"><img src="../img/Apps-kmymoney-icon.png" width="35" height="35" /></td>
<td width="470" class=" arial15Verde"><strong>¡Tu saldo actual es de <? echo $user->puntos() ?> puntos!</strong></td>
</tr>
</table>

<?
	$puntos=$user->listaPuntos();
	
	for ($i=0;$i<count($puntos);$i++)
	{
		
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
			
			
		if ($puntos[$i]['puntos_mas']==0)
			$puntos_aux="-".$puntos[$i]['puntos_menos'];
		if ($puntos[$i]['puntos_menos']==0)
			$puntos_aux=$puntos[$i]['puntos_mas'];
			
		
		
		$leyenda="";
		if ($puntos[$i]['tipo']=="anuncio")
		{
			$anuncio=new Anuncio($puntos[$i]['id_referencia']);
			$leyenda="Anuncio publicado<br><a href='../".$anuncio->armarEnlace()."' target='_blank' class='LinkFuncionalidad'><em>".$anuncio->titulo."</em></a>";
		}
		if ($puntos[$i]['tipo']=="destacar_anuncio")
		{
			$anuncio=new Anuncio($puntos[$i]['id_referencia']);
			$leyenda="Anuncio destacado<br><a href='../".$anuncio->armarEnlace()."' target='_blank' class='LinkFuncionalidad'><em>".$anuncio->titulo."</em></a>";
		}
		
		if ($puntos[$i]['tipo']=="conversacion")
		{
			$conversacion=new Conversacion($puntos[$i]['id_referencia']);
			$leyenda="Conversación iniciada<br><a href='../".$conversacion->armarEnlace()."' target='_blank' class='LinkFuncionalidad'><em>".$conversacion->titulo."</em></a>";
		}
		
		if ($puntos[$i]['tipo']=="comentario_anuncio")
		{
			$query=operacionSQL("SELECT id_anuncio FROM Anuncio_Comentario WHERE id=".$puntos[$i]['id_referencia']);
			
			$anuncio=new Anuncio(mysql_result($query,0,0));
			$leyenda="Comentario en anuncio<br><a href='../".$anuncio->armarEnlace()."' target='_blank' class='LinkFuncionalidad'><em>".$anuncio->titulo."</em></a>";
		}
		
		
		if ($puntos[$i]['tipo']=="recomendacion_anuncio")
		{
			$query=operacionSQL("SELECT id_anuncio FROM Anuncio_Comentario WHERE id=".$puntos[$i]['id_referencia']);
			
			$anuncio=new Anuncio($puntos[$i]['id_referencia']);
			$leyenda="Anuncio recomendado<br><a href='../".$anuncio->armarEnlace()."' target='_blank' class='LinkFuncionalidad'><em>".$anuncio->titulo."</em></a>";
		}
		
		if ($puntos[$i]['tipo']=="mensaje_anuncio")
		{
			$query=operacionSQL("SELECT id_anuncio FROM AnuncioMensaje WHERE id=".$puntos[$i]['id_referencia']);
			
			$anuncio=new Anuncio(mysql_result($query,0,0));
			$leyenda="Mensaje en anuncio<br><a href='../".$anuncio->armarEnlace()."' target='_blank' class='LinkFuncionalidad'><em>".$anuncio->titulo."</em></a>";
		}
		
		if ($puntos[$i]['tipo']=="comentario_conversacion")
		{
			$query=operacionSQL("SELECT id_conversacion FROM ConversacionComentario WHERE id=".$puntos[$i]['id_referencia']);
			
			$conver=new Conversacion(mysql_result($query,0,0));			
			$leyenda="Comentario en conversación<br><a href='../".$conver->armarEnlace()."' target='_blank' class='LinkFuncionalidad'><em>".$conver->titulo."</em></a>";
		}
		
		if ($puntos[$i]['tipo']=="tienda")
		{
			$tienda=new Tienda($puntos[$i]['id_referencia']);
			$leyenda="Tienda creada<br><a href='../".$tienda->nick."/' target='_blank' class='LinkFuncionalidad'><em>www.hispamercado.com.ve/".$tienda->nick."</em></a>";
		}
		
		if ($puntos[$i]['tipo']=="registro")
		{
			$leyenda="Registro en Hispamercado";
		}
		
	
		echo '<table width="500" border="0" cellspacing="0" cellpadding="0" align="center" bgcolor="'.$colorete.'">
			  <tr>
				<td width="80" height="30" class="arial13Negro">'.aaaammdd_ddmmaaaa($puntos[$i]['fecha']).'</td>
				<td width="337" class="arial13Negro" style="padding-bottom:5px; padding-top:5px;">'.$leyenda.'</td>
				<td width="83" class="arial13Negro">'.$puntos_aux.' puntos</td>
			  </tr>
			</table>';
	}
	
?>





</body>
</html>

<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>

