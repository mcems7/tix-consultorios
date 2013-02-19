
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
<script type="text/javascript">
///////////////////////////////////////////////////////////////////////////////
var id_medico_seleccionado=-1;
var id_agenda_detalle=-1;
var nombre_medico='';
function traerAgenda()
{    
    if($('fecha_agenda').value=="")
        {
            alert("Seleccione una Fecha");
            return false;
        }
    lista_especialidades_dia();
    lista_pacientes_espera();
    //id_medico=$('id_especialidad').value;
    lista_especialistas_dia();
    return false;
}
////////////////////////////////////////////////////////////////////////////////

function asignar()
{
    if(!confirm('Asignará una cita en el horario seleccionado. ¿Está seguro que desea continuar?'))
	{
            return false;
        }
    if(id_agenda_detalle==-1)
        {
            alert('No ha seleccionado rango horario');
            return;
        }
    if(parseInt(document.getElementById("duracion").innerHTML)>parseInt(document.getElementById("hora"+id_agenda_detalle).innerHTML))
        {
            alert('El tiempo requerido para la cita es mayor al tiempo disponible');
            return;
        }
    pacientes_medico_agenda(id_medico_seleccionado, nombre_medico)
    //alert($('id_remision').value);
    var var_url = '<?=site_url()?>/citas/asignacion_cita/asignar_cita/'+id_agenda_detalle+'/'+$('id_remision').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    //$('agenda').set('html',html);
                    lista_pacientes_espera();
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                    return false;
                }
		
	});
	ajax1.send();
        lista_especialistas_dia();
        pacientes_medico_agenda(id_medico_seleccionado,nombre_medico);
        return false;
}
///////////////////////////////////////////////////////////////////////////////
function eliminar()
{
    causa=prompt('Ingrese la causa de baja de la solicitud:','');
    if(causa==null || causa=="")
       {
        alert("Requiere una causa para dar de baja la solicitud")
        return false;   
       }
    if(!confirm('Eliminará la solicitud ¿Esta seguro que desea continuar?'))
	{
            return false;
        }
    var var_url = '<?=site_url()?>/citas/asignacion_cita/dar_baja_cita_paciente/'+$('id_remision').value+'/'+causa;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    //$('agenda').set('html',html);
                    lista_pacientes_espera();
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                    return false;
                }
		
	});
	ajax1.send();
        lista_especialistas_dia();
        pacientes_medico_agenda(id_medico_seleccionado,nombre_medico);
        return false;
 }
//////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////
function observacion()
{
    observacion1=prompt('Ingrese la observacion de la cita:','');
    if(observacion1==null || observacion1=="")
       {
        alert("No a ingresado ninguna observacion")
        return false;   
       }
  
    var var_url = '<?=site_url()?>/citas/asignacion_cita/crear_observacion_agenda/'+$('id_remision').value+'/'+observacion1;
    var ajax1 = new Request(
		{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    //$('agenda').set('html',html);
                   lista_pacientes_espera();
				  
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                    return false;
                }
		
	});
	ajax1.send();
        lista_especialistas_dia();
        pacientes_medico_agenda(id_medico_seleccionado,nombre_medico);
        return false;
 }
//////////////////////////////////////////////////////////////////////////////







function hora_seleccionada(id,hora)
{
    if(id==-1)
        {
            alert("Rango asignado como no disponible");
            return;
        }
      $('hora_elegida').set('html',hora);
      id_agenda_detalle=id;
}
////////////////////////////////////////////////////////////////////////////////
function cargar_municipios()
{
    	var var_url = '<?=site_url()?>/citas/solicitar_cita/municipios/'+
                      $('nombre_departamento_hidden').value;
	var ajax1 = new Request(
	{
		url: var_url,
                async: false,
		onSuccess: function(html){
                    $('nombre_municipio').set('html',html);
                },
		onComplete: function(){
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();
        lista_pacientes_espera();
}
///////////////////////////////////////////////////////////////////////////////
function lista_especialidades_dia()
{
    var var_url = '<?=site_url()?>/citas/asignacion_cita/especialidades_dia/'+
                   $('fecha_agenda').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    $('lista_especialidades').set('html',html);
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                    return false;
                }
		
	});
	ajax1.send();
        return false;
}
////////////////////////////////////////////////////////////////////////////////
function lista_especialistas_dia()
{
  
    var var_url = '<?=site_url()?>/citas/asignacion_cita/especialistas_dia/'+
                  $('fecha_agenda').value+'/'+$('id_especialidad').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    $('agenda').set('html',html);
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                    return false;
                }
		
	});
	ajax1.send();
        return false;
}
//////////////////////////////////////////////////////////////////////////////
function pacientes_medico_agenda(id_medico,nombre)
{
    id_medico_seleccionado=id_medico;
    nombre_medico=nombre;
    if($('doctor_elegido')!=null)
        $('doctor_elegido').set('html','Doctor: '+nombre);
    var var_url = '<?=site_url()?>/citas/asignacion_cita/pacientes_agenda/'+
        id_medico+'/'+$('fecha_agenda').value;//+'/'+$('id_especialidad').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    $('agenda_pacientes').set('html',html);
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                    return false;
                }
		
	});
	ajax1.send();
        return false;
}
///////////////////////////////////////////////////////////////////////////////
function lista_pacientes_espera()
{
   
   
    $('datos_cita').set('html','');
    lista_especialistas_dia();
    
    id_departamento=$('nombre_departamento_hidden').value==""?-1:$('nombre_departamento_hidden').value;
    id_municipio= $('nombre_municipio_hidden').value==""?-1:$('nombre_municipio_hidden').value;  
    var var_url = '<?=site_url()?>/citas/asignacion_cita/pacientes_espera/'+$('id_especialidad').value+'/'+id_departamento+'/'+id_municipio+'/'+$('tipo_atencion').value+'/'+$('prioridad').value+'/'+$('prioritaria').value+'/'+
                  $('id_entidad_remitente').value+'/'+$('id_tiempo').value+'/'+$('id_entidad').value+'/'+$('fecha_agenda').value+
                  '/'+$('medico_remite').value+'/';
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    $('lista_pacientes').set('html',html);
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                }
		
	});
	ajax1.send();
        datos_basicos_cita();
}
///////////////////////////////////////////////////////////////////////////////
function datos_basicos_cita()
{
    //lista_especialistas_dia();
    try
    {
        if($('id_remision').value=="")
        return;
    }
    catch(e)
    {
        return;
    }
    
    var var_url = '<?=site_url()?>/citas/asignacion_cita/datos_basico_cita/'+$('id_remision').value+'/'+$('fecha_agenda').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    //alert(html);
                    $('datos_cita').set('html',html);
                    
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                }
		
	});
	ajax1.send();
        
}
////////////////////////////////////////////////////////////////////////////////
function suspender_cita(id_cita)
{
    if(confirm('Suspenderá la cita y tendrá que reprogramarla ¿Esta seguro que desea continuar?'))
	{
	var var_url = '<?=site_url()?>/citas/asignacion_cita/suspender_cita_paciente/'+id_cita;
        var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                pacientes_medico_agenda(id_medico_seleccionado,nombre_medico);
                alert('Cita Suspendida satisfactoriamente');
                //alert(html);
                           },
		evalScripts: true,
		onFailure: function(){alert('Error suspendiendo cita');
                }
		
	});
	ajax1.send();
        }
}
////////////////////////////////////////////////////////////////////////////////
function cancelar_cita(id_cita)
{
     causa=prompt('Ingrese la causa de baja de la solicitud:','');
    if(causa==null || causa=="")
       {
        alert("Requiere una causa para dar de baja la solicitud")
        return false;   
       }
    if(confirm('Cancelará la solicitud de cita ¿Esta seguro que desea continuar?'))
	{
		var var_url = '<?=site_url()?>/citas/asignacion_cita/dar_baja_cita_paciente/'+id_cita+'/'+causa;
        var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                pacientes_medico_agenda(id_medico_seleccionado,nombre_medico);
                alert('Cita cancelada satisfactoriamente');
                //alert(html);
                           },
		evalScripts: true,
		onFailure: function(){alert('Error suspendiendo cita');
                }
		
	});
	ajax1.send();
        }
}
///////////////////////////////////////////////////////////////////////////////
function filtrar_medico(e)
{
    if($('medico_remite').value.length%3==0)
       lista_pacientes_espera();
}
///////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){	
  $('fecha_agenda').value="<?=date('Y')?>-<?=date('m')?>-<?=date('d');?>"
   traerAgenda();
   cargar_municipios(-1);	
});
////////////////////////////////////////////////////////////////////////////////
</script>

<h1 class="tituloppal">Servicio de Consulta Externa </h1>
<h2 class="subtitulo">Asignación Citas Pacientes </h2>

<?php
$attributes = array('id'=>'formulario',
	            'name'=>'formulario',
		    'method'=>'post',
                    'onSubmit'=>'return traerAgenda()');
echo form_open('/citas/autorizar_cita/cambiar_estado_cita_pedida',$attributes);
?>
<table width="100%" class="tabla_interna">
<tr>
  <td class="campo_izquierda" width="82px">Fecha:</td>
  <td class="campo_centro" width="120px"><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']" onchange="traerAgenda()">
  <img src='<?=base_url()?>/resources/img/calendario_boton.png' id='fecha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
<script type='text/javascript'>
Calendar.setup({
    inputField     :    'fecha_agenda',     		// id of the input field
    ifFormat       :    '%Y-%m-%d',
    daFormat       :    '%Y-%m-%d',          // format of the input field
    displayArea	   :	'fecha_agenda',
    showsTime      :	true,
    timeFormat     :    '12',
    button         :    'fecha_agenda_botton',       // trigger for the calendar (button ID)
    align          :    'Br',                   // alignment (defaults to 'Bl')
    singleClick    :    true
});
</script></td>
  <td class="campo_izquierda"><?=form_submit('boton', 'Traer Agenda')?></td>
</tr>
</table>
<table class="tabla_interna"  width="100%">
    <tr>
        <td class="campo_izquierda" width="85px">Especialidad:</td><td id="lista_especialidades"></td>
    </tr>
     <tr>
        <td class="campo_izquierda" width="85px">Filtrar</td>
        <td id="lista_pacdientes">
            <table class="tabla_interna">
             <tr>   
                <td class="campo_izquierda">Institución Encargada del Pago:</td>
                <td>
                   <select name="id_entidad" id="id_entidad" onchange="lista_pacientes_espera()"  style="font-size:9px">
                       <option value="-1">Todas</option>
                       <?php
                        foreach($entidades_remision as $d)
                        {
                            echo '<option value="'.$d['id_entidad'].'">'.$d['nombre'].'</option>';
                        }     ?>
                    </select>
                 </td>
               </tr>
              <tr>   
                <td class="campo_izquierda">Institución Remite:</td>
                <td>
                   <select name="id_entidad_remitente" id="id_entidad_remitente" onchange="lista_pacientes_espera()"  style="font-size:9px">
                       <option value="-1">Todas</option>
                       <?php
                        foreach($entidades_remision as $d)
                        {
                            echo '<option value="'.$d['codigo_entidad'].'">'.$d['nombre'].'</option>';
                        }     ?>
                    </select>
                 </td>
               </tr>
               <tr>
                 <td class='campo_izquierda' id="td_departamento">Departamento Residencia:</td>
                 <td><?=form_dropdown('nombre_departamento_hidden',$departamento, 
                                     '','id="nombre_departamento_hidden" onchange="cargar_municipios()"')?>

                 </td>
               </tr>
                <tr>
                    <td class='campo_izquierda' >Municipio Residencia:</td>
                    <td id="nombre_municipio">
                        <select id="nombre_municipio_hidden" onchange="lista_pacientes_espera()" name="nombre_municipio_hidden">
                             <option value="-1">Todos</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td class="campo_izquierda">Causa Externa:</td>
                    <td><select name="tipo_atencion" id="tipo_atencion" onchange="lista_pacientes_espera()">
                      <option value="-1">Todos</option>
                      <option value="01">Accidente Trabajo</option>
                      <option value="02">Accidente Tránsito</option>
                      <option value="03">Accidente Rábico</option>
                      <option value="04">Accidente Ofíbico</option>
                      <option value="05">Otro Accidente</option>
                      <option value="06">Evento Catastrófico</option>
                      <option value="07">Lesión por Agresión</option>
                      <option value="08">Lesión Autoinfligida</option>
                      <option value="09">Sospecha Maltrato Físico</option>
                      <option value="10">Sospecha Abuso Sexual</option>
                      <option value="11">Sospecha Violencia Sexual</option>
                      <option value="12">Sospecha Maltr. Emocional</option>
                      <option value="13">Enfermedad General</option>
                      <option value="14">enfermedad Profesional</option>
                      <option value="15">Otra</option>
                    </select>
                    </td></tr><tr>
                    <td class="campo_izquierda">Clasificación:</td>
                    <td>
                        <select id="prioridad" onchange="lista_pacientes_espera()"> 
                            <option value="ninguna">Todas</option>
                             <option value="enfermedad_general">Enfermedad General</option>
                             <option value="adulto_mayor">Mayores de 65</option>
                             <option value="menores">Menores de 1 año</option>
                             <option value="soat">SOAT</option>
                             <option value="alto_riesgo">Alto riesgo obstétrico</option>
                             <option value="riesgo_cardiovascular">Programa de riesgo cardiováscular</option>
                             <option value="discapacitados">Discapacitados</option>
                             <option value="epileptico">Epiléptico</option>
                             <option value="programas_especiales">Programas especiales</option>
                             <option value="alto_costo">Alto Costo</option>
                             <option value="anticoagulados">Anticoagulados</option>
                             <option value="maltrato">Maltrato Violencia</option>
                             <option value="prepagados">Prepagada</option>
                </select>
                    </td>
                </tr>
                <tr>
                    <td class="campo_izquierda">Prioritaria:</td>
                        <td>
                            <select id="prioritaria" name="prioritaria" onchange="lista_pacientes_espera()">
                             <option value="ambas">Ambas</option>
                             <option value="prioritaria">Prioritaria</option>
                             <option value="no_prioritaria">No Prioritaria</option>
                            </select>
                        </td></tr>
                <tr>
                    <td class="campo_izquierda">Tipo Cita:</td>
                        <td>
                            <select id="id_tiempo" name="id_tiempo" onchange="lista_pacientes_espera()">
                                <option value="todas">Todas</option>
                                <option value="consulta_primera_vez">Primera Vez</option>
                                <option value="consulta_control_pos_operatorio">Control POP</option>
                                <option value="consulta_control">Control</option>
                                <option value="consulta_procedimiento">procedimiento</option>
                                <option value="junta_medica">Junta Médica</option>
                            </select>
                        </td>
                </tr>
                 <tr>
                    <td class="campo_izquierda">Médico Remite:</td>
                        <td>
                            <input onkeyup="filtrar_medico(event);" type="text" size="50" id="medico_remite" name="medico_remite"></input>
                        </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="campo_izquierda">Paciente</td>
        <td><div id="lista_pacientes"><select id="id_especialidads"></select></div></br>
            <!--<strong>NOMBRE PACIENTE|| DIAS ESPERA || EDAD DEL PACIENTE|| NUMERO DOCUMENTO || PIN</strong>-->
        </td>
    </tr>
</table>
<table width="100%" class="tabla_interna">
    <tr><td><div id="datos_cita"> </div></td></tr>
    <tr><td><div id="agenda"> </div></td></tr>
    <tr><td><div id="agenda_pacientes"> </div></td></tr>
</table>
<?=form_close();?>
</td></tr>
    </table>
  
</div>
