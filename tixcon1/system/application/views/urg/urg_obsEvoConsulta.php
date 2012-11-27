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
<tr><td align="center" colspan="2"><?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data).nbs();
?></td></tr>
<tr><td class="linea_azul" colspan="2"></td></tr>
</table>
</center>