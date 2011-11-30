<?	
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);			
	
	$barra=barraPrincipal("../");
	$barraLogueo=barraLogueo();
	$barraPaises= barraPaises($id_pais);
	
	
	$codigo_verificacion=$_SESSION['codigo_verificacion'];
	$query=operacionSQL("SELECT id,status_general FROM Anuncio WHERE codigo_verificacion='".$codigo_verificacion."'");
	$anuncio=new Anuncio(mysql_result($query,0,0));
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<script language="javascript" type="text/javascript" src="../lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript">
</script>







<title>Gestion de anuncio</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body>

  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td width="295" align="left"><a href="../"><img src="../img/logo_290.JPG" width="290" height="46" border="0"></a></td>
      <td width="280" align="left" valign="bottom" class="arial13Mostaza"><strong><em>Anuncios Clasificados  en Venezuela</em></strong></td>
      <td width="225" align="right" valign="top" class="arial11Negro"><a href="javascript:window.alert('Sección en construcción')" class="LinkFuncionalidad">T&eacute;rminos</a> | <a href="../sugerencias.php" class="LinkFuncionalidad">Sugerencias</a></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="6" bgcolor="#FFFFFF">
    <tr>
      <td width="10">&nbsp;</td>
      <td width="777" align="right" class="Arial11Negro">&nbsp;</td>
      <td width="13">&nbsp;</td>
    </tr>
  </table>
  <? echo $barra; ?>
  <table width="300" border="0" align="center" cellpadding="0" cellspacing="5" bgcolor="#FFFFFF">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div align="center">
    <table width="800" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse ">
      <tr>
        <td width="653" align="left" valign="bottom" class="arial13Negro"><a href="/" class="LinkFuncionalidad13"><b>Inicio </b></a>&raquo; Gestion de anuncio</td>
        <td width="147" align="right" valign="bottom" class="arial13Negro"><a href="detalles.php" class="LinkFuncionalidad13">Anuncio</a>&nbsp;&nbsp;&nbsp;<strong>Comentarios</strong></td>
      </tr>
    </table>
    <table cellpadding='0 'cellspacing='0' border='0' width='800' align='center' bgcolor="#C8C8C8">
      <tr>
        <td height="1"></td>
      </tr>
    </table>
  </div>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
 <form name="Forma" method="post" action="comentariosGestionar.php">
   <table width="600" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#F4F9E8" style="border-collapse:collapse">
     <tr bgcolor="#F4F9E8">
       <td align="left" class="arial13Negro"><strong>Comentarios recibidos
         <input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $anuncio->id ?>">
       </strong></td>
     </tr>
     <tr>
       <td valign="top"><?
		
		$comentarios=$anuncio->comentarios();
		for ($i=0;$i<count($comentarios);$i++)
		{
			//echo $comentarios[$i]['respuesta'];
			
			if ($comentarios[$i]['respuesta']!="")
				$respuesta=$comentarios[$i]['respuesta'];
			else
				$respuesta="<textarea name='respuesta_".$comentarios[$i]['id']."' cols='35' rows='3' id='respuesta_'>".$comentarios[$i]['respuesta']."</textarea>";
			
			
			echo "<table width='97%' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
					  <td align='left' class='arial13Negro'>&nbsp;</td>
					</tr>
					<tr>
					  <td align='left' class='arial13Negro'><span class='arial13Gris'>".aaaammdd_ddmmaaaa($comentarios[$i]['fecha'])."</span> | <a href='mailto:".$comentarios[$i]['de_email']."' class='LinkFuncionalidad13'>".$comentarios[$i]['de_nombre']."</a></td>
					</tr>
				  </table>
					<table width='97%' border='0' align='center' cellpadding='3' cellspacing='0'>
					  <tr>
						<td width='11%' align='left' class='arial13Negro'><b>Comentario:</b></td>
						<td width='89%' align='left' class='arial13Negro'>".$comentarios[$i]['comentario']."</td>
					  </tr>
					  <tr>
						<td align='left' class='arial13Negro'><b>Respuesta:</b></td>
						<td align='left' class='arial13Negro'>".$respuesta."</td>
					  </tr>
					
					<table width='97%' border='0' align='center' cellpadding='0' cellspacing='0'>
					  <tr>
						<td align='left' class='arial13Negro'>&nbsp;</td>
					  </tr>
					</table>
						<table cellpadding='0 'cellspacing='0' border='0' width='97%' align='center' bgcolor='#F4F9E8'>
							<tr>
						<td height='1'></td>
						  </tr>
					</table>";
			
			
			
			/*echo "<table width='97%' border='0' align='center' cellpadding='0' cellspacing='0'>
					<tr>
					  <td align='left' class='arial13Negro'>&nbsp;</td>
					</tr>
					<tr>
					  <td align='left' class='arial13Negro'><span class='arial13Gris'>".aaaammdd_ddmmaaaa($comentarios[$i]['fecha'])."</span> | <a href='mailto:".$comentarios[$i]['de_email']."' class='LinkFuncionalidad13'>".$comentarios[$i]['de_nombre']."</a></td>
					</tr>
					<tr>
					  <td class='arial13Negro'>Comentario: ".$comentarios[$i]['comentario'].$respuesta."</td>					 
					</tr>
					<tr>
					  <td>&nbsp;</td>
					</tr>
				  </table>
					<table cellpadding='0 'cellspacing='0' border='0' width='97%' align='center' bgcolor='#F4F9E8'>
					  <tr>
						<td height='1'></td>
					  </tr>
					</table>";*/
		}
        
		
		?></td>
     </tr>
   </table>
   <p align="center">
     <input type="submit" name="Submit" value="Responder comentarios">
</p>
      <table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      <table width="800" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
        <tr>
          <td align="center" class="arial13Negro"><? echo $barraPaises; ?> </td>
        </tr>
      </table>
</form>

</body>
</html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
var pageTracker = _gat._getTracker("UA-3308629-1");
pageTracker._initData();
pageTracker._trackPageview();
</script>