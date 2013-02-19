<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de hospitalización - Notas de enfermeria</h4>
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
<?=br()?>
<table id="interna">
  <tr>
    <td class="negrita">Fecha y hora:</td>
    <td class="centrado"><?=$evo[0]['fecha_nota']?></td>
    <td class="negrita">M&eacute;dico:</td>
    <td class="centrado"><?=$evo[0]['primer_nombre'].' '.$evo[0]['segundo_nombre'].' '.$evo[0]['primer_apellido'].' '.$evo[0]['segundo_apellido']?></td>
  </tr>
  <tr>
    <td class="negrita">Especialidad:</td>
    <td class="centrado" colspan="3"><?=$evo[0]['esp']?></td>
    
    
  </tr>
  
<tr><td class="texto" colspan="4"><strong>Subjetivo:</strong>
<?=nbs().$evo[0]['subjetivo']?></td></tr>
<tr><td class="texto" colspan="4"><strong>Objetivo:</strong>
<?=nbs().$evo[0]['objetivo']?></td></tr>
<tr><td class="texto" colspan="4"><strong>Actividades:</strong>
<?=nbs().$evo[0]['actividades']?></td></tr>
<tr><td class="texto" colspan="4"><strong>Pendientes:</strong>
<?=nbs().$evo[0]['pendientes']?></td></tr>
</table>



<?php $this -> load -> view('impresion/fin'); ?>