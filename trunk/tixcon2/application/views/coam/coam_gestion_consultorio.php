<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/calendario_agenda.css" type="text/css" media="screen" />
<script language="javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 obtener_agendas()
});
////////////////////////////////////////////////////////////////////////////////
function obtener_agendas()
{
	var var_url = '<?=site_url()?>/coam/coam_gestion_consultorio/obtenerAgendas';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_agenda').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);
?>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Gestión de consultorio</h2>
<center>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">
Fecha:&nbsp;
<input name="fecha" type="text" id="fecha" value="<?=date("Y-m-d")?>" size="10" maxlength="10" class="fValidate['dateISO8601']" onchange="obtener_agendas()">
 <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d',
                                daFormat       :    '%Y-%m-%d',          // format of the input field
                                displayArea	   :	'fecha',
                                showsTime      :	false,
                                timeFormat     :    '12',
                                button         :    'fecha_botton',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>
</th></tr>
<tr><td id="div_detalle_agenda">

</td></tr>
<tr><td class="linea_azul">&nbsp;</td></tr>
  <tr><td align="center">
  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
  </td></tr>
</table>
&nbsp;
</center>
<?=form_close();?>