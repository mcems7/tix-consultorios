<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Solicitud Interconsulta</h2>
<table width="95%" class="tabla_form">
<?php $this->load->view('atencion/aten_datos_basicos_atencion');
if(count($remision)==0)
{
   ?>
    <tr><td class="campo_centro"><center>No se solicitó interconsulta</br></br></br>
        <?php
        $data = array(	'name' => 'bv',
				'onclick' => 'history.back()',
				'value' => 'Volver',
				'type' =>'button');
         echo form_input($data),nbs();?>
    </center></td></tr>
    <?php
    return;
}
?>
    
<tr><th colspan="2">Datos Remisión</th></tr>
<tr><td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
    <td class="campo_izquierda">Prioridad:</td>
    <td><?=valor_prioritaria($remision['tipo_cita'])?></td>
    </tr>
    <td class="campo_izquierda">Especialidad:</td>
    <td><?=$remision['especialidad']?></td>
    </tr>
    <td class="campo_izquierda">Motivo:</td>
    <td><?=$remision['motivo_remision']?></td>
    </tr>
    <td class="campo_izquierda">Observación:</td>
    <td><?=$remision['observacion']?></td>
    </tr>
    </table>
    </td></tr>
<tr></tr>
</table>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
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
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_remision/'.$info_cita['id'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>