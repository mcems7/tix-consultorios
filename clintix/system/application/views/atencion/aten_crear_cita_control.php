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
<?php
$attributes = array('id'=> 'formulario_carga_agenda','name'=> 'formulario_carga_agenda',
                    'method' => 'post','onsubmit'=> 'return validarFormulario()');
echo form_open('/atencion/atenciones/registrar_cita_control',$attributes);
?>
<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Pedir Cita Control</h2>
<center>
<table width="95%" class="tabla_form">
<?php 
$this->load->view('atencion/aten_datos_basicos_atencion');
echo form_hidden('id_atencion',$tercero['id']);
echo form_hidden('id_medico',$medico['id_medico']);
echo form_hidden('id_entidad',$tercero['id_entidad']);
?>
<tr><th colspan="2">Detalle Cita Control</th></tr>
<tr>
    <td>
        <table width="100%" cellpadding="2" cellspacing="2" border="0">
             <tr>
                <td class="campo" width="30%">Dias espera Solicitud:</td>
                <td><?=form_input(array('name' => 'dias_cita_control',
						'id'=> 'ddias_cita_control',
						'class'=> "fValidate['integer']",					
						'size'=> '15'))?></td>
                
            </tr>
             <tr>
                <td class="campo" width="30%">Tipo de Control:</td>
                <td>
                    <select id="tipo_cita" name="tipo_cita">
                        <option SELECTED value="consulta_control">Cita Control</option>
                        <option value="consulta_control_pos_operatorio">Cita POP</option>
                        <option value="consulta_procedimiento">Procedimiento</option>
                        <option value="junta_medica">Junta Médica</option>
                    </select>
                </td>
                
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
$data = array('name'=>'bv','onclick'=>'regresar()',
	      'value'=>'Volver','type'=>'button');
echo form_input($data);
?>
&nbsp;
<?=form_submit('boton', 'Guardar')?>
</center>