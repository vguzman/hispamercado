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


<script language="javascript" type="text/javascript">

	function accionAnuncio(accion,code)
	{
		if (accion=="finalizar")
		{
			var dec=window.confirm("Seguro de finalizar este anuncio? Podras activarlo nuevamente cuando quieras");
			if (dec==true)
				document.location.href="../publicar/gestionAccion.php?accion="+accion+"&code="+code;
		}
		else
			document.location.href="../publicar/gestionAccion.php?accion="+accion+"&code="+code;
	}

</script>


<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hispamercado</title>


<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">


</head>

<body>







<div style="border-bottom:#C8C8C8 1px solid; width:644px; margin:0 auto 0 auto; text-align:right; clear:both; margin-top:30px; padding-left:6px;" >

<? if ($_GET['status']=="A") echo '<span class="arial13Negro"><strong>Activos</strong></span>'; else echo '<a href="anuncios.php?status=A" class="LinkFuncionalidad13">Activos</a>'; ?>
&nbsp;&nbsp;&nbsp;
<? if ($_GET['status']=="F") echo '<span class="arial13Negro"><strong>Finalizados</strong></span>'; else echo '<a href="anuncios.php?status=F" class="LinkFuncionalidad13">Finalizados</a>'; ?>

</div>


<div style="width:650px; margin:0 auto 0 auto;">
<?

	if ($_GET['status']=="A")
		$query=operacionSQL("SELECT id FROM Anuncio WHERE id_usuario=".$user->id." AND status_general='Activo' ORDER BY fecha DESC");
	if ($_GET['status']=="F")
		$query=operacionSQL("SELECT id FROM Anuncio WHERE id_usuario=".$user->id." AND status_general='Inactivo' ORDER BY fecha DESC");
	
	
	
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
		
		
		$anuncio=new Anuncio(mysql_result($query,$i,0));
		
		
		if ($anuncio->status_general=="Activo")
			$accion='<a href="javascript:accionAnuncio('.chr(39).'finalizar'.chr(39).','.chr(39).$anuncio->codigo_verificacion.chr(39).')" class="LinkFuncionalidad13"><img src="../img/delete-icon.png" width="19" height="19" border="0" /> Finalizar</a>';
		if ($anuncio->status_general=="Inactivo")
			$accion='<a href="javascript:accionAnuncio('.chr(39).'reactivar'.chr(39).','.chr(39).$anuncio->codigo_verificacion.chr(39).')" class="LinkFuncionalidad13"><img src="../img/activate-icon.png" width="19" height="19" border="0" /> Reactivar</a>';
			
			
		
		echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" style="clear:both; border-bottom:#C8C8C8 1px solid; background-color:'.$colorete.';">
			  <tr>
				<td width="110" align="center"><img src="../lib/img.php?tipo=gestion&anuncio='.$anuncio->id.'" /></td>
				<td width="540" height="100" valign="top" style="padding-left:20px;">
				
				<div style="margin-top:10px;">
					<a href="../'.$anuncio->armarEnlace().'" class="tituloAnuncioChico" target="_blank">'.$anuncio->titulo.'</a>
				</div>
				<div class="arial11Negro" style="margin-top:5px;">
					<em>Publicado hace '.$anuncio->tiempoHace().' | '.$anuncio->visitas().' visitas</em>
				</div>
				
				<div style="margin-top:30px;">
				
				<a href="../publicar/index.php?edit='.$anuncio->codigo_verificacion.'&d='.time().'" class="LinkFuncionalidad13" target="_blank"><img src="../img/edit-icon.png" width="19" height="19" border="0" />Editar</a>&nbsp;&nbsp;&nbsp; '.$accion.' &nbsp;&nbsp;&nbsp;  <a href="" class="LinkFuncionalidad13"><img src="../img/chart-icon.png" width="19" height="19" border="0" /> Destacar</a>
					
				</div>
				
				</td>
			  </tr>
			</table>';
	}


?>
</div>

</body>
</html>
