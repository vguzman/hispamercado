function verAnuncio(pais,id)
{
	window.open("http://www.hispamercado.com/"+pais+"/anuncio_"+id,"anuncio_"+id,"toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=650,height=650");
}



function callFaceboxPuntos(my_href) 
{ 
	var j1 = document.getElementById("hiddenclicker"); 
	j1.href = my_href;
	j1.click();
	
	
	window.setTimeout("$(document).trigger('close.facebox')",5000);
}


function substr_count(string,substring,start,length)
{
 var c = 0;
 if(start) { string = string.substr(start); }
 if(length) { string = string.substr(0,length); }
 for (var i=0;i<string.length;i++)
 {
  if(substring == string.substr(i,substring.length))
  c++;
 }
 return c;
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
	window.alert("Secci�n en construcci�n. No necesitas estar registrado para colocar un anuncio");
}

function enConstruccion()
{
	window.alert("Secci�n en construcci�n");
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


function loginFB(url)
{
	window.open(url,"loginFB","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=400");
}

function hora()
{
	var d = new Date();
	var date=d.getDate();
	var year=d.getFullYear();
	var month=d.getMonth();
	var hour=d.getHours();
	var minutes=d.getMinutes();
	var seconds=d.getSeconds();
	
	var hora=date.toString()+year.toString()+month.toString()+hour.toString()+minutes.toString()+seconds.toString();
	
	return hora;
	//window.alert(hora);
}




function selecMenu(id)
{
	document.getElementById("menu1").className = 'miCuentaMenuNoSeleccion';
	document.getElementById("menu1_link").className = 'LinkmiCuentaMenu';
	document.getElementById("menu2").className = 'miCuentaMenuNoSeleccion';
	document.getElementById("menu2_link").className = 'LinkmiCuentaMenu';
	document.getElementById("menu3").className = 'miCuentaMenuNoSeleccion';
	document.getElementById("menu3_link").className = 'LinkmiCuentaMenu';
	document.getElementById("menu4").className = 'miCuentaMenuNoSeleccion';
	document.getElementById("menu4_link").className = 'LinkmiCuentaMenu';
	document.getElementById("menu5").className = 'miCuentaMenuNoSeleccion';
	document.getElementById("menu5_link").className = 'LinkmiCuentaMenu';
	document.getElementById("menu6").className = 'miCuentaMenuNoSeleccion';
	document.getElementById("menu6_link").className = 'LinkmiCuentaMenu';
	
	
	
	document.getElementById(id).className = 'miCuentaMenuSeleccion';
	document.getElementById(id+"_link").className = 'arial13Negro';
}


function manejoBusqueda(donde)
{
	if (donde=="adentro")
		if (document.getElementById("buscar").value=="Buscar en Hispamercado")
			document.getElementById("buscar").value="";
	
	if (donde=="afuera")
		if (document.getElementById("buscar").value=="")
			document.getElementById("buscar").value="Buscar en Hispamercado";
}

function validar(e,path) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13) buscar(path);
}


function buscar(path) 
{		
	
	if (document.getElementById("buscar").value=="Buscar en Hispamercado")
		document.getElementById("buscar").value="";
	
	categoria=document.getElementById("categorias");
	ciudad=document.getElementById("ciudades");
	buscar=document.getElementById("buscar");
		
	var url="listado.php?";
	if (categoria.options[categoria.selectedIndex].value!="todas")
		url=url+"id_cat="+categoria.options[categoria.selectedIndex].value;
	if (ciudad.options[ciudad.selectedIndex].value!="todas")
		url=url+"&ciudad="+ciudad.options[ciudad.selectedIndex].value;
	if (trim(buscar.value)!="")
		url=url+"&buscar="+trim(buscar.value);

	
	//window.alert(path);
	document.location.href=path+url;
} 


function manejoConversa(e,donde,leyenda)
{
	if (donde=="adentro")
		if (e.value==leyenda)
			e.value="";
	
	if (donde=="afuera")
		if (e.value=="")
			e.value=leyenda;
}
