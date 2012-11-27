<script language="JavaScript">
function Abrir_ventana (pagina) {
var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=600, top=10, left=140";
window.open(pagina,"Mi_ventana",opciones);
}
</script>
<?php
if(isset($boton) && is_bool($boton) === true)
{
?>
<h1 class="tituloppal">Consulta de historias cl&iacute;nicas</h1>
<?php
}
if(!is_null($listaUrg))
{
?>
<table style="width:100%" class="tabla_form">
<tr><th colspan="5">Datos del Paciente</th></tr>
<tr>
	<td class="campo_centro">Nombre del paciente:</td>
  <td colspan="2"><?=$listaUrg[0]['primer_nombre'].' '.$listaUrg[0]['segundo_nombre'].' '.$listaUrg[0]['primer_apellido'].' '.$listaUrg[0]['segundo_apellido']?></td>
  <td class="campo_centro">Identificación:</td>
  <td><?=$listaUrg[0]['tipo_documento'].' '.$listaUrg[0]['numero_documento']?></td>
</tr>
</table>
<br />
<table style="width:100%" class="tabla_form">
<tr><th colspan="5" class="campo_centro">Atenciones vigentes Urgencias</th></tr>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha de ingreso</td>
<td class="campo_centro">Fecha de egreso</td>
<td class="campo_centro">Servicio</td>
<td class="campo_centro">Operaci&oacute;n</td>
</tr>
<?php
	$i = 1;
	foreach($listaUrg as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_ingreso']?></td>
<td><?=$d['fecha_egreso']?></td>
<td><?=$d['nombre_servicio']?></td>
<td class="opcion"><a href="javascript:Abrir_ventana('<?=site_url('impresion/impresion/atencionUrg/'.$d['id_atencion'])?>')"><strong>Imprimir</strong></a></td>
</tr>
<?php
$i++;
	}
?>
</table>
<?php
}
else{
?>
<table>
<tr>
<td colspan="5" class="campo_centro">No se encontraron registros de atenciones en urgencias</td>
</tr>
</table>
<?php
}
?>
<br />
<center>
<?php
if(isset($boton) && is_bool($boton) === true)
{
	$data1 = array('name' 	 => 'bv',
								 'onclick' => 'javascript:history.back()',
								 'value' 	 => 'Volver',
								 'type' 	 => 'button');
	echo form_input($data1);
}
?>
</center>