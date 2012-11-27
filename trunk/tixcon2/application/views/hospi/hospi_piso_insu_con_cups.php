<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td><strong>Procedimiento:</strong>&nbsp;<?=$procedimiento?></td><td class="campo_centro">Pagador</td></tr>
</tr>
<tr><td><strong>Cantidad:</strong>&nbsp;<?=$cantidadCups?></td>
<td rowspan="2">
<input name="factura_cups<?=$tipo?><?=$id?>" type="radio" checked="checked" value="Contrato" onchange="actualizarCupsPagador('<?=$tipo?>','<?=$id?>','Contrato')" />&nbsp;Contrato<br />
<input name="factura_cups<?=$tipo?><?=$id?>" type="radio" value="Evento" onchange="actualizarCupsPagador('<?=$tipo?>','<?=$id?>','Evento')"/>&nbsp;Evento
</td></tr>
</tr>
<tr><td><strong>Observaciones:</strong>&nbsp;<?=$observacionesCups?></td></tr>
</table>