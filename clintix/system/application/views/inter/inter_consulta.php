<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
	 var exValidatorA = new fValidator("formulario");	
});
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{
 	if(confirm('¿Está seguro que desea realizar la operación?')){
		return true;
	}else{
 		return false;
	}
}
////////////////////////////////////////////////////////////////////////////////
function agregar_obs()
{
	var obs = $('observacion').value.length;
	if(obs < 10){
		alert('La observación debe superar los 10 caracteres!!');
		return false;
	}
	
	var var_url = '<?=site_url()?>/inter/main/agregarObsInterconsulta';
	var ajax1 = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		$('div_obs').set('html',html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');}
	});
	ajax1.send();		
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias</h1>
<h2 class="subtitulo"><span class="tituloppal">Interconsulta</span></h2>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/inter/main/notificarInterconsulta',$attributes);
echo form_hidden('id_interconsulta',$inter['id_interconsulta']);
?>
<center>
<table width="95%" class="tabla_form">
<tr><th colspan="2">Información del paciente</th></tr>
<tr><td>

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
<tr><td class="campo">Fecha y hora solicitud interconsulta:</td><td><?=$inter['fecha_solicitud']?></td></tr>
<tr><td class="campo" width="30%">Medico que solicita:</td>
<td width="70%"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td></tr>
<tr>
  <th colspan="2">Datos interconsulta</th></tr>
<tr><td class="campo">Especialidad solicitada</td><td><?=$inter['descripcion']?></td></tr>
<td class="campo">Subjetivo:</td><td><?=$evo['subjetivo']?></td></tr>
<td class="campo">Objetivo:</td><td><?=$evo['objetivo']?></td></tr>
<td class="campo">Análisis:</td><td><?=$evo['analisis']?></td></tr>
<td class="campo">Conducta:</td><td><?=$evo['conducta']?></td></tr>
<tr><th colspan="2">Impresi&oacute;n diagnostica</th></tr>
<?php
$i = 1;
if(count($dxEvo) > 0)
{
foreach($dxEvo as $d)
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
}else{
?>
<tr><td class="campo_centro" colspan="2">No hay diagnosticos asociados a la interconsulta</td><td>
<?php
}
?>
<tr><th colspan="2">Observaciones</th></tr>
<tr><td colspan="2" id="div_obs">
<?php
foreach($obs as $d)
{
	$this->load->view('inter/inter_observaciones',$d);
}
?>
</td></tr>
<tr><td colspan="2">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="campo_centro">Observaci&oacute;n</td>
  </tr>
  <tr>
    <td style="text-align:center"><?=form_textarea(array('name' => 'observacion',
								'id'=> 'observacion',
								'rows' => '3',
								'cols'=> '55'))?></td>
  </tr>
    <tr>
    <td style="text-align:center">
<?php    
$data = array(	'name' => 'bv',
				'onclick' => 'agregar_obs()',
				'value' => 'Agregar observación',
				'type' =>'button');
				
echo form_input($data);
?>
</td>
  </tr>
</table>

</td></tr>
<tr><th colspan="2">Notificación</th></tr>
<tr><td colspan="2">
<?php
if($inter['estado'] == 'Consultada')
{
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="campo" width="40%">Nombres y apellidos:</td>
    <td width="60%"><?=form_input(array('name' => 'nombres',
						'id'=> 'nombres',
						'maxlength' => '255',
						'size'=> '60',
						'class'=>"fValidate['alphanumtilde']"))?></td>
  </tr>
  <tr>
    <td class="campo">Número documento:</td>
    <td><?=form_input(array('name' => 'documento',
						'id'=> 'documento',
						'maxlength' => '255',
						'size'=> '60',
						'class'=>"fValidate['nit']"))?></td>
  </tr>
  <tr><td style="text-align:center" colspan="2">
<?=form_submit('boton', 'Notificar')?>
</td></tr>
</table>
<?php
}else{
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="campo" width="40%">Nombres y apellidos:</td>
    <td width="60%"><?=$inter['nombres']?></td>
  </tr>
  <tr>
    <td class="campo">Número documento:</td>
    <td><?=$inter['documento']?></td>
  </tr>
  <tr>
    <td class="campo">Fecha y hora notificación:</td>
    <td><?=$inter['fecha_notificacion']?></td>
  </tr>

</table>
<?php
}
?>
</td></tr>

<?=form_close();?>
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
</center>
</div>
<br />
</td></tr></table>