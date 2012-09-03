<tr>
    <td class="campo_centro">Usando</td>
    <td class="campo_centro">Consultorio</td>
</tr>
<?php
if(count($consultorioEspecialidades)!=0)
    foreach($consultorioEspecialidades as $item)   
    {
       ?>
       <tr>
        <td><?=form_checkbox('usando_consultorio',
                             $item['id_especialidad'].'-'.$item['id_consultorio'], 
                             $item['estado']==1?TRUE:FALSE,
                             'onClick="cambiarEstadoEspecialidad(this)"
                             id="'.$item['id_especialidad'].'-'.$item['id_consultorio'].'"');?>
        </td>
        <td><?=$item['descripcion']?></td>
       </tr>
       <?php
    } 
?>
