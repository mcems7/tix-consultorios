<?php echo $this->load->helper("open_flash_chart"); ?>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////


////////////////////////////////////////////////////////////////////////////////

function resetDiv()
{
	$('con_nota').set('html','');
	$('bl_nota').set('html','');
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
  if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
  {
      return true
  }else{
      return false;
  } 
}
function consultaNota(id_atencion,fecha_nota)
{
	var var_url = '<?=site_url()?>/urg/bl_enfermeria/consultaBalance/'+id_atencion+'/'+fecha_nota;
	
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
function registroadministrados(id_nota)
{
	var var_url = '<?=site_url()?>/urg/bl_enfermeria/crearNotaAdm/'+id_nota;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('bl_nota').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function registroeliminados(id_nota)
{
	var var_url = '<?=site_url()?>/urg/bl_enfermeria/crearNotaEli/'+id_nota;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('bl_nota').set('html', html);
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



<h1 class="tituloppal">Servicio de urgencias - Observación</h1>
<h2 class="subtitulo">Balance de l&iacute;quidos </h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Género:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td>
</tr>


<tr><td colspan="2">&nbsp;</td></tr>
<tr><th colspan="2">Balance de l&iacute;quidos</th></tr>
<tr>
 <td>
 <div id="bl_nota">
 
</div>
</td></tr>


<?php

	if($notas == 0)
	{
		echo "<tr> <td>";
		echo "<center><strong>No se ha registrado ningun balance de liquidos</strong></center>";	
		echo "<tr/> </td>";
	}else{
?></td></tr>
<tr>
 <td>

            <?= $this->graph->render()?>
        
 </td>
</tr>
<tr>
 <td>
<div id="con_nota">

</div>
</td></tr>
<tr>
  <td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Fecha </td>
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
<td class="opcion"><a href="#con_nota" onclick="consultaNota('<?=$d['id_atencion']?>','<?=$d['fecha_nota']?>')"><strong>Consultar</strong></a></td>

</tr>

<?php
	}
		echo "</table>";
		echo "</td></tr>";
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

