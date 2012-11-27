<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="c<?=$marca?>">
<tr>
<td rowspan="2" align="center" width="15%">
<?php
echo form_hidden('id_cuidado_[]',$id_cuidado);
echo form_hidden('frecuencia_cuidado_[]',$frecuencia_cuidado);
echo form_hidden('id_frecuencia_cuidado_[]',$id_frecuencia_cuidado);
?>
<a href="#mosAgrCui" onclick="eliminarCuidado('c<?=$marca?>')">[Eliminar]</a></td>
<td><strong>Cuidado:</strong>&nbsp;<?=$cuidado?></td>
</tr>
<tr><td><strong>Frecuencia:</strong>&nbsp;<?="Cada ".$frecuencia_cuidado." ".$uni_frecuencia?></td></tr>
</table>