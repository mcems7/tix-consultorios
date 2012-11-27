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
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
	echo form_open('/inve/inve_admin_productos/editarProducto_',$attributes);
	echo form_hidden('id_producto',$producto['id_producto']);
?>
<h1 class="tituloppal">Módulo de inventario</h1>
<h2 class="subtitulo">Editar un producto</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="4">Datos del producto</th></tr>
<tr>
<td class="campo">Tipo de producto:</td>
<td>
<?=$producto['tipo_producto']?>
</td>
<td class="campo">Fecha creación:</td><td><?=$producto['fecha_creacion']?></td></tr>
<tr><td colspan="4">
<?php
$d = array();
$d['producto'] = $producto;
$d['tipo'] = 'edit';
if($producto['tipo_producto'] == 'Medicamento'){
	$d['principio_activo'] = $principio_activo;
	echo $this->load->view('inve/inve_producto_crear_medi',$d);
}else if($producto['tipo_producto'] == 'Insumo'){
	echo $this->load->view('inve/inve_producto_crear_insu',$d);
}else{
	echo "Error";
}	
?>
</td></tr>
<tr><td colspan="4" align="center">
<?
$data = array(	'name' => 'bv',
	'id' => 'bv',
	'onclick' => 'regresar()',
	'value' => 'Volver',
	'type' =>'button');
echo form_input($data),nbs();
?>
<?=form_submit('boton', 'Guardar')?>
</td></tr>
</table>
<?=form_close();?>
</center>