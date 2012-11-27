<script type="text/javascript">
//////////////////////////////////////////////////////
function validar()
{	
	var pass1 = $('_password').value;
	var pass2 = $('password').value;
	
	if(pass1 != pass2){
		alert('Las contraseñas no coinciden!!');
		return false;
	}
	if(confirm('¿Esta seguro de cambiar su contraseña?'))
	{
			return true
	}else{
			return false;
	}	
}
//////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
//////////////////////////////////////////////////////
</script>
<?php 
$attributes = array('id'   => 'formulario',
	                'name' => 'formulario',
					'onsubmit' => 'return validar()');
echo form_open("core/perfil/editar", $attributes); 
?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Perfil de usuario</h2>
<center>
<table width="70%" class="tabla_form">
<tr><th colspan="2">Contrase&ntilde;a</th></tr>
<tr>
<td class="campo">Nombre de usuario</td>
<td><?= $usuario['_username']; ?></td>
</tr>
<tr>
<td class="campo">Contrase&ntilde;a actual</td>
<td>
		<?=form_password(array('name' => 'passwordAct',
							'id'=> 'passwordAct',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['required']"))?>
		
	
		
		</td>
	</tr>
<tr>
<td class="campo">Contrase&ntilde;a</td>
<td>
		<?=form_password(array('name' => '_password',
							'id'=> '_password',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['required']"))?>
		
	
		
		</td>
	</tr>

	<tr>
		<td class='campo'>Confirmaci&oacute;n de contrase&ntilde;a</td>
		<td>

		<?=form_password(array('name' => 'password',
							'id'=> 'password',
							'maxlength' => '20',
							'size'=> '20',
							'class'=>"fValidate['required']"))?>
		
		</td>
	</tr>

</table>

<br />


  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>



<?php

echo form_close();

?>

<br />
