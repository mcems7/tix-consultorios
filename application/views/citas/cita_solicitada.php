<h1 class="tituloppal">Consulta Externa - Citas</h1>
<h2 class="subtitulo">Solicitudad Consulta con Especialista</h2>
<?php if(isset ($datos_localizacion)){?>
<h3 class="subtitulo">El registro de la solicitud de la cita se ha efectuado correctamente.<BR/>
 </h3>
<?php }  ?>
  <table width="100%" class="tabla_form">
<tr><th colspan="2">Datos Solicitud </th></tr>
<tr><td>
        <table>
            <tr>
                <td class="campo_izquierda">PIN:</td>
                <td><?=$pin;?></td>
            </tr>
            <tr>
                <td class="campo_izquierda">Estado Solicitud:</td>
                <td><?=estado_cita($estado_cita['estado'])?></td>
            </tr>
            <tr>
                <td class="campo_izquierda">Fecha Solicitud:</td>
                <td><?=$estado_cita['fecha_solicitud'];?></td>
            </tr>
             <tr>
                <td class="campo_izquierda">Especialidad:</td>
                <td><?=$estado_cita['especialidad']?> </td>
            </tr>
            <tr>
                <td class="campo_izquierda">Entidad Solicita:</td>
                <td><?=$estado_cita['entidad']?></td>
            </tr>
            <tr>
                <td class="campo_izquierda">Documento Paciente:</td>
                <td><?=$estado_cita['numero_documento']?></td>
            </tr>
            <tr>
                <td class="campo_izquierda">Nombre Paciente:</td>
                <td><?=$estado_cita['primer_nombre']?> <?=$estado_cita['segundo_nombre']?> <?=$estado_cita['primer_apellido']?> <?=$estado_cita['segundo_apellido']?></td>
            </tr>
            <?php
            if($estado_cita['estado']=='asignada'||$estado_cita['estado']=='confirmada' ||
               $estado_cita['estado']=='atendida')
            {
                ?>
                <tr>
                <td class="campo_izquierda">Fecha Cita:</td>
                <td><?=$estado_cita['fecha_cita']?></td>
                </tr>
                <tr>
                <td class="campo_izquierda">Hora:</td>
                <td><?=arreglo_a_hora($estado_cita['orden_intervalo'],$parametros_agenda).':'.strlen(count($minutos)==1?'0':'').$minutos[0]['minutos']?></td>
                </tr>
                  <tr>
                <td class="campo_izquierda">Médico:</td>
                <td><?=$estado_cita['primer_nombre_medico']?> <?=$estado_cita['segundo_nombre_medico']?> <?=$estado_cita['primer_apellido_medico']?> <?=$estado_cita['segundo_apellido_medico']?></td>
                </tr>
                 <tr>
                <td class="campo_izquierda">Consultorio:</td>
                <td><?=$estado_cita['consultorio']?></td>
                </tr>
                <?php
            }
            if ($estado_cita['estado']=='rechazada')
            {
                ?>
                <tr>
                <td class="campo_izquierda">Motivo Rechazo:</td>
                <td><?=$estado_cita['motivo_rechazo']?></td>
                </tr>
                <?php
            }
            ?>
            
        </table>
    </td>
</tr>
  </table>
</br>
<center>
<?
$data = array('name'=>'bv',
            'onclick'=>'finalizar()',
            'value'=>'Finalizar',
            'type'=>'button');
echo form_input($data),nbs();
$data = array('name'=>'imp',
                'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_estado_cita/'.$pin)."')",
                'value' => 'Imprimir',
                'type' =>'button');
echo form_input($data);
?>
</center>
