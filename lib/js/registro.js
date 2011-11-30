function verificaUser()
{
	var user=document.FormaRegistro.user.value;
	
	if (user.length<6)
	{
		document.getElementById("mensaje_user").innerHTML=" el nombre de usuario debe ser de mínimo 6 caracteres";
		document.FormaRegistro.veriuser.value="NO";
	}
	else
	{
		reqUser=getXMLHttpRequest();
		reqUser.onreadystatechange=processUser;
		
		reqUser.open("POST","lib/servicios/utilRegistro.php",true);
		reqUser.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		reqUser.send("veri=user&user="+document.FormaRegistro.user.value);
	}
	
}

function processUser()
{
	if (reqUser.readyState==4)
	{		
		if (reqUser.status==200)
		{
			//window.alert(reqUser.responseText);
			
			if (reqUser.responseText=="true")//user ya existe
			{	
				document.getElementById("mensaje_user").innerHTML=" este nombre de usuario ya está registrado";
				document.FormaRegistro.veriuser.value="NO";
			}
			else
			{	
				//
				document.getElementById("mensaje_user").innerHTML="";
				document.FormaRegistro.veriuser.value="SI";
			}			
		} 
		else 
			window.alert("Problema");      
	}
}



function verificaEmail()
{
	if (document.FormaRegistro.email.value=="")
	{
		document.getElementById("mensaje_email").innerHTML=" debes indicar un e-mail válido";
		document.getElementById("mensaje_email2").innerHTML="";
		document.FormaRegistro.verimail.value="NO";
		document.FormaRegistro.verimail2.value="NO";
	}
	else
	{
		verificaEmailIguales();
		
		//window.alert("verificamailiguales");
		reqEmail=getXMLHttpRequest();
		reqEmail.onreadystatechange=processEmail;
		
		reqEmail.open("POST","lib/servicios/utilRegistro.php",true);
		reqEmail.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		reqEmail.send("veri=email&email="+document.FormaRegistro.email.value);
	}
}

function processEmail()
{
	if (reqEmail.readyState==4)
	{		
		if (reqEmail.status==200)
		{			
			if (reqEmail.responseText=="true")
			{				
				document.getElementById("mensaje_email").innerHTML=" este e-mail ya se encuentra registrado";
				document.FormaRegistro.verimail.value="NO";
			}
			else
			{	
				//window.alert(reqEmail.responseText);
				
				document.getElementById("mensaje_email").innerHTML="";						
				document.FormaRegistro.verimail.value="SI";
			}
		} 
		else 
			window.alert("Problema");      
	}
}



function verificaEmailIguales()
{
	if (document.FormaRegistro.email2.value=="")
	{
		document.getElementById("mensaje_email2").innerHTML=" debes indicar la confirmación del e-mail";
		document.FormaRegistro.verimail2.value="NO";
	}
	
	if ((document.FormaRegistro.email.value!="")&&(document.FormaRegistro.email2.value!=""))
	{	
		if (document.FormaRegistro.email.value==document.FormaRegistro.email2.value)
		{			
			document.getElementById("mensaje_email2").innerHTML="";
			document.FormaRegistro.verimail2.value="SI";	
			
			req2=getXMLHttpRequest();
			req2.onreadystatechange=processAnuncios;
		
			req2.open("POST","lib/servicios/utilRegistro.php",true);
			req2.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			req2.send("veri=anuncios&email="+document.FormaRegistro.email.value);
		}
		else
		{
			document.getElementById("mensaje_email2").innerHTML=" este e-mail no coincide con el original";
			document.FormaRegistro.verimail2.value="NO";
			document.getElementById("asociar_anuncios").innerHTML="";
		}
	}
}

function processAnuncios()
{
	if (req2.readyState==4)
	{		
		if (req2.status==200)
		{
			if (req2.responseText=="true")//user ya existe
			{
				document.getElementById("asociar_anuncios").innerHTML="<table width='100%' border='0' align='center' cellpadding='0' cellspacing='0' bgcolor='#CCFF99'><tr><td class='Arial13Negro'>Existen anuncios publicados con este e-mail que serán asociados automáticamente a tu cuenta</td></tr></table>";
				//document.FormaRegistro.verianuncios.value="SI";
			}
			else
			{
				document.getElementById("asociar_anuncios").innerHTML="";
				//document.FormaRegistro.verianuncios.value="NO";
			}
		} 
		else 
			window.alert("Problema");      
	}
}

function verificaPass()
{
	var pass=document.FormaRegistro.pass.value;
	
	if (pass.length<8)
	{
		document.getElementById("mensaje_pass1").innerHTML=" la contraseña debe contener mínimo 8 caracteres";
		document.FormaRegistro.veripass.value="NO";		
	}
	else
	{
		document.getElementById("mensaje_pass1").innerHTML="";
		document.getElementById("mensaje_pass").innerHTML="";
		verificaPassIguales();
	}
	
}


function verificaPassIguales()
{
	if (document.FormaRegistro.pass2.value=="")
	{
		document.getElementById("mensaje_pass").innerHTML=" debes indicar la confirmación de la contraseña";
		document.FormaRegistro.veripass.value="NO";
	}
	
	if ((document.FormaRegistro.pass.value!="")&&(document.FormaRegistro.pass2.value!=""))
	{	
		if (document.FormaRegistro.pass.value==document.FormaRegistro.pass2.value)
		{
			document.getElementById("mensaje_pass").innerHTML="";
			document.getElementById("mensaje_pass").innerHTML="";
			document.FormaRegistro.veripass.value="SI";		
		}
		else
		{
			document.getElementById("mensaje_pass").innerHTML=" esta contraseña no coincide con la original";
			document.FormaRegistro.veripass.value="NO";
			
		}
	}
}


function procesarRegistro()
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processProcesar;
		
	req.open("POST","lib/servicios/utilRegistro.php",true);
	req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	req.send("veri=procesar&user="+document.FormaRegistro.user.value+"&email="+document.FormaRegistro.email.value+"&pass="+document.FormaRegistro.pass.value+"&provincia="+document.FormaRegistro.provincia.options[document.FormaRegistro.provincia.selectedIndex].id+"&ciudad="+document.FormaRegistro.mierda.value+"&nombre="+document.FormaRegistro.nombre.value);
}

function processProcesar()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{			
			document.getElementById("tablaPrincipal").innerHTML=req.responseText;
			document.getElementById("ubicaboton").innerHTML="";
			document.getElementById("mensaje_top").innerHTML="";
		} 
		else 
			window.alert("Problema");      
	}
}


var todoBien=true;
var intervalo;

function verificaProcesos()
{		
	var control=false;
		
	if ((document.FormaRegistro.veriuser.value=="NULL")||(document.FormaRegistro.verimail.value=="NULL")||
		(document.FormaRegistro.verimail2.value=="NULL")||(document.FormaRegistro.veripass.value=="NULL"))
		control=false;
	else
		control=true;

	if (control==true)
	{
		clearInterval(intervalo);
		
		if  ((document.FormaRegistro.veriuser.value=="SI")&&(document.FormaRegistro.verimail.value=="SI")&&
			(document.FormaRegistro.verimail2.value=="SI")&&(document.FormaRegistro.veripass.value=="SI"))
		{			
			//todoBien=true;
			if (document.FormaRegistro.terminos.checked==true)
				procesarRegistro();
			else
			{	
				document.FormaRegistro.boton.value="Registrar";
				document.FormaRegistro.boton.disabled=false;
							
				window.alert("Debes marcar la casilla de aceptación de los Términos del Servicio");
			}		
		}
		else
		{	
			todoBien=false;
			
			document.FormaRegistro.boton.value="Registrar";
			document.FormaRegistro.boton.disabled=false;
						
			//window.alert("No se pudo procesar el registro, revisa los mensajes rojos");
		}
	}
	
}

function registrar()
{	
	document.getElementById("mensaje_nombre").innerHTML=""
	document.getElementById("mensaje_provincia").innerHTML="";
	document.getElementById("mensaje_mierda").innerHTML="";
	
	todoBien=true;
	
	document.FormaRegistro.boton.value="procesando...";
	document.FormaRegistro.boton.disabled=true;
	
	
	if (document.FormaRegistro.nombre.value=="")
	{
		todoBien=false;
		
		document.FormaRegistro.boton.value="Registrar";
		document.FormaRegistro.boton.disabled=false;
						
		document.getElementById("mensaje_nombre").innerHTML=" debes indicar tu nombre completo";
	}
	//else
		if (document.FormaRegistro.provincia.selectedIndex==0)
		{
			todoBien=false;
			
			document.FormaRegistro.boton.value="Registrar";
			document.FormaRegistro.boton.disabled=false;
					
			//window.alert("Debes seleccionar tu provincia");
			document.getElementById("mensaje_provincia").innerHTML=" debes seleccionar tu provincia";
		}
		//else
			if (document.FormaRegistro.mierda.value=="")
			{	
				todoBien=false;
				
				document.FormaRegistro.boton.value="Registrar";
				document.FormaRegistro.boton.disabled=false;
						
				//window.alert("Debes indicar el nombre de tu ciudad");
				document.getElementById("mensaje_mierda").innerHTML=" debes indicar el nombre de tu ciudad";
			}
			
			
	document.FormaRegistro.veriuser.value="NULL";
	document.FormaRegistro.verimail.value="NULL";
	document.FormaRegistro.verimail2.value="NULL";
	document.FormaRegistro.veripass.value="NULL";	
	
	verificaUser();
	verificaEmail();
	verificaPass();				

	if (todoBien==true)
	{
		intervalo=setInterval("verificaProcesos()",100);		
	}

}