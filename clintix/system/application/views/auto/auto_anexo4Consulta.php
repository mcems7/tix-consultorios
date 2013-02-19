<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Central de autorizaciones - Anexo técnico No. 4</h1>
<h2 class="subtitulo">Autorización de servicios de salud</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Información general</th></tr>
<tr><td colspan="2">

<table width="100%" class="tabla_interna">
<tr>
  <td class="campo">Número autorización:</td>
<td><?=$anexo['numero_informe']
?></td>
<td class="campo">Fecha:</td><td>
<?=$anexo['fecha_anexo']?>
</td>
<td class="campo">Hora:</td><td>
<?=$anexo['hora_anexo']?>
</td>
<td class="campo">Estado autorización:</td><td>
<?=$anexo['estado_anexo']?>
</td>
</tr>
</table>
</td></tr>
<tr>
  <th colspan="2">Entidad responsable de pago</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Nombre pagador:</td><td><?=$entidad['razon_social']?></td><td class="campo">Código:</td><td><?=$entidad['codigo_eapb']?></td></tr>
</table>
</td></tr>
<tr>
  <th colspan="2">Datos del paciente</th></tr>
<tr><td>
<table width="100%" class="tabla_interna">
<tr>
<td align="center"><?=$tercero['primer_apellido']?></td>
<td align="center"><?=$tercero['segundo_apellido']?></td>
<td align="center"><?=$tercero['primer_nombre']?></td>
<td align="center"><?=$tercero['segundo_nombre']?></td></tr>
<td class="campo_centro">Primer apellido</td><td class="campo_centro">Segundo apellido</td>
<td class="campo_centro">Primer nombre</td><td class="campo_centro">Segundo nombre</td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr><td class="campo">Tipo identificación:</td>
<td><?=$tercero['tipo_documento']?></td>
<td class="campo">Número documento:</td>
<td><?=$tercero['numero_documento']?></td></tr><tr>
<td class="campo">Fecha de nacimiento:</td>
<td colspan="3"><?=$tercero['fecha_nacimiento']?></td></tr>
<tr><td class="campo">Direcci&oacute;n de residencia habitual:</td>
<td colspan="3"><?=$tercero['direccion']?></td></tr>
<tr><td class="campo">Teléfono:</td>
<td colspan="3"><?=$tercero['telefono']?></td></tr>
<tr><td class="campo">Departamento:</td>
<td><?=$tercero['depa']?></td>
<td class="campo">Municipio:</td>
<td><?=$tercero['nombre']?></td></tr>
</table>
<table width="100%" class="tabla_interna">
<tr><td class="campo">Cobertura en salud:</td><td><?=$paciente['cobertura']?></td></tr>
</table>



</td></tr>
<tr>
<th colspan="2">Servicios autorizados</th></tr>
<tr>
  <td colspan="2">
  <?php
	foreach($anexoCups as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
		echo $this->load->view('auto/auto_anexo4CupsConsulta',$d);
	}
?>
  </td></tr>
<tr><th colspan="2">Pagos compartidos</th></tr>
<tr>
<td colspan="2">
<table width="100%" class="tabla_interna">
  <tr>
    <td colspan="2"><strong>Porcentaje del valor de los servicios de esta autorización a pagar por la entidad responsable de pago:</strong>&nbsp;<?=$anexo['porcentaje_pagar']?>%</td>
  </tr>
    <tr>
    <td colspan="2"><strong>Semanas de afiliación del paciente a la solicitud de la autorización:</strong>&nbsp;
	<?=$anexo['semanas_afiliacion']?></td>
  </tr>
  <tr>
    <td class="campo" width="50%">Reclamo de tiquete, bono o vale de pago:</td>
    <td width="50%"><?=$anexo['bono_pago']?></td>
  </tr>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
 <tr><td class="campo_centro" colspan="4">Recaudo del prestador</td></tr>
  <tr>
    <td class="campo_centro" width="25%">Concepto</td>
    <td class="campo_centro" width="25%">Valor en pesos</td>
    <td class="campo_centro" width="25%">Porcentaje</td>
    <td class="campo_centro" width="25%">Valor máximo en pesos</td>
  </tr>
  <tr>
    <td>Cuota moderadora:&nbsp;<strong><?=$anexo['cuota_moderadora']?></strong></td>
   <td><?=$anexo['valor_moderadora']?></td>
    <td><?=$anexo['porcentaje_moderadora']?>%</td>
    <td><?=$anexo['tope_moderadora']?></td>
  </tr>
  <tr>
     <td>Copago:&nbsp;<strong><?=$anexo['copago']?></strong></td>
    <td><?=$anexo['valor_copago']?></td>
    <td><?=$anexo['porcentaje_copago']?>%</td>
    <td><?=$anexo['tope_copago']?></td>
  </tr>
  <tr>
   <td>Cuota de recuperación:&nbsp;<strong><?=$anexo['cuota_recuperacion']?></strong></td>
    <td><?=$anexo['valor_recuperacion']?></td>
    <td><?=$anexo['porcentaje_recuperacion']?>%</td>
    <td><?=$anexo['tope_recuperacion']?></td>
  </tr>
  <tr>
     <td>Otro:&nbsp;<strong><?=$anexo['otro']?></strong></td>
    <td><?=$anexo['valor_otro']?></td>
    <td><?=$anexo['porcentaje_otro']?>%</td>
    <td><?=$anexo['tope_otro']?></td>
  </tr>
</table>


</td>
</tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>                             
</table>

