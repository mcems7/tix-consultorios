<?php $this -> load -> view('impresion/coam/inicio'); ?>
<h4>Historia cl&iacute;nica</h4>
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
<?=br()?>
<table id="interna">
    <tr>
    <td class="negrita">Fecha y hora de inicio consulta:</td>
    <td class="centrado"><?=$consulta['fecha_ini_consulta']?></td>
    <td class="negrita">Fecha y hora de finalización consulta:</td>
    <td class="centrado"><?=$consulta['fecha_fin_consulta']?></td>
  </tr><tr>
    <td colspan='4'><strong>M&eacute;dico tratante:</strong><?=nbs().$medico['primer_nombre'].' '.$medico['segundo_nombre'].' '.$medico['primer_apellido'].' '.$medico['segundo_apellido'].nbs().'<strong>Codigo:</strong>'.nbs().$medico['tarjeta_profesional']?></td>
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
<h5>ANTECEDENTES</h5>
<table id="interna">
<tr><td class="texto"><strong>Antecedentes patol&oacute;gicos:</strong>
<?=nbs().$consulta_ant['ant_patologicos']?></td></tr>
<tr><td class="texto"><strong>Antecedentes farmacol&oacute;gicos:</strong>
<?=nbs().$consulta_ant['ant_famacologicos']?></td></tr>
<tr><td class="texto"><strong>Antecedentes tóxico al&eacute;rgicos:</strong>
<?=nbs().$consulta_ant['ant_toxicoalergicos']?></td></tr>
<tr><td class="texto"><strong>Antecedentes quir&uacute;rgicos:</strong>
<?=nbs().$consulta_ant['ant_quirurgicos']?></td></tr>
<tr><td class="texto"><strong>Antecedentes familiares:</strong>
<?=nbs().$consulta_ant['ant_familiares']?></td></tr>
<tr><td class="texto"><strong>Antecedentes ginecol&oacute;gicos:</strong>
<?=nbs().$consulta_ant['ant_ginecologicos']?></td></tr>
<tr><td class="texto"><strong>Antecedentes otros:</strong>
<?=nbs().$consulta_ant['ant_otros']?></td></tr>
</table>
<h5>EXÁMEN FÍSICO</h5>
<table id="interna">
<tr><td class="texto" colspan="6"><strong>Condiciones generales:</strong>
<?=$consulta['condiciones_generales']?></td></tr>
<tr><td class="negrita">Peso:</td>
<td><?=$consulta['peso']?></td>
<td class="negrita">Talla:</td>
<td><?=$consulta['talla']?></td>
<?php
if(strlen($consulta['peso']) > 0 && strlen($consulta['talla']) > 0){
	echo "<td>",$this->lib_ope->imc($consulta['talla'],$consulta['peso']),"</td>";
}
?>
</tr>
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
  <td>
  
  <?php
switch ($d['orden_dx']) {
    case 0:
        $orden_dx = "Diagnóstico principal";
        break;
    case 1:
        $orden_dx = "Diagnóstico relacionado 1";
        break;
    case 2:
        $orden_dx = "Diagnóstico relacionado 2";
        break;
    case 3:
        $orden_dx = "Diagnóstico relacionado 3";
        break;
      case 4:
        $orden_dx = "Diagnóstico relacionado 4";
        break;
        case 5:
        $orden_dx = "Diagnóstico relacionado 5";
        break;
        case 6:
        $orden_dx = "Diagnóstico relacionado 6";
        break;
}
$tipodx = '';
switch ($d['tipo_dx']) {
    case 1:
        $tipodx = "Impresión diagnóstica";
        break;
    case 2:
        $tipodx = "Confirmado nuevo";
        break;
    case 3:
        $tipodx = "Confirmado repetido";
        break;
}

echo '<strong>',$orden_dx,'</strong>',br(),$tipodx;
?></td>
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
<?=br()?>
<table id="interna">
<tr><td class="texto"><strong>Causa externa:</strong><?=nbs().$atencion['causa_externa'];?></td></tr>
<tr><td class="texto"><strong>An&aacute;lisis:</strong>
<?=nbs().$consulta['analisis']?></td></tr>
<tr><td class="texto"><strong>Conducta:</strong>
<?=$consulta['conducta']?></td></tr>
</table>
<?php $this -> load -> view('impresion/coam/fin'); ?>