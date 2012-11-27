<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 

class Lib_ope{

    function imc($talla,$peso)
    {
		$cadena = '';
		if($talla > 0 && $peso > 0)
		{
		
		$talla = $talla / 100;
		
		$imc = $peso / ($talla * $talla);
		if($imc < 16){
			$res = "Delgadez severa";
		}else if($imc >= 16 && $imc <= 16.99){
			$res = "Delgadez moderada";
		}else if($imc >= 17 && $imc <= 18.49){
			$res = "Delgadez no muy pronunciada";
		}else if($imc >= 18.5 && $imc <= 24.99){
			$res = "Normal";
		}else if($imc >= 25 && $imc <= 29.99){
			$res = "Preobeso";
		}else if($imc >= 30 && $imc <= 34.99){
			$res = "Obeso tipo I";
		}else if($imc >= 35 && $imc <= 39.99){
			$res = "Obeso tipo II";
		}else if($imc >= 40){
			$res = "Obeso tipo III";
		}
		
			$cadena = "<strong>IMC</strong>:".nbs().number_format($imc,2).nbs()." - <strong>".$res."</strong>";
		}
		
			return $cadena ;
    }
}

?>
