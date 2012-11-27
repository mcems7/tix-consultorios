<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Gestión de la atención</h1>
<h2 class="subtitulo">Consultar TRIAGE</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td>
</tr>
<tr><th colspan="2">Datos de la atención</th></tr>
<tr><td class="campo" width="40%">Fecha y hora de inicio:</td>
<td width="60%"><?=$triage['fecha_ini_triage']?></td></tr>
<tr><td class="campo">Fecha y hora de fianlización:</td>
<td><?=$triage['fecha_fin_triage']?></td></tr>
<tr><td class="campo">Medico Triage:</td>
<td><?=$triage['primer_apellido']." ".$triage['segundo_apellido']." ".$triage['primer_nombre']." ".$triage['segundo_nombre']?></td></tr>
<tr><th colspan="2">Datos del triage</th></tr>
<tr><td class="campo">Paciente remitido:</td><td><?=$atencion['remitido']?></td></tr>
<?php
if($atencion['remitido'] == 'SI'){
$ent_remi = $this->urgencias_model->obtenerEntidadRemision($atencion['codigo_entidad']);	
?>
<tr><td class="campo">Entidad que remite:</td><td><?=$ent_remi['nombre']?></td></tr>
<?php
}
?>
<tr><td class="campo">Motivo de la consulta:</td>
<td><?=$triage['motivo_consulta']?></td></tr>
<tr><td class="campo">Antecedentes:</td>
<td><?=$triage['antecedentes']?></td></tr>
<tr><td colspan="2">

<table width="100%" border="0" style="text-align:center" >
<tr><td class="campo_centro" colspan="5">Signos vitales</td></tr>
<tr>
<td width="20%" class="campo_centro">Frecuencia cardiaca</td>
<td width="20%" class="campo_centro">Frecuencia respiratoria</td>
<td width="20%" class="campo_centro">Tensi&oacute;n arterial</td>
<td width="20%" class="campo_centro">Temperatura</td>
<td width="20%" class="campo_centro">Pulsioximetr&iacute;a (SPO2)</td>
</tr>
<tr>
<td><?=$triage['frecuencia_cardiaca'];?>&nbsp;X min</td>
<td><?=$triage['frecuencia_respiratoria'];?>&nbsp;X min</td>
<td><?=$triage['ten_arterial_s'];?>&nbsp;/&nbsp;<?=$triage['ten_arterial_d'];?></td>
<td><?=$triage['temperatura'];?> &deg;C</td>
<td><?=$triage['spo2'];?> %</td>
</table>
</td></tr>
<tr><td class="campo">Escala Glasgow</td><td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>Respuesta ocular:&nbsp;<strong><?=$triage['resp_ocular']?></strong></td>
    <td>Respuesta verbal:&nbsp;<strong><?=$triage['resp_verbal']?></strong></td>
    <td>Respuesta motora:&nbsp;<strong><?=$triage['resp_motora']?></strong></td>
    <td>Glasgow:&nbsp;<strong><?=$triage['resp_ocular']+$triage['resp_verbal']+$triage['resp_motora']?>/15</strong></td>
  </tr>
</table>

</td></tr>
<tr><tr><td class="campo">Sala de espera:</td>
<td><?=$atencion['nombre_servicio']?></td></tr>
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
<tr><td class="campo">Clasificaci&oacute;n:</td><td <?=$clas?> style="padding:10px; text-align:left;"><?=$atencion['clasificacion']?></td></tr>
<tr>

<td class='campo'>Justificación no admisión:</td>
			<td><?=$triage['just_blanco']?></td>
			
		</tr>
		<tr>

<td class='campo'>Recomendaciones:</td>
			<td><?=$triage['recomendaciones']?></td>
			
		</tr>
<tr><td colspan="2" class="linea_azul"></td></tr>   
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresion/consultaTriage/'.$atencion['id_atencion'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</td></tr></table>
<?=form_close();?>
