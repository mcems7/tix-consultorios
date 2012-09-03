<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
slidePaciente = null;
////////////////////////////////////////////////////////////////////////////////
function verificar_entidad()
{
	var origen = $('id_origen').value;
	if(origen == 0){
		return false;	
	}
	
	var var_url = '<?=site_url()?>/hosp/hosp_registrar/verificarEntidad';	
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onSuccess: function(html){$('responsable_pago').set('html', html);},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
		
	});
	ajax1.send();
}
////////////////////////////////////////////////////////////////////////////////
function agregar_dX()
{
	if(!validarDx())
	{
		return false;
	}
	var var_url = '<?=site_url()?>/hosp/hosp_registrar/agregar_dx';
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
function validarFormulario()
{
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
	var var_url = '<?=site_url()?>/hosp/hosp_registrar/dxAvanzados';
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
	var var_url = '<?=site_url()?>/hosp/hosp_registrar/dxSimple';
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
</script>
<h1 class="tituloppal">Hospitalización</h1>
<h2 class="subtitulo">Ingreso de un paciente</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/hosp/hosp_registrar/registrarAtencion_',$attributes);
echo form_hidden('id_paciente',$paciente['id_paciente']);
echo form_hidden('id_entidad',$paciente['id_entidad']);
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
<tr><td class="campo">Entidad:</td><td>
<?php 
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

<tr>
  <th colspan="2">Información de la atención</th></tr>
<tr><td class="campo" width="35%">Fecha y hora de ingreso:</td>
<td width="65%">
<?=form_input(array('name' => 'fecha_ing',
						'id'=> 'fecha_ing',
						'maxlength' => '10',
						'value' => date('Y-m-d'),
						'class'=> "fValidate['dateISO8601']",
						'size'=> '10'))?>(aaaa-mm-dd)
  &nbsp;                      
<?=form_input(array('name' => 'hora_ing',
						'id'=> 'hora_ing',
						'maxlength' => '5',
						'value' => date('H:i:s'),
						'class'=> "fValidate['required']",
						'size'=> '5'))?> (HH:mm)
</td></tr>
<td  class="campo">Servicio hospitalario:</td><td >
<select name="id_servicio" id="id_servicio">
    <option value="0">-Seleccione uno-</option>
<?php
	foreach($servicios as $d)
	{
		echo '<option value="'.$d['id_servicio'].'">'.$d['nombre_servicio'].'</option>';	
	}
?>      
    </select></td></tr>
 <tr>
<td class="campo">Cama:</td>
<td><?=form_input(array('name' => 'cama',
						'id'=> 'cama',
						'maxlength' => '4',
						'class'=> "fValidate['integer']",
						'size'=> '3'))?></td></tr>
 <tr><td class="campo">Origen de la atenci&oacute;n:</td>
<td>
<select name="id_origen" id="id_origen" onchange="verificar_entidad()">
<option value="0" selected="selected">-Seleccione uno-</option>
<?
	foreach($origen as $d)
	{
		echo '<option value="'.$d['id_origen'].'">'.$d['origen'].'</option>';
	}
?>
</select>
</td>
</tr>
<tr><td class="campo" width="40%">Responsable de pago:</td>
<td id="responsable_pago">
</td>
</tr>
<tr>
<td class="campo">N&uacute;mero de ingreso:</td>
<td><?=form_input(array('name' => 'numero_ingreso',
						'id'=> 'numero_ingreso',
						'maxlength' => '12',
						'class'=> "fValidate['integer']",
						'size'=> '10'))?></td></tr>
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
