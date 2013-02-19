<table width="100%" class="tabla_form">
<tr><th colspan="2">Citas Programadas para el Día <?=$datos_agenda['fecha']?></th></tr>
<tr><th colspan="2"></th></tr>
<tr><th colspan="2"></th></tr>
<tr><td colspan="2">       
<table width="100%" border="1" id="interna">
    <tr style="background-color:#CCC">
        <th class="negrita">Hora</th>
        <th class="negrita">Documento</th>
        <th class="negrita">Paciente</th>
        <th class="negrita">Celular</th>
        <th class="negrita">Tipo Cita</th>
        
<?php
foreach($lista_pacientes as $item)
{
    ?>
    <tr>
        <td width="10px"><?=arreglo_a_hora($item['orden_intervalo'],$parametros_agenda).':'.(strlen($item['minutos'])==1?'0':'').$item['minutos']?></td>
        <td><?=$item['numero_documento']?> </td>
        <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
         <td><?=$item['celular']?></td>
        <td><?=valor_tipo_cita($item['tipo_cita'])?></td>
       
    </tr>
    <?php
}
?>
 </tr>
</table>
    </td>
    </tr>
  </table>