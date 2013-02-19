<br />

<center>
<table width="98%" class="tabla_form">
<tr><th>INFORMACIÓN IMPORTANTE - NOVEDADES</th></tr>
<tr>
<td>
<?php
	foreach($nove as $d){
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_cama">
<tr><td>
<?php
$horas_espera = 170;
$segundos_espera = $horas_espera * 3600;

$fecha_actual_time = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
$fecha = explode(" ", $d['fecha_publicacion']);
list($anno, $mes, $dia) = explode( '-', $fecha[0] );
list($hora, $min, $seg)= explode( ':', $fecha[1] );
$fecha_egreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
$segundos = $fecha_actual_time - $fecha_egreso_time;
if($segundos_espera >= $segundos){
?>
<img src="<?=base_url()?>/resources/img/nuevo.gif" width="40" height="40" alt="Nuevo" />
<?php
}
?>
<strong>&nbsp;<?=$d['fecha_publicacion']?></strong>&nbsp;</td></tr>
<tr><td><strong><?=mb_strtoupper($d['titulo'],'utf-8')?></strong></td></tr>
<tr><td><?=$d['texto']?></td></tr>
</table>
<?php
	}
?>
</td>
</table>
</center>