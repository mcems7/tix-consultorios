<?php
if($atencionesUrg !=0)
{
	foreach($atencionesUrg as $d)
	{
?>
<input name="id_paciente_destino" id="id_paciente_destino" type="hidden" value="<?=$d['id_paciente']?>" />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="campo_centro">&nbsp;</td>
<td class="campo_centro">Número de documento</td>
<td class="campo_centro">Nombres y apellidos</td>
<td class="campo_centro">Fecha de nacimiento</td>
</tr>
<tr>
<td align="center">&nbsp;</td>
<td align="center"><?=$d['tipo_documento']." ".$d['numero_documento']?>&nbsp;</td>
<td align="center"><?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?></td>
<td align="center"><?=$d['fecha_nacimiento']?></td>
</tr>
</table>
<?php
	}
}else{
?>
No hay un paciente con ese documento
<input name="id_paciente_destino" id="id_paciente_destino" type="hidden" value="" />
<?php
}
?>
