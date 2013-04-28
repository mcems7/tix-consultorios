<?php
$llena = array('src' => 'resources/images/group_delete.png','alt' => 'Agenda llena','title' => 'Agenda llena');
$vacia = array('src' => 'resources/images/group.png','alt' => 'Agenda vacia','title' => 'Agenda vacia');
$dispo = array('src' => 'resources/images/group_add.png','alt' => 'Cupos disponibles','title' => 'Cupos disponibles');
?>
<table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-weight:bold">
  <tr>
    <td><?=img($llena)?>&nbsp;Agenda llena</td>
    <td><?=img($vacia)?>&nbsp;Agenda vacia</td>
    <td><?=img($dispo)?>&nbsp;Agenda con cupos disponibles</td>
  </tr>
</table>

<?php
$mact = date('m');
$hoy = date('d');
$m = $mes;
$a = $anno;
for($i=0;$i<=31;$i++)
{
	$dis = $this->coam_model->obtenerAgendasFecha($i,$mes,$anno);
	
	$lista[$i] = "";
		if($dis != 0)
		{
			foreach($dis as $d){
			$num_citas_asignadas = $this->coam_model->obtener_estado_agenda($d['id']);
			$inicio = mktime($d['hora_inicio'],$d['min_inicio'],0,$mes,$i,$anno);
			$fin = mktime($d['hora_fin'],$d['min_fin'],0,$mes,$i,$anno);
			$num_citas = ($fin - $inicio)/($d['tiempo_consulta']*60);
$tabla = '<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Medico:</td>
    <td>'.$d['medico'].'</td>
  </tr>
   <tr>
    <td>Especialidad:</td>
    <td>'.$d['descripcion'].'</td>
  </tr>
  <tr>
    <td>Hora inicio:</td>
    <td>'.str_pad($d['hora_inicio'],2,'0',STR_PAD_LEFT).':'.str_pad($d['min_inicio'],2,'0',STR_PAD_LEFT).'</td>
  </tr>
  <tr>
    <td>Hora fin:</td>
    <td>'.str_pad($d['hora_fin'],2,'0',STR_PAD_LEFT).':'.str_pad($d['min_fin'],2,'0',STR_PAD_LEFT).'</td>
  </tr>
  <tr>
    <td>Tiempo consulta:</td>
    <td>'.$d['tiempo_consulta'].nbs().'Minutos</td>
  </tr>
    <tr>
    <td>Número citas disponibles:</td>
    <td>'.($num_citas-$num_citas_asignadas).'</td>
  </tr>
    <tr>
    <td>Número citas asignadas:</td>
    <td>'.$num_citas_asignadas.'</td>
  </tr>
      <tr>
    <td>Total citas agenda:</td>
    <td>'.$num_citas.'</td>
  </tr>
</table>';
$clase = "";
if($num_citas == $num_citas_asignadas){
	$clase = 'class="agenda_llena"';
$imgprop = array('src' => 'resources/images/group_delete.png','alt' => 'Agenda llena','title' => 'Agenda llena');
}else if($num_citas_asignadas == 0){
$imgprop = array('src' => 'resources/images/group.png','alt' => 'Agenda vacia','title' => 'Agenda vacia');	
}else if($num_citas_asignadas < $num_citas){
$imgprop = array('src' => 'resources/images/group_add.png','alt' => 'Cupos disponibles','title' => 'Cupos disponibles');		
}


$lista[$i] .= br().anchor('coam/coam_agenda_citas/citas_dia_medico/'.$d['id'],"<div ".$clase.">".img($imgprop).nbs().$d['medico']."</div><span>$tabla</span>", 'class="Ntooltip"')."<br /></div>";
			}
		}
		$lista[$i] .= "";
}
echo $this->calendar->generate($a,$m,$lista);
?>