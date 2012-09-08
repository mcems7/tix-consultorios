<?php $this -> load -> view('impresion/coam/inicio'); ?>
<h4>Orden de medicamentos</h4>
<table id="interna">
<tr>
	<td class="negrita">Paciente:</td>
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
  <tr>
    <td class="negrita">Fecha:</td>
    <td><?=$orden['fecha_creacion']?></td>
    <td class="negrita">M&eacute;dico tratante:</td>
    <td><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td>
  </tr>
</table>
<h5>Medicamentos</h5>
<table id="interna">
  <tr>
  <td class="negrita centrado">No.</td>
    <td class="negrita centrado">Medicamento</td>
    <td class="negrita centrado">Dosis</td>
    <td class="negrita centrado">Unidad</td>
    <td class="negrita centrado">Frecuencia</td>
    <td class="negrita centrado">V&iacute;a</td>
    <td class="negrita centrado">Observaciones:</td>
  </tr>
<?php
$i=1;
	foreach($ordenMedi as $d)
	{
		$d['via'] = $this->urgencias_model->obtenerValorVarMedi($d['id_via']);
		$d['uni_frecuencia'] = $this->urgencias_model->obtenerValorVarMedi($d['id_frecuencia']);
		$d['unidad'] = $this->urgencias_model->obtenerValorVarMedi($d['id_unidad']);
		$d['medicamento'] = $this->urgencias_model->obtenerNomMedicamento($d['atc']);
?>

  <tr>
   <td class="centrado"><?=$i?></td>
    <td class="negrita"><?=$d['medicamento']?></td>
    <td class="centrado"><?=$d['dosis']?></td>
    <td class="centrado"><?=$d['unidad']?></td>
    <td class="centrado"><?="Cada ".$d['frecuencia']." ".$d['uni_frecuencia']?></td>
    <td class="centrado"><?=$d['via']?></td>
     <td class="centrado"><?=$d['observacionesMed']?></td>
  </tr>
<?php

$i++;
	}
?>
</table>
<?php $this -> load -> view('impresion/coam/fin'); ?>