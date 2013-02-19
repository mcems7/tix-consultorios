<h4>Servicio de Consulta Externa - Interconsulta</h4>
<table width="100%">
<?php $this->load->view('impresion/datos_basicos_consulta');?>
   <tr><th colspan="2">Solicitud Interconsulta</th></tr>
<tr><td>
<table width="100%" border="1">
    <tr>
    <td class="negrita">Prioridad:</td>
    <td><?=valor_prioritaria($remision['tipo_cita'])?></td>
    </tr>
    <td class="negrita">Especialidad:</td>
    <td><?=$remision['especialidad']?></td>
    </tr>
    <td class="negrita">Motivo:</td>
    <td><?=$remision['motivo_remision']?></td>
    </tr>
    <td class="negrita">Observación:</td>
    <td><?=$remision['observacion']?></td>
    </tr>
</table>
 </td>
</tr>
</table>