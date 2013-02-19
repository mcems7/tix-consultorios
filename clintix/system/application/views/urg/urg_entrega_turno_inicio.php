<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	var exValidatorA = new fValidator("formulario");			 
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Entrega de turno</h2>
<center>
<table width="98%" class="tabla_form">
<tr><th colspan="2">Listado pacientes a entregar</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/entrega_turno/pacientes_seleccionados_',$attributes);
echo form_hidden('id_medico_entrega',$medico['id_medico']);
echo form_hidden('id_servicio',$id_servicio);
?>
<table width="100%" cellspacing="2" cellpadding="0" class="tabla_registro">
<tr>
<td class="campo" width="30%">Médico que entrega:</td><td width="70%"><?=$medico['primer_nombre'].' '.$medico['segundo_nombre'].' '.$medico['primer_apellido'].' '.$medico['segundo_apellido']?></td></tr>
<td class="campo">Médico que recibe:</td>
<td><select name="id_medico_recibe" id="id_medico_recibe">
  <option value="0">-Seleccione uno-</option>
 <?php
 	foreach($hospitalarios as $d)
	{
		echo '<option value="'.$d['id_medico'].'">'.$d['primer_apellido'].' '.$d['segundo_apellido'].', '.$d['primer_nombre'].' '.$d['segundo_nombre'].'</option>';	
	}
 ?>
</select></td></tr>
<tr><td class="campo">Fecha y hora de entrega:</td><td><?=date("Y-m-d H:i:s")?></td></tr></table>