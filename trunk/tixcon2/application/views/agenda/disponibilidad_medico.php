<tr>
  <td class="campo_centro">Lunes</td><td class="campo_centro">Martes</td>
  <td class="campo_centro">Miercoles</td><td class="campo_centro">Jueves</td>
  <td class="campo_centro">Viernes</td><td class="campo_centro">Sabado</td>
  <td class="campo_centro">Domingo</td>  
</tr>
<?php
foreach($disponibilidad_medico as $item)
{
    ?><tr><?php
    agregar_campo_tabla('1',$item);
    agregar_campo_tabla('2',$item);
    agregar_campo_tabla('3',$item);
    agregar_campo_tabla('4',$item);
    agregar_campo_tabla('5',$item);
    agregar_campo_tabla('6',$item);
    agregar_campo_tabla('7',$item);
    ?></tr><?php
}
function agregar_campo_tabla($key, $item)
{
    if(!array_key_exists($key, $item))
    {
        ?><td> </td><?php
        return;
    }
    ?>
        <td onclick="marcar_disponibilidad(<?=$item[$key]['id_disponibilidad']?>,
                   <?=$item[$key]['hora_inicio']?>,<?=$item[$key]['hora_fin']?>,
                   <?=$key?>);
        " class="campo_centro" 
        style="background-color:<?=$item[$key]['tipo']=='disponible'?'GREEN':'RED'?>">
        <?=$item[$key]['hora_inicio']?>-<?=$item[$key]['hora_fin']?>
        </td>
    <?php
}
?>
