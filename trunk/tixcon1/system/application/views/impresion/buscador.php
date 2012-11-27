<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	var exValidatorA = new fValidator("formulario");			 
});
////////////////////////////////////////////////////////////////////////////////
function validar()
{
	var elem = document.getElementsByName('criterio');
	for(i=0;i<elem.length;i++)
		if(elem[i].checked)
			var valor = elem[i].value;

	if((valor == 'documento' && $('numero_documento').value != '') || (valor == 'nombre' && $('nombre1').value != '' && $('apellido1').value != ''))
	{
		buscar();		
	}
	else
		alert('Parámetros incompletos!.\nPara buscar por documento debe proporcionar el número de documento del paciente.\nPara buscar por nombres debe proporcionar al menos el primer nombre y primer apellido del paciente');
}

function buscar()
{
	var var_url = '<?=site_url()?>/impresion/impresion/buscarPaciente';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data: $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_listado').set('html', html); 
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();
}

function activar(criterio)
{
	if(criterio == 'documento')
	{
		$('numero_documento').disabled = false;
		$('nombre1').disabled = true;
		$('nombre1').value = '';
		$('nombre2').disabled = true;
		$('nombre2').value = '';
		$('apellido1').disabled = true;
		$('apellido1').value = '';
		$('apellido2').disabled = true;
		$('apellido2').value = '';
		$('bv').disabled = false;
	}
	else
	{
		$('numero_documento').disabled = true;
		$('numero_documento').value = '';
		$('nombre1').disabled = false;
		$('nombre2').disabled = false;
		$('apellido1').disabled = false;
		$('apellido2').disabled = false;
		$('bv').disabled = false;
	}
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Consulta de historias cl&iacute;nicas</h1>
<?php
$attributes = array('id'     => 'formulario',
	                	'name'   => 'formulario',
										'method' => 'post');
echo form_open('/impresion/impresion/buscarPaciente',$attributes);
?>
<center>
<table width="70%" class="tabla_form">

<tr><th colspan="4">Buscar paciente</th></tr>
<tr><td width="50%" class="campo" colspan="2">Criterio de b&uacute;squeda:</td>
<td width="50%" colspan="2"><?=form_radio(
							array('name'    => 'criterio',
										'id'			=> 'criterio',
										'value'   => 'documento',
										'onclick' => 'activar(this.value);'));?> Documento
                    
                    <?=form_radio(
							array('name'    => 'criterio',
										'id'			=> 'criterio',
										'value'   => 'nombre',
										'onclick' => 'activar(this.value);'));?> Nombre
</td></tr>
<tr><td width="50%" class="campo" colspan="2">Número de documento:</td>
<td width="50%" colspan="2"><?=form_input(
							array('name' 			=> 'numero_documento',
										'id' 	 			=> 'numero_documento',
										'maxlength' => '20',
										'size' 			=> '20',
										'disabled'  => 'disabled',
										'class' 		=> "fValidate['nit']"))?>
</td></tr>
<tr><td width="50%" class="campo">Primer nombre:</td>
<td width="50%"><?=form_input(
							array('name' 			=> 'nombre1',
										'id' 	 			=> 'nombre1',
										'maxlength' => '20',
										'size' 			=> '20',
										'disabled'  => 'disabled',
										'class' 		=> "fValidate['alpha']"))?>
</td>
<td width="50%" class="campo">Segundo nombre:</td>
<td width="50%"><?=form_input(
							array('name' 			=> 'nombre2',
										'id' 	 			=> 'nombre2',
										'maxlength' => '20',
										'disabled'  => 'disabled',
										'size' 			=> '20'))?>
</td></tr>
<tr><td width="50%" class="campo">Primer apellido:</td>
<td width="50%"><?=form_input(
							array('name' 			=> 'apellido1',
										'id' 	 			=> 'apellido1',
										'maxlength' => '20',
										'size' 			=> '20',
										'disabled'  => 'disabled',
										'class' 		=> "fValidate['alpha']"))?>
</td>
<td width="50%" class="campo">Segundo apellido:</td>
<td width="50%"><?=form_input(
							array('name' 			=> 'apellido2',
										'id' 	 			=> 'apellido2',
										'maxlength' => '20',
										'disabled'  => 'disabled',
										'size' 			=> '20'))?>
</td></tr>
<tr><td colspan="4" align="center"><?
$data = array('name' 		 => 'bv',
							'id' 			 => 'bv',
							'onclick'  => 'validar()',
							'value'		 => 'Buscar',
							'disabled' => 'disabled',
							'type' 		 => 'button');
echo form_input($data);
?>
&nbsp;&nbsp;
<?
$data1 = array('name' 		=> 'bv',
							'onclick' => 'regresar()',
							'value' 	=> 'Volver',
							'type' 		=> 'button');
echo form_input($data1);
?>
</td></tr>
</table>
<br />
<div id="div_listado"></div>
</center>
<?=form_close(); ?>