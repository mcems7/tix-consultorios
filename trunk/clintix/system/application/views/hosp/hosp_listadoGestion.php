<?php
$n = count($atencion);
if($n>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Número documento</td>
<td class="campo_centro">Nombres y apellidos</td>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro" colspan="2">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	
	foreach($atencion as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['numero_documento']?></td>
<td><?php echo $d['primer_apellido'],nbs(),$d['segundo_apellido'],nbs(),$d['primer_nombre'],nbs(),$d['segundo_nombre']?></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td class="opcion"><strong>
<?=anchor('hosp/hosp_gestion_atencion/main/'.$d['id_atencion'],'Gesti&oacute;n de la atenci&oacute;n');?></strong>
</td>
<?php
$i++;
	}
?>
<tr><td colspan="6" class="campo_centro">No se encontraron registros</td></tr>
</table>
<?php
}
?>
