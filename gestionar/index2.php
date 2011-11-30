<?	
	session_start();
	
	include "../lib/class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);
    
	$query=operacionSQL("SELECT id FROM Anuncio WHERE status_general='Activo' AND anunciante_email='".trim($_POST['email'])."'");
	
	
	if (mysql_num_rows($query)>0)
	{
	$articulos="";
	for ($i=0;$i<mysql_num_rows($query);$i++)
	{
			$anuncio=new Anuncio(mysql_result($query,$i,0));
			
			$articulos.="<p><font face='Arial' size='2'>".$anuncio->titulo."<br /> Gestionar:  <a href='http://www.hispamercado.com.ve/gestionar/redirect.php?codigo=".$anuncio->codigo_verificacion."'>http://www.hispamercado.com.ve/gestionar/redirect.php?codigo=".$anuncio->codigo_verificacion."</a> </font></p>";		
		}
		
		
		$contenido="<div align='center'>
					<table border='0' width='800' id='table1'>
						<tr>
						  <td align='left'><font face='Arial' size='2'>Hola <b>".$anuncio->anunciante_nombre."</b>,</font><p>
							<font face='Arial' size='2'>Muchas gracias por utilizar
							<a href='http://".$_SERVER['HTTP_HOST']."'>HispaMercado ".$pais->nombre."</a>.</font>
							<p>
							<font face='Arial' size='2'>Estos son tus anuncios se encuentran activos en hispamercado:</font></p>
							".$articulos."
							<p><font face='Arial' size='2'>Hasta luego...</font></p></td>
						</tr>
					</table>
				</div>";
		
		
		
		
		
		
		email("Hispamercado ".$pais->nombre,"info@hispamercado.com.ve",$anuncio->anunciante_nombre,$anuncio->anunciante_email,"Tus anuncios en hispamercado",$contenido);
		
		
		
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