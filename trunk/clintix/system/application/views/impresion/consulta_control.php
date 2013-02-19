<h4>Servicio de Consulta Externa - Consulta de Control</h4>
<table width="100%">
<?php $this->load->view('impresion/datos_basicos_consulta');?>
   <tr><th colspan="2">Solicitud de Cita de Control</th></tr>
<tr><td>
<table width="100%" border="1">
    <tr>
    <td class="negrita">PIN:</td>
    <td><?=$remision['pin']?></td>
    </tr>
    <tr>
    <td class="negrita">Dias de Espera para Solicitar Cita:</td>
    <td><?=numtoletras($remision['dias_cita_control'])?> (<?=$remision['dias_cita_control']?>) DÍAS</td>
    </tr>
     <tr>
    <td class="negrita">Programar Cita Después del:</td>
    <td><?=suma_fechas($remision['fecha_solicitud'],$remision['dias_cita_control'])?></td>
    </tr>
    <tr>
    <td class="negrita">Observación:</td>
    <td><?=$remision['observacion']?></td>
    </tr>
</table>
 </td>
</tr>
</table><br/>
<span style="font-size: 9px">Visite nuestra página web http://www.hospitalquindio.gov.co en el enlace "Consultar el estado de cita AQUI" para hacerle seguimiento al estado de su cita, debe ingresar el PIN y su número de documento</span>