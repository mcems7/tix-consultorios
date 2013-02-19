<?php
	$ca1 = 'width="20%"';
	$ca2 = 'width="80%"';
	
?>
<center>

<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro" colspan="2">Detalle de la evolución</td></tr>
<tr><td class="campo" <?=$ca1?>>Fecha y hora:</td><td <?=$ca2?>><?=$nota['fecha_nota']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Realiza la nota:</td><td <?=$ca2?>><?=$nota['primer_apellido']." ".$nota['segundo_apellido']." ".$nota['primer_nombre']." ".$nota['segundo_nombre']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Subjetivo:</td><td <?=$ca2?>><?=$nota['subjetivo']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Objetivo:</td><td <?=$ca2?>><?=$nota['objetivo']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Actividades:</td><td <?=$ca2?>><?=$nota['actividades']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Pendientes:</td><td <?=$ca2?>><?=$nota['pendientes']?></td></tr>
<tr><td align="center" colspan="2"><?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data);
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/hospi_impresion/consultaNotaEnfermeria/'.$nota['id_nota'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?></td></tr>
<tr><td class="linea_azul" colspan="2"></td></tr>

</table>

</center>
