<script type="text/javascript">
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
<h1 class="tituloppal">Servicio de urgencias - M&oacute;dulo de enfermer&iacute;a</h1>
<h2 class="subtitulo">Gesti&oacute;n de la atención</h2>
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
<td class="campo">Ingreso administrativo:</td
><td><?php
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
    <td class="campo">Motivo de consulta:</td>
    <td colspan="3"><?=$consulta['motivo_consulta']?>&nbsp;</td>
  </tr>
 <?=$this->load->view('urg/urg_segu_info')?>
</table>

</td>
</tr>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
  <tr>
    <td class="opcion"><a href="<?=site_url()?>/urg/enfermeria/consultaTriage/<?=$atencion['id_atencion']?>">Consultar<br />TRIAGE</a></td>
    <td class="opcion"><a href="<?=site_url()?>/urg/enfermeria/consultaAtencion/<?=$atencion['id_atencion']?>">Consultar<br /> Atención inicial</a></td>
<td class="opcion">
<?=anchor('/urg/notas_enfermeria/main/'.$atencion['id_atencion'],'Notas de enfermer&iacute;a');?>
</td>

<td class="opcion">
<?=anchor('/urg/sv_enfermeria/main/'.$atencion['id_atencion'],'Signos Vitales enfermer&iacute;a');?>
</td>
<td class="opcion">
<?=anchor('/urg/bl_enfermeria/main/'.$atencion['id_atencion'],'Balance De L&iacute;quidos');?>
</td>
<td class="opcion">
<?=anchor('/urg/seguridad_paciente/escala_crichton/'.$atencion['id_atencion'],'Valoración del riesgo de caídas');
?>
</td>
<td class="opcion">
<a href="<?=site_url()?>/urg/enfermeria/consultarOrdenes/<?=$atencion['id_atencion']?>">Ordenes procedimientos y formulación</a>
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
