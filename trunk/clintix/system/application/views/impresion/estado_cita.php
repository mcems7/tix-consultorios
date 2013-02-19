<center><strong>Datos Solicitud</strong></center>
        <table border="1">
            <tr>
                <td class="negrita" width="20%">PIN:</td>
                <td><?=$pin;?></td>
            </tr>
            <tr>
                <td class="negrita"  width="20%">Estado Solicitud:</td>
                <td><?=$estado_cita['estado']?></td>
            </tr>
            <tr>
                <td class="negrita"  width="20%">Fecha Solicitud:</td>
                <td><?=$estado_cita['fecha_solicitud'];?></td>
            </tr>
             <tr>
                <td class="negrita"  width="20%">Especialidad:</td>
                <td><?=$estado_cita['especialidad']?> </td>
            </tr>
            <tr>
                <td class="negrita"  width="20%">Entidad Solicita:</td>
                <td><?=$estado_cita['entidad']?></td>
            </tr>
            <tr>
                <td class="negrita"  width="20%">Documento Paciente:</td>
                <td><?=$estado_cita['numero_documento']?></td>
            </tr>
            <tr>
                <td class="negrita"  width="20%">Nombre Paciente:</td>
                <td><?=$estado_cita['primer_nombre']?> <?=$estado_cita['segundo_nombre']?> <?=$estado_cita['primer_apellido']?> <?=$estado_cita['segundo_apellido']?></td>
            </tr>
            <?php
           if($estado_cita['estado']=='asignada'||$estado_cita['estado']=='confirmada' ||
               $estado_cita['estado']=='atendida')
            {
                ?>
             <tr>
                <td class="campo_izquierda">Hora:</td>
                <td>
               <?=arreglo_a_hora($estado_cita['orden_intervalo'],$parametros_agenda).':'.strlen(count($minutos)==1?'0':'').$minutos[0]['minutos']?></td>
                </tr>
                <tr>
                <td class="negrita"  width="20%">Fecha Cita:</td>
                <td><?=$estado_cita['fecha_cita']?></td>
                </tr>
                  <tr>
                <td class="negrita"  width="20%">Médico:</td>
                <td><?=$estado_cita['primer_nombre_medico']?> <?=$estado_cita['segundo_nombre_medico']?> <?=$estado_cita['primer_apellido_medico']?> <?=$estado_cita['segundo_apellido_medico']?></td>
                </tr>
                 <tr>
                <td class="negrita"  width="20%">Consultorio:</td>
                <td><?=$estado_cita['consultorio']?></td>
                </tr>
                <?php
            }
            if ($estado_cita['estado']=='rechazada')
            {
                ?>
                <tr>
                <td class="negrita"  width="20%">Motivo Rechazo:</td>
                <td><?=$estado_cita['motivo_rechazo']?></td>
                </tr>
                <?php
            }
            ?>
            
        </table>
