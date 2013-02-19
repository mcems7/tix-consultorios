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
function otra_especialidad()
{
    if($('especialidad').value==999)
        {
            cadena='<td class="campo" width="30%">Cuál:</td><td>';
            cadena+='<input id="cual_especialidad" class="fValidate[\'required\']" type="text" size="70" value="" name="cual_especialidad">';
            cadena+='</td></tr>';
            $('otra_especialidad').set('html',cadena);
        }
    else
        $('otra_especialidad').set('html','');
}
</script>
<link rel="stylesheet" type="text/css" media="all" href="<?=base_url()?>/resources/js/jscalendar/calendar-system.css" title="Calendario" />
<?php
$attributes = array('id'=> 'formulario_carga_remision','name'=> 'formulario_registro_remision',
                    'method' => 'post','onsubmit'=> 'return validarFormulario()');
echo form_open('/atencion/atenciones/registrar_remision',$attributes);
?>
<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Crear Remision</h2>
<center>
<table width="95%" class="tabla_form">
<?php 
$this->load->view('atencion/aten_datos_basicos_atencion');
$attributes = array('id'       => 'formulario',
	                'name'     => 'formulario',
					'method'   => 'post',
					'onsubmit' => 'return validarFormulario()');
echo form_open('/atencion/atenciones/registrar_remision',$attributes);
echo form_hidden('id_atencion',$tercero['id']);
echo form_hidden('id_medico',$medico['id_medico']);
?>
<tr><th colspan="2">Datos Remisión</th></tr>
<tr>
    <td>
        <table width="100%" cellpadding="2" cellspacing="2" border="0">
            <tr>
                <td class="campo" width="30%">Diagnóstico:</td>
                <td><?=$principal?></td>
                
            </tr>
            <tr>
                <td class="campo" width="30%">Especialidad Remitir:</td>
                <td><?=form_dropdown('especialidad',$listadoEspecialidades,'','id="especialidad" onChange=otra_especialidad()')?></td>
                
            </tr>
             <tr id="otra_especialidad"></tr>
            <tr>
                <td class="campo" width="30%">Prioridad:</td>
                <td><?php
                  $lista = array(
                  'no_prioritaria'  => 'No Prioritaria',
                  'prioritaria'    => 'Prioritaria',
                );
                echo form_dropdown('prioridad', $lista, 'no_prioritaria');
                ?></td>   
            </tr>
            <tr>
                <td class="campo" width="30%">Motivo Remisión:</td>
                <td><?=form_textarea(array('name' => 'motivo_remision',
	 'id'=> 'motivo_remision',
	 'autocomplete'=>'off',
	 'class'=>"fValidate['required']",
                                                                'rows' => '6',
                                                                'cols'=> '70'))?></td>   
            </tr>
            <tr>
                <td class="campo" width="30%">Observaciones:</td>
                <td><?=form_textarea(array('name' => 'observacion',
	 'id'=> 'observacion',
	 'autocomplete'=>'off',
	 'class'=>"fValidate['required']",
                                                                'rows' => '6',
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