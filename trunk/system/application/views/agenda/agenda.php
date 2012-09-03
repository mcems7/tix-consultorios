<table width="100%" class="tabla_form">
<tr><th colspan="2">Detalle de Agenda</th></tr>
<tr><td colspan="2">
<div style="display: block; width: 700px; overflow-x: scroll;">    
<table width="60%" class="tabla_interna">
    <tr>
        <td class="campo_centro">HORA</td>
        <?php
        foreach($options_array_consultorio_selected as $key1=>$value1)
        {
            ?>
        <td class="campo_centro" id="consultorio-<?=$key1?>"><?=$value1?></td>
            <?php
        }
        ?>
    </tr>
    <?php
        foreach($horas as $key=>$value)
        {
            ?>
            <tr>
                <td class="campo_centro" id="hora-<?=$key?>"><?=$value?></td>
                <?php
                    foreach($options_array_consultorio_selected as $key2=>$value2)
                    {
                      ?>
                    <?=imprimir_item_agenda($key,$key2,$datos_agenda)?>
                        <?php
                    }
                    ?>
            <tr>
            <?php
        }
    ?>
</table>
</div>
</td>
</tr>
</table>   
<?php
function imprimir_item_agenda($intervalo,$id_consultorio,$datos_agenda)
{
   $imprimio=false; 
    foreach($datos_agenda as $item)
        if($item['id_consultorio']==$id_consultorio && $item['orden_intervalo']==$intervalo)
        {
            
            ?>
            <td><div id="item-<?=$intervalo?>-<?=$id_consultorio?>"><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?>
                </br>
                -<?=$item['especialidad']?>-
                </div></td>
           <?php
        $imprimio=true;          
        }
    if(!$imprimio)    
        echo '<td><div id="item-'.$intervalo.'-'.$id_consultorio.'"></td></td>';
}
?>