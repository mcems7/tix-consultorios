<table width="100%" class="tabla_registro" cellpadding="2" cellspacing="2">
<tr>
<td class="campo_centro">Fecha asignación</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
foreach($servicios_asig as $data)
{
?>
<tr><td align="center">
<?=$data['fecha_asignacion']?>
</td>
<td align="center">
<?=$data['nombre_servicio']?>
</td>
<td class="opcion">
<a href="<?=site_url()?>/urg/evoluciones/main/<?=$data['id_asignacion']?>">Suspender</a>
</td>
</tr>
<?php
}
?>
</table>