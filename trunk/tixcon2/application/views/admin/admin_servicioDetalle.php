<center>
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
	$dat = $this->admin_model->obtenerAtencionCama($d['id_cama']);
	if(count($dat) != 0)
	{
?>
<a href="<?=site_url()?>/admin/main/gestion_atencion/<?=$dat['id_atencion']?>" class="vpaciente">
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
