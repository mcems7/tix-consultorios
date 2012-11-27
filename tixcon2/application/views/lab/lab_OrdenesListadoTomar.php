<?php
$n = count($listado);
if($n>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro"># Orden</td>
<td class="campo_centro">Tipo Documento</td>
<td class="campo_centro">Nombre</td>
<td class="campo_centro">Fecha </td>
<td class="campo_centro">Cantidad </td>
<td class="campo_centro">Procedimiento</td>

<td class="campo_centro">Accion</td>
</tr>
<?php

  $i = 1;
  
  foreach($listado as $dato)
  {
	  $clase = '';
	  if ($dato['id_rechazo']>0){
		  $clase = 'listado_triage_1';		  
		  }
?>

<?php 
if($dato['cantidadCups']>1 && $dato['registro_numero']>0){

	
	if($dato['minutos'] >= $dato['periocidad_min']){
		
		?><tr>
<td align="center" class="<?=$clase?>"><strong><?=$dato['id_ordenes']?></strong></td>
<td align="center"><?=$dato['tipo_documento']." ".$dato['numero_documento']?></td>
<td><?=$dato['primer_nombre']." ".$dato['primer_apellido']." ".$dato['segundo_apellido']?></td>
<td><?=$dato['fecha_realizado']?></td>
<td><?=$dato['registro_numero']."/".$dato['cantidadCups']?></td>
<td><?=$dato['desc_subcategoria']?></td>

<td class="opcion"><?php echo anchor('/lab/lab_lista_enfermeria/MuestraRemitidaLab/'.$dato['id_ordenes'], 'Remitir',array('title'=>'Verificacion','onclick'=>'return confirmarordrem()'));?>
</br><a href="<?=site_url()?>/lab/lab_lista_enfermeria/MuestraEnviadaLab/<?=$dato['id_ordenes']?>", onclick="return confirmarordenv();"><strong>Enviar</strong></a> </td>
	

 </td>
		<?php
		}
	}



if($dato['cantidadCups']<=1 || $dato['registro_numero']==0){
?>
<tr>
<td align="center" class="<?=$clase?>"><strong><?=$dato['id_ordenes']?></strong></td>
<td align="center"><?=$dato['tipo_documento']." ".$dato['numero_documento']?></td>
<td><?=$dato['primer_nombre']." ".$dato['primer_apellido']." ".$dato['segundo_apellido']?></td>
<td><?=$dato['fecha_realizado']?></td>
<td><?=$dato['registro_numero']."/".$dato['cantidadCups']?></td>
<td><?=$dato['desc_subcategoria']?></td>

<td class="opcion"><?php echo anchor('/lab/lab_lista_enfermeria/MuestraRemitidaLab/'.$dato['id_ordenes'], 'Remitir',array('title'=>'Verificacion','onclick'=>'return confirmarordrem()'));?>
</br><a href="<?=site_url()?>/lab/lab_lista_enfermeria/MuestraEnviadaLab/<?=$dato['id_ordenes']?>", onclick="return confirmarordenv();"><strong>Enviar</strong></a> </td>
	

 </td>

<?php
}
$i++;
  }

}else{
?>
<tr><td colspan="4" class="campo_centro">No se encontraron registros</td></tr>
</table>
<?php
}


?>