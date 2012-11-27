<h4>Servicio de Consulta Externa - Órdenes Médicas</h4>
<table width="100%">
<?php $this->load->view('impresion/datos_basicos_consulta');?>
<tr><th colspan="2">Medicamentos</th></tr>
<tr><td>
    <table width="100%" border="1" cellspacing="2" cellpadding="2">
    <?php 
    if(count($medicamentos)!=0)
    {
    foreach($medicamentos as $item)
    {
        ?>
        <tr><td>    
        <table><tr>
            <td class="negrita">Medicamento</td><td class="negrita">Dosis Medicada</td>
            <td class="negrita">Frecuencia</td><td class="negrita">Forma Administrar</td>
           </tr><tr>
        <td><?=$item['principio_activo']?> <?=$item['descripcion']?> </td>
        <td><?=$item['dosis']?> <?=$item['descripcion_dosis']?></td>
         <td>Cada <?=$item['frecuencia']?> <?=$item['descripcion_frecuencia']?></td>
         <td><?=$item['via']?></td>
         </tr>
         </table></td></tr>
        <tr>
            <td><strong>Observaciones: </strong><?=$item['observacionesMed']?></td>
        </tr>
        <?php
    }
    }
    else
    {
        echo "<tr><td><center>No se ordenaron medicamentos</center></td></tr>";
    }
    ?>
    </table>
    </td></tr>
<tr><th colspan="2">Ayudas Diagnósticas</th></tr>

         <?php 
         if(count($ayudas_diagnosticas)!=0)
       {
         foreach($ayudas_diagnosticas as $item)
            {
               ?> <tr><td>
                 <table width="100%" border="1" cellspacing="2" cellpadding="2">
                     <tr><td><table><tr border="1">
                         <th border="1" class="negrita" width="10%">Cantidad</th><th class="negrita">Procedimiento o Servicio</th></tr>
                                 <tbody><tr><td width="10%" ><?=$item['cantidad']?></td><td><?=$item['desc_subcategoria']?></td></tr></tbody>
                    </table> </td></tr>
                     <tr border="1"><td><strong>Observaciones: </strong><?=$item['observaciones']?></td></tr>
                 </table></td></tr>
               <tr><td>
               </td></tr>
            <?php 
               }
               }
                else
    {
        echo '<tr><td border="1"><center>No se ordenaron procedimientos</center></td></tr>';
    }
            ?>
        
<td><tr>
</table>