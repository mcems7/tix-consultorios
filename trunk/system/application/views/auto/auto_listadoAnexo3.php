<?php
function minutos_envio($fecha_ultimo_envio){	
	$fecha_actual_time = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
	$fecha = explode(" ", $fecha_ultimo_envio);
	list($anno, $mes, $dia) = explode( '-', $fecha[0] );
	list($hora, $min, $seg)= explode( ':', $fecha[1] );
	$fecha_envio_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
	
	return $segundos = $fecha_actual_time - $fecha_envio_time;
	
}
?>
<table style="width:100%" class="tabla_interna">
<tr><td colspan="7" class="campo_centro">Listado de Anexo Técnico 3</td></tr>
<?php
$n = count($lista);
if($n>0)
{
?>
<tr>
<td class="campo_centro">Fecha y hora envio</td>
<td class="campo_centro">Nombres y apellidos paciente</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Procedimientos o servicios solicitados</td>
<td class="campo_centro">Entidad responsable de pago</td>
<td class="campo_centro">Estado del envio</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
	
	foreach($lista as $d)
	{
		
?>
<tr>
<td><?=$d['fecha_anexo']?><br /><?=$d['hora_anexo']?></td>
<td><?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?><br />
<?=$d['tipo_documento']." ".$d['numero_documento']?></td>
<td><?=$d['nombre_servicio']?></td>
<td>
<?php
$cups =$this->autorizaciones_model->obtenerCupsAnexo3($d['id_anexo3']);
if($cups != 0)
{
	foreach($cups as $data)
	{
		$procedimiento = $this->urgencias_model->obtenerNomCubs($data['cups']); 
		echo '<li>',$procedimiento,"</li>";
	}
}
?>
</td>
<td style=""><?=$d['razon_social']?></td>
<?php
	$segundos = minutos_envio($d['fecha_ultimo_envio']);
	$estilo = '';
	if(	
		$d['numero_envio'] >= 3 &&
		$d['id_estado_anexo'] == 2 && 
		$segundos >= 2700 &&
		$d['anexo4'] == 'NO')
	{
		$estilo ='style="background-color:#F00;font-weight:bold;color:#FFF;"';
	}else if($d['numero_envio'] > 0 && 
	$d['numero_envio'] < 3 && 
	$d['id_estado_anexo'] == 2 && 
	$segundos >= 2700)
	{
		$estilo ='style="background-color:#FF0;font-weight:bold;"';
	}
?>
<td align="center" <?=$estilo?>><?php 

echo $d['estado_anexo']?></td>
<td class="opcion">
<a href="<?=site_url()?>/auto/anexo3/gestionAnexo3/<?=$d['id_anexo3']?>"><strong>Administrar</strong></a>
</td>

<?php
	}

}else{
?>
<tr><td class="campo_centro">No se encontraron registros</td></tr>
<?php
}
?>
</table>
