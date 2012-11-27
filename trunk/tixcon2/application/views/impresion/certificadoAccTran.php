<?php $this -> load -> view('impresion/inicio'); ?>

<h4>CERTIFICADO DE ATENCIÓN MÉDICA PARA VÍCTIMA DE ACCIDENTES DE TRÁNSITO</h4>
<p style="text-align:justify; font-size:12px">EL SUSCRITO MÉDICO DEL SERVICIO DE URGENCIAS DEL HOSPITAL DEPARTAMENTAL UNIVERSITARIO DEL QUINDÍO SAN JUAN DE DIOS CERTIFICA QUE ATENDIÓ EN EL SERVICIO DE URGENCIAS AL PACIENTE:</p>
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
    <td class="negrita">Fecha y hora de inicio consulta:</td>
    <td class="centrado"><?=$consulta['fecha_ini_consulta']?></td>
    <td class="negrita">Fecha y hora de finalización consulta:</td>
    <td class="centrado"><?=$consulta['fecha_fin_consulta']?></td>
  </tr>
</table>
<?=br()?>
<table id="interna">
  <tr>
    <td class="texto"><strong>Motivo de la consulta:</strong>
	<?=nbs().$consulta['motivo_consulta']?></td></tr>
    <tr><td class="texto"><strong>Enfermedad actual:</strong>
    <?=nbs().$consulta['enfermedad_actual']?></td></tr>
    <tr><td class="texto"><strong>Revisi&oacute;n sistemas:</strong>
	<?=nbs().$consulta['revicion_sistemas']?></td>
  </tr>
</table>
<h5>EXÁMEN FÍSICO</h5>
<table id="interna">
<tr><td class="texto" colspan="6"><strong>Condiciones generales:</strong>
<?=$consulta['condiciones_generales']?></td></tr>
<tr>
  <td colspan="6" class="negrita centrado">Signos vitales</td>
</tr>
<tr>
  <td class="negrita centrado">Frecuencia cardiaca:</td>
  <td class="negrita centrado">Frecuencia respiratoria:</td>
  <td class="negrita centrado">Tensi&oacute;n arterial:</td>
  <td class="negrita centrado">Temperatura:</td>
  <td colspan="2" class="negrita centrado">Pulsioximetr&iacute;a (SPO2):</td>
</tr>
<tr>
  <td class="centrado"><?=$consulta['frecuencia_cardiaca']?> X min</td>
  <td class="centrado"><?=$consulta['frecuencia_respiratoria']?> X min</td>
  <td class="centrado"><?=$consulta['ten_arterial_s'].' / '.$consulta['ten_arterial_d']?></td>
  <td class="centrado"><?=$consulta['temperatura']?> &deg;C</td>
  <td colspan="2" class="centrado"><?=$consulta['spo2']?> %</td>
</tr>
<tr>
  <td class="texto" colspan="6"><strong>Ex&aacute;men cabeza:</strong><?=nbs().$consulta_exa['exa_cabeza']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men ojos:</strong>
<?=nbs().$consulta_exa['exa_ojos']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men oral:</strong>
<?=nbs().$consulta_exa['exa_oral']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men cuello:</strong>
<?=nbs().$consulta_exa['exa_cuello']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men dorso:</strong>
<?=nbs().$consulta_exa['exa_dorso']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men torax:</strong>
<?=nbs().$consulta_exa['exa_torax']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men abdomen:</strong>
<?=nbs().$consulta_exa['exa_abdomen']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men genitourinario:</strong>
<?=nbs().$consulta_exa['exa_genito_urinario']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men extremidades:</strong>
<?=nbs().$consulta_exa['exa_extremidades']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men neurol&oacute;gico:</strong>
<?=nbs().$consulta_exa['exa_neurologico']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men piel:</strong>
<?=nbs().$consulta_exa['exa_piel']?></td></tr>
<tr><td class="texto" colspan="6"><strong>Ex&aacute;men mental:</strong>
<?=nbs().$consulta_exa['exa_mental']?></td></tr>
</table>
<h5>IMPRESI&Oacute;N DIAGN&Oacute;STICA</h5>
<table id="interna">
<?php
  $i = 1;
  if(count($dx) > 0)
    {
      foreach($dx as $d)
      {
?>
<tr>
  <td class="negrita" width="30%">Diagn&oacute;stico <?=$i?>:<?=nbs().'<strong>'.$d['id_diag'].'</strong> '.$d['diagnostico']?></td>
</tr>
<?php
      }
    }
  else
    {
?>
<tr>
  <td>No hay diagnosticos asociados a la consulta inicial</td>
</tr>
<?php
    }
?>
</table>
<?=br(3)?>
<table>
 <tr>
    <td colspan='4'><strong>M&eacute;dico tratante:</strong><?=nbs().$medico['primer_nombre'].' '.$medico['segundo_nombre'].' '.$medico['primer_apellido'].' '.$medico['segundo_apellido'].br().'<strong>Registro medico:</strong>'.nbs().$medico['tarjeta_profesional']?></td>
  </tr>
</table>

<?php $this -> load -> view('impresion/fin'); ?>