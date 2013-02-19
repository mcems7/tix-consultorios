<?=form_hidden('idInsu[]',$id);?>
<?=form_hidden('id_insumo[]',$id_insumo);?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td class="campo_centro" colspan="3">Insumo</td>
<td class="campo_centro">Cantidad</td>
<td class="campo_centro">Código interno</td>
</tr>
<tr>
<td align="center" colspan="3"><?=$insumo?></td>
<td align="center"><?=$cantidad?></td>
<td align="center"><?=$codigo_interno?></td>
</tr>
<tr>
<td>
<table border ='0' cellspacing="0" cellpadding="0">
<tr>
<td rowspan='2' class='campo'>Despacho:</td>
<td><?=form_radio('despacho'.$id, 'SI').br();?></td><td>Si</td></tr>
<tr><td><?=form_radio('despacho'.$id, 'NO',TRUE).br();?></td><td>No</td></tr>
</table>
</td>
<td class='campo_centro'>Cantidad despachada
<?=br().form_input(array('name' => 'cantidad_despachada[]',
                'id'=> 'cantidad_despachada[]',
                'maxlength' => '3',
        		'size'=> '3',
                'value' => $cantidad,
                'class'=>"fValidate['integer']"))?></td>
<td class='campo'>Observaciones despacho:</td>
<td colspan='2'>
<?=form_textarea(array('name' => 'observacion[]',
              'rows' => '3',
              'cols'=> '30'))?></td>
</tr>
<tr><td colspan="5"><strong>Observaciones:</strong>&nbsp;<?=$observaciones?></td></tr>

</table>

