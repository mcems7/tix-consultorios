<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}

</script>

<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Historia del paciente</h2>
<table width="100%" class="tabla_form">
<tr><td colspan='2'>



<table style="width:100%" class="tabla_interna">
<tr>
<th colspan="7">Atenciones Urgencias</th>
</tr>

<tr>
<td class="campo_centro">Documento de Identidad</td>

<td class="campo_centro">Nombres y apellidos</td>
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
<td><?=$d['tipo_documento']."".$d['numero_documento']?></td>
<td><?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['fecha_egreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td><?=$d['estado']?></td>
<td class='opcion'>
<?php
if($d['clasificacion'] != '4'){
?>

 <a href="<?=site_url('hce/main/consultarAtencion/'.$d['id_atencion'])?>"><strong>Consultar</strong>
      </a>
<?php
}else{
?>
<a href="<?=site_url('hce/main/consultaTriageBlanco/'.$d['id_atencion'])?>"><strong>Consulta TRIAGE</strong>
      </a>	
<?php
}
?>
</td>
</tr>		
<?php
	}
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
<tr><td colspan="1" align="center">
<?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
echo nbs();

?>

</td></tr>


</td></tr>


</table>



