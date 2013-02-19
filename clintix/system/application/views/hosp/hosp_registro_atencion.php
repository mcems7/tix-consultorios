<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
/////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Hospitalización</h1>
<h2 class="subtitulo">Registro de una atención</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Informaci&oacute;n del paciente</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
</table>
</td>
</tr>
<tr><td colspan="2" class="opcion">
<a href="<?=site_url('hosp/hosp_registrar/registrarAtencion/'.$paciente['id_paciente'])?>"><strong>Registrar una nueva atención al paciente</strong></a>
</td></tr>
<?php
$n = count($lista);
if($n>0)
{
?>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Atenciones vigentes</th></tr>
<tr>
  <td colspan="2">
<table style="width:100%" class="tabla_interna">
<tr><td colspan="6">
Se han encontrado las siguientes atenciones vigentes. Verifique si la atención que desea registrar no se encuentra en el listado.
</td></tr>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Numero documento</td>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	foreach($lista as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$numero_documento?></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td class="opcion"><a href="<?=site_url('hosp/hosp_gestion_atencion/main/'.$d['id_atencion'])?>"><strong>Consultar</strong></a></td>
</tr>
<?php
$i++;
	}
?>
</table>
</td></tr>
<?php
}
?>
<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</center>