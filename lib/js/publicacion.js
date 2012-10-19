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
	req.open("GET","../lib/servicios/subcategorias.php?id_padre="+id_padre+"&selec="+nombre_selec+"&d="+now(), true);
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
			
	//window.alert(document.Forma['id'].value);
	
	armarCategoria(document.Forma['id'].value,document.Forma['tipo'].value);
	//window.alert(document.Forma['id'].value+" - "+document.Forma['tipo'].value);
	//cerrarVentana();
}


function detallesAnuncio(id_cat) 
{	
	if (document.Forma.codigo.value=="")
		var id_anuncio="NULL";
	else
		var id_anuncio=document.Forma.codigo.value;
		
		
	var aux=new String(id_cat);
	var cates=aux.split(";");
	var id_cat2=cates[0];
	
	if (id_cat2==5000)
		document.getElementById('barra_precio').style.display="none";
	
	fox=0;
	req=getXMLHttpRequest();
	req.onreadystatechange=processdetallesAnuncio;
	req.open("GET","ajax_detallesAnuncio.php?id_cat="+id_cat+"&id_anuncio="+id_anuncio+"&d="+now(),true);
	req.send(null);	
} 

function processdetallesAnuncio()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("barra_detalles_anuncio").innerHTML=req.responseText;
		} 
		else 
			alert("Problema");      
	}
}




function modelos(e) 
{	
	req=getXMLHttpRequest();
	req.onreadystatechange=process_modelos;
	req.open("GET","ajax_modelos.php?marca="+e.value+"&d="+now(),true);
	req.send(null);
} 

function process_modelos()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			//window.alert(req.responseText);
			document.getElementById("espacio_modelo").innerHTML=req.responseText;
		} 
		else 
			alert("Problema");      
	}
}

var fox=0;
function armarCategoria(id,tipo) 
{	
	fox=0;
	req=getXMLHttpRequest();
	req.onreadystatechange=processArmarCategoria;
	req.open("GET","ajax_armarCategoria.php?id="+id+"&tipo="+tipo+"&d="+now(),true);
	req.send(null);	
	
	
} 


function processArmarCategoria()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("categoriasSeleccionadas").innerHTML=req.responseText;
			fox=1;
			
			//ventana.close();
			detallesAnuncio(document.Forma['id'].value);				
		} 
		else 
			alert("Problema");      
	}
}



function resetCategoria() 
{	
	eliminar_categoria();
	
	req=getXMLHttpRequest();
	req.onreadystatechange=process_selecCategoria;
	req.open("GET","ajax_resetCategoria.php"+"?d="+now(),true);
	req.send(null);
} 


function process_selecCategoria()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			document.getElementById("categoriasSeleccionadas").innerHTML=req.responseText;
		} 
		else 
			alert("Problema");      
	}
}


function eliminar_categoria()
{
	document.Forma['id'].value="NULL";
	document.Forma['tipo'].value="NULL";
	
	document.getElementById("barra_detalles_anuncio").innerHTML="";
}

function subirFoto()
{	
	var foto="X";
	
	if (document.Forma['foto1'].value=="NO")
		foto="1"; else
	if (document.Forma['foto2'].value=="NO")
		foto="2"; else
	if (document.Forma['foto3'].value=="NO")
		foto="3"; else
	if (document.Forma['foto4'].value=="NO")
		foto="4"; else
	if (document.Forma['foto5'].value=="NO")
		foto="5"; else
	if (document.Forma['foto6'].value=="NO")
		foto="6";
	
	if (foto!="X")
		window.open("subirFoto.php?foto="+foto+"&code="+document.Forma['id_anuncio'].value,"subirFoto","toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=400,height=130");
	else
		window.alert("Ya has subido todas las fotos posibles");
}



function borrarFoto(foto)
{	
	document.Forma['foto'+foto].value="NO";
	document.getElementById("foto"+foto).innerHTML="Foto "+foto;
	
	calibrarFotos();		
}


function contar_texto()
{
	texto = new String (document.Forma.texto.value);
	longitud = 700-texto.length;
	if (longitud<0)
	{
		//window.alert("Tamaño máximo alcanzado");
		document.Forma.texto.value=texto.substr(0,700);
	}
	else
		document.getElementById("restan").innerHTML=longitud;	
}


function colocar(tipo)
{
	var aux=new String(document.Forma.id.value);
	var cates=aux.split(";");
	var id_cat=cates[cates.length-1];
	
	
	
	//EXPRESIONES REGULARES
	var patron_email=/^[^@ ]+@[^@ ]+.[^@ .]+$/;
	//var patron_ciudad=/^[a-zA-Z][a-zA-Z\s]+$/;
	var patron_anio=/^19\d\d|200\d|201\d$/;
	var patron_no_vacio=/^\S[\w\W]*$/;
	
	
	
	
	if (document.Forma.id.value=="NULL")
		window.alert("Debes seleccionar una categoria para tu anuncio");
	else 
	{
		if (patron_email.test(document.Forma.email.value)==false)
			window.alert("Debe indicar un e-mail valido");
		else
			if (patron_no_vacio.test(document.Forma.nombre.value)==false)
				window.alert("Debe indicar su nombre");
			else
				if (patron_no_vacio.test(document.Forma.titulo.value)==false)
					window.alert("Debe introducir el titulo del anuncio");
				else
					if (patron_no_vacio.test(document.Forma.ciudad.value)==false)
						window.alert("Debe introducir un nombre de ciudad valido");
						else
							if ((document.Forma.precio.value!="")&&(validaDecimal(document.Forma.precio.value)==0))
								window.alert("El precio debe tener el formato indicado");
							else
							{
								if ((id_cat==4)||(id_cat==3))
								{
									if (patron_no_vacio.test(document.Forma.urbanizacion.value)==false)
										window.alert("Debes indicar la urbanización, barrio o zona donde se encuentra el inmueble");
									else
										if (validaDecimal(document.Forma.superficie.value)==0)
											window.alert("El valor de la superficie del inmueble debe tener el formato indicado");
										else
											if (validaEntero(document.Forma.habitaciones.value)==0)
												window.alert("El numero de habitaciones del inmueble debe ser un número entero");
											else
											{
												if (tipo==1)
													document.Forma.action="publicar.php";
												if (tipo==2)
													document.Forma.action="editar.php";
														
												document.Forma.submit();
											}
								}
								else
									if ((id_cat==5)||(id_cat==6)||(id_cat==7)||(id_cat==8)||(id_cat==9)||(id_cat==10)||(id_cat==3707))
									{
										if (patron_no_vacio.test(document.Forma.urbanizacion.value)==false)
											window.alert("Debes indicar la urbanización, barrio o zona donde se encuentra el inmueble");
										else
											if (validaDecimal(document.Forma.superficie.value)==0)
												window.alert("El valor de la superficie del inmueble debe tener el formato indicado");
											else
											{
												if (tipo==1)
													document.Forma.action="publicar.php";
												if (tipo==2)
													document.Forma.action="editar.php";
														
												document.Forma.submit();
											}
									}
									else
										if ((id_cat==11)||(id_cat==12)||(id_cat==16)||(id_cat==13)||(id_cat==14))
										{
											if (patron_no_vacio.test(document.Forma.marca.value)==false)
												window.alert("Debes indicar la marca del vehiculo");
											else
												if (patron_no_vacio.test(document.Forma.modelo.value)==false)
													window.alert("Debes indicar el modelo del vehiculo");
												else
													if (patron_anio.test(document.Forma.anio.value)==false)
														window.alert("El año del vehiculo no es correcto");
													else
														if (validaEntero(document.Forma.kms.value)==0)
															window.alert("El kilometraje del vehiculo no es correcto");
														else														
														{
															if (tipo==1)
																document.Forma.action="publicar.php";
															if (tipo==2)
																document.Forma.action="editar.php";
																
															document.Forma.submit();
														}										
													
										}
										else
											if ((id_cat>=5001)&&(id_cat<=5021))
											{
												if ((trim(document.Forma.salario.value)!="")&&(validaDecimal(document.Forma.salario.value)==0))
													window.alert("El salario del empleo que estas ofreciendo es invalido");
												else
												{
													if (tipo==1)
														document.Forma.action="publicar.php";
													if (tipo==2)
														document.Forma.action="editar.php";
														
													document.Forma.submit();
												}
											}
											else
											{
												if (tipo==1)
													document.Forma.action="publicar.php";
												if (tipo==2)
													document.Forma.action="editar.php";
													
												document.Forma.submit();
											}
							}
								
	}
}





function calibrarFotos()
{
	document.Forma['aux1'].value="0";
	document.Forma['aux2'].value="0";
	document.Forma['aux3'].value="0";
	document.Forma['aux4'].value="0";
	document.Forma['aux5'].value="0";
	document.Forma['aux6'].value="0";
	
	var num=0;
	
	if (document.Forma['foto1'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="1";
			
	}
	if (document.Forma['foto2'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="2";		
	}
	if (document.Forma['foto3'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="3";	
	}
	if (document.Forma['foto4'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="4";		
	}
	if (document.Forma['foto5'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="5";	
	}
	if (document.Forma['foto6'].value=="SI")
	{
		num++;
		document.Forma['aux'+num].value="6";	
	}	
	//---------------------------------------------------------	
	
	var url="ajax_calibrarFotos.php?foto1="+document.Forma['aux1'].value+"&foto2="+document.Forma['aux2'].value+"&foto3="+document.Forma['aux3'].value+"&foto4="+document.Forma['aux4'].value+"&foto5="+document.Forma['aux5'].value+"&foto6="+document.Forma['aux6'].value+"&code="+document.Forma['id_anuncio'].value;+"&d="+now()
	
	
	//window.alert(url);
	
	req=getXMLHttpRequest();
	req.onreadystatechange=processCalibrar;
	req.open("GET",url, true);
	req.send(null);	
}

var n=0;

function processCalibrar()
{
	
	
	if (req.readyState==4)
	{		
		if (req.status==200)
		{			
			document.Forma['foto1'].value="NO";
			document.Forma['foto2'].value="NO";
			document.Forma['foto3'].value="NO";
			document.Forma['foto4'].value="NO";
			document.Forma['foto5'].value="NO";
			document.Forma['foto6'].value="NO";
			
			if (document.Forma['aux1'].value!="0")
			{
				document.Forma['foto1'].value="SI";
				n=hora();
				document.getElementById("foto1").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_1_muestra?d="+n+"'><br><a href='javascript:borrarFoto(1)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto1").innerHTML="Foto 1";
			}
			if (document.Forma['aux2'].value!="0")
			{
				document.Forma['foto2'].value="SI";
				n=hora();
				document.getElementById("foto2").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_2_muestra?d="+n+"'><br><a href='javascript:borrarFoto(2)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto2").innerHTML="Foto 2";
			}
			if (document.Forma['aux3'].value!="0")
			{
				document.Forma['foto3'].value="SI";
				n=hora();
				document.getElementById("foto3").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_3_muestra?d="+n+"'><br><a href='javascript:borrarFoto(3)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto3").innerHTML="Foto 3";
				}
			if (document.Forma['aux4'].value!="0")
			{
				document.Forma['foto4'].value="SI";
				n=hora();
				document.getElementById("foto4").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_4_muestra?d="+n+"'><br><a href='javascript:borrarFoto(4)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto4").innerHTML="Foto 4";
			}
			if (document.Forma['aux5'].value!="0")
			{
				document.Forma['foto5'].value="SI";
				n=hora();
				document.getElementById("foto5").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_5_muestra?d="+n+"'><br><a href='javascript:borrarFoto(5)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto5").innerHTML="Foto 5";
			}
			if (document.Forma['aux6'].value!="0")
			{
				document.Forma['foto6'].value="SI";
				n=hora();
				document.getElementById("foto6").innerHTML="<img src='../img/img_bank/temp/"+document.Forma['id_anuncio'].value+"_6_muestra?d="+n+"'><br><a href='javascript:borrarFoto(6)' class='LinkFuncionalidad'>eliminar</a>";
			}
			else
			{
				document.getElementById("foto6").innerHTML="Foto 6";
			}	
		} 
		else 
			alert("Ocurrió un problema");      
	}
}



function probarYoutube() 
{	
	document.getElementById('verificar_youtube').innerHTML='<img src="../img/ajax-loader.gif" width="16" height="16">';
	
	req=getXMLHttpRequest();
	req.onreadystatechange=processStateChange2;
	req.open("POST","ajax_comprobarYutub.php"+"?d="+now(), true);
	req.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
	req.send("url="+document.Forma.youtube.value);		
}

function processStateChange2()
{
	if (req.readyState==4)
	{		
		if (req.status==200)
		{
			if (req.responseText=="1")
			{
				document.Forma.estado_yutub.value="SI";
				document.getElementById('verificar_youtube').innerHTML='<img src="../img/checked.png" width="24" height="24">';				
			}
			else
			{
				document.Forma.estado_yutub.value="NO";
				window.alert('La direccion del video introducida no es valida');
				document.getElementById('verificar_youtube').innerHTML='<input type="button" name="button3" id="button3" value="Verificar" onClick="probarYoutube()">';
			}
		} 
		else 
		{
			//window.alert("Problema youtube");
			window.alert(req.status);
		}
	}
} 
