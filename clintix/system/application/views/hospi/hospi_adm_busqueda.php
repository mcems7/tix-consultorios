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
</script>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post');
	echo form_open('/hospi/hospi_admision/buscarPaciente',$attributes);
?>
<center>
<h1 class="tituloppal">Unidad de hospitalización</h1>
<h2 class="subtitulo">Admisión de un paciente</h2>

<table width="100%" class="tabla_form">
<tr><th colspan="2">Paciente a ser ingresado al sistema</th></tr>
<tr><td width="50%" class="campo">Número de documento del paciente:</td>
<td width="50%"><?=form_input(array('name' => 'numero_documento',
							'id'=> 'numero_documento',
							'maxlength'   => '20',
							'size'=> '20',
							'class'=>"fValidate['nit']"))?>
</td></tr>
<tr><td colspan="2" align="center">
<?=form_submit('boton', 'Buscar')?></td></tr>
</table>
<?=br()?>
<table width="100%" class="tabla_form">
<tr>
  <th colspan="2">Paciente pendiente de admisi&oacute;n v&iacute;a de ingreso Urgencias</th></tr>
<tr><td width="50%" class="campo">Número de documento del paciente:</td>
<td width="50%">&nbsp;
</td></tr>
<tr><td colspan="2" align="center">
<?=form_submit('boton', 'Buscar')?></td></tr>
</table>
<?
echo br();
?>
<?=form_close();?>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Listado pacientes</th></tr>
<tr><td>
<table width="100%" cellpadding="5" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora de ingreso</td>
<td class="campo_centro">Nombre e identificación del paciente</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
$n = count($lista);
if($n>0)
{
	$i = 1;
	foreach($lista as $d)
	{
?>
<tr class="fila">
<td align="center"><strong><?=$i?></strong></td>
<td>	
<?=$d['fecha_ingreso']?>
</td>
<td>
<?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?></td>
<td align="center"><?=$d['estado'];?>	</td>
<td class="opcion"><strong>
<a href="<?=site_url()?>/hce/hce_hospi/gestion_atencion/<?=$d['id_atencion']?>">
Consultar</a></strong></td>
</tr>	
<?php
$i++;
	}
}else{
?>
<tr><td colspan="8" align="center">No hay pacientes que cumplan con los creiterios seleccionados</td></tr>
<?php
}
?>
</table>
</td></tr></table>
<?
echo br();
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</center>
