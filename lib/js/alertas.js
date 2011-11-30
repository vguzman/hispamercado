// JavaScript Document
var fox=0;
function agregar_categoria(pais)
{	
	fox=0;
	if ((document.Forma2['id_1'].value=="NULL")||(document.Forma2['id_2'].value=="NULL")||(document.Forma2['id_3'].value=="NULL")||(document.Forma2['id_4'].value=="NULL")||(document.Forma2['id_5'].value=="NULL")||(document.Forma2['id_6'].value=="NULL"))
		ventana=window.open("http://www.hispamercado.com/agregarCategoriaAlerta.php?pais="+pais,"publicar_agrega_categoria","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=750,height=160");
	else
		alert("Has seleccionado el máximo de categorías permitidas");
}


function processArmarCategoria()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("categoriasSeleccionadas").innerHTML=req.responseText;
			fox=1;				
		} 
		else 
			alert("Problema");      
	}
}

function armarCategoria(id_1,tipo_1,id_2,tipo_2,id_3,tipo_3,id_4,tipo_4,id_5,tipo_5,id_6,tipo_6) 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processArmarCategoria;
	req.open("GET","../lib/servicios/armarCategoriaAlerta.php?id_1="+id_1+"&tipo_1="+tipo_1+"&id_2="+id_2+"&tipo_2="+tipo_2+"&id_3="+id_3+"&tipo_3="+tipo_3+"&id_4="+id_4+"&tipo_4="+tipo_4+"&id_5="+id_5+"&tipo_5="+tipo_5+"&id_6="+id_6+"&tipo_6="+tipo_6, true);
	req.send(null);
	
}

function eliminar_categoria(num)
{
	var id="id_"+num;
	var tipo="tipo_"+num;
	
	document.Forma2[id].value="NULL";
	document.Forma2[tipo].value="NULL";
	
	
	if ((document.Forma2['id_1'].value=="NULL")&&(document.Forma2['id_2'].value=="NULL")
		&&(document.Forma2['id_3'].value=="NULL")&&(document.Forma2['id_4'].value=="NULL"))
		document.getElementById("categoriasSeleccionadas").innerHTML="no has agregado ninguna categor&iacute;a";
	else
		armarCategoria(document.Forma2['id_1'].value,document.Forma2['tipo_1'].value,
						document.Forma2['id_2'].value,document.Forma2['tipo_2'].value,
						document.Forma2['id_3'].value,document.Forma2['tipo_3'].value,
						document.Forma2['id_4'].value,document.Forma2['tipo_4'].value,
						document.Forma2['id_5'].value,document.Forma2['tipo_5'].value,
						document.Forma2['id_6'].value,document.Forma2['tipo_6'].value);		
}


function crearAlerta() 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=processcrearAlerta;
	
	req.open("POST","lib/servicios/crearAlerta.php",true);
	req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	var provincia=document.Forma2['provincia'];
	var aux="id_1="+document.Forma2['id_1'].value+"&tipo_1="+document.Forma2['tipo_1'].value+"&id_2="+document.Forma2['id_2'].value+
			"&tipo_2="+document.Forma2['tipo_2'].value+"&id_3="+document.Forma2['id_3'].value+"&tipo_3="+document.Forma2['tipo_3'].value+"&id_4="+document.Forma2['id_4'].value+"&tipo_4="+document.Forma2['tipo_4'].value+"&id_5="+document.Forma2['id_5'].value+"&tipo_5="+document.Forma2['tipo_5'].value+"&id_6="+document.Forma2['id_6'].value+"&tipo_6="+document.Forma2['tipo_6'].value
			+"&email="+document.Forma2['email'].value+"&terminos="+document.Forma2['terminos'].value+"&provincia="+provincia.options[provincia.selectedIndex].id;
	
	//window.alert(aux);
	req.send(aux);	
}


function processcrearAlerta()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("contenido_alertas").innerHTML=req.responseText;
			//ventana.close();				
		} 
		else 
			alert("Problema");      
	}
}