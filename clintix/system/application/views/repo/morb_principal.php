<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function generar()
{
	var var_url = '<?=site_url()?>/repo/rep_morbilidad/obtener_datos';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_resultado').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function restablecer()
{
	$('fecha_inicio').value = '';
	$('fecha_fin').value = '';
}
</script>
<h1 class="tituloppal">M&oacute;dulo de reportes - Urgencias</h1>
<h2 class="subtitulo">Morbilidad servicio de urgencias</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="95%" class="tabla_form">
<tr><th>Parametros</th></tr>
<tr><td align="center">
<table class="tabla_interna" width="95%">
<tr><td class="campo" width="30%">Servicio:</td>
<td width="70%">
<select name="servicio">
  <option value="0" selected="selected">Todos</option>
  <option value="1">Adultos</option>
  <option value="2">Pediatria</option>
  <option value="3">Ginecobstetricia</option>
</select>
</td></tr>
<tr><td class="campo">Rango de fechas:</td><td>Inicio:&nbsp;<input name="fecha_inicio" type="text" id="fecha_inicio" value="" size="10" maxlength="10" READONLY="readonly" class="fValidate['dateISO8601']">
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
                            </script>&nbsp;Fin:&nbsp;
                            <input name="fecha_fin" type="text" id="fecha_fin" value="" size="10" maxlength="10" READONLY="readonly" class="fValidate['dateISO8601']">
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
<?php
$data = array(	'name' => 'bv',
				'onclick' => 'restablecer()',
				'value' => 'Restablecer',
				'type' =>'button');
echo nbs().form_input($data);
?>
</td></tr>
<tr><td class="campo">Número de registros:</td>
<td><select name="total" id="total">
  <option value="10" selected="selected">10</option>
  <option value="20">20</option>
  <option value="30">30</option>
</select></td></tr>
</table>
</td></tr>
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data).nbs();

$data = array(	'name' => 'bv',
				'onclick' => 'generar()',
				'value' => 'Generar',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
<tr><td>
<div id="div_resultado">

</div>
</td></tr>
</table>
<?=form_close();?>