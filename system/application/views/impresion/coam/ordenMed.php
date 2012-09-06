<?php $this -> load -> view('impresion/coam/inicio'); ?>
<h4>Orden de medicamentos</h4>
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
<?=br()?>
<table id="interna">
  <tr>
    <td class="negrita">Fecha y hora de la orden:</td>
    <td class="centrado"><?=$orden['fecha_creacion']?></td>
    <td class="negrita">M&eacute;dico tratante:</td>
    <td class="centrado"><?=$medico['primer_apellido']." ".$medico['segundo_apellido']." ".$medico['primer_nombre']." ".$medico['segundo_nombre']?></td>
  </tr>
  <tr>
    <td class="negrita">Tipo m&eacute;dico:</td>
    <td class="centrado"><?=$medico['tipo_medico']?></td>
    <td class="negrita">Especialidad:</td>
    <td class="centrado"><?=$medico['especialidad']?></td>
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
<?=br(4)?>
<div id="firma">
<?=$medico['primer_nombre']." ".$medico['segundo_nombre']." ".$medico['primer_apellido']." ".$medico['segundo_apellido']?><br />
R.M:<?=nbs().$medico['tarjeta_profesional']?>
</div>
<?php $this -> load -> view('impresion/hospi/hospi_fin'); ?>