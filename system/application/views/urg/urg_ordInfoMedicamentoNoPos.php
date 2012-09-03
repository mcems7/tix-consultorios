<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="m<?=$marca?>">
<tr>
<td class="campo_centro">Eliminar</td>
<td class="campo_centro">Medicamento</td>
<td class="campo_centro">Dias tratamiento</td>
<td class="campo_centro">Dosis tratamiento</td>
<td class="campo_centro">Cantidad diaria</td>
</tr>
<tr>
<td rowspan="4" align="center">
<?php
echo form_hidden('atc_pos_[]',$atc_pos);
echo form_hidden('atcNoPos_[]',$atcNoPos);
echo form_hidden('dias_tratamientoPos_[]',$dias_tratamientoPos);
echo form_hidden('dosis_diariaPos_[]',$dosis_diariaPos);
echo form_hidden('cantidad_mesPos_[]',$cantidad_mes);
echo form_hidden('resp_clinica_[]',$resp_clinica);
echo form_hidden('resp_clinica_cual_[]',$resp_clinica_cual);
echo form_hidden('contraindicacion_[]',$contraindicacion);
echo form_hidden('contraindicacion_cual_[]',$contraindicacion_cual);
?>
<a href="#mosAgrMed" onclick="eliminarMedicamento('m<?=$marca?>')">[Eliminar]</a></td>
<td><?=$medicamento?></td>
<td align="center"><?=$dias_tratamientoPos?></td>
<td align="center"><?=$dosis_diariaPos?></td>
<td align="center"><?=$cantidad_mes?></td>
</tr>
<tr>
<td class="campo_centro">Respuesta clinica</td>
<td class="campo_centro">Cual</td>
<td class="campo_centro">Cantraindicación</td>
<td class="campo_centro">Cual</td>
</tr>
<tr>
<td align="center"><?=$resp_clinica?></td>
<td align="center"><?=$resp_clinica_cual?></td>
<td align="center"><?=$contraindicacion?></td>
<td align="center"><?=$contraindicacion_cual?></td>
</tr>
</table>