<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr><td class="campo_izquierda">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo_izquierda">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo_izquierda">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo_izquierda">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo_izquierda">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo_izquierda">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
<tr><td class="campo_izquierda">Fecha y hora de la atención:</td><td><?=date('Y-m-d H:i:s')?></td></tr>
<tr><td class="campo_izquierda" width="30%">Medico tratante:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo_izquierda">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo_izquierda">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
</table>
</td></tr>