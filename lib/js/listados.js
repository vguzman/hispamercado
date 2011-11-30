function verAnuncio(pais,id)
{
	window.open("http://www.hispamercado.com/"+pais+"/anuncio_"+id,"anuncio_"+id,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=650,height=650");
}

function buscar(pais,cat)
{
	if (cat=="no")
		document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+document.Forma['busqueda'].value+"/mostrar_1_30";
	else
	{
		if (document.Forma['esta_categoria'].checked==false)
			document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+document.Forma['busqueda'].value+"/mostrar_1_30";
		else
			document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+document.Forma['busqueda'].value+"/categoria_"+document.Forma['esta_categoria'].value+"/mostrar_1_30";
	}
	
}
function validarBuscar(e,pais,cat) 
{	
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==13)		
	{	
		if (cat=="no")
		{
			document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+document.Forma['busqueda'].value+"/mostrar_1_30";
		}
		else
		{
			if (document.Forma['esta_categoria'].checked==false)
				document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+document.Forma['busqueda'].value+"/mostrar_1_30";
			else
				document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+document.Forma['busqueda'].value+"/categoria_"+document.Forma['esta_categoria'].value+"/mostrar_1_30";
		}
	}
}