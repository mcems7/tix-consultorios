<?php
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
	
	if($puntaje == 20){
		$estilo = "";
		$texto = "NO VALORADO";
		$puntaje = ''; 
	}
		
?>
   <tr>
    <td class="campo">Valoración del riesgo de caídas.<br />Escala de Crichton:</td>
    <td colspan="3" style="<?=$estilo?>"><strong><?=$puntaje?></strong>&nbsp;-&nbsp;<?=$texto?>
    </td>
  </tr>