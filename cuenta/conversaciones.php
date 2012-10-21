<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">


<script language="javascript" type="text/javascript">

	function finalizar(code)
	{
		var dec=window.confirm("Seguro de finalizar esta conversacion? Podras activarla nuevamente cuando quieras");
		if (dec==true)
			document.location.href="conversacionAccion.php?accion=finalizar&code="+code;
	}
	
	function reactivar(code)
	{
		document.location.href="conversacionAccion.php?accion=reactivar&code="+code;
	}

</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Hispamercado</title>
</head>

<body>

<div style="border-bottom:#C8C8C8 1px solid; width:644px; margin:0 auto 0 auto; text-align:right; clear:both; margin-top:30px; padding-left:6px;" >

<? if ($_GET['status']=="A") echo '<span class="arial13Negro"><strong>Activas</strong></span>'; else echo '<a href="conversaciones.php?status=A" class="LinkFuncionalidad13">Activas</a>'; ?>
&nbsp;&nbsp;&nbsp;
<? if ($_GET['status']=="F") echo '<span class="arial13Negro"><strong>Finalizadas</strong></span>'; else echo '<a href="conversaciones.php?status=F" class="LinkFuncionalidad13">Finalizadas</a>'; ?>

</div>

<div style="width:650px; margin:0 auto 0 auto;">
<?

	if ($_GET['status']=="A")
		$query=operacionSQL("SELECT id FROM Conversacion WHERE id_usuario=".$user->id." AND status=1 ORDER BY fecha DESC");
	if ($_GET['status']=="F")
		$query=operacionSQL("SELECT id FROM Conversacion WHERE id_usuario=".$user->id." AND status=0 ORDER BY fecha DESC");
	
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
		
		
		$conversacion=new Conversacion(mysql_result($query,$i,0));
		$usuario=new Usuario($conversacion->id_usuario);		
		
		if ($conversacion->status=="1")
		{
			$accion='<a href="javascript:finalizar('.chr(39).$conversacion->hash.chr(39).')" class="LinkFuncionalidad13"><img src="../img/delete-icon.png" width="19" height="19" border="0" /> Finalizar</a>';
			
			if ($conversacion->comentariosRecibidos()==0)
				$accion='<a href="../conversaciones/publicar.php?edit='.$conversacion->hash.'&d='.time().'" class="LinkFuncionalidad13" target="_blank"><img src="../img/edit-icon.png" width="19" height="19" border="0" />Editar</a>&nbsp;&nbsp;&nbsp;<a href="javascript:finalizar('.chr(39).$conversacion->hash.chr(39).')" class="LinkFuncionalidad13"><img src="../img/delete-icon.png" width="19" height="19" border="0" /> Finalizar</a>';
		
		}
		if ($conversacion->status=="0")
			$accion='<a href="javascript:reactivar('.chr(39).$conversacion->hash.chr(39).')" class="LinkFuncionalidad13"><img src="../img/activate-icon.png" width="19" height="19" border="0" /> Reactivar</a>';
			
			
		
		echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" style="clear:both; border-bottom:#C8C8C8 1px solid; background-color:'.$colorete.';">
			  <tr>
				<td width="110" align="center"><img src="https://graph.facebook.com/'.$usuario->fb_nick.'/picture" /></td>
				<td width="540" height="100" valign="top" style="padding-left:20px;">
				
				<div style="margin-top:10px;">
					<a href="../'.$conversacion->armarEnlace().'" class="tituloAnuncioChico" target="_blank">'.$conversacion->titulo.'</a>
				</div>
				<div class="arial11Negro" style="margin-top:5px;">
					<em>Publicado hace '.$conversacion->tiempoHace().' | '.$conversacion->comentariosRecibidos().' comentarios recibidos</em>
				</div>
				
				<div style="margin-top:30px;">
				
				'.$accion.'
					
				</div>
				
				</td>
			  </tr>
			</table>';
	}


?>
</div>

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

