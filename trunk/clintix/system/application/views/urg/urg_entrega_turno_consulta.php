<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){	 
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Entrega de turno</h2>
<center>
<table width="98%" class="tabla_form">
<tr><th colspan="2">Listado pacientes a entregar</th></tr>
<tr><td>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td class="campo" width="30%">Médico que entrega:</td>
<td width="70%"><?=$entrega['medico_entrega']?></td></tr>
<td class="campo">Médico que recibe:</td>
<td><?=$entrega['medico_recibe']?></td></tr>
<tr><td class="campo">Fecha y hora de entrega:</td><td><?=$entrega['fecha_hora_entrega']?></td></tr></table>
<?php
if($entrega_detalle != 0)
{
foreach($entrega_detalle as $dato)
{
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td colspan="2"><strong>Cama:</strong><?=nbs().$dato['numero_cama'].nbs(3)?>
<strong>Nombre e identificación:</strong><?=nbs().$dato['paciente']?>
<?=nbs(3).$dato['tipo_documento'].' '.$dato['numero_documento'].nbs()."<strong>EH:</strong>".nbs().$this->urgencias_model->obtenerTiempoEstancia($dato['id_atencion'],$entrega['fecha_hora_entrega'])?>H</td>
</tr>
<tr>
<td class='campo_centro' colspan="2">Diagnosticos</td></tr>
<tr>
<?php
$consulta = $this->urgencias_model->obtenerConsulta($dato['id_atencion']);
$dx_con = $this->urgencias_model->obtenerDxConsulta($consulta['id_consulta']);
$dx_evo = $this->urgencias_model->obtenerDxEvoluciones($dato['id_atencion']);
?>
<td colspan="2">
<?php
if(count($dx_con) > 0)
{
	foreach($dx_con as $dat)
	{

		echo ' - <strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'<br />';

	}
}
?>
<?php
if(count($dx_evo) > 0)
{
	foreach($dx_evo as $dat)
	{

		echo ' - <strong>'.$dat['id_diag'].'</strong> '.$dat['diagnostico'] ,'<br />';

	}
}
?>
</td>
</tr>
<tr>
<td colspan="2"><strong>Especialidad:</strong>&nbsp;<?=$dato['espe']?>
</td>
</tr>
<tr>
<td width="50%" class='campo_centro'>Pendiente</td>
<td width="50%" class='campo_centro'>Observaciones</td>
<tr>
<td width="50%"><?=$dato['pendiente']?></td><td><?=$dato['observaciones']?></td>
</tr>
</table>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td class="linea_azul"></td></tr></table> 
<?php
}
}else{
	echo br(3);
?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr><td class="campo_centro">NO SE HAN SELECCIONADO PACIENTES A ENTREGAR</td></tr></table> 
<?php
}
?>
</td>
</tr>
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data).nbs();
if($entrega_detalle != 0)
{
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('urg/entrega_turno/entrega_turno_imp/'.$entrega['id_entrega'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
}
?>
</td></tr>
</table>
