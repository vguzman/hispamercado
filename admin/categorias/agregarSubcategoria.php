<?
	session_start();
	include "../../lib/class.php";	
	if (!session_is_registered('nick_gestion'))
	{	
		echo "<SCRIPT LANGUAGE='JavaScript'> window.alert('Acceso prohibido'); location.href='../index.php'; </SCRIPT>";
		exit;
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title></title>



<LINK REL="stylesheet" TYPE="text/css" href="../../lib/css/basicos.css">

</head>

<body>
<form id="form1" name="form1" method="post" action="agregarSubcategoria2.php">
  <table width="500" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td class="arial13Negro">Subcategoria de:
      
      <br />»
      <?
	  
	  		$categoria=new Categoria($_GET['id_cat']);
			$arbol=$categoria->arbolDeHoja();
			$niveles=count($arbol);
	  
	  
	  		for ($i=($niveles-1);$i>=0;$i--)
			{
				echo $arbol[$i]['nombre']."";
				if ($i>0)
					echo " &raquo; ";
			}
	  
	  ?>
      
      
      
            
      
      
      </td>
    </tr>
    <tr>
      <td><label>
        <input name="nombre_categoria" type="text" id="nombre_categoria" size="40" />
        <input type="hidden" name="id_cat" id="id_cat" value="<? echo $_GET['id_cat'] ?>" />
        <input type="submit" name="button" id="button" value="Agregar" />
      </label></td>
    </tr>
  </table>
</form>
</body>
</html>