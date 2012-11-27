<h4>Servicio de Consulta Externa - Incapacidad</h4>
<table width="100%">
<?php $this->load->view('impresion/datos_basicos_consulta');?>
<tr><th colspan="2">Incapacidad Médica</th></tr>
<tr><td>
    <table width="100%" border="1" cellspacing="2" cellpadding="2">
    <tr>
    <th align="left">Fecha Inicio:</th><td><?=$incapacidad['fecha_inicio']?> </td>
    </tr>
    <tr>
    <th align="left">Duración:</th><td> <?=numtoletras($incapacidad['duracion'])?> (<?=$incapacidad['duracion']?>) DÍAS</td>
    <tr>
   <tr>
    <th align="left">Finaliza el:</th><td> <?=suma_fechas($incapacidad['fecha_inicio'],$incapacidad['duracion'])?></td>
    <tr>
    <th align="left">Diagnóstico:</th><td><?=$incapacidad['id_diagnostico']?> </td>
    </tr>
    <tr>
    <th align="left">Observaciones:</th><td><?=$incapacidad['observacion']?> </td>
    </tr>
    </table>
    </td>
</tr>
</table>
