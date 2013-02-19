<table class="tabla_interna" width="100%" id="lista_pacientes"> 
<tr>
         <td class="campo_centro">Hora</td>
         <td class="campo_centro">Documento</td>
         <td class="campo_centro">Nombre</td>
         <td class="campo_centro">Consultorio</td>
         <td class="campo_centro">Especialidad</td>
         <td class="campo_centro">Especialista</td>
         <td class="campo_centro">Confirmar</td>
     </tr>
<?php
    foreach($lista_pacientes as $item)
    {
       ?> 
    <tr>
     <td>
        <?=arreglo_a_hora($item['orden_intervalo'],$parametros_agenda).':'.(strlen($item['minutos'])==1?'0':'').$item['minutos']?>
    </td>
    <td>
        <?=$item['numero_documento']?>
    </td>
    <td>
        <?=$item['primer_nombre']?>  <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?>  
    </td>
    <td>
        <?=$item['consultorio']?>
    </td>
     <td>
        <?=$item['especialidad']?>
    </td>
     <td>
        <?=$item['nombre_dr_1']?> <?=$item['nombre_dr_2']?> <?=$item['apellido_dr_1']?> <?=$item['apellido_dr_2']?>
    </td>
    <td class="opcion">
         <a onClick="validar(<?=$item['id']?>)">Confirmar</a> 
    </td>
    </tr>
        <?php
    }
?>
</table>