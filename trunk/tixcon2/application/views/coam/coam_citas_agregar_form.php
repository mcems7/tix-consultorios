<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script type="text/javascript" src="<?=base_url()?>resources/js/mootools1-2-0.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/fValidator.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax.js"></script>
<script type="text/javascript" src="<?=base_url()?>resources/js/lista_ajax/ajax-dynamic-list.js"></script>
<link rel="stylesheet" href="<?=base_url()?>resources/styles/style.css" type="text/css" media="screen" />
<link rel="stylesheet" href="<?=base_url()?>resources/styles/general.css" type="text/css" media="screen" />
<script language="javascript">
///////////////////////////////////////////////////////////////////
var ajax_list_externalFile = '<?=site_url()?>/';
///////////////////////////////////////////////////////////////////
function borrar_form()
{
    $('primer_apellido').disabled = false;
	$('segundo_apellido').disabled = false;
	$('primer_nombre').disabled = false;
	$('segundo_nombre').disabled = false;
	$('id_tipo_documento').disabled = false;
	$('documento').disabled = false;
	$('primer_apellido').value = '';
	$('segundo_apellido').value = '';
	$('primer_nombre').value = '';
	$('segundo_nombre').value = '';
	$('id_tipo_documento').selectedIndex = 0;
	$('id_entidad').selectedIndex = 0;
	$('documento_hidden').value = '-';
	$('documento').value = '';
}
///////////////////////////////////////////////////////////////////
function bloquear_nombres()
{
	$('primer_apellido').disabled = true;
	$('segundo_apellido').disabled = true;
	$('primer_nombre').disabled = true;
	$('segundo_nombre').disabled = true;
	$('id_tipo_documento').disabled = true;
	traer_paciente($('documento_hidden').value);
}
///////////////////////////////////////////////////////////////////
function traer_paciente(id)
{	
	var var_url = '<?=site_url("coam/coam_agenda_citas/obtener_paciente_cita")?>/'+id;
	var ajax = new Request(
	{
		url: var_url,
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		$('div_lista_js').set('html',html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			//borrarForm();	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax.send();	
}
///////////////////////////////////////////////////////////////////
</script>
<body style="padding:10px">
<div id="div_precarga" class="capa_ajax" style="display:none">
		<img src="<?=base_url()?>resources/img/loading2.gif" alt="Cargando..."/>
		<br />Por favor espere mientras se procesa su solicitud ...
</div>
<center>
<table width="90%" class="tabla_principal" cellpadding="0" cellspacing="0">
<tr><td>
<center>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Agregar una cita</h2>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
	echo form_open('coam/coam_agenda_citas/agregarCita',$attributes);
	echo form_hidden('hora',$hora);
	echo form_hidden('id_agenda',$id_agenda);
?>
<div id="div_lista_js">

</div>
<input type="hidden" name="paciente_nuevo" id="paciente_nuevo" value="SI" />
<table width="95%" class="tabla_form">
<tr><td style="text-align:center">

<table width="95%" class="tabla_interna">
<tr><th colspan="4">Información de la cita (Hora: <?=date("H:i",$hora)?>)</th></tr>
<tr><td class="campo">Número documento:</td>
<td>
<input size="15" type="text" id="documento" name="documento" value="" 
onkeyup="ajax_showOptions(this,'coam/coam_agenda_citas/buscar_paciente_cita',event)" AUTOCOMPLETE="off">
<input type="hidden" id="documento_hidden" name="documento_ID" value="-">
</td>
<td class="campo">Tipo documento:</td>
<td>
<select name="id_tipo_documento" id="id_tipo_documento">
<option value="0">-Seleccione uno-</option>
<?
foreach($tipo_documento as $d)
{
	echo '<option value="'.$d['id_tipo_documento'].'">'.$d['tipo_documento'].'</option>';
}
?>
</select>
</td></tr>
<tr>
<td class="campo_centro">Primer apellido</td>
<td width="25%" class="campo_centro">Segundo apellido</td>
<td class="campo_centro"  width="25%">Primer nombre</td>
<td class="campo_centro" width="25%">Segundo nombre:</td>
</tr><tr>
<td class="campo_centro">
<?=form_input(array('name' => 'primer_apellido',
					'id'=> 'primer_apellido',
					'class'=>"fValidate['alphanumtilde']",
					'maxlength'   => '20',
					'size'=> '20'))?></td>
<td class="campo_centro">
<?=form_input(array('name' => 'segundo_apellido',
					'id'=> 'segundo_apellido',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?>	
	</td>

    
    <td class="campo_centro">
<?=form_input(array('name' => 'primer_nombre',
					'id'=> 'primer_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"
					))?></td>
    
    <td class="campo_centro">
<?=form_input(array('name' => 'segundo_nombre',
					'id'=> 'segundo_nombre',
					'maxlength'   => '20',
					'size'=> '20',
					'class'=>"fValidate['alphanumtilde']"))?>
    </td>
  </tr>
<tr>
<td class="campo">Entidad:</td>
<td colspan="3" style="text-align:left">
<select name="id_entidad" id="id_entidad">
<option value="0" selected="selected">-Seleccione-</option>
<?
foreach($entidad as $d)
{
	echo '<option value="'.$d['id_entidad'].'">'.$d['razon_social'].'</option>';
}
?>
</select>
</td>
</tr>
<tr><td align="center" colspan="4">
  <?
 $data = array(	'name' => 'bc',
				'id' => 'bc',
				'onclick' => 'window.close()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'borrar',
				'id' => 'borrar',
				'onclick' => 'borrar_form()',
				'value' => 'Reestablecer',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'value' => 'Agregar cita');
echo form_submit($data);
?>
  </td></tr>
</table>
</td>
</tr>
</table>
<?=form_close();?>
</center>
<br />
</td>
</tr>
</table>
</center>
</body>