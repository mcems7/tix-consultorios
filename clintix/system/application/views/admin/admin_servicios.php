<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerServicio();					 
});
////////////////////////////////////////////////////////////////////////////////
function obtenerServicio()
{
	var sala = $('id_servicio').value;
	if(sala == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/admin/main/listadoPacientesServicio';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_servicio').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
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
<h1 class="tituloppal">Gesti&oacute;n administrativa del paciente</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr><th style="text-align:right">
Salas de observación:&nbsp;
<?php
$id = $this->session->userdata('id_servicioAdmin');
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
$res5 = '';
if($id == 16){
	$res1 = 'selected="selected"';
}else if($id == 17){
	$res2 = 'selected="selected"';
}else if($id == 18){
	$res3 = 'selected="selected"';
}else if($id == 19){
	$res4 = 'selected="selected"';
}else{
	$res5 = 'selected="selected"';
}
?>


<select name="id_servicio" id="id_servicio" onchange="obtenerServicio()">
  <option value="0" <?=$res5?>>-Seleccione una-</option>
  <option value="16"<?=$res1?>>Observación adultos</option>
  <option value="17"<?=$res2?>>Observación pediatría</option>
  <option value="18"<?=$res3?>>Observación psiquiatría</option>
  <option value="19"<?=$res4?>>Observación ginecobstetricia</option>
</select>
</th></tr>
<tr><td style="padding:0px">
<div id="div_detalle_servicio">
</div>
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
