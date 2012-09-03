<center>
<?php
$n = count($lista);
if($n>0)
{
?>
<table widtd="100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora de ingreso</td>
<td class="campo_centro">Nombre e identificación del paciente</td>
<td class="campo_centro">Número cama</td>
</tr>
<?php
	$i = 1;
	foreach($lista as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td>
<?=$d['fecha_ingreso']?>
</td>
<td>
<a href="#" class="vpaciente"><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></a><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?><br />
 Edad:&nbsp;<?=$this->lib_edad->edad($d['fecha_nacimiento'])?></td>
<td align="center" id="cama<?=$d['id_atencion']?>">
<?php
$data = array(	'name' => 'bv',
		'onclick' => "ingresoServicio('".$d['id_atencion']."','".$d['id_servicio']."')",
		'value' => 'Asignar Cama',
		'type' =>'button');
echo form_input($data);
?>
</td>
</tr>	
<?php
$i++;
	}
?>
</table>
<?php
}
?>
<table widtd="100%" border="0">
<tr>
<?php
$i = 1;
foreach($camas as $d)
{	
?>
<td>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabla_cama">
  <tr>
  <?php	
  	$dat = $this->hospi_model->obtenerAtencionCama($d['id_cama']);
	//print_r($this->db->last_query());
	//$lab = $this->ordenes_model->obtenerordenlab($dat['id_paciente']);
	$lab = 0;
  ?>
	
  <td width="60px" rowspan="2">
  
<?php 
if($dat['consulta'] == 'NO'){
	$ruta = site_url().'/hospi/hospi_gestion_atencion/notaInicial/'.$dat['id_atencion'];
	?>
    <img src="<?=base_url()?>resources/images/iconos/hospi.jpg" alt="Paciente pendiente de consulta" title="Paciente pendiente de consulta"/>
<?php
}else {
	$ruta = site_url().'/hospi/hospi_gestion_atencion/main/'.$dat['id_atencion'];
	if ($lab>0){
?>
<img src="<?=base_url()?>resources/images/iconos/probetagif.gif"/>
<?php


}else {?>
<img src="<?=base_url()?>resources/images/iconos/<?=$d['icono']?>" alt"Cama <?=$d['estado']?>" title="Cama <?=$d['estado']?>"/>
<?php } 
}
?>
</td>
  </tr><tr><td>
 
   <strong>Cama:&nbsp;<?=$d['numero_cama']?></strong><br />
<?php

	if($d['estado'] == 'Ocupada')
	{
		
	if($dat != 0)
	{
?>
<a href="<?=$ruta?>" class="vpaciente">
<?=$dat['primer_nombre']." ".$dat['segundo_nombre']."<br>".$dat['primer_apellido']." ".$dat['segundo_apellido']?>
</a>
<br />
Edad: <?=$this->lib_edad->edad($dat['fecha_nacimiento'])?>
<br>
<?=$dat['razon_social']?>
	
<?php
	}else{
			echo "No hay paciente asignado, se ha generado un error";
			echo '<br /><strong><a href="#" onclick="activarCama('.$d['id_cama'].')">Activar cama</a></strong>';
		}
	}else if($d['estado'] != 'Disponible'){
		echo $d['estado'] ,br() , '<strong><a href="#" onclick="activarCama('.$d['id_cama'].')">Activar cama</a></strong>';
	}else{
		echo $d['estado'];
		}
	?>
    </td>
  </tr>
</table>

</td>
<?php    
	if( ($i % 3) == 0)
	{
		echo "</tr><tr>";		
	}
	$i++;
}
?>
</tr></table>
</center>
