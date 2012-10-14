var nivele;
function cargarCategoria(id_padre,nivel)
{
	//window.alert("div_"+nivel);
	document.getElementById("div_"+nivel).style.display='table';
	
	nivele=nivel;
	
	req=getXMLHttpRequest();
	req.onreadystatechange=process_cargarCategoria;
	req.open("GET","ajax_subcategorias.php?id_padre="+id_padre+"&nivel="+nivel,true);
	req.send(null);
}

function process_cargarCategoria()
{
	if (req.readyState==4)
	{
		if (req.status==200)
		{			
			//window.alert(nivele);
			//window.alert(req.responseText);
			if (req.responseText=="OK")
			{
				document.getElementById('categoriaux').value="SI";
				document.getElementById("div_"+nivele).innerHTML='<br><img src="../img/ok.png" width="68" height="65" />';
			}
			else
			{
				document.getElementById('categoriaux').value="NO";
				document.getElementById("div_"+nivele).innerHTML=req.responseText;
			}
		} 
		else
			window.alert("Ha ocurrido un problema");      
	}
}

function manejoSeleCat(e)
{
	document.getElementById('categoria').value=e.value;
	//window.alert(document.getElementById('categoria').value);
	
	
	cadena=e.id;
	aux=cadena.split("_");
	
	var nivel_actual=parseInt(aux[1]);
	var nivel_siguiente=nivel_actual+1;
	//window.alert(parseInt(aux[1])+1);
	
	for (i=nivel_siguiente;i<10;i++)
	{
		document.getElementById("div_"+i).style.display='none';
		document.getElementById("div_"+i).innerHTML='<br /><br /><br /><img src="../img/bigrotation2.gif" width="32" height="32" />';
		
	}
	
	
	cargarCategoria(e.value,nivel_siguiente);
}



function colocar()
{
	
	//EXPRESIONES REGULARES
	var patron_email=/^[^@ ]+@[^@ ]+.[^@ .]+$/;
	var patron_no_vacio=/^\S[\w\W]*$/;
	
	
	if (document.Forma.categoriaux.value!="SI")
		window.alert("Debes seleccionar una categoria");
	else
		if (patron_no_vacio.test(document.Forma.titulo.value)==false)
			window.alert("Debe introducir el titulo de la conversacion");
		else
			document.Forma.submit();						
					

}


//-------------------------------------------------------SECCION FB---------------------------------------------------------------------
window.fbAsyncInit = function() {
    FB.init({
      appId      : '119426148153054', // App ID
      //channelUrl : '//WWW.YOUR_DOMAIN.COM/channel.html', // Channel File
      status     : true, // check login status
      cookie     : true, // enable cookies to allow the server to access the session
      xfbml      : true  // parse XFBML
    });

    // Additional initialization code here
	FB.Event.subscribe('comment.create',
    function(response) {
		
		var url="ajax_nuevoComentarioFB.php?url="+response.href;
		req=getXMLHttpRequest();
		req.onreadystatechange=nuevoComentario;
		req.open("GET",url,true);
		req.send(null);
		
    });
	
	FB.Event.subscribe('comment.remove',
    function(response) {
		
        var url="ajax_borrarComentarioFB.php?url="+response.href;
		req=getXMLHttpRequest();
		req.onreadystatechange=nuevoComentario;
		req.open("GET",url,true);
		req.send(null);
		
    });
	
	function nuevoComentario()
	{
		if (req.readyState==4)
		{
			if (req.status==200)
			{
				window.alert(req.responseText);
			} 
			else
				window.alert("Ha ocurrido un problema");      
		}
	}
	
  };
  
 (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/es_LA/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));





