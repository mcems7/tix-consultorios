<h4>Listado de Citas</h4>
<?php
if($citas==0)
{
    echo "<center>No Hay Resultados</center>";
}
else
{
?>
<table class="tabla_interna" width="100%" border="1" style="font-size:10px">
    <tr style="background-color: #CCC">
        <td class="negrita">PIN</td>
        
        <?php
            if($id_estado=='asignada')
            {
                ?>
                    <td class="negrita">Fecha Cita</td>
                <?php
            }
            else
            {
                ?>
                    <td class="negrita">Fecha Solicitud</td>
                    <td class="negrita">Estado</td>
                <?php
                
            }
        ?>
        
        <td class="negrita">Documento</td><td  class="negrita">Nombre</td>
        <td class="negrita">Especialidad</td>
        <td  class="negrita">Entidad</td>
        <?php
        foreach($citas as $item)
        {
            ?>
    <tr>
        <td><?=$item['pin']?></td>
         <?php
            if($id_estado=='asignada')
            {
                ?>
                     <td><?=$item['fecha']?></td> 
                <?php
            }
            else
            {
                ?>
                    <td><?=$item['fecha_solicitud']?></td> 
                    <td><?=$item['estado']?></td> 
                <?php
            }
        ?>
        
        <td><?=$item['numero_documento']?></td>
        <td><?=$item['primer_nombre']?> <?=$item['segundo_nombre']?> <?=$item['primer_apellido']?> <?=$item['segundo_apellido']?></td>
        <td><?=$item['especialidad']?></td> 
        <td><?=$item['entidad']?></td>
       
    </tr>
            <?php
        }
        ?>
    </tr>
</table>
<?php 
 
    }
?>
