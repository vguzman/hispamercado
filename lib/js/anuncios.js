var fotoActual=1;

function verFoto(foto,anuncio)
{
	if (foto=="adelante")
	{
		foto=fotoActual+1;
		
		document.getElementById("fotofoto1").style.display="none";
		document.getElementById("fotofoto2").style.display="none";
		document.getElementById("fotofoto3").style.display="none";
		document.getElementById("fotofoto4").style.display="none";
		document.getElementById("fotofoto5").style.display="none";
		document.getElementById("fotofoto6").style.display="none";
		
		document.getElementById("fotofoto"+foto).style.display="block";
		
		
		document.getElementById("foto"+foto).innerHTML="<b>"+foto+"</b>";
		document.getElementById("foto"+fotoActual).innerHTML="<a href='javascript:verFoto("+fotoActual+","+anuncio+")' class='LinkFuncionalidad13'>"+fotoActual+"</a>";
		fotoActual=foto
	}
	else
		if (foto=="atras")
		{
			foto=fotoActual-1;
		
			
			document.getElementById("fotofoto1").style.display="none";
			document.getElementById("fotofoto2").style.display="none";
			document.getElementById("fotofoto3").style.display="none";
			document.getElementById("fotofoto4").style.display="none";
			document.getElementById("fotofoto5").style.display="none";
			document.getElementById("fotofoto6").style.display="none";
			
			document.getElementById("fotofoto"+foto).style.display="block";
			
			
			document.getElementById("foto"+foto).innerHTML="<b>"+foto+"</b>";
			document.getElementById("foto"+fotoActual).innerHTML="<a href='javascript:verFoto("+fotoActual+","+anuncio+")' class='LinkFuncionalidad13'>"+fotoActual+"</a>";
			fotoActual=foto
		}
		else
		{
			
			
			document.getElementById("fotofoto1").style.display="none";
			document.getElementById("fotofoto2").style.display="none";
			document.getElementById("fotofoto3").style.display="none";
			document.getElementById("fotofoto4").style.display="none";
			document.getElementById("fotofoto5").style.display="none";
			document.getElementById("fotofoto6").style.display="none";
			
			document.getElementById("fotofoto"+foto).style.display="block";
			
			
			document.getElementById("foto"+foto).innerHTML="<b>"+foto+"</b>";
			document.getElementById("foto"+fotoActual).innerHTML="<a href='javascript:verFoto("+fotoActual+","+anuncio+")' class='LinkFuncionalidad13'>"+fotoActual+"</a>";
			fotoActual=foto;
		}
	
	var comilla=String.fromCharCode(34);
	
	if (fotoActual>1)
		document.getElementById("atras").innerHTML="<a href='javascript:verFoto("+comilla+"atras"+comilla+","+anuncio+")' class='LinkFuncionalidad13'><<</a>";
	else
		if (document.Forma.num_fotos.value>1)
			document.getElementById("atras").innerHTML="<<<";
	
	if (fotoActual<document.getElementById("num_fotos").value)
		document.getElementById("adelante").innerHTML="<a href='javascript:verFoto("+comilla+"adelante"+comilla+","+anuncio+")' class='LinkFuncionalidad13'>>></a>";
	else
		if (document.Forma.num_fotos.value>1)
			document.getElementById("adelante").innerHTML=">>";
}

function accionAnuncio(tipo) 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange;
	req.open("GET","../lib/servicios/acciones_anuncio.php?tipo=requerir&que="+tipo, true);
	req.send(null);	
} 
 
function processStateChange()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("ejecuta_accion").innerHTML=req.responseText;						
		} 
		else 
			window.alert("Problema");      
	}
}

function ejecutaAccionAnuncio(tipo,id_anuncio) 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange2;
	req.open("POST","lib/servicios/acciones_anuncio.php?tipo=ejecutar&que="+tipo, true);
	if (tipo=="amigo")
	{
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		req.send("tunombre="+document.Forma.tunombre.value+"&para="+document.Forma.para.value+"&id_anuncio="+id_anuncio+"&captcha="+document.Forma.captcha.value);
		document.Forma.boton_enviar.disabled=true;
		document.Forma.boton_enviar.value="Enviando";
	}
	if (tipo=="anunciante")
	{
		req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		req.send("tunombre="+document.Forma.tunombre.value+"&tuemail="+document.Forma.tuemail.value+"&id_anuncio="+id_anuncio+"&captcha="+document.Forma.captcha.value+"&mensaje="+document.Forma.mensaje.value);
		document.Forma.boton_enviar.disabled=true;
		document.Forma.boton_enviar.value="Enviando";
	}
		
}

function processStateChange2()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			if (req.responseText=="error captcha")
			{
				window.alert("Código de verificación errado");
				
				document.Forma.boton_enviar.disabled=false;
				document.Forma.boton_enviar.value="Enviar";
			}
			else
				if ((req.responseText=="Debe introducir su nombre")||(req.responseText=="Debe introducir su e-mail")
					||(req.responseText=="Debe introducir un mensaje"))
				{	
					window.alert(req.responseText);
					
					document.Forma.boton_enviar.disabled=false;
					document.Forma.boton_enviar.value="Enviar";
				}
				else
					document.getElementById("ejecuta_accion").innerHTML=req.responseText;						
		} 
		else 
		{
			window.alert("Problema");      
		
			document.Forma.boton_enviar.disabled=false;
			document.Forma.boton_enviar.value="Enviar";
		}
	}
} 

function dejarComentario(id)
{
	posicion=posicionElemento("recomendar");
	INNERDIV.newInnerDiv('dejarComentario',500,posicion['top']-10,400,250,'dejarComentario.php?id_anuncio='+id+"&adsad=",'Realizar comentario');
}

function recomendarAmigo(id)
{
	fecha = now();
	dialog(400,190,"recomendarAmigo.php?id_anuncio="+id+"&hora="+fecha);
}

function denunciar(id)
{
	fecha = now();
	dialog(400,450,"denunciar.php?id_anuncio="+id+"&hora="+fecha);
}

function contactarAnunciante(id)
{
	fecha = now();
	dialog(400,450,"contactarAnunciante.php?id_anuncio="+id+"&hora="+fecha);
	
}

function verFotoGrande(anuncio,foto,w,h)
{
	fecha = now();
	dialog(w+80,h+80,"verFoto.php?anuncio="+anuncio+"&foto="+foto+"&hora="+fecha);
	
}


function verVideo(id)
{
	fecha = now();
	dialog(600,500,"verVideo.php?id_video="+id+"&hora="+fecha);
}

function validarContacto()
{
	//EXPRESIONES REGULARES
	var patron_email=/^[^@ ]+@[^@ ]+.[^@ .]+$/;
	
	document.Forma_Contacto.button.value="Enviando....";
	document.Forma_Contacto.button.disabled=true;
	
	$good=false;
	
	if (trim(document.Forma_Contacto.tu_nombre.value)=="")
		window.alert("Debes indicar tu nombre");
	else
		if (patron_email.test(trim(document.Forma_Contacto.tu_email.value))=="")
			window.alert("Debes indicar un email valido");
		else
			if (trim(document.Forma_Contacto.comentario.value)=="")
				window.alert("Debes ingresar el mensaje que va a recibir el anunciante");
			else
			{
				document.Forma_Contacto.submit();
				$good=true;
			}
	
	if ($good==false)
	{
		document.Forma_Contacto.button.disabled=false;
		document.Forma_Contacto.button.value="Enviar consulta";
	}
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
		//window.alert(url);
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
				//window.alert(req.responseText);	
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
