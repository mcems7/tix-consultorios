<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	
});
////////////////////////////////////////////////////////////////////////////////
function cambiar_cama()
{
	if(confirm('¿Desea asignarle una nueva cama al paciente?'))
	{
		var var_url = '<?=site_url()?>/urg/observacion/cambiarCamaObser/'+<?=$atencion['id_atencion']?>;
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
function asignarCama(id_obs)
{
	var cama = $('id_cama').value;
	if(cama == 0){
		alert('Seleccione la cama a ser asignada!!');
	return false;
	}
	
	var var_url = '<?=site_url()?>/urg/observacion/cambiarObservacionCama/'+id_obs+'/'+cama;
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
function verificado()
{
	alert("Para realizar la acción solicitada la consulta inicial debe estar verificada");	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Observación</h1>

<h2 class="subtitulo">Informaci&oacute;n de la atenci&oacute;n</h2>
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
    <td class="campo">Fecha y hora ingreso a urgencias:</td>
    <td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
  <?php
	$clas = "";
	if($atencion['clasificacion'] == 1){
		$clas = 'class="triage_rojo_con"';
	}else if($atencion['clasificacion'] == 2){
		$clas = 'class="triage_amarillo_con"';
	}else if($atencion['clasificacion'] == 3){
		$clas = 'class="triage_verde_con"';
	}else if($atencion['clasificacion'] == 4){
		$clas = 'class="triage_blanco_con"';
	}
	
?>
    <td class="campo">Clasificación TRIAGE:</td>
    <td <?=$clas?> style="padding:10px; text-align:left;"><?=$atencion['clasificacion']?>&nbsp;</td>
  </tr>
  <tr>
    <td class="campo">Fecha y hora remisión observación:</td>
    <td><?=$observacion['fecha_remicion']?>&nbsp;</td>
    <td class="campo">Cama</td>
    <td id="div_cama"><?=$observacion['numero_cama']?>
	</td>
    </tr>
    <tr>
    <td class="campo">Fecha y hora ingreso a observación:</td>
    <td><?=$observacion['fecha_ingreso']?>&nbsp;</td>
    <td class="campo">Servicio:</td><td><?=$observacion['nombre_servicio']?>&nbsp;</td>
    </tr>
     <tr>
    <td class="campo">Medico remite:</td>
    <td colspan="3"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?>&nbsp;</td>
    </tr>
  <tr>
    <td class="campo">Motivo de consulta:</td>
    <td colspan="3"><?=$consulta['motivo_consulta']?>&nbsp;</td>
  </tr>
<?=$this->load->view('urg/urg_segu_info')?>
   <tr>
  <td class="campo">Diagn&oacute;sticos consulta inicial:</td>
  <td colspan="3">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta inicial';

}
?>
  </td></tr>
    <tr>
  <td class="campo">Diagn&oacute;sticos evoluciones:</td>
  <td colspan="3">
  
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
<?php
if(count($inter) > 0)
{
?>
<tr><th colspan="2" id="opciones">Interconsultas</th></tr>
<tr><td colspan="2">
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora solicitud</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
	$i = 1;
	foreach($inter as $d)
	{

?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_solicitud']?></td>
<td><?=$d['estado']?></td>
<td class="opcion"><a href="<?=site_url()?>/urg/evoluciones/respInterconsultaObs/<?=$d['id_interconsulta']?>/<?=$atencion['id_atencion']?>"><strong>Responder</strong></a></td>

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
				'onclick' => 'cambiar_cama()',
				'value' => 'Cambiar cama',
				'type' =>'button');
echo form_input($data);
?></td></tr>
<tr><td colspan="2" align="center" id="div_cambiar_cama"></td></tr>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
  <tr>
    <td class="opcion"><a href="<?=site_url()?>/urg/observacion/consultaTriage/<?=$atencion['id_atencion']?>">Consultar<br />TRIAGE</a></td>
    <td class="opcion"><a href="<?=site_url()?>/urg/observacion/consultaAtencion/<?=$atencion['id_atencion']?>">Consultar<br /> Atención inicial</a></td>
    <td class="opcion"> 
    <a href="<?=site_url()?>/urg/evoluciones/main/<?=$atencion['id_atencion']?>">Evoluciones</a>
</td>
<td class="opcion">
<a href="<?=site_url()?>/lab/hce_laboratorio/main/<?=$atencion['id_atencion']?>">Laboratorios</a>
</td>
<td class="opcion">
<a href="<?=site_url()?>/urg/ordenamiento/main/<?=$atencion['id_atencion']?>">Órdenes médicas</a>
</td>
<td class="opcion">
<table>

<tr>
<td>
<a href="<?=site_url()?>/urg/observacion/remision/<?=$atencion['id_atencion']?>">Remisión</a>
</td>

</tr>
<tr>
<?php
if($rem != 0)
{
	
?>
<tr><td class="linea_azul"></td></tr>
<td class="opcion">

<a href="<?=site_url()?>/urg/observacion/consultaRemision/<?=$atencion['id_atencion']?>">Imprimir</a>
</td>

<?php
}
?>

</tr>


</table>

</td>



<td class="opcion">
<a href="<?=site_url()?>/urg/observacion/epicrisis/<?=$atencion['id_atencion']?>">Epicrisis</a>
</td>
<td class="opcion">
<?=anchor('/urg/notas_enfermeria/consultarNota/'.$atencion['id_atencion'],'Notas de enfermer&iacute;a');?>
</td>

<td class="opcion">
<?=anchor('/urg/sv_enfermeria/consultarSv/'.$atencion['id_atencion'],'Signos Vitales enfermer&iacute;a');?>
</td>
<td class="opcion">
<?=anchor('/urg/bl_enfermeria/consultaBl/'.$atencion['id_atencion'],'Balance De L&iacute;quidos');?>
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
