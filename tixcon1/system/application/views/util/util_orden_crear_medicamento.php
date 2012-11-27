<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Crear medicamento</title>
<script type="text/javascript" src="<?=base_url()?>resources/js/mootools1-2-0.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/fValidator.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/mediabox.js"></script>
<link rel="stylesheet" href="<?=base_url()?>resources/styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/general.css" type="text/css" media="screen" />
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
});
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	var pos_si = $('pos_si').checked;
	
	var pos_no = $('pos_no').checked;
	
	if( !(pos_si || pos_no )){
		alert('Debe seleccionar si el medicamento se encuentra en el plan obligatorio de salud!!');
		return false;
	}
	
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
</script>
</head>
<body>
<center>
<?=br(3)?>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Crear medicamento</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/util/ordenes/crearMedicamento_',$attributes);
?>
<table width="95%" class="tabla_form">
<td class="campo">Medicamento:</td><td>
<?=form_input(array('name' => 'medicamento',
								'id'=> 'medicamento',
								'maxlength' => '255',
								'size'=> '60',
								'class'=>"fValidate['required']"))?></td></tr>
<tr><td class="campo">PLan obligatorio de salud (POS):</td>
<td>

      <input type="radio" name="pos" value="SI" id="pos_si" />
      SI
      <input type="radio" name="pos" value="NO" id="pos_no" />
      NO</td></tr>

<tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<?=form_close();?>

</body>
</html>