<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="http://www.hispamercado.com.ve/"  />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Hispamercado</title>

<LINK REL="stylesheet" TYPE="text/css" href="lib/css/basicos.css">

</head>



<body>

<div style="width:500px; margin:0 auto 0 auto;">


<div style="background-color:#F4F9E8; padding-top:15px; padding-bottom:15px;">

  <table width="480" border="0" cellspacing="0" cellpadding="0" align="center" class="arial13Negro">
    <tr>
      <td width="119"><img src="http://www.hispamercado.com.ve/img/Emotes-face-smile-big-icon.png" width="96" height="96" /></td>
      <td width="361" class="arial25Mostaza"><em><strong>¡
      <?
	  		if ($_GET['tipo']=="mensaje")
				echo "Gracias por tu mensaje";
			if ($_GET['tipo']=="anuncio")
				echo "Gracias por tu anuncio";
			if ($_GET['tipo']=="comentario")
				echo "Gracias por tu comentario";
			if ($_GET['tipo']=="registro")
				echo "Gracias por registrarte";
			if ($_GET['tipo']=="recomendacion")
				echo "Gracias por tu recomendación";
			if ($_GET['tipo']=="mas15")
				echo "Ya tienes mas de 15 puntos";
	  		
	  
	  ?>
      
      
      
      !<br />
      <?	
	  	if ($_GET['tipo']=="mas15")
			echo "Puedes usarlo para destacar tus anuncios";
		else
			echo "Has ganado ".$_GET['puntos']." puntos";	  
	  ?>
      
        </strong></em></td>
    </tr>
  </table>
</div>


</div>

</body>
</html>
