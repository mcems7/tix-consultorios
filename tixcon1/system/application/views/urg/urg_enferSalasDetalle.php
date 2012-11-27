<table width="100%" class="tabla_interna" cellpadding="5">
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora de llegada</td>
<td class="campo_centro">Nombre e identificación del paciente</td>
<td class="campo_centro">Estado / especialista</td>
<td class="campo_centro">Clasificaci&oacute;n TRIAGE</td>
</tr>
<?php
$n = count($lista);
if($n>0)
{
	$i = 1;
	foreach($lista as $d)
	{
?>
<tr class="fila">
<td align="center"><strong><?=$i?></strong></td>
<td>	
<?=$d['fecha_ingreso']?>
</td>
<td><strong><?=anchor('urg/enfermeria/main/'.$d['id_atencion'],$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre'])?></strong><?=br()?>
<?=$d['tipo_documento'].": ".$d['numero_documento']?><br />
 Edad:&nbsp;<?=$this->lib_edad->edad($d['fecha_nacimiento'])?></td>
<td align="center">
<?php
	$med = $this->urgencias_model->obtenerMedico($d['id_medico_consulta']);
	echo $d['estado']."<br/>".$med['primer_apellido']." ".$med['segundo_apellido']." ".$med['primer_nombre']." ".$med['segundo_nombre'];
?>
</td>
<?php 
$clase = '';
if($d['clasificacion'] == 1 ){
	$clase = 'listado_triage_1';
}else if($d['clasificacion'] == 2){
	$clase = 'listado_triage_2';
}else if($d['clasificacion'] == 3){
	$clase = 'listado_triage_3';
}
?>
<td class="<?=$clase?>"><span class="listado_triage_numero"><?=$d['clasificacion']?></span><br /><?=$d['motivo_consulta']?></td>

</tr>	
<?php
$i++;
	}
}else{
?>
<tr><td colspan="6" align="center">No hay pacientes en la sala de espera</td></tr>
<?php
}
?>
</table>
