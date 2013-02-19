<?php
	if($lista == 0)
	{
		echo "<center><strong>No hay ordenes médicas pendientes</strong></center>";	
	}else{
?>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
    <td class="campo_centro">Fecha y hora orden</td>
    <td class="campo_centro">Medico</td>
    <td class="campo_centro">Paciente</td>
     <td class="campo_centro">Cama</td>
    <td class="campo_centro">Operación</td>
  </tr>
<?php
	foreach($lista as $d)
	{
		
?>
  <tr>
<td><?=$d['fecha_creacion'];?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['pa_pac']." ".$d['sa_pac']." ".$d['pn_pac']." ".$d['sn_pac']?></td>
<td><?=$d['numero_cama']?></td>
<td class="opcion"><a href="<?=site_url('urg/insumos/crearOrdenIns/'.$d['id_orden'])?>"><strong>Ordenar insumos</strong></a></td>
</tr>
<?php
	
	}
?>
</table>
<?php
	}
?>
