<table width="100%" class="tabla_interna" cellpadding="5">
<tr>
<td class='campo_centro'>Consultorio</td>
<td class='campo_centro'>Hora</td>
<td class='campo_centro'>Paciente</td>
<td class='campo_centro'>Medico</td>
<td class='campo_centro'>Estado</td>
<td class='campo_centro'>Opciones</td>
</tr>
<?php
if($citas != 0)
{
	$i = 1;
	foreach($citas as $d)
	{

$imgadm = array('src' => 'resources/images/accept.png','alt' => 'Confirmar paciente','title' => 'Confirmar paciente');
$imgcan = array('src' => 'resources/images/delete.png','alt' => 'Cancelar cita','title' => 'Cancelar cita');
?>
<tr class="fila">
<td><?=$d['consultorio']?></td>
<td><?=date("H:i",$d['hora'])?></td>
<td><strong><?=$d['paciente']?></strong></td>
<td><?=$d['medico']?></td>
<td align="center"><?=$d['estado']?></td>
<td align="center">
<a href="<?=site_url('coam/coam_admision/buscar_paciente_adm/'.$d['id_cita'])?>">
<?=img($imgadm)?></a>
<a href="#" onclick="no_responde('<?=$d['id_cita']?>')">
<?=img($imgcan)?></a></td>
</tr>	
<?php
$i++;
	}
}else{
?>
<tr><td colspan="6" align="center">No hay pacientes en la sala de espera del consultorio</td></tr>
<?php
}
?>
</table>