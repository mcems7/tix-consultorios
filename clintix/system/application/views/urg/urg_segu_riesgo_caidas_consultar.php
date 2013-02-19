
<table width="95%" class="tabla_form">
<tr><th colspan="3">Valoración del riesgo de caídas. Escala de Crichton</th></tr>
<tr><td class="campo_centro" width="50%">Valoración del riesgo</td>
<td class="campo_centro" width="25%">Puntuación</td>
<td class="campo_centro" width="25%">Marca</td>
</tr>
<tr><td class="campo">Limitación física:</td><td class="campo_centro">2</td>
<td class="campo_centro">
<?php
if($es['limitacion_fisica'] == 2)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');
?>
</td></tr>
<tr><td class="campo">Estado mental alterado:</td><td class="campo_centro">3</td>
<td class="campo_centro">
<?php
if($es['estado_mental'] == 3)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');	
?></td></tr>
<tr><td class="campo">Tratamiento farmacológico que implica riesgo:</td><td class="campo_centro">2</td>
<td class="campo_centro">
<?php
if($es['tratamiento_farmacologico'] == 2)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');	
?></td></tr>
<tr><td class="campo">Problemas de idioma o socioculturaes:</td><td class="campo_centro">2</td>
<td class="campo_centro">
<?php
if($es['problemas_de_idioma'] == 2)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');	
?></td></tr>
<tr><td class="campo">Incontinencia urinaria:</td><td class="campo_centro">1</td>
<td class="campo_centro">
<?php
if($es['incontinencia_urinaria'] == 1)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');	
?>
</td></tr>
<tr><td class="campo">Déficit sensorial:</td><td class="campo_centro">2</td>
<td class="campo_centro">
<?php
if($es['deficit_sensorial'] == 2)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');	
?>
</td></tr>
<tr><td class="campo">Desarrollo psicomotriz:</td><td class="campo_centro">2</td>
<td class="campo_centro">
<?php
if($es['desarrollo_psicomotriz'] == 2)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');	
?>
</td></tr>
<tr><td class="campo">Pacientes sin factores de riesgo evidentes:</td><td class="campo_centro">1</td>
<td class="campo_centro">
<?php
if($es['pacientes_sin_facores'] ==1)
echo img('resources/images/001_06.png');
else
echo img('resources/images/001_05.png');	
?>
</td></tr>
<tr><td class="campo">Total:</td><td class="campo_centro">15</td>
 <?php
$puntaje = $es['limitacion_fisica']+$es['estado_mental']+$es['tratamiento_farmacologico']+$es['problemas_de_idioma']+$es['incontinencia_urinaria']+$es['deficit_sensorial']+$es['desarrollo_psicomotriz']+$es['pacientes_sin_facores'];
 
	if($puntaje <= 2){
		$estilo = "background-color:#00FF00";
		$texto = "BAJO RIESGO";
	}else if($puntaje > 2 && $puntaje < 8){
		$estilo = "background-color:#FFFF00";
		$texto = "MEDIANO RIESGO";
	}else if($puntaje >= 8){
		$estilo = "background-color:#FF0000";
		$texto = "ALTO RIESGO";
	}
?>
<td style="<?=$estilo?>"><strong><?=$puntaje?></strong>&nbsp;-&nbsp;<?=$texto?>
</td>
<tr><td align="center" colspan="3"><?
$data = array(	'name' => 'bv',
				'onclick' => 'resetDiv()',
				'value' => 'Cerrar',
				'type' =>'button');
echo form_input($data).nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('impresion/impresion/consultaEvolucion/'.$es['id'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?></td></tr>                               
</table>