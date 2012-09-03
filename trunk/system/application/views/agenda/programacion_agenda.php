<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />

<script type="text/javascript">
var id=0;
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////
function verificarPosicionAgenda()
{

 var var_url = '<?=site_url()?>/agenda/consultar_agendas/verificarPosicionAgenda/1/2/3/'+id;
 respuesta='false';
var ajax1 = new Request(
{       
        url: var_url,
        async: false,
        onSuccess: function(html){ 
            respuesta=html;
            //$('lista_especialidades').set('html', html)
                   },
        evalScripts: true,
        onFailure: function(){alert('Error verificando agenda');
        }

});
ajax1.send();
return respuesta;
}
 //////////////////////////////////////////////////////////////////////////
 function actualizarListaMedico()
 {
    var var_url = '<?=site_url()?>/agenda/programar_agenda/listar_especialistas_por_especialidad/'+$('id_especialidad').value;
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
        actualizarConsultorios();
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
  cargarAgenda();
	    	
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
////////////////////////////////////////////////////////////////////////////////
function adicionarDatosAgenda()
{
    
    var fecha=$('fecha_agenda').value;
    for(i=parseInt($('intervalo_inicial').value);i<=parseInt($('intervalo_final').value);i++)
        {
    var var_url = '<?=site_url()?>/agenda/programar_agenda/agregar_dato_agenda/'+$('medico_disponibilidad').value+'/'+$('consultorio').value+'/'+fecha+'/'+i;
    var ajax1 = new Request(
	{       
		url: var_url,
		onSuccess: function(html){ 
                                 },
		evalScripts: true,
		onFailure: function(){alert('Error ingresando dato agenda');
                }
		
	});
	ajax1.send();
        }
        cargarAgenda();
}

////////////////////////////////////////////////////////////////////////////////
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
    var var_url="";
    if($('medico_disponibilidad').value=="")
        var_url = '<?=site_url()?>/agenda/programar_agenda/consultorios_especialidad/-1';
    else   
        var_url = '<?=site_url()?>/agenda/programar_agenda/consultorios_especialidad/'+$('medico_disponibilidad').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                    $('consultorios_especialidades').set('html',html);
                    //$('lista_especialidades').set('html', html)
                           },
		evalScripts: true,
		onFailure: function(){alert('Error verificando agenda');
                }
		
	});
	ajax1.send();  
        //actualizarListaMedico();
}
///////////////////////////////////////////////////////////////////////////////
//
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
   if(parseInt($('intervalo_inicial').value)>parseInt($('intervalo_final').value))
       {
           alert('El rango inicial no puede ser mayor al rango final');
           return false;
       }
   for(i=parseInt($('intervalo_inicial').value);i<=parseInt($('intervalo_final').value);i++)
   {
       if($('item-'+i+'-'+$('consultorio').value).innerHTML!="")
           {
              alert('Elemento de agenda se encuentra ocupado');
               return false;
           }
   }
   
   for(i=parseInt($('intervalo_inicial').value);i<=parseInt($('intervalo_final').value);i++)
   {
       if($('item-'+i+'-'+$('consultorio').value).innerHTML!="")
           {
              alert('Elemento de agenda se encuentra ocupado');
               return false;
           }
   }
   if(medico_ocupado_hora())
       {
           alert('Médico ya se encuentra programado en el intérvalo de tiempo');
               return false;
       }
   if(confirm('Los datos se registrarán en la agenda ¿Esta seguro que desea continuar?'))
	{
           agregar_agenda()
        }
   return false;
   
}
/////////////////////////////////////////////////////////////////////////////////
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
////////////////////////////////////////////////////////////////////////////////
function eliminar_agenda()
{
    
    if(confirm('Los datos se eliminarán de la agenda y afectarán las citas asignadas. ¿Esta seguro que desea continuar?'))
	{
            
        
    var_url = '<?=site_url()?>/agenda/programar_agenda/eliminar_agenda/'+ $('fecha_agenda').value+'/'+$('id_consultorio_eliminacion').value+'/'+$('intervalo_inicial_eliminacion').value+'/'+$('intervalo_final_eliminacion').value;
    var ajax1 = new Request(
	{       
		url: var_url,
                async: false,
		onSuccess: function(html){ 
                   //$('lista_especialidades').set('html', html)
                           },
		evalScripts: true,
		onFailure: function(){alert('Error eliminando agenda');
                }
		
	});
	ajax1.send();  
        }
    cargarAgenda();
    return false;
}
////////////////////////////////////////////////////////////////////////////////
function copiar_agenda()
{
    return false;
}
///////////////////////////////////////////////////////////////////////////////
function mostrar_agregar()
{
    $('nuevo_item_agenda').style.display=""
    $('borrar_agenda').style.display="none"
}
///////////////////////////////////////////////////////////////////////////////
function mostrar_eliminar()
{
    $('nuevo_item_agenda').style.display="none"
    $('borrar_agenda').style.display=""
}
</script>
<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Programación Agendas Médicos</h2>
<div id="carga_agenda">
    <h2 class="subtitulo">Ingresar Item Agenda</h2> 
    <table width="100%" class="tabla_form">
<tr><th colspan="2">Parametro Agenda</th></tr>
<tr><td colspan="2">
    <?php
$attributes = array('id'=> 'formulario_carga_agenda','name'=> 'formulario_carga_agenda',
                    'method' => 'post','onsubmit'=> 'return recargarAgenda()');
echo form_open('',$attributes);
?>
<table width="60%" class="tabla_interna">
<tr>
  <td class="campo">Fecha Agenda Cargar:</td>
  <td class="campo"><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
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
  <td class="campo"><?=form_submit('boton', 'Traer Agenda')?></td>
</tr>
</table>
<?=form_close();?>
        </td></tr>
    </table>
</div>
<input type="radio" name="acciones" value="agregar" onClick="mostrar_agregar()" checked> Agregar Programación
<input type="radio" name="acciones" value="eliminar" onClick="mostrar_eliminar()"> Eliminar Items Agenda
<div id="nuevo_item_agenda">
    <h2 class="subtitulo">Programar Agenda</h2> 
    <table width="100%" class="tabla_form">
<tr><th colspan="2">Adicionar Items</th></tr>
<tr><td colspan="2">
    <?php
$attributes = array('id'=> 'formulario','name'=> 'formulario',
                    'method' => 'post','onsubmit'=> 'return validarFormulario()');
echo form_open('agenda/main/agregarParametroAgenda',$attributes);
?>
    </td></tr>
    </table>
    <table width="100%">
<tr>
  <td><table><tr>
    <td class="campo_izquierda">Especialidad:</td><td id="lista_especialidadess"><?=form_dropdown('id_especialidad',$listadoEspecialidades,'-1','id="id_especialidad" onChange="actualizarListaMedico()"')?></td>
  </td></tr> </table>
</tr>
<tr>
  <td><table><tr>
     <td class="campo_izquierda">Especialista:</td><td id="lista_medicos_consultorio"></td></tr>
  </td></tr></table>
</tr>
<tr>
    <td> 
        <table>
            <tr>
                <td class="campo">Hora Inicio:</td><td id="hora_seleccionada"><?=form_dropdown('intervalo_inicial',$horarios,'','id="intervalo_inicial"');?></td>
                <td class="campo">Hora Final:</td><td id="hora_seleccionada"><?=form_dropdown('intervalo_final',$horarios,'','id="intervalo_final"');?></td>
                <td class="campo">Consultorio:</td><td id="consultorios_especialidades"></td>
            </tr>
        </table>
    </td>
</tr>
<td class="campo_izquierda"><?=form_submit('boton', 'Agregar')?></td>
</table>
 <?=form_close();?>
    <script>
    actualizarListaMedico();
    actualizarConsultorios();
    </script>
</div>
<div id="borrar_agenda" style="display: none">
    <?php
$attributes = array('id'=> 'formulario_eliminacion','name'=> 'formulario',
                    'method' => 'post','onsubmit'=> 'return eliminar_agenda()');
echo form_open('',$attributes);
?>
    <h2 class="subtitulo">Programar Agenda</h2> 
    <table width="100%" class="tabla_form">
<tr><th colspan="2">Eliminar Datos</th></tr>
<tr><td colspan="2">
    <table>
            <tr>
                <td class="campo">Hora Inicio:</td><td id="hora_seleccionada"><?=form_dropdown('intervalo_inicial_eliminacion',$horarios,'','id="intervalo_inicial_eliminacion"');?></td>
                <td class="campo">Hora Final:</td><td id="hora_seleccionada"><?=form_dropdown('intervalo_final_eliminacion',$horarios,'','id="intervalo_final_eliminacion"');?></td>
                <td class="campo">Consultorio:</td><td><?=form_dropdown('id_consultorio_eliminacion',$options_array_consultorio_selected,'','id="id_consultorio_eliminacion"');?></td>
                <td class="campo_izquierda"><?=form_submit('boton', 'Eliminar')?></td>
            </tr>
        </table>
    </td>
</Tr>
    </table>
     <?=form_close();?>
</div>

<div id="programacion_agenda"></div>
