<?php
if($lista > 0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora</td>
<td class="campo_centro">Medico entrega</td>
<td class="campo_centro">Medico recibe</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	
	foreach($lista as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_hora_entrega']?></td>
<td><?=$d['medico_entrega']?></td>
<td><?=$d['medico_recibe']?></td>
<td><?=$d['nombre_servicio']?></td>
<td class="opcion"><strong>
<?php
echo anchor('urg/consulta_entrega_turno/entrega_turno_consulta/'.$d['id_entrega'],'Consultar');
?></strong>
</td>
<?php
$i++;
	}

}else{
?>
<tr><td colspan="7" class="campo_centro">No se encontraron registros</td></tr>
</table>
<?php
}
?>
