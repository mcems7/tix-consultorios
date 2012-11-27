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
	var estado = $('estado_salida').value;
	if(estado == 0){
		alert("Debe seleccionar un estado de salida!!");
		return false;
	}
	
	if(estado == 'Muerto'){
		var muerto = $('tiempo_muerto').value;
		if(muerto == 0){
			alert("Debe seleccionar una opción en tiempo muerto");
			return false;
		}
	}
	
	if(confirm("Esta seguro de guardar la información??")){
		return true;
		}else{
		return false;
		}
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Observación</h1>
<h2 class="subtitulo">Epicrisis</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/observacion/epicrisis_',$attributes);
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
<tr><td class="campo">Estado de salida:</td><td>
<table>
<tr><td>
<select name="estado_salida" id="estado_salida" onchange="funestado_salida()">
  <option value="0">-Seleccione uno-</option>
  <option value="Vivo">Vivo</option>
  <option value="Muerto">Muerto</option>
</select></td><td id="div_tiempo_muerto">
<select name="tiempo_muerto" id="tiempo_muerto">
  <option value="0">-Seleccione uno-</option>
  <option value="menor48">Menor a 48 horas</option>
  <option value="mayor48">Mayor a 48 horas</option>
</select>
</td></tr></table>
</td></tr>
<tr><td class="campo">Incapacidad:</td>
<td>
<table>
<tr><td>
SI&nbsp;<input name="incapacidad" id="incapacidad" type="radio"  value="SI" onchange="fincapacidad('SI')" />&nbsp;NO&nbsp;<input name="incapacidad" id="incapacidad" type="radio"  value="NO" checked="checked" onchange="fincapacidad('NO')" />
</td><td id="div_incapacidad_dias">
Días:<?=nbs().form_input(array('name' => 'incapacidad_dias',
						'id'=> 'incapacidad_dias',
						'maxlength' => '3',
						'value' => '0',
						'size'=> '3',
						'class'=>"fValidate['integer']"))?>
</td></tr></table>
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
  <th colspan="2">Exámenes auxiliares de diagnósticos solicitados</th></tr>
<td colspan="2"><?=form_textarea(array('name' => 'examenes_auxiliares',
								'id'=> 'examenes_auxiliares',
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
<tr><th colspan="2">Traslado del paciente</th></tr>
<tr><td class="campo">Traslado:</td>
<td>
SI&nbsp;<input name="traslado" id="traslado" type="radio"  value="SI" onchange="traslado_paciente('SI')" />&nbsp;NO&nbsp;<input name="traslado" id="traslado" type="radio"  value="NO" checked="checked" onchange=" traslado_paciente('NO')" />
<div id="div_lugar_traslado">
<table border="0">
<tr><td>
Nivel:</td><td> <select name="nivel_traslado" id="nivel_traslado">
  <option value="0">-Seleccione uno-</option>
  <option value="Superior">Nivel superior</option>
  <option value="Local">Hospital local</option>
</select></td></tr><tr><td>Tipo de transporte:</td><td>
<select name="tipo_transporte" id="tipo_transporte">
  <option value="0">-Seleccione uno-</option>
  <option value="TAB">TAB</option>
  <option value="TAM">TAM</option>
  <option value="PROPIOS MEDIOS">PROPIOS MEDIOS</option>
</select>
</td></tr>
<tr><td>Lugar de traslado:</td><td>
<br />
<?=form_input(array('name' => 'lugar_traslado',
						'id'=> 'lugar_traslado',
						'maxlength' => '255',
						'size'=> '40',
						'value' => ' ',
						'class'=>"fValidate['alphanumtilde']"))?>
</td></tr></table>

</div>
</td></tr>
<tr><th colspan="2">Recomendaciones</th></tr>
<tr><td class="campo">
Cita de control en Consulta Externa:</td>
<td>SI&nbsp;<input name="cita_con_ext" id="cita_con_ext" type="radio"  value="SI" onchange="citaConExt('SI')" />&nbsp;NO&nbsp;<input name="cita_con_ext" id="cita_con_ext" type="radio"  value="NO" checked="checked" onchange="citaConExt('NO')" /></td></tr>
<tr><td colspan="2">
<table id="div_cita_con_ext">
<tr><td class="campo">
Con:</td><td><select name="id_especialidad" id="id_especialidad" style="font-size:10px">
  <option value="0">-Seleccione uno-</option>
 <?php
 	foreach($especialidades as $d)
	{
		echo '<option value="'.$d['id_especialidad'].'">'.$d['descripcion'].'</option>';	
	}
 ?>
</select>
</td></tr><td class="campo">En cuantos días:</td><td>
<?=form_input(array('name' => 'cita_conext',
						'id'=> 'cita_conext',
						'maxlength' => '2',
						'value' => '0',
						'size'=> '2',
						'class'=>"fValidate['integer']"))?>&nbsp;(Días)</td></tr>
</table>
</td></tr>
<tr><td class="campo">
Cita de control hospital local:</td>
<td>SI&nbsp;<input name="cita_hosp_local" id="cita_hosp_local" type="radio"  value="SI" onchange="citaHopsLocal('SI')" />&nbsp;NO&nbsp;<input name="cita_hosp_local" id="cita_hosp_local" type="radio"  value="NO" checked="checked" onchange="citaHopsLocal('NO')" /></td></tr>
<tr><td colspan="2">
<table id="div_cita_hops_local">
<tr><td class="campo">Municipio:</td><td><?=form_input(array('name' => 'municipio_cita',
						'id'=> 'municipio_cita',
						'maxlength' => '100',
						'size'=> '40',
						'value' => ' ',
						'class'=>"fValidate['alphanumtilde']"))?>
</td></tr><tr><td class="campo">En cuantos días:</td><td>
<?=form_input(array('name' => 'cita_hopslocal',
						'id'=> 'cita_hopslocal',
						'maxlength' => '2',
						'size'=> '2',
						'value' => '0',
						'class'=>"fValidate['integer']"))?>&nbsp;(Días)</td></tr>
</table>
</td></tr>
<tr><th colspan="2">Destino</th></tr>
<?php
$num = count($destino);
?>
  <tr>
    <td class="campo_centro">Destino del paciente</td>
    <td class="campo_centro">Observaciones sobre el destino</td>
  </tr>
  <tr><td style="padding-left:30px">
<?php
$i=0;

	foreach($destino as $d)
	{
		
		if($d['id_destino'] != 2){
			$res = '';
			if($i == 0){
				$res = 'checked="checked"';}
?>	
<li><input name="id_destino" id="id_destino" type="radio" value="<?=$d['id_destino']?>" <?=$res?> />&nbsp;<?=$d['destino']?></li>
  
<?php
		}
		$i++;
	}
?>
</td>
<td>
<?=form_textarea(array('name' => 'obser_destino',
							'id'=> 'obser_destino',
							'rows' => '5',
							'cols'=> '40'))?>
</td>
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
