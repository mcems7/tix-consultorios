<script type="text/javascript">
function validarFormulario()
{
	if(confirm('La información ingresada se almacenara en el sistema\n  ¿Esta seguro que desea continuar?'))
	{
			return true
	}else{
			return false;
	}	
}
</script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar.js"></script>

<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/lang/calendar-es.js"></script>
<script type="text/javascript" src="<?=base_url()?>/resources/js/jscalendar/calendar-setup.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<?php
$attributes = array('id'=> 'formulario_carga_agenda','name'=> 'formulario_carga_agenda',
                    'method' => 'post','onsubmit'=> 'return validarFormulario()');
echo form_open('/atencion/atenciones/registrar_incapacidad',$attributes);
?>
<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Crear Incapacidad</h2>
<center>
<table width="95%" class="tabla_form">
<?php 
$this->load->view('atencion/aten_datos_basicos_atencion');
echo form_hidden('id_atencion',$tercero['id']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_diagnostico',$principal);
?>
<tr><th colspan="2">Datos Incapacidad</th></tr>
<tr>
    <td>
        <table width="100%" cellpadding="2" cellspacing="2" border="0">
            <tr>
                <td class="campo" width="30%">Diagnóstico:</td>
                <td><?=$principal?></td>
                
            </tr>
            <tr>
                <td class="campo" width="30%">Fecha Inicio:</td>
                <td><input name="fecha_agenda" type="text" id="fecha_agenda" value="" size="10" maxlength="10" READONLY="readonly"class="fValidate['dateISO8601']">
  <img src='<?=base_url()?>/resources/img/calendario_boton.png' id='fec leha_agenda_botton' title='Seleccionar fecha' style='cursor:pointer' onmouseout='this.style.background=""' />
<script type='text/javascript'>
Calendar.setup({
    inputField     :    'fecha_agenda',     		// id of the input field
    ifFormat       :    '%Y-%m-%d',
    daFormat       :    '%Y-%m-%d',          // format of the input field
    displayArea	   :	'fecha_agenda',
    showsTime      :	true,
    timeFormat     :    '12',
    button         :    'fecha_agenda_botton',       // trigger for the calendar (button ID)
    align          :    'Br',                   // alignment (defaults to 'Bl')
    singleClick    :    true
});
</script></td>
                
            </tr>
            <tr>
                <td class="campo" width="30%">Duración Días:</td>
                <td><?=form_input(array('name' => 'duracion',
						'id'=> 'duracion',
						'class'=> "fValidate['integer']",					
						'size'=> '15'))?></td>   
            </tr>
            <tr>
                <td class="campo" width="30%">Observación:</td>
                <td><?=form_textarea(array('name' => 'observacion',
	 'id'=> 'observacion',
	 'autocomplete'=>'off',
	 'class'=>"fValidate['required']",
                                                                'rows' => '10',
                                                                'cols'=> '70'))?></td>   
            </tr>
        </table>
    </td>
</tr>
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