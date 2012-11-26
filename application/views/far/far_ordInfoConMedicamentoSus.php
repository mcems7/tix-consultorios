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
<td align="center">
<?=$medicamento?></td>
<td align="center" style="background-color:#F00; color:#FFF"><strong><?=$estado?></strong></td>
<td align="center"><?=$dosis?></td>
<td align="center"><?=$unidad?></td>
<td align="center"><?="Cada ".$frecuencia." ".$uni_frecuencia?></td>
<td align="center"><?=$via?></td>
</tr>
<tr><td colspan="6"><strong>Observaciones:</strong>&nbsp;<?=$observacionesMed?></td></tr>
<tr><td colspan="6">
<?php
if($estado != 'Nuevo')
{
?>
<span class="texto_barra_med">
<a href="#div_<?=$atc?>" onclick="consultaMedi('<?=$atc?>')" title="Ver historial del medicamento">
Ver historial del medicamento
<img src="<?=base_url()?>resources/img/triangulo.png"/></a></span>
<?php
}
?>
</td></tr>
<tr><td colspan="6" id="div_<?=$atc?>">
</td></tr>
</table>