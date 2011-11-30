<?
	session_start();
	
	include "../class.php";	
	
	$id_pais=verificaPais();
	$pais=new Pais($id_pais);
	
	cookieSesion(session_id(),$_SERVER['HTTP_HOST']);
	
	if ($_GET['que']=="info_cliente")
	{
		
		$usuario=new Usuario($_GET['usuario']);
		$provincia=new Provincia($usuario->provincia);
		
		$tienda=new Tienda($_GET['tienda']);
		$politicas=$tienda->politicas();
		
		for ($i=0;$i<count($politicas);$i++)
			$pol.="- ".$politicas[$i]."<br>";
			
		
		
		echo utf8_encode("<table width='97%' height='74' border='1' align='center' cellpadding='3' cellspacing='0' bordercolor='#EBEBEB' bgcolor='#FFFFCC' style='border-collapse:collapse '>
        <tr>
          <td width='247' height='72' valign='top' class='arial11Negro'><strong>".$usuario->nombre."</strong><br>
           <b>Dirección:</b> ".$usuario->direccion.", ".$usuario->ciudad.", ".$provincia->nombre."<br>
		   <b>Teléfonos:</b> ".$usuario->telefonos."<br><b>E-mail:</b> <a href='mailto:".$usuario->email."'>".$usuario->email."</a>
		   <br><b>Web: </b><a href='http://".$usuario->web."'>".$usuario->web."</a></td>
          <td width='267' valign='top' class='arial11Negro'>".$pol."</td>
        </tr>
    </table>");
		
		
	
	}
	
	if ($_GET['que']=="sugerencia")
	{		
		$headers = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html; charset=iso-8859-1\n";
		$headers .= "From: HispaMercado ".$pais->nombre." <info@hispamercado.com>\n";
		$headers .= "Reply-To: info@hispamercado.com";
		
		$contenido="<b>Nombre:</b> ".$_POST['nombre']."<br>";
		$contenido.="<b>E-mail:</b> ".$_POST['mail']."<br>";
		$contenido.="<b>Sugerencia:</b> ".$_POST['contenido']."<br>";
		
		email("Hispamercado","info@hispamercado.com","VITOR","vmgafrm@gmail.com","Sugerencia recibida",$contenido,$headers);
		
		echo "<table width='391' border='0' align='center' cellpadding='2' cellspacing='0' bgcolor='#E8E800' style='border-collapse: collapse'>
			  <tr>
				<td width='387' align='center' class='Arial13Negro' align='center'>Tu sugerencia fue enviada exitosamente. &iexcl;Muchas gracias!</td>
			  </tr>
			</table>";
	}
	
	if ($_GET['que']=="eliminar_logo")
	{
		$aux="UPDATE detalles_tienda SET logo='NO' WHERE usuario='".$_SESSION['user']."'";
		operacionSQL($aux);
		unlink("../../img/img_bank/logos/".$_SESSION['user']);		
	}
	if ($_GET['que']=="politicas_tienda")
	{
		$aux="<table width='500' border='0' cellpadding='0' cellspacing='0'>";
	
		$query=operacionSQL("SELECT * FROM politicas_tienda WHERE usuario='".$_SESSION['user']."'");
		for ($i=0;$i<mysql_num_rows($query);$i++)
			$aux.="<tr>
            <td class='arial11Negro'>- ".mysql_result($query,$i,2)." (<a href='javascript:eliminarPolitica(".mysql_result($query,$i,0).")'><i>eliminar</i></a>)</td>
          </tr>";
		
		echo $aux.="<table width='500' border='0' cellpadding='0' cellspacing='0'>";
	}
	if ($_GET['que']=="agregar_politica")
	{
		$aux="INSERT INTO politicas_tienda VALUES (NULL,'".$_SESSION['user']."','".$_POST['politica']."')";
		operacionSQL(utf8_decode($aux));
	}
	if ($_GET['que']=="eliminar_politica")
	{
		$aux="DELETE FROM politicas_tienda WHERE id=".$_POST['id']." AND usuario='".$_SESSION['user']."'";
		operacionSQL($aux);
	}
	
?>