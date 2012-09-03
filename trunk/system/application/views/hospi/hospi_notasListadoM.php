<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function resetDiv()
{
	$('con_nota').set('html','');
	
}
////////////////////////////////////////////////////////////////////////////////
function consultaNota(id_nota)
{
	var var_url = '<?=site_url()?>/hospi/hospi_notas_enfermeria/consultaNota/'+id_nota;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('con_nota').set('html', html);
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
<h1 class="tituloppal">Servicio de hospitalizaci&oacute;n</h1>
<h2 class="subtitulo">Notas de enfermer&iacute;a</h2>
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

<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Notas de enfermer&iacute;a realizadas</th></tr>
<tr>
<td>
<div id="con_nota">

</div>
<?php
	if($notas == 0)
	{
		echo "<center><strong>No se ha registrado ninguna nota de enfermer&iacute;a</strong></center>";	
	}else{
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Fecha y hora</td>
    <td class="campo_centro">Realiza la nota</td>
    <td class="campo_centro">Operación</td>
  </tr>
<?php
	foreach($notas as $d)
	{
?>
  <tr>
<td><?=$d['fecha_nota'];?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td class="opcion"><a href="#con_nota" onclick="consultaNota('<?=$d['id_nota']?>')"><strong>Consultar</strong></a></td>

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
