<table widtd="100%" cellpadding="5" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora de llegada</td>
<td class="campo_centro">Nombre e identificación del paciente</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Medico</td>
<td class="campo_centro">TRIAGE</td>
<td class="campo_centro">Admisi&oacute;n</td>
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
<td>
<a href="#" onclick="admisionPaciente('<?=$d['id_atencion']?>')" class="vpaciente"><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></a><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?></td>
<td align="center"><?=$d['nombre_servicio'];?></td>
<td align="center"><?=$d['estado'];?>	</td>
<td>
<?php
if($d['consulta'] == 'SI')
{
	$med = $this->urgencias_model->obtenerMedico($d['id_medico_consulta']);
	echo $med['primer_apellido']." ".$med['segundo_apellido']." ".$med['primer_nombre']." ".$med['segundo_nombre'];
}else{
		echo '<center><strong>Sin asignar</strong></center>';
}
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
<td class="<?=$clase?>"><span class="listado_triage_numero"><?=$d['clasificacion']?></span><br><?=$d['motivo_consulta']?></td>
<td style="text-align:center"><strong><?=$d['admision']?></strong></td>
</tr>	
<?php
$i++;
	}
}else{
?>
<tr><td colspan="8" align="center">No hay pacientes que cumplan con los creiterios seleccionados</td></tr>
<?php
}
?>
</table>
