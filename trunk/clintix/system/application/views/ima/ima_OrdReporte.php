<?=form_hidden('cups[]',$cups);?>
<?=form_hidden('idIma[]',$id);?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
  
  <tr>
    <td width="100" class="campo_centro">Codigo</td>
    <td colspan="3"class="campo_centro">Examen</td>
  </tr>
  <tr>
    <td align="center"><?=$cups?></td>
    <td colspan="3" align="center"><?=$desc_subcategoria?></td>
   
  </tr>
  <tr>
    <td class="campo_centro">Observaciones:</td>
    <td class="campo_centro" colspan='4'><?=$observacionesCups?></td>
  </tr>
  
  <tr>
    <td class="campo_centro">Realizado:</td>
    <td width="340" class="campo_centro">Si<?=form_radio('realiza'.$id,'SI').br();?>No<?=form_radio('realiza'.$id, 'NO',TRUE).br();?></td>
    <td width="173" class="campo_centro">Motivo:</td>
    <td colspan='2' class="campo_centro"><?=form_textarea(array('name' => 'razon[]',
                                                                'rows' => '3',
                                                                'cols'=> '30'))?></td>
  </tr>
    <tr>
    <td class="campo_centro">Informe:</td>
    <td colspan='3' class="campo_centro"><?=form_textarea(array('name' => 'informe',
                                                                'rows' => '15',
                                                                'cols'=> '30'))?></td>
  </tr>
</table>

  