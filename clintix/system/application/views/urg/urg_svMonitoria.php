<h2 class="subtitulo" style=" margin-left:40%">Monitoria</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">

<tr>
 <td colspan="2">
<table width="100%" border="0" cellspacing="2" cellpadding="2"  class="tabla_interna">
<tr> 
    <td class="campo_sobresale">H</td>
    <td class="campo_sobresale">T°</td>
    <td class="campo_sobresale">FC</td>
    <td class="campo_sobresale">PAS</td>
    <td class="campo_sobresale">PAD</td>
    <td class="campo_sobresale">PAM</td>
    <td class="campo_sobresale">FR</td>
    <td class="campo_sobresale">SO2 </td>
    <td class="campo_sobresale">FiO2</td>
    <td class="campo_sobresale">PH</td>
    <td class="campo_sobresale">PaCO2</td>
    <td class="campo_sobresale">PaO2</td>
    <td class="campo_sobresale">HCO3</td>
    <td class="campo_sobresale">SaO2</td>
    <td class="campo_sobresale">p02/fi02</td>
    <td class="campo_sobresale">BE</td>
    <td class="campo_sobresale">Gluco</td>
    <td class="campo_sobresale">Insul</td>
     <td class="campo_sobresale">via</td>
    
  </tr>
<?php

	foreach($listado as $d)
	{
?>
 <tr>
<td class="campo_sobresale"><?=$d['hora']; 
if($d['minuto']!=""){
	echo ':'.$d['minuto'];
	}?></td>
<td><?=$d['temperatura'];?></td>
<td><?=$d['pulso'];?></td>
<td><?=$d['ten_arterial_s'];?></td>
<td><?=$d['ten_arterial_d'];?></td>
   <?php 
   if ((($d['ten_arterial_d']*2)+$d['ten_arterial_s'])!=0)
   {   
	?>
    <td><?=number_format((($d['ten_arterial_d']*2)+$d['ten_arterial_s'])/3,1);?></td>   <?php
	   }else{
		   ?>
		    <td>0 </td>
            <?php 
           
		   }
	   
?>

<td><?=$d['frecuencia_respiratoria'];?></td>
<td><?=$d['spo2'];?></td>
<td><?=$d['fraccion_inspirada_oxigeno'];?></td>
<td><?=$d['ph'];?></td>
<td><?=$d['paco2'];?></td>
<td><?=$d['pao2'];?></td>
<td><?=$d['hco3'];?></td>
<td><?=$d['sao2'];?></td>
  <?php 
   if ($d['paco2'] != 0 && $d['fraccion_inspirada_oxigeno'] != 0)
   {   
	?>
   <td><?=number_format($d['paco2'] / $d['fraccion_inspirada_oxigeno'],2);?></td>   <?php
	   }else{
		   ?>
		    <td>0 </td>
            <?php 
           
		   }
	   
?>



<td><?=$d['BE'];?></td>


<td><?=$d['glucometria'];?></td>
<td><?=$d['insulina'];?></td>
<td><?=$d['via_administracion'];?></td>

 </tr>

<?php
	}
		echo "</table>";
			echo "</td></tr>";
	
?>

<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<?php

$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresion/consultaMonitoria/'.$id_atencion.'/'.$fecha_turno)."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</td>
</tr>
</table>

