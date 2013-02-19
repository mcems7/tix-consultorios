<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
});
////////////////////////////////////////////////////////////////////////////////
function cambiar_cama()
{
	if(confirm('¿Desea asignarle una nueva cama al paciente?'))
	{
		var var_url = '<?=site_url()?>/hospi/hospi_gestion_atencion/cambiarCamaHospi/'+<?=$atencion['id_atencion']?>;
		var ajax1 = new Request(
		{
			url: var_url,
			onSuccess: function(html){$('div_cambiar_cama').set('html', html);},
			evalScripts: true,
			onFailure: function(){alert('Error ejecutando ajax!');}
		});
		ajax1.send();	
	}
	else
	{
		return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
function asignarCama(id_aten)
{
	var cama = $('id_cama').value;
	if(cama == 0){
		alert('Seleccione la cama a ser asignada!!');
	return false;
	}
	
	var var_url = '<?=site_url()?>/hospi/hospi_gestion_atencion/cambiarHospiCama/'+id_aten+'/'+cama;
	var ajax1 = new Request(
	{
		url: var_url,
		onSuccess: function(html){$('div_cama').set('html', html);},
		onComplete: function(){
			$('div_cambiar_cama').set('html','');
			},
		evalScripts: true,
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
</script>
<h1 class="tituloppal">Unidad de hospitalizaci&oacute;n</h1>
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
<td class="campo">Ingreso administrativo:</td><td><?php
echo $atencion['admision'];
if($atencion['admision'] == 'SI')
{
	echo ' - <strong>',$atencion['ingreso'], '</strong>';
}
?></td></tr>
</table>
</td>
</tr>

<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
<td class="campo">Fecha y hora de ingreso:</td>
<td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
<td class="campo">Servicio:</td>
<td><?=$atencion['nombre_servicio']?>&nbsp;</td>
<td class="campo">Cama</td>
<td id="div_cama"><?=$atencion['numero_cama']?></td>
</tr>
<tr>
<td class="campo">Motivo de consulta:</td>
<td colspan="5"><?=$consulta['motivo_consulta']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Enfermedad actual:</td>
<td colspan="5"><?=$consulta['enfermedad_actual']?>&nbsp;</td>
</tr>
   <tr>
  <td class="campo">Diagn&oacute;sticos nota inicial:</td>
  <td colspan="5">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la nota inicial';
}
?>
  </td></tr>
    <tr>
  <td class="campo">Diagn&oacute;sticos evoluciones:</td>
  <td colspan="5">
  
  <?php
if(count($dxEvo) > 0)
{
	foreach($dxEvo as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a las evoluciones';

}
?>
  </td></tr>
</table>
</td>
</tr>
<tr><td colspan="2" align="center"><?
$data = array(	'name' => 'bv',
				'onclick' => 'cambiar_cama()',
				'value' => 'Cambiar cama',
				'type' =>'button');
echo form_input($data);
?></td></tr>
<tr><td colspan="2" align="center" id="div_cambiar_cama"></td></tr>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<!--Opciones gestion de la atencion-->
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
<tr>
<td class="opcion">
<?=anchor('hospi/hospi_gestion_atencion/consultaNotaInicial/'.$atencion['id_atencion'], 'Consultar Nota inicial', 'title="Consultar Nota inicial"');?>
</td>
<td class="opcion">
<?=anchor('hospi/hospi_evoluciones/main/'.$atencion['id_atencion'], 'Evoluciones', 'title="Evoluciones"');?>
</td>

<td class="opcion">
<?=anchor('hospi/hospi_ordenamiento/main/'.$atencion['id_atencion'], '&Oacute;rdenes m&eacute;dicas', 'title="&Oacute;rdenes m&eacute;dicas"');?>
</td>
<td class="opcion">
<?=anchor('hospi/hospi_gestion_atencion/epicrisis/'.$atencion['id_atencion'], 'Epicrisis', 'title="Epicrisis"');?>
</td>
</tr><tr>

<td class="opcion">
<?=anchor('/hospi/hospi_notas_enfermeria/consultarNota/'.$atencion['id_atencion'],'Notas de enfermer&iacute;a','title="Notas de enfermer&iacute;a"');?>
</td>

<td class="opcion">
<?=anchor('/hospi/hospi_sv_enfermeria/consultarSv/'.$atencion['id_atencion'],'Signos Vitales enfermer&iacute;a','title="Signos Vitales enfermer&iacute;a"');?>
</td>
<td class="opcion">
<?=anchor('/hospi/hospi_bl_enfermeria/consultaBl/'.$atencion['id_atencion'],'Balance De L&iacute;quidos','title="Balance De L&iacute;quidos"');?>
</td>
</tr>
</table>
</td>
</tr>
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
