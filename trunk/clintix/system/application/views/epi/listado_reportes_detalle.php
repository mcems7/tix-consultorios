<table style="width:100%" class="tabla_interna">
<?php
if($lista != 0)
{
?>
<tr>
<td class="campo_centro">Fecha y hora reporte</td>
<td class="campo_centro">Nombres y apellidos paciente</td>
<td class="campo_centro">Diagnostico</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro" colspan="3">Operaciones</td>
</tr>
<?php
	
	foreach($lista as $d)
	{
		
?>
<tr>
<td><?=$d['fecha']?></td>
<td><?=$d['paciente']?></td>
<td><?=$d['dx']?></td>
<td><?=$d['estado']?></td>
<td class="opcion">
<a href="#" onclick="Abrir_ventana('<?=site_url('epi/main/consulta_caso/'.$d['id_reporte'])?>')">Resumen</a>
</td>
<td class="opcion">
<a href="<?=site_url('hce/main/consultarAtencion/'.$d['id_atencion'])?>" target="_blank">Ver atención</a>
</td>
<td class="opcion">
<?php
	if($d['estado'] == 'Activo')
	{
?>
<a href="#"  onclick="inactivarCaso('<?=$d['id_reporte']?>')">Inactivar</a>
<?php
	}else{
?>
<a href="#"  onclick="activarCaso('<?=$d['id_reporte']?>')">Activar</a>
<?php
	}
?>
</td>
<?php
	}

}else{
?>
<tr><td class="campo_centro">No se encontraron registros</td></tr>
<?php
}
?>
</table>
