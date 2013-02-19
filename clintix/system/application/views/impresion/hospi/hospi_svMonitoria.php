<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de hospitalización - Monitoria enfermeria</h4>
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

  
<center>

<table width="100%" border="0" cellspacing="2" cellpadding="2" id="interna">
<tr> 
    <td class="negrita" colspan="21" align="center">Fecha: <?=$fecha_turno?></td>    
</tr>
<tr> 
    <td class="negrita">H</td>
    <td class="negrita">T°</td>
    <td class="negrita">FC</td>
     <td class="negrita">PAS</td>
    <td class="negrita">PAD</td>
     <td class="negrita">PAM</td>
    <td class="negrita">FR</td>
     <td class="negrita">SO2 </td>
    <td class="negrita">FiO2</td>
    <td class="negrita">PH</td>
    <td class="negrita">PaCO2</td>
    <td class="negrita">PaO2</td>
    <td class="negrita">HCO3</td>
    <td class="negrita">SaO2</td>
    <td class="negrita">SvO2</td>
    <td class="negrita">Lactato</td>
    <td class="negrita">Gluco</td>
    <td class="negrita">Insul</td>
     <td class="negrita">via</td>
    
  </tr>
<?php

	foreach($listado as $d)
	{
?>
 <tr>
<td class="negrita"><?=$d['hora']; 
if($d['minuto']!=""){
	echo ':'.$d['minuto'];
	}?></td>
<td><?=$d['temperatura'];?></td>
<td><?=$d['pulso'];?></td>
<td><?=$d['ten_arterial_s'];?></td>
<td><?=$d['ten_arterial_d'];?></td>
<td><?=number_format((($d['ten_arterial_d']*2)+$d['ten_arterial_s'])/3,1);?></td>
<td><?=$d['frecuencia_respiratoria'];?></td>
<td><?=$d['spo2'];?></td>
<td><?=$d['fraccion_inspirada_oxigeno'];?></td>
<td><?=$d['ph'];?></td>
<td><?=$d['paco2'];?></td>
<td><?=$d['pao2'];?></td>
<td><?=$d['hco3'];?></td>
<td><?=$d['sao2'];?></td>
<td><?=$d['svo2'];?></td>
<td><?=$d['lactato'];?></td>
<td><?=$d['glucometria'];?></td>
<td><?=$d['insulina'];?></td>
<td><?=$d['via_administracion'];?></td>

 </tr>

<?php
	}
		echo "</table>";
			echo "</td></tr>";
	
?>


<?php $this -> load -> view('impresion/fin'); ?>