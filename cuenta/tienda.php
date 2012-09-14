<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
	
	$nick="";
	$nombre="";
	$descripcion="";
		
	$id_tienda=$user->idTienda();
	if ($id_tienda!=false)
	{
		$tienda=new Tienda($id_tienda);
		
		$nick=$tienda->nick;
		$nombre=$tienda->nombre;
		$descripcion=$tienda->descripcion;
	}
		
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">


<script language="javascript" type="text/javascript">
	
	function activar()
	{
		window.alert(document.Forma.activar.checked.value);
	}

</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hispamercado</title>
</head>

<body>

<div style="margin-top:30px;">
  
<form id="Forma" name="Forma" method="post" action="tienda2.php">
  
  <div style="width:570px; border-style:solid; border-color:#999; border-width:1px; border-bottom:1px dashed #999; background-color:#F4F9E8; margin:0 auto 0 auto; padding:15px;" class="arial13Negro">
  
  <p>Crea una tienda personalizada con todos tus anuncios en un dos por tres. Pasa el link de tu tienda hispamercado a todos tus clientes y promociona de forma efectiva todos tus productos o servicios.</p>
      <p>El link de tu tienda sera <a href="" class="LinkFuncionalidad13">tiendas.hispamercado.com.ve/nickdetienda</a></p>
  </div>
  <div style="width:570px; border-style:solid; border-color:#999; border-width:1px; border-top:0px; background-color:#F4F9E8; padding:15px;  margin:0 auto 0 auto; ">
  <table width="500" border="0" cellspacing="0" cellpadding="0" style=" margin-top:10px;">
    <tr>
      <td class="arial13Negro" style="padding:5px;">Nick de tienda</td>
      <td style="padding:5px;"><label for="nick"></label>
        <input name="nick" type="text" id="nick" size="20" maxlength="20" value="<? echo $nick ?>" />
        <a href="" class="LinkFuncionalidad13">Chequear disponibilidad</a>
        <br /></td>
    </tr>
    <tr>
      <td width="130" class="arial13Negro" style="padding:5px;">Nombre de tienda</td>
      <td width="370" style="padding:5px;"><input name="nombre" type="text" id="nombre" size="25" value="<? echo $nombre ?>" /></td>
    </tr>
    <tr>
      <td class="arial13Negro" style="padding:5px;">Descripción</td>
      <td style="padding:5px;"><textarea name="descripcion" cols="25" rows="3" id="descripcion"><? echo $descripcion ?></textarea></td>
    </tr>
    <tr>
      <td class="arial13Negro" style="padding:5px;">Logo</td>
      <td style="padding:5px;"><a href="" class=" LinkFuncionalidad13">Subir logo</a><br />
        <span class="arial11Gris">Tamaño recomendado: 200 pixeles de ancho</span></td>
    </tr>
</table>

<div align="center" style="width:500px; margin-top:15px;"><input type="submit" name="button2" id="button2" value="Guardar cambios" style="font-family:Arial, Helvetica, sans-serif; font-size:15px;" /></div>
  
 </div> 
</form>
</div>
</body>
</html>
