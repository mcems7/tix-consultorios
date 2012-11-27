<script language="javascript">
function validarFormulario()
{	
	var p_a= $('principio_activo').value;
	
	if(p_a == 0){
		alert("Debe seleccionar un principio activo de la lista!!");
		return false;}
	
		for(i=0; i <document.formulario.estado.length; i++){
    if(document.formulario.estado[i].checked){
      var val = document.formulario.estado[i].value;}
    }
	if(!(val == 'Activo' || val == 'Inactivo')){
		alert("Debe seleccionar el estado del medicamento!!");
		return false;
	}
	
	
	for(i=0; i <document.formulario.pos.length; i++){
    if(document.formulario.pos[i].checked){
      var val = document.formulario.pos[i].value;}
    }
	if(!(val == 'SI' || val == 'NO')){
		alert("Debe seleccionar si el medicamento es POS o NO POS!!");
		return false;
	}
	
		if(confirm('¿Está seguro de guardar la información?')){
		return true;
	}else{
		return false;
	}	
	
}
</script>
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td colspan="2" class="campo_centro">Información del medicamento</td></tr>
<tr>
<td class="campo" width="40%">Producto:</td>
<td width="60%"><?php
if($tipo == 'edit')
	$valor = $producto['producto'];
else
	$valor = '';
echo form_textarea(array('name' => 'producto',
							'id'=> 'producto',
							'rows' => '2',
							'value' => $valor,
							'style' => 'width:100%',
							'class' => "fValidate['required']"))?></td>
</tr>
<tr>
<td class="campo">Laboratorio:</td>
<td><?php 
if($tipo == 'edit')
	$valor = $producto['marca'];
else
	$valor = '';
echo form_input(array('name' => 'marca',
	'id'=> 'marca',
	'maxlength' => '150',
	'size' => '60',
	'value' => $valor,
	'class'=>"fValidate['alphanumtilde']"))?></td>
</tr>
<tr>
<td class="campo">Registro sanitario:</td>
<td><?php
if($tipo == 'edit')
	$valor = $producto['invima'];
else
	$valor = '';
echo form_input(array('name' => 'invima',
	'id'=> 'invima',
	'maxlength' => '25',
	'size' => '25',
	'value' => $valor,
	'class'=>"fValidate['required']"))?></td>
</tr>
<tr>
<td class="campo">CUM:</td>
<td><?php 
if($tipo == 'edit')
	$valor = $producto['cum'];
else
	$valor = '';
echo form_input(array('name' => 'cum',
	'id'=> 'cum',
	'maxlength' => '25',
	'size' => '25',
	'value' => $valor,
	'class'=>"fValidate['required']"))?></td>
</tr>
<tr>
<td class="campo">ATC:</td>
<td><?php
if($tipo == 'edit')
	$valor = $producto['atc'];
else
	$valor = '';
echo form_input(array('name' => 'atc',
	'id'=> 'atc',
	'maxlength' => '15',
	'size' => '15',
	'value' => $valor,
	'class'=>"fValidate['required']"))?></td>
</tr>
<tr>
<td class="campo">Principio activo:</td>
<td>
<select name="principio_activo" id="principio_activo">
<?php
	if($tipo == 'edit'){
		foreach($principio_activo as $data)
		{
			if($data['principio_activo'] == $producto['principio_activo'])
			echo '<option value="'.$data['principio_activo'].'" selected="selected">'.$data['principio_activo'].'</option>';
			else
			echo '<option value="'.$data['principio_activo'].'">'.$data['principio_activo'].'</option>';	
			
		}
	}else{
?>
<option value="0" selected="selected">-Seleccione uno-</option>
<?php
		foreach($principio_activo as $data)
		{
			echo '<option value="'.$data['principio_activo'].'">'.$data['principio_activo'].'</option>';	
		}
	}
?>
</select>
</td>
</tr>
<tr>
<td class="campo">Descripción:</td>
<td><?php
if($tipo == 'edit')
	$valor = $producto['descripcion'];
else
	$valor = '';
echo form_input(array('name' => 'descripcion',
	'id'=> 'descripcion',
	'maxlength' => '150',
	'size' => '60',
	'value' => $valor,
	'class'=>"fValidate['required']"))?></td>
</tr>
<tr>
<td class="campo">Estado:</td>
<td>
<?php
$activo = false;
$inactivo = false;	
if($tipo == 'edit'){
	($producto['estado'] == 'Activo')? $activo = true: $activo = false;
	($producto['estado'] == 'Inactivo')? $inactivo = true: $inactivo = false;
}	
$data = array(
	'name' => 'estado',
	'value' => 'Activo',
	'checked' => $activo
	);
echo form_radio($data),nbs(),'Activo';
$data = array(
    'name'        => 'estado',
    'value'       => 'Inactivo',
	'checked' => $inactivo);
echo nbs(),form_radio($data),nbs(),'Inactivo';
?></td>
</tr>
<tr>
<td class="campo">Plan obligatorio de salud:</td>
<td>
<?php
$pos = false;
$nopos = false;	
if($tipo == 'edit'){
	($producto['pos'] == 'SI')? $pos = true: $pos = false;
	($producto['pos'] == 'NO')? $nopos = true: $nopos = false;
}	
$data = array(
	'name' => 'pos',
	'value' => 'SI',
	'checked' => $pos);
echo form_radio($data),nbs(),'SI';
$data = array(
    'name'        => 'pos',
    'value'       => 'NO',
	'checked' => $nopos);
echo nbs(),form_radio($data),nbs(),'NO';
?></td>
</tr>
</table>