<?php
if($lista > 0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr><td colspan="7" class="campo_centro">Atenciones vigentes Urgencias</td></tr>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Numero documento</td>
<td class="campo_centro">Paciente</td>
<td class="campo_centro">Fecha y hora anexo</td>
<td class="campo_centro">Entidad</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro" colspan="2">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	
	foreach($lista as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['tipo_documento'].': '.$d['numero_documento']?></td>
<td><?=$d['paciente']?></td>
<td><?=$d['fecha_anexo']?></td>
<td><?=$d['razon_social']?></td>
<td><?=$d['nombre_servicio']?></td>
<td class="opcion"><a href="<?=site_url('auto/anexo3_consulta/consultarAnexo3/'.$d['id_anexo3'])?>"><strong>Consultar </strong></a></td></tr>
<?php
$i++;
	}
?>
</table>
<?php
}
?>