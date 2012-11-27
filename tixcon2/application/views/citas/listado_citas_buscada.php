<?php
if(count($citas)==0)
{
    echo "<center>No Hay Resultados</center>";
}
else
{
?>
<table class="tabla_interna" width="100%">
    <tr>
        <td class="campo_izquierda">PIN</td>
        <td class="campo_izquierda">Fecha Solicitud</td>
        <td class="campo_izquierda">Estado</td>
        <td class="campo_izquierda">Documento</td><td  class="campo_izquierda">Nombre</td>
        <td class="campo_izquierda">Especialidad</td>
        <td  class="campo_izquierda">Entidad</td>
        <td class="campo_izquierda">Consultar</td>
        <?php
        foreach($citas as $item)
        {
            ?>
    <tr>
        <td><?=$item['pin']?></td> <td><?=$item['fecha_solicitud']?></td> 
        <td><?=estado_cita($item['estado'])?></td> 
        <td><?=$item['numero_documento']?></td>
        <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
        <td><?=$item['especialidad']?></td> 
        <td><?=$item['entidad']?></td>
        <td class="opcion"><a href="<?=site_url()?>/citas/estado_cita/detalle_solicitud/<?=$item['pin']?>">Ver</a></td>
       
    </tr>
            <?php
        }
        ?>
    </tr>
</table>
<?php 
 
    }
?>