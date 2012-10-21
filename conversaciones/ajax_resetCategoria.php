<?
	
	include "../lib/class.php";

?>
<div style="float:left; width:auto; display:table;" class="arial11Negro" id="div_1">
 <select name="selec_1" size="6" id="selec_1" onChange="manejoSeleCat(this)" style="float:left;">
                <?			
                $categorias=categorias_principales();			
                $total=sizeof($categorias);
                for ($i=0;$i<$total;$i++)
                    echo "<option value='".$categorias[$i]['id']."'>".utf8_encode($categorias[$i]['nombre'])."</option>";			
            ?>
              </select>
               <div style="float:left; width:5px; padding-top:50px; margin-left:3px; margin-right:3px; width:auto;" class="arial13Negro">&raquo;</div>
            
            </div>
            <div style="float:left; width:auto;  display:none;" class="arial11Negro" id="div_2"></div>
            <div style="float:left; width:auto;  display:none;" class="arial11Negro" id="div_3"></div>
            <div style="float:left; width:auto;  display:none;" class="arial11Negro" id="div_4"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_5"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_6"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_7"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_8"></div>
            <div style="float:left; width:auto; display:none;" class="arial11Negro" id="div_9"></div></td>
            