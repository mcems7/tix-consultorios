<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<script type="text/javascript">
sNoTras = null;
eNoTras = false;
sSiTras = null;
eSiTras = false;
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
	sNoTras = new Fx.Slide('div_traslado_no');
	sNoTras.hide();
	sSiTras = new Fx.Slide('div_traslado_si');
	sSiTras.hide();
});
////////////////////////////////////////////////////////////////////////////////
function tras_realizado(valor)
{
	if(valor == 'SI')
	{
		sSiTras.slideIn();
		eSiTras = true;
		sNoTras.slideOut();
		eNoTras = false;		
	}else{
		sNoTras.slideIn();
		eNoTras = true;
		sSiTras.slideOut();
		eSiTras = false;
	}
}
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Referencia y contrareferencia</h1>
<h2 class="subtitulo">Finalizar tramite de referencia y contrareferencia</h2>
<center>
<?php
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/ref/traslados/finalizar_traslado_',$attributes);
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
<tr><th colspan="2">Finalizar traslado</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr>
<td class="campo" width="30%">Traslado realizado:</td>
<td width="70%"><input name="traslado_realizado" id="traslado_realizado" type="radio" value="SI" onchange="tras_realizado('SI')"/>SI&nbsp;&nbsp;<input name="traslado_realizado" id="traslado_realizado" type="radio" value="NO" onchange="tras_realizado('NO')"/>NO
<div id="div_traslado_no">
<br />
<strong>Paciente muere antes de traslado:</strong>&nbsp;
<input name="muere_traslado" id="muere_traslado" type="radio" value="SI"/>SI&nbsp;&nbsp;<input name="muere_traslado" id="muere_traslado" type="radio" value="NO"/>NO
<br /><br />
<strong>Motivo de no traslado:</strong>
<textarea name="motivo_no_traslado" id="motivo_no_traslado" rows="2" style="width:100%"></textarea>
</div>
<div id="div_traslado_si">
<br />
<table width="100%" border="0" cellspacing="2" cellpadding="2">
<tr>
<td class="campo">Fecha y hora traslado:</td>
<td width="70%"><input name="fecha_traslado" type="text" id="fecha_traslado" value="" size="18" maxlength="20" READONLY="readonly" >
                        <img src='<?=base_url()?>resources/img/calendario_boton.png' id='fecha_traslado_b' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
                            <script type='text/javascript'>
                                Calendar.setup({
                                inputField     :    'fecha_traslado',     		// id of the input field
                                ifFormat       :    '%Y-%m-%d %H:%M:%S',
                                daFormat       :    '%Y-%m-%d %H:%M:%S',          // format of the input field
                                displayArea	   :	'fecha_traslado',
                                showsTime      :	true,
                                timeFormat     :    '12',
                                button         :    'fecha_traslado_b',       // trigger for the calendar (button ID)
                                align          :    'Br',                   // alignment (defaults to 'Bl')
                                singleClick    :    true
                            });
                            </script>

</td></tr>
  <tr>
    <td width="30%" class="campo">Móvil de traslado:</td>
    <td width="70%"><?=form_input(array('name' => 'movil',
							'id'=> 'movil',
							'maxlength' => '3',
							'size'=> '3'))?></td>
  </tr>
  <tr>
    <td class="campo">Conductor:&nbsp;</td>
    <td><?=form_input(array('name' => 'conductor',
							'id'=> 'conductor',
							'maxlength' => '60',
							'size'=> '40'))?></td>
  </tr>
  <tr>
    <td class="campo">Paramédico:&nbsp;</td>
    <td><?=form_input(array('name' => 'paramedico',
							'id'=> 'paramedico',
							'maxlength' => '60',
							'size'=> '40'))?></td>
  </tr>
  <tr>
    <td class="campo">Médico:&nbsp;</td>
    <td><?=form_input(array('name' => 'medico',
							'id'=> 'medico',
							'maxlength' => '60',
							'size'=> '40'))?></td>
  </tr>
  <tr>
    <td class="campo">Observación:&nbsp;</td>
    <td><textarea name="observacion" id="observacion" rows="2" style="width:100%"></textarea></td>
  </tr>
</table>

</div>
</td>
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