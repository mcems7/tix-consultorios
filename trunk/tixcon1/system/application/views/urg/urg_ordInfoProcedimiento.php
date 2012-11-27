<?php
$marca =mt_rand();
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="p<?=$marca?>">
<tr>
<td rowspan="4" align="center" width="15%">
<?php
echo form_hidden('cups_[]',$cups);
echo form_hidden('observacionesCups_[]',$observacionesCups);
echo form_hidden('cantidadCups_[]',$cantidadCups);
if(isset ($frecuencia)){
echo form_hidden('periocidad_[]',$frecuencia);
echo form_hidden('periocidad_lab_[]',$frecuencia_lab);

}

?>
<a href="#mosAgrPro" onclick="eliminarCups('p<?=$marca?>')">[Eliminar]</a></td>
<td><strong>Procedimiento:</strong>&nbsp;<?=$procedimiento?></td>
</tr>
<tr><td><strong>Cantidad:</strong>&nbsp;<?=$cantidadCups?></td></tr>
<tr><td><strong>Observaciones:</strong>&nbsp;<?=$observacionesCups?></td></tr>
<?php
if(isset ($frecuencia)){
	
	?>
<tr><td><strong>Frecuencia:</strong> Cada <?=$frecuencia_lab?>&nbsp;<?=$frecuencia?></td></tr>

<?php
}
?>
</table>
