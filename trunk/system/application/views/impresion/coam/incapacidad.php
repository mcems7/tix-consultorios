<?php $this -> load -> view('impresion/hospi/hospi_inicio'); ?>
<h4>Consulta ambulatoria - Incapacidad</h4>
<h5>Datos del paciente</h5>
<table id="interna">
  <tr>
    <td class="negrita">Apellidos:</td>
    <td class="centrado"><?=$tercero['primer_apellido'].' '.$tercero['segundo_apellido']?></td>
    <td class="negrita">Nombres:</td>
    <td class="centrado"><?=$tercero['primer_nombre'].' '.$tercero['segundo_nombre']?></td>
  </tr>
  <tr>
    <td class="negrita">Documento de identidad:</td>
    <td class="centrado"><?=$tercero['tipo_documento'].' '.$tercero['numero_documento']?></td>
    <td class="negrita">G&eacute;nero:</td>
    <td class="centrado"><?=$paciente['genero']?></td>
  </tr>
  <tr>
    <td class="negrita">Fecha de nacimiento:</td>
    <td class="centrado"><?=$tercero['fecha_nacimiento']?></td>
    <td class="negrita">Edad:</td>
    <td class="centrado"><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td>
  </tr>
</table>
<h5>Datos incapacidad</h5>
<table id="interna">
<tr>
<td class="negrita">Médico que incapacita:</td>
    <td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?>&nbsp;</td>
    </tr>
<tr>
<td class="negrita">Fdecha y hora incapacidad:</td>
<td><?=$inca['fecha_incapacidad']?></td>
</tr>
<tr>
<td class="negrita">Fdecha de inicio incapacidad:</td>
<td><?=$inca['fecha_inicio']?></td>
</tr>
<tr>
<td class="negrita">Duración incapacidad:</td>
<td><?=$inca['duracion'].nbs()?>(Días)
</td>
</tr>
<tr>
  <td class="negrita">Diagn&oacute;sticos:</td>
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
<tr>
<td class="negrita">Observaci&oacute;n:</td>
<td><?=$inca['observacion']?></td>
</tr>
</table>
<?php $this -> load -> view('impresion/hospi/hospi_fin'); ?>