<?=form_hidden('id_atencion[]',$dato['id_atencion'])?>
<?php
//Verificar entregas del mismo paciente anteriores
$detalle = $this->urgencias_model->verificaPacienteEntregaTurno($dato['id_atencion']);
if($detalle != 0){
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td colspan="2"><strong>Cama:</strong><font size="+1"><?=nbs().$dato['numero_cama'].nbs(3)?></font>
<strong>Nombre e identificación:</strong><?=nbs().$dato['primer_nombre'].' '.$dato['segundo_nombre'].' '.$dato['primer_apellido'].' '.$dato['segundo_apellido']?>
<?=nbs(3).$dato['tipo_documento'].' '.$dato['numero_documento']?></td>
</tr>
<tr>
<td class='campo_centro' colspan="2">Diagnosticos</td></tr>
<tr>
<?php
$consulta = $this->urgencias_model->obtenerConsulta($dato['id_atencion']);
$dx_con = $this->urgencias_model->obtenerDxConsulta($consulta['id_consulta']);
$dx_evo = $this->urgencias_model->obtenerDxEvoluciones($dato['id_atencion']);
?>
<td colspan="2">
<?php
if(count($dx_con) > 0)
{
	foreach($dx_con as $dat)
	{

		echo ' - <strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'<br />';

	}
}
?>
<?php
if(count($dx_evo) > 0)
{
	foreach($dx_evo as $dat)
	{

		echo ' - <strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'<br />';

	}
}
?>
</td>
</tr>
<tr>
<td colspan="2"><strong>Especialidad:</strong>&nbsp;
<select name="id_especialidad[]" id="id_especialidad[]">
 <?php
 	foreach($especialidades as $d)
	{
		if($detalle['id_especialidad'] == $d['id_especialidad']){	
			echo '<option value="'.$d['id_especialidad'].'" selected="selected">'.$d['descripcion'].'</option>';	
		}else{
			echo '<option value="'.$d['id_especialidad'].'">'.$d['descripcion'].'</option>';
		}
	}
 ?>
</select>
</td>
</tr>
<tr>
<td width="50%" class='campo_centro'>Pendiente</td>
<td width="50%" class='campo_centro'>Observaciones</td>
<tr>
<td width="50%">
<?=form_textarea(array('name' => 'pendiente[]',
						'id'=> 'pendiente[]',
						'value' => $detalle['pendiente'],
						'rows' => '3',
						'style'=> 'width:100%'))?></td>
                        <td width="50%"><?=form_textarea(array('name' => 'observaciones[]',
						'id'=> 'observaciones[]',
						'value' => $detalle['observaciones'],
						'rows' => '3',
						'style'=> 'width:100%'))?></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td class="linea_azul"></td></tr></table>  
<?php
}else{
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td colspan="2"><strong>Cama:</strong><font size="+1"><?=nbs().$dato['numero_cama'].nbs(3)?></font>
<strong>Nombre e identificación:</strong><?=nbs().$dato['primer_nombre'].' '.$dato['segundo_nombre'].' '.$dato['primer_apellido'].' '.$dato['segundo_apellido']?>
<?=nbs(3).$dato['tipo_documento'].' '.$dato['numero_documento']?></td>
</tr>
<tr>
<td class='campo_centro' colspan="2">Diagnosticos</td></tr>
<tr>
<?php
$consulta = $this->urgencias_model->obtenerConsulta($dato['id_atencion']);
$dx_con = $this->urgencias_model->obtenerDxConsulta($consulta['id_consulta']);
$dx_evo = $this->urgencias_model->obtenerDxEvoluciones($dato['id_atencion']);
?>
<td colspan="2">
<?php
if(count($dx_con) > 0)
{
	foreach($dx_con as $dat)
	{

		echo ' - <strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'<br />';

	}
}
?>
<?php
if(count($dx_evo) > 0)
{
	foreach($dx_evo as $dat)
	{

		echo ' - <strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'<br />';

	}
}
?>
</td>
</tr>
<tr>
<td colspan="2"><strong>Especialidad:</strong>&nbsp;
<select name="id_especialidad[]" id="id_especialidad[]">
  <option value="0">-Seleccione uno-</option>
 <?php
 	foreach($especialidades as $d)
	{
		echo '<option value="'.$d['id_especialidad'].'">'.$d['descripcion'].'</option>';	
	}
 ?>
</select>
</td>
</tr>
<tr>
<td width="50%" class='campo_centro'>Pendiente</td>
<td width="50%" class='campo_centro'>Observaciones</td>
<tr>
<td width="50%">
<?=form_textarea(array('name' => 'pendiente[]',
						'id'=> 'pendiente[]',
						'rows' => '3',
						'style'=> 'width:100%'))?></td>
                        <td width="50%"><?=form_textarea(array('name' => 'observaciones[]',
						'id'=> 'observaciones[]',
						'rows' => '3',
						'style'=> 'width:100%'))?></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td class="linea_azul"></td></tr></table>  
<?php
}
?>