<?php
$marca = md5(mt_rand());
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro" id="dx<?=$marca?>">
<tr>
<td class="campo_centro" width="15%">Eliminar</td>
<td class="campo_centro" width="60%">Diagnóstico</td>
<td class="campo_centro" width="25%">Tipo diagnóstico</td>
</tr>
<tr>
<td rowspan="2" align="center">
<?php
echo form_hidden('dx_ID_[]',$dx_ID);
echo form_hidden('tipo_dx_[]',$tipo_dx);
echo form_hidden('orden_dx_[]',$orden_dx);
?>
<a href="#mosAgrMed" onclick="eliminarDx('dx<?=$marca?>')">[Eliminar]</a></td>
<td><?=$dx?></td>
<td align="center"><?php
switch ($orden_dx) {
    case 0:
        $orden_dx = "Diagnóstico principal";
        break;
    case 1:
        $orden_dx = "Diagnóstico relacionado 1";
        break;
    case 2:
        $orden_dx = "Diagnóstico relacionado 2";
        break;
    case 3:
        $orden_dx = "Diagnóstico relacionado 3";
        break;
      case 4:
        $orden_dx = "Diagnóstico relacionado 4";
        break;
        case 5:
        $orden_dx = "Diagnóstico relacionado 5";
        break;
        case 6:
        $orden_dx = "Diagnóstico relacionado 6";
        break;
}
$tipodx = '';
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

echo '<strong>',$orden_dx,'</strong>',br(),$tipodx;
?></td>
</tr>
</table>
