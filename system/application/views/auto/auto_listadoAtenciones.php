<?php
$nlistaHosp = count($listaHosp);
$nlistaUrg = count($listaUrg);
if($nlistaUrg>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr><td colspan="6" class="campo_centro">Atenciones vigentes Urgencias</td></tr>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Numero documento</td>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro" colspan="2">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	
	foreach($listaUrg as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$numero_documento?></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td class="opcion"><a href="<?=site_url('auto/anexo3/crearAnexo3/'.$d['id_atencion'])?>"><strong>Generar Anexo T&eacute;cnico 3</strong></a></td></tr>
<?php
$i++;
	}
?>
</table>
<?php
}
?>

<br />
<br />
<?php

if($nlistaHosp>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr><td colspan="5" class="campo_centro">Atenciones vigentes Hospitalización</td></tr>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Numero documento</td>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	
	foreach($listaHosp as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$numero_documento?></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td class="opcion"><a href="<?=site_url('auto/anexo3/anexo3Hosp/'.$d['id_atencion'])?>"><strong>Generar Anexo T&eacute;cnico 3</strong></a></td></tr>

<?php
$i++;
	}
?>
</table>
<?php
}
if($nlistaHosp == 0 && $nlistaUrg == 0){
?>
<center><strong>No se encontraron atenciones activas en el sistema</strong></center>
<?php
}
?>
