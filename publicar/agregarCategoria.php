<?
	session_start();	
	include "../lib/class.php";	
	$id_pais=verificaPais();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Agregar categor&iacute;a</title>


<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript">

var which;
var nombre_selec;

	
function subcategorias(selec) 
{
	nombre_selec=selec.name;	
	indice=document.Forma[nombre_selec].selectedIndex;
	id_padre=document.Forma[nombre_selec].options[indice].value;	
		
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
				document.getElementById("sig_sub1").innerHTML="<div align='center'><b><span style='font-size: 10pt'> &raquo; </span></b></div>";		
			}
			
			if (nombre_selec=="sub1")
			{
				document.getElementById("sub2").innerHTML="";
				document.getElementById("sig_sub2").innerHTML="";
				document.getElementById("sub3").innerHTML="";
				document.getElementById("sig_sub3").innerHTML="";
				document.getElementById("final").innerHTML="";
				
				document.getElementById("sub2").innerHTML=req.responseText;
				document.getElementById("sig_sub2").innerHTML="<div align='center'><b><span style='font-size: 10pt'> &raquo; </span></b></div>";
			}
			
			if (nombre_selec=="sub2")
			{
				document.Forma.control_sub2.value="SI";			
				
				document.getElementById("sub3").innerHTML="";
				document.getElementById("sig_sub3").innerHTML="";
				document.getElementById("final").innerHTML="";
				
				document.getElementById("sub3").innerHTML=req.responseText;
				document.getElementById("sig_sub3").innerHTML="<div align='center'><b><span style='font-size: 10pt'> &raquo; </span></b></div>";
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
	
	window.opener.document.Forma['id'].value=id;
	window.opener.document.Forma['tipo'].value=tipo;
			
	window.opener.armarCategoria(window.opener.document.Forma['id'].value,window.opener.document.Forma['tipo'].value);		
	//window.alert(window.opener.document.Forma['id'].value);
	cerrarVentana();
}

</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<form name="Forma" method="post" action="">
  <table width="700" border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td width="67"><select name="principal" size="7" id="principal" onChange="subcategorias(this)">      
        <?			
			$categorias=categorias_principales($id_pais);			
			$total=sizeof($categorias);
			for ($i=0;$i<$total;$i++)
				echo "<option value='".$categorias[$i]['id']."'>".$categorias[$i]['nombre']."</option>";			
		?>
      </select></td>
      <td width="7"><div align="center"><b><span style='font-size: 10pt'> &raquo; </span></b></div></td>
      <td width="7" id="sub1">&nbsp;</td>
      <td width="7" id="sig_sub1"></td>
      <td width="7" id="sub2">&nbsp;</td>
      <td width="7" id="sig_sub2"></td>
      <td width="7" id="sub3">&nbsp;</td>
      <td width="7" id="sig_sub3"><div align="center"></div></td>
      <td width="584" align="left" id="final">&nbsp;</td>
    </tr>
  </table>
  <input name="control_sub2" type="hidden" id="control_sub2" value="NO">
</form>
</body>
</html>
