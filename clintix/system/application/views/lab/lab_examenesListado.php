<?php
$n = count($lista);
if($n>0)
{
?>
<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora solicitud</td>
<td class="campo_centro">Paciente</td>
<td class="campo_centro">Ingreso Dinamica</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
  $i = 1;
  
  foreach($lista as $d)
  {
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_verificado']?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['ingreso']?></td>
<td class="opcion"><a href="<?=site_url()?>/lab/main/consultarOrden/<?=$d['id_orden']?>"><strong>Consultar</strong></a></td>

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