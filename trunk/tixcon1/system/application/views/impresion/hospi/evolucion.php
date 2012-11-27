<?php $this -> load -> view('impresion/hospi/hospi_inicio'); ?>
<h4>Servicio de hospitalización - Nota de evoluci&oacute;n</h4>
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
    <td class="negrita">Fecha y hora:</td>
    <td class="centrado"><?=$evo['fecha_evolucion']?></td>
    <td class="negrita">M&eacute;dico:</td>
    <td class="centrado"><?=$evo['primer_nombre'].' '.$evo['segundo_nombre'].' '.$evo['primer_apellido'].' '.$evo['segundo_apellido']?></td>
  </tr>
  <tr>
    <td class="negrita">Especialidad:</td>
    <td class="centrado"><?=$evo['esp']?></td>
    <td class="negrita">Tipo evolución:</td>
    <td class="centrado"><?=$evo['tipo_evolucion']?></td>
  </tr>
<tr><td class="texto" colspan="4"><strong>Subjetivo:</strong>
<?=nbs().$evo['subjetivo']?></td></tr>
<tr><td class="texto" colspan="4"><strong>Objetivo:</strong>
<?=nbs().$evo['objetivo']?></td></tr>
<tr><td class="texto" colspan="4"><strong>Análisis:</strong>
<?=nbs().$evo['analisis']?></td></tr>
<tr><td class="texto" colspan="4"><strong>Conducta:</strong>
<?=nbs().$evo['conducta']?></td></tr>
</table>

<h5>DIAGN&Oacute;STICOS</h5>
<table id="interna">
<?php
  $i = 1;
  if(count($dxEvo) > 0)
  {
    foreach($dxEvo as $d)
    {
?>
      <tr>
        <td class="negrita" style="width:130px">Diagn&oacute;stico <?=$i?>:</td>
        <td><strong><?=$d['id_diag'].' '?></strong><?=$d['diagnostico']?></td>
      </tr>
<?php
      $i++;
    }
  }
  else
  {
?>
    <tr>
      <td colspan="2">No hay diagn&oacute;sticos asociados a la evoluci&oacute;n</td>
    </tr>
<?php
  }
?>
</table>
<?php $this -> load -> view('impresion/hospi/hospi_fin'); ?>