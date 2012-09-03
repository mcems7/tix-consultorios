 <table width="100%" class="tabla_form">
<tr><th colspan="2">Citas Asignadas</th></tr>
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
    <tr>
        <td class="campo_centro">Hora</td>
        <td class="campo_centro">Documento</td>
        <td class="campo_centro">Paciente</td>
        <td class="campo_centro">Tipo Cita</td>
        <td class="campo_centro">Duración</td>
        <td class="campo_centro">Suspender</td>
        <td class="campo_centro">Cancelar</td>
<?php
foreach($lista_pacientes as $item)
{
    ?>
    <tr>
        <td><?=arreglo_a_hora($item['orden_intervalo'],$parametros_agenda).':'.(strlen($item['minutos'])==1?'0':'').$item['minutos']?></td>
        <td><?=$item['numero_documento']?> </td>
        <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
        <td><?=valor_tipo_cita($item['tipo_cita'])?></td>
        <td><?=$item['duracion_cita']?></td>
        <?php 
            if($item['estado']=='asignada')
            {
        ?>
        <td class="opcion"><a href="#" onClick="suspender_cita('<?=$item['id']?>');return false">Suspender</a></td>
        <td class="opcion"><a href="#" onClick="cancelar_cita('<?=$item['id']?>'); return false">Cancelar</a></td>
        <?php 
            }
            else
            {
            ?>
        <td colspan="2" class="campo_centro"><center><?=$item['estado']?></center></td>
        <?php
            }
        ?>
    </tr>
    <?php
}
?>
 </tr>
</table>
    </td>
    </tr>
  </table>