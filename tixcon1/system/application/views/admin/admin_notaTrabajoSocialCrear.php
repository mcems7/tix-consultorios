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
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Gesti&oacute;n administrativa del paciente</h1>
<h2 class="subtitulo">Registro de una nota de trabajo social</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/admin/notas_trabajo_social/crearNota_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_funcionario',$funcionario['id_funcionario']);
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
  <th colspan="2">Datos de la evoluci&oacute;n</th></tr>
<tr>
<tr><td class="campo">Funcionario:</td>
<td><?=$funcionario['primer_apellido']." ".$funcionario['segundo_apellido']." ".$funcionario['primer_nombre']." ".$funcionario['segundo_nombre']?></td></tr>
<td class="campo">Titulo:</td><td>
<?=form_input(array('name'	=> 'titulo_nota',
					'id'	=> 'titulo_nota',
					'class'	=>"fValidate['required']",
					'maxlength' => '100',
					'size'=> '60'))?></td></tr>
<tr><td class="campo">Detalle nota:</td>
<td><?=form_textarea(array('name' => 'nota',
								'id'=> 'nota',
								'rows' => '5',
								'class'=>"fValidate['required']",
								'cols'=> '45'))?></td></tr>
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
