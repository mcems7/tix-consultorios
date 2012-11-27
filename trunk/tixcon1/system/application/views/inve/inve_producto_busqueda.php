<script type="text/javascript">
sTipoProducto = null;
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
 
sTipoProducto = new Fx.Slide('div_medicamento');
sTipoProducto.hide();
 				 
});
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	return true;
}
////////////////////////////////////////////////////////////////////////////////
function formBusqueda(opcion)
{
	if(opcion == 'Medicamento'){
		sTipoProducto.slideIn();
	}else if(opcion == 'Insumo'){
			sTipoProducto.slideOut();
			$('cum').value = '';
			$('atc').value = '';
			$('principio_activo').value = '';
	}
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$this->load->helper('form');

$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/inve/inve_admin_productos/buscarProducto',$attributes);
?>
<h1 class="tituloppal">Módulo de inventario</h1>
<h2 class="subtitulo">Administración de productos</h2>
<center>
  <table width="100%" class="tabla_form">
  <tr>
    <th colspan="2">Criterios de búsqueda</th>
  </tr>
  <tr>
    <td class="campo" width="50%">Descripción:</td>
    <td width="50%"><?=form_input(array('name' => 'descripcion',
							'id'=> 'descripcion',
							'maxlength'   => '100',
							'size'=> '40'))?>
                            </td>
  </tr>
   <tr>
    <td class="campo">Tipo de producto:</td>
    <td><?php
$data = array(
	'name' => 'tipo_producto',
	'id' => 'tipo_producto',
	'value' => 'Medicamento',
	'onChange' => "formBusqueda('Medicamento')");
echo form_radio($data),nbs(),'Medicamento';
$data = array(
    'name'        => 'tipo_producto',
    'id'          => 'tipo_producto',
    'value'       => 'Insumo',
	'checked'     => TRUE,
	'onChange' => "formBusqueda('Insumo')");
echo nbs(),form_radio($data),nbs(),'Insumo';
?></td>
  </tr>
  <tr><td colspan="2">
  <table width="100%" id="div_medicamento">
   <tr>
    <td class="campo" width="50%">Principio activo:</td>
    <td width="50%"><?=form_input(array('name' => 'principio_activo',
							'id'=> 'principio_activo',
							'maxlength'   => '60',
							'size'=> '30'))?>***
                            </td>
  </tr>
    <tr>
    <td class="campo" width="50%">CUM:</td>
    <td width="50%"><?=form_input(array('name' => 'cum',
							'id'=> 'cum',
							'maxlength'   => '25',
							'size'=> '20'))?>
                            </td>
  </tr>
  <tr>
    <td class="campo">ATC:</td>
    <td><?=form_input(array('name' => 'atc',
							'id'=> 'atc',
							'maxlength'   => '15',
							'size'=> '20'))?>
                            </td>
  </tr>
  </table>
  </td></tr>
  <tr><td colspan="2" align="center">
<?=form_submit('boton', 'Buscar')?>
</td></tr>
<tr>
  <td colspan="2" class="opcion">
    <a href="<?=site_url('inve/inve_admin_productos/crearProducto')?>">Registrar un producto</a></td></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr>
  <th colspan="5">Listado de productos</th></tr>
<tr>
<td class="campo_centro">Tipo de producto</td>
<td class="campo_centro">Descripción</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Editar</td>
</tr>
<?php
	foreach($lista as $d)
	{
?>
<tr>
<td><?=$d['tipo_producto']?></td>
<td><?=($d['tipo_producto'] == "Medicamento") ? $d["principio_activo"].' '.$d["descripcion"] : $d['descripcion']?></td>
<td><?=$d['estado']?></td>
<td class="opcion"><a href="<?=site_url('inve/inve_admin_productos/editarProducto/'.$d['id_producto'])?>">Editar</a></td>
</tr>
<?php
	}
?>
</table>

</td></tr>
<tr><td colspan="2"><?=$this->pagination->create_links()?></td></tr>
<tr><td colspan="2" align="center">
  <?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);?>
</td></tr>
</table>
</center>
<?=form_close();?>