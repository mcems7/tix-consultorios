<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
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
	if($('id_especialidad').value == 0)
	{
		alert("Debe seleccionar la especialidad a la que remite!!");
		return false;	
	}
	
	return true;
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Módulo consulta ambulatoria</h1>
<h2 class="subtitulo">Incapacidad</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/coam/coam_gestion_atencion/incapacidad_',$attributes);
echo form_hidden('id_atencion',$atencion['id_atencion']);
echo form_hidden('id_medico',$medico['id_medico']);
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td colspan="2">
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
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
<td class="campo" colspan="2">&nbsp;</td></tr>
</table>
</td>
</tr>

<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
<td class="campo">Fecha y hora de ingreso:</td>
<td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
<td class="campo">Consultorio:</td>
<td><?=$atencion['consultorio']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Motivo de consulta:</td>
<td colspan="3"><?=$consulta['motivo_consulta']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Enfermedad actual:</td>
<td colspan="3"><?=$consulta['enfermedad_actual']?>&nbsp;</td>
</tr>
   <tr>
  <td class="campo">Diagn&oacute;sticos consulta:</td>
  <td colspan="3">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta';
}
?>
  </td></tr>
</table>
</td>
</tr>
<tr><th colspan="2" id="opciones">Incapacidad</th></tr>
 <tr>
    <td class="campo">Médico que incapacita:</td>
    <td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?>&nbsp;</td>
    </tr>
<tr>
<td class="campo">Fecha de inicio incapacidad:</td>
<td><input name="fecha_inicio" type="text" id="fecha_inicio" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
                      <img src='<?=base_url()?>/resources/img/calendario_boton.png' id='fecha_inicio_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                    <script type='text/javascript'>
                    Calendar.setup({
                        inputField     :    'fecha_inicio',     		// id of the input field
                        ifFormat       :    '%Y-%m-%d',
                        daFormat       :    '%Y-%m-%d',          // format of the input field
                        displayArea	   :	'fecha_inicio',
                        showsTime      :	true,
                        timeFormat     :    '12',
                        button         :    'fecha_inicio_botton',       // trigger for the calendar (button ID)
                        align          :    'Br',                   // alignment (defaults to 'Bl')
                        singleClick    :    true
                    });
                    </script></td>
</tr>
<tr>
<td class="campo">Duración incapacidad:</td>
<td>
<?=form_input(array('name' => 'duracion',
					'id'=> 'duracion',
					'maxlength'   => '3',
					'size'=> '3',
					'class'=>"fValidate['integer']")),nbs()?>(D&iacute;as)
</td>
</tr>
<tr>
<td class="campo">Observación:</td>
<td>
<?=form_textarea(array('name' => 'observacion',
							'id'=> 'observacion',
							'rows' => '3',
							'cols'=> '55'))?>
</td>
</tr>
<tr><td class="linea_azul" colspan="2"></td></tr>      
<tr><td align="center" colspan="2">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
?>
<?=form_submit('boton', 'Guardar')?>
<?=form_close();?>
</td></tr>
</table>
</center>