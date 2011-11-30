// JavaScript Document

var id_actual;

function aFavoritos(id,root)
{
	id_actual=id;
	var comilla='"';
	
	document.getElementById("favorito_"+id_actual).innerHTML="<a href='javascript:quitaFavoritos("+id+","+comilla+root+comilla+")'><img src='"+root+"img/favorito1.gif' title='Quitar de favoritos' width='26' height='25' border='0'></a>";
	
	
	var post="id_anuncio="+id+"&tipo=meter";
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChangeFavoritos;
	req.open("GET",root+"lib/servicios/favoritos.php?"+post,true);
	req.send(null);
	
}

function quitaFavoritos(id,root)
{
	id_actual=id;
	var comilla='"';
	
	document.getElementById("favorito_"+id_actual).innerHTML="<a href='javascript:aFavoritos("+id+","+comilla+root+comilla+")'><img src='"+root+"img/favorito0.gif' title='Quitar de favoritos' width='26' height='25' border='0'></a>";
		
	var post="id_anuncio="+id+"&tipo=sacar&dedonde=lista";
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChangeFavoritos;
	req.open("GET",root+"lib/servicios/favoritos.php?"+post,true);
	req.send(null);
	
}


function processStateChangeFavoritos()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{			
			//document.getElementById("favorito_"+id_actual).innerHTML=req.responseText;			
			//window.opener.document.getElementById("favorito_"+id_actual).innerHTML=req.responseText;
		} 
		else 
			window.alert("Ha ocurrido un problema");      
	}
}