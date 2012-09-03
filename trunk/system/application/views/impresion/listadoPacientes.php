<?php
if(!is_null($listaUrg))
{
?>
<table style="width:100%" class="tabla_form">
<tr><th colspan="5">Pacientes registrados</th></tr>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Nombre del paciente</td>
<td class="campo_centro">Identificaci&oacute;n</td>
<td class="campo_centro">Fecha de nacimiento</td>
<td class="campo_centro">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	foreach($listaUrg as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['primer_nombre'].' '.$d['segundo_nombre'].' '.$d['primer_apellido'].' '.$d['segundo_apellido']?></td>
<td><?=$d['tipo_documento'].' '.$d['numero_documento']?></td>
<td><?=$d['fecha_nacimiento']?></td>
<td class="opcion"><a href="<?=site_url('impresion/impresion/atencionPaciente/'.$d['numero_documento'])?>"><strong>Ver atenciones</strong></a></td>
</tr>
<?php
$i++;
	}
}else{
?>
<tr><td colspan="5" class="campo_centro">No se encontraron registros de pacientes</td></tr>
</table>
<?php
}
?>