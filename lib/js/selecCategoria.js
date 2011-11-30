var which;
var nombre_selec;

	
function subcategorias(selec) 
{
	nombre_selec=selec.name;
	
	
	if (nombre_selec=="principal")
		document.getElementById("sub1").innerHTML="<img src='../img/bigrotation2.gif' width='32' height='32'>";
	if (nombre_selec=="sub1")
		document.getElementById("sub2").innerHTML="<img src='../img/bigrotation2.gif' width='32' height='32'>";
	if (nombre_selec=="sub2")
		document.getElementById("sub3").innerHTML="<img src='../img/bigrotation2.gif' width='32' height='32'>";
	
	
	indice=document.Forma[nombre_selec].selectedIndex;
	id_padre=document.Forma[nombre_selec].options[indice].value;
	
	
	//window.alert(nombre_selec);	
		
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange;
	req.open("GET","../lib/servicios/subcategorias.php?id_padre="+id_padre+"&selec="+nombre_selec, true);
	req.send(null);	
}

function processStateChange()
{
	if (req.readyState==4)
	{
		if (req.status==200)
		{						
			if (nombre_selec=="principal")
			{	
				document.getElementById("sub1").innerHTML="";
				document.getElementById("sig_sub1").innerHTML="";
				document.getElementById("sub2").innerHTML="";
				document.getElementById("sig_sub2").innerHTML="";
				document.getElementById("sub3").innerHTML="";
				document.getElementById("sig_sub3").innerHTML="";
				document.getElementById("final").innerHTML="";				
				document.getElementById("sub1").innerHTML=req.responseText;
				document.getElementById("sig_sub1").innerHTML="<b>&nbsp;&raquo;&nbsp;</b>";		
			}
			
			if (nombre_selec=="sub1")
			{
				document.getElementById("sub2").innerHTML="";
				document.getElementById("sig_sub2").innerHTML="";
				document.getElementById("sub3").innerHTML="";
				document.getElementById("sig_sub3").innerHTML="";
				document.getElementById("final").innerHTML="";
				
				document.getElementById("sub2").innerHTML=req.responseText;
				document.getElementById("sig_sub2").innerHTML="<b>&nbsp;&raquo;&nbsp;</b>";
			}
			
			if (nombre_selec=="sub2")
			{
				document.Forma.control_sub2.value="SI";			
				
				document.getElementById("sub3").innerHTML="";
				document.getElementById("sig_sub3").innerHTML="";
				document.getElementById("final").innerHTML="";
				
				document.getElementById("sub3").innerHTML=req.responseText;
				document.getElementById("sig_sub3").innerHTML="<b>&nbsp;&raquo;&nbsp;</b>";
			}			
		} 
		else 
			alert("Problem: " + req.statusText);      
	}
}

  
function activar(selec)
{
	document.getElementById("final").innerHTML="<input name='agregar' type='button' id='agregar' value='Finalizar' onClick='procesar()'>";
}


function cerrarVentana()
{
	if (window.opener.fox==1)
		window.close();
	else
		setTimeout("cerrarVentana()",100);
}


function procesar()
{
	document.getElementById("agregar").disabled=true;
	
	indice=document.Forma['principal'].selectedIndex;
	var id=document.Forma['principal'].options[indice].value;
	
	indice=document.Forma['sub1'].selectedIndex;
	id=id+";"+document.Forma['sub1'].options[indice].value;
	
	indice=document.Forma['acciones'].selectedIndex;
	tipo=document.Forma['acciones'][indice].text;
		
	if (document.Forma['control_sub2'].value=="SI")
	{
		indice=document.Forma['sub2'].selectedIndex;
		id=id+";"+document.Forma['sub2'].options[indice].value;
	}
	
	document.Forma['id'].value=id;
	document.Forma['tipo'].value=tipo;
			
	armarCategoria(document.Forma['id'].value,document.Forma['tipo'].value);		
	//window.alert(window.opener.document.Forma['id'].value);
	//cerrarVentana();
}
