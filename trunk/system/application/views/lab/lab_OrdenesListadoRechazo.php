
<?php
$n = count($lista);
if($n>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro"># Orden</td>
<td class="campo_centro">Tipo Documento</td>
<td class="campo_centro">Nombre</td>
<td class="campo_centro">Fecha </td>
<td class="campo_centro">Motivo Dev</td>

<td class="campo_centro">Accion</td>
</tr>
<?php
  $i = 1;
  
  foreach($lista as $d)
  {
?>
<tr>
<td align="center"><strong><?=$d['id_ordenes']?></strong></td>
<td align="center"><?=$d['tipo_documento']." ".$d['numero_documento']?></td>
<td><?=$d['primer_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?></td>
<td><?=$d['fecha_realizado']?></td>
<td><?=$d['motivo']?></td>



	<td class="opcion"><a href="<?=site_url()?>/lab/lab_lista_enfermeria/rechazoOrden/<?=$d['id_ordenes']?>", onclick="return confirmbaja()"><strong>Dar de baja</strong></a> </td>



 


</td>

<?php
$i++;
  }

}else{
?>
<tr><td colspan="4" class="campo_centro">No se encontraron registros</td></tr>
</table>
<?php
}
?>