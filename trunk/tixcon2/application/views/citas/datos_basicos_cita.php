<table class="tabla_interna" width="100%">
    <tr>
        <td> <?=$datos_cita['entidad']?></td>
    </tr>
    <tr><td>
    <table class="tabla_interna" width="100%">
        <tr>
            <td class="campo">Fecha Solicitud</td><td> <?=$datos_cita['fecha_solicitud']?></td>
            <td class="campo">Tiempo Espera</td><td> <!--<?=$this->lib_edad->edad($datos_cita['fecha_solicitud'])?>-->0 días</td>
            <td class="campo">Clasificación</td><td> <?=valor_prioridad($datos_cita['prioridad'])?></td>
        </tr>
        <tr>
            <td class="campo">Departamento</td><td> <?=$datos_cita['departamento']?></td>
            <td class="campo">Municipio</td><td> <?=$datos_cita['municipio']?></td>
            <td class="campo">Celular</td><td> <?=$datos_cita['celular']?></td>
        </tr>
        <tr>
            <td class="campo">Motivo Consulta</td><td> <?=valor_motivo_consulta($datos_cita['tipo_atencion'])?></td>
            <td class="campo">Duración Cita</td><td><div id="duracion"> <?=$datos_cita['duracion_cita']?></div></td>
            <td class="campo">Tipo Cita</td><td> <?=valor_tipo_cita($datos_cita['tipo_cita'])?></td>
        </tr>
         <tr>
            <td class="campo">Fecha Nacimiento</td><td> <?=$datos_cita['fecha_nacimiento']?></td>
            <td class="campo">Edad</td><td> <?=$this->lib_edad->edad($datos_cita['fecha_nacimiento'])?></td>
            <td class="campo">Género</td><td> <?=$datos_cita['genero']?></td>
        </tr>
    </table>
     </td> </tr>
     <tr>
        <td class="campo_centro"> Motivo</td>
    </tr>
    <tr>
        <td><?=$datos_cita['motivo_consulta']?></td>
    </tr>
    <tr>
        <td class="campo_centro"> Diagnóstico</td>
    </tr>
    <tr>
        <td><?=$datos_cita['impresiones_diagnosticas']?></td>
    </tr>
    <tr>
        <td><div style="float:left">Hora: <div id="hora_elegida" style="float:right;padding-left: 5px;padding-right: 5px; font-weight: bold">SIN SELECCIONAR</div>
                <div id="doctor_elegido">Doctor: No seleccionado</div>
            </div><?
$data = array('name'=>'bv',
	      'id'=>'bv',
	      'onclick'=>'asignar()',
              'value'=>'Asignar',
	      'type'=>'button');
echo form_input($data);
?></td>
    </tr>
</table>