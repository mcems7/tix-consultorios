<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="m<?=$marca?>">
<tr>
<td class="campo_centro">Eliminar</td>
<td class="campo_centro">Medicamento</td>
<td class="campo_centro">Dosis</td>
<td class="campo_centro">Unidad</td>
<td class="campo_centro">Frecuencia</td>
<td class="campo_centro">Vía</td>
</tr>
<tr>
<td rowspan="2" align="center">
<?php
echo form_hidden('atc_[]',$atc);
echo form_hidden('dosis_[]',$dosis);
echo form_hidden('id_unidad_[]',$id_unidad);
echo form_hidden('frecuencia_[]',$frecuencia);
echo form_hidden('id_frecuencia_[]',$id_frecuencia);
echo form_hidden('id_via_[]',$id_via);
echo form_hidden('observacionesMed_[]',$observacionesMed);
echo form_hidden('pos_[]',$pos);
?>
<a href="#mosAgrMed" onclick="eliminarMedicamento('m<?=$marca?>')">[Eliminar]</a></td>
<td><?=$medicamento?></td>
<td align="center"><?=$dosis?></td>
<td align="center"><?=$unidad?></td>
<td align="center"><?="Cada ".$frecuencia." ".$uni_frecuencia?></td>
<td align="center"><?=$via?></td>
</tr>
<tr><td colspan="5"><strong>Observaciones:</strong>&nbsp;<?=$observacionesMed?></td></tr>
</table>