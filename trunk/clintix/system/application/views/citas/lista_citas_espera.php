<h1 class="tituloppal">Consulta Externa - Citas</h1>
<h2 class="subtitulo">Lista Espera</h2>
  <table width="100%" class="tabla_form">
<tr><th colspan="2">Citas por Asignar</th></tr>
<tr><td colspan="2">       
<table width="100%" class="tabla_interna">
    <tr>
       <td class="campo_centro">Fecha</td><td class="campo_centro">Tiempo Espera</td>
       <td class="campo_centro">Calif.</td> <td class="campo_centro">Tipo</td>
       <td class="campo_centro">Especialidad</td>
       <td class="campo_centro">Nombre</td>
       <td class="campo_centro">Edad</td>
       <td class="campo_centro">Motivo</td>
       <td class="campo_centro">Consultar</td>
       <td class="campo_centro">Dar Baja</td>
        <?php
        foreach($listado_citas as $item)
        {
            ?><tr>
            <td><?=$item['fecha_solicitud']?></td>
            <td><?=$this->lib_edad->edad($item['fecha_solicitud'])?></td>
            <td><?=valor_prioridad($item['prioridad'])?></td>
            <td><?=$item['tipo_cita']?></td>
            <td><?=$item['especialidad']?></td>
            <td><?=$item['primer_apellido']?> <?=$item['segundo_apellido']?> <?=$item['primer_nombre']?> <?=$item['segundo_nombre']?></td>
            <td><?=$this->lib_edad->edad($item['fecha_nacimiento'])?></td>
            <td><?=$item['motivo_remision']?></td>
            <td class="opcion"><a href="<?=site_url('citas/listas_pacientes_espera/detalle_cita/'.$item['id'])?>">Ver</a></td>
            <td class="opcion"><a href="<?=site_url('citas/autorizar_cita/detalle/'.$item['id'])?>">Dar Baja</a></td>
            </tr>
            <?php
        }
        ?>
    </tr>
</table>
    </td>
    </tr>
  </table>