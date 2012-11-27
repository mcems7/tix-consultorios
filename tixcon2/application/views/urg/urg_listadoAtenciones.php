<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function nuevaAtencion()
{
	var numero = '<?=$numero_documento?>';
	var var_url = '<?=site_url()?>/urg/triage/inicioTriage/'+numero+'/0';
	document.location = var_url;
}

function reingreso(id_atencion)
{
	var numero = '<?=$numero_documento?>';
	var var_url = '<?=site_url()?>/urg/triage/inicioTriage/'+numero+'/1/'+id_atencion;
	document.location = var_url;
}
</script>
<div id="tabla_atenciones">
<?php
$fecha_actual_time = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
$cont = 0;
$bandera = 0;
if($verAten != 0)
{
?>
<h1 class="tituloppal">Servicio de urgencias - TRIAGE</h1>
<h2 class="subtitulo">Verificar atenciones anteriores</h2>
<center>
<table width="95%" class="tabla_form">
<tr><th>Atenciones anteriores Urgencias</th></tr>
<tr><td>

<table style="width:100%" class="tabla_interna">
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Numero documento</td>
<td class="campo_centro">Nombres y apellidos</td>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	
	foreach($verAten as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$numero_documento?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td><?=$d['estado']?></td>
<?php
	$fecha = explode(" ", $d['fecha_egreso']);
	list($anno, $mes, $dia) = explode( '-', $fecha[0] );
	list($hora, $min, $seg)= explode( ':', $fecha[1] );
	$fecha_envio_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
	
	$segundos = $fecha_actual_time - $fecha_envio_time;
	if($segundos <= 259200)
	{
		$cont++;
		$bandera = 1;
?>

<td class='opcion'>
<a href="#" onclick="reingreso('<?=$d['id_atencion']?>')"><strong>Reingreso</strong></a>
</td>
<?php
	}else if($d['fecha_egreso'] == '0000-00-00 00:00:00'){
		$cont++;
		$bandera = 0;
?>
<td class="opcion">
<strong>Atención sin concluir</strong>
</td>		
<?php		
	}else{
?>		
<td class="opcion">
<strong>Egreso mayor a 72 horas</strong>
</td>		
<?php
	}
$i++;
	}
	if($bandera == 1){
?>
<tr><td colspan="7" class="opcion"><a href="#" onclick="nuevaAtencion()"><strong>Continuar con nueva atención</strong></a></td></tr>
<?php
}
?>
</table>

</td></tr>
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
<?php
}
?>
</div>
<?php
if($cont==0){
?>
<script language="javascript">
nuevaAtencion();
</script>
<?php
}
?>


<div id="pagina_triage">
</div>
