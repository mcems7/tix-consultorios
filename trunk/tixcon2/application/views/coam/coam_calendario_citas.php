<?php
$m = $mes;
$a = $anno;
for($i=0;$i<=31;$i++){
$dis = $this->coam_model->obtenerAgendasFecha($i,$mes,$anno);
$lista[$i] = "<ul>";
	if($dis != 0)
	{
		foreach($dis as $d){
			$lista[$i] .= "<li>".anchor('coam/coam_agenda_citas/citas_dia_medico/'.$d['id'],$d['medico'])."</a></li>";
		}
	}
	$lista[$i] .= "</ul>";
}
echo $this->calendar->generate($anno,$mes,$lista);
?>