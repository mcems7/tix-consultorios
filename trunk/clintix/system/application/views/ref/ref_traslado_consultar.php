<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
window.addEvent("domready", function(){
});
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Referencia y contrareferencia</h1>
<h2 class="subtitulo">Consultar tramite de referencia y contrareferencia</h2>
<center>
<table width="100%" class="tabla_form">
<tr><th colspan="2">Datos del paciente</th></tr>
<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
<tr><td class="campo">Apellidos:</td>
<td><?=$tercero['primer_apellido']." ".$tercero['segundo_apellido']?></td><td class="campo">Nombres:</td><td><?=$tercero['primer_nombre']." ".$tercero['segundo_nombre']?></td></tr>
<tr><td class="campo">Documento de identidad:</td><td><?=$tercero['tipo_documento'].": ".$tercero['numero_documento']?></td><td class="campo">Entidad:</td><td>
<?php 
if(isset($entidad['razon_social']))
	echo $entidad['razon_social'];

?>
</td></tr>
<tr><td class="campo">Fecha de nacimiento:</td><td><?=$tercero['fecha_nacimiento']?></td><td class="campo">Edad:</td><td><?=$this->lib_edad->edad($tercero['fecha_nacimiento'])?></td></tr>
<tr><td class="campo">Departamento:</td><td><?=$tercero['depa']?></td>
<td class="campo">Municipio:</td><td><?=$tercero['nombre']?></td></tr>
<tr><td class="campo">Servicio:</td><td><?=$atencion['nombre_servicio']?></td>
<td class="campo"> Cama:</td><td><?=$atencion['cama']?>
</tr>
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td></tr>
</table>
</td>
</tr>
<tr>
<th colspan="2">Información de la solicitud</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo">Fecha y hora de recepción:</td><td><?=$traslado['fecha_solicitud']?></td>
<td class="campo">Fecha y hora de la órden:</td><td><?=$traslado['fecha_orden']?></td>
<tr><td class="campo">Trámite solicitado:</td><td colspan="3"><?=$traslado['tramite']?></td></tr>
<tr><td class="campo">Tipo traslado:</td><td colspan="3"><?php
if($traslado['tipo_traslado'] == 1){
	echo "Remisión";
}else if($traslado['tipo_traslado'] == 2){
	echo "Procedimientos o examenes";
}else if($traslado['tipo_traslado'] == 3){
	echo "Otro";
}else if($traslado['tipo_traslado'] == 4){
	echo "Contra remisión";
}
?></td></tr>
<tr><td class="campo">Prioridad:</td><td colspan="3"><?=$traslado['prioridad']?></td></tr>
<tr><td class="campo">Procedimiento:</td><td colspan="3"><?=$traslado['procedimiento']?></td></tr>
<tr><td class="campo">Médico que remite:</td><td colspan="3"><?=$traslado['medico_remite']?></td></tr>
<?php
if($traslado['autorizacion'] == 'SI')
{
?>
<tr><td class="campo">Autorización:</td><td><?=$auto['autorizacion']?></td>
<td class="campo">Fecha y hora autorización:</td><td><?=$auto['fecha_autorizacion']?></td>
</tr>
<tr><td class="campo">Observación autorización:</td><td colspan="3"><?=$auto['obs_autorizacion']?></td></tr>
<?php
}
?>
</table>
</td></tr>
<tr>
<?php
if($traslado['activo'] == 'NO')
{
?>
<th colspan="2">Información de finalización</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<tr><td class="campo" width="50%">Transporte realizado:</td><td width="50%"><?=$traslado_fin['traslado_realizado']?></td>
</tr>
<?php
if($traslado_fin['traslado_realizado'] == 'SI')
{
?>
<tr><td class="campo">Fecha y hora del traslado:</td><td><?=$traslado_fin['fecha_traslado']?></td></tr>
<tr><td class="campo">Conductor:</td><td><?=$traslado_fin['conductor']?></td></tr>
<tr><td class="campo">Paramedico:</td><td><?=$traslado_fin['paramedico']?></td></tr>
<tr><td class="campo">Medico:</td><td><?=$traslado_fin['medico']?></td></tr>
<tr><td class="campo">Observacion:</td><td><?=$traslado_fin['observacion']?></td></tr>
<tr><td class="campo">Fecha y hora del registro:</td><td><?=$traslado_fin['fecha_creacion']?></td></tr>
<?php
}else{
?>
<tr><td class="campo">Motivo no traslado:</td><td><?=$traslado_fin['motivo_no_traslado']?></td></tr>
<?php
}
?>
</table>
</td></tr>
<?php
}
?>
<tr><th colspan="2">Diagnósticos</th></tr>
<tr><td colspan="2">
<table width="100%" class="tabla_interna">
<?php
$i = 1;
if(count($dx) > 0)
{
foreach($dx as $d)
{
?>
<tr><td class="campo">Diagnostico <?=$i?>:</td><td>
<?php
	echo '<strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'];
?>
</td></tr>
<?php
$i++;
}
}
?>
<?php
if(isset($dx_evo)){
if(count($dx_evo) > 0)
{
foreach($dx_evo as $d)
{
?>
<tr><td class="campo">Diagnostico <?=$i?>:</td><td>
<?php
	echo '<strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'];
?>
</td></tr>
<?php
$i++;
}
}
}
?>
</table>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><th colspan="2">Notas</th></tr>
<tr><td colspan="2">
<div id='div_lista_notas'>
<?php
if($notas != 0){
foreach($notas as $data){
$d['nota'] = $data;
$this->load->view('ref/ref_traslado_nota_info',$d);
}
}
?>
</div>
</td></tr>
<tr><td colspan="2" class="linea_azul"></td></tr>
<tr><td colspan="2" align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>                             
</table>