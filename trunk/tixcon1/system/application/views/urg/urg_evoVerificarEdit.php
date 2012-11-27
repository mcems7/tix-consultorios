<script type="text/javascript">
slideEsp = null;
////////////////////////////////////////////////////////////////////////////////
function agregar_dX()
{
	if(!validarDx())
	{
		return false;
	}
	
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
	if(confirm('¿Desea eliminar el diagnostico seleccionado?'))
		$(id_tabla).dispose();	
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
 var exValidatorA = new fValidator("formulario");
  slideEsp = new Fx.Slide('div_espe');
 slideEsp.hide();
 interconsulta();
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
////////////////////////////////////////////////////////////////////////////////
function interconsulta()
{
	var tipo = $('id_tipo_evolucion').value;
	if(tipo == 3){
		slideEsp.slideIn();
	}else{
		slideEsp.slideOut();
	}
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	var tipo = $('id_tipo_evolucion').value;
	if(tipo == 0){
		alert('Debe seleccionar el tipo de evolución');
		return false;
	}
	
	if(tipo == 3){
		var tipoE = $('id_especialidad').value;
		if(tipoE == 0){
		alert('Debe seleccionar el tipo de especialidad');
		return false;
		}
	}
	return true;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo">Registro de una nueva evolucion</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/urg/evoluciones/verificarEvolucion_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_evolucion',$evo['id_evolucion']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td colspan="2">
<table width="100%" cellpadding="2" cellspacing="2" border="0" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr></tr>
</table>
</td></tr>
<tr><th colspan="2">Atenci&oacute;n del paciente</th></tr>
<tr><td class="campo">Medico tratante:</td>
<td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr><td class="campo">Tipo medico:</td><td><?=$medico['tipo_medico']?></td></tr>
<tr><td class="campo">Especialidad:</td><td><?=$medico['especialidad']?></td></tr>
<tr>
  <th colspan="2">Datos de la evolución</th></tr>
 <tr>
<td width="35%" class="campo">Tipo evoluci&oacute;n:</td><td width="65%">
<select name="id_tipo_evolucion" id="id_tipo_evolucion" onchange="interconsulta()">
<option value="0">-Seleccione uno-</option>
<?php
foreach($tiposEvo as $d)
{	
	if($evo['id_tipo_evolucion'] == $d['id_tipo_evolucion']){
		if($d['id_tipo_evolucion'] != 4){
	echo '<option value="'.$d['id_tipo_evolucion'].'" selected="selected">'.$d['tipo_evolucion'].'</option>';
}
	}else{
		if($d['id_tipo_evolucion'] != 4){
	echo '<option value="'.$d['id_tipo_evolucion'].'">'.$d['tipo_evolucion'].'</option>';	
}
	}
}
?>
</select>
<div id="div_espe">
<strong>Especialidad interconsulta:</strong>
<select name="id_especialidad" id="id_especialidad">
  <option value="0">-Seleccione uno-</option>
 <?php
 	foreach($especialidades as $d)
	{
		echo '<option value="'.$d['id_especialidad'].'">'.$d['descripcion'].'</option>';	
	}
 ?>
</select>
</div>
</td></tr>
<tr>
<td class="campo">Subjetivo:</td><td>
<?=form_textarea(array('name' => 'subjetivo',
								'id'=> 'subjetivo',
								'rows' => '5',
								'value' => $evo['subjetivo'],
								'class'=>"fValidate['required']",
								'cols'=> '45'))?></td></tr>
<tr><td class="campo">Objetivo:</td>
<td><?=form_textarea(array('name' => 'objetivo',
								'id'=> 'objetivo',
								'rows' => '5',
								'value' => $evo['objetivo'],
								'class'=>"fValidate['required']",
								'cols'=> '45'))?></td></tr>

<tr>
<td class="campo">An&aacute;lisis:</td>
<td><?=form_textarea(array('name' => 'analisis',
							'id'=> 'analisis',
							'rows' => '5',
							'value' => $evo['analisis'],
							'class' => "fValidate['required']",
							'cols'=> '45'))?></td></tr>
<tr>
<td class="campo">Conducta:</td>
<td><?=form_textarea(array('name' => 'conducta',
							'id'=> 'conducta',
							'rows' => '5',
							'value' => $evo['conducta'],
							'class' => "fValidate['required']",
							'cols'=> '45'))?></td></tr>
<tr><th colspan="2">Impresi&oacute;n diagnostica</th></tr>
<tr><td colspan="2">
<div id="div_lista_dx">
<?php
	foreach($dxEvo as $dat)
	{
		$d['dx_ID'] = $dat['id_diag'];
		$d['dx'] = $this->urgencias_model->obtenerDxCon($d['dx_ID']);
		echo $this->load->view('urg/urg_dxInfo',$d);
	}
?>  
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
<?php
	if($medico['id_tipo_medico'] == '1')
	{
?>
<tr><td colspan="2" id="div_verificar">
<?=$this->load->view('urg/urg_evoConfirm')?>
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
