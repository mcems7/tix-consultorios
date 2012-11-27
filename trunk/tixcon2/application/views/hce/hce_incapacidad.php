<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Incapacidad</h2>
<table width="95%" class="tabla_form">
<?php $this->load->view('atencion/aten_datos_basicos_atencion');?>
<tr><th colspan="2">Incapacidad Médica</th></tr>
<?php
    if(count($incapacidad)==0)
    {
   ?>
    <tr>
        <td>
    <center>
        No se registró incapacidad
    </center>
        </td>
    </tr>
    <?php   
    }   
    else
    {
?>
<tr><td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
    <td class="campo_izquierda">Fecha Inicio:</td><td><?=$incapacidad['fecha_inicio']?> </td>
    </tr>
    <tr>
    <td class="campo_izquierda">Duración:</td><td><?=$incapacidad['duracion']?> días </td>
    <tr>
    <td class="campo_izquierda">Código Diagnóstico:</td><td><?=$incapacidad['id_diagnostico']?> </td>
    </tr>
    <tr>
    <td class="campo_izquierda">Diagnóstico:</td><td><?=$incapacidad['diagnostico']?> </td>
    </tr>
    <tr>
    <td class="campo_izquierda">Observaciones:</td><td><?=$incapacidad['observacion']?> </td>
    </tr>
    </table>
        <?php
    }
        ?>
        
    </td></tr>
</table>
<div class="linea_azul"></div>
</br></br>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'history.back()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
if(count($incapacidad)!=0)
{
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_incapacidad/'.$info_cita['id'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
}
?>
</center>