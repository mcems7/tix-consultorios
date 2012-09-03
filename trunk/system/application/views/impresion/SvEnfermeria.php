<?php $this -> load -> view('impresion/inicio'); ?>

<h4>Servicio de Urgencias - Signos Vitales</h4>
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
   <tr>
    <td class="negrita" colspan="4" align="center">Detalles</td>
    
    </tr>
</table>


<table border="1" id="interna"  width="100%" cellpadding="3" cellspacing="3">
	<tr>
		<td><span class="campo" style="font-weight:bold">Fecha y hora:</span></td>
		<td><span class="campo" style="font-weight:bold">Tensión arterial sistolica:</span></td>
		<td><span class="campo" style="font-weight:bold">Tensión arterial diastolica:</span></td>
		<td><span class="campo" style="font-weight:bold">Pulso</span></td>
		<td><span class="campo" style="font-weight:bold">Temperatura</span></td>
		<td><span class="campo" style="font-weight:bold">Frecuencia respiratoria</span></td>
		<td><span class="campo" style="font-weight:bold">Spo2</span></td>
		<td><span class="campo" style="font-weight:bold">Peso</span></td>
	</tr>
    
    <?php 
	foreach ($evo as $item)
	
	{
	?>	
		
	
	<tr>
		<td><?=$item['fecha_nota']?></td>
		<td><?=$item['ten_arterial_s']?></td>
		<td><?=$item['ten_arterial_d']?></td>
		<td><?=$item['pulso']?></td>
		<td><?=$item['temperatura']?></td>
		<td><?=$item['frecuencia_respiratoria']?></td>
		<td><?=$item['spo2']?></td>
		<td><?=$item['peso']?></td>
	</tr>
    
    <?php
	}
	?>
    </table>


<?php $this -> load -> view('impresion/fin'); ?>