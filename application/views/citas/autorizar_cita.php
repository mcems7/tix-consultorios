<script type="text/javascript">
///////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){	
    mostrar();
});
////////////////////////////////////////////////////////////////////////////////
function validar()
{
    if(confirm('Se procederá a realizar la operación ¿Esta seguro que desea continuar?'))
	return true;     
    return false;
}
////////////////////////////////////////////////////////////////////////////////
function mostrar()
{
  html='';
  if($('estado').value=='autorizada')
      {
          html='<td></td><td><table><tr><td class="campo">Prioridad</td><td><select name="prioridad" id="prioridad">'+
               '<option value="enfermedad_general">Enfermedad General</option>'+
               '<option value="adulto_mayor">Mayores de 65</option>'+
               '<option value="alto_riesgo">Alto riesgo obstétrico</option>'+
               '<option value="riesgo_cardiovascular">Programa de riesgo cardiováscular</option>'+
               '<option value="discapacitados">Discapacitados</option>'+
               '<option value="epileptico">Epiléptico</option>'+
               '<option value="programas_especiales">Programas especiales</option>'+
               '<option value="alto_costo">Alto Costo</option>'+
               '<option value="anticoagulados">Anticoagulados</option>'+
               '<option value="maltrato">Maltrato Violencia</option>'+
               '<option value="prepagada">Prepagada</option>'+
               '</select></td></tr>';
           html+='<tr><td class="campo">Tipo Cita</td><td><select name="tipo_cita" id="tipo_cita">'+
               '<option value="consulta_primera_vez">Primera Vez</option>'+
               '<option value="consulta_repetitiva">Repetitiva</option>'+
               '<option value="consulta_control_pos_operatorio">Control POP</option>'+
               '<option value="consulta_control">Control</option>'+
               '<option value="consulta_procedimiento">Procedimiento</option>'+
               '</select></td></tr>';
            html+='<tr><td class="campo">Prioritaria</td>'+
                  '<td><select name="prioritaria" id="prioritaria">'+
                  '<option value="no_prioritaria">No Prioritaria</option>'+
                  '<option value="prioritaria">Prioritaria</option>'+
                  '</select></td>';
            html+='</tr></table></td>';
      }
  else
      {
          html='<td  class="campo">Motivo Rechazo</td><td><?=form_textarea(array('name' => 'motivo_rechazo',
								'id'=> 'motivo_rechazo',
								'rows' => '5',
								
								'cols'=> '50'))?></td>';
      }
      $('complemento_formulario').set('html', html)
}
//////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'=>'formulario',
	            'name'=>'formulario',
		    'method'=>'post',
                    'onsubmit' => 'return validar()');
echo form_open('/citas/autorizar_cita/cambiar_estado_cita_pedida',$attributes);
echo form_hidden('id',$info_cita['id']);
?>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Aprobación</th></tr>
<tr><td class="campo">Seleccione una Opción:</td>
<td>
    <select name="estado" id="estado" onchange="mostrar();">
        <option value="autorizada">Aprobada</option>
        <option value="rechazada">No Aprobada</option>
    </select>
</td></tr>
<tr id="complemento_formulario"></tr>
<tr><td colspan="2" align="center"><?
$data = array('name'=>'bv',
	      'id'=>'bv',
	      'onclick'=>'regresar()',
              'value'=>'Volver',
	      'type'=>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Procesar')?></td></tr>
</table>
<?=form_close();?>
