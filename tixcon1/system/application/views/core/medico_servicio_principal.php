<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	//obtenerServicio();					 
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
function buscar_medico()
{
	var var_url = '<?=site_url()?>/core/asignar_medico_servicio/obtenerMedicoDocumento';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_info_medico').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function asignar_medico(){
	var var_url = '<?=site_url()?>/core/asignar_medico_servicio/asignar_medico';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){},
		onSuccess: function(html){$('div_info_medico').set('html', html);},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
echo form_open('',$attributes);
?>
<h1 class="tituloppal">Administraci&oacute;n del sistema</h1>
<h2 class="subtitulo">Administrar personal asistencial en servicios de hospitalizaci&oacute;n</h2>
<table width="100%" class="tabla_form">
<tr><th>
Asignar servicio
</th></tr>
<tr><td align="center">

<table class="tabla_interna" width="100%">

		<tr>
			<td class="campo" width="50%">Número documento:</td>
			<td width="50%"><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'class'=>"fValidate['alphanumtilde']",
							'maxlength'   => '20',
							'size'=> '20')).nbs()?>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'buscar_medico()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);

?>							
							
 		</td>
		</tr>
        <tr><td colspan="2" id='div_info_medico'>
        
        </td></tr>
	</tbody>
</table>

</td></tr>
</table>
<?=br()?>
<table width="100%" class="tabla_form">
<tr><th>
Listado
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
