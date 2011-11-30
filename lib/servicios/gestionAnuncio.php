<?
	header ("Cache-Control: no-cache, must-revalidate");
	header('Content-Type: text/html; charset=iso-8859-1');
	
	include "../util.php";
	
	session_start();
	
	$id=$_SESSION['id_anuncio'];
	$verificacion=$_SESSION['verificacion'];
	
	$tipo=$_GET['tipo'];
	
	if ($tipo=="extender")
	{
		$hoy=getdate();
		$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];	
		
		operacionSQL("UPDATE anuncio SET fecha='".$fecha."' WHERE id=".$id." AND verifica='".$verificacion."'");
		
		echo "<table width='310' border='0' align='center' bgcolor='#FFCC00'>
				<tr>
				<td class='Arial11Negro' align='center'><b>La duración de tu anuncio ha sido extendida</b></td>
			  </tr>
			</table>";
			
		
		echo "*";
			
		//Horas y dias faltantes para que se acabe
		$query2=operacionSQL("SELECT HOUR(TIMEDIFF(CURRENT_TIMESTAMP(),fecha)),status FROM anuncio WHERE id=".$id);
		$horas=1440-mysql_result($query2,0,0);
		$dias=floor($horas/24);
		$horas=$horas%24;
		$status=mysql_result($query2,0,1);	
			
		echo "Este anuncio finalizar&aacute; en <strong>".$dias." d&iacute;as y ".$horas." horas</strong> y su estado es <strong>".$status."</strong>";
	

	
	}
	if ($tipo=="debaja")
	{		
		$aux="UPDATE anuncio SET status='Inactivo' WHERE id=".$id." AND verifica='".$verificacion."'";
		operacionSQL($aux);
		
		$hoy=getdate();
		$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];	
		operacionSQL("UPDATE anuncio SET fecha='".$fecha."' WHERE id=".$id." AND verifica='".$verificacion."'");
		
		
		echo "<table width='400' border='0' align='center' bgcolor='#FFCC00'>
				<tr>
				<td class='Arial11Negro' align='center'><b>Tu anuncio ha sido dado de baja, tienes 30 días para reactivarlo</b></td>
			  </tr>
			</table>";
		echo "*";
		
		//Horas y dias faltantes para que se acabe
		$query2=operacionSQL("SELECT HOUR(TIMEDIFF(CURRENT_TIMESTAMP(),fecha)),status FROM anuncio WHERE id=".$id);
		$horas=720-mysql_result($query2,0,0);
		$dias=floor($horas/24);
		$horas=$horas%24;
		$status=mysql_result($query2,0,1);	
			
		echo "Este anuncio se encuentra <b>".$status."</b> y será borrado definitivamente en <b>".$dias."</b> días y <b>".$horas."</b> horas";
	

		
		
		
	}
	if ($tipo=="dealta")
	{		
		$aux="UPDATE anuncio SET status='Activo' WHERE id=".$id." AND verifica='".$verificacion."'";
		operacionSQL($aux);
		
		$hoy=getdate();
		$fecha=$hoy['year']."-".$hoy['mon']."-".$hoy['mday']." ".$hoy['hours'].":".$hoy['minutes'].":".$hoy['seconds'];	
		operacionSQL("UPDATE anuncio SET fecha='".$fecha."' WHERE id=".$id." AND verifica='".$verificacion."'");
		
		echo "<table width='300' border='0' align='center' bgcolor='#FFCC00'>
				<tr>
				<td class='Arial11Negro' align='center'><b>Tu anuncio ha sido reactivado</b></td>
			  </tr>
			</table>";			
		
		echo "*";
			
		//Horas y dias faltantes para que se acabe
		$query2=operacionSQL("SELECT HOUR(TIMEDIFF(CURRENT_TIMESTAMP(),fecha)),status FROM anuncio WHERE id=".$id);
		$horas=1440-mysql_result($query2,0,0);
		$dias=floor($horas/24);
		$horas=$horas%24;
		$status=mysql_result($query2,0,1);	
			
		echo "Este anuncio finalizar&aacute; en <strong>".$dias." d&iacute;as y ".$horas." horas</strong> y su estado es <strong>".$status."</strong>";
	

	}
	
?>