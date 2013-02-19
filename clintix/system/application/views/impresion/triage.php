<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de Urgencias - Triage del paciente</h4>
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
<h5>Datos de la atenci&oacute;n</h5>
<table id="interna">
    <tr>
    <td class="negrita">Fecha y hora de inicio TRIAGE:</td>
    <td class="centrado"><?=$triage['fecha_ini_triage']?></td>
    <td class="negrita">Fecha y hora de finalización TRIAGE:</td>
    <td class="centrado"><?=$triage['fecha_fin_triage']?></td>
  </tr><tr>
    <td colspan='4'><strong>M&eacute;dico Triage:</strong><?=nbs().$triage['primer_nombre'].' '.$triage['segundo_nombre'].' '.$triage['primer_apellido'].' '.$triage['segundo_apellido']?></td>
  </tr>
</table>
<h5>Datos del triage</h5>
<table id="interna">
<tr>
  <td class="texto" colspan="5">
  <strong>Motivo de la consulta:</strong>
  <?=nbs().$triage['motivo_consulta']?>
</td></tr>
<tr>
  <td colspan="5" class="texto">
  <strong>Antecedentes:</strong><?=nbs().$triage['antecedentes']?></td>
</tr>
<tr>
  <td colspan="5"  class="negrita centrado">Signos vitales</td>
</tr>
<tr>
  <td class="negrita centrado">Frecuencia cardiaca:</td>
  <td class="negrita centrado">Frecuencia respiratoria:</td>
  <td class="negrita centrado">Tensión arterial:</td>
  <td class="negrita centrado">Temperatura:</td>
  <td class="negrita centrado">Pulsioximetría (SPO2):</td>
</tr>
<tr>
  <td class="centrado"><?=$triage['frecuencia_cardiaca']?>&nbsp;X min</td>
  <td class="centrado"><?=$triage['frecuencia_respiratoria']?>&nbsp;X min</td>
  <td class="centrado"><?=$triage['ten_arterial_s'].' / '.$triage['ten_arterial_d']?></td>
  <td class="centrado"><?=$triage['temperatura']?> &deg;C</td>
  <td class="centrado"><?=$triage['spo2']?> %</td>
</tr>
<tr>
  <td rowspan="2" class="negrita centrado">Escala Glasgow:</td>
  <td class="negrita centrado">Respuesta ocular:</td>
  <td class="negrita centrado">Respuesta verbal:</td>
  <td class="negrita centrado">Respuesta motora:</td>
  <td class="negrita centrado">Glasgow:</td>
</tr>
<tr>
  <td class="centrado"><?=$triage['resp_ocular']?></td>
  <td class="centrado"><?=$triage['resp_verbal']?></td>
  <td class="centrado"><?=$triage['resp_motora']?></td>
  <td class="centrado"><?=$triage['resp_ocular']+$triage['resp_verbal']+$triage['resp_motora']?>/15</td>
</tr>
<tr>
  <td class="negrita centrado">Sala de espera:</td><td class="centrado" colspan="2"><?=$atencion['nombre_servicio']?></td>
<td class="negrita centrado">Clasificación:</td>

  
  <td class="centrado">
    <?php 
      switch ($triage['clasificacion']){
        case '1':
          echo $triage['clasificacion'].' - Rojo';
          break;
        case '2':
          echo $triage['clasificacion'].' - Amarillo';
          break;
        case '3':
          echo $triage['clasificacion'].' - Verde';
          break;
        default:
          echo 'No registra clasificaci&oacute;n';
      }
    ?>
  </td>
</tr>
</table>

<?php $this -> load -> view('impresion/fin'); ?>
