<table width="100%" class="tabla_interna" cellpadding="5">
<tr>
<td class='campo_centro'>No.</td>
<td class='campo_centro'>Fecha y hora de llegada</td>
<td class='campo_centro'>Nombre e identificación del paciente</td>
<td class='campo_centro'>Estado / especialista</td>
<td class='campo_centro'>Clasificaci&oacute;n TRIAGE</td>
<td class='campo_centro'>Opciones</td>
</tr>
<?php
$n = count($lista);
if($n>0)
{
	$i = 1;
	foreach($lista as $d)
	{
?>
<tr class="fila">
<td align="center"><strong><?=$i?></strong></td>

<input type='hidden' name='id_estado<?=$d['id_atencion']?>' id='id_estado<?=$d['id_atencion']?>' value='<?=$d['id_estado']?>' />
<?php 
echo '';
$res = $this->lib_tiempo->alerta($d['fecha_ingreso'],$d['clasificacion']);
if($res['estado'] && $d['estado'] == 'En espera de consulta')
{
?>
<td class="alerta_sala">
<?php
}else{
?>
<td>	
<?php
}
?>
<?=$d['fecha_ingreso']?><br />Tiempo en el servicio:&nbsp;<?=$res['tiempo']?>
</td>
<td> <a href="#" onclick="consultaPaciente('<?=$d['id_atencion']?>')" class="vpaciente"><?=$d['primer_nombre']." ".$d['segundo_nombre']." ".$d['primer_apellido']." ".$d['segundo_apellido']?></a><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?><br />
 Edad:&nbsp;<?=$this->lib_edad->edad($d['fecha_nacimiento'])?></td>
<td align="center">
<?php

if($d['consulta'] == 'SI')
{
	$med = $this->urgencias_model->obtenerMedico($d['id_medico_consulta']);
	echo $d['estado']."<br/>".$med['primer_apellido']." ".$med['segundo_apellido']." ".$med['primer_nombre']." ".$med['segundo_nombre'];
}else{
echo $d['estado'];	
}
?>

</td>
<?php 
$clase = '';
if($d['clasificacion'] == 1 ){
	$clase = 'listado_triage_1';
}else if($d['clasificacion'] == 2){
	$clase = 'listado_triage_2';
}else if($d['clasificacion'] == 3){
	$clase = 'listado_triage_3';
}
?>
<td class="<?=$clase?>"><span class="listado_triage_numero"><?=$d['clasificacion']?></span><br /><?=$d['motivo_consulta']?></td>
<td align="center">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td> <a href="<?=site_url('urg/salida_voluntaria/main/'.$d['id_atencion'])?>">
<img  src="<?=base_url()?>resources/images/against.gif" alt="Retiro voluntario" title="Retiro voluntario" width="20px" height="20px"/>
</a></td>
    <td><?php $row = $this->urgencias_model->obtenerConsulta($d['id_atencion']);

  if(isset($row['id_consulta'])) {
      if($row['verificado']=="NO"){?>
      
       <a href="<?=site_url('urg/atencion_inicial/editarConsultaInicial/'.$d['id_atencion'])?>">
<img  src="<?=base_url()?>resources/images/caution.gif" alt="Pendiente verificar Atención Inicial" width="20" height="20" title="Pendiente verificar atención inicial"/>
</a>
      
      <?php  
      }
      else{
?>
<img  src="<?=base_url()?>resources/images/checkmark.gif" alt="Atención inicial verificada" width="20" height="20" title="Atención inicial Verificada"/>
<?php
      }
  }
  else 
  {
?>
<img  src="<?=base_url()?>resources/images/question-mark.gif" alt="No Hay atención inicial" width="20" height="20" title="No Hay atención inicial"/>
<?php
  }
 ?></td>
    <td>
<?php 
	if(isset($row['id_consulta'])) {
      if($row['verificado']=="SI"){

?>    
     <a href="<?=site_url('urg/gestion_atencion/egreso/'.$d['id_atencion'])?>">
<img  src="<?=base_url()?>resources/images/x.gif" alt="Egreso del servicio" title="Egreso del servicio" width="20px" height="20px"/>
</a>
<?php
	}
	}
?>  
    </td>
  </tr>
</table>
 </td>
</tr>	
<?php
$i++;
	}
}else{
?>
<tr><td colspan="6" align="center">No hay pacientes en la sala de espera</td></tr>
<?php
}
?>
</table>
