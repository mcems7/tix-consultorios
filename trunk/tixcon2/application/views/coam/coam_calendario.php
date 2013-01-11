<?php
$m = date('m');
$a = date('Y');
for($i=0;$i<=31;$i++){
	$dia =  date('l', mktime(0, 0, 0, $m, $i, $a));
	if($dia != 'Sunday'/* && $dia != 'Saturday' */){
		$n = $this->coam_model->verificar_obtener_agenda_dia($i,$m,$a,$id_consultorio);
		if(date('d') <= $i){
		
			if($n == 0){
			$lista[$i] = "<br /><input type='button' name='ca' id='ca' value='Crear agenda' onClick=\"crear_agenda('$i','$m','$a','$id_consultorio')\" />";
			}else{
			$lista[$i] = "<br /><input type='button' name='ca' id='ca' value='Modificar agenda' onClick=\"crear_agenda('$i','$m','$a','$id_consultorio')\" />";
			}
		}else{
			if($n == 0){
			$lista[$i] = "<br /><center><strong>No hay agenda registrada</strong></center>";
			}else{
			$lista[$i] = "<br /><input type='button' name='ca' id='ca' value='Consultar agenda' onClick=\"consultar_agenda('$i','$m','$a','$id_consultorio')\" />";
			}
		}
	}
}
echo $this->calendar->generate(date('Y'),date('m'),$lista);
?>