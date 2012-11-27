<?=form_hidden('atc[]',$atc);?>
<?=form_hidden('idMed[]',$id);?>
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
<td align="center"><?=$medicamento?></td>
<?php
	if($estado == "Modificado"){
?>
<td align="center" style="background-color:#FF0;"><strong><?=$estado?></strong></td>
<?php
	}else{
?>
<td align="center"><strong><?=$estado?></strong></td>
<?php
	}
?>
<td align="center"><?=$dosis?></td>
<td align="center"><?=$unidad?></td>
<td align="center"><?="Cada ".$frecuencia." ".$uni_frecuencia?></td>
<td align="center"><?=$via?></td>
</tr>
<tr>
<td class="campo_centro">Cantidad Despachada</td>
<td class="campo_centro" colspan='5'>Elemento Despachado</td>
</tr>
<tr>
<td align="center"><?=form_input(array('name' => 'cantidadMed[]',
                'id'=> 'cantidadMed[]',
                'maxlength' => '3',
        'size'=> '3',
                'value' => $dosis,
                'class'=>"fValidate['required']"))?></td></td>
<td align="center" colspan='5'>
<?php
  $res = $this->farmacia_model->obtMediPrincipioActivo($principio_activo);
?>
<select name="atc_despa[]" id="atc_despa[]">
<?
  foreach($res as $d)
  {   
    if($atc == $d['atc_full']){
    echo '<option value="'.$d['atc_full'].'" selected="selected">'.$d['principio_activo'].nbs().$d['descripcion'].'</option>';
    }else{
    echo '<option value="'.$d['atc_full'].'">'.$d['principio_activo'].nbs().$d['descripcion'].'</option>';
    }
  }
?>
</select>

</td></td>
</tr>
<tr>
<td>
<table border ='0' cellspacing="0" cellpadding="0">
<tr>
<td rowspan='3' class='campo'>Despacho:</td>
<td><?=form_radio('despachoMed'.$id, 'Total').br();?></td><td>Total</td></tr>
<tr><td><?=form_radio('despachoMed'.$id, 'Parcial').br();?></td><td>Parcial</td></tr>
<tr><td><?=form_radio('despachoMed'.$id, 'Sin despacho',TRUE).br();?></td><td>Sin despacho</td></tr>
</table>
</td>
<td colspan='2' class='campo'>Observaciones despacho:</td>
<td colspan='3'>
<?=form_textarea(array('name' => 'observacionMed[]',
              'rows' => '3',
              'cols'=> '30'))?></td>
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

