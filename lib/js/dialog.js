var wi_aux;
var he_aux;

function dialog(wi,he,url)
{
	wi_aux=wi;
	he_aux=he;
	
	req=getXMLHttpRequest();
	req.onreadystatechange=process;
	req.open("GET",url,true);
	req.send(null);
}

function process()
{
	if (req.readyState==4)
	{
		if (req.status==200)
		{
			Dialog.info("<div align='right'><a href='javascript:cerrarDialog()' class='LinkFuncionalidad11'>Cerrar <img border=0 src='close_icon.gif' style='vertical-align:middle;' /></a></div>"+req.responseText,{width:wi_aux, height:he_aux, showProgress: false});
		}
		else
			window.alert("Ha ocurrido un problema");      
	}
}


function cerrarDialog()
{
	Dialog.closeInfo()
}