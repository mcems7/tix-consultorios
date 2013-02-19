
<table width="100%" class="tabla_form">
<tr><th colspan="2">Citas Asignadas</th></tr>
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
    <tr>
        <td class="campo_centro">Hora</td>
        <td class="campo_centro">Documento</td>
        <td class="campo_centro">Paciente</td>
    
        <td class="campo_centro">Tipo Cita</td>
        <td class="campo_centro">Duración</td>
<?php
foreach($lista_pacientes as $item)
{
    ?>
    <tr>
        <td><?=arreglo_a_hora($item['orden_intervalo'],$parametros_agenda).':'.(strlen($item['minutos'])==1?'0':'').$item['minutos']?></td>
        <td><?=$item['numero_documento']?> </td>
        <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
      
        <td><?=valor_tipo_cita($item['tipo_cita'])?></td>
        <td><?=$item['duracion_cita']?></td>
        
       
       
    </tr>
    <?php
}
?>
 </tr>
</table>
    </td>
    </tr>
  </table>
<center>

<?php
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_pacientes_medico_dia/'.
                                                                        $datos_agenda['id_medico'].'/'.$datos_agenda['fecha'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>