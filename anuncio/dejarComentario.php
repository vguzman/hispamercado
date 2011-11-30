
<form name="form1" method="post" action="dejarComentario2.php">
  <table width="371" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" class="arial13Negro">Visibilidad:</td>
      <td align="left" class="arial13Negro"><input name="visi" type="radio" value="pub">
      P&uacute;blico
        <input type="hidden" name="id_anuncio" id="id_anuncio" value="<? echo $_GET['id_anuncio'] ?>">
        <br>
        <input name="visi" type="radio" value="priv">
Privado (s&oacute;lo lo recibir&aacute; el anunciante) </td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Tu nombre</td>
      <td><input name="tu_nombre" type="text" id="tu_nombre" size="30" maxlength="100"></td>
    </tr>
    <tr>
      <td width="93" align="left" class="arial13Negro">Tu e-mail : </td>
      <td width="264"><input name="tu_email" type="text" id="tu_email" size="30" maxlength="100"></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">Tu comentario: </td>
      <td><textarea name="comentario" cols="25" rows="5" id="comentario"></textarea></td>
    </tr>
    <tr>
      <td align="left" class="arial13Negro">&nbsp;</td>
      <td><input type="submit" name="Submit" value="Enviar comenario"></td>
    </tr>
  </table>
</form>