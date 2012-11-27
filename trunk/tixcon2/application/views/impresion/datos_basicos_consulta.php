<tr><th>Información del paciente</th></tr>
<tr><td>
<table width="100%" border="1">
<tr><td class="negrita">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="negrita">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="negrita">Doc. identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="negrita">Género:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="negrita">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="negrita">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th class="negrita" >Atenci&oacute;n del paciente</th></tr>
<tr><td>
<table width="100%" border="1">
<tr><td class="negrita" width="5%">Fecha y hora de la atención:</td><td><?=date('Y-m-d H:i:s')?></td></tr>
<tr><td class="negrita"  width="5%">Medico tratante:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<!--<tr><td class="negrita" width="5%">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>-->
<tr><td class="negrita" width="5%">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
</table>
</td></tr>