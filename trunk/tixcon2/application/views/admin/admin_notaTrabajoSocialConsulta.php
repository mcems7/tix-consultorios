<?php
	$ca1 = 'width="20%"';
	$ca2 = 'width="80%"';
?>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro" colspan="2">Detalle de la nota de trabajo social</td></tr>
<tr><td class="campo" <?=$ca1?>>Fecha y hora:</td><td <?=$ca2?>><?=$nota['fecha_nota']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Funcionario:</td><td <?=$ca2?>><?=$nota['primer_apellido']." ".$nota['segundo_apellido']." ".$nota['primer_nombre']." ".$nota['segundo_nombre']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Titulo:</td><td <?=$ca2?>><?=$nota['titulo_nota']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Nota de trabajo social:</td><td <?=$ca2?>><?=$nota['nota']?></td></tr>
<tr><td align="center" colspan="2"><?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresion/consultaEvolucion/'.$nota['id_nota'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?></td></tr>
<tr><td class="linea_azul" colspan="2"></td></tr>
</table>

</center>
