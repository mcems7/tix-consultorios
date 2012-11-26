<script type="text/javascript">
var slidePaciente = null;
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
  
	slidePaciente = new Fx.Slide('div_paciente');
	slidePaciente.hide();
	

	$('v_ampliar').addEvent('click', function(e){
			e.stop();
			slidePaciente.toggle();
	});		
	
	$('v_ocultar').addEvent('click', function(e){
			e.stop();
			slidePaciente.toggle();
	});			 
});
////////////////////////////////////////////////////////////////////////////////
function resetDiv()
{
	$('con_evo').set('html','');
}
////////////////////////////////////////////////////////////////////////////////
function consultaEvo(id_evo)
{
	var var_url = '<?=site_url()?>/urg/observacion/consultaEvolucion/'+id_evo;
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('con_evo').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Consulta epicrisis</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td width="40%" class="campo">Apellidos:</td>
<td width="60%"><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td></tr>
<tr><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td></tr>
<tr><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Entidad:</td><td><?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?></td></tr>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul">
<span class="texto_barra">
<a href="#"  id="v_ampliar" title="Ampliar la informaci&oacute;n del paciente">
Ampliar la informaci&oacute;n del paciente
<img src="<?=base_url()?>resources/img/triangulo.png"/></a></span>
</td></tr>
<tr><td colspan="2">
<div id="div_paciente">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo" width="40%">Pa&iacute;s:</td><td width="60%"><?=$tercero['PAI_NOMBRE']?></td></tr>
<tr><td class="campo">Departamento:</td><td><?=$tercero['depa']?></td></tr>
<tr><td class="campo">Municipio:</td><td><?=$tercero['nombre']?></td></tr>
<tr><td class="campo">Barrio / Vereda:</td><td><?=$tercero['vereda']?></td></tr>
<tr><td class="campo">Zona:</td><td><?=$tercero['zona']?></td></tr>
<tr><td class="campo">Direcci&oacute;n:</td><td><?=$tercero['direccion']?></td></tr>
<tr><td class="campo">Teléfono:</td><td><?=$tercero['telefono']?></td></tr>
<tr><td class="campo">Celular:</td><td><?=$tercero['celular']?></td></tr>
<tr><td class="campo">Fax:</td><td><?=$tercero['fax']?></td></tr>
<tr><td class="campo">Correo electrónico:</td><td><?=$tercero['email']?></td></tr>
<tr><td class="campo">Observaciones:</td><td><?=$tercero['observaciones']?></td></tr>
<tr><td class="campo">Tipo usuario:</td><td>
<?
	foreach($tipo_usuario as $d)
	{
		if($paciente['id_cobertura'] == $d['id_cobertura'])
		{
			echo $d['cobertura'];
		}
	}
?>
</td></tr>
<tr><td class="campo">Tipo de afiliado:</td><td><?=$paciente['tipo_afiliado']?></td></tr>
<tr><td class="campo">Nivel o categoria:</td><td>
 <?=$paciente['nivel_categoria']?></td></tr>
<tr><td class="campo">Desplazado:</td><td> <?=$paciente['desplazado']?></td></tr>
<tr><td class="campo">Observaciones:</td><td><?=$paciente['observaciones']?></td></tr>
</table>
<p class="linea_azul">
<span class="texto_barra">
<a href="#"  id="v_ocultar" title="Ocultar la informaci&oacute;n del paciente">
Ocultar la informaci&oacute;n del paciente
<img src="<?=base_url()?>resources/img/triangulo.png"/></a></span>
</p>
</div>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo" width="40%">Fecha y hora de ingreso:</td><td width="60%"><?=$atencion['fecha_ingreso']?></td></tr>
<tr><td class="campo">Servicio de ingreso:</td><td><?=$atencion['nombre_servicio']?></td></tr>
<tr><td class="campo">Fecha y hora de egreso:</td><td><?=$atencion['fecha_egreso']?></td></tr>
<tr><td class="campo">Servicio de egreso:</td><td>
<?php
$servicio = $this->urgencias_model->obtenerInfoServicio($atencion['id_servicio']);
echo $servicio['nombre_servicio'];
?></td></tr>
<tr><td class="campo">Paciente remitido:</td><td><?=$atencion['remitido']?></td></tr>
<?php
if($atencion['remitido'] == 'SI'){
$ent_remi = $this->urgencias_model->obtenerEntidadRemision($atencion['codigo_entidad']);	
?>
<tr><td class="campo">Entidad que remite:</td><td><?=$ent_remi['nombre']?></td></tr>
<?php
}
?>
<tr><td class="campo">Estado de salida:</td><td>
<table>
<tr><td>
<?php
echo $epicrisis['estado_salida'];

if($epicrisis['estado_salida'] == 'Muerto')
	echo '&nbsp;' , $epicrisis['tiempo_muerto'];


?>
</td></tr></table>
</td></tr>
<tr>
<td class="campo">Incapacidad funcional:</td>
<td><?php
echo $epicrisis['incapacidad'];
if($epicrisis['incapacidad'] == 'SI')
	echo nbs(),$epicrisis['incapacidad'], nbs(),'D&iacute;as';
?></td></tr>
<tr><th colspan="2">Diagnósticos</th></tr>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro" colspan="2">Diagn&oacute;sticos de ingreso</td></tr>
<tr>
<td class="campo_centro">CI-10</td>
<td class="campo_centro">Descripci&oacute;n</td></tr>
<?php
$i = 1;
if(count($dxI) > 0)
{
foreach($dxI as $d)
{
?>
<tr>
<td style="text-align:center"><strong><?=$d['id_diag']?></strong></td>
<td><?=$d['diagnostico']?></td></tr>
<?php
$i++;
}
}
?>
<tr><td class="campo_centro" colspan="2">Diagn&oacute;sticos de egreso</td></tr>
<tr>
<td class="campo_centro">CI-10</td>
<td class="campo_centro">Descripci&oacute;n</td></tr>
<?php
$i = 1;
if(count($dxE) > 0)
{
foreach($dxE as $d)
{
?>
<tr>
<td style="text-align:center"><strong><?=$d['id_diag']?></strong></td>
<td><?=$d['diagnostico']?></td></tr>
<?php
$i++;
}
}
?>
</table>
</td></tr>
<tr>
  <th colspan="2">Exámenes auxiliares de diagnósticos solicitados</th></tr>
<td colspan="2"><?=$epicrisis['examenes_auxiliares']?></td></tr>
<tr><th colspan="2">Tratamiento recibido</th></tr>
<td colspan="2">

<?php
	foreach($mediAtencion as $d)
	{
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
		echo $this->load->view('urg/urg_obsEpicrisisMedicamentos',$d);
	}
?>  

</td></tr>
<tr><th colspan="2">Evolución</th></tr>
<tr><td colspan="2">
<div id="con_evo">

</div>
<?php
	if($evo == 0)
	{
		echo "<center><strong>No se ha registrado ninguna evolución</strong></center>";	
	}else{
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Fecha y hora</td>
    <td class="campo_centro">Medico</td>
    <td class="campo_centro">Especialidad</td>
    <td class="campo_centro">Tipo evolucion</td>
    <td class="campo_centro">Operación</td>
</tr>
<?php
	foreach($evo as $d)
	{
?>
<tr>
<td><?=$d['fecha_evolucion'];?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['esp'];?></td>
<td><?=$d['tipo_evolucion'];?></td>
<td class="opcion"><a href="#con_evo" onclick="consultaEvo('<?=$d['id_evolucion']?>')"><strong>Consultar</strong></a></td>
</tr>
<?php
	}
?>
</table>
<?php
	}
?>

</td></tr>
<tr><th colspan="2">Traslado del paciente</th></tr>
<tr><td class="campo">Traslado:</td>
<td>
<?php
echo $epicrisis['traslado'];
if($epicrisis['traslado'] == 'SI')
{
	echo '<br>Nivel de traslado: ' , $epicrisis['nivel_traslado'];
	echo '<br>Lugar traslado: ' , $epicrisis['lugar_traslado'];
}
?>
</td></tr>
<tr><th colspan="2">Recomendaciones</th></tr>
<tr><td class="campo">
Cita de control en Consulta Externa:</td>
<td>
<?php
echo $epicrisis['cita_con_ext'];
if($epicrisis['cita_con_ext'] == 'SI')
{
	echo '<br>Nivel de traslado: ' , $epicrisis['nivel_traslado'];
	echo '<br>Lugar traslado: ' , $epicrisis['lugar_traslado'];
}
?>
</td></tr>
<?php
if($epicrisis['cita_con_ext'] == 'SI')
{
?>
<tr><td colspan="2">
<table>
<tr><td class="campo">
Con:</td><td><?=$epicrisis['descripcion']?>
</td></tr><td class="campo">En cuantos días:</td><td>
<?=$epicrisis['cita_conext']?>&nbsp;(Días)</td></tr>
</table>
</td></tr>
<?php
}
?>
<tr><td class="campo">
Cita de control hospital local:</td>
<td><?=$epicrisis['cita_hosp_local']?></td></tr>
<?php
if($epicrisis['cita_hosp_local']== 'SI')
{
?>
<tr><td colspan="2">
<table>
<tr><td class="campo">Municipio:</td><td><?=$epicrisis['municipio_cita']?></td></tr>
<tr><td class="campo">En cuantos días:</td><td>
<?=$epicrisis['cita_hopslocal']?>&nbsp;(Días)</td></tr>
</table>
</td></tr>
<?php
}
?>
<tr><th colspan="2">Destino</th></tr>
<?php
$num = count($destino);
?>
  <tr>
    <td class="campo_centro">Destino del paciente</td>
    <td class="campo_centro">Observaciones sobre el destino</td>
  </tr>
  <tr><td style="padding-left:30px"><?=$epicrisis['destino']?></td>
<td><?=$epicrisis['obser_destino']?></td>
</tr>
<tr><th colspan="2">Responsable</th></tr>
<tr><td class="campo">Certifico que el cuadro clínico anteriormente descrito junto con su tratamiento fueron consecuencia de:</td>
<td><?=$origen['origen']?></td>
</tr>
<tr><td class="campo">Médico que realiza la salida:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Código:</td>
<td><?=$medico['tarjeta_profesional']?></td></tr>
<tr><td class="campo">Fecha y hora epicrisis:</td>
<td><?=$epicrisis['fecha_egreso']?></td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresion/consultaEpicrisis/'.$atencion['id_atencion'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>
</div>
<br />
</td></tr></table>