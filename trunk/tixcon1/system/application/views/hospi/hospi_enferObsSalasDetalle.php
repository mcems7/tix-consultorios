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
<tr><td colspan="6" class="campo_centro">No hay pacientes pendientes de asignación de cama</td></tr>
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
  <td width="60px" rowspan="2"><img  src="<?=base_url()?>resources/images/iconos/<?=$d['icono']?>"/></td>
  </tr><tr><td>
 
   <strong>Cama:&nbsp;<?=$d['numero_cama']?></strong><br />
<?php

	if($d['estado'] == 'Ocupada')
	{
	$dat = $this->urgencias_model->obtenerAtencionCama($d['id_cama']);
	if(count($dat) != 0)
	{
?>
<a href="<?=site_url()?>/urg/enfermeria_obs/main/<?=$dat['id_atencion']?>" class="vpaciente">
<?=$dat['primer_apellido']." ".$dat['segundo_apellido']."<br>".$dat['primer_nombre']." ".$dat['segundo_nombre']?>
</a>
<br />
Edad: <?=$this->lib_edad->edad($dat['fecha_nacimiento'])?>
<br>
<?=$dat['razon_social']?>
<?php
	}else{
			echo "No hay paciente asignado";
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
