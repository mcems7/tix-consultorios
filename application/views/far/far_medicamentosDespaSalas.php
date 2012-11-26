<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
  document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio Farmaceutico - Ordenes despachadas</h1>
<table width="100%" class="tabla_form">
<tr><th>
Listado de las ultimas 50 ordenes despachadas
</th></tr>
<tr><td style="padding:0px">

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
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Ingreso Dinamica</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
  $i = 1;
  
  foreach($lista as $d)
  {
	  
	$d['ordenMedi'] = $this -> urgencias_model -> obtenerMediOrdenInsu($d['id_orden']);
   if(count($d['ordenMedi']) != 0){
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_verificado']?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['nombre_servicio']?></td>
<td><?=$d['ingreso']?></td>
<td class="opcion"><a href="<?=site_url()?>/far/main/consultaOrdenDespachoCon/<?=$d['id_orden']?>"><strong>Consultar</strong></a></td>

<?php
$i++;
	}
  }

}else{
?>
<tr><td colspan="4" class="campo_centro">No se encontraron registros</td></tr>
</table>
<?php
}

?>


</td></tr>
<tr><td align="center">
<?
$data = array(  'name' => 'bv',
        'onclick' => 'regresar()',
        'value' => 'Volver',
        'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?=form_close();?>
