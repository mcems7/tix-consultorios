<?php 

if ($tipo=='urg')
{

?>
<ul class="cvoptions">
        <li style="background-image:url(<?=base_url()?>/resources/img/inicial.png); width:32px; height:32px"> <a href="<?=site_url()?>/hce/main/consultaAtencionEfecto/<?=$atencion['id_atencion']?>" class="emailbutton" rel="lightbox[external 780 480]" title="Consulta Inicial">Consulta Inicial</a></li>
      <li style="background-image:url(<?=base_url()?>/resources/img/evoluciones.png); width:32px; height:32px"> <a href="<?=site_url()?>/hce/main/consultaEvolucionesEfecto/<?=$atencion['id_atencion']?>" class="emailbutton" rel="lightbox[external 780 480]" title="Evoluciones">Evoluciones</a></li>
      
</ul>
<?php
}
?>

<script type="text/javascript">////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{	
	var contCups = $('contCups').value;
	
	if(contCups <= 0){
		alert("Dede agregar los procedimientos y servicios a solicitar!!");
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
	
	var contCups = $('contCups').value;
	$('contCups').value = parseInt(contCups)+1;
	
	var var_url = '<?=site_url()?>/auto/anexo3/agregarProcedimiento';
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
		var contCups= $('contCups').value;
		$('contCups').value = parseInt(contCups)-1;
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
	var var_url = '<?=site_url()?>/auto/anexo3/cupsAvanzados';
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
	var var_url = '<?=site_url()?>/auto/anexo3/cupsSimple';
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
<h1 class="tituloppal">Central de autorizaciones - Anexo técnico No. 3</h1>
<h2 class="subtitulo">Solicitud de autorización de servicios de salud</h2>
<center>
<?php
$fecha = date('Y-m-d');
$hora = date('H:i');
$id_depa = substr($empresa['id_municipio'], 0, 2);
$id_muni = substr($empresa['id_municipio'], 2, 3);
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/auto/anexo3/anexo3_',$attributes);
echo form_hidden('id_paciente',$paciente['id_paciente']);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('fecha_anexo',$fecha);
echo form_hidden('hora_anexo',$hora);
echo form_hidden('cod_depa_empresa',$id_depa);
echo form_hidden('cod_muni_empresa',$id_muni);
echo form_hidden('numero_informe',$conse);
echo form_hidden('id_empresa',$empresa['id_empresa']);
echo form_hidden('tipo',$tipo);
echo form_hidden('id_origen',$atencion['id_origen']);
echo form_hidden('numero_documento',$tercero['numero_documento']);

?>
<input type="hidden" name="contCups" value="0" id="contCups" />
<table width="100%" class="tabla_form">
<tr><th colspan="2">Información general</th></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr><td class="campo">Número de informe:</td><td><? printf("%04d",$conse);?></td>
<td class="campo">Fecha:</td><td><?=$fecha?></td>
<td class="campo">Hora:</td><td><?=$hora?></td></tr>
</table>
</td></tr>
<tr><th colspan="2">Información del prestador</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Nombre:</td><td colspan="3"><?=$empresa['razon_social']?></td><td class="campo">Nit:</td><td><?=$empresa['nit']?> - <?=$empresa['nit_dv']?></td></tr>
<tr><td class="campo">Código:</td><td><?=$empresa['codigo']?></td><td class="campo">Dirección prestador:</td><td colspan="3"><?=$empresa['direccion']?></td></tr>
<tr><td class="campo">Teléfono:</td><td>(<?=$empresa['indicativo']?>) <?=$empresa['telefono1']?></td><td class="campo">Departamento:</td><td><?=$empresa['depa']?> <strong><?=$id_depa?></strong></td><td class="campo">Municipio:</td><td><?=$empresa['muni']?> <strong><?=$id_muni?></strong></td></tr>
</table>
</td></tr>
<tr><th colspan="2">Entidad a la que se le informa</th></tr>
<tr><td colspan="2">
<?php
$res = '';
$res2 = 'checked="checked"';
if(count($correos) == 0){
	$res = 'disabled="disabled"';
	$res2 = '';
}
?>
<table width="100%" class="tabla_registro">
<tr>
<td class="campo_centro" rowspan="2" width="5%">
<input name="id_entidad" <?=$res?>  <?=$res2?> id="id_entidad1" type="radio" value="<?=$entidad['id_entidad']?>" /></td>
<td class="campo" width="25%">Nombre pagador:</td><td><?=$entidad['razon_social']?></td><td class="campo" width="10%">Código:</td><td width="10%"><?=$entidad['codigo_eapb']?></td></tr>

<tr>
<td class="campo">Correos de notificación:</td>
<td colspan="3">
<?php
	if(count($correos) == 0){
		echo "<strong>No hay correos registrados</strong>";	
	}else{
	foreach($correos as $d)
	{
		echo $d['correo_entidad'] ,'<br/>';
	}
	}
?>
</td>
</tr>
</table>
<?php
if($atencion['id_entidad_pago'] != '0'){
$res2 = 'checked="checked"';
$res = '';
if(count($correos_entidad_pago) == 0){
	$res = 'disabled="disabled"';
	$res2 = '';
} 

?>
<table width="100%" class="tabla_registro">
<tr>
<td class="campo_centro" rowspan="2" width="5%">
<input name="id_entidad" id="id_entidad2" type="radio" <?=$res?>   value="<?=$entidad_pago['id_entidad']?>" /></td>
<td class="campo" width="25%">Nombre pagador:</td><td><?=$entidad_pago['razon_social']?></td><td class="campo" width="10%">Código:</td><td width="10%"><?=$entidad_pago['codigo_eapb']?></td></tr>

<tr>
<td class="campo">Correos de notificación:</td>
<td colspan="3">
<?php
	if(count($correos_entidad_pago) == 0){
		echo "<strong>No hay correos registrados</strong>";	
	}else{
	
	foreach($correos_entidad_pago as $d)
	{
		echo $d['correo_entidad'] ,'<br/>';
	}
	}
?>
</td>
</tr>
</table>
<?php
}
if($atencion['id_origen'] == 4 || $atencion['id_origen'] == 5){
$fosyga =	$this -> urgencias_model -> obtenerEntidad(173);
$correo_fosyga =$this -> autorizaciones_model -> obtenerCorreosEntidad(173);
?>
<table width="100%" class="tabla_registro">
<tr>
<td class="campo_centro" rowspan="2" width="5%">
<input name="id_entidad" id="id_entidad3" type="radio" value="<?=$fosyga['id_entidad']?>" /></td>
<td class="campo" width="25%">Nombre pagador:</td><td><?=$fosyga['razon_social']?></td><td class="campo" width="10%">Código:</td><td width="10%"><?=$fosyga['codigo_eapb']?></td></tr>

<tr>
<td class="campo">Correos de notificación:</td>
<td colspan="3">
<?php
	if(count($correo_fosyga) == 0){
		echo "<strong>No hay correos registrados</strong>";	
	}else{
	
	foreach($correo_fosyga as $d)
	{
		echo $d['correo_entidad'] ,'<br/>';
	}
	}
?>
</td>
</tr>
</table>
<?php
}
?>
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
<th colspan="2">Información de la atención y servicios solicitados</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo" width="50%">Origen de la atención</td>
<td width="50%"><?=$atencion['origen']?></td></tr>
<tr><td class="campo" width="50%">Tipo de servicios solicitados</td>
<td width="50%">
<input name="serv_soli" id="serv_soli" type="radio" value="1" />&nbsp;Posterior a la atención inicial de urgencias<br />
<input name="serv_soli" id="serv_soli" type="radio" value="2" />&nbsp;Servicios electivos
</td></tr>
<tr><td class="campo" width="50%">Prioridad en la atención</td>
<td width="50%">
<input name="prioridad" id="prioridad" type="radio" value="1" />&nbsp;Prioritaria<br />
<input name="prioridad" id="prioridad" type="radio" value="2" />&nbsp;No Prioritaria
</td></tr>
</table>
</td></tr>
<tr>
  <th colspan="2">Ubicación del paciente al momento de la solicitud de autorización</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
  <tr>
    <td width="50%"><input name="ubicacion_paciente" id="ubicacion_paciente" type="radio" value="1" />Consulta externa<br />
      <input name="ubicacion_paciente" id="ubicacion_paciente" type="radio" value="2" />Urgencias<br />
      <input name="ubicacion_paciente" id="ubicacion_paciente" type="radio" value="3" />Hospitalización</td>
    <td width="50%"><select name="servicio" id="servicio">
    <option value="0">-Seleccione uno-</option>
<?php
	foreach($servicios as $d)
	{
		if($atencion['id_servicio'] == $d['id_servicio']){
		echo '<option value="'.$d['id_servicio'].'" selected="selected">'.$d['nombre_servicio'].'</option>';	
		}else{
		echo '<option value="'.$d['id_servicio'].'">'.$d['nombre_servicio'].'</option>';
		}
	}
?>      
    </select><br /><br />
    Cama: 
    <?=form_input(array('name' => 'cama',
							'id'=> 'cama',
							'maxlength' => '3',
							'value' => $atencion['cama'],
							'size'=> '3',
							'class'=>"fValidate['integer']"))?>
    </td>
  </tr>
  <tr><td>Manejo integral según guía de:</td><td>
     <?=form_input(array('name' => 'guia_manejo',
							'id'=> 'guia_manejo',
							'maxlength' => '100',
							'size'=> '60'))?></td></tr>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr>
  <td colspan="2">
  <div id="div_lista_procedimientos">
  
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
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
  <tr>
    <td class="campo" width="20%">Justificación clinica:</td>
    <td width="80%">
    
	<?php
	if(isset($consulta['analisis']) && isset($consulta['conducta'])){
	$jus_clinica = '';
	$jus_clinica .= '<Enfermedad actual> '.$consulta['enfermedad_actual'];
	$jus_clinica .= ' <Analisis> '.$consulta['analisis'];
	$jus_clinica .= ' <Conducta> '.$consulta['conducta'];	
	}else{
		$jus_clinica = '';
	}
    
	echo form_textarea(array('name' => 'justificacion_clinica',
								'id'=> 'justificacion_clinica',
								'rows' => '8',
								'value' => $jus_clinica,
								'class'=>"fValidate['required']",
								'cols'=> '60'))?>
</td>
  </tr>
</table>
</td></tr>
<tr><th colspan="2">Impresi&oacute;n diagnostica</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<?php
$i = 1;
if(count($dx) > 0)
{
foreach($dx as $d)
{
?>
<tr><td class="campo">Diagnostico <?=$i?>:</td><td>
<?php
	echo '<strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'];
?>
</td></tr>
<?php
$i++;
}
}
?>
<?php
if(isset($dx_evo)){
if(count($dx_evo) > 0)
{
foreach($dx_evo as $d)
{
?>
<tr><td class="campo">Diagnostico <?=$i?>:</td><td>
<?php
	echo '<strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'];
?>
</td></tr>
<?php
$i++;
}
}
}
?>


</table>
</td></tr>
<tr><td colspan="2">
 <table width="100%" class="tabla_interna">
  <tr>
    <td style="font-weight:bold">Nombre de quien informa:</td>
    <td rowspan="2" class="campo_centro">Teléfono</td>
    <td><?=form_input(array('name' => 'indicativo_reporta',
							'id'=> 'indicativo_reporta',
							'maxlength' => '2',
							'class'=>"fValidate['integer']",
							'size'=> '1'))?>&nbsp;</td>
    <td><?=form_input(array('name' => 'telefono_reporta',
							'id'=> 'telefono_reporta',
							'maxlength' => '10',
							'class'=>"fValidate['integer']",
							'size'=> '10'))?>&nbsp;</td>
    <td><?=form_input(array('name' => 'ext_reporta',
							'id'=> 'ext_reporta',
							'maxlength' => '4',
							'class'=>"fValidate['integer']",
							'size'=> '4'))?>&nbsp;</td>
  </tr>
  <tr>
    <td><?=form_input(array('name' => 'nombre_reporta',
							'id'=> 'nombre_reporta',
							'maxlength' => '100',
							'class'=>"fValidate['required']",
							'size'=> '40'))?>&nbsp;</td>
    <td class="campo_centro">indicativo</td>
    <td class="campo_centro">número</td>
    <td class="campo_centro">extensión</td>
  </tr>
  <tr>
    <td><strong>Cargo o actividad</strong>:&nbsp;<?=form_input(array('name' => 'cargo_reporta',
							'id'=> 'cargo_reporta',
							'maxlength' => '100',
							'class'=>"fValidate['required']",
							'size'=> '40'))?>&nbsp;</td>
    <td colspan="2" class="campo_centro">Teléfono celular:</td>
    <td colspan="2"><?=form_input(array('name' => 'celular_reporta',
							'id'=> 'celular_reporta',
							'maxlength' => '10',
							'class'=>"fValidate['integer']",
							'size'=> '10'))?>&nbsp;</td>
  </tr>
</table>
</td></tr>
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
