<h4>Servicio de Consulta Externa - Órdenes Médicas</h4>
<table width="100%">
<tr><td>
<table width="100%" border="1" id="interna">
<tr><td class="negrita">EPS:</td>
<td><?=$tercero['eps']?></td><td Colspan="2"><strong>FECHA: </strong> <?=date("d-m-Y");?></td></tr>
<tr><td class="negrita">NOMBRE DEL USUARIO:</td>
<td colspan="3"><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']." ".$tercero['primer_apellido']." ".$tercero['segundo_apellido']  ?></td> </tr>

<tr><td class="negrita">DOCUMENTO :</td><td><?=$tercero['tipo_documento']?> <?=$tercero['numero_documento']?></td> <td class="negrita">EDAD:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>

<tr><td class="negrita">DIRECCION: </td><td><?=$datos_paciente['direccion']?></td><td class="negrita">TELEFONO:</td><td><?=$datos_paciente['telefono']?></td> </tr>

<?php 
$contador =1;
foreach($diagnosticos as $d)
	{
	
?>

<tr><td class="negrita">DIAGNOSTICO <?=$contador?> :</td><td colspan="3"><?=$d['id_diagnostico']?></td></tr>

<?php
$contador = $contador +1;
	}
?>
<tr>
<td colspan="4">
<strong>RESUMEN HISTORIA CLINICA: </strong> <?=$medicamentonopos[0]['resumen_historia']?>
</td>
</tr>
</table>
<table width="100%" border="1" id="interna">
<tr><th colspan="2">MEDICAMENTO NO POS SOLICITADO</th></tr>
<?php 
$d['pos'] = $this->urgencias_model->obtenerMedicamentoPos($medicamentonopos[0]['atcNoPos']);
?>
<tr><td class="negrita"  width="40%">Principio activo:</td>
<td  width="60%"><?=$d['pos']['principio_activo']?></td></tr>
<tr><td class="negrita">Grupo terapéutico:</td>
<td><?=$d['pos']['grupos']?></td></tr>
<tr><td class="negrita">Forma farmacéutica y concentración:</td>
<td><?=$d['pos']['descripcion']?></td></tr>
<tr><td class="negrita">Dias Tratamiento:</td>
<td><?=$medicamentonopos[0]['dias_tratamiento']?></td></tr>
<tr><td class="negrita">Dosis Diaria:</td>
<td><?=$medicamentonopos[0]['dosis_diaria']?></td></tr>
<tr><td class="negrita">Cantidad total por mes:</td>
<td><?=$medicamentonopos[0]['cantidad_mes']?></td></tr>
<tr><td class="negrita">REGISTRO INVIMA:</td>
<td></td></tr>
<tr><td colspan="2"><strong>VENTAJAS DEL MEDICAMENTO SOLICITADO SOBRE LOS OTROS DE LA MISMA CATEGORÍA FARMACOLÓGICA:</strong> <?=$medicamentonopos[0]['ventajas']?></td></tr>



</table>

<table width="100%" border="1" id="interna">
<tr><th colspan="3">MEDICAMENTO (S) POS QUE SE REEMPLAZA (N) O SUSTITUYE (N)</th></tr>
<?php 
$d['pos'] = $this->urgencias_model->obtenerMedicamentoPos($medicamentosustituto[0]['atc_pos']);
?>
<tr><td colspan="3"><strong>Principio activo: </strong> <?=$d['pos']['principio_activo']?></td></tr>
<tr><td colspan="3"> <strong>Grupo terapéutico:</strong> <?=$d['pos']['grupos']?></td></tr>
<tr><td colspan="3"><strong>Forma farmacéutica y concentración: </strong> <?=$d['pos']['descripcion']?></td></tr>
<tr><td> <strong>Dias Tratamiento:</strong> <?=$medicamentosustituto[0]['dias_tratamientoPos']?></td>
<td ><strong>Dosis Diaria:</strong><?=$medicamentosustituto[0]['dosis_diariaPos']?></td>
<td ><strong>Cantidad total por mes: </strong> <?=$medicamentosustituto[0]['cantidad_mesPos']?></td></tr>
<tr><td colspan="3"><strong>RESPUESTA CLÍNICA OBSERVADA:</strong> <?=$medicamentosustituto[0]['resp_clinica']?>  <?=$medicamentosustituto[0]['resp_clinica_cual']?> </td></tr>
<tr><td  colspan="3"><strong>CONTRAINDICACION: </strong><?=$medicamentosustituto[0]['contraindicacion']?>  <?=$medicamentosustituto[0]['contraindicacion_cual']?> </td></tr>


</table>
<table width="100%" border="1" id="interna">
<tr><th colspan="2">CRITERIOS QUE JUSTIFICAN LA PRESENTE SOLICITUD:</th></tr>

<tr>
  <td class="campo"><strong>Justificación del riesgo inminente para la vida y la salud del usuario si no es administrado el medicamento NO POS: </strong><?=$medicamentonopos[0]['justificacion']?></td>
</tr>



</table>