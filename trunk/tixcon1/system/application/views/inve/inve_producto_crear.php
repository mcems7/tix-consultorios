<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function obtener_formulario()
{
	var tipo = $('tipo_producto').value;
	
	var var_url = '<?=site_url()?>/inve/inve_admin_productos/form_crear_producto/'+tipo;
	var ajax1 = new Request(
	{
		url: var_url,
		evalScripts: true,
		onSuccess: function(html){$('div_formulario_crear_producto').set('html', html);},
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
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
	echo form_open('/inve/inve_admin_productos/crearProducto_',$attributes);
?>
<h1 class="tituloppal">Módulo de inventario</h1>
<h2 class="subtitulo">Crear un producto</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="4">Datos del producto</th></tr>
<tr>
<td class="campo">Tipo de producto:</td>
<td>
<?php
$options = array('0'  => '-Seleccione uno-',
                  'Medicamento'    => 'Medicamento',
                  'Insumo'   => 'Insumo');
$js = 'id="tipo_producto" onChange="obtener_formulario();"';
echo form_dropdown('tipo_producto', $options, '0',$js);
?>
</td>
<td class="campo">Fecha creación:</td><td><?=date("Y-m-d")?></td></tr>
<tr><td id='div_formulario_crear_producto' colspan="4">

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