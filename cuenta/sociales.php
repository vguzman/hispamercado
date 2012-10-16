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
<form id="form1" name="form1" method="post" action="sociales2.php">

<div style="width:570px; border-style:solid; border-color:#999; border-width:1px;  background-color:#F4F9E8; margin:0 auto 0 auto; padding:15px; margin-top:30px;" class="arial13Negro">
     
     
    <div style="margin:0 auto 0 auto; width:90%; border-bottom:dashed 1px #333;">
      <table width="300" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40"><img src="../img/social-facebook-box-blue-icon.png" alt="" width="32" height="32" /></td>
          <td width="260"><strong>Facebook</strong></td>
        </tr>
      </table>
</div>
     <div style="margin:0 auto 0 auto; width:90%; margin-top:5px;">
       <input type="checkbox" name="fb_anuncio" id="fb_anuncio" <? if ($datos['fb_anuncio']=="1") echo "checked" ?> />
       <label for="fb_anuncio">Compartir en Facebook cuando publique un anuncio</label><br />
       
       <input type="checkbox" name="fb_conversacion" id="fb_conversacion" <? if ($datos['fb_conversacion']=="1") echo "checked" ?> />
       <label for="fb_conversacion">Compartir en Facebook cuando inicie una conversación</label>
	</div>       
       
       
    
     
     <div style="margin:0 auto 0 auto; width:90%; border-bottom:dashed 1px #333; margin-top:30px;">
       <table width="300" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td width="40"><img src="../img/social-twitter-box-blue-icon.png" width="32" height="32" /></td>
           <td width="260"><strong>Twitter</strong></td>
         </tr>
       </table>
    </div>
     <div style="margin:0 auto 0 auto; width:90%; margin-top:5px;">
     		<input type="checkbox" name="tw_anuncio" id="tw_anuncio" <? if ($datos['tw_anuncio']=="1") echo "checked" ?> />
       <label for="tw_anuncio">Compartir en Twitter cuando publique un anuncio</label><br />
       
       <input type="checkbox" name="tw_conversacion" id="tw_conversacion" <? if ($datos['tw_conversacion']=="1") echo "checked" ?> />
       <label for="tw_conversacion">Compartir en Twitter cuando inicie una conversació</label>
      </div>
     
     <div align="center" style="margin-top:20px;">
  <input type="submit" name="button" id="button" value="Guardar cambios" />
</div>
</div>


 </form>
</body>
</html>
