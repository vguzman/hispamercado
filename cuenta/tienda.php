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


<SCRIPT LANGUAGE="JavaScript" src="../lib/js/ajax.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" src="../lib/js/basicos.js"></SCRIPT>
<script language="javascript" type="text/javascript">
	
function tiendaVerificarNick()
{
	var patron=/^[a-zA-Z0-9]*$/;
	
	if (patron.test(trim(document.Forma.nick.value))==false)
	{
		window.alert("Debes ingresar un nick para tu tienda válido");
		return;
	}
	
	req=getXMLHttpRequest();
	req.onreadystatechange=process_tiendaVerificarNick;
	url="http://www.hispamercado.com.ve/cuenta/tiendaChequearNick.php?nick="+trim(document.Forma.nick.value);
	//window.alert(url);
	req.open("GET",url, true);
	req.send(null);
}

function process_tiendaVerificarNick()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			if (req.responseText=="SI")
			{	
				document.Forma.disponibilidad.value="SI";
				document.getElementById("disponibilidad_html").innerHTML='<img src="../img/checked.png" width="18" height="18" />';
			}
			if (req.responseText=="NO")
			{	
				window.alert("Ya este nick de tienda fue escogido por otro usuario");
				document.Forma.disponibilidad.value="NO";
			}
		}
		 
		else 
			alert("Problema");      
	}
}


function procesar()
{
	if (document.Forma.disponibilidad.value=="NO")
		window.alert("Debes indicar un nick para tu tienda y chequear su disponibilidad");
	else
		if (trim(document.Forma.nombre.value)=="")
			window.alert("Debes indicar el nombre para tu tienda");
		else
			document.Forma.submit();
}

function manejoNick()
{
	document.Forma.disponibilidad.value="NO";
	document.getElementById("disponibilidad_html").innerHTML='<a href="javascript:tiendaVerificarNick()" class="LinkFuncionalidad13">Chequear disponibilidad</a>';
}


function subirFoto()
{	
	window.open("tiendaSubirLogo.php","subir_logo","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=400,height=130");
}

function borrarLogo()
{
	document.Forma.logo.value="NO";
	document.getElementById("logo_html").innerHTML='<a href="javascript:subirFoto()" class=" LinkFuncionalidad13">Subir logo</a><br /><span class="arial11Gris">Tamaño recomendado: 300 pixeles de ancho</span>';
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
      <p>El link de tu tienda sera <a href="http://tiendas.hispamercado.com.ve/<? if (isset($tienda)) echo $tienda->nick; else echo "nickdetienda"; ?>" class="LinkFuncionalidad13" target="_blank">tiendas.hispamercado.com.ve/<? if (isset($tienda)) echo $tienda->nick; else echo "nickdetienda"; ?></a></p>
  </div>
  <div style="width:570px; border-style:solid; border-color:#999; border-width:1px; border-top:0px; background-color:#F4F9E8; padding:15px;  margin:0 auto 0 auto; ">
  <table width="500" border="0" cellspacing="0" cellpadding="0" style=" margin-top:10px;">
    <tr>
      <td class="arial13Negro" style="padding:5px;">Nick de tienda <span class="arial13Rojo">*</span><input type="hidden" name="disponibilidad" id="disponibilidad" value="<? if (isset($tienda)) echo "SI"; else echo "NO";   ?>" /></td>
      <td style="padding:5px;">
        <input name="nick" type="text" id="nick" size="20" maxlength="20" value="<? echo $nick ?>" onkeypress="manejoNick()" />
        
        <span id="disponibilidad_html">
        <?	
            if (isset($tienda)) 
				echo '<img src="../img/checked.png" width="18" height="18" />';
			else
				echo '<a href="javascript:tiendaVerificarNick()" class="LinkFuncionalidad13">Chequear disponibilidad</a>';
        ?>
        </span>
        
        
        <br /><span class="arial11Gris">Solo letras y números</span></td>
    </tr>
    <tr>
      <td width="130" class="arial13Negro" style="padding:5px;">Nombre de tienda <span class="arial13Rojo">*</span></td>
      <td width="370" style="padding:5px;"><input name="nombre" type="text" id="nombre" size="25" value="<? echo $nombre ?>" /></td>
    </tr>
    <tr>
      <td class="arial13Negro" style="padding:5px;">Descripción</td>
      <td style="padding:5px;"><textarea name="descripcion" cols="45" rows="4" id="descripcion"><? echo $descripcion ?></textarea></td>
    </tr>
    <tr>
      <td class="arial13Negro" style="padding:5px;">Logo
        <input type="hidden" name="logo" id="logo" value="<? echo $tienda->logo ?>" /></td>
      <td style="padding:5px;" id="logo_html"><? 
	  			
				
				if ((isset($tienda)==false)||($tienda->logo=="NO"))
					echo '<a href="javascript:subirFoto()" class=" LinkFuncionalidad13">Subir logo</a><br />
        <span class="arial11Gris">Tamaño recomendado: 300 pixeles de ancho</span>';
				else
					echo "<img src='../img/img_bank/tiendaLogo/".$tienda->id."_muestra?d=".time()."'><br><a href='javascript:borrarLogo()' class='LinkFuncionalidad'>Cambiar logo</a>";
	  	
	  
	  ?></td>
    </tr>
</table>

<div align="center" style="width:500px; margin-top:15px;"><input type="button" name="button2" id="button2" value="Guardar cambios" style="font-family:Arial, Helvetica, sans-serif; font-size:15px;" onclick="procesar()" /></div>
  
 </div> 
</form>
</div>
</body>
</html>
