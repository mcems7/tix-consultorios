<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function validarFormulario()
{	
	var tipo = $('tipo_traslado').value;
	
	if(tipo == 0){
		alert("Debe seleccionar el tipo de traslado!!");
		return false;
	}
	
	
	var prioridad = $('prioridad').value;
	
	if(prioridad == 0){
		alert("Debe seleccionar la prioridad del traslado!!");
		return false;
	}
	
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
});
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Referencia y contrareferencia</h1>
<h2 class="subtitulo">Crear tramite de referencia y contrareferencia</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/ref/traslados/crear_traslado_',$attributes);
echo form_hidden('id_paciente',$paciente['id_paciente']);
echo form_hidden('id_atencion',$atencion['id_atencion']);
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
<tr>
<td class="campo" width="30%">Fecha y hora de recepción:</td>
<td width="70%"><input name="fecha_solicitud" type="text" id="fecha_solicitud" value="" size="18" maxlength="20" READONLY="readonly" class="fValidate['required']">
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_solicitud_b' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_solicitud',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d %H:%M:%S',
                                daFormat       :    '%Y-%m-%d %H:%M:%S',          // format of the input field
                                displayArea	   :	'fecha_solicitud',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_solicitud_b',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>

</td></tr>
<tr><td class="campo">Trámite solicitado:</td>
<td>
<textarea name="tramite" id="tramite" rows="3" style="width:100%" class="fValidate['required']"></textarea>
</td></tr>
<tr><td class="campo">Tipo de traslado:</td>
<td>
<select name="tipo_traslado" id="tipo_traslado">
  <option value="0">-Seleccione una-</option>
  <option value="1">Remisión</option>
  <option value="4">Contra remisión</option>
  <option value="2">Procedimientos o examenes</option>
  <option value="3">Otro</option>
</select>
</td></tr>
<tr><td class="campo">Prioridad:</td>
<td>
<select name="prioridad" id="prioridad">
  <option value="0">-Seleccione una-</option>
  <option value="Alta">Alta</option>
  <option value="Media">Media</option>
  <option value="Baja">Baja</option>
</select>
</td></tr>
<tr>
<td class="campo">Fecha y hora de la órden:</td>
<td width="70%"><input name="fecha_orden" type="text" id="fecha_orden" value="" size="18" maxlength="20" READONLY="readonly" class="fValidate['required']">
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_orden_b' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_orden',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d %H:%M:%S',
                                daFormat       :    '%Y-%m-%d %H:%M:%S',          // format of the input field
                                displayArea	   :	'fecha_orden',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_orden_b',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>

</td></tr>
<tr><td class="campo">Procedimiento:</td>
<td>
<textarea name="procedimiento" id="procedimiento" rows="3" style="width:100%" class="fValidate['required']"></textarea>
</td></tr>
<tr><td class="campo">Médico que remite:</td>
<td>
<?=form_input(array('name' => 'medico_remite',
							'id'=> 'medico_remite',
							'maxlength' => '60',
							'size'=> '40',
							'class'=>"fValidate['required']"))?>
</td></tr>
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