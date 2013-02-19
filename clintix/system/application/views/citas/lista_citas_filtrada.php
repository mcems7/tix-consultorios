<?php
if($citas==0)
{
    echo "<center>No Hay Resultados</center>";
}
else
{
?>
<table class="tabla_interna" width="100%">
    <tr>
        <td class="campo_izquierda">PIN</td>
        
        <?php
            if($id_estado=='asignada')
            {
                ?>
                    <td class="campo_izquierda">Fecha Cita</td>
                <?php
            }
            else
            {
                ?>
                    <td class="campo_izquierda">Fecha Solicitud</td>
                    <td class="campo_izquierda">Estado</td>
                <?php
                
            }
        ?>
        
        <td class="campo_izquierda">Documento</td><td  class="campo_izquierda">Nombre</td>
        <td class="campo_izquierda">Especialidad</td>
         <?php
            if($id_estado=='asignada')
            {
                ?>
                    <td class="campo_izquierda">Médico</td>
                <?php
            }
        ?>
        <td  class="campo_izquierda">Entidad</td>
        <td class="campo_izquierda">Consultar</td>
        <?php
        foreach($citas as $item)
        {
            ?>
    <tr>
        <td><?=$item['pin']?></td>
         <?php
            if($id_estado=='asignada')
            {
                ?>
                     <td><?=$item['fecha']?></td> 
                <?php
            }
            else
            {
                ?>
                    <td><?=$item['fecha_solicitud']?></td> 
                    <td><?=$item['estado']?></td> 
                <?php
            }
        ?>
        
        <td><?=$item['numero_documento']?></td>
        <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
        <td><?=$item['especialidad']?></td> 
         <?php
            if($id_estado=='asignada')
            {
                ?>
                    <td><?=$item['primer_nombre_medico']?> <?=$item['segundo_nombre_medico']?> <?=$item['primer_apellido_medico']?> <?=$item['segundo_apellido_medico']?></td>
                <?php
            }
        ?>
        <td><?=$item['eps']?></td>
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
<center>
<?
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_lista/'.
                                                                        $filtros['fecha_agenda_inicial'].'/'.$filtros['fecha_agenda'].
                                                                        '/'.$filtros['id_especialidad'].
                                                                        '/'.$filtros['id_entidad'].
                                                                        '/'.$filtros['id_estado'].
                                                                        '/'.$filtros['id_entidad_pago'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>