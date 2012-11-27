<table width="100%">
<tr>
<td class="campo">Nombres y apellidos:</td>
<td><?=$medico['primer_nombre']." ".$medico['segundo_nombre']." ".$medico['primer_apellido']." ".$medico['segundo_apellido']?></td>
</tr>
<tr><td class="campo">Tipo de profesional:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr><td class="campo">Servicio a ser asignado:</td>
<td>
<input type="hidden" id="id_medico" name="id_medico" value="<?=$medico['id_medico']?>">
<select name="id_servicio" id="id_servicio">
<option value="0">-Seleccione una-</option>
<?php
	foreach($servicios as $dat){
		echo '<option value="'.$dat['id_servicio'].'">'.$dat['nombre_servicio'].'</option>';
	}
?>
</select>
</td>
</tr>
<tr><td align="center" colspan="2">

<?
$data = array(	'name' => 'bv',
				'onclick' => 'asignar_medico()',
				'value' => 'Asignar',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>