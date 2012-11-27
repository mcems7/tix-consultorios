<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="p<?=$marca?>">
<tr>
<td rowspan="3" align="center" width="15%">
<?php
echo form_hidden('id_insumo_[]',$id_insumo);
echo form_hidden('cantidad_[]',$cantidad);
echo form_hidden('observaciones_[]',$observaciones);
echo form_hidden('pagador_[]',$pagador);
?>
<a href="#mosAgrPro" onclick="eliminarCups('p<?=$marca?>')">[Eliminar]</a></td>
<td><strong>Insumo:</strong>&nbsp;<?=$insumo?></td><td class="campo_centro">Pagador</td>
</tr>
<tr><td><strong>Cantidad:</strong>&nbsp;<?=$cantidad?></td>
<td rowspan="2" style="text-align:center"><?=$pagador?></td>
</tr>
<tr><td><strong>Observaciones:</strong>&nbsp;<?=$observaciones?></td></tr> 
</table>