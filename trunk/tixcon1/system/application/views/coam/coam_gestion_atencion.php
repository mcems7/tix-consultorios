<script type="text/javascript">
function finalizar_atencion(id_atencion)
{
if(confirm('¿Está seguro de finalizar la atención del paciente?\nLa historia clínica será cerrada y no se podrán agregar nuevos registros!!'))
{
	document.location = '<?=site_url()?>/coam/coam_gestion_atencion/finalizar_atencion/'+id_atencion;
	return true;
}
else
{
	return false;
}
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Gesti&oacute;n de la atenci&oacute;n</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
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
<td class="campo" colspan="2">&nbsp;</td></tr>
</table>
</td>
</tr>

<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
<td class="campo">Fecha y hora de ingreso:</td>
<td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
<td class="campo">Consultorio:</td>
<td><?=$atencion['consultorio']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Motivo de consulta:</td>
<td colspan="3"><?=$consulta['motivo_consulta']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Enfermedad actual:</td>
<td colspan="3"><?=$consulta['enfermedad_actual']?>&nbsp;</td>
</tr>
   <tr>
  <td class="campo">Diagn&oacute;sticos consulta:</td>
  <td colspan="3">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta';
}
?>
  </td></tr>
</table>
</td>
</tr>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<!--Opciones gestion de la atencion-->
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
<tr>
<td class="opcion">
<?=anchor('coam/coam_gestion_atencion/consultaNotaInicial/'.$atencion['id_atencion'], 'Ver datos consulta', 'title="Ver datos consulta"');?>
</td>
<td class="opcion">
<?=anchor('coam/coam_ordenamiento/main/'.$atencion['id_atencion'], '&Oacute;rdenes m&eacute;dicas', 'title="&Oacute;rdenes m&eacute;dicas"');?>
</td>
<td class="opcion">
<?=anchor('coam/coam_gestion_atencion/remision/'.$atencion['id_atencion'], 'Remisi&oacute;n', 'title="Remisi&oacute;n"');?>
</td>
<td class="opcion">
<?=anchor('coam/coam_gestion_atencion/incapacidad/'.$atencion['id_atencion'], 'Incapacidad', 'title="Incapacidad"');?>
</td>
<td class="opcion">
<a href="#" onclick="finalizar_atencion('<?=$atencion['id_atencion']?>')">Finalizar atención</a>
</td>
</tr>
</table>
</td>
</tr>
<?php 
if($rem != 0){
	$i = 1;
?>
<tr><th colspan="2" id="opciones">Remisiones</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora remision</td>
<td class="campo_centro">Especialidad a la que se remite</td>
<td class="campo_centro">Opciones</td>
<?php
	foreach($rem as $d)
	{
		
?>
<tr>
<td><?=$i?></td>
<td><?=$d['fecha_remision']?></td>
<td><?=$d['descripcion']?></td>
<td class="opcion">
<?=anchor('coam/coam_gestion_atencion/remision_consulta/'.$d['id_remision'], 'Consultar', 'title="Consultar"');?>
</td>
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
<?php 
if($inca != 0){
	$i = 1;
?>
<tr><th colspan="2" id="opciones">Incapacidades</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora incapacidad</td>
<td class="campo_centro">Duración</td>
<td class="campo_centro">Opciones</td>
<?php
	foreach($inca as $d)
	{
		
?>
<tr>
<td><?=$i?></td>
<td><?=$d['fecha_incapacidad']?></td>
<td><?=$d['duracion']?></td>
<td class="opcion">
<?=anchor('coam/coam_gestion_atencion/incapacidad_consulta/'.$d['id_incapacidad'], 'Consultar', 'title="Consultar"');?>
</td>
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
<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</center>