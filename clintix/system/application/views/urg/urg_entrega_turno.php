<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
		 
});
///////////////////////////////////////////////////////////////////////////////
function obtenerSala()
{
	var sala = $('id_servicio').value;
	if(sala == 0){
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/entrega_turno/listadoPacientesServicio';
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

function validarFormulario()
{
	var ser = $('id_servicio').value;
	if(ser == 0){
			alert("Debe seleccionar un servicio!!");
			return false;
	}
	
	var seleccion = document.formulario.elements["seleccion[]"];
	var cont = 0;
	for(i=0;i<seleccion.length;i++)
	{
		if(seleccion[i].checked)
			cont++;
	}
	if(cont <= 0){
		alert("No ha seleccionado ningun paciente de la lista!!");
		return false;
	}
	return true;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('urg/entrega_turno/pacientes_seleccionados',$attributes);
?>
<h1 class="tituloppal">Servicio de urgencias - Entrega de turno</h1>
<h3 class="subtitulo">
<?=$medico['primer_nombre'].' '.$medico['segundo_nombre'].' '.$medico['primer_apellido'].' '.$medico['segundo_apellido']?></h3>
<table width="100%" class="tabla_form">
<tr><th style="text-align:right">
Sala de observación:<?=nbs()?>
<select name="id_servicio" id="id_servicio" onchange="obtenerSala()">
  <option value="0">-Seleccione una-</option>
  <option value="16">Observación adultos</option>
  <option value="17">Observación pediatría</option>
  <option value="18">Observación psiquiatría</option>
  <option value="19">Observación ginecobstetricia</option>
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
echo form_input($data).nbs();
echo form_submit('boton', 'Continuar');
?>
</td></tr>
</table>
<?=form_close();?>
