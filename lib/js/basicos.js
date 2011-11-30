function verAnuncio(pais,id)
{
	window.open("http://www.hispamercado.com/"+pais+"/anuncio_"+id,"anuncio_"+id,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=650,height=650");
}

function buscar(pais,cat)
{	
	var criterio=escape(document.Forma['busqueda'].value);
	
	if (cat=="no")
		document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+criterio+"/mostrar_1_30";
	else
	{
		if (document.Forma['esta_categoria'].checked==false)
			document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+criterio+"/mostrar_1_30";
		else
			document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+criterio+"/categoria_"+document.Forma['esta_categoria'].value+"/mostrar_1_30";
	}
	
}
function validarBuscar(e,pais,cat) 
{	
	var criterio=escape(document.Forma['busqueda'].value);
	
	tecla = (document.all) ? e.keyCode : e.which;
	if (tecla==13)		
	{	
		if (cat=="no")
		{
			document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+criterio+"/mostrar_1_30";
		}
		else
		{
			if (document.Forma['esta_categoria'].checked==false)
				document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+criterio+"/mostrar_1_30";
			else
				document.location.href="http://www.hispamercado.com/"+pais+"/buscar_"+criterio+"/categoria_"+document.Forma['esta_categoria'].value+"/mostrar_1_30";
		}
	}
}



function posicionElemento(id_elemento)
{
	element=document.getElementById(id_elemento);
	
	var y = 0;
 	var x = 0;
	while (element.offsetParent) 
	{
    	x += element.offsetLeft;
    	y += element.offsetTop;
    	element = element.offsetParent;
  	}
	
	return {top:y,left:x};
}





function validaDecimal(numero)
{
	if (numero=="")
		return 0;
	patron = /^([0-9])*\.?[0-9]?[0-9]?$/ ;
	patron2 = /^([0-9])*\,?[0-9]?[0-9]?$/ ;
	
	if ((patron.test(numero)==false)&&(patron2.test(numero)==false))
		return 0;
	else
		return 1;		
}



function validaEntero(valor)
{
	var er1_EntradaS = /^[0-9]+$/
    if(!er1_EntradaS.test(valor)) 
		return 0;
	else
		return 1;

}

function clik_entrar()
{
	window.alert("Sección en construcción. No necesitas estar registrado para colocar un anuncio");
}

function enConstruccion()
{
	window.alert("Sección en construcción");
}

function now()
{
	fecha = new Date();
	hora=""+fecha.getFullYear()+"-"+fecha.getMonth()+"-"+fecha.getDate()+" "+fecha.getHours()+":"+fecha.getMinutes()+":"+fecha.getSeconds();
	return hora;
}


function ltrim(s) {
	return s.replace(/^\s+/, "");
}

function rtrim(s) {
	return s.replace(/\s+$/, "");
}

function trim(s) {
	return rtrim(ltrim(s));
}