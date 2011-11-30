<?
	include "../../lib/class.php";
	error_reporting(0);
	
	$aux=stripslashes($_POST['query']);
	$query=operacionSQL($aux);
	
	if ($_POST['accion']=="reprobar_revision")
	{
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			if ($_POST['anuncio_'.mysql_result($query,$i,0)]=="SI")
				operacionSQL("UPDATE Anuncio SET status_revision='Revisado', status_general='Inactivo' WHERE id=".mysql_result($query,$i,0));
		}
		
		
		echo "<script type='text/javascript'>
				window.history.go(-1);
				//document.location.href='index.php?filtro=acreno';
				</script>";
		
		
	}
	
	if ($_POST['accion']=="marcar_verificado")
	{
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			if ($_POST['anuncio_'.mysql_result($query,$i,0)]=="SI")
			{
				$id_anuncio=mysql_result($query,$i,0);
				$anuncio=new Anuncio($id_anuncio);
				fopen("http://www.hispamercado.com/publicar/activaAnuncio.php?id=".$anuncio->codigo_verificacion,"r");
			}
		}		
		echo "<script type='text/javascript'>
				window.history.go(-1);
				//document.location.href='index.php?filtro=nocon';
				</script>";
	}
	
	
	if ($_POST['accion']=="eliminar")
	{
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			if ($_POST['anuncio_'.mysql_result($query,$i,0)]=="SI")
				operacionSQL("DELETE FROM Anuncio WHERE id=".mysql_result($query,$i,0));
		}		
		
		echo "<script type='text/javascript'>
				window.history.go(-1);
				//document.location.href='index.php?filtro=nocon';
				</script>";
	}
	
	
	
?>