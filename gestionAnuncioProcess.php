<?	
	include "lib/class.php";	
	
    
	$query=operacionSQL("SELECT id FROM Anuncio WHERE status_general='Activo' AND anunciante_email='".trim($_POST['email'])."'");
	
	
	if (mysql_num_rows($query)>0)
	{
	$articulos="";
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
			$anuncio=new Anuncio(mysql_result($query,$i,0));
			
			$articulos.="<p><font face='Arial' size='2'><strong>".$anuncio->titulo."</strong><br /> Gestionar:  <a href='http://www.hispamercado.com.ve/publicar/index.php?edit=".$anuncio->codigo_verificacion."'>http://www.hispamercado.com.ve/publicar/index.php?edit=".$anuncio->codigo_verificacion."</a> </font></p>";		
	}
		
		
		$contenido="<div align='center'>
					<table border='0' width='800'>
						<tr>
					  <td align='left'><img src='http://www.hispamercado.com.ve/img/logo_original.jpg'  width='360' height='58'></td>
				  </tr>				  
						<tr>
						  <td align='left'>
						  
						  <p></p>
						  <p><font face='Arial' size='2'>Hola <b>".$anuncio->anunciante_nombre."</b>,</font></p>
						  
						  <p><font face='Arial' size='2'>Estos son tus anuncios se encuentran activos en hispamercado:</font></p>
							
                            
                            <p>".$articulos."</p>
							
                            
                            <p><font face='Arial' size='2'>Gracias por usar Hispamercado!</font></p>
                           </td>
						</tr>
					</table>
				</div>";
				
				
		
		
		email("Hispamercado","no-responder@hispamercado.com.ve","",trim($_POST['email']),"Tus anuncios en Hispamercado",$contenido);
		
		
		
		echo "<SCRIPT LANGUAGE='JavaScript'>	
			window.alert('La información para gestionar tus anuncios fue enviada a tu email');				
			document.location.href='../';
		</SCRIPT>";
	}
	else
		echo "<SCRIPT LANGUAGE='JavaScript'>	
			window.alert('No existen anuncios activos con publicados con ese e-mail');				
			document.location.href='index.php';
		</SCRIPT>";
	
?>


<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>