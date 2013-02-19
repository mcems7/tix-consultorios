 <script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript" src="<?=base_url()?>resources/js/mootools1-2-0.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/fValidator.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/validaciones.js"></script>
<link rel="Shortcut Icon" href="<?=base_url()?>resources/img/e.png" type="image/x-icon" />
<link rel="stylesheet" href="<?=base_url()?>resources/menu/menu_style.css" type="text/css" />

<link rel="stylesheet" href="<?=base_url()?>resources/styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/general.css" type="text/css" media="screen" />
<!--Mediabox-->
<script type="text/javascript" src="<?=base_url()?>resources/js/mediabox.js"></script>
<link type="text/css" rel="stylesheet" href="<?=base_url()?>resources/styles/mediaboxAdvBlack.css" media="screen"></LINK>
 
  

<script type="text/javascript" src="<?=base_url()?>resources/js/mootools1-2-0.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/fValidator.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/validaciones.js"></script>
<link rel="Shortcut Icon" href="<?=base_url()?>resources/img/e.png" type="image/x-icon" />
<link rel="stylesheet" href="<?=base_url()?>resources/menu/menu_style.css" type="text/css" />

<link rel="stylesheet" href="<?=base_url()?>resources/styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/general.css" type="text/css" media="screen" />

<table class="tabla_interna" width="100%">
    <tr>
        <td>
            <strong>Entidad Encargada Pago: </strong><?=$datos_cita['eps']?><br/>
            <strong>Entidad Remite: </strong><?=$datos_cita['entidad']?><br/>
            <strong>Médico Remite: </strong><?=$datos_cita['medico_remite']?><br/>
            <strong>Pin: </strong><?=$datos_cita['pin']?>
        </td>
    </tr>
    <tr><td>
    <table class="tabla_interna" width="100%">
        <tr>
            <td class="campo_izquierda">Última Atencion:</td><td> <?=$ultima_atencion['fecha_atencion']?></td>
            
            <td class="campo_izquierda">Especialidad:</td><td  colspan="3"> <?=$ultima_atencion['especialidad']?></td>
        </tr>
        <tr>
            <td class="campo_izquierda">Fecha Solicitud:</td><td> <?=$datos_cita['fecha_solicitud']?></td>
            <td class="campo_izquierda">Tiempo Espera:</td><td> <?=$this->lib_edad->dias($datos_cita['fecha_solicitud'],date('Y-m-d'))?> Días</td>
            <td class="campo_izquierda">Clasificación:</td><td> <?=valor_prioridad($datos_cita['prioridad'])?></td>
        </tr>
        <tr>
            <td class="campo_izquierda">Departamento:</td><td> <?=$datos_cita['departamento']?></td>
            <td class="campo_izquierda">Municipio:</td><td> <?=$datos_cita['municipio']?></td>
            <td class="campo_izquierda">Celular:</td><td> <?=$datos_cita['celular']?></td>
        </tr>
        <tr>
            <td class="campo_izquierda">Causa Externa:</td><td> <?=valor_motivo_consulta($datos_cita['tipo_atencion'])?></td>
            <td class="campo_izquierda">Duración Cita:</td><td><div id="duracion"> <?=$datos_cita['duracion_cita']?></div></td>
            <td class="campo_izquierda">Tipo Cita:</td><td> <?=valor_tipo_cita($datos_cita['tipo_cita'])?></td>
        </tr>
         <tr>
            <td class="campo_izquierda">Fecha Nacimiento:</td><td> <?=$datos_cita['fecha_nacimiento']?></td>
            <td class="campo_izquierda">Edad:</td><td> <?=$this->lib_edad->edad($datos_cita['fecha_nacimiento'])?></td>
            <td class="campo_izquierda">Género:</td><td> <?=$datos_cita['genero']?></td>
        </tr>
        <tr>
         <td class="campo_izquierda">Numero Documento:</td>
        <td>
        <?=$datos_cita['numero_documento']?>
        </td>
         <td class="campo_izquierda">Numero Telefono:</td>
        <td>
        <?=$datos_cita['telefono']?>
        </td>
        <td colspan="2">
        </td>  
        </tr>
    </table>
     </td> </tr>
    <tr><td>
     <table>
         <tr> <td class="campo_izquierda">Motivo:</td>
              <td><?=$datos_cita['motivo_consulta']?></td>
         </tr>
          <tr> <td class="campo_izquierda">Diagnóstico:</td>
              <td><?=$datos_cita['impresiones_diagnosticas']?></td>
         </tr>
          <tr>
            <td class="campo_izquierda">Observaciones:</td>
            <td><?=$datos_cita['observaciones']?></td>
        </tr>
     </table>
    </td> </tr>
    <tr>
        <td><div style="float:left"><strong>Hora:</strong> <div id="hora_elegida" style="float:right;padding-left: 5px;padding-right: 5px; font-weight: bold">SIN SELECCIONAR</div>
                <div id="doctor_elegido"><strong>Doctor: </strong>No seleccionado</div>
            </div><?
            $resultado=$this->lib_edad->dias($fecha,date('Y-m-d'));
           if($resultado<=0)
           {
$data = array('name'=>'bv',
	      'id'=>'bv',
	      'onclick'=>'asignar()',
              'value'=>'Asignar',
	      'type'=>'button');
echo form_input($data).' ';
           }
$data = array('name'=>'bv',
	      'id'=>'bv',
	      'onclick'=>'eliminar()',
              'value'=>'Eliminar',
	      'type'=>'button');
echo form_input($data).' ';;


$data = array('name'=>'bv',
	      'id'=>'bv',
	      'onclick'=>'observacion()',
              'value'=>'Observacion',
	      'type'=>'button');
echo form_input($data);

?></td>
    </tr>
   <tr>
   <td><strong>Observaciones:</strong> <?=$datos_cita['observacion_agendamiento']?> </td>
  
             
   </tr> 
   
</table>