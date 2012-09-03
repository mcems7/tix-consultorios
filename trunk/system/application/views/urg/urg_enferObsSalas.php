<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	obtenerSala();					 
});
////////////////////////////////////////////////////////////////////////////////
function ingresoObservacion(id_obs)
{
	if(confirm('¿Desea realizar el ingreso del paciente a observación?'))
	{
		var div = 'cama'+id_obs;
		var var_url = '<?=site_url()?>/urg/enfermeria_obs/ingresoObservacion/'+id_obs;
		var ajax1 = new Request(
		{
			url: var_url,
			onSuccess: function(html){$(div).set('html', html);},
			evalScripts: true,
			onFailure: function(){alert('Error ejecutando ajax!');}
		});
		ajax1.send();	
	}
	else
	{
		return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function asignarCama(id_obs)
{
	var cama = $('id_cama').value;
	if(cama == 0){
		alert('Seleccione la cama a ser asignada!!');
	return false;	
		}
	
	var div = 'cama'+id_obs;
	var var_url = '<?=site_url()?>/urg/enfermeria_obs/ingresoObservacionCama/'+id_obs+'/'+cama;
	var ajax1 = new Request(
	{
		url: var_url,
		onSuccess: function(html){$(div).set('html', html);},
		onComplete: function(){obtenerSala();},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////

////////////////////////////////////////////////////////////////////////////////
function obtenerSala()
{
	var sala = $('salasObs').value;
	if(sala == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/enfermeria_obs/listadoPacientesSala';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_sala').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function activarCama(id_cama)
{
	var sala = $('salasObs').value;
	if(sala == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/enfermeria_obs/activarCama/'+id_cama;
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_detalle_sala').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		

}
///////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);
?>
<h1 class="tituloppal">Servicio de urgencias - M&oacute;dulo de enfermería</h1>
<h1 class="tituloppal">Observaci&oacute;n</h1>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<table width="100%" class="tabla_form">
<tr><th style="text-align:right">
Salas de observación:&nbsp;
<?php
$id = $this->session->userdata('id_salaObs');
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


<select name="salasObs" id="salasObs" onchange="obtenerSala()">
  <option value="0" <?=$res5?>>-Seleccione una-</option>
  <option value="16"<?=$res1?>>Observación adultos</option>
  <option value="17"<?=$res2?>>Observación pediatría</option>
  <option value="18"<?=$res3?>>Observación psiquiatría</option>
  <option value="19"<?=$res4?>>Observación ginecobstetricia</option>
  <option value="0">Todas</option>
 <?php
 	foreach($estados as $d)
	{
		echo '<option value="'.$d['id_estado'].'">'.$d['estado'].'</option>';	
	}
 ?>
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
