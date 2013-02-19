<?php
if(count($resultado)==0)
{
    echo "<center>No Hay Resultados</center>";
    return;
}
?>
<table width="100%" class="tabla_form">
    <tr><th colspan="2">Atenciones <?=$resultado[0]['primer_nombre_medico']?> <?=$resultado[0]['segundo_nombre_medico']?> <?=$resultado[0]['primer_apellido_medico']?> <?=$resultado[0]['segundo_apellido_medico']?>, <?=$resultado[0]['especialidad']?></th></tr>
    <table  width="100%" class="tabla_interna">
        <tr>
            <th class="campo_izquierda">Fecha Cita</th>
            <th class="campo_izquierda">Factura</th> 
            <th class="campo_izquierda">Editar</th> 
            <th class="campo_izquierda">Documento</th> 
            <th class="campo_izquierda">Nombre Usuario</th> 
            <th class="campo_izquierda">Causa Externa</th>
            <th class="campo_izquierda">Dx Principal</th>
        </tr>
        <?php 
            foreach($resultado as $item)
            {
                ?>
        <tr><td><?=$item['fecha']?><td id="<?=$item['id_atencion']?>"><?=$item['factura']?></td>
            <td class="opcion"><a href="#" onClick="editar(<?=$item['id_atencion']?>); return false">Editar</a></td><td><?=$item['numero_documento']?></td>
            <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
            <td><?=valor_motivo_consulta($item['tipo_atencion'])?></td>
            <td><?=$item['diagnostico']?></td>
        </tr>
                <?php
            }
        ?>
    </table>
    
</table>
</br></br>