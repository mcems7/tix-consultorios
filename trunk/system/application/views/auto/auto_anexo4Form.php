<script type="text/javascript">////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
	var estado = $('estado_anexo').value;
	if(estado == 0){
	alert("Debe definir el estado de la autorización!!");
	return false;	
	}
	return true;	
}
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	var exValidatorA = new fValidator("formulario");
});
////////////////////////////////////////////////////////////////////////////////
function agregarProcecimiento()
{
	if(!validarProce())
	{
		return false;
	}
	
	var var_url = '<?=site_url()?>/urg/ordenamiento/agregarProcedimiento';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_procedimientos').get('html');
		$('div_lista_procedimientos').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			borrarFormCubs();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();	
}
////////////////////////////////////////////////////////////////////////////////
function eliminarCups(id_tabla)
{	
	if(confirm('¿Desea eliminar el procedimiento o servicio seleccionado?'))
	{
		$(id_tabla).dispose();
	}
}
////////////////////////////////////////////////////////////////////////////////
function validarProce()
{
	if($('cups_hidden').value < 1 ){
		alert("Debe seleccionar un procedimiento");
		return false;
	}
	
	return true;
	
}
////////////////////////////////////////////////////////////////////////////////
function borrarFormCubs()
{
	var flag = $('flagCups').value;
	if(flag == 'simple'){
		$('cups_hidden').value = '';
		$('cups').value = '';
		
	}else if(flag == 'avanzado'){
		simple();
	}
}
////////////////////////////////////////////////////////////////////////////////
function avanzado()
{
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsAvanzados';
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('agregarPro').set('html', html);
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
	var var_url = '<?=site_url()?>/urg/ordenamiento/cupsSimple';
	var ajax1 = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){$('agregarPro').set('html', html);
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
<h1 class="tituloppal">Central de autorizaciones - Anexo técnico No. 4</h1>
<h2 class="subtitulo">Autorización de servicios de salud</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/auto/anexo3/anexo4_',$attributes);
echo form_hidden('id_anexo3',$anexo['id_anexo3']);
?>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Información general</th></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr>
  <td class="campo">Número autorización:</td>
<td><?=form_input(array('name' => 'numero_informe',
							'id'=> 'numero_informe',
							'maxlength' => '15',
							'size'=> '10',
							'class'=>"fValidate['required']"))?></td>
<td class="campo">Fecha:</td><td>
<?=form_input(array('name' => 'fecha_anexo',
							'id'=> 'fecha_anexo',
							'maxlength' => '10',
							'size'=> '10',
							'value' => date('Y-m-d'),
							'class'=>"fValidate['dateISO8601']"))?>
</td>
<td class="campo">Hora:</td><td>
<?=form_input(array('name' => 'hora_anexo',
							'id'=> 'hora_anexo',
							'maxlength' => '5',
							'size'=> '5',
							'value' => date('H:i:s'),
							'class'=>"fValidate['required']"))?>
</td>
<td class="campo">Estado autorización:</td><td>
<select name="estado_anexo" id="estado_anexo">
  <option value="0">-Seleccione-</option>
  <option value="3">Autorizado total</option>
  <option value="7">Autorizado parcial</option>
  <option value="8">No autorizado</option>
</select>
</td>
</tr>
</table>
</td></tr>
<tr>
  <th colspan="2">Entidad responsable de pago</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Nombre pagador:</td><td><?=$entidad['razon_social']?></td><td class="campo">Código:</td><td><?=$entidad['codigo_eapb']?></td></tr>
</table>
</td></tr>
<tr>
  <th colspan="2">Datos del paciente</th></tr>
<tr><td>
<table width="100%" class="tabla_interna">
<tr>
<td align="center"><?=$tercero['primer_apellido']?></td>
<td align="center"><?=$tercero['segundo_apellido']?></td>
<td align="center"><?=$tercero['primer_nombre']?></td>
<td align="center"><?=$tercero['segundo_nombre']?></td></tr>
<td class="campo_centro">Primer apellido</td><td class="campo_centro">Segundo apellido</td>
<td class="campo_centro">Primer nombre</td><td class="campo_centro">Segundo nombre</td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr><td class="campo">Tipo identificación:</td>
<td><?=$tercero['tipo_documento']?></td>
<td class="campo">Número documento:</td>
<td><?=$tercero['numero_documento']?></td></tr><tr>
<td class="campo">Fecha de nacimiento:</td>
<td colspan="3"><?=$tercero['fecha_nacimiento']?></td></tr>
<tr><td class="campo">Direcci&oacute;n de residencia habitual:</td>
<td colspan="3"><?=$tercero['direccion']?></td></tr>
<tr><td class="campo">Teléfono:</td>
<td colspan="3"><?=$tercero['telefono']?></td></tr>
<tr><td class="campo">Departamento:</td>
<td><?=$tercero['depa']?></td>
<td class="campo">Municipio:</td>
<td><?=$tercero['nombre']?></td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr><td class="campo">Cobertura en salud:</td><td><?=$paciente['cobertura']?></td></tr>
</table>



</td></tr>
<tr>
<th colspan="2">Servicios autorizados</th></tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">
  <?php
	foreach($anexoCups as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		echo $this->load->view('auto/auto_anexo4Cups',$d);
	}
?>
  </div>
  </td></tr>
  <tr>
  <td colspan="2">
  <div id="agregarPro">
  <?=$this->load->view('urg/urg_ordAgreProcSimple')?>
  </div>
  <center>
<?
$data = array(	'name' => 'ba',
				'onclick' => 'agregarProcecimiento()',
				'value' => 'Agregar',
				'type' =>'button');
echo form_input($data);
?>
</center>
  </td></tr>
<tr><th colspan="2">Pagos compartidos</th></tr>
<tr>
<td colspan="2">
<table width="100%" class="tabla_interna">
  <tr>
    <td colspan="2"><strong>Porcentaje del valor de los servicios de esta autorización a pagar por la entidad responsable de pago:</strong>&nbsp;<?=form_input(array('name' => 'porcentaje_pagar',
							'id'=> 'porcentaje_pagar',
							'maxlength' => '2',
							'size'=> '2',
							'value' => '0',
							'class'=>"fValidate['integer']"))?>%</td>
  </tr>
    <tr>
    <td colspan="2"><strong>Semanas de afiliación del paciente a la solicitud de la autorización:</strong>&nbsp;<?=form_input(array('name' => 'semanas_afiliacion',
							'id'=> 'semanas_afiliacion',
							'maxlength' => '4',
							'size'=> '4',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
  </tr>
  <tr>
    <td class="campo" width="50%">Reclamo de tiquete, bono o vale de pago:</td>
    <td width="50%">
    <input name="bono_pago" id="bono_pago" type="radio" value="SI" />&nbsp;SI&nbsp;
    <input name="bono_pago" id="bono_pago" type="radio" value="NO" checked="checked"/>&nbsp;NO&nbsp;</td>
  </tr>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
 <tr><td class="campo_centro" colspan="4">Recaudo del prestador</td></tr>
  <tr>
    <td class="campo_centro" width="25%">Concepto</td>
    <td class="campo_centro" width="25%">Valor en pesos</td>
    <td class="campo_centro" width="25%">Porcentaje</td>
    <td class="campo_centro" width="25%">Valor máximo en pesos</td>
  </tr>
  <tr>
    <td><input name="cuota_moderadora" type="checkbox" value="SI" />&nbsp;Cuota moderadora</td>
   <td><?=form_input(array('name' => 'valor_moderadora',
							'id'=> 'valor_moderadora',
							'maxlength' => '7',
							'value' => '0',
							'size'=> '7',
							'class'=>"fValidate['integer']"))?></td>
    <td><?=form_input(array('name' => 'porcentaje_moderadora',
							'id'=> 'porcentaje_moderadora',
							'maxlength' => '3',
							'size'=> '3',
							'value' => '0',
							'class'=>"fValidate['real']"))?>%</td>
    <td><?=form_input(array('name' => 'tope_moderadora',
							'id'=> 'tope_moderadora',
							'maxlength' => '7',
							'size'=> '7',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
  </tr>
  <tr>
     <td><input name="copago" type="checkbox" value="SI" />&nbsp;Copago</td>
    <td><?=form_input(array('name' => 'valor_copago',
							'id'=> 'valor_copago',
							'maxlength' => '7',
							'size'=> '7',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
    <td><?=form_input(array('name' => 'porcentaje_copago',
							'id'=> 'porcentaje_copago',
							'maxlength' => '3',
							'size'=> '3',
							'value' => '0',
							'class'=>"fValidate['real']"))?>%</td>
    <td><?=form_input(array('name' => 'tope_copago',
							'id'=> 'tope_copago',
							'maxlength' => '7',
							'size'=> '7',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
  </tr>
  <tr>
   <td><input name="cuota_recuperacion" type="checkbox" value="SI" />&nbsp;Cuota de recuperación</td>
    <td><?=form_input(array('name' => 'valor_recuperacion',
							'id'=> 'valor_recuperacion',
							'maxlength' => '7',
							'size'=> '7',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
    <td><?=form_input(array('name' => 'porcentaje_recuperacion',
							'id'=> 'porcentaje_recuperacion',
							'maxlength' => '3',
							'size'=> '3',
							'value' => '0',
							'class'=>"fValidate['real']"))?>%</td>
    <td><?=form_input(array('name' => 'tope_recuperacion',
							'id'=> 'tope_recuperacion',
							'maxlength' => '7',
							'size'=> '7',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
  </tr>
  <tr>
     <td><input name="otro" type="checkbox" value="SI" />&nbsp;Otro</td>
    <td><?=form_input(array('name' => 'valor_otro',
							'id'=> 'valor_otro',
							'maxlength' => '7',
							'size'=> '7',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
    <td><?=form_input(array('name' => 'porcentaje_otro',
							'id'=> 'porcentaje_otro',
							'maxlength' => '3',
							'size'=> '3',
							'value' => '0',
							'class'=>"fValidate['real']"))?>%</td>
    <td><?=form_input(array('name' => 'tope_otro',
							'id'=> 'tope_otro',
							'maxlength' => '7',
							'size'=> '7',
							'value' => '0',
							'class'=>"fValidate['integer']"))?></td>
  </tr>
</table>


</td>
</tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</td></tr>                             
</table>
<?=form_close();?>
