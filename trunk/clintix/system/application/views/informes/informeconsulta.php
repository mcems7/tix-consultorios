<script type="text/javascript">
///////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
function informe()
{
	var var_url = '<?=site_url()?>/informes/consulta/informe/';
	
	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){},
		onSuccess: function(html){$('con_ord').set('html', html);},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}






</script>
<h1 class="tituloppal">Informe</h1>
<h2 class="subtitulo">Consulta externa</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">



<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Ordenes realizadas</th></tr>
<tr>
<td>
<div id="con_ord">

</div>
<?php 

$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);

?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<td class="campo"><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
<img src='http://localhost/yage/resources/img/calendario_boton.png' id='fec leha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
<script type='text/javascript'>
Calendar.setup({
inputField : 'fecha_agenda', // id of the input field
ifFormat : '%Y-%m-%d',
daFormat : '%Y-%m-%d', // format of the input field
displayArea	 :	'fecha_agenda',
showsTime :	true,
timeFormat : '12',
button : 'fecha_agenda_botton', // trigger for the calendar (button ID)
align : 'Br', // alignment (defaults to 'Bl')
singleClick : true
});
</script></td>
<td class="campo"><input name="fecha_final" type="text" id="fecha_final" value="" size="10" maxlength="10" READONLY="readonly">
<img src='http://localhost/yage/resources/img/calendario_boton.png' id='fec leha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
<script type='text/javascript'>
Calendar.setup({
inputField : 'fecha_final', // id of the input field
ifFormat : '%Y-%m-%d',
daFormat : '%Y-%m-%d', // format of the input field
displayArea	 :	'fecha_final',
showsTime :	true,
timeFormat : '12',
button : 'fecha_agenda_botton', // trigger for the calendar (button ID)
align : 'Br', // alignment (defaults to 'Bl')
singleClick : true
});
</script></td>
<td> 
<?

//$js = 'onClick="informe()"';

//echo form_submit('boton', 'informe',$js)
?>
<input type="button" name="boton" onclick="informe()" value="Calcular" />
</td>

</table>
</table>