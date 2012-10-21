<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	else
		exit;
		
		
	$datos=$user->predatos();
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
<form id="form1" name="form1" method="post" action="generales2.php">

<div style="width:570px; border-style:solid; border-color:#999; border-width:1px;  background-color:#F4F9E8; margin:0 auto 0 auto; padding:15px; margin-top:30px;" class="arial13Negro">
     
     <div><strong>Preferencias de publicaci&oacute;n</strong></div>
     
     <div style="margin-top:15px; margin-top:15px;"><em>Para que no tengas que introducir los mismos datos cada vez que publiques un anuncio, los datos que indiques aqui se precargaran automaticamente en el formulario de publicación de anuncios</em></div>
     
  <div style="margin-top:15px;">
     
       <table width="500" border="0" cellspacing="2" cellpadding="3">
         <tr>
           <td width="107">Nombre</td>
           <td width="375"><label for="nombre"></label>
           <input name="nombre" type="text" id="nombre" size="30" value="<? echo $datos['nombre'] ?>" /></td>
         </tr>
         <tr>
           <td>E-mail</td>
           <td><label for="email"></label>
           <input name="email" type="text" id="email" size="30" value="<? echo $datos['email'] ?>" /></td>
         </tr>
         <tr>
           <td>Tel&eacute;fonos</td>
           <td><label for="telefonos"></label>
           <input name="telefonos" type="text" id="telefonos" size="30" value="<? echo $datos['telefonos'] ?>" /></td>
         </tr>
         <tr>
           <td>Ciudad</td>
           <td class="autocomplete" ><input name="ciudad" type="text" id="ciudad" size="30" maxlength="255" value="<? echo $datos['ciudad'] ?>" data-source="../publicar/suggest/search.php?search=" /></td>
         </tr>
       </table>
   
</div>

<div align="center" style="margin-top:20px;">
  <input type="submit" name="button" id="button" value="Guardar cambios" />
</div>
     
     
</div>


 </form>
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

