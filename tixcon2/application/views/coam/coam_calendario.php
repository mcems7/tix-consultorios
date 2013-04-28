<?php

$mact = date('m');
$hoy = date('d'); 

for($i=0;$i<=31;$i++)
{
	$dia =  date('l', mktime(0, 0, 0, $m, $i, $a));
	if($dia != 'Sunday' /*&& $dia != 'Saturday'*/)
	{
		$n = $this->coam_model->verificar_obtener_agenda_dia($i,$m,$a,$id_consultorio);
				$lista[$i] = "";
		if($mact == $m)
		{
			if($i >= $hoy)
			{
				if($n == 0){
	$lista[$i].= "<a href='#'  onClick=\"crear_agenda('$i','$m','$a','$id_consultorio')\">";
	$lista[$i].= '<img  src="'.base_url().'resources/images/clock_add.png" alt="Agregar agenda" title="Agregar agenda"/>';
	$lista[$i].= '</a>';
				}else{
	$lista[$i] = "<a href='#'  onClick=\"crear_agenda('$i','$m','$a','$id_consultorio')\">";
	$lista[$i].= '<img  src="'.base_url().'resources/images/clock_edit.png" alt="Modificar agenda" title="Modificar agenda"/>';
	$lista[$i].= '</a>';			
				}
			}else{
				if($n == 0){
	$lista[$i] .= "";		
				}else{
	$lista[$i] .= "<a href='#'  onClick=\"consultar_agenda('$i','$m','$a','$id_consultorio')\">";
	$lista[$i].= '<img  src="'.base_url().'resources/images/clock_.png" alt="Consultar agenda" title="Consultar agenda"/>';
	$lista[$i].= '</a>';		
				}
			}
		}else if($mact < $m)
		{
			if($n == 0){
	$lista[$i].= "<a href='#'  onClick=\"crear_agenda('$i','$m','$a','$id_consultorio')\">";
	$lista[$i].= '<img  src="'.base_url().'resources/images/clock_add.png" alt="Agregar agenda" title="Agregar agenda"/>';
	$lista[$i].= '</a>';
			}else{
	$lista[$i].= "<a href='#'  onClick=\"crear_agenda('$i','$m','$a','$id_consultorio')\">";
	$lista[$i].= '<img  src="'.base_url().'resources/images/clock_edit.png" alt="Modificar agenda" title="Modificar agenda"/>';
	$lista[$i].= '</a>';			
			}	
		}else{
			if($n == 0){
	$lista[$i].= "";		
			}else{
	$lista[$i].= "<a href='#'  onClick=\"consultar_agenda('$i','$m','$a','$id_consultorio')\">";
	$lista[$i].= '<img  src="'.base_url().'resources/images/clock_.png" alt="Consultar agenda" title="Consultar agenda"/>';
	$lista[$i].= '</a>';		
			}
		}
	}
}
echo $this->calendar->generate($a,$m,$lista);
?>