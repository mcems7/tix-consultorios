<?php
$n = count($lista);
if($n>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora solicitud</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
	$i = 1;
	
	foreach($lista as $d)
	{
		$estilo = '';
		if($d['estado'] == 'Sin consultar')
			$estilo = 'style="background-color:#8080FF"';
?>
<tr <?=$estilo?>>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_solicitud']?></td>
<td><?=$d['nombre_servicio']?></td>
<td><?=$d['estado']?></td>
<td class="opcion"><a href="<?=site_url()?>/inter/main/consultaInterconsulta/<?=$d['id_interconsulta']?>"><strong>Consultar</strong></a></td>

<?php
$i++;
	}

}else{
?>
<tr><td colspan="4" class="campo_centro">No se encontraron registros</td></tr>
</table>
<?php
}
?>