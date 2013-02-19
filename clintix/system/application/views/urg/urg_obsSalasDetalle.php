<center>
<?php
$this->load->helper('html','url');
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
<?php
	if($d['ingreso_sala'] == 'NO')
	{
		echo "Pendiente de ingreso";
	}
	else{
		echo $d['fecha_ingreso'];
	}
?>
</td>
<td>
<?php
	if($d['ingreso_sala'] == 'NO')
	{
		$fun = "ingresoObservacion('".$d['id_observacion']."')";
	}
	else{
		$fun = "consultaPaciente('".$d['id_atencion']."')";
	}
?>
<a href="#" onclick="<?=$fun?>" class="vpaciente"><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></a><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?><br />
 Edad:&nbsp;<?=$this->lib_edad->edad($d['fecha_nacimiento'])?></td>
<td align="center" id="cama<?=$d['id_observacion']?>">
<?php
	if($d['ingreso_sala'] == 'NO')
	{
		echo "Cama no asignada";
	}
	else{
		echo $d['numero_cama'];
	}
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
  	//$dat = $this->urgencias_model->obtenerAtencionCama($d['id_cama']);
	
	$lab = 0;
	//$lab = $this->ordenes_model->obtenerordenlab($dat['id_paciente']);

  ?>
	
  <td width="60px" rowspan="2"><?php if ($lab>0){
		?>
		<img src="<?=base_url()?>resources/images/iconos/probetagif.gif" />
		<?php
        
		
		}else {
			
			   if($d['estado'] == 'Ocupada')
				{
					$dat = $this->urgencias_model->obtenerAtencionCama($d['id_cama']);
					$n = $this->urgencias_model->obtenerTiempoEstancia($dat['id_atencion'],date("Y-m-d H:i:s"));
					echo "<img src='".base_url()."resources/images/iconos/".$d['icono']."'/>";
					
					/*
					if($n < 24)
					{
						
						echo "<img src='".base_url()."resources/images/iconos/".$d['icono']."'/>";
					}else if($n <= 48)
					{
						echo "<img src='".base_url()."resources/images/iconos/cama_ocupada_amarillo.png' alt='Paciente que supera las 24 horas de estancia' title='Paciente que supera las 24 horas de estancia'/>";
					}else if($n > 48)
					{
						echo "<img src='".base_url()."resources/images/iconos/cama_ocupada_rojo.png' alt='Paciente que supera las 48 horas de estancia' title='Paciente que supera las 48 horas de estancia'/>";
					}
					* 
					* */
				}else{
				echo "<img src='".base_url()."resources/images/iconos/".$d['icono']."'/>";	
				}
			
			?>
     
        
        
        <?php } ?></td>
  </tr><tr><td>
 
   <strong>Cama:&nbsp;<?=$d['numero_cama']?></strong><br />
<?php

	if($d['estado'] == 'Ocupada')
	{
	$dat = $this->urgencias_model->obtenerAtencionCama($d['id_cama']);
	//$lab = $this->ordenes_model->obtenerordenlab($dat['id_paciente']);
	
	
	//print_r($this->db->last_query());
	if($dat != 0)
	{
?>
<? //$dat['id_paciente'] ?>
<a href="<?=site_url()?>/urg/observacion/main/<?=$dat['id_atencion']?>" class="vpaciente">
<?=$dat['primer_apellido']." ".$dat['segundo_apellido']."<br>".$dat['primer_nombre']." ".$dat['segundo_nombre']?>
</a>
<br />
Edad: <?=$this->lib_edad->edad($dat['fecha_nacimiento'])?>
<br>
<?=$dat['razon_social'].br()?>
<strong>Estancia:</strong><?=nbs().$n?>H
<?php
	}else{
			echo '<strong><a href="#" onclick="activarCama('.$d['id_cama'].')">Activar cama</a></strong>';
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
