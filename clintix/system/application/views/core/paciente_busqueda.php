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
echo form_open('/core/administrar_paciente/buscarPaciente',$attributes);
?>
<h1 class="tituloppal">Administración del sistema</h1>
<h2 class="subtitulo">Administración de pacientes</h2>
<center>
  <table width="100%" class="tabla_form">
  <tr>
    <th colspan="2">Criterios de búsqueda</th>
  </tr>
  <tr>
    <td class="campo">Número de documento:</td>
    <td><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20'))?>
                            </td>
  </tr>
   <tr>
    <td width="50%" class="campo">Primer apellido:</td>
    <td width="50%"><?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'maxlength'   => '20',
					'size'=> '20'))?>	</td>
  </tr>
   <tr>
    <td class="campo">Segundo apellido:</td>
    <td><?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20',
					'size'=> '20'))?>	</td>
  </tr>
  <tr>
    <td class="campo">Primer nombre:</td>
    <td><?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20'))?></td>
  </tr>
   <tr>
    <td class="campo">Segundo nombre:</td>
    <td><?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20'))?></td>
  </tr>
   <tr>
    <td class="campo">Régimen:</td>
    <td><select name="id_cobertura" id="id_cobertura">
      <option value="0" selected="selected">-Seleccione uno-</option>
    <?
		foreach($tipo_usuario as $d)
		{
				echo '<option value="'.$d['id_cobertura'].'">'.$d['cobertura'].'</option>';
		}
	?>
    </select></td>
  </tr>
  <tr><td colspan="2" align="center">
<?=form_submit('boton', 'Buscar')?>
</td></tr>
<tr>
  <td colspan="2" class="opcion">
    <a href="<?=site_url('core/administrar_paciente/veriPaciente')?>">Registrar un paciente</a></td></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><th colspan="6">Listado de pacientes</th></tr>
<tr>
<td class="campo_centro">Apellidos y nombres</td>
<td class="campo_centro">Número documento</td>
<td class="campo_centro">Régimen</td>
<td class="campo_centro">Entidad</td>
<td class="campo_centro">Editar</td>
</tr>
<?php
	foreach($lista as $d)
	{
?>
<tr>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['tipo_documento'].": ".$d['numero_documento']?></td>
<td><?=$d['cobertura']?></td>
<td><?=$d['razon_social']?></td>
<td class="opcion"><a href="<?=site_url('core/administrar_paciente/editarPaciente/'.$d['id_paciente'])?>">Editar</a></td>
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