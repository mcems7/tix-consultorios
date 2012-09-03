<?php

	$ca1 = 'width="30%"';
	$ca2 = 'width="70%"';
	
	$alertas='"style="color:#000"';
	$alertad='"style="color:#000"';	
	$alertat='"style="color:#000"';
	$alertaspo='"style="color:#000"';
	$alertapulso='"style="color:#000"';	
	
	if($nota[0]['ten_arterial_s'] > 90)
	{
	   $alertas='style="color:#FF0000"';	
	}
	if($nota[0]['ten_arterial_d'] < 40)
	{
	   $alertad='style="color:#FF0000"';	
	}
	if($nota[0]['temperatura'] < 36 || $nota[0]['temperatura'] > 38)
	{
	   $alertat='style="color:#FF0000"';	
	}
	
	if($nota[0]['spo2'] < 90)
	{
	   $alertaspo='style="color:#FF0000"';	
	}
	if($nota[0]['pulso'] > 100)
	{
	   $alertapulso='style="color:#FF0000"';	
	}
	
?>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo_centro" colspan="2">Detalles</td></tr>
<tr><td class="campo" <?=$ca1?> >Fecha y hora:</td><td <?=$ca2?>><?=$nota[0]['fecha_nota']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Realiza la nota:</td><td <?=$ca2?>><?=$nota[0]['primer_apellido']." ".$nota[0]['segundo_apellido']." ".$nota[0]['primer_nombre']." ".$nota[0]['segundo_nombre']?></td></tr>
 <tr>
    
  <td class="campo" <?=$ca1?>>Tensión arterial sistólica:</td>
  <td <?=$ca2?><?=$alertas?>><?=$nota[0]['ten_arterial_s']?></td>
  
</tr>
<tr>
  <td class="campo" <?=$ca1?>>Tensión arterial diastólica:</td><td <?=$ca2?><?=$alertad?>><?=$nota[0]['ten_arterial_d']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Pulso:</td><td <?=$ca2?><?=$alertapulso?>><?=$nota[0]['pulso']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Temperatura:</td><td <?=$ca2?><?=$alertat?>><?=$nota[0]['temperatura']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Frecuencia respiratoria:</td><td <?=$ca2?>><?=$nota[0]['frecuencia_respiratoria']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Peso:</td><td <?=$ca2?>><?=$nota[0]['peso']?></td></tr>
<tr><td class="campo" <?=$ca1?>>Spo2:</td><td <?=$ca2?><?=$alertaspo?>><?=$nota[0]['spo2']?></td></tr>
<tr><td align="center" colspan="2"><?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data);
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresion/SvEnfermeria/'.$nota[0]['id_atencion'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?></td></tr>
<tr><td class="linea_azul" colspan="2"></td></tr>

</table>

</center>
