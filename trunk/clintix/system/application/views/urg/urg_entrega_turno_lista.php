<?php
echo form_hidden('id_servicio',$id_servicio);
?>
<table width="100%" class="tabla_interna" cellpadding="5">
<tr>
<td class='campo_centro'></td>
<td class='campo_centro'>Cama</td>
<td class='campo_centro'>Nombre e identificación</td>
<td class='campo_centro'>Diagnosticos</td>
</tr>
<?php
if($lista != 0)
{
	foreach($lista as $d)
	{
?>
<tr class="fila">
<td><input name="seleccion[]" id"seleccion[]" type="checkbox" value="<?=$d['id_atencion']?>" /></td>
<td align="center"><?=$d['numero_cama']?></td>
<td>
<?=$d['primer_nombre'].' '.$d['segundo_nombre'].' '.$d['primer_apellido'].' '.$d['segundo_apellido'].br()?>
<?=$d['tipo_documento'].' '.$d['numero_documento']?> 
 </td>
<?php
$consulta = $this->urgencias_model->obtenerConsulta($d['id_atencion']);
$dx_con = $this->urgencias_model->obtenerDxConsulta($consulta['id_consulta']);
$dx_evo = $this->urgencias_model->obtenerDxEvoluciones($d['id_atencion']);
?>
<td>
<?php
if(count($dx_con) > 0)
{
	foreach($dx_con as $dat)
	{

		echo '<li><strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'</li>';

	}
}
?>
<?php
if(count($dx_evo) > 0)
{
	foreach($dx_evo as $dat)
	{

		echo '<li><strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'</li>';

	}
}
?>
</td>
</tr>	
<?php
	}
}else{
?>
<tr><td colspan="6" align="center">No hay pacientes en la sala de espera</td></tr>
<?php
}
?>
</table>
