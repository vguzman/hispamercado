<?
	header ("Cache-Control: no-cache, must-revalidate");
	header('Content-Type: text/html; charset=iso-8859-1');
	
	include "../util.php";
	
	session_start();
	
	$id=$_GET['id'];	
	$tipo=$_GET['tipo'];
	
	if (isset($_SESSION['user']))
	{
		if ($tipo=="extender")
		{
			$hoy=getdate();
			$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];	
			
			operacionSQL("UPDATE anuncio SET fecha='".$fecha."' WHERE id=".$id);		
		}
		
		if ($tipo=="debaja")
		{		
			$aux="UPDATE anuncio SET status='Inactivo' WHERE id=".$id;
			operacionSQL($aux);	
			
		}
		if ($tipo=="dealta")
		{		
			$aux="UPDATE anuncio SET status='Activo' WHERE id=".$id;
			operacionSQL($aux);			
		}
	}
	
?>