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
echo form_open('/core/administrar_ter/buscarTercero',$attributes);
?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Administración de terceros</h2>
<center>
  <table width="100%" class="tabla_form">
  <tr>
    <th colspan="2">Criterios de búsqueda</th>
  </tr>
  <tr>
    <td class="campo">Número documento:</td>
    <td><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'value' => $numero_documento,
							'maxlength'   => '20',
							'size'=> '20'))?>
                            </td>
  </tr>
   <tr>
    <td class="campo">Primer apellido:</td>
    <td><?=form_input(array('name' => 'primer_apellido',
							'id'=> 'primer_apellido',
							'value' => $primer_apellido,
							'maxlength'   => '50',
							'size'=> '20'))?>
                            </td>
  </tr>
  <tr>
    <td class="campo">Segundo apellido:</td>
    <td><?=form_input(array('name' => 'segundo_apellido',
							'id'=> 'segundo_apellido',
							'value' => $segundo_apellido,
							'maxlength'   => '50',
							'size'=> '20'))?>
                            </td>
<tr>
    <td class="campo">Primer nombre:</td>
    <td><?=form_input(array('name' => 'primer_nombre',
							'id'=> 'primer_nombre',
							'value' => $primer_nombre,
							'maxlength'   => '50',
							'size'=> '20'))?>
                            </td>
<tr>
    <td class="campo">Segundo nombre:</td>
    <td><?=form_input(array('name' => 'segundo_nombre',
							'id'=> 'segundo_nombre',
							'value' => $segundo_nombre,
							'maxlength'   => '50',
							'size'=> '20'))?>
                            </td>
  </tr>
   <tr>
    <td width="50%" class="campo">Razón social:</td>
    <td width="50%"><?=form_input(array('name' => 'razon_social',
					'id'=> 'razon_social',
					'value' => $razon_social,
					'maxlength'   => '20',
					'size'=> '20'))?>	</td>
  </tr>
  <tr><td colspan="2" align="center">
<?=form_submit('boton', 'Buscar')?>
</td></tr>
<tr>
  <td colspan="2" class="opcion">
    <a href="<?=site_url('core/administrar_ter/crearTercero')?>">Registrar un tercero</a></td></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr>
  <th colspan="5">Listado de terceros</th></tr>
<tr>
<td class="campo_centro">Nombres y apellidos</td>
<td class="campo_centro">Documento identificación</td>
<td class="campo_centro">Editar</td>
</tr>
<?php
	foreach($lista as $d)
	{
?>
<tr>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['tipo_documento'].": ".$d['numero_documento']?></td>
<td class="opcion"><a href="<?=site_url('core/administrar_ter/editarTercero/'.$d['id_tercero'])?>">Editar</a></td>
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