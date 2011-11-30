<?
	session_start();	
	include "../lib/class.php";	

?>

<table width="800" align="center" border="0" cellpadding="0" cellspacing="0" >
        <tr>
          <td width="67"><select name="principal" size="6" id="principal" onChange="subcategorias(this)">
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