<script type="text/javascript">
slidePaciente = null;
slideControl = null;
slideVDRL = null;
slideVIH = null;
slideIgG = null;
slideIgGP = null;
slideRH = null;
slideAEA = null;
slidePE = null;
slideCP = null;
////////////////////////////////////////////////////////////////////////////////
function calcularSemanas()
{
	var fum = $('fum').value;
	
	if(fum.length < 10 || fum.length > 10){
		alert('malo');
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/atencion_inicial/calculoSemanasGestacion';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_semanas_gestacion').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
	
	var var_url = '<?=site_url()?>/urg/atencion_inicial/calculoFechaParto';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_fecha_parto').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
	
	
	
}
////////////////////////////////////////////////////////////////////////////////
function activarOtroCual()
{
	var otro = document.getElementById('control_otro').checked;
	if(otro){
		slideControl.slideIn();
	}else{
		slideControl.slideOut();
		var control_otro_cual = $('control_otro_cual');
		control_otro_cual.value ='';
	}
}
////////////////////////////////////////////////////////////////////////////////
function agregar_dX()
{
	if(!validarDx())
	{
		return false;
	}
	
	var contDx = $('contDx').value;
	$('contDx').value = parseInt(contDx)+1;
	
	var var_url = '<?=site_url()?>/urg/atencion_inicial/agregar_dx';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_dx').get('html');
		$('div_lista_dx').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarForm();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function validarDx()
{
	if($('dx_hidden').value < 1){
		alert("Debe realizar la búsqueda de un diagnostico");
		return false;
	}
	return true;
}
////////////////////////////////////////////////////////////////////////////////
function borrarForm()
{	
	$('dx_hidden').value = '';
	$('dx').value = '';
	simple();
}
////////////////////////////////////////////////////////////////////////////////
function eliminarDx(id_tabla)
{	
	if(confirm('¿Desea eliminar el diagnostico seleccionado?')){
		var contDx = $('contDx').value;
		$('contDx').value = parseInt(contDx)-1;
		$(id_tabla).dispose();	
	}
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	var contDx = $('contDx').value;
	
	for(i=0; i <document.formulario.grupo_san.length; i++){
    	if(document.formulario.grupo_san[i].checked == true){
      	var grupo_san = document.formulario.grupo_san[i].value;
			}
		}
		
	if(grupo_san == 'SI'){
		
		var grupo = $('grupo').value;
		if(grupo == 0){
			alert("Debe seleccionar un grupo sanguíneo valido!!");
			return false;	
		}
		
		var conta = 0;
		for(i=0; i <document.formulario.rh.length; i++){
    	if(document.formulario.rh[i].checked == true){
      		conta++;
			}
			if(conta == 0){
				alert("Debe indicar el RH del grupo sanguíneo!!");
				return false;
		}
		}		
	}
		
	
	if(contDx <= 0){
		alert("No se permite guardar una consulta sin diagnósticos!!");
		return false;
	}
	return true;	
}
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
 
	slideControl = new Fx.Slide('div_control_otro_cual');
	slideControl.hide();
	
	slideVDRL = new Fx.Slide('div_VDRL');
	slideVDRL.hide();
	
	slideVIH = new Fx.Slide('div_VIH');
	slideVIH.hide();
	
	slideIgG = new Fx.Slide('div_IgG');
	slideIgG.hide();
	
	slideIgGP = new Fx.Slide('div_IgGP');
	slideIgGP.hide();
	
	slideRH = new Fx.Slide('div_RH');
	slideRH.hide();
	
	slideAEA = new Fx.Slide('div_AEA');
	slideAEA.hide();
	
	slidePE = new Fx.Slide('div_PE');
	slidePE.hide();
	
	slideCP = new Fx.Slide('div_CP');
	slideCP.hide();
	 
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
function avanzado()
{
	var var_url = '<?=site_url()?>/urg/atencion_inicial/dxAvanzados';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_dx').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
function simple()
{
	var var_url = '<?=site_url()?>/urg/atencion_inicial/dxSimple';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('div_dx').set('html', html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
/////////////////////////////////////////////////////////////////////////////////
function verificarVDRL(valor){
	fecha_vdrl = $('fecha_vdrl');
	if(valor == 'SI'){
		slideVDRL.slideIn();
		fecha_vdrl = $('fecha_vdrl');
		fecha_vdrl.value = '';
	}else{
		slideVDRL.slideOut();
		fecha_vdrl = $('fecha_vdrl');
		fecha_vdrl.value = '<?=date("Y-m-d")?>';
		
	}
}
/////////////////////////////////////////////////////////////////////////////////
function verificarVIH(valor){
	
	if(valor == 'SI'){
		slideVIH.slideIn();
		
	}else{
		slideVIH.slideOut();
	}
}
/////////////////////////////////////////////////////////////////////////////////
function verificarIgG(valor){
	
	if(valor == 'SI'){
		slideIgG.slideIn();
		
	}else{
		slideIgG.slideOut();
		slideIgGP.slideOut();
	}
}
/////////////////////////////////////////////////////////////////////////////////
function verificarIgGP(valor){
	
	if(valor == 'SI'){
		slideIgGP.slideIn();
		
	}else{
		slideIgGP.slideOut();
	}
}
/////////////////////////////////////////////////////////////////////////////////
function verificarRH(valor){
	
	if(valor == 'SI'){
		slideRH.slideIn();
		
	}else{
		slideRH.slideOut();
	}
}
/////////////////////////////////////////////////////////////////////////////////
function verificarPE(valor){
	
	if(valor == 'SI'){
		slidePE.slideIn();
		
	}else{
		slidePE.slideOut();
	}	
}
/////////////////////////////////////////////////////////////////////////////////
function evaluarNumeroEmbarazos()
{
	var n = $('embarazo_numero');
	if(n.value > 1){
		slideAEA.slideIn();	
	}else{
		slideAEA.slideOut();
	}
}
/////////////////////////////////////////////////////////////////////////////////
function verificarComplica(valor)
{
	if(valor == 'SI'){
		slideCP.slideIn();
		
	}else{
		slideCP.slideOut();
		var cp = $('complicaciones_parto_cuales');
		cp.value = '';
	}	
}
/////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Atención inicial</h1>
<h2 class="subtitulo">Atención de urgencias</h2>
<h3 class="subtitulo"><b><?=anchor('urg/atencion_inicial/desistirAtencion/'.$atencion['id_atencion'],'Desistir atenci&oacute;n')?></b></h3>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/atencion_inicial/consultaInicial_',$attributes);
echo form_hidden('fecha_ini_consulta',$fecha_ini_consulta);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
$edad = $this->lib_edad->edad($tercero['fecha_nacimiento']);
$annos = $this->lib_edad->annos($tercero['fecha_nacimiento']);
?>
<input type="hidden" name="contDx" value="0" id="contDx" />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td width="40%" class="campo">Apellidos:</td>
<td width="60%"><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td></tr>
<tr><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td></tr>
<tr><td class="campo">Edad:</td><td><?=$edad?></td></tr>
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
								'value' => $triage['motivo_consulta'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?></td></tr>
<tr><td class="campo">Enfermedad actual:</td>
<td><?=form_textarea(array('name' => 'enfermedad_actual',
								'id'=> 'enfermedad_actual',
								'rows' => '3',
								'class'=>"fValidate['required']",
								'cols'=> '55'))?></td></tr>

<tr><td class="campo">Revisi&oacute;n sistemas:</td>
<td><?=form_textarea(array('name' => 'revicion_sistemas',
							'id'=> 'revicion_sistemas',
							'rows' => '3',
							'class' => "fValidate['required']",
							'cols'=> '55'))?></td></tr>
                            <tr>
<th colspan="2">Antecedentes</th></tr>
<tr><td class="campo">Antecedentes patol&oacute;gicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_patologicos',
								'id'=> 'ant_patologicos',
								'rows' => '3',
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes farmacol&oacute;gicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_famacologicos',
								'id'=> 'ant_famacologicos',
								'rows' => '3',
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
								</td></tr>
<tr><td class="campo">Antecedentes t&oacute;xico al&eacute;rgicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_toxicoalergicos',
								'id'=> 'ant_toxicoalergicos',
								'rows' => '3',
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes quir&uacute;rgicos:</td>
<td>
<?=form_textarea(array('name' => 'ant_quirurgicos',
								'id'=> 'ant_quirurgicos',
								'rows' => '3',
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Antecedentes familiares:</td>
<td>
<?=form_textarea(array('name' => 'ant_familiares',
								'id'=> 'ant_familiares',
								'rows' => '3',
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><td class="campo">Otros Antecedentes:</td>
<td>

<?=form_textarea(array('name' => 'ant_otros',
								'id'=> 'ant_otros',
								'rows' => '3',
								'value' => $triage['antecedentes'],
								'class'=>"fValidate['required']",
								'cols'=> '55'))?>
</td></tr>
<tr><th colspan="2">Antecedentes ginecol&oacute;gicos</th></tr>
<tr><td class="campo">Embarazo número:</td>
<td>
<?php	
echo form_input(array('name' => 'embarazo_numero',
								'id'=> 'embarazo_numero',
								'maxlength'   => '2',
              					'size'        => '2',
								'onChange' => "vNum('embarazo_numero','1','15'),evaluarNumeroEmbarazos()",
								'class'=>"fValidate['integer']"));
?>
</td></tr>
<tr><td class="campo">Fecha última menstruación:</td>
<td>
<?php	
echo form_input(array('name' => 'fum',
								'id'=> 'fum',
								'maxlength'   => '10',
              					'size'        => '10',
								'onChange' => 'calcularSemanas()',
								'class'=>"fValidate['dateISO8601']"));
?>&nbsp;(aaaa-mm-dd)
</td></tr>
<tr><td class="campo">Semanas de gestación por FUM:</td>
<td id="div_semanas_gestacion">
</td></tr>
<tr><td class="campo">Fecha probable del parto:</td>
<td id="div_fecha_parto">
</td></tr>
<tr><td class="campo">Número controles prenatales:</td>
<td>
<?php	
echo form_input(array('name' => 'controles_pre',
								'id'=> 'controles_pre',
								'maxlength'   => '2',
              					'size'        => '2',
								'class'=>"fValidate['integer']"));
?>
</td></tr>
<tr><td class="campo">Controles realizados por:</td>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td><input name="control_medico" id="control_medico" type="checkbox" value="SI" />Médico</td>
<td><input name="control_aux" id="control_aux" type="checkbox" value="SI" />Aux. Enfermería</td>
<td><input name="control_enfermera" id="control_enfermera" type="checkbox" value="SI" />Enfermera</td>
</tr>
<tr>
<td><input name="control_promotora" id="control_promotora" type="checkbox" value="SI" />Promotora</td>
<td><input name="control_otro" id="control_otro" type="checkbox" value="SI" onchange="activarOtroCual()" />Otro</td>
<td>

</td>
<tr><td colspan="3">
<div id="div_control_otro_cual">
Cuál:
<?=form_input(array('name' => 'control_otro_cual',
								'id'=> 'control_otro_cual',
								'maxlength'   => '250',
              					'size'        => '40',
								'class'=>"fValidate['required']"))?>
</div>
</td></tr></table>
</td></tr>
<tr><td class="campo">Último VDRL:</td>
<td>
<input type="radio" name="vdrl" value="SI" id="vdrl_0" onchange="verificarVDRL('SI')"/>SI&nbsp;
<input type="radio" name="vdrl" value="NO" id="vdrl_1" checked="checked" onchange="verificarVDRL('NO')"/>NO
<div id="div_VDRL">
<input type="radio" name="vdrl_si" value="Reactivo"/>Reactivo&nbsp;
<input type="radio" name="vdrl_si" value="No Reactivo" checked="checked"/>No Reactivo
&nbsp;
Fecha:
<?php	
echo form_input(array('name' => 'fecha_vdrl',
								'id'=> 'fecha_vdrl',
								'maxlength'   => '10',
              					'size'        => '10',
								'value'		=> date("Y-m-d"),
								'class'=>"fValidate['dateISO8601']"));
?>&nbsp;(aaaa-mm-dd)
</div>
</td></tr>
<tr><td class="campo">ELISA VIH:</td>
<td>
<input type="radio" name="vih" value="SI" id="vih_0" onchange="verificarVIH('SI')"/>SI&nbsp;
<input type="radio" name="vih" value="NO" id="vih_1" checked="checked" onchange="verificarVIH('NO')"/>NO
<div id="div_VIH">
<input type="radio" name="vih_si" value="Positivo"/>Positivo&nbsp;
<input type="radio" name="vih_si" value="Negativo" checked="checked"/>Negativo
</div>
</td></tr>
<tr><td class="campo">Toxoplasma:</td>
<td>IgG: 
<input type="radio" name="IgG" value="SI" id="IgG_0" onchange="verificarIgG('SI')"/>SI&nbsp;
<input type="radio" name="IgG" value="NO" id="IgG_1" checked="checked" onchange="verificarIgG('NO')"/>NO
<div id="div_IgG">
<br />
<input type="radio" name="IgG_si" value="Positivo" onchange="verificarIgGP('SI')"/>Positivo&nbsp;
<input type="radio" name="IgG_si" value="Negativo" checked="checked" onchange="verificarIgGP('NO')"/>Negativo
</div>
<div id="div_IgGP">
<br />
IgM:
<input type="radio" name="igm" value="SI"/>SI&nbsp;
<input type="radio" name="igm" value="NO" checked="checked"/>NO
<br />
Valor:&nbsp;
<?php	
echo form_input(array('name' => 'valor_igm',
								'id'=> 'valor_igm',
								'maxlength'   => '10',
              					'size'        => '10'));
?>
<br />
<br />
Otra Ig:&nbsp; 
<?php	
echo form_input(array('name' => 'otra_ig',
								'id'=> 'otra_ig',
								'maxlength'   => '20',
              					'size'        => '20'));
?>
</div>
</td></tr>
<tr><td class="campo">Grupo sanguíneo:</td>
<td>
<input type="radio" name="grupo_san" value="SI" id="grupo_san_0" onchange="verificarRH('SI')"/>SI&nbsp;
<input type="radio" name="grupo_san" value="NO" id="grupo_san_1" checked="checked" onchange="verificarRH('NO')"/>NO
<div id="div_RH">
Grupo:
<select name="grupo" id="grupo">
<option value="0">--</option>
  <option value="A">A</option>
  <option value="B">B</option>
  <option value="AB">AB</option>
  <option value="O">O</option>
</select>&nbsp;RH:
<input type="radio" name="rh" value="Positivo"/>Positivo&nbsp;
<input type="radio" name="rh" value="Negativo"/>Negativo
</div>
</td></tr>
<tr><td colspan="2">
<div id="div_AEA">
<table width="100%" border="0" cellspacing="2" cellpadding="2" >
<tr><th colspan="2">Antecedentes embarazo anterior</th></tr>
<tr>
  <tr>
    <td class="campo">Edad gestacional alcanzada:</td>
    <td><?php	
echo form_input(array('name' => 'edad_gestacional',
								'id'=> 'edad_gestacional',
								'maxlength'   => '2',
              					'size'        => '2'));
?>&nbsp;Semanas</td>
  </tr>
  <tr>
    <td class="campo">Producto del embarazo:</td>
    <td>
<input type="radio" name="producto_embarazo" value="Vivo" checked="checked"/>Vivo&nbsp;
<input type="radio" name="producto_embarazo" value="Muerto"/>Muerto&nbsp;
<input type="radio" name="producto_embarazo" value="Aborto"/>Aborto&nbsp;
<input type="radio" name="producto_embarazo" value="Ectópico"/>Ectópico&nbsp;
    </td>
  </tr>
  <tr>
    <td class="campo">Presentación:</td>
    <td>
<input type="radio" name="presentacion_embarazo" value="Cefálica" onchange="verificarPE('NO')"/>Cefálica&nbsp;
<input type="radio" name="presentacion_embarazo" value="Pelvíca" onchange="verificarPE('NO')"/>Pelvíca&nbsp;
<input type="radio" name="presentacion_embarazo" value="Otra" onchange="verificarPE('SI')"/>Otra&nbsp;
<div id="div_PE">
<br />
Otra cuál:
<?php	
echo form_input(array('name' => 'presentacion_embarazo_otra',
								'id'=> 'presentacion_embarazo_otra',
								'maxlength'   => '255',
              					'size'        => '60'));
?>
</div>
    </td>
  </tr>
   <tr>
    <td class="campo">Vía de parto:</td>
    <td>
    <input type="radio" name="via_parto" value="Espontáneo"/>Espontáneo&nbsp;
<input type="radio" name="via_parto" value="Cesárea"/>Cesárea&nbsp;
<input type="radio" name="via_parto" value="Instrumentado"/>Instrumentado&nbsp;</td>
  </tr>
   <tr>
    <td class="campo">Complicaciones:</td>
    <td>
<input type="radio" name="complicaciones_parto" value="NO" checked="checked" onchange="verificarComplica('NO')"/>NO&nbsp;
<input type="radio" name="complicaciones_parto" value="SI" onchange="verificarComplica('SI')"/>SI
<div id="div_CP">
<br />
Cuales:
<?php	
echo form_input(array('name' => 'complicaciones_parto_cuales',
								'id'=> 'complicaciones_parto_cuales',
								'maxlength'   => '255',
              					'size'        => '60'));
?>
</div>    
    </td>
  </tr>
</table>
<br />
<br />
<br />
<br />
<br />
<br />
</div>
</td>
</tr>

<tr><th colspan="2">Examen f&iacute;sico</th></tr>
<tr><td class="campo">Condiciones generales:</td>
<td><?=form_textarea(array('name' => 'condiciones_generales',
							'id'=> 'condiciones_generales',
							'rows' => '3',
							'class'=>"fValidate['required']",
							'cols'=> '55'))?></td></tr>						
<tr><td class="campo">Talla:</td>
<td><?=form_input(array('name' => 'talla',
							'id'=> 'talla',
							'onChange' => "vNum('talla','10','250')",
							'maxlength' => '5',
							'size'=> '5',
							))?>&nbsp;Centímetros</td></tr>
<tr><td class="campo">Peso:</td>
<?php
	if($annos <= 13){
?>
<td><?=form_input(array('name' => 'peso',
							'id'=> 'peso',
							'onChange' => "vNum('peso','1','160')",
							'maxlength' => '5',
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
							'size'=> '5',
							))?> &nbsp;Kilogramos </td>
<?php
}
?>							
</tr>
<tr><td colspan="2" class="linea_azul"></td></tr>   
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
<tr><td colspan="5" class="campo_centro">
Signos vitales
</td></tr>
<tr>
<td width="20%">Frecuencia cardiaca</td>
<td width="20%">Frecuencia respiratoria</td>
<td width="20%">Tensi&oacute;n arterial</td>
<td width="20%">Temperatura</td>
<td width="20%">Pulsioximetr&iacute;a (SPO2)</td>
</tr>
<tr>
<td><?=form_input(array('name' => 'frecuencia_cardiaca',
							'id'=> 'frecuencia_cardiaca',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('frecuencia_cardiaca','0','400')",
							'class'=>"fValidate['integer']"))?> X min</td>
<td><?=form_input(array('name' => 'frecuencia_respiratoria',
							'id'=> 'frecuencia_respiratoria',
							'onChange' => "vNum('frecuencia_respiratoria','0','100')",
							'maxlength' => '3',
							'size'=> '3',
							'class'=>"fValidate['integer']"))?>   X min</td>
<td><b>S</b>&nbsp;<?=form_input(array('name' => 'ten_arterial_s',
							'id'=> 'ten_arterial_s',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('ten_arterial_s','0','350')",
							'class'=>"fValidate['integer']")).br()?>
                           <b>D</b>&nbsp;<?=form_input(array('name' => 'ten_arterial_d',
							'id'=> 'ten_arterial_d',
							'maxlength' => '3',
							'size'=> '3',
							'onChange' => "vNum('ten_arterial_d','0','250')",
							'class'=>"fValidate['integer']"))?></td>
<td><?=form_input(array('name' => 'temperatura',
							'id'=> 'temperatura',
							'maxlength' => '4',
							'size'=> '4',
							'onChange' => "vNum('temperatura','20','45')"))?> &deg;C</td>
<td><?=form_input(array('name' => 'spo2',
							'id'=> 'spo2',
							'maxlength' => '4',
							'size'=> '4',
							'onChange' => "vNum('spo2','0','100')"))?> %</td>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>   
<tr><td class="campo">Examen cabeza:</td>
<td><?=form_textarea(array('name' => 'exa_cabeza',
						'id'=> 'exa_cabeza',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen ojos:</td>
<td><?=form_textarea(array('name' => 'exa_ojos',
						'id'=> 'exa_ojos',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen oral:</td>
<td><?=form_textarea(array('name' => 'exa_oral',
						'id'=> 'exa_oral',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen cuello:</td>
<td><?=form_textarea(array('name' => 'exa_cuello',
						'id'=> 'exa_cuello',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr> 
<tr>
  <td class="campo">Examen dorso:</td>
<td><?=form_textarea(array('name' => 'exa_dorso',
						'id'=> 'exa_dorso',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen torax:</td>
<td><?=form_textarea(array('name' => 'exa_torax',
						'id'=> 'exa_torax',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr><td class="campo">Examen abdomen:</td>
<td><?=form_textarea(array('name' => 'exa_abdomen',
						'id'=> 'exa_abdomen',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr><td class="campo">Examen genitourinario:</td>
<td><?=form_textarea(array('name' => 'exa_genito_urinario',
						'id'=> 'exa_genito_urinario',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen extremidades:</td>
<td><?=form_textarea(array('name' => 'exa_extremidades',
						'id'=> 'exa_extremidades',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr>
  <td class="campo">Examen neurol&oacute;gico:</td>
<td><?=form_textarea(array('name' => 'exa_neurologico',
						'id'=> 'exa_neurologico',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr><tr>
<td class="campo">Examen piel:</td>
<td><?=form_textarea(array('name' => 'exa_piel',
						'id'=> 'exa_piel',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr><tr>
<td class="campo">Examen mental:</td>
<td><?=form_textarea(array('name' => 'exa_mental',
						'id'=> 'exa_mental',
						'rows' => '3',
						'cols'=> '55',
						'class'=>"fValidate['required']"))?></td></tr>
<tr><th colspan="2">Impresi&oacute;n diagnostica</th></tr>
<tr><td colspan="2">
<div id="div_lista_dx">
  
</div>
</td></tr>
<tr><td colspan="2" id="div_dx">
<?php
	echo $this->load->view('urg/urg_dxSimple');
?>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'agregar_dX()',
				'value' => 'Agregar diagnostico',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td class="campo">An&aacute;lisis:</td>
<td><?=form_textarea(array('name' => 'analisis',
							'id'=> 'analisis',
							'rows' => '3',
							'class'=>"fValidate['required']",
							'cols'=> '55'))?></td></tr>
<tr><td class="campo">Conducta:</td>
<td><?=form_textarea(array('name' => 'conducta',
							'id'=> 'conducta',
							'rows' => '3',
							'class'=>"fValidate['required']",
							'cols'=> '55'))?></td></tr>
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
