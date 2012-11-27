<script type="text/javascript">
////////////////////////////////////////////////////////////////////////////////
function regresar()
{
	document.location = "<?php echo $urlRegresar; ?>";
}
////////////////////////////////////////////////////////////////////////////////
</script>
<h1 class="tituloppal">Servicio de urgencias - Retiro voluntario</h1>
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
    <td class="campo">Fecha y hora de egreso:</td>
    <td colspan="3"><?=$atencion['fecha_egreso']?>&nbsp;</td>
    </tr>
</table>
</td></tr>
<tr><td class="linea_azul"></td></tr>      
<tr><td align="center">
<?
$data = array(	'name' => 'bv',
				'onclick' => 'regresar()',
				'value' => 'Volver',
				'type' =>'button');
echo form_input($data),nbs();
$data = array(	'name' => 'imp',
				'onclick' => "Abrir_ventana('".site_url('/impresion/impresion/retiroVoluntario/'.$atencion['id_atencion'])."')",
				'value' => 'Imprimir',
				'type' =>'button');
echo form_input($data);
?>
</td></tr>
</table>
</center>
<?=form_close();?>
