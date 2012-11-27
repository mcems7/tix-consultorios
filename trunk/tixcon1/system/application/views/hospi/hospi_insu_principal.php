<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerOrdenesServicio();					 
});
////////////////////////////////////////////////////////////////////////////////
function obtenerOrdenesServicio()
{
	var var_url = '<?=site_url()?>/hospi/hospi_insumos/listadoOrdenesServicio';
	var ajax1 = new Request(
	{
		url: var_url,
		method:'post',
		evalScripts: true,
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_sala').set('html', html);
		$('div_precarga').style.display = "none";},
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
<h1 class="tituloppal">Servicio de urgencias - Ordenes medicas</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr>
  <th style="text-align:right">
Servicio:<?=nbs()?>
<?php
$id = $this->session->userdata('id_servicio');
$res0 = '';
$res1 = '';
$res2 = '';
$res3 = '';
$res4 = '';
$res5 = '';
$res6 = '';
$res7 = '';
$res8 = '';

if($id == 12){
	$res1 = 'selected="selected"';
}else if($id == 13){
	$res2 = 'selected="selected"';
}else if($id == 14){
	$res3 = 'selected="selected"';
}else if($id == 15){
	$res4 = 'selected="selected"';
}else if($id == 16){
	$res5 = 'selected="selected"';
}else if($id == 17){
	$res6 = 'selected="selected"';
}else if($id == 18){
	$res7 = 'selected="selected"';
}else if($id == 19){
	$res8 = 'selected="selected"';
}else{
	$res0 = 'selected="selected"';
}
?>
<select name="id_servicio" id="id_servicio" onchange="obtenerOrdenesServicio()">
  <option value="0"  <?=$res0?>>-Seleccione una-</option>
  <option value="12" <?=$res1?>>Urgencias Adultos</option>
  <option value="13" <?=$res2?>>Urgencias Pediátricas</option>
  <option value="14" <?=$res3?>>Urgencias Ginecobstétricas</option>
  <option value="15" <?=$res4?>>Urgencias Psiquiátricas</option>
  <option value="16" <?=$res5?>>Urgencias Observación Adultos</option>
  <option value="17" <?=$res6?>>Urgencias Observación Pedriáticas</option>
  <option value="18" <?=$res7?>>Urgencias Observación Psiquiátricas</option>
  <option value="19" <?=$res7?>>Urgencias Observación ginecobstetricia</option>
</select>
</th></tr>
<tr><td style="padding:0px">
<div id="div_detalle_sala">
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
