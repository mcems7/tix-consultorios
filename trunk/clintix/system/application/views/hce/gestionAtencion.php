<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
///////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Historia cl&iacute;nica electr&oacute;nica</h1>
<h2 class="subtitulo">Consulta atenci&oacute;n</h2>
<center>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_form">
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
<tr><td class="campo">Genero:</td><td><?=$paciente['genero']?></td>
<td class="campo">Ingreso administrativo:</td>
<td><?php
echo $atencion['admision'];
if($atencion['admision'] == 'SI')
{
	echo ' - <strong>',$atencion['ingreso'], '</strong>';
}
?></td></tr>
</table>
</td>
</tr>

<tr>
<td>
<table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_interna">
  <tr>
    <td class="campo">Fecha y hora de ingreso:</td>
    <td><?=$atencion['fecha_ingreso']?>&nbsp;</td>
  <?php
	$clas = "";
	if($atencion['clasificacion'] == 1){
		$clas = 'class="triage_rojo_con"';
	}else if($atencion['clasificacion'] == 2){
		$clas = 'class="triage_amarillo_con"';
	}else if($atencion['clasificacion'] == 3){
		$clas = 'class="triage_verde_con"';
	}else if($atencion['clasificacion'] == 4){
		$clas = 'class="triage_blanco_con"';
	}
	
?>
    <td class="campo">Clasificación TRIAGE:</td>
    <td <?=$clas?> style="padding:10px; text-align:left;"><?=$atencion['clasificacion']?>&nbsp;</td>
  </tr>
  <tr>
    <td class="campo">Motivo de consulta:</td>
    <td colspan="3"><?php
    if($atencion['consulta'] == 'SI')
		echo $consulta['motivo_consulta'];
	else
		echo "SIN CONSULTA";?>&nbsp;</td>
  </tr>
  <tr>
  <td class="campo">Diagn&oacute;sticos consulta inicial:</td>
  <td colspan="3">
  
  <?php
if(count($dxCon) > 0)
{
	foreach($dxCon as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a la consulta inicial';

}
?>
  </td></tr>
    <tr>
  <td class="campo">Diagn&oacute;sticos evoluciones:</td>
  <td colspan="3">
  
  <?php
if(count($dxEvo) > 0)
{
	foreach($dxEvo as $d)
	{

		echo '<li><strong>'.$d['id_diag'].'</strong> '.$d['diagnostico'] ,'</li>';

	}
}else{
echo 'No hay diagn&oacute;sticos asociados a las evoluciones';
}
?>
  </td></tr>
</table>

</td>
</tr>
<tr><th colspan="2" id="opciones">Opciones disponibles</th></tr>
<tr>
<td colspan="2">
<table width="100%" border="0" cellspacing="5" cellpadding="2" >
  <tr>
    <td class="opcion"><a href="<?=site_url()?>/hce/main/consultaTriage/<?=$atencion['id_atencion']?>">Consultar<br />TRIAGE</a></td>

<?php
if($atencion['consulta'] == 'SI'){
?>
    <td class="opcion"><a href="<?=site_url()?>/hce/main/consultaAtencion/<?=$atencion['id_atencion']?>">Consultar<br /> Atención inicial</a></td>

    <td class="opcion">
   <a href="<?=site_url()?>/hce/main/consultaEvoluciones/<?=$atencion['id_atencion']?>">Evoluciones</a>  
</td>
<td class="opcion">
<?=anchor('/hce/main/consultarNota/'.$atencion['id_atencion'],'Notas de enfermer&iacute;a');?>
</td>


<td class="opcion">
<?=anchor('/hce/main/consultarSv/'.$atencion['id_atencion'],'Signos Vitales enfermer&iacute;a');?>
</td>
<td class="opcion">
<?=anchor('/hce/main/consultaBl/'.$atencion['id_atencion'],'Balance De L&iacute;quidos');?>
</td>
<td class="opcion">
<a href="<?=site_url()?>/hce/main/consultarOrdenes/<?=$atencion['id_atencion']?>">Ordenes procedimientos y formulación</a>
</td>



  
<?php
}
if($rem != 0)
{
	
?>
<td class="opcion">
<a href="<?=site_url()?>/hce/main/consultaRemision/<?=$atencion['id_atencion']?>">Remision</a>
</td>

<?php
}

if($obs != 0)
{
?>
    <td class="opcion">
    <a href="<?=site_url()?>/hce/main/consultaEpicrisis/<?=$atencion['id_atencion']?>">Epicrisis</a>
    </td>

<?php
}else{
	
}
?>


  </tr>
  <tr>

  <?php
if($atencion['id_origen'] == '4')
{
?>
<td class="opcion"><a href="<?=site_url()?>/urg/certificado_accidente/main/<?=$atencion['id_atencion']?>">Certificado de atención médica para víctimas de accidentes de transito

</a></td>

<?php
}
?>
 <td class="opcion"><a href="<?=site_url()?>/urg/admision/admisionPaciente/<?=$atencion['id_atencion']?>">Modificar admisi&oacute;n</a></td>
<?php
if($atencion['anexo2'] == 'SI')
{
?>
  <td class="opcion">
  <a href="<?=site_url()?>/auto/anexo2/generarAnexo2Manual/<?=$atencion['id_atencion']."/".$atencion['id_entidad']?>">
  Reenviar Anexo t&eacute;cnico 2</a>
  </td>
<?php
}
?>


<?php
//Horas de espera para permitir apertura atención
$horas_espera = 18;
$segundos_espera = $horas_espera * 3600;

$fecha_actual_time = mktime(date('H'),date('i'),date('s'),date('m'),date('d'),date('Y'));
$fecha = explode(" ", $atencion['fecha_egreso']);
list($anno, $mes, $dia) = explode( '-', $fecha[0] );
list($hora, $min, $seg)= explode( ':', $fecha[1] );
$fecha_egreso_time = mktime( $hora , $min , $seg , $mes , $dia , $anno );
$segundos = $fecha_actual_time - $fecha_egreso_time;



if($atencion['activo'] == 'NO')
{
	//Si no se ha superado el tiempo de espera permite abrir atencion
	if($segundos_espera >= $segundos){
?>
  <td class="opcion">
  <a href="<?=site_url()?>/urg/abrir_atencion/main/<?=$atencion['id_atencion']."/".$atencion['id_entidad']?>">Abrir atenci&oacute;n</a>
  </td>
<?php
	}
}
?>

  <tr>
</table>
</td>
</tr>
<tr><th colspan="2" id="opciones">Listado del anexo técnico 3 generados</th></tr>
<tr><td>
<table style="width:100%" class="tabla_interna">
<?php
if($anexo3 != 0)
{
?>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora envio</td>
<td class="campo_centro">Número de solicitud</td>
<td class="campo_centro">Procedimientos o servicios solicitados</td>
<td class="campo_centro">Entidad responsable de pago</td>
<td class="campo_centro">Estado</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
	$i = 1;
	
	foreach($anexo3 as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_anexo']?><br /><?=$d['hora_anexo']?></td>
<td align="center"><?=$d['numero_informe']?></td>
<td>
<?php
$cups = $this -> autorizaciones_model -> obtenerCupsAnexo3($d['id_anexo3']);
if($cups != 0)
{
	foreach($cups as $data)
	{
		$procedimiento = $this->urgencias_model->obtenerNomCubs($data['cups']); 
		echo '<li>',$procedimiento,"</li>";
	}
}
?>
</td>
<td style=""><?=$d['razon_social']?></td>	
<td align="center"><?=$d['estado_anexo']?></td>
<td class="opcion">
<a href="<?=site_url()?>/auto/anexo3/gestionAnexo3/<?=$d['id_anexo3']?>"><strong>Administrar</strong></a>
</td>

<?php
$i++;
	}

}else{
?>
<tr><td class="campo_centro">No se encontraron registros</td></tr>
<?php
}
?>
</table>
</td></tr>
<tr><th colspan="2" id="opciones">Listado del anexo técnico 2 generados</th></tr>
<tr><td>
<table style="width:100%" class="tabla_interna">
<?php
$n = count($anexo2);
if($n>0)
{
?>
<tr>
<td class="campo_centro">No.</td>
<td class="campo_centro">Fecha y hora envio</td>
<td class="campo_centro">Número de solicitud</td>
<td class="campo_centro">Entidad responsable de pago</td>
<td class="campo_centro">Estado del envio</td>
<td class="campo_centro">Operación</td>
</tr>
<?php
	$i = 1;
	
	foreach($anexo2 as $d)
	{
?>
<tr>
<td align="center"><strong><?=$i?></strong></td>
<td><?=$d['fecha_anexo']?><br /><?=$d['hora_anexo']?></td>
<td align="center"><?=$d['numero_informe']?></td>
<td style=""><?=$d['razon_social']?></td>
<?php
	$bandera = false;
	if($d['enviado'] == 'NO')
	{
		$estilo ='style="background-color:#F00;font-weight:bold;color:#FFF;"';
		$bandera = false;
	}else
	{
		$estilo ='style="font-weight:bold;"';
		$bandera = true;
	}
?>
<td align="center" <?=$estilo?>><?=$d['enviado']?></td>
<td class="opcion">
<strong>
<?php
if($bandera){
echo anchor('/auto/anexo2/consultarAnexo2/'.$d['id_anexo2'],'Consultar',array('target' => 'Blanck_'));
}else{
echo anchor('/auto/anexo2/consultarAnexo2/'.$d['id_anexo2'],'Consultar',array('target' => 'Blanck_')).br();	
echo anchor('/auto/anexo2/reenviarAnexo2/'.$d['id_anexo2'],'Enviar');	
}
?>
</strong>
</td>

<?php
$i++;
	}

}else{
	if($atencion['activo'] == 'NO' && $atencion['anexo2'] == 'NO'){
?>
<tr><td class="opcion"><?=anchor('/auto/anexo2/generarAnexo2Manual/'.$atencion['id_atencion'].'/'.$atencion['id_entidad'],'Envió manual del anexo 2')?>	</td></tr>
<?php
	}else{
?>
<tr><td class="campo_centro">No se encontraron registros</td></tr>
<?php		
	}
}
?>
</table>
</td></tr>
</table>
</center>