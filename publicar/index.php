<?	
	include "../lib/class.php";
	$sesion=checkSession();
	
	$cookie=md5(uniqid(rand().time(), TRUE));

	
	$pre_email="";
	$pre_nombre="";
	$pre_telefonos="";
	$pre_titulo="";
	$pre_descripcion="";
	$pre_ciudad="";
	$pre_precio="";
	$pre_youtube="";
	
	//CASOS USUARIO REGISTRADO
	if ($sesion!=false)
	{
		$usuario=new Usuario($sesion);
		$datos=$usuario->predatos();
		
		
		$pre_email=$datos['email'];
		$pre_nombre=$datos['nombre'];
		$pre_telefonos=$datos['telefonos'];
		$pre_ciudad=$datos['ciudad'];
	}
	
	
	//CASOS SPAM
	if (isset($_GET['precarga']))
	{
		$query=operacionSQLSpam("SELECT * FROM anuncios WHERE id=".$_GET['precarga']);
		
		if (mysql_num_rows($query)>0)
		{
			$pre_email=mysql_result($query,0,3);
			$pre_nombre=mysql_result($query,0,4);
			$pre_telefonos=mysql_result($query,0,10);
			$pre_titulo=mysql_result($query,0,1);
			$pre_descripcion=mysql_result($query,0,2);
			$pre_ciudad=mysql_result($query,0,8);
		}
	}
	
	
	$trigger="";$trigger2="";
	if (isset($_GET['edit']))
	{
		$query=operacionSQL("SELECT id FROM Anuncio WHERE codigo_verificacion='".$_GET['edit']."'");
		if (mysql_num_rows($query)==0)
		{
			echo "<SCRIPT LANGUAGE='JavaScript'>		
				document.location.href='http://www.hispamercado.com.ve/';			
			</SCRIPT>";
			exit;
		}
		else
		{
			$anuncio=new Anuncio(mysql_result($query,0,0));
			
			$pre_nombre=$anuncio->anunciante_nombre;
			$pre_email=$anuncio->anunciante_email;
			$pre_telefonos=$anuncio->anunciante_telefonos;
			$pre_titulo=$anuncio->titulo;
			$pre_descripcion=$anuncio->descripcion;
			$pre_ciudad=$anuncio->ciudad;
			$pre_precio=$anuncio->precio;
			$pre_youtube=$anuncio->video_youtube;
			
			
			
			$cate=new Categoria($anuncio->id_categoria);
			$arbol=$cate->arbolDeHoja();
			
			$armar_cate="";
			for ($i=count($arbol)-1;$i>=0;$i--)
			{
				$armar_cate.=$arbol[$i]['id'];
				if ($i>0)
					$armar_cate.=";";
			}
			
			
			//TRATANDO FOTOS
			if ($anuncio->foto1=="SI")
			{
				$destino="../img/img_bank/temp/".$cookie."_1";
				copy("../img/img_bank/".$anuncio->id."_1",$destino);
			
				$info = getimagesize($destino);
			
				//Para abrir archivo
				switch ($info[2]) 
				{
					case 1:
						$original = imagecreatefromgif($destino); break;
					case 2:
						$original = imagecreatefromjpeg($destino); break;
					case 3:
						$original = imagecreatefrompng($destino); break;
					
				}
				
				//TODO LO QUE VIENE ES PARA CUADRAR LAS PROPORCIONES DE LA FOTO
				$original_w = imagesx($original);
				$original_h = imagesy($original);
			
				if($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*97);
					$muestra_h=97;				
				}
				else
				{
					$muestra_w=77;
					$muestra_h=intval(($original_h/$original_w)*77);
				}
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
				
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
				
				//Para cerrar y guardar foto			
				imagejpeg($muestra,$destino."_muestra",100);
				imagedestroy($muestra);			
			
			
			
			
			}
			if ($anuncio->foto2=="SI")
			{
				
				$destino="../img/img_bank/temp/".$cookie."_2";
				copy("../img/img_bank/".$anuncio->id."_2",$destino);
			
			
			
				$info = getimagesize($destino);
			
				//Para abrir archivo
				switch ($info[2]) 
				{
					case 1:
						$original = imagecreatefromgif($destino); break;
					case 2:
						$original = imagecreatefromjpeg($destino); break;
					case 3:
						$original = imagecreatefrompng($destino); break;
					
				}
				
				//TODO LO QUE VIENE ES PARA CUADRAR LAS PROPORCIONES DE LA FOTO
				$original_w = imagesx($original);
				$original_h = imagesy($original);
			
				if($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*97);
					$muestra_h=97;				
				}
				else
				{
					$muestra_w=77;
					$muestra_h=intval(($original_h/$original_w)*77);
				}
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
				
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
				
				//Para cerrar y guardar foto			
				imagejpeg($muestra,$destino."_muestra",100);
				imagedestroy($muestra);
			}			
			if ($anuncio->foto3=="SI")
			{
				$destino="../img/img_bank/temp/".$cookie."_3";
				copy("../img/img_bank/".$anuncio->id."_3",$destino);
				
				$info = getimagesize($destino);
			
				//Para abrir archivo
				switch ($info[2]) 
				{
					case 1:
						$original = imagecreatefromgif($destino); break;
					case 2:
						$original = imagecreatefromjpeg($destino); break;
					case 3:
						$original = imagecreatefrompng($destino); break;
					
				}
				
				//TODO LO QUE VIENE ES PARA CUADRAR LAS PROPORCIONES DE LA FOTO
				$original_w = imagesx($original);
				$original_h = imagesy($original);
			
				if($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*97);
					$muestra_h=97;				
				}
				else
				{
					$muestra_w=77;
					$muestra_h=intval(($original_h/$original_w)*77);
				}
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
				
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
				
				//Para cerrar y guardar foto			
				imagejpeg($muestra,$destino."_muestra",100);
				imagedestroy($muestra);
			}
			if ($anuncio->foto4=="SI")
			{
				$destino="../img/img_bank/temp/".$cookie."_4";
				copy("../img/img_bank/".$anuncio->id."_4",$destino);
				
				
				$info = getimagesize($destino);
			
				//Para abrir archivo
				switch ($info[2]) 
				{
					case 1:
						$original = imagecreatefromgif($destino); break;
					case 2:
						$original = imagecreatefromjpeg($destino); break;
					case 3:
						$original = imagecreatefrompng($destino); break;
					
				}
				
				//TODO LO QUE VIENE ES PARA CUADRAR LAS PROPORCIONES DE LA FOTO
				$original_w = imagesx($original);
				$original_h = imagesy($original);
			
				if($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*97);
					$muestra_h=97;				
				}
				else
				{
					$muestra_w=77;
					$muestra_h=intval(($original_h/$original_w)*77);
				}
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
				
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
				
				//Para cerrar y guardar foto			
				imagejpeg($muestra,$destino."_muestra",100);
				imagedestroy($muestra);
			}
			if ($anuncio->foto5=="SI")
			{
				$destino="../img/img_bank/temp/".$cookie."_5";
				copy("../img/img_bank/".$anuncio->id."_5",$destino);
				
				$info = getimagesize($destino);
			
				//Para abrir archivo
				switch ($info[2]) 
				{
					case 1:
						$original = imagecreatefromgif($destino); break;
					case 2:
						$original = imagecreatefromjpeg($destino); break;
					case 3:
						$original = imagecreatefrompng($destino); break;
					
				}
				
				//TODO LO QUE VIENE ES PARA CUADRAR LAS PROPORCIONES DE LA FOTO
				$original_w = imagesx($original);
				$original_h = imagesy($original);
			
				if($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*97);
					$muestra_h=97;				
				}
				else
				{
					$muestra_w=77;
					$muestra_h=intval(($original_h/$original_w)*77);
				}
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
				
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
				
				//Para cerrar y guardar foto			
				imagejpeg($muestra,$destino."_muestra",100);
				imagedestroy($muestra);
			}
			if ($anuncio->foto6=="SI")
			{
				$destino="../img/img_bank/temp/".$cookie."_6";
				copy("../img/img_bank/".$anuncio->id."_6",$destino);
			
			
				$info = getimagesize($destino);
			
				//Para abrir archivo
				switch ($info[2]) 
				{
					case 1:
						$original = imagecreatefromgif($destino); break;
					case 2:
						$original = imagecreatefromjpeg($destino); break;
					case 3:
						$original = imagecreatefrompng($destino); break;
					
				}
				
				//TODO LO QUE VIENE ES PARA CUADRAR LAS PROPORCIONES DE LA FOTO
				$original_w = imagesx($original);
				$original_h = imagesy($original);
			
				if($original_w<$original_h) 
				{
					$muestra_w = intval(($original_w/$original_h)*97);
					$muestra_h=97;				
				}
				else
				{
					$muestra_w=77;
					$muestra_h=intval(($original_h/$original_w)*77);
				}
				$muestra = imagecreatetruecolor($muestra_w,$muestra_h); 
				
				imagecopyresampled($muestra,$original,0,0,0,0,$muestra_w,$muestra_h,$original_w,$original_h);
				imagedestroy($original);
				
				//Para cerrar y guardar foto			
				imagejpeg($muestra,$destino."_muestra",100);
				imagedestroy($muestra);
			
			}
			
			
			
			$trigger='onLoad="armarCategoria('.chr(39).$armar_cate.chr(39).','.chr(39).$anuncio->tipo_categoria.chr(39).')"';
			$trigger2='<SCRIPT LANGUAGE="JavaScript">
						calibrarFotos();
					</SCRIPT>';
		}
	}
	
	
	
	
	
	
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>


<meta name="description" content="Publicar aviso clasificado gratis en cualquier ciudad de venezuela con fotos y videos. Publique su anuncio en solo 1 minuto">

<LINK REL="stylesheet" TYPE="text/css" href="../lib/css/basicos.css">

<script language="javascript" type="text/javascript" src="../lib/js/basicos.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/ajax.js"> </script>
<script language="javascript" type="text/javascript" src="../lib/js/publicacion.js"> </script>
<script language="javascript" type="text/javascript">


function accionAnuncio(accion,code)
{
	
	if (accion=="finalizar")
	{
		var dec=window.confirm("Seguro de finalizar este anuncio? Podras activarlo nuevamente cuando quieras");
		if (dec==true)
			document.location.href="gestionAccion.php?accion="+accion+"&code="+code;
	}
	else
		document.location.href="gestionAccion.php?accion="+accion+"&code="+code;
}




</script>


<script src="suggest/js/jquery-1.4.2.min.js"></script>
<script src="suggest/js/autocomplete.jquery.js"></script>
 <script>
            $(document).ready(function(){
                /* Una vez que se cargo la pagina , llamo a todos los autocompletes y
                 * los inicializo */
                $('.autocomplete').autocomplete();
            });
        </script>
        
        
        
        
<link type="text/css" rel="stylesheet" href="suggest/css/autocomplete.css"></link>
        
        
<script type="text/javascript" src="../lib/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
tinyMCE.init({
// General options
mode : "textareas",
theme : "advanced",
height : "450px",
language : "es",
plugins : "table,inlinepopups,preview",

// Theme options
theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,fontselect,fontsizeselect,|,bullist,numlist,|,forecolor,backcolor,|",
theme_advanced_buttons2 : "link,unlink,image,table,|,cut,copy,paste,undo,redo,|,preview,|,code,|",
theme_advanced_buttons3 : "",
theme_advanced_buttons4 : "",

theme_advanced_toolbar_location : "top",
theme_advanced_toolbar_align : "left",
theme_advanced_statusbar_location : "bottom",
theme_advanced_resizing : true,


})
</script>






<title>Publicar anuncio clasificado gratis en Venezuela</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<body <? echo $trigger ?>>
<table width="1000" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="730" align="left" valign="top" ><div style="width:100%;"> <a href="http://www.hispamercado.com.ve/"><img src="../img/logo_original.jpg" alt="" width="360" height="58" border="0"></a> <span class="arial15Mostaza"><strong><em>Anuncios Clasificados en Venezuela</em></strong></span> </div></td>
    <td width="270" valign="top" align="right"><div class="arial13Negro" <? if ($sesion==false) echo 'style="display:none"' ?>>
      <?
	
	if ($sesion!=false)
		$user=new Usuario($sesion);
	
	
	 ?>
      <table width="270" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40" align="left"><? echo "<img src='https://graph.facebook.com/".$user->fb_nick."/picture' width='30' heigth='30' />" ?></td>
          <td width="230" align="left" ><strong><? echo $user->nombre ?>&nbsp;&nbsp;&nbsp;</strong><a href="closeSession.php" class="LinkFuncionalidad13">Mi cuenta</a>&nbsp;&nbsp;<a href="../closeSession.php" class="LinkFuncionalidad13">Salir</a></td>
        </tr>
      </table>
    </div>
      <div <? if ($sesion!=false) echo 'style="display:none"' ?>>
        <div style="width:160px; height:26px; float:right; background-image:url(../img/fondo_fb.png); background-repeat:repeat;" align="left">
          <div style="margin-top:5px; margin-left:8px;"><a href="javascript:loginFB(<? echo "'https://www.facebook.com/dialog/oauth?client_id=119426148153054&redirect_uri=".urlencode("http://www.hispamercado.com.ve/registro.php")."&scope=email&state=".$_SESSION['state']."&display=popup'" ?>)" class="LinkBlanco13">Accede con Facebook</a></div>
        </div>
        <div style="width:26px; height:26px; float:right; background-image:url(../img/icon_facebook.png); background-repeat:no-repeat;"></div>
      </div></td>
  </tr>
</table>
<div style="margin-top:50px;">
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td align="right" valign="bottom" class="arial13Gris" style="padding:3px;"><a href="" class="LinkFuncionalidad17">Gestionar mis anuncios</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" class="LinkFuncionalidad17">Conversaciones</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="" class="LinkFuncionalidad17">Tiendas</a></td>
    </tr>
  </table>
  <table width="1000" border="0" cellspacing="0" cellpadding="0" align="center">
    <tr>
      <td width="320"><input type="button" name="button2" id="button2" value="Publicar Anuncio" onClick="document.location.href=''" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;">
        <input type="button" name="button2" id="button2" value="Iniciar conversaci&oacute;n" onClick="listarRecientes()" style="font-size:15px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; padding-top:4px; padding-bottom:4px;"></td>
      <td width="680"><div style="margin:0 auto 0 auto; width:100%; background-color:#D8E8AE; padding-top:3px; padding-bottom:3px; padding-left:5px;">
        <input name="buscar" type="text" onFocus="manejoBusqueda('adentro')" onBlur="manejoBusqueda('afuera')" onKeyPress="validar(event)" id="buscar" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C; width:170px;" value="Buscar en Hispamercado">
        &nbsp;
        <select name="categorias" id="categorias" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
          <option selected value="todas">Todas las categor&iacute;as</option>
          <?
	  	$aux="SELECT id,nombre FROM Categoria WHERE id<>160 AND id_categoria IS NULL";
		$query=operacionSQL($aux);
		$total=mysql_num_rows($query);	
		
		for ($i=0;$i<$total;$i++)
		{
			$categoria=new Categoria(mysql_result($query,$i,0));
			
			//if ($categoria->anunciosActivos()>0)
			echo "<option value='".mysql_result($query,$i,0)."'style='font-size:13px; font-weight:bold; font-family:Arial, Helvetica, sans-serif; color:#77773C'>".mysql_result($query,$i,1)."</option>";
			
			
		}
		?>
        </select>
        &nbsp;
        <select name="ciudades" id="ciudades" style="font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C">
          <option selected value='todas' style='font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C'>Todas las ciudades</option>
          <option value='Fuera del pa&iacute;s'style='font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C'>Fuera del pa&iacute;s</option>
          <?
		
		//-----EXCLUYENDO CATEGORIA ADULTOS
	$cat=new Categoria(160);
	$hijos=$cat->hijos();
	
	$parche="";
	for ($i=0;$i<count($hijos);$i++)
		$parche.=" AND id_categoria<>".$hijos[$i];
	//-----------
		
		
	  	$query=operacionSQL("SELECT ciudad,COUNT(*) FROM Anuncio WHERE status_general='Activo' AND ciudad<>'Fuera del pa&iacute;s' ".$parche." GROUP BY ciudad ORDER BY ciudad ASC");
				
		for ($i=0;$i<mysql_num_rows($query);$i++)
			echo "<option value='".mysql_result($query,$i,0)."' style='font-size:13px; font-family:Arial, Helvetica, sans-serif; color:#77773C'>".mysql_result($query,$i,0)."</option>";
		
	  ?>
        </select>
        &nbsp;
        <label>
          <input type="button" name="button" id="button" value="Buscar" onClick="listarRecientes()" style="font-size:13px; font-family:Arial, Helvetica, sans-serif;">
        </label>
      </div></td>
    </tr>
  </table>
</div>
<div style="visibility:hidden; display:none;">
<img src="../img/bigrotation2.gif" width="32" height="32" ></div>
<div align="center" style="margin-top:50px;">
<table width="1000" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" style="border-collapse:collapse; border-bottom:#C8C8C8 1px solid; ">
      <tr>
        <td width="347" align="left" valign="bottom" class="arial15Negro"><a href="/" class="LinkFuncionalidad15"><b>Inicio </b></a>&raquo; <? if (isset($anuncio)) echo "Editar anuncio #".$anuncio->id; else echo "Publicar anuncio"; ?> </td>
        <td width="653" align="right" valign="bottom">
        
        <?
			if (isset($anuncio))
			{	
				if ($anuncio->status_general=="Activo")
					echo '<table width="200" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="42" align="right"><img src="../img/delete-icon.png" width="24" height="24" border="0"></td>
							<td width="158" style="padding-left:3px;" align="left"><a href="javascript:accionAnuncio('.chr(39).'finalizar'.chr(39).','.chr(39).$anuncio->codigo_verificacion.chr(39).')" class="LinkFuncionalidad15">Finalizar este anuncio</a></td>
						  </tr>
						</table>';
						
				if ($anuncio->status_general=="Inactivo")
					echo '<table width="200" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td width="42" align="right"><img src="../img/activate-icon.png" width="24" height="24" border="0"></td>
							<td width="158" style="padding-left:3px;" align="left"><a href="javascript:accionAnuncio('.chr(39).'reactivar'.chr(39).','.chr(39).$anuncio->codigo_verificacion.chr(39).')" class="LinkFuncionalidad15">Reactivar este anuncio</a></td>
						  </tr>
						</table>';
			
			
			
			}
		?>
        
        

        
        
        
        </td>
      </tr>
    </table>
</div>

<div style=" margin-top:30px;">
<form name="Forma" method="post" action="publicar.php">


<div style="margin:0 auto 0 auto; width:1000px; background-color:#F4F9E8; padding-top:5px; padding-left:5px;" class="arial13Negro">
	<strong>Categor&iacute;a <span class="arial13Rojo">*</span></strong>
    <input type="hidden" name="codigo" id="codigo"  <? if (isset($anuncio)) echo 'value="'.$anuncio->codigo_verificacion.'"' ?>>
</div>

  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3" bgcolor="#F4F9E8">
    <tr>
      <td align="center" id="categoriasSeleccionadas" class="arial13Negro"><table width="1000" align="center" border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="67" style="padding-top:5px; padding-bottom:5px;"><select name="principal" size="6" id="principal" onChange="subcategorias(this)">
            <?			
			$categorias=categorias_principales();			
			$total=sizeof($categorias);
			for ($i=0;$i<$total;$i++)
				echo "<option value='".$categorias[$i]['id']."'>".$categorias[$i]['nombre']."</option>";			
		?>
          </select></td>
          <td width="7" align="center" class="arial13Negro"><b>&nbsp;&raquo;&nbsp;</b></td>
          <td width="7" id="sub1" style="padding-top:5px; padding-bottom:5px;">&nbsp;</td>
          <td width="7" id="sig_sub1" style="padding-top:5px; padding-bottom:5px;"></td>
          <td width="7" id="sub2" style="padding-top:5px; padding-bottom:5px;">&nbsp;</td>
          <td width="7" id="sig_sub2" style="padding-top:5px; padding-bottom:5px;"></td>
          <td width="7" id="sub3" style="padding-top:5px; padding-bottom:5px;">&nbsp;</td>
          <td width="7" id="sig_sub3" style="padding-top:5px; padding-bottom:5px;"><div align="center"></div></td>
          <td width="584" align="left" id="final" style="padding-top:5px; padding-bottom:5px;">&nbsp;</td>
        </tr>
      </table></td>
    </tr>
  </table>
  <table width="800" border="0" align="center" cellpadding="0" cellspacing="3">
    <tr>
      <td><i><font face="Arial" size="2" color="#666666">
        <input name="id" type="hidden" id="id" <? if (isset($anuncio)) echo 'value="'.$armar_cate.'"'; else echo 'value="NULL"'; ?>>
        <input name="tipo" type="hidden" id="tipo" <? if (isset($anuncio)) echo 'value="'.$anuncio->tipo_categoria.'"'; else echo 'value="NULL"'; ?>>
        &nbsp;
        <input name="control_sub2" type="hidden" id="control_sub2" value="NO">
      </font></i></td>
    </tr>
  </table>
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="435" align="left" class="arial13Negro" style="padding-top:5px; padding-bottom:5px;"><strong>Datos del anunciante</strong></td>
      <td width="356" align="right" class="Estilo3"><? //f (isset($_SESSION['user'])) echo "te encuentras logueado como <strong>".$_SESSION['user']."</strong>"; ?></td>
    </tr>
  </table>
  <table width="1000" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td width="117" align="left" class="arial13Negro">E-mail</td>
      <td width="258" valign="middle" align="left"><input name="email" type="text" id="email" size="25" maxlength="255" value="<? echo $pre_email ?>"></td>
      <td width="65" align="left" class="arial13Negro">Nombre</td>
      <td width="340" align="left"><input name="nombre" type="text" id="nombre" size="25" maxlength="255" value="<? echo $pre_nombre ?>"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Tel&eacute;fono(s)</td>
      <td align="left" class="arial13Negro"><input name="telefonos" type="text" id="telefonos2" size="20" maxlength="255" value="<? echo $pre_telefonos ?>"> 
      <em>(opcional)</em></td>
      <td align="left">&nbsp;</td>
      <td align="left">&nbsp;</td>
    </tr>
  </table>
  <table width="200" border="0" align="center" cellpadding="0" cellspacing="3">
    <tr>
      <td>&nbsp;<input name="id_anuncio" type="hidden" id="id_anuncio" value="<? echo $cookie ?>"></td>
    </tr>
  </table>
  <table width="1000" border="0" align="center" cellpadding="0" cellspacing="4" bgcolor="#F4F9E8" style="border-collapse:collapse ">
    <tr>
      <td width="484" align="left" class="arial13Negro" style="padding-top:5px; padding-bottom:5px;"><strong>Datos del anuncio</strong></td>
    </tr>
  </table>
  <table width="1000" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td align="left" class="arial13Negro"> T&iacute;tulo</td>
      <td align="left"><input name="titulo" type="text" id="titulo" size="100" maxlength="150" value="<? echo $pre_titulo ?>"></td>
    </tr>
    <tr>
      <td width="150" align="left" valign="top" class="arial13Negro">Descripci&oacute;n</td>
      <td width="850" align="left"><textarea id="content" name="content" rows="10" style="width:100%" ><? echo $pre_descripcion ?>
	</textarea></td>
    </tr>
  </table>
    <table width="1000" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#F4F9E8">
    <tr>
      <td id="barra_detalles_anuncio"></td>
    </tr>
  </table>
  <table width="1000" border="0" align="center" cellpadding="2" cellspacing="4" bgcolor="#F4F9E8">
    <tr>
      <td width="150" align="left" class="arial13Negro">Ciudad</td>
      <td width="830" align="left" style="padding-top:8px;">
      
     
      
      
      <div  class="autocomplete" style="margin:0px; padding:0px;">
        <input name="ciudad" type="text" id="ciudad" size="40" maxlength="255" value="<? echo $pre_ciudad ?>"  data-source="suggest/search.php?search=">
      </div>
      
       <div class="arial11Gris">Si la ciudad introducida es distinta a cualquiera de las sugeridas el anuncio sera revisado antes de su activacion</div>
      	
       
      
      
      </td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Precio </td>
      <td align="left" class="arial13Negro" style="padding-top:8px;"><label for="moneda"></label>
        <select name="moneda" id="moneda">
          <option <? if (isset($_GET['edit']))
		  				if ($anuncio->moneda=="Bs") echo "selected" ?>>Bs</option>
          <option <? if (isset($_GET['edit']))
		  					if ($anuncio->moneda=="US$") echo "selected" ?>>US$</option>
        </select>
        <input name="precio" type="text" id="precio" size="16" value="<? echo $pre_precio ?>">
        <em>(opcional)</em><br>
        <span class="arial11Gris">Usar formato 999.99</span></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Fotos (<a href="javascript:subirFoto()" class="LinkFuncionalidad13">subir foto</a>) </td>
      <td align="left" style="padding-top:8px;"><table width="600" border="1" align="left" cellpadding="0" cellspacing="0" bordercolor="#C8C8C8" style="border-collapse:collapse; ">
          <tr>
            <td width="100" height="81" align="center" class="arial13Negro" id="foto1">Foto 1</td>
            <td width="100" align="center" class="arial13Negro" id="foto2">Foto 2</td>
            <td width="100" align="center" class="arial13Negro" id="foto3">Foto 3</td>
            <td width="100" align="center" class="arial13Negro" id="foto4">Foto 4</td>
            <td width="100" align="center" class="arial13Negro"  id="foto5">Foto 5</td>
            <td width="100" align="center" class="arial13Negro"  id="foto6">Foto 6</td>
          </tr>
      </table></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Video <img src="../img/youtube.png" width="16" height="16"></td>
      <td align="left" class="arial13Negro" style="padding-top:8px;"><input name="youtube" type="text" id="youtube" size="72" maxlength="255" onChange="probarYoutube()" value="<? echo $pre_youtube ?>"><? if ($pre_youtube=="") 
	  echo '<span id="verificar_youtube"><input type="button" name="button3" id="button3" value="Verificar" onClick="probarYoutube()"></span>
         <input name="estado_yutub" type="hidden" id="estado_yutub" value="X">';
		 else
		 	echo '<span id="verificar_youtube"><img src="../img/checked.png" width="24" height="24"></span>
         <input name="estado_yutub" type="hidden" id="estado_yutub" value="SI">';
			
			
			
			 ?><br>
          <span class="arial11Gris">Introducir url del video de YouTube (ejemplo: http://www.youtube.com/watch?v=DZRXe1wtC)</span></td>
    </tr>
  </table>
  <table width="200" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td>&nbsp;</td>
    </tr>
  </table>
  <div align="center">
<table width="600" border="0" align="center" cellpadding="0" cellspacing="4">
      <tr>
        <td><input name="foto1" type="hidden" id="foto1" <? if (isset($anuncio)) if ($anuncio->foto1=="SI") echo 'value="SI"'; else echo 'value="NO"';  else echo 'value="NO"'; ?>>
        <input name="aux1" type="hidden" id="aux1"></td>
        <td><input name="foto2" type="hidden" id="foto2" <? if (isset($anuncio)) if ($anuncio->foto2=="SI") echo 'value="SI"'; else echo 'value="NO"';  else echo 'value="NO"'; ?>>
        <input name="aux2" type="hidden" id="aux2"></td>
        <td><input name="foto3" type="hidden" id="foto3" <? if (isset($anuncio)) if ($anuncio->foto3=="SI") echo 'value="SI"'; else echo 'value="NO"';  else echo 'value="NO"'; ?>>
        <input name="aux3" type="hidden" id="aux3"></td>
        <td><input name="foto4" type="hidden" id="foto4" <? if (isset($anuncio)) if ($anuncio->foto4=="SI") echo 'value="SI"'; else echo 'value="NO"';  else echo 'value="NO"'; ?>>
        <input name="aux4" type="hidden" id="aux4"></td>
        <td><input name="foto5" type="hidden" id="foto5" <? if (isset($anuncio)) if ($anuncio->foto5=="SI") echo 'value="SI"'; else echo 'value="NO"';  else echo 'value="NO"'; ?>>
        <input name="aux5" type="hidden" id="aux5"></td>
        <td><input name="foto6" type="hidden" id="foto6" <? if (isset($anuncio)) if ($anuncio->foto6=="SI") echo 'value="SI"'; else echo 'value="NO"';  else echo 'value="NO"'; ?>>
        <input name="aux6" type="hidden" id="aux6"></td>
      </tr>
  </table>
 
      <p align="center">
        <?
			if (isset($anuncio))
				echo '<input type="button" name="Submit" value="Editar anuncio" onClick="colocar(2)" style="font-size:18px; font-family:Arial, Helvetica, sans-serif;">';
			else
				echo '<input type="button" name="Submit" value="Colocar anuncio" onClick="colocar(1)" style="font-size:18px; font-family:Arial, Helvetica, sans-serif;">';
		
		?>
        
  </p>
      <table width="400" border="0" align="center" cellpadding="0" cellspacing="1">
        <tr>
          <td><input type="hidden" name="referencia" id="referencia" value="<? if (isset( $_GET['precarga'])) echo $_GET['precarga'] ?>"></td>
        </tr>
        <tr>
          <td id="campo_prueba">&nbsp;</td>
        </tr> 
        <tr>
          <td>&nbsp;</td>
        </tr>
      </table>
      
</form>
</div>
<? echo $trigger2 ?>
</body>
</html>
<script type="text/javascript">
var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
try {
var pageTracker = _gat._getTracker("UA-3308629-2");
pageTracker._trackPageview();
} catch(err) {}</script>