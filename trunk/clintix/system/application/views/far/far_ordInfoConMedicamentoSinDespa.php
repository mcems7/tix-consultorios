<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td class="campo_centro">Medicamento</td>
<td class="campo_centro">Dosis</td>
<td class="campo_centro">Unidad</td>
<td class="campo_centro">Frecuencia</td>
<td class="campo_centro">Vía</td>
</tr>
<tr>
<td align="center">
<?=$medicamento?></td>
<td align="center"><?=$cantidadMed?></td>
<td align="center"><?=$unidad?></td>
<td align="center"><?="Cada ".$frecuencia." ".$uni_frecuencia?></td>
<td align="center"><?=$via?></td>
</tr>

<tr>
<td>
<table border ='0' cellspacing="0" cellpadding="0">
<tr>
<td class='campo'>Despacho:</td>
<td><?=$despachoMed?></td></tr>
</table>
</td>
<td colspan='2' class='campo'>Observaciones despacho:</td>
<td colspan='2'>
<?=$observacionMed?></td>
</tr>
<tr><td colspan="5"><strong>Observaciones:</strong>&nbsp;<?=$observacionesMed?></td></tr>

</table>

