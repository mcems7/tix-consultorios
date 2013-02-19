<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
///////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Consulta atenci&oacute;n <?=$atencion['nombre_servicio']?></h2>
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
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
<td class="campo">Ingreso administrativo:</td>
<td><?php
echo $atencion['admision'];
if($atencion['admision'] == 'SI')
{
	echo ' - <strong>',$atencion['ingreso'], '</strong>';
}
?></td></tr>
</table>
</td>
</tr>
<?php
	if($atencion['consulta'] != 'NO'){
?>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
  <tr>
    <td class="campo">Fecha y hora de ingreso:</td>
    <td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
    <td class="campo">Servicio:</td>
    <td><?=$atencion['nombre_servicio']?>&nbsp;</td>
  </tr>
  <tr>
    <td class="campo">Motivo de consulta:</td>
    <td colspan="3"><?php
    if($atencion['consulta'] == 'SI')
		echo $consulta['motivo_consulta'];
	else
		echo "SIN CONSULTA";?>&nbsp;</td>
  </tr>
  <tr>
  <td class="campo">Diagn&oacute;sticos consulta inicial:</td>
  <td colspan="3">
  
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
  <td colspan="3">
  
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
<td class="opcion">
	<?=anchor('/hce/main/consultaAtencion/'.$atencion['id_atencion'],'Nota de ingreso');?>
</td>
<td class="opcion">
	<a href="<?=site_url()?>/hce/main/consultaEvoluciones/<?=$atencion['id_atencion']?>">Evoluciones</a>  
</td>
<td class="opcion">
<a href="<?=site_url()?>/hce/main/consultarOrdenes/<?=$atencion['id_atencion']?>">Ordenes procedimientos y formulación</a>
</td>
<?/*
<td class="opcion">
<?=anchor('/hce/main/consultarNota/'.$atencion['id_atencion'],'Notas de enfermer&iacute;a');?>
</td>
<td class="opcion">
<?=anchor('/hce/main/consultarSv/'.$atencion['id_atencion'],'Signos Vitales enfermer&iacute;a');?>
</td>
<td class="opcion">
<?=anchor('/hce/main/consultaBl/'.$atencion['id_atencion'],'Balance De L&iacute;quidos');?>
</td>*/
?>
</tr>
<tr>
<td class="opcion"><a href="<?=site_url()?>/urg/admision/admisionPaciente/<?=$atencion['id_atencion']?>">Modificar admisi&oacute;n</a></td>
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
<?php
}else{
?>
<tr></tr><td class="opcion">EL PACIENTE NO TIENE NOTA DE INGRESO</td></tr>
<?php
}
?>
</table>
</center>
