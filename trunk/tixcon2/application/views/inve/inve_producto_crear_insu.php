<?php
echo form_hidden('principio_activo','');
echo form_hidden('cum','');
echo form_hidden('atc','');
echo form_hidden('invima','');
echo form_hidden('pos','NA');
?>
<script language="javascript">
function validarFormulario()
{	
	for(i=0; i <document.formulario.estado.length; i++){
    if(document.formulario.estado[i].checked){
      var val = document.formulario.estado[i].value;}
    }
	if(!(val == 'Activo' || val == 'Inactivo')){
		alert("Debe seleccionar el estado del insumo!!");
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
<tr>
  <td colspan="2" class="campo_centro">Información del insumo</td></tr>
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
<td class="campo">Marca:</td>
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
</table>