<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Atenciones Consulta Externa Paciente</h2>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Atenciones Anteriores</th></tr>
<tr><td colspan="2">  
        
<?php 
if($listado_atenciones!=0)
{
?>
<table class="tabla_interna" width="100%" > 
    <tr>
    <td class="campo_centro">Fecha</td>
    <td class="campo_centro">Especialidad</td>
    <td class="campo_centro">Atendido Por</td>
    <td class="campo_centro">HCE</td>
    <td class="campo_centro">Órdenes</td>
    <td class="campo_centro">Incapacidad</td>
    <td class="campo_centro">Interconsulta</td>
    <td class="campo_centro">Control</td>
    </tr>
    <?php
     foreach($listado_atenciones as $item)
        {
            ?>
            <tr>
                <td><?=$item['fecha']?></td>
                <td><?=$item['especialidad']?></td>
                <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
                <td class="opcion"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_paciente/<?= $item['id']?>">Consultar</a></td>
                <td class="opcion"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_ordenes/<?= $item['id']?>">Consultar</a></td>
                <td class="opcion"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_incapacidad/<?= $item['id']?>">Consultar</a></td>
                <td class="opcion"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_remision/<?= $item['id']?>">Consultar</a></td>
                <td class="opcion"><a href="<?=site_url()?>/hce/main_consulta_externa/hce_control/<?= $item['id']?>">Consultar</a></td>
                
            </tr>
            <?php
        }
    ?>
</table>
        <?php 
}
else
    echo "No hay resultados";
        ?>
 </td></tr>
</table>
</br></br>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'history.back()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
/*$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_remision/'.$info_cita['id'])."')",
				'value' => 'Imprimir',
				'type' =>'button');*/
//echo form_input($data);
?>
</center>