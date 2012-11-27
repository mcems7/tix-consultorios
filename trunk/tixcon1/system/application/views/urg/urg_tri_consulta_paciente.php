<div id="datos_paciente">
<?=form_hidden('id_entidad',$paciente['id_entidad'])?>
<?=form_hidden('tipo','n')?>
<?=form_hidden('id_paciente',$paciente['id_paciente'])?>
<input type='hidden' id='genero' name='genero' value='<?=$paciente['genero']?>' />
<table width="100%">
<tr><td colspan="2" class="linea_azul">&nbsp;</td></tr>
<tr><td colspan="2">
<span class="boton_modificar"><a href="#" onclick="editarPaciente()">Editar</a></span>
</td></tr>
<tr><td width="40%">Genero:</td><td width="60%"><?=$paciente['genero']?></td></tr>
</table>
</div>
