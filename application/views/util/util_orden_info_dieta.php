<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="d<?=$marca?>">
<tr>
<td rowspan="2" align="center" width="15%">
<?php
echo form_hidden('id_dieta[]',$id_dieta);
?>
<a href="#mosAgrDie" onclick="eliminarDieta('d<?=$marca?>')">[Eliminar]</a></td>
<td><?=$dieta?></td>
</tr>
</table>