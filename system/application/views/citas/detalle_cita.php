<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos Paciente</th></tr>
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
    
       <tr > <td class="campo_izquierda">Fecha Nacimiento</td><td><?=$info_cita['fecha_nacimiento']?></td> </<tr>
       <td class="campo_izquierda">Edad</td><td><?=$info_cita['edad']?></td>
       <tr> 
        <td class="campo_izquierda">Documento</td><td><?=$info_cita['numero_documento']?></td>
        <td class="campo_izquierda">Nombre</td><td><?=$info_cita['primer_nombre']?> <?=$info_cita['segundo_nombre']?> <?=$info_cita['primer_apellido']?> <?=$info_cita['segundo_apellido']?></td> 
       </<tr>
       <tr> 
        <td class="campo_izquierda">Departamento</td><td><?=$info_cita['departamento']?></td>
        <td class="campo_izquierda">Ciudad</td><td><?=$info_cita['municipio']?> </td> 
       </<tr>
       <tr> 
        <td class="campo_izquierda">Direccion</td><td><?=$info_cita['direccion']?></td>
        <td class="campo_izquierda">Teléfono</td><td><?=$info_cita['telefono']?> </td> 
       </<tr>
       <tr> 
        <td class="campo_izquierda">Celular</td><td><?=$info_cita['celular']?></td>
        <td class="campo_izquierda">Email</td><td><?=$info_cita['email']?> </td> 
       </<tr>
</table>
    </td></tr>
</table>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Detalle Solicitud</th></tr>
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
       <tr> <td class="campo_izquierda">Fecha Solicitud</td><td><?=$info_cita['fecha_solicitud']?></td> </<tr>    
       <tr> <td class="campo_izquierda">Tiempo Espera</td><td><?=$info_cita['tiempo_espera']?></td> </<tr> 
           <?php 
           if($info_cita['estado']=='solicitada' && $info_cita['solicitud_prioritaria']=='prioritaria') 
           {
              ?>
       <tr> <td class="campo_izquierda">Prioritaria</td><td><?=valor_prioritaria($info_cita['solicitud_prioritaria'])?></td> </<tr>    
       <tr> <td class="campo_izquierda">Justificación Prioridad</td><td><?=$info_cita['justificacion_solicitud_prioritaria']?></td> </<tr> 
           <?php
           }
           ?>
       <tr> <td class="campo_izquierda">Entidad Remite</td><td><?=$info_cita['entidad_remite']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Especialidad</td><td><?=$info_cita['especialidad']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Médico Remite</td><td><?=$info_cita['medico_remite']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Motivo Remision</td><td><?=$info_cita['motivo_remision']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Motivo Consulta</td><td><?=$info_cita['motivo_consulta']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Enfermedad Actual</td><td><?=$info_cita['enfermedad_actual']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Antecedentes Personales</td><td><?=$info_cita['antecedentes_personales']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Antecedentes Familiares</td><td><?=$info_cita['antecedentes_familiares']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Revisión Sistemas</td><td><?=$info_cita['revision_sistemas']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Examen Físico</td><td><?=$info_cita['examen_fisico']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Impresiones Diagnósticas</td><td><?=$info_cita['impresiones_diagnosticas']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Paraclinicos Realizadas</td><td><?=$info_cita['paraclinicos_realizados']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Tratamientos Realizados</td><td><?=$info_cita['tratamientos_realizados']?></td> </<tr> 
       <tr> <td class="campo_izquierda">Observaciones</td><td><?=$info_cita['observaciones']?></td> </<tr> 
</table
    </td></tr>
</table>