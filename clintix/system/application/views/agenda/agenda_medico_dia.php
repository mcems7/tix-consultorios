<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />

<script type="text/javascript">
var id=0;
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
 //////////////////////////////////////////////////////////////////////////
 function actualizarListaMedico()
 {
    var var_url = '<?=site_url()?>/agenda/agenda_medicos/listar_especialistas_por_especialidad/'+$('id_especialidad').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                                    $('lista_medicos_consultorio').set('html', html)
                                     },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                }
		
	});
	ajax1.send();
     
 }

 ///////////////////////////////////////////////////////////////////////////
    function verificarDisponibilidadAgenda()
    {
        
         var var_url = '<?=site_url()?>/agenda/disponibilidades/estaDisponibleMedico/1/2/3/29-02-2011';
         respuesta='false';
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    respuesta=html;
                    //alert(html);|
                    //$('lista_especialidades').set('html', html)
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                }
		
	});
	ajax1.send();
        return respuesta;
    }
window.addEvent("domready", function(){	
  $('fecha_agenda').value="<?=date('Y')?>-<?=date('m')?>-<?=date('d');?>"
 
	    	
});
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function cargarAgenda()
{
    var var_url = '<?=site_url()?>/agenda/programar_agenda/programacion_agenda/'+$('fecha_agenda').value;
    var ajax1 = new Request(
    {       
    url: var_url,
    async: false,
    onSuccess: function(html){ 
                        $('programacion_agenda').set('html', html)
                         },
    evalScripts: true,
    onFailure: function(){alert('Error verificando agenda');
    }

    });
  ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function agregar_agenda()
{
    if(verificarDisponibilidadAgenda()=='false')
        {
            alert('Medico no tiene disponbilidad en el espacio asignado')
            return false;
        }
    if(verificarPosicionAgenda()=='false')
     {
        alert('Medico no tiene disponbilidad en el espacio asignado')
        return false;
     }
    adicionarDatosAgenda();
    cargarAgenda();
    return false;
}
////////////////////////////////////////////////////////////////////////////////
//

//
////////////////////////////////////////////////////////////////////////////////
function recargarAgenda()
{
    cargarAgenda();
    return false;
}
////////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function actualizarConsultorios()
{

}

///////////////////////////////////////////////////////////////////////////////
//


////////////////////////////////////////////////////////////////////////////////
function medico_ocupado_hora()
{
    var fecha=$('fecha_agenda').value;
    var resultado=false;
    var var_url = '<?=site_url()?>/agenda/programar_agenda/medico_ocupa_consultorio_hora/'+$('medico_disponibilidad').value+'/'+$('intervalo_inicial').value+'/'+$('intervalo_final').value+'/'+fecha+'/'+i;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                                resultado=html=="0"?false:true
                                },
		evalScripts: true,
		onFailure: function(){alert('Error ingresando dato agenda');
                }
		
	});
	ajax1.send();

       return resultado;
}
///////////////////////////////////////////////////////////////////////////////
//

function imprimir()
{
  
    var var_url = '<?=site_url()?>/agenda/agenda_medicos/pacientes_agenda/'+$('medico_disponibilidad').value+'/'+$('fecha_agenda').value;//+'/'+$('id_especialidad').value;
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
</script>
<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Agenda Dia Médico</h2>
<div id="carga_agenda">
    <table width="100%" class="tabla_form">
<tr><th colspan="2">Parametro Agenda</th></tr>
<tr><td colspan="2">
    <?php
$attributes = array('id'=> 'formulario_carga_agenda','name'=> 'formulario_carga_agenda',
                    'method' => 'post','onsubmit'=> 'return recargarAgenda()');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_interna">
<tr>
  <td class="campo_izquierda" width="20%">Fecha Imprimir:</td>
  <td class="campo_izquierda"><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
  <img src='http://localhost/yage/resources/img/calendario_boton.png' id='fec leha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
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
 
</tr>

<tr>
    <td class="campo_izquierda" width="20%">Especialidad:</td><td id="lista_especialidadess"><?=form_dropdown('id_especialidad',$listadoEspecialidades,'-1','id="id_especialidad" onChange="actualizarListaMedico()"')?></td>
  </td></tr>

<tr>
     <td class="campo_izquierda" width="20%">Especialista:</td><td id="lista_medicos_consultorio"></td></tr>
</tr>

<tr>
<td colspan="2">
<?php 
$data = array(	'name' => 'imp',
				'onclick' => "imprimir()",
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data).nbs();
?>
</td>
</tr>


</table>
<table>

<tr><td><div id="agenda_pacientes"> </div></td></tr>
</table>
<?=form_close();?>
    
        
        
    </table>
</div>

