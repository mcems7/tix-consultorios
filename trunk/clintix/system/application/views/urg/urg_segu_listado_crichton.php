<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function resetDiv()
{
	$('con_val').set('html','');
}
////////////////////////////////////////////////////////////////////////////////
function consultaVal(id_val)
{
	var var_url = '<?=site_url()?>/urg/seguridad_paciente/escala_crichton_consultar/'+id_val;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('con_val').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
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
<h1 class="tituloppal">Servicio de urgencias - Seguridad del paciente</h1>
<h2 class="subtitulo">Valoración del riesgo de caídas. Escala de Crichton</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td>
</tr>
<tr>
  <td colspan="2" class="opcion">
<?=anchor('/urg/seguridad_paciente/escala_crichton_crear/'.$atencion['id_atencion'],'Registrar una nueva valoración');
?>
 </td></tr>
<tr><td colspan="2">
<div id="con_val">

</div>
</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Valoraciones realizadas</th></tr>
<tr>
<td>
<div id="con_evo">

</div>
<?php
	if($lista == 0)
	{
		echo "<center><strong>No se ha registrado ninguna valoración</strong></center>";	
	}else{
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Fecha y hora</td>
    <td class="campo_centro">Profesional</td>
    <td class="campo_centro">Puntaje</td>
    <td class="campo_centro">Operación</td>
  </tr>
<?php
	foreach($lista as $d)
	{
?>
  <tr>
<td><?=$d['fecha_creacion'];?></td>
<td><?=$d['medico']?></td>
 <?php
$puntaje = $d['limitacion_fisica']+$d['estado_mental']+$d['tratamiento_farmacologico']+$d['problemas_de_idioma']+$d['incontinencia_urinaria']+$d['deficit_sensorial']+$d['desarrollo_psicomotriz']+$d['pacientes_sin_facores'];
 
	if($puntaje <= 2){
		$estilo = "background-color:#00FF00";
		$texto = "BAJO RIESGO";
	}else if($puntaje > 2 && $puntaje < 8){
		$estilo = "background-color:#FFFF00";
		$texto = "MEDIANO RIESGO";
	}else if($puntaje >= 8){
		$estilo = "background-color:#FF0000";
		$texto = "ALTO RIESGO";
	}
?>
<td style="<?=$estilo?>"><strong><?=$puntaje?></strong>&nbsp;-&nbsp;<?=$texto?>
</td>
<td class="opcion"><a href="#con_val" onclick="consultaVal('<?=$d['id']?>')"><strong>Consultar</strong></a></td>
</tr>

<?php
	}
		echo "</table>";
	}
?>

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