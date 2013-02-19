<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lib_edad {

    function edad($fecha_nac)
    {
		$dia=date("j"); 
		$mes=date("n"); 
		$anno=date("Y"); 
		
		$dia_nac=substr($fecha_nac, 8, 2); 
		$mes_nac=substr($fecha_nac, 5, 2); 
		$anno_nac=substr($fecha_nac, 0, 4); 
		
		if($mes_nac>$mes){ 
			$calc_edad= $anno-$anno_nac - 1;
			$calc_edad_mes = 12 - ($mes_nac - $mes); 
		}else{ 
			if($mes == $mes_nac AND $dia_nac > $dia){ 
				$calc_edad= $anno-$anno_nac-1;
				$calc_edad_mes = $mes_nac - $mes;  
			}else{ 
				$calc_edad= $anno-$anno_nac;
				$calc_edad_mes = $mes - $mes_nac; 
				if($calc_edad == 0)
				{
					$calc_edad = $mes - $mes_nac;
					$calc_edad = $calc_edad." Meses";
					return $calc_edad;
				}
			} 
		} 
		$calc_edad = $calc_edad." Años y ".$calc_edad_mes." meses";
		return $calc_edad; 
    }
    
    function annos($fecha_nac)
    {
		$dia=date("j"); 
		$mes=date("n"); 
		$anno=date("Y"); 
		
		$dia_nac=substr($fecha_nac, 8, 2); 
		$mes_nac=substr($fecha_nac, 5, 2); 
		$anno_nac=substr($fecha_nac, 0, 4); 
		
		if($mes_nac>$mes){ 
			$calc_edad= $anno-$anno_nac - 1;
			$calc_edad_mes = 12 - ($mes_nac - $mes); 
		}else{ 
			if($mes == $mes_nac AND $dia_nac > $dia){ 
				$calc_edad= $anno-$anno_nac-1;
				$calc_edad_mes = $mes_nac - $mes;  
			}else{ 
				$calc_edad= $anno-$anno_nac;
				$calc_edad_mes = $mes - $mes_nac; 
				
			} 
		} 
		return $calc_edad; 
    }
    
   function dias($fecha_inicial, $fecha_final)
   {
       $dia=substr($fecha_inicial, 8, 2); 
       $mes=substr($fecha_inicial, 5, 2); 
       $anno=substr($fecha_inicial, 0, 4); 
       $fecha1=mktime(0,0,0,$mes,$dia,$anno); 
       $dia=substr($fecha_final, 8, 2); 
       $mes=substr($fecha_final, 5, 2); 
       $anno=substr($fecha_final,0, 4); 
       $fecha2=mktime(0,0,0,$mes,$dia,$anno); 
       $dias_diferencia = floor(($fecha2-$fecha1)/(60*60*24)); 
       return $dias_diferencia;
   }
}

?>
