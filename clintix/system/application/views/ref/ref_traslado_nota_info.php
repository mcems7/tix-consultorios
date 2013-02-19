<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td class="campo_centro" width="14%">Fecha y hora</td>
<td class="campo_centro" width="12%">Tipo nota</td>
<td class="campo_centro" width="30%">Responsable</td>
<td class="campo_centro" width="44%">Nota</td>
</tr>
<?php
$u  = $this->ref_model->obtenerUsuario($nota['id_usuario']);
?>
<tr>
<td><?=$nota['fecha_nota']?></td>
<td class="campo_centro"><?=$nota['tipo_nota']?></td>
<td><?=$u['usuario']?></td>
<td><?=$nota['nota']?></td>
</tr>
</table>