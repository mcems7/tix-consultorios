<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
</script>
<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Historia del paciente</h2>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
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
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
</table>
</td></tr>
<?php
if($atencionesUrg !=0)
{
?>
<tr><td colspan='2'>
<table style="width:100%" class="tabla_interna">
<tr>
<th colspan="7">Atenciones Urgencias</th>
</tr>

<tr>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Fecha y hora egreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Consultar</td>
</tr>
<?php
	foreach($atencionesUrg as $d)
	{
?>
<tr>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['fecha_egreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td><?=$d['estado']?></td>
<td class='opcion'>
<?php
if($d['clasificacion'] != '4'){
?>

 <a href="<?=site_url('hce/main/consultarAtencion/'.$d['id_atencion'])?>"><strong>Consultar</strong>
      </a>
<?php
}else{
?>
<a href="<?=site_url('hce/main/consultaTriageBlanco/'.$d['id_atencion'])?>"><strong>Consulta TRIAGE</strong>
      </a>	
<?php
}
?>
</td>
</tr>		
<?php
	}
?>
</table>
</td></tr>
<?php
}
?>
<?php
if($atencionesHospi !=0)
{
?>
<tr><td colspan='2'>
<table style="width:100%" class="tabla_interna">
<tr>
<th colspan="7">Atenciones Unidad de hospitalizaci&oacute;n</th>
</tr>

<tr>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Fecha y hora egreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Consultar</td>
</tr>
<?php
	foreach($atencionesHospi as $d)
	{
?>
<tr>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['fecha_egreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td><?=$d['estado']?></td>
<td class='opcion'>
<a href="<?=site_url('hce/hce_hospi/main/'.$d['id_atencion'])?>"><strong>Ver atenci&oacute;n</strong></a>
</td>
</tr>		
<?php
	}
?>
</table>
</td></tr>
<?php
}
?>
<tr><td colspan="1" align="center">
<?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
echo nbs();

?>
</td></tr>
</td></tr>
</table>