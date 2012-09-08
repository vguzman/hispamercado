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
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hispamercado</title>


<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">


</head>

<body>


<ul class="miCuentaMenu">

	<li style="border-top:2px solid #77773C; border-left:2px solid #77773C; border-right:2px solid #77773C; border-bottom:1px solid #FFF; background-color:#FFF; width:120px; text-align:center; float:left; height:31px; padding-top:8px;"><span class="arial13Negro"><strong>Anuncios</strong></span></li>
    <li style="width:140px; text-align:center; float:left; height:35px; padding-top:8px;"><a href="" class="LinkmiCuentaMenu"><strong>Conversaciones</strong></a></li>
    <li style="width:80px; text-align:center; float:left; height:35px; padding-top:8px;"><a href="" class="LinkmiCuentaMenu"><strong>Tienda</strong></a></li>
    <li style="width:90px; text-align:center; float:left; height:35px; padding-top:8px;"><a href="" class="LinkmiCuentaMenu"><strong>Créditos</strong></a></li>
    <li style="width:90px; text-align:center; float:left; height:35px; padding-top:8px;"><a href="" class="LinkmiCuentaMenu"><strong>Generales</strong></a></li>

</ul>


<?

	$query=operacionSQL("SELECT id FROM Anuncio WHERE id_usuario=".$user->id." AND status_general='Activo'");
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
		if (($i%2)==0)
			$colorete="#F2F7E6";			
		else
			$colorete="#FFFFFF";
		
		
		$anuncio=new Anuncio(mysql_result($query,$i,0));
		
		echo '<table width="650" border="0" cellspacing="0" cellpadding="0" align="center" style="clear:both; border-bottom:#C8C8C8 1px solid; background-color:'.$colorete.';">
			  <tr>
				<td width="148">&nbsp;</td>
				<td width="502" height="100" valign="top" style="padding-left:10px;">
				
				<div style="margin-top:10px;">
					<a href="" class="tituloAnuncioChico">'.$anuncio->titulo.'</a>
				</div>
				<div class="arial11Negro" style="margin-top:5px;">
					<em>Publicado hace '.$anuncio->tiempoHace().' | 545 visitas</em>
				</div>
				
				<div style="margin-top:30px;">
				
				<a href="" class="LinkFuncionalidad13"><img src="../img/edit-icon.png" width="19" height="19" border="0" /> Editar   </a>&nbsp;&nbsp;&nbsp;<a href="" class="LinkFuncionalidad13"><img src="../img/delete-icon.png" width="19" height="19" border="0" /> Finalizar</a>&nbsp;&nbsp;&nbsp;  <a href="" class="LinkFuncionalidad13"><img src="../img/chart-icon.png" width="19" height="19" border="0" /> Destacar</a>
					
				</div>
				
				</td>
			  </tr>
			</table>';
	}


?>

</body>
</html>
