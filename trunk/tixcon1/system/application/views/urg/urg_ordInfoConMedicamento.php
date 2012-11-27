<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td class="campo_centro">Medicamento</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Dosis</td>
<td class="campo_centro">Unidad</td>
<td class="campo_centro">Frecuencia</td>
<td class="campo_centro">Vía</td>
</tr>
<tr>
<td><?=$medicamento?></td>
<?php
	$estilo = '';
	if($estado == 'Suspendido'){
		$estilo = 'style="background-color:#F00; color:#FFF"';
	}else if($estado == 'Modificado'){
		$estilo = 'style="background-color:#FF0"';
	}
?>
<td align="center" <?=$estilo?>><strong><?=$estado?></strong></td>
<td align="center"><?=$dosis?></td>
<td align="center"><?=$unidad?></td>
<td align="center"><?="Cada ".$frecuencia." ".$uni_frecuencia?></td>
<td align="center"><?=$via?></td>
</tr>
<tr><td colspan="6"><strong>Observaciones:</strong>&nbsp;<?=$observacionesMed?></td></tr>
</table>