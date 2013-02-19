<?php
if($citas==0)
{
    echo "<center>No Hay Resultados</center>";
}
else
{
?>

<?php
$this->load->helper('form');
$attributes = array('id'       => 'formulario2',
	                'name'     => 'formulario2',
					'method'   => 'post');
	echo form_open('',$attributes);
	echo form_hidden('pin', $citas[0]['pin']); 
	?>
<table class="tabla_interna" width="100%"  style="font-size:10px">
    <tr>
        <td class="negrita">PIN</td>

        <td class="negrita">Documento</td><td  class="negrita">Nombre</td>
        <td class="negrita">Especialidad</td>
        <td  class="negrita">Entidad Actual</td>
        <td  class="negrita">Cambiar entidad por</td>
        <td  class="negrita">Accion</td>
        <?php
		
       
            ?>
    <tr>
        <td><?=$citas[0]['pin']?></td>
     
        <td><?=$citas[0]['numero_documento']?></td>
        <td><?=$citas[0]['primer_nombre']?> <?=$citas[0]['segundo_nombre']?> <?=$citas[0]['primer_apellido']?> <?=$citas[0]['segundo_apellido']?></td>
        <td><?=$citas[0]['especialidad']?></td> 
        <td><?=$citas[0]['eps']?></td>
        <td>     <select name="id_entidad" id="id_entidad" style="font-size:9px">
        <option value="0" selected="selected">-Seleccione uno-</option>
        <?php
        foreach($entidades_remision as $d)
        {
            
          
                echo '<option value="'.$d['id_entidad'].'">'.$d['nombre'].'</option>';
            
        }
        ?>
    </select> </td>
       
       <td>      <?php
        $data = array(	'name' => 'cambiar',
				'id' => 'cambiar',
				'onclick' => 'validar()',
				'value' => 'Cambiar',
				'type' =>'button');
echo form_input($data);
        ?> </td>
    </tr>
      
    </tr>
</table>
<?php 
 
    }
?>
