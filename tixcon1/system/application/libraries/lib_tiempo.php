<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lib_tiempo {

    function segundos($segundos)
	{ 
		$minutos=$segundos/60; 
		$horas=floor($minutos/60); 
		$minutos2=$minutos%60; 
		$segundos_2=$segundos%60%60%60; 
		if($minutos2<10)$minutos2='0'.$minutos2; 
		if($segundos_2<10)$segundos_2='0'.$segundos_2; 
		
		if($segundos<60){ /* segundos */ 
		$resultado= round($segundos).' Segundos'; 
		}elseif($segundos>60 && $segundos<3600){/* minutos */ 
		$resultado= $minutos2.':'.$segundos_2.' Minutos'; 
		}else{/* horas */ 
		$resultado= $horas.':'.$minutos2.':'.$segundos_2.' Horas'; 
		} 
		return $resultado; 
	}  
function alerta($fecha_inicio,$clasi)
{
	$fecha_actual_time = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
	
	$fecha = explode(" ", $fecha_inicio);
	list($anno, $mes, $dia) = explode( '-', $fecha[0] );
	list($hora, $min, $seg)= explode( ':', $fecha[1] );
	$fecha_lleada_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
	
	$total_segundos = ($fecha_actual_time - $fecha_lleada_time);
	$dat = array();
	
	$dat['estado'] = false;
	$dat['tiempo'] = $this->segundos($total_segundos);
		
	if($clasi == 1 && $total_segundos >60)
	{
		$dat['estado'] = true;
		
	}else if($clasi == 2 && $total_segundos >1800)
	{	
		$dat['estado'] = true;
		
	}else if($clasi == 3 && $total_segundos >3600)
	{
		$dat['estado'] = true;
		
	}
	return $dat;
	}
}
?>
