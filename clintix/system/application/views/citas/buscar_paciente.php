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
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
	echo form_open('/citas/solicitar_cita/buscarPaciente',$attributes);
?>
<h1 class="tituloppal">Solicitud Citas - Consulta Externa</h1>
<h2 class="subtitulo">Buscar un paciente en el sistema</h2>
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
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Buscar')?></td></tr>
</table>
</center>
<?=form_close();?>
