<script type="text/javascript">

////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	return true;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - M&oacute;dulo de Enfermer&iacute;a</h1>
<h2 class="subtitulo">Registro nota de enfermer&iacute;a</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/notas_enfermeria/crearNota_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr>
<td colspan='2'>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
  <tr>
    <td class="campo">Motivo de consulta:</td>
    <td><?=$consulta['motivo_consulta']?>&nbsp;</td>
  </tr>
</table>

</td>
</tr>
<tr>
  <th colspan="2">Datos nota de enfermer&iacute;a</th></tr>
<tr>
<td class="campo">Subjetivo:</td><td>
<?=form_textarea(array('name' => 'subjetivo',
								'id'=> 'subjetivo',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '45'))?></td></tr>
<tr><td class="campo">Objetivo:</td>
<td><?=form_textarea(array('name' => 'objetivo',
								'id'=> 'objetivo',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '45'))?></td></tr>

<tr>
<td class="campo">Actividades:</td>
<td><?=form_textarea(array('name' => 'actividades',
							'id'=> 'actividades',
							'rows' => '5',
							'class' => "fValidate['required']",
							'cols'=> '45'))?></td></tr>
                            <tr>
<tr>
<td class="campo">Pendientes:</td>
<td><?=form_textarea(array('name' => 'pendientes',
							'id'=> 'pendientes',
							'rows' => '5',
							
							'cols'=> '45'))?></td></tr>
                            <tr>

<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
<?=form_close();?>
</td></tr></table>
