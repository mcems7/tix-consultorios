<script type="text/javascript">
var slidePaciente = null;
var sTMuerto = null;
var sInca = null;
var sTras = null;
var sCita = null;
var sCitaH = null;
//////////////////////////////////////////////////////////////////////////////////

function resetDiv()
{
	//$('con_evo').innerHTML = "";	
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
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 
 	 var exValidatorA = new fValidator("formulario");
	
	slidePaciente = new Fx.Slide('div_paciente');
	slidePaciente.hide();
	
	sTMuerto = new Fx.Slide('div_tiempo_muerto');
	sTMuerto.hide();
	
	sInca = new Fx.Slide('div_incapacidad_dias');
	sInca.hide();
	
	sTras = new Fx.Slide('div_lugar_traslado');
	sTras.hide();
	
	sCita = new Fx.Slide('div_cita_con_ext');
	sCita.hide();
	
	sCitaH = new Fx.Slide('div_cita_hops_local');
	sCitaH.hide();
 
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
function funestado_salida()
{
	var estado = $('estado_salida').value;
	if (estado == 'Muerto'){
		
		for(i=0; i <document.formulario.incapacidad.length; i++){
    	if(document.formulario.incapacidad[i].value == 'SI'){
      		document.formulario.incapacidad[i].checked = false;}
    	
		
		if(document.formulario.incapacidad[i].value == 'NO'){
      		document.formulario.incapacidad[i].checked = true;}
    	}
		sInca.slideOut();	
		$('incapacidad').disabled = true;
		sTMuerto.slideIn();
	}else{
		$('incapacidad').disabled = false;;
		sTMuerto.slideOut();	
	}
}
////////////////////////////////////////////////////////////////////////////////
function fincapacidad(opcion)
{	
	if (opcion == 'SI'){
		$('incapacidad_dias').value = '';
		sInca.slideIn();
	}else{
		$('incapacidad_dias').value = '0';
		sInca.slideOut();	
	}
}
////////////////////////////////////////////////////////////////////////////////
function traslado_paciente(opcion)
{
	if (opcion == 'SI'){
		sTras.slideIn();
	}else{
		sTras.slideOut();	
	}
}
////////////////////////////////////////////////////////////////////////////////
function citaConExt(opcion)
{
	if (opcion == 'SI'){
		sCita.slideIn();
	}else{
		sCita.slideOut();	
	}
}
////////////////////////////////////////////////////////////////////////////////
function citaHopsLocal(opcion)
{
	if (opcion == 'SI'){
		sCitaH.slideIn();
	}else{
		sCitaH.slideOut();	
	}
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	
	
	if(confirm("Esta seguro de guardar la información??")){
		return true;
		}else{
		return false;
		}
}
////////////////////////////////////////////////////////////////////////////////
</script>


<h1 class="tituloppal">Servicio de urgencias - Observación</h1>
<h2 class="subtitulo">Remisión</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/observacion/remision_',$attributes);
$fecha_egreso = date('Y-m-d H:i:s');
echo form_hidden('fecha_egreso',$fecha_egreso);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
?>
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
<tr><td class="campo">Fecha y hora de ingreso:</td><td><?=$atencion['fecha_ingreso']?></td></tr>
<tr><td class="campo">Servicio de ingreso:</td><td><?=$atencion['nombre_servicio']?></td></tr>
<tr><td class="campo">Fecha y hora de egreso:</td><td><?=$fecha_egreso?></td></tr>
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

<tr>
  <th colspan="2">Resumen de anamnesís y examen fisico.</th></tr>
<td colspan="2"><?=form_textarea(array('name' => 'resumen_anamnesis',
								'id'=> 'resumen_anamnesis',
								'rows' => '7',
								'class'=>"fValidate['required']",
								'value'=> $consulta['condiciones_generales'],
								'cols'=> '80'))?></td></tr>
 <tr>
  <th colspan="2">Exámenes auxiliares de diagnósticos solicitados</th></tr>
<td colspan="2"><?=form_textarea(array('name' => 'examenes_auxiliares',
								'id'=> 'examenes_auxiliares',
								'rows' => '7',
								'class'=>"fValidate['required']",
								'cols'=> '80'))?></td></tr>
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
    <td class="campo_centro">Marca</td>
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
<td>
<input name="evos[]" id="evos[]" type="checkbox" value="<?=$d['id_evolucion']?>" />
</td>
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
<tr><th colspan="2">Diagnósticos</th></tr>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro" colspan="4">Diagn&oacute;sticos de ingreso</td></tr>
<tr>
<td class="campo_centro">Marca</td>
<td class="campo_centro">CI-10</td>
<td class="campo_centro">Descripci&oacute;n</td></tr>
<?php
$i = 1;
if(count($dx) > 0)
{
foreach($dx as $d)
{
?>
<tr><td style="text-align:center">
<input name="dxI[]" id="dxI[]" type="checkbox" value="<?=$d['id_diag']?>" /></td>
<td><?=$d['id_diag']?></td>
<td><?=$d['diagnostico']?></td></tr>
<?php
$i++;
}
}
?>
<tr><td class="campo_centro" colspan="4">Diagn&oacute;sticos de egreso</td></tr>
<tr>
<td class="campo_centro">Marca</td>
<td class="campo_centro">CI-10</td>
<td class="campo_centro">Descripci&oacute;n</td></tr>
<?php
$i = 1;
if(count($dx_evo) > 0)
{
foreach($dx_evo as $d)
{
?>
<tr><td style="text-align:center">
<input name="dxE[]" id="dxE[]" type="checkbox" value="<?=$d['id_diag']?>" /></td>
<td><?=$d['id_diag']?></td>
<td><?=$d['diagnostico']?></td></tr>
<?php
$i++;
}
}
?>
</table>
</td></tr>
 <tr>
  <th colspan="2">Complicaciones</th></tr>
<td colspan="2"><?=form_textarea(array('name' => 'complicaciones',
								'id'=> 'complicaciones',
								'rows' => '7',
								'class'=>"fValidate['required']",
								'cols'=> '80'))?></td></tr>
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




 <tr>
  <th colspan="2">Motivo de remisión</th></tr>
<td colspan="2"><?=form_textarea(array('name' => 'motivo_remision',
								'id'=> 'motivo_remision',
								'rows' => '7',
								'class'=>"fValidate['required']",
								'cols'=> '80'))?></td></tr>

<tr><th colspan="2">Responsable</th></tr>
<tr><td class="campo">Certifico que el cuadro clínico anteriormente descrito junto con su tratamiento fueron consecuencia de:</td>
<td><?=$origen['origen']?></td>
</tr>
<tr>
<td class="campo">Médico que realiza la remision:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Código:</td>
<td><?=$medico['tarjeta_profesional']?></td></tr>
<tr><td class="campo">Fecha y hora epicrisis:</td>
<td><?=$fecha_egreso?></td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>                               
</table>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>
</div>
<br />
<?=form_close();?>
</td></tr></table>
