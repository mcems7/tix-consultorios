<?php 
if(count($listado_citas)!=0)
{
?>
<table width="100%" class="tabla_interna">
    <tr>
        <td class="campo_centro">Fecha</td>
        <td class="campo_centro">Prioritaria</td>
        <td class="campo_centro">Entidad</td><td class="campo_centro">Especialidad</td>
        <td class="campo_centro">Nombre</td>
        <td class="campo_centro">Motivo</td>
        <td class="campo_centro">Acción</td>
        <?php
        foreach($listado_citas as $item)
        {
            ?><tr>
            <td><?=$item['fecha_solicitud']?></td>
            <td><?=valor_prioritaria($item['solicitud_prioritaria'])?></td>
             <td><?=$item['entidad_remite']?></td>
            <td><?=$item['especialidad']?></td>
            <td><?=$item['primer_apellido']?> <?=$item['segundo_apellido']?> <?=$item['primer_nombre']?> <?=$item['segundo_nombre']?></td>
            <td><?=$item['motivo_remision']?></td>
            <td class="opcion"><a href="<?=site_url('citas/autorizar_cita/detalle/'.$item['id'])?>">Procesar</a></td>
            </tr>
            <?php
        }
        ?>
    </tr>
</table>
<?php
}
else
{
?>
<center>No hay Resultados</center>
<?php
}
?>