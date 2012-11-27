<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	filtrar();					 
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function filtrar()
{
	var var_url = '<?=site_url()?>/urg/admision/listadoPacientesUrgencias';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('tabla_lista').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();			
}
function admisionPaciente(id_atencion)
{
	if(confirm('¿Desea realizar la admisión del paciente?'))
	{
		document.location = '<?=site_url()?>/urg/admision/admisionPaciente/'+id_atencion;
		return true;
	}
	else
	{
		return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
?>
<h1 class="tituloppal">Servicio de urgencias - Admisiones</h1>
<h2 class="subtitulo">Listado de pacientes que han ingresado al servicio de urgencias</h2>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);
?>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">
Admisi&oacute;n:
&nbsp;SI
<input name="admision" id="admision" type="radio" value="SI" onChange='filtrar()' />
&nbsp;No<input name="admision" id="admision" type="radio" value="NO" checked="checked" onChange='filtrar()'/>
<tr><td>
<div id="tabla_lista">

</div>
<tr><td align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</center>
<?=form_close();?>
