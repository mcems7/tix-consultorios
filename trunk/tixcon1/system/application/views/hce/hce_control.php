<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Solicitud Cita de Control</h2>
<table width="95%" class="tabla_form">
<?php $this->load->view('atencion/aten_datos_basicos_atencion');?>
<tr><th colspan="2">Datos Solicitud</th></tr>
<tr><td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
    <td class="campo_izquierda">Dias para solicitud de cita:</td>
    <td><?=$remision['dias_cita_control']?> días</td>
    </tr>
    <tr>
    <td class="campo_izquierda">Observacion:</td>
    <td><?=$remision['observacion']?></td>
    </tr>
    </table>
    </td></tr>
<tr></tr>
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
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_control/'.$info_cita['id'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>