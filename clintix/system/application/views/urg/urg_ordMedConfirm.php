<?=form_hidden('verificado','SI')?>
<?=form_hidden('id_medico_verifica',$med['id_medico'])?>
<?=form_hidden('fecha_verificado',date('Y-m-d H:i:s'))?>
<table width="100%" cellspacing="0" cellpadding="0">
<tr><td colspan="2" class="campo_centro">Medico que confirma el ordenamiento</td></tr>
<tr>
<td class="campo" width="40%">Apellidos:</td>
<td width="60%"><?=$med['primer_apellido']." ".$med['segundo_apellido']?></td>
</tr>
<tr>
<td class="campo">Nombres:</td>
<td><?=$med['primer_nombre']." ".$med['segundo_nombre']?></td>
</tr>
<tr>
<td class="campo">Tarjeta profesional:</td>
<td><?=$med['tarjeta_profesional']?></td>
</tr>
</table>