<?php
	$r1 ='';
	$r2 ='';
	$r3 ='';
	$paciente['genero'];
	if($paciente['genero'] == "Masculino"){
		$r1 ='checked="checked"';	
	}else if($paciente['genero'] == "Femenino"){
		$r2 ='checked="checked"';
	}else if($paciente['genero'] == "Indefinido"){
		$r3 ='checked="checked"';
	}
?>
<?=form_hidden('id_paciente',$paciente['id_paciente'])?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr><td colspan="2"><span class="boton_guardar">
<a href="#" onclick="editarPacienteGuardar()">&nbsp;Guardar</a></span>
</td></tr>
<tr><td width="40%">Genero:</td>
<td width="60%">
Masculino&nbsp;<input name="genero" <?=$r1?> id="genero" type="radio" value="Masculino"/>
    Femenino&nbsp;<input name="genero" id="genero" <?=$r2?> type="radio" value="Femenino" />
    &nbsp;Indefinido<input name="genero" id="genero" <?=$r3?> type="radio" value="Indefinido" />
</td></tr>
</table>
<br />
<br />
