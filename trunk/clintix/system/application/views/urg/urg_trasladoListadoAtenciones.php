<table style="width:100%" class="tabla_interna">
<tr>
<th colspan="7">Listado atenciones</th>
</tr>
<tr>
<td colspan="7" class="campo_centro">
Operación a realizar:
<input type="radio" name="operacion" value="Trasladar" checked="checked"/>
Traslado de historia&nbsp;
<input type="radio" name="operacion" value="Unificar"/>
Unificación historia</td>
</tr>
<tr>
<td class="campo_centro">Atención a ser movida</td>
<td class="campo_centro">Fecha y hora ingreso</td>
<td class="campo_centro">Fecha y hora egreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Consultar</td>
</tr>
<?php
if($atencionesUrg !=0)
{
	foreach($atencionesUrg as $d)
	{
?>
<tr>
<td class="campo_centro"><input type="radio" name="atencion" value="<?=$d['id_atencion']?>"/></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['fecha_egreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td><?=$d['estado']?></td>
<td class='opcion'>
<?php
if($d['clasificacion'] != '4'){
?>

 <a href="<?=site_url('hce/main/consultarAtencion/'.$d['id_atencion'])?>" target="_blank"><strong>Consultar</strong>
      </a>
<?php
}else{
?>
<a href="<?=site_url('hce/main/consultaTriageBlanco/'.$d['id_atencion'])?>" target="_blank"><strong>Consulta TRIAGE</strong>
      </a>	
<?php
}
?>
</td>
</tr>
	
<?php
	}
?>
<tr>
<td colspan="7" class="campo_centro">
<?php
$data = array(	'name' => 'trasladar',
				'id' => 'trasladar',
				'onclick' => "trasladarAtencion()",
				'value' => 'Trasladar atención seleccionada',
				'type' =>'button');
echo form_input($data);

?>
</td></tr>
<?php
}else{
?>
<tr>
<td colspan="5">No hay atenciones
</td>
</tr>
<?php
}
?>
</table>


