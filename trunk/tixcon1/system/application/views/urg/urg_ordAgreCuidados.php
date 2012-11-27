<table width="100%" cellspacing="0" cellpadding="0">
<tr>
<td class="campo">Cuidado:</td>
<td>
<select name="id_cuidado" id="id_cuidado">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
	foreach($cuidados as $d)
	{
		echo '<option value="'.$d['id_cuidado'].'">'.$d['cuidado'].'</option>';	
	}
?>
</select></td>
</tr>
<tr>
<td class="campo">Frecuencia:</td>
<td>Cada: <?=form_input(array('name' => 'frecuencia_cuidado',
						'id'=> 'frecuencia_cuidado',
						'maxlength' => '2',
						'size'=> '2',
						'value'=> '0',
						'class'=>"fValidate['integer']"))?>&nbsp;
<select name="id_frecuencia_cuidado" id="id_frecuencia_cuidado">
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
	foreach($frecuencia as $d)
	{
		echo '<option value="'.$d['id'].'">'.$d['descripcion'].'</option>';	
	}
?>
</select></td>
</tr>
</table>
<center>
<?
$data = array(	'name' => 'ba',
				'onclick' => 'agregarCuidado()',
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center>