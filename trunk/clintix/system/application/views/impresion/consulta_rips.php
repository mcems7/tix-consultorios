<?php
if(count($resultado)==0)
{
    echo "<center>No Hay Resultados</center>";
    return;
}
?>
<table width="100%" border="1" style="font-size: 12px">
    <tr><td colspan="2">
            <strong>Médico: </strong><?=$resultado[0]['primer_nombre_medico']?> <?=$resultado[0]['segundo_nombre_medico']?> <?=$resultado[0]['primer_apellido_medico']?> <?=$resultado[0]['segundo_apellido_medico']?></br> 
        <strong>Especialidad: </strong> <?=$resultado[0]['especialidad']?></td></tr>
    <tr><td><table  width="100%" border="1">
        <tr>
            <td class="negrita" style="font-size: 12px">Fecha Cita</td>
            <td class="negrita" style="font-size: 12px">Factura</td> <td class="negrita" style="font-size: 12px">Documento</td> 
            <td class="negrita" style="font-size: 12px">Nombre Usuario</td> <td class="negrita" style="font-size: 12px">Causa Externa</td>
            <td class="negrita" style="font-size: 12px">Dx Principal</td>
        </tr>
        <?php 
            foreach($resultado as $item)
            {
                ?>
        <tr style="font-size: 12px"><td><?=$item['fecha']?><td><?=$item['factura']?><td><?=$item['numero_documento']?></td>
            <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
            <td><?=valor_motivo_consulta($item['tipo_atencion'])?></td>
            <td><?=$item['diagnostico']?></td>
        </tr>
                <?php
            }
        ?>
    </table>
        </td></tr>
</table>