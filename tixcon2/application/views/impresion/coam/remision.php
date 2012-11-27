<?php $this -> load -> view('impresion/coam/inicio'); ?>
<h4>Remisión</h4>
<table id="interna">
<tr>
	<td class="negrita">Nombres y apellidos:</td>
	<td><?=$tercero['primer_nombre'].' '.$tercero['segundo_nombre']." ".$tercero['primer_apellido'].' '.$tercero['segundo_apellido']?></td>
	<td class="negrita">Documento de identidad:</td>
	<td><?=$tercero['tipo_documento'].' '.$tercero['numero_documento']?></td>
</tr>
<tr>
	<td class="negrita">Entidad:</td>
	<td><?=$entidad['razon_social']?></td>
	<td class="negrita">Edad:</td>
	<td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
</tr>
</table>
<h5>Datos de la consulta</h5>
<table id="interna">
<tr>
<td class="negrita">Fecha y hora consulta:</td>
<td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
<td class="negrita">Consultorio:</td>
<td><?=$atencion['consultorio']?>&nbsp;</td>
</tr>
<tr>
<td class="negrita">Motivo de consulta:</td>
<td colspan="3"><?=$consulta['motivo_consulta']?>&nbsp;</td>
</tr>
<tr>
<td class="negrita">Enfermedad actual:</td>
<td colspan="3"><?=$consulta['enfermedad_actual']?>&nbsp;</td>
</tr>
<tr>
<td class="negrita">Análisis:</td>
<td colspan="3"><?=$consulta['analisis']?>&nbsp;</td>
</tr>
<tr>
<td class="negrita">Conducta:</td>
<td colspan="3"><?=$consulta['conducta']?>&nbsp;</td>
</tr>
   <tr>
  <td class="negrita">Diagn&oacute;sticos consulta:</td>
  <td colspan="3">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta';
}
?>
  </td></tr>
</table>
<h5>Datos remisión</h5>
<table id="interna">
<tr>
<td class="negrita">Médico que remite:</td>
    <td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?>&nbsp;</td>
    </tr>
<tr>
<td class="negrita">Motivo remisi&oacute;n:</td>
<td><?=$remision['motivo_remision']?></td>
</tr>
<tr>
<td class="negrita">Especialidad a la que remite:</td>
<td><?=$remision['descripcion']?>
</td>
</tr>
<tr>
<td class="negrita">Observaci&oacute;n:</td>
<td><?=$remision['observacion']?></td>
</tr>
</table>
<?php $this -> load -> view('impresion/coam/fin'); ?>