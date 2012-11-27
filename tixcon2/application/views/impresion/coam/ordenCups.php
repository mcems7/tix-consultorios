<?php $this -> load -> view('impresion/coam/inicio'); ?>
<h4>Orden de ayudas diagnosticas</h4>
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