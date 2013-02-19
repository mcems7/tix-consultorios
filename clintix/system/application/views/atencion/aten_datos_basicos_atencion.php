<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr><td class="campo_izquierda">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo_izquierda">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo_izquierda">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo_izquierda">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo_izquierda" colspan="1">Entidad encargada pago:</td><td colspan="3"><?=$tercero['eps']?></td></tr>
<tr><td class="campo_izquierda" colspan="1">Entidad solicita atención:</td><td colspan="3"><?=$tercero['entidad_remite']?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr><td class="campo_izquierda">Fecha y hora de la atención:</td><td><?=$tercero['fecha_atencion']?> <?=$tercero['hora_atencion']?></td></tr>
<tr><td class="campo_izquierda" width="30%">Medico tratante:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo_izquierda">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo_izquierda">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
</table>
</td></tr>