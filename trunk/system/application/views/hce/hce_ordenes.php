<h1 class="tituloppal">Servicio de Consulta Externa</h1>
<h2 class="subtitulo">Órdenes Médicas</h2>
<table width="95%" class="tabla_form">
<?php $this->load->view('atencion/aten_datos_basicos_atencion');?>
<tr><th colspan="2">Medicamentos</th></tr>
<tr><td>
    <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <?php 
    if(count($medicamentos)!=0)
    {
    foreach($medicamentos as $item)
    {
        ?>
        <tr><td>    
        <table><tr>
            <td class="campo_centro ">Medicamento</td><td class="campo_centro">Dosis Medicada</td>
            <td class="campo_centro">Frecuencia</td><td class="campo_centro">Forma Administrar</td>
           </tr><tr>
        <td><?=$item['principio_activo']?> <?=$item['descripcion']?> </td>
        <td><?=$item['dosis']?> <?=$item['descripcion_dosis']?></td>
         <td>Cada <?=$item['frecuencia']?> <?=$item['descripcion_frecuencia']?></td>
         <td><?=$item['via']?></td>
         </tr>
         </table></td></tr>
        <tr>
            <td class="campo_izquierda">Observaciones:</td><td class="texto"><?=$item['observacionesMed']?></td>
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
                 <table width="100%" border="0" cellspacing="2" cellpadding="2">
                     <tr><td class="campo_centro">Cantidad</td><td class="campo_centro">Ayuda Diagnóstica</td></tr>
                     <tr><td><?=$item['cantidad']?></td><td><?=$item['desc_subcategoria']?></td></tr>
                     <tr><td class="campo">Observacion:</td><td><?=$item['observaciones']?></td></tr>
                 </table></td></tr>
               <tr><td>
               </td></tr>
            <?php 
               }
    }
    else
    {
        echo "<tr><td><center>No se ordenaron procedimientos</center></td></tr>";
    }
            ?>
        
<td><tr>
<table width="100%" cellpadding="2" cellspacing="2" border="0">
</table>
        <div class="linea_azul"></div>
</br></br>
<center>
<?
$data = array(	'name' => 'bv',
				'onclick' => 'history.back()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresiones_consulta/imprimir_ordenes/'.$info_cita['id'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</center>