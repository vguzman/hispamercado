<?
	if (isset($_GET['path']))
		$path=$_GET['path'];
	else
		$path='';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hispamercado</title>


<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">


</head>



<body>

<ul class="miCuentaMenu">

	<li style="width:90px;" class="miCuentaMenuSeleccion" id="menu1"><a href="<? echo $path ?>cuenta/anuncios.php?status=A&d=<? echo time() ?>" class="arial13Negro" target="iframe" onclick="selecMenu('menu1')" id="menu1_link"><strong>Anuncios</strong></a></li>
    <li style="width:140px;" class="miCuentaMenuNoSeleccion" id="menu2"><a href="<? echo $path ?>cuenta/conversaciones.php?status=A&d=<? echo time() ?>" class="LinkmiCuentaMenu" target="iframe" onclick="selecMenu('menu2')" id="menu2_link"><strong>Conversaciones</strong></a></li>
    <li style="width:80px;" class="miCuentaMenuNoSeleccion" id="menu3"><a href="<? echo $path ?>cuenta/tienda.php" class="LinkmiCuentaMenu" target="iframe" onclick="selecMenu('menu3')" id="menu3_link"><strong>Tienda</strong></a></li>
    <li style="width:90px;" class="miCuentaMenuNoSeleccion" id="menu4"><a href="<? echo $path ?>cuenta/sociales.php" class="LinkmiCuentaMenu"  target="iframe" onclick="selecMenu('menu4')" id="menu4_link"><strong>Sociales</strong></a></li>
    <li style="width:90px;" class="miCuentaMenuNoSeleccion" id="menu5"><a href="<? echo $path ?>cuenta/generales.php" class="LinkmiCuentaMenu"  target="iframe" onclick="selecMenu('menu5')" id="menu5_link"><strong>Generales</strong></a></li>

</ul>

<div align="center">



<iframe src="<? echo $path ?>cuenta/anuncios.php?status=A&d=<? echo time() ?>" width="700" height="500" frameborder="0" id="iframe" name="iframe"></iframe>
</div>


</body>
</html>
