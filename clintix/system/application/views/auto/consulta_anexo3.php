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
function buscar_paciente()
{
	var var_url = '<?=site_url()?>/auto/anexo3_consulta/buscarPaciente';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_listado').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Central de autorizaciones - Consulta anexo t&eacute;cnico 3</h1>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
	echo form_open('/auto/anexo3_consulta/buscarPaciente',$attributes);
?>
<center>
<table width="70%" class="tabla_form">
<tr><th colspan="2">Buscar paciente</th></tr>
<tr><td width="50%" class="campo">Número de documento del paciente:</td>
<td width="50%"><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20',
							'class'=>"fValidate['nit']"))?>
</td></tr>
<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'buscar_paciente()',
				'value' => 'Buscar',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<br />
<table width="100%" class="tabla_form">
<tr>
  <th>Resultados
</th></tr>
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
</center>
<?=form_close();?>
