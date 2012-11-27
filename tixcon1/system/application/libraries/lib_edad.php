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
}

?>
