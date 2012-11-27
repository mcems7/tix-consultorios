<?php
$marca = mt_rand();
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td class="campo_centro">Operaci&oacute;n</td>
<td class="campo_centro">Medicamento</td>
<td class="campo_centro">Dosis</td>
<td class="campo_centro">Unidad</td>
<td class="campo_centro">Frecuencia</td>
<td class="campo_centro">Vía</td>
</tr>
<tr>
<?php
echo form_hidden('id_[]',$id);
echo form_hidden('atc_[]',$atc);
echo form_hidden('dosis_[]',$dosis);
echo form_hidden('id_unidad_[]',$id_unidad);
echo form_hidden('frecuencia_[]',$frecuencia);
echo form_hidden('id_frecuencia_[]',$id_frecuencia);
echo form_hidden('id_via_[]',$id_via);
echo form_hidden('observacionesMed_[]',$observacionesMed);
echo form_hidden('pos_[]',$pos);
?>
<td rowspan="2">
  <table border="0" cellpadding="0" cellspacing="0" id="tmc<?=$marca?>">
    <tr>
      <td style="width:2px">
      <?=form_hidden('bandera[]',$bandera);?>
        <input type="radio" name="opcionMed<?=$id?>" value="Continuar" id="opcionMed_0" checked="checked" onchange="modificarMed('<?=$id?>','Continuar','<?=$marca?>')"/>
        </td><td>Continuar</td>
    </tr>
    <tr>
      <td>
        <input type="radio" name="opcionMed<?=$id?>" value="Modificar" id="opcionMed_1" onchange="modificarMed('<?=$id?>','Modificar','<?=$marca?>')" />
        </td><td>Modificar</td>
    </tr>
    <tr>
      <td>
        <input type="radio" name="opcionMed<?=$id?>" value="Suspender" id="opcionMed_2" onchange="modificarMed('<?=$id?>','Suspender','<?=$marca?>')"/>
        </td><td>Suspender</td>
    </tr>
  </table></td>
<td><?=$medicamento?></td>
<td align="center"><?=$dosis?></td>
<td align="center"><?=$unidad?></td>
<td align="center"><?="Cada ".$frecuencia." ".$uni_frecuencia?></td>
<td align="center"><?=$via?></td>
</tr>
<tr><td colspan="5"><strong>Observaciones:</strong>&nbsp;<?=$observacionesMed?></td></tr>
</table>