<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="dx<?=$marca?>">
<tr>
<td class="campo_centro" width="15%">Eliminar</td>
<td class="campo_centro" width="65%">Diagnóstico</td>
<td class="campo_centro" width="20%">Tipo diagnóstico</td>
</tr>
<tr>
<td rowspan="2" align="center">
<?php
echo form_hidden('dx_ID_[]',$dx_ID);
echo form_hidden('tipo_dx_[]',$tipo_dx);
?>
<a href="#mosAgrMed" onclick="eliminarDx('dx<?=$marca?>')">[Eliminar]</a></td>
<td><?=$dx?></td>
<td><?php
switch ($tipo_dx) {
    case 1:
        $tipodx = "Impresión diagnóstica";
        break;
    case 2:
        $tipodx = "Confirmado nuevo";
        break;
    case 3:
        $tipodx = "Confirmado repetido";
        break;
}

echo $tipodx;
?></td>
</tr>
</table>