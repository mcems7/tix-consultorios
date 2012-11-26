<table style="width:100%" class="tabla_interna">
<?php
$n = count($lista);
if($n>0)
{
?>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora envio</td>
<td class="campo_centro">Número de solicitud</td>
<td class="campo_centro">Nombres y apellidos paciente</td>
<td class="campo_centro">Entidad responsable de pago</td>
<td class="campo_centro">Estado del envio</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
	$i = 1;
	
	foreach($lista as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_anexo']?><br /><?=$d['hora_anexo']?></td>
<td align="center"><?=$d['numero_informe']?></td>
<td><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?><br />
<?=$d['tipo_documento']." ".$d['numero_documento']?></td>
<td style=""><?=$d['razon_social']?></td>
<?php
	$bandera = false;
	if($d['enviado'] == 'NO')
	{
		$estilo ='style="background-color:#F00;font-weight:bold;color:#FFF;"';
		$bandera = false;
	}else
	{
		$estilo ='style="font-weight:bold;"';
		$bandera = true;
	}
?>
<td align="center" <?=$estilo?>><?=$d['enviado']?></td>
<td class="opcion">
<strong>
<?php
if($bandera){
echo anchor('/auto/anexo2/consultarAnexo2/'.$d['id_anexo2'],'Consultar',array('target' => 'Blanck_')).br();
echo anchor('/auto/anexo2/editar/'.$d['id_anexo2'], 'Verificar',array('title'=>'Verificacion','onclick'=>'con'));
}else{
echo anchor('/auto/anexo2/consultarAnexo2/'.$d['id_anexo2'],'Consultar',array('target' => 'Blanck_')).br();	
echo anchor('/auto/anexo2/reenviarAnexo2/'.$d['id_anexo2'],'Enviar');	
}
?>
</strong>
</td>

<?php
$i++;
	}

}else{
?>
<tr><td class="campo_centro">No se encontraron registros</td></tr>
<?php
}
?>
</table>
