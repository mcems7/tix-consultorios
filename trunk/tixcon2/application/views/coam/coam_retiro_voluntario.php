<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	
	if(confirm('La atención del paciente finalizara\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/coam/coam_gestion_atencion/retiro_voluntario_',$attributes);
$username = $this->session->userdata('_username');
echo form_hidden('id_atencion',$atencion['id_atencion']);
?>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Retiro voluntario</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
<td class="campo">Fecha y hora de ingreso:</td>
<td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
</tr>
</table>
</td>
</tr>
<tr><td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
  <tr>
<td class="campo">Nombre de usuario:</td>
<td><?=$username?></td>
</tr>
<tr>
<td class="campo">Contrase&ntilde;a:</td>
<td>
		<?=form_password(array('name' => 'password',
							'id'=> 'password',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['required']"))?>
		
	
		
		</td>
	</tr>
</table>
</td></tr>
<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<?php
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
echo form_submit('boton', 'Retiro voluntario');
?>
</td></tr>
</table>
</center>
<?=form_close();?>
