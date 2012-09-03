<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="p<?=$marca?>">
<tr>
<td rowspan="3" align="center" width="15%">
<?php
echo form_hidden('cups_[]',$cups);
echo form_hidden('observacionesCups_[]',$observacionesCups);
?>
<a href="#mosAgrPro" onclick="eliminarCups('p<?=$marca?>')">[Eliminar]</a></td>
<td><strong>Procedimiento:</strong>&nbsp;<?=$procedimiento?></td>
</tr>
<tr><td><strong>Cantidad:</strong>&nbsp;<?=form_input(array('name' => 'cantidadCups_[]',
							'id'=> 'cantidadCups_[]',
							'maxlength' => '5',
							'size'=> '5',
							'value' => $cantidadCups,
							'class'=>"fValidate['integer']"))?></td></tr>
<tr><td><strong>Observaciones:</strong>&nbsp;<?=$observacionesCups?></td></tr>
</table>