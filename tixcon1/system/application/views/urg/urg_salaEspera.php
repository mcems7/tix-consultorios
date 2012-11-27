<script>setTimeout('document.location.reload()',60000); </script>
<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function alerta(nombre,tiempo) 
{
	var mensaje = 'El paciente '+nombres+' no ha sido atendido despues de '+tiempo;
	alert(mensaje);
	return false;
}

////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
function consultaPaciente(id_atencion)
{
	var campo = 'id_estado'+id_atencion;
	var id_estado = $(campo).value;
	
	if(id_estado == 3){
			alert('El paciente se encuentra actualmente en consulta!!');
			
			if(confirm('¿Desea iniciar la atención del paciente?'))
	{
		document.location = '<?=site_url()?>/urg/atencion_inicial/consultaInicial/'+id_atencion;
		return true;
	}
	else
	{
		return false;
	}	
	}
	
	if(confirm('¿Desea iniciar la atención del paciente?'))
	{
		document.location = '<?=site_url()?>/urg/atencion_inicial/consultaInicial/'+id_atencion;
		return true;
	}
	else
	{
		return false;
	}	
}
////////////////////////////////////////////////////////////////////////////////
</script>
<?php
$fecha_actual = date('Y-m-d H:i:s');
?>
<h1 class="tituloppal">Servicio de urgencias - SALAS DE ESPERA</h1>
<h2 class="subtitulo"><?=$sala?></h2>
<h3 class="subtitulo">Fecha y hora de &uacute;ltima actualizaci&oacute;n:&nbsp;<?=$fecha_actual?></h3>
<center>
<table width="100%" class="tabla_listado" cellpadding="5">
<tr><td class="titulo_tabla_listado" colspan="6">Listado de pacientes activos en el servicio de urgencias</td></tr>
<tr>
<th>No.</th>
<th>Fecha y hora de llegada</th>
<th>Nombre e identificación del paciente</th>
<th>Estado / especialista</th>
<th>Clasificaci&oacute;n TRIAGE</th>
<th>Verificado</th>
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
$res = alerta($d['fecha_ingreso'],$d['clasificacion']);
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
<td> <a href="#" onclick="consultaPaciente('<?=$d['id_atencion']?>')" class="vpaciente"><?=$d['primer_apellido']." ".$d['segundo_apellido']." ".$d['primer_nombre']." ".$d['segundo_nombre']?></a><br /><?=$d['tipo_documento'].": ".$d['numero_documento']?><br />
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
<td align="center"><?php $row = $this->urgencias_model->obtenerConsulta($d['id_atencion']);

  if(isset($row['id_consulta'])) {
      if($row['verificado']=="NO"){?>
      <A HREF="<?php echo site_url('urg/atencion_inicial/editarConsultaInicial/'.$d['id_atencion']);?>"><B>Pendiente Verificar Atencion Inicial</B></A><?php  
      }
      else{
      echo "Atencion Inicial Verificada";
      }
  }
  else 
  {
    echo "No Hay atencion Inicial";
  }
 ?> </td>
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
<tr><td colspan="6" align="center"><?
$data = array(	'name' => 'bv',
				'id' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</center>
