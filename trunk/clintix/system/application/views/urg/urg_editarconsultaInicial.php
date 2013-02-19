<?=$this->load->view('util/util_dx_js');?>
<script type="text/javascript">
slidePaciente = null;
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	var contDx = $('contDx').value;
	
	if(contDx <= 0){
		alert("No se permite guardar una consulta sin diagnósticos!!");
		return false;
	}
	
	if(confirm('¿Está seguro que desea guardar la información?\n Luego no podrá ser modificada'))
	{
		return true;
	}else{
		return false;	
	}	
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
 
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
</script>

<h1 class="tituloppal">Servicio de urgencias - Atención inicial</h1>
<h2 class="subtitulo">Atención de urgencias</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/atencion_inicial/editarConsultaInicial_',$attributes);
echo form_hidden('id_consulta',$consulta['id_consulta']);
echo form_hidden('fecha_ini_consulta',$fecha_ini_consulta);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_paciente',$atencion['id_paciente']);
echo form_hidden('id_servicio',$atencion['id_servicio']);
$annos = $this->lib_edad->annos($tercero['fecha_nacimiento']);
?>
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
<tr><td class="campo">Entidad:</td><td>
<?php 

$genero = $paciente['genero'];

if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>

</td></tr>
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
<tr><td class="campo">Nivel o categoria:</td><td><?=$paciente['nivel_categoria']?></td></tr>
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
<tr><td class="campo">Fecha y hora de atención:</td><td><?=$fecha_ini_consulta?></td></tr>
<tr><td class="campo">Medico tratante:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr><td class="campo">Paciente remitido:</td><td><?=$atencion['remitido']?></td></tr>
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
<tr><td class="campo">Clasificaci&oacute;n TRIAGE:</td><td <?=$clas?> style="padding:10px; text-align:left;"><?=$atencion['clasificacion']?></td></tr>
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
<tr><th colspan="2">Historia cl&iacute;nica</th></tr>
<tr>
<td width="35%" class="campo">Motivo de la consulta:</td><td width="65%">
<?=form_textarea(array('name' => 'motivo_consulta',
								'id'=> 'motivo_consulta',
								'rows' => '3',
								'value' => $consulta['motivo_consulta'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?></td></tr>
<tr><td class="campo">Enfermedad actual:</td>
<td><?=form_textarea(array('name' => 'enfermedad_actual',
								'id'=> 'enfermedad_actual',
								'rows' => '3',
								'value' => $consulta['enfermedad_actual'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?></td></tr>

<tr><td class="campo">Revisi&oacute;n sistemas:</td>
<td><?=form_textarea(array('name' => 'revicion_sistemas',
							'id'=> 'revicion_sistemas',
							'rows' => '3',
							'value' => $consulta['revicion_sistemas'],
							'class' => "fValidate['required']",
							'cols'=> '55'))?></td></tr>
                            <tr>
<th colspan="2">Antecedentes</th></tr>
<tr><td class="campo">Antecedentes patol&oacute;gicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_patologicos',
								'id'=> 'ant_patologicos',
								'rows' => '3',
								'value' => $consulta_ant['ant_patologicos'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes farmacol&oacute;gicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_famacologicos',
								'id'=> 'ant_famacologicos',
								'rows' => '3',
							'value' => $consulta_ant['ant_famacologicos'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes t&oacute;xico al&eacute;rgicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_toxicoalergicos',
								'id'=> 'ant_toxicoalergicos',
								'rows' => '3',
							'value' => $consulta_ant['ant_toxicoalergicos'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes quir&uacute;rgicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_quirurgicos',
								'id'=> 'ant_quirurgicos',
								'rows' => '3',
							'value' => $consulta_ant['ant_quirurgicos'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes familiares:</td>
<td>
<?=form_textarea(array('name' => 'ant_familiares',
								'id'=> 'ant_familiares',
								'rows' => '3',
							'value' => $consulta_ant['ant_familiares'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes ginecol&oacute;gicos:</td>
<td>
<?php
	if($genero == 'Femenino'){
echo form_textarea(array('name' => 'ant_ginecologicos',
								'id'=> 'ant_ginecologicos',
								'rows' => '3',
								'value' => $consulta_ant['ant_ginecologicos'],
								'class'=>"fValidate['required']",
								'cols'=> '55'));
}else{
echo form_textarea(array('name' => 'ant_ginecologicos',
								'id'=> 'ant_ginecologicos',
								'rows' => '3',
								'value' => $consulta_ant['ant_ginecologicos'],
								'readonly' => 'readonly',
								'class'=>"fValidate['required']",
								'cols'=> '55'));
}
?>
</td></tr>
<tr><td class="campo">Otros Antecedentes:</td>
<td>
<?=form_textarea(array('name' => 'ant_otros',
								'id'=> 'ant_otros',
								'rows' => '3',
							'value' => $consulta_ant['ant_otros'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><th colspan="2">Examen f&iacute;sico</th></tr>
<tr><td class="campo">Condiciones generales:</td>
<td><?=form_textarea(array('name' => 'condiciones_generales',
							'id'=> 'condiciones_generales',
							'rows' => '5',
							'value' => $consulta['condiciones_generales'],
							'class'=>"fValidate['required']",
							'cols'=> '45'))?></td></tr>
<tr><td class="campo">Talla:</td>
<td><?=form_input(array('name' => 'talla',
							'id'=> 'talla',
							'maxlength' => '5',
							'value' => $consulta['talla'],
							'size'=> '5',
							'class'=>"fValidate['real']"))?>&nbsp;Centímetros</td></tr>
<tr><td class="campo">Peso:</td>
<?php
	if($annos <= 13){
?>
<td><?=form_input(array('name' => 'peso',
							'id'=> 'peso',
							'onChange' => "vNum('peso','1','160')",
							'maxlength' => '5',
							'value' => $consulta['peso'],
							'class'=>"fValidate['required']",
							'size'=> '5',
							))?> &nbsp;Kilogramos </td>
<?php
}else{
?>
<td><?=form_input(array('name' => 'peso',
							'id'=> 'peso',
							'onChange' => "vNum('peso','1','160')",
							'maxlength' => '5',
							'value' => $consulta['peso'],
							'size'=> '5',
							))?> &nbsp;Kilogramos </td>
<?php
}
?>			</tr>   
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" style="text-align:center" class="tabla_interna">
<tr><td class="campo_centro" colspan="5">Signos vitales TRIAGE</td></tr>
<tr>
<td width="20%" class="campo_centro">Frecuencia cardiaca</td>
<td width="20%" class="campo_centro">Frecuencia respiratoria</td>
<td width="20%" class="campo_centro">Tensi&oacute;n arterial</td>
<td width="20%" class="campo_centro">Temperatura</td>
<td width="20%" class="campo_centro">Pulsioximetr&iacute;a (SPO2)</td>
</tr>
<tr>
<td><?=$triage['frecuencia_cardiaca'];?> X min</td>
<td><?=$triage['frecuencia_respiratoria'];?>   X min</td>
<td><?=$triage['ten_arterial_s'];?>&nbsp;/&nbsp;<?=$triage['ten_arterial_d'];?></td>
<td><?=$triage['temperatura'];?> &deg;C</td>
<td><?=$triage['spo2'];?> %</td>
</table>
</td></tr>
<tr>
<td colspan="2" class="campo">
<table width="100%" border="0" cellspacing="0" cellpadding="2" style="text-align:center">
<tr><td class="campo_centro" colspan="5">Signos vitales Consulta</td></tr>
<tr>
<td width="20%" class="campo_centro">Frecuencia cardiaca</td>
<td width="20%" class="campo_centro">Frecuencia respiratoria</td>
<td width="20%" class="campo_centro">Tensi&oacute;n arterial</td>
<td width="20%" class="campo_centro">Temperatura</td>
<td width="20%" class="campo_centro">Pulsioximetr&iacute;a (SPO2)</td>
</tr>
<tr>
<td><?=form_input(array('name' => 'frecuencia_cardiaca',
							'id'=> 'frecuencia_cardiaca',
							'maxlength' => '3',
							'onChange' => "vNum('frecuencia_cardiaca','0','400')",
							'value' => $consulta['frecuencia_cardiaca'],
							'size'=> '3',
							'class'=>"fValidate['integer']"))?> X min</td>
<td><?=form_input(array('name' => 'frecuencia_respiratoria',
							'id'=> 'frecuencia_respiratoria',
							'maxlength' => '3',
							'onChange' => "vNum('frecuencia_respiratoria','0','100')",
							'value' => $consulta['frecuencia_respiratoria'],
							'size'=> '3',
							'class'=>"fValidate['integer']"))?>   X min</td>
<td><?=form_input(array('name' => 'ten_arterial_s',
							'id'=> 'ten_arterial_s',
							'maxlength' => '3',
							'onChange' => "vNum('ten_arterial_s','0','350')",
							'value' => $consulta['ten_arterial_s'],
							'size'=> '3',
							'class'=>"fValidate['integer']"))?>&nbsp;/&nbsp;
    <?=form_input(array('name' => 'ten_arterial_d',
							'id'=> 'ten_arterial_d',
							'maxlength' => '3',
							'onChange' => "vNum('ten_arterial_d','0','250')",
							'value' => $consulta['ten_arterial_d'],
							'size'=> '3',
							'class'=>"fValidate['integer']"))?></td>
<td><?=form_input(array('name' => 'temperatura',
							'id'=> 'temperatura',
							'onChange' => "vNum('temperatura','20','45')",
							'maxlength' => '4',
							'value' => $consulta['temperatura'],
							'size'=> '4',
							'class'=>"fValidate['real']"))?> &deg;C</td>
<td><?=form_input(array('name' => 'spo2',
							'id'=> 'spo2',
							'maxlength' => '4',
							'value' => $consulta['spo2'],
							'size'=> '4',
							'onChange' => "vNum('spo2','0','100')",
							'class'=>"fValidate['integer']"))?> %</td>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>   
<tr><td class="campo">Examen cabeza:</td>
<td><?=form_textarea(array('name' => 'exa_cabeza',
						'id'=> 'exa_cabeza',
						'rows' => '3',
						'value' => $consulta_exa['exa_cabeza'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen ojos:</td>
<td><?=form_textarea(array('name' => 'exa_ojos',
						'id'=> 'exa_ojos',
						'rows' => '3',
						'value' => $consulta_exa['exa_ojos'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen oral:</td>
<td><?=form_textarea(array('name' => 'exa_oral',
						'id'=> 'exa_oral',
						'rows' => '3',
						'value' => $consulta_exa['exa_oral'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen cuello:</td>
<td><?=form_textarea(array('name' => 'exa_cuello',
						'id'=> 'exa_cuello',
						'rows' => '3',
						'value' => $consulta_exa['exa_cuello'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr> 
<tr>
  <td class="campo">Examen dorso:</td>
<td><?=form_textarea(array('name' => 'exa_dorso',
						'id'=> 'exa_dorso',
						'rows' => '3',
						'value' => $consulta_exa['exa_dorso'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen torax:</td>
<td><?=form_textarea(array('name' => 'exa_torax',
						'id'=> 'exa_torax',
						'rows' => '3',
						'value' => $consulta_exa['exa_torax'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr><td class="campo">Examen abdomen:</td>
<td><?=form_textarea(array('name' => 'exa_abdomen',
						'id'=> 'exa_abdomen',
						'rows' => '3',
						'value' => $consulta_exa['exa_abdomen'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr><td class="campo">Examen genitourinario:</td>
<td><?=form_textarea(array('name' => 'exa_genito_urinario',
						'id'=> 'exa_genito_urinario',
						'rows' => '3',
						'value' => $consulta_exa['exa_genito_urinario'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen extremidades:</td>
<td><?=form_textarea(array('name' => 'exa_extremidades',
						'id'=> 'exa_extremidades',
						'rows' => '3',
						'value' => $consulta_exa['exa_extremidades'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen neurol&oacute;gico:</td>
<td><?=form_textarea(array('name' => 'exa_neurologico',
						'id'=> 'exa_neurologico',
						'rows' => '3',
						'value' => $consulta_exa['exa_neurologico'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr><tr>
<td class="campo">Examen piel:</td>
<td><?=form_textarea(array('name' => 'exa_piel',
						'id'=> 'exa_piel',
					'rows' => '3',
						'value' => $consulta_exa['exa_piel'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr><tr>
<td class="campo">Examen mental:</td>
<td><?=form_textarea(array('name' => 'exa_mental',
						'id'=> 'exa_mental',
						'rows' => '3',
						'value' => $consulta_exa['exa_mental'],
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr><th colspan="2">Impresi&oacute;n diagnostica</th></tr>
<tr><td colspan="2" class="campo_centro">
Para asegurar la calidad de la información ingresada en la historia clínica referente a la morbilidad hospitalaria se deben ingresar los diagnósticos de la atención en estricto orden de relevancia.
</td></tr>
<tr><td colspan="2">
<?php
$n = count($dxCon);
?>
<input type="hidden" name="contDx" value="<?=$n?>" id="contDx" />
<div id="div_lista_dx">
<?php
  foreach($dxCon as $dat)
  {
    $d['dx_ID'] = $dat['id_diag'];
	$d['orden_dx'] = $dat['orden_dx'];
	$d['tipo_dx'] = $dat['tipo_dx'];
    $d['dx'] = $this->urgencias_model->obtenerDxCon($d['dx_ID']);
    echo $this->load->view('util/util_dxInfo',$d);
  }
?>
</div>
</td></tr>
<tr><td colspan="2" id="div_dx">
<?php
	echo $this->load->view('util/util_dx_Simple');
?>
<tr><td colspan="2">
<table>
<tr><td class="campo">Tipo de diagnóstico:</td>	
<td>
<input type="radio" name="tipo_dx" value="1" id="tipo_dx_0" />&nbsp;Impresión diagnóstica<br />
<input type="radio" name="tipo_dx" value="2" id="tipo_dx_1" />&nbsp;Confirmado nuevo<br />
<input type="radio" name="tipo_dx" value="3" id="tipo_dx_2" />&nbsp;Confirmado repetido<br />
<input type="hidden" value="0" name="orden_dx" id="orden_dx" />
</td>
<td style="font-weight:900;">
<ol>
<li>Diagnóstico principal.</li>
<li>Diagnóstico relacionado 1.</li>
<li>Diagnóstico relacionado 2.</li>
<li>Diagnóstico relacionado 3.</li>
<li>Diagnóstico relacionado 4.</li>
</ol>
</td>
</tr>
</table>
</td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'agregar_dX()',
				'value' => 'Agregar diagnostico',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
<tr><td colspan="2">
<?php
	echo $this->load->view('urg/urg_segu_riesgo_caidas');
?>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td class="campo">An&aacute;lisis:</td>
<td><?=form_textarea(array('name' => 'analisis',
							'id'=> 'analisis',
							'rows' => '5',
							'value' => $consulta['analisis'],
							'class'=>"fValidate['required']",
							'cols'=> '45'))?></td></tr>
<tr><td class="campo">Conducta:</td>
<td><?=form_textarea(array('name' => 'conducta',
							'id'=> 'conducta',
							'rows' => '5',
							'value' => $consulta['conducta'],
							'class'=>"fValidate['required']",
							'cols'=> '45'))?></td></tr> 
<?php
	if($medico['id_tipo_medico'] == '1')
	{
?>
<tr><td colspan="2" id="div_verificar">
<?=$this->load->view('urg/urg_consultaConfirm')?>
</td></tr>
<?php
	}else{
		echo form_hidden('verificado','SI');
		echo form_hidden('id_medico_verifica',$medico['id_medico']);
		echo form_hidden('fecha_verificado',date('Y-m-d H:i:s'));
	}
?>
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
