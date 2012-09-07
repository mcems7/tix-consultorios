<?php $this -> load -> view('impresion/coam/inicio'); ?>
<h4>Orden de ayudas diagnosticas</h4>
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
<h5>Procedimientos y ayudas diagn&oacute;sticas</h5>
<table id="interna">
  <tr>
      <td class="negrita centrado">N0</td>
    <td class="negrita centrado">Procedimiento</td>
    <td class="negrita centrado">Cantidad</td>
    <td class="negrita centrado">Observaciones</td>
  </tr>
<?php
$i=1;
	foreach($ordenCups as $d)
	{
		$d['procedimiento'] = $this->urgencias_model->obtenerNomCubs($d['cups']);
?>
  <tr>
    <td class="centrado"><?=$i?></td>
    <td class="negrita"><?=$d['procedimiento']?></td>
    <td class="centrado"><?=$d['cantidadCups']?></td>
    <td class="centrado"><?=$d['observacionesCups']?></td>
  </tr>
<?php
$i++;
	}
?>
</table>
<?php $this -> load -> view('impresion/coam/fin'); ?>