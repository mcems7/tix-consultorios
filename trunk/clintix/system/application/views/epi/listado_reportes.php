<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function inactivarCaso(id_reporte)
{
 	if(!confirm("¿Esta seguro que desea inactivar el reporte?"))
	{
		return false;	
	}	
	
	var var_url = '<?=site_url()?>/epi/main/inactivar_reporte/'+id_reporte;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		obtenerListado()
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function activarCaso(id_reporte)
{
 	if(!confirm("¿Esta seguro que desea activar el reporte?"))
	{
		return false;	
	}	
	
	var var_url = '<?=site_url()?>/epi/main/activar_reporte/'+id_reporte;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		obtenerListado()
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{

	var fi = $('fecha_inicio').value;
	var ff = $('fecha_fin').value;
	
	if( !((fi.length == 0) && (ff.length  == 0)) )
	{
		if( !((fi.length > 0) && (ff.length  > 0)) ){
			alert("Debe seleccionar un rango de fechas valido!!");
			return false;	
		}
		
	}
	return true;
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
//obtenerListado();			 
});
////////////////////////////////////////////////////////////////////////////////
function obtenerListado()
{
	if(!validarFormulario())
		return false;
	
	var var_url = '<?=site_url()?>/epi/main/listado_reportes';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_listado').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		Mediabox.scanPage();	
			},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
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
<h1 class="tituloppal">Epidemiología - Listado reportes</h1>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Criterios de busqueda y filtrado de reportes</th></tr>
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
<td class="campo">Estado:</td>
<td>
<select name="estado" id="estado" onchange="obtenerListado()">
<option value="Activo" selected="selected">Activo</option>
<option value="Inactivo">Inactivo</option>
<option value="0">Todos los estados</option>
</select>
</td>
</tr>

</table>
</td></tr>
<tr>
  <td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'res',
				'value' => 'Restablecer',
				'type' =>'reset');
echo form_input($data).nbs();
$data = array(	'name' => 'bb',
				'onclick' => 'obtenerListado()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);
?></td></tr>
</table>
<?=br()?>
<table width="100%" class="tabla_form">
<tr>
  <th>Listado reportes</th></tr>
<tr><td style="padding:0px" id="div_listado">

</td></tr>
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?=form_close();?>
