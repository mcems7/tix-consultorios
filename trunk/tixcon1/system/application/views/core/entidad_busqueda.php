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
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	return true;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$this->load->helper('form');

$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/core/administrar_entidades/buscarEntidad',$attributes);
?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Administración de las entidades administradoras de planes de beneficio</h2>
<center>
  <table width="100%" class="tabla_form">
  <tr>
    <th colspan="2">Criterios de búsqueda</th>
  </tr>
  <tr>
    <td class="campo">NIT:</td>
    <td><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20'))?>
                            </td>
  </tr>
   <tr>
    <td width="50%" class="campo">Razón social:</td>
    <td width="50%"><?=form_input(array('name' => 'razon_social',
					'id'=> 'razon_social',
					'maxlength'   => '60',
					'size'=> '60'))?>	</td>
  </tr>
  <tr><td colspan="2" align="center">
<?=form_submit('boton', 'Buscar')?>
</td></tr>
<tr>
  <td colspan="2" class="opcion">
    <a href="<?=site_url('core/administrar_entidades/crearEntidad')?>">Registrar una entidad administradora de planes de beneficio </a></td></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr>
  <th colspan="5">Listado de entidades</th></tr>
<tr>
<td class="campo_centro">Razón social</td>
<td class="campo_centro">NIT</td>
<td class="campo_centro">Código</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Editar</td>
</tr>
<?php
	foreach($lista as $d)
	{
?>
<tr>
<td><?=$d['razon_social']?></td>
<td><?=$d['numero_documento']?></td>
<td><?=$d['codigo_eapb']?></td>
<td><?=$d['estado']?></td>
<td class="opcion"><a href="<?=site_url('core/administrar_entidades/editarEntidad/'.$d['id_entidad'])?>">Editar</a></td>
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
