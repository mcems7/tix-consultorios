<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){	 
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
		document.location = "<?php echo $urlRegresar; ?>";	
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{

	var fi = $('fecha_inicio').value;
	var ff = $('fecha_fin').value;
	
	if( (fi.length == 0) || (ff.length  == 0) ){
		alert("Debe seleccionar un rango de fechas valido!!");
		return false;
	}
	return true;
}
////////////////////////////////////////////////////////////////////////////////
function buscar()
{
	if(!validarFormulario())
		return false;
	
	var var_url = '<?=site_url()?>/urg/consulta_entrega_turno/buscar';
	var ajax1 = new Request(
	{
		url: var_url,
		method:'post',
		evalScripts: true,
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_lista').set('html', html);
		$('div_precarga').style.display = "none";},
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('urg/entrega_turno/pacientes_seleccionados',$attributes);
?>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Consulta entrega de turno</h2>
<center>
<table width="98%" class="tabla_form">
<tr><th>Buscar entregas de turno</th></tr>
<tr><td>Seleccione alguno de los criterios de búsqueda disponibles para obtener los registros de las entregas de turno que concuerden con la información suministrada como parámetro.</td></tr>
<tr><td>

<table width="100%" class="tabla_interna">
<tr>
<td class="campo">Fecha:</td><td>De:&nbsp;<input name="fecha_inicio" type="text" id="fecha_inicio" value="" size="18" maxlength="20" READONLY="readonly" class="fValidate['required']">
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_inicio_b' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_inicio',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d',
                                daFormat       :    '%Y-%m-%d',          // format of the input field
                                displayArea	   :	'fecha_inicio',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_inicio_b',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>&nbsp;Hasta:&nbsp;<input name="fecha_fin" type="text" id="fecha_fin" value="" size="18" maxlength="20" READONLY="readonly" class="fValidate['required']">
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_fin_b' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_fin',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d',
                                daFormat       :    '%Y-%m-%d',          // format of the input field
                                displayArea	   :	'fecha_fin',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_fin_b',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>
</tr>
<tr>
<td class="campo">Servicio:</td>
<td>
<select name="id_servicio" id="id_servicio">
    <option value="0">Todos</option>
    <option value="16">Observación adultos</option>
    <option value="17">Observación pediatría</option>
    <option value="18">Observación psiquiatría</option>
    <option value="19">Observación ginecobstetricia</option>
</select>
</td>
</tr>
</table>

</td></tr>
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'bb',
				'onclick' => 'buscar()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?=form_close();?>
<div id="div_lista">
</div>