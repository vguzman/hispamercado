<? set_time_limit(0); ?>
<? include "lib/class.php"; echo '<?xml version="1.0" encoding="UTF-8"?>' ?>
  <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  	<url><loc>http://www.hispamercado.com.ve/</loc></url>
    <url><loc>http://www.hispamercado.com.ve/publicar/</loc></url>
    <url><loc>http://www.hispamercado.com.ve/gestionar/</loc></url>
    <url><loc>http://www.hispamercado.com.ve/conversaciones/publicar.php</loc></url>
   <url><loc> http://www.hispamercado.com.ve/conversaciones/</loc></url>
   <url><loc> http://www.hispamercado.com.ve/tiendas/</loc></url>
    
    <? 
		//URLS DE ANUNCIOS
		$query=operacionSQL("SELECT id FROM Anuncio WHERE status_general='Activo'");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$anuncio=new Anuncio(mysql_result($query,$i,0));
			$enlace=$anuncio->armarEnlace();
			echo "<url><loc>http://www.hispamercado.com.ve/".$enlace."</loc></url>\n";
		}
		//URLS DE CONVERSACIONES
		$query=operacionSQL("SELECT id FROM Conversacion WHERE status=1");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$conversacion=new Conversacion(mysql_result($query,$i,0));
			$enlace=$conversacion->armarEnlace();
			echo "<url><loc>http://www.hispamercado.com.ve/".$enlace."</loc></url>\n";
		}
		//URLS DE TIENDAS
		$query=operacionSQL("SELECT id FROM Tienda WHERE status=1");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$tienda=new Tienda(mysql_result($query,$i,0));
			echo "<url><loc>http://www.hispamercado.com.ve/".$tienda->nick."/</loc></url>\n";
		}
		//URL DE CATEGORIAS
		$query=operacionSQL("SELECT id FROM Categoria");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$cat=new Categoria(mysql_result($query,$i,0));
			$enlace=$cat->armarEnlace();
			echo "<url><loc>http://www.hispamercado.com.ve/".$enlace."</loc></url>\n";
		}
		//URL DE CIUDADES
		$query=operacionSQL("SELECT DISTINCT(ciudad) FROM Anuncio WHERE status_general='Activo' ORDER BY ciudad ASC");
		for ($i=0;$i<mysql_num_rows($query);$i++)
		{
			$ciudad=mysql_result($query,$i,0);
			$ciudad=limpiar_acentos($ciudad);
			$ciudad=limpiarEnies($ciudad);
			echo "<url><loc>http://www.hispamercado.com.ve/ciudad-".$ciudad."/</loc></url>\n";
		}
	?>   
  </urlset>