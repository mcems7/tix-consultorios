<table style="width:100%" class="tabla_interna">
<tr>
<th colspan="3">Pacientes con atenciones</th>
</tr>
<tr>
<td class="campo_centro">Documento de Identidad</td>

<td class="campo_centro">Nombres y apellidos</td>


<td class="campo_centro">Consultar</td>
</tr>
<?php
if($atencionesUrg !=0)
{
	foreach($atencionesUrg as $d)
	{
?>
<tr>
<td><?=$d['tipo_documento']." ".$d['numero_documento']?></td>

<td><?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?></td>

<td class='opcion'>


 <a href="#" onclick="verAtencionesPac('<?=$d['id_paciente']?>')"><strong>Ver Atenciones</strong>
      </a>


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
<div id="listado_atenciones">
</div>