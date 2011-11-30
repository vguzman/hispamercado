<?
	session_start();
	
	header ("Cache-Control: no-cache, must-revalidate");
	
	include "../util.php";	
	
	$id_1=$_GET['id_1'];	
	$tipo_1=$_GET['tipo_1'];
	$id_2=$_GET['id_2'];
	$tipo_2=$_GET['tipo_2'];
	$id_3=$_GET['id_3'];
	$tipo_3=$_GET['tipo_3'];
	$id_4=$_GET['id_4'];
	$tipo_4=$_GET['tipo_4'];
	$id_5=$_GET['id_5'];
	$tipo_5=$_GET['tipo_5'];
	$id_6=$_GET['id_6'];
	$tipo_6=$_GET['tipo_6'];
	
	$result="";
	$n=0;
	
	$pais=$_SESSION['pais'];	
	
	
	if ($id_1!="NULL")
	{		
		$n++;
		$len=strlen($id_1);
		$num="";$categorias="";
		for ($i=0;$i<$len;$i++)
		{			
			if ($id_1[$i]==';')
			{
				$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='../listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
				$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";				
				$num="";
			}
			else
				$num.=$id_1[$i];
		}
		
		$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='../listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
		$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";
		$categorias.=$tipo_1;		
		
		$result.="<table width='335' border='0' cellpadding='0' cellspacing='3'>
				  <tr>
					<td class='Arial11Negro'>- ".$categorias." (<a class='LinkFuncionalidad' href='javascript:eliminar_categoria(1)'>eliminar</a>)</td>
				  </tr>
				</table>";
	}
	
	if ($id_2!="NULL")
	{	
		$n++;	
		$len=strlen($id_2);
		$num="";$categorias="";
		for ($i=0;$i<$len;$i++)
		{			
			if ($id_2[$i]==';')
			{
				$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
				$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";				
				$num="";
			}
			else
				$num.=$id_2[$i];
		}
		
		$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
		$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";
		$categorias.=$tipo_2;
				
		$result.="<table width='335' border='0' cellpadding='0' cellspacing='3'>
				  <tr>
					<td class='Arial11Negro'>- ".$categorias." (<a class='LinkFuncionalidad' href='javascript:eliminar_categoria(2)'>eliminar</a>)</td>
				  </tr>
				</table>";
	}
	
	if ($id_3!="NULL")
	{	
		$n++;	
		$len=strlen($id_3);
		$num="";$categorias="";
		for ($i=0;$i<$len;$i++)
		{			
			if ($id_3[$i]==';')
			{
				$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
				$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";				
				$num="";
			}
			else
				$num.=$id_3[$i];
		}
		
		$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
		$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";
		$categorias.=$tipo_3;
				
		$result.="<table width='335' border='0' cellpadding='0' cellspacing='3'>
				  <tr>
					<td class='Arial11Negro'>- ".$categorias." (<a class='LinkFuncionalidad' href='javascript:eliminar_categoria(3)'>eliminar</a>)</td>
				  </tr>
				</table>";
	}
	
	if ($id_4!="NULL")
	{		
		$n++;
		$len=strlen($id_4);
		$num="";$categorias="";
		for ($i=0;$i<$len;$i++)
		{			
			if ($id_4[$i]==';')
			{
				$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
				$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";				
				$num="";
			}
			else
				$num.=$id_4[$i];
		}
		
		$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
		$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";
		$categorias.=$tipo_4;
				
		$result.="<table width='335' border='0' cellpadding='0' cellspacing='3'>
				  <tr>
					<td class='Arial11Negro'>- ".$categorias." (<a class='LinkFuncionalidad' href='javascript:eliminar_categoria(4)'>eliminar</a>)</td>
				  </tr>
				</table>";
	}	
	
	if ($id_5!="NULL")
	{		
		$n++;
		$len=strlen($id_5);
		$num="";$categorias="";
		for ($i=0;$i<$len;$i++)
		{			
			if ($id_5[$i]==';')
			{
				$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
				$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";				
				$num="";
			}
			else
				$num.=$id_5[$i];
		}
		
		$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
		$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";
		$categorias.=$tipo_5;
				
		$result.="<table width='335' border='0' cellpadding='0' cellspacing='3'>
				  <tr>
					<td class='Arial11Negro'>- ".$categorias." (<a class='LinkFuncionalidad' href='javascript:eliminar_categoria(5)'>eliminar</a>)</td>
				  </tr>
				</table>";
	}	
	if ($id_6!="NULL")
	{		
		$n++;
		$len=strlen($id_6);
		$num="";$categorias="";
		for ($i=0;$i<$len;$i++)
		{			
			if ($id_6[$i]==';')
			{
				$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
				$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";				
				$num="";
			}
			else
				$num.=$id_6[$i];
		}
		
		$categorias.="<font face='Arial' style='font-size: 8pt'><a target='_blank' href='listado.php?pais=".$pais."&id_cat=".$num."&mostrar=1_30'>".nombre_categoria($num)."</a></font>";
		$categorias.=" <b><span style='font-size: 10pt'>&raquo;</span></b> ";
		$categorias.=$tipo_6;
				
		$result.="<table width='335' border='0' cellpadding='0' cellspacing='3'>
				  <tr>
					<td class='Arial11Negro'>- ".$categorias." (<a class='LinkFuncionalidad' href='javascript:eliminar_categoria(4)'>eliminar</a>)</td>
				  </tr>
				</table>";
	}	
	
	
	header('Content-Type: text/html; charset=iso-8859-1');
	echo $result;
?>