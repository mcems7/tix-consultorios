<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript">
sNota = null;
eNota = false;
sAuto = null;
eAuto = false;
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{	
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
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
	sNota = new Fx.Slide('div_nota');
	sNota.hide();
	
	sAuto = new Fx.Slide('div_auto');
	sAuto.hide();
});
////////////////////////////////////////////////////////////////////////////////
function mostrar_agregar_nota()
{
	if(eNota){
		sNota.slideOut();
		eNota = false;
	}else{
		sNota.slideIn();
		eNota = true;
		sAuto.slideOut();
		eAuto = false;
		sFin.slideOut();
		eFin = false;
	}
	
	$('tipo_nota').value = 0;
	$('nota').value = '';
}
////////////////////////////////////////////////////////////////////////////////
function mostrar_autorizacion()
{
	if(eAuto){
		sAuto.slideOut();
		eAuto = false;
	}else{
		sAuto.slideIn();
		eAuto = true;
		sNota.slideOut();
		eNota = false;
	}
}
////////////////////////////////////////////////////////////////////////////////
function finalizacion()
{
	document.location = '<?=site_url('ref/traslados/finalizar_traslado/'.$traslado['id_traslado'])?>';
}
////////////////////////////////////////////////////////////////////////////////
function agregar_nota()
{
	var tipo = $('tipo_nota').value;
	if(tipo == 0){
		alert("Debe seleccionar un tipo de nota!!");
		return false;
	}
	
	var nota = $('nota').value;
	
	if(nota.length < 10)
	{
		alert("El tamaño de la nota es incorrecto!!");
		return false;	
	}
	
	var var_url = '<?=site_url()?>/ref/traslados/agregar_nota';
	var ajax = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(html){
		var html2 = $('div_lista_notas').get('html');
		$('div_lista_notas').set('html',html2, html);
		$('div_precarga').style.display = "none";},
		onComplete: function(){
			mostrar_agregar_nota()	
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax.send();	
}
////////////////////////////////////////////////////////////////////////////////
function agregar_autorizacion()
{	
	var autorizacion = $('autorizacion').value;
	
	if(autorizacion.length < 4)
	{
		alert("El tamaño del número de autorización es incorrecto!!");
		return false;	
	}
	
	var fecha_autorizacion = $('fecha_autorizacion').value;
	
	if(fecha_autorizacion.length < 4)
	{
		alert("El tamaño de la fecha de autorización es incorrecto!!");
		return false;	
	}
	
	var var_url = '<?=site_url()?>/ref/traslados/agregar_autorizacion';
	var ajax = new Request(
	{
		url: var_url,
		method: 'post',
		data:  $('formulario').toQueryString(),
		onRequest: function (){$('div_precarga').style.display = "block";},
		onSuccess: function(){$('div_precarga').style.display = "none";},
		onComplete: function(){
		document.location.reload();
		},
		evalScripts: true,
		onFailure: function(){alert('Error ejecutando ajax!');
		$('div_precarga').style.display = "none";}
	});
	ajax.send();	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Referencia y contrareferencia</h1>
<h2 class="subtitulo">Gestionar tramite de referencia y contrareferencia</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/ref/traslados/crear_traslado_',$attributes);
echo form_hidden('id_traslado',$traslado['id_traslado']);
?>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Departamento:</td><td><?=$tercero['depa']?></td>
<td class="campo">Municipio:</td><td><?=$tercero['nombre']?></td></tr>
<tr><td class="campo">Servicio:</td><td><?=$atencion['nombre_servicio']?></td>
<td class="campo"> Cama:</td><td><?=$atencion['cama']?>
</tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
</table>
</td>
</tr>
<tr>
<th colspan="2">Información de la solicitud</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Fecha y hora de recepción:</td><td><?=$traslado['fecha_solicitud']?></td>
<td class="campo">Fecha y hora de la órden:</td><td><?=$traslado['fecha_orden']?></td>
<tr><td class="campo">Trámite solicitado:</td><td colspan="3"><?=$traslado['tramite']?></td></tr>
<tr><td class="campo">Tipo traslado:</td><td colspan="3"><?php
if($traslado['tipo_traslado'] == 1){
	echo "Remisión";
}else if($traslado['tipo_traslado'] == 2){
	echo "Procedimientos o examenes";
}else if($traslado['tipo_traslado'] == 3){
	echo "Otro";
}else if($traslado['tipo_traslado'] == 4){
	echo "Contra remisión";
}
?></td></tr>
<tr><td class="campo">Prioridad:</td><td colspan="3"><?=$traslado['prioridad']?></td></tr>
<tr><td class="campo">Procedimiento:</td><td colspan="3"><?=$traslado['procedimiento']?></td></tr>
<tr><td class="campo">Médico que remite:</td><td colspan="3"><?=$traslado['medico_remite']?></td></tr>
<?php
if($traslado['autorizacion'] == 'SI')
{
?>
<tr><td class="campo">Autorización:</td><td><?=$auto['autorizacion']?></td>
<td class="campo">Fecha y hora autorización:</td><td><?=$auto['fecha_autorizacion']?></td>
</tr>
<tr><td class="campo">Observación autorización:</td><td colspan="3"><?=$auto['obs_autorizacion']?></td></tr>
<?php
}
?>
</table>
</td></tr>
<tr><th colspan="2">Diagnósticos</th></tr>
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
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'mnota',
				'id' => 'mnota',
				'onclick' => 'mostrar_agregar_nota()',
				'value' => 'Agregar nota',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'mau',
				'onclick' => 'mostrar_autorizacion()',
				'value' => 'Autorización',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'mfin',
				'onclick' => 'finalizacion()',
				'value' => 'Finalización',
				'type' =>'button');
echo form_input($data).br();
?>
</td></tr>
<tr><td  colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna" id="div_auto">
<tr><th colspan="2">Agregar autorización</th></tr>
<tr><td class="campo" width="30%">Número autorización:</td>
<td width="70%"><?=form_input(array('name' => 'autorizacion',
							'id'=> 'autorizacion',
							'maxlength' => '20',
							'size'=> '15',
							'class'=>"fValidate['required']"))?>
</td></tr>
<tr>
<td class="campo">Fecha y hora autorización:</td>
<td><input name="fecha_autorizacion" type="text" id="fecha_autorizacion" value="" size="18" maxlength="20" READONLY="readonly" class="fValidate['required']">
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_autorizacion_b' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_autorizacion',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d %H:%M:%S',
                                daFormat       :    '%Y-%m-%d %H:%M:%S',          // format of the input field
                                displayArea	   :	'fecha_autorizacion',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_autorizacion_b',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>

</td></tr>
<tr><td class="campo">Observaciones:</td>
<td><textarea name="obs_autorizacion" id="obs_autorizacion" rows="3" style="width:100%" class="fValidate['required']"></textarea></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'anota',
				'onclick' => 'mostrar_autorizacion()',
				'value' => 'Ocultar',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'anota',
				'onclick' => 'agregar_autorizacion()',
				'value' => 'Agregar autorización',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna" id="div_nota">
<tr><th colspan="2">Agregar Nota</th></tr>
<tr><td class="campo" width="30%">Fecha y hora:</td><td width="70%"><?=date("Y-m-d H:i:s")?></td></tr>
<tr><td class="campo">Funcionario:</td><td><?=$usuario['usuario']?></td></tr>
<tr><td class="campo">Tipo de nota:</td><td>
<select name="tipo_nota" id="tipo_nota">
  <option value="0">-Seleccione una-</option>
  <option value="Avance">Avance</option>
  <option value="Tarea pendiente">Tarea pendiente</option>
  <option value="Observación">Observación</option>
</select>
</td></tr>
<tr><td class="campo">Nota:</td>
<td><textarea name="nota" id="nota" rows="3" style="width:100%" class="fValidate['required']"></textarea></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'anota',
				'onclick' => 'mostrar_agregar_nota()',
				'value' => 'Ocultar',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'anota',
				'onclick' => 'agregar_nota()',
				'value' => 'Agregar nota',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</td></tr>
<tr><th colspan="2">Notas</th></tr>
<tr><td colspan="2">
<div id='div_lista_notas'>
<?php
if($notas != 0){
foreach($notas as $data){
$d['nota'] = $data;
$this->load->view('ref/ref_traslado_nota_info',$d);
}
}
?>
</div>
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