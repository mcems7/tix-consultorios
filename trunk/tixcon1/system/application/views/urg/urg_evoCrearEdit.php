<ul class="cvoptions">
        <li style="background-image:url(../../../../resources/img/nota.png); width:32px; height:32px"> <a href="<?=site_url()?>/urg/notas_enfermeria/consultarNotaEfecto/<?=$atencion['id_atencion']?>" class="emailbutton" rel="lightbox[external 780 480]" title="Nota Enfermeria">nota enfermeria</a></li>
      <li style="background-image:url(../../../../resources/img/signos.png); width:32px; height:32px"> <a href="<?=site_url()?>/urg/sv_enfermeria/consultarSvEfecto/<?=$atencion['id_atencion']?>" class="emailbutton" rel="lightbox[external 780 480]" title="Signos Vitales">Signos Vitales</a></li>
      <li style="background-image:url(../../../../resources/img/balance.png); width:32px; height:32px"> <a href="<?=site_url()?>/urg/bl_enfermeria/consultaBlEfecto/<?=$atencion['id_atencion']?>" class="emailbutton" rel="lightbox[external 780 480]" title="Balance de liquidos">Balance de liquidos</a></li>
</ul>

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
	if(confirm('La información no ha sido almacenada\n  ¿Esta seguro que desea continuar?'))
	{
		document.location = "<?php echo $urlRegresar; ?>";	
	}
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
	
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
	
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
echo form_open('/urg/evoluciones/crearEvolucion_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
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
<tr>
<td colspan='2'>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
  <tr>
    <td class="campo">Motivo de consulta:</td>
    <td><?=$consulta['motivo_consulta']?>&nbsp;</td>
  </tr>
  <tr>
  <td class="campo">Diagn&oacute;sticos consulta inicial:</td>
  <td>
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta inicial';

}
?>
  </td></tr>
    <tr>
  <td class="campo">Diagn&oacute;sticos evoluciones:</td>
  <td>
  
  <?php
if(count($dxEvo) > 0)
{
	foreach($dxEvo as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a las evoluciones';

}
?>
  </td></tr>
</table>

</td>
</tr>
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
	foreach($dx as $dat)
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
