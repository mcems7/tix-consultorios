<?php
	$ca1 = 'width="20%"';
	$ca2 = 'width="80%"';
?>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro" colspan="2">Detalle de la evolución</td></tr>
<tr><td class="campo" <?=$ca1?>>Fecha y hora:</td><td <?=$ca2?>><?=$evo['fecha_evolucion']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Medico:</td><td <?=$ca2?>><?=$evo['primer_apellido']." ".$evo['segundo_apellido']." ".$evo['primer_nombre']." ".$evo['segundo_nombre']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Especialidad:</td><td <?=$ca2?>><?=$evo['esp']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Tipo evolución:</td><td <?=$ca2?>><?=$evo['tipo_evolucion']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Subjetivo:</td><td <?=$ca2?>><?=$evo['subjetivo']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Objetivo:</td><td <?=$ca2?>><?=$evo['objetivo']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Análisis:</td><td <?=$ca2?>><?=$evo['analisis']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Conducta:</td><td <?=$ca2?>><?=$evo['conducta']?></td></tr>
<?php
$i = 1;
if(count($dxEvo) > 0)
{
foreach($dxEvo as $d)
{
?>
<tr><td class="campo">Diagnostico <?=$i?>:</td><td>
<?php
	echo '<strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'];
?>
</td></tr>
<?php
$i++;
}
}else{
?>
<tr><td class="campo_centro" colspan="2">No hay diagnosticos asociados a la evolución</td></tr>
<?php
}
?>
<tr><td align="center" colspan="2"><?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/hospi_impresion/consultaEvolucion/'.$evo['id_evolucion'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?></td></tr>
<tr><td class="linea_azul" colspan="2"></td></tr>
</table>

</center>
