<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
///////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Consulta atenci&oacute;n</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
</table>
</td>
</tr>

<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr>
<td class="campo">Fecha y hora de ingreso:</td>
<td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
<td class="campo">Servicio:</td>
<td><?=$atencion['nombre_servicio']?>&nbsp;</td>
<td class="campo">Cama</td>
<td><?=$atencion['numero_cama']?></td>
</tr>
<tr>
<td class="campo">Estado:</td>
<td colspan="5"><?=$atencion['estado']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Motivo de consulta:</td>
<td colspan="5"><?=$consulta['motivo_consulta']?>&nbsp;</td>
</tr>
<tr>
<td class="campo">Enfermedad actual:</td>
<td colspan="5"><?=$consulta['enfermedad_actual']?>&nbsp;</td>
</tr>
  <td class="campo">Diagn&oacute;sticos consulta inicial:</td>
  <td colspan="5">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta inicial';

}
?>
  </td></tr>
    <tr>
  <td class="campo">Diagn&oacute;sticos evoluciones:</td>
  <td colspan="5">
  
  <?php
if(count($dxEvo) > 0)
{
	foreach($dxEvo as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a las evoluciones';
}
?>
  </td></tr>
</table>

</td>
</tr>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
<tr>
<?php
if($atencion['consulta'] == 'SI'){
?>
<td class="opcion">
<?=anchor('/hce/hce_hospi/consultaNotaInicial/'.$atencion['id_atencion'],'Nota de ingreso','title="Nota de ingreso"');?>
</td>
<td class="opcion">
<?=anchor('/hce/hce_hospi/consultaEvoluciones/'.$atencion['id_atencion'],'Evoluciones','title="Evoluciones"');?>
</td>
<td class="opcion">
<?=anchor('/hce/hce_hospi/consultarNota/'.$atencion['id_atencion'],'Notas de enfermer&iacute;a','title="Notas de enfermer&iacute;a"');?>
</td>
<td class="opcion">
<?=anchor('/hce/hce_hospi/consultarSv/'.$atencion['id_atencion'],'Signos Vitales enfermer&iacute;a','title="Signos Vitales enfermer&iacute;a"');?>
</td>
<td class="opcion">
<?=anchor('/hce/hce_hospi/consultaBl/'.$atencion['id_atencion'],'Balance De L&iacute;quidos','title="Balance De L&iacute;quidos"');?>
</td>
<td class="opcion">
<?=anchor('/hce/hce_hospi/consultarOrdenes/'.$atencion['id_atencion'],'Ordenes m&eacute;dicas','title="Ordenes m&eacute;dicas"');?>
</td>
<?php
if($atencion['activo']=='NO'){
?>
<td class="opcion">
<?=anchor('/hce/hce_hospi/consultaEpicrisis/'.$atencion['id_atencion'],'Epicrisis','title="Epicrisis"');?>
</td>
<?php
}
?>
<?php
}
if($rem != 0)
{
	
?>
<td class="opcion">
<a href="<?=site_url()?>/hce/main/consultaRemision/<?=$atencion['id_atencion']?>">Remision</a>
</td>
<?php
}
?>

<td class="opcion">
<?=anchor('/hospi/hospi_admision/editarAdmision/'.$atencion['id_atencion'],'Epicrisis','title="Epicrisis"');?>
</td>
<?php
//Horas de espera para permitir apertura atención
$horas_espera = 18;
$segundos_espera = $horas_espera * 3600;

$fecha_actual_time = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
$fecha = explode(" ", $atencion['fecha_egreso']);
list($anno, $mes, $dia) = explode( '-', $fecha[0] );
list($hora, $min, $seg)= explode( ':', $fecha[1] );
$fecha_egreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
$segundos = $fecha_actual_time - $fecha_egreso_time;
if($atencion['activo'] == 'NO')
{
	//Si no se ha superado el tiempo de espera permite abrir atencion
	if($segundos_espera >= $segundos){
?>
  <td class="opcion">
  <a href="<?=site_url()?>/urg/abrir_atencion/main/<?=$atencion['id_atencion']."/".$atencion['id_entidad']?>">Abrir atenci&oacute;n</a>
  </td>
<?php
	}
}
?>
<tr>
</table>
</td>
</tr>
</table>
</center>