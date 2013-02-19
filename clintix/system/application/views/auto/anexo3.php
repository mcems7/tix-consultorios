<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>SOLICITUD DE AUTORIZACIÓN DE SERVICIOS DE SALUD</title>
<style>
.tabla{
	border-color:#000000;
	border-style: solid; 
	border-width: 1px;
	border-collapse:collapse;	
}
.encabezado{
	font-size:10px;	
}
</style>
</head>
<?php
	$f= '';
	if($tipo == 'email'){
		$f = 10;
	}else if($tipo == 'pdf'){
		$f = 8;
	}else if($tipo == 'web'){
		$f = 12;
	}
?>
<body style="font:Arial, Helvetica, sans-serif; font-size:<?=$f?>">
<p>La información reportada y/o autorización de servicios solicitada, esta acorde con los lineamientos técnicos del Decreto 4747 de 2007, la Resolución 3047 de 2008 y la Ley 527 de 1999(en lo relacionado con la validéz e irrefutabilidad de la información electrónica).</p>
<table width="98%" align="center"  cellpadding="5" cellspacing="0" class="tabla">
	<tr>
		<td>
        
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="20%" rowspan="2"><img src='http://www.opuslibertati.org/escudo_colombia.jpg' border="0" alt='' align='left'></td>
    <td align="center" width="60%" class="encabezado"><b>MINISTERIO DE LA PROTECCION SOCIAL<BR>
		SOLICITUD DE AUTORIZACIÓN DE SERVICIOS DE SALUD
		</b></td>
    <td width="20%">&nbsp;</td></tr><tr>
  <td colspan="2" align="right"><br />NUMERO DE LA ATENCION: <b><?php printf("%04d",$anexo['numero_informe'])?></b>&nbsp;FECHA:<b> <?=$anexo['fecha_anexo']?></b> HORA:<b> <?=$anexo['hora_anexo']?> </b></td>
  </tr>
</table>
	</td>
</tr>
<tr>
	<td>
		
		<b>INFORMACION DEL PRESTADOR</b>
 		
<table width="100%" border="1" cellspacing="0" cellpadding="0" class="tabla">
<tr><td colspan="3">Nombre: <b><?=$empresa['razon_social']?></b></td><td colspan="2">NIT: <b><?=$empresa['nit']?> - <?=$empresa['nit_dv']?></b></td></tr>
  <tr>
    <td>Código</td>
    <td colspan="2"><b><?=$empresa['codigo']?></b>&nbsp;</td>
    <td colspan="2" rowspan="2">Dirección del prestador:<br /> <b><?=$empresa['direccion']?></b></td>
  </tr>
  <tr>
    <td rowspan="2" valign="middle">Teléfono</td>
    <td align="center"><strong><?=$empresa['indicativo']?></strong>&nbsp;</td>
    <td align="center"><strong><?=$empresa['telefono1']?></strong>&nbsp;</td>
  </tr>
  <tr>
    <td align="center">indicativo</td>
    <td align="center">número</td>
    <td>Departamento: <?=$empresa['depa']?> <b><?=$anexo['cod_depa_empresa']?></b></td>
    <td>Municipio: <?=$empresa['muni']?> <b><?=$anexo['cod_muni_empresa']?></b></td>
  </tr>
  <tr>
  <td colspan="3">Entidad a la que se le informa: <b><?=$entidad['razon_social']?></b></td>
  <td colspan="2">Código: <b><?=$entidad['codigo_eapb']?></b></td>
  </tr>
</table>
        
    
		
		 
	</td>
</tr>

<tr>
	<td>
	<div align='center'><b>DATOS DEL PACIENTE</b></div>
	<table width='100%'  cellpadding='0' cellspacing='0' class="tabla" border="1">
	<tr align='center'><td><b><?=$tercero['primer_apellido']?></b></td><td><b><?=$tercero['segundo_apellido']?></b></td><td><b><?=$tercero['primer_nombre']?></b></td><td><b><?=$tercero['segundo_nombre']?></b></td></tr>
	<tr align='center'><td>Primer Apellido</DIV></td><td>Segundo Apellido</td><td>Primer Nombre</td><td>Segundo Nombre</td></tr>

	</table>
        <?php
	$r1 = '&nbsp;&nbsp;&nbsp;';
	$r2 = '&nbsp;&nbsp;&nbsp;';
	$r3 = '&nbsp;&nbsp;&nbsp;';
	$r4 = '&nbsp;&nbsp;&nbsp;';
	$r5 = '&nbsp;&nbsp;&nbsp;';
	$r6 = '&nbsp;&nbsp;&nbsp;';
	$r7 = '&nbsp;&nbsp;&nbsp;';
	
	if($tercero['id_tipo_documento'] == 1){
	$r1 = 'X';
	}else if($tercero['id_tipo_documento'] == 2){
	$r2 = 'X';
	}else if($tercero['id_tipo_documento'] == 3){
	$r3 = 'X';
	}else if($tercero['id_tipo_documento'] == 4){
	$r4 = 'X';
	}else if($tercero['id_tipo_documento'] == 5){
	$r5 = 'X';
	}else if($tercero['id_tipo_documento'] == 6){
	$r6 = 'X';
	}else if($tercero['id_tipo_documento'] == 8){
	$r7 = 'X';
	}
?>        

  <table width="100%" cellspacing="0" cellpadding="0" border="0">
  <tr>
    <td colspan="2"><strong>Tipo documento de Identificación:</strong></td>
    <td rowspan="3" align="center" style="vertical-align:middle"><strong><?=$tercero['numero_documento']?></strong>&nbsp;<br>
		Número documento de identificación</td>
  </tr>
  <tr>
    <td>[<?=$r4?>] Registro Civil</td>
    <td>[<?=$r7?>] Pasaporte</td>
  </tr>
  <tr>
    <td>[<?=$r3?>] Tarjeta de identidad</td>
    <td>[<?=$r5?>] Adulto sin identificación</td>
  </tr>
  <tr>
    <td>[<?=$r1?>] Cédula de ciudadanía</td>
    <td>[<?=$r6?>] Menor sin identificación</td>
     <td rowspan="2" align="center">Fecha de nacimiento: <strong><?=$tercero['fecha_nacimiento']?></strong></td>
  </tr>
  <tr>
    <td>[<?=$r2?>] Cédula de extranjería</td>
    <td>&nbsp;</td>
  </tr>
</table>
<br />
	<table width='100%' border="1" cellpadding="0" cellspacing="0" class="tabla">
	<tr>
		<td>Dirección de Residencia Habitual:&nbsp; <b><?=$tercero['direccion']?></b>
		</td>
		<td align='right'>Telefono: <b><?=$tercero['telefono']?></b>
		</td>
	</tr>
	<tr>
		<td height="18">Departamento: <?=$tercero['depa']?>  <b><?=$tercero['departamento']?></b> 
		</td>
		<td align='right'>Municipio: <?=$tercero['nombre']?>  <b><?=$tercero['municipio']?></b> 
		</td>
	</tr>
	</table>
	<b>Cobertura en salud</b>
	<table border="0"  width='90%' cellpadding="0" cellspacing="0">
	<tr valign='top'>
		<td >
       <?php
	$r1 = '&nbsp;&nbsp;&nbsp;';
	$r2 = '&nbsp;&nbsp;&nbsp;';
	$r3 = '&nbsp;&nbsp;&nbsp;';
	$r4 = '&nbsp;&nbsp;&nbsp;';
	$r5 = '&nbsp;&nbsp;&nbsp;';
	$r6 = '&nbsp;&nbsp;&nbsp;';
	$r7 = '&nbsp;&nbsp;&nbsp;';
	$r8 = '&nbsp;&nbsp;&nbsp;';
	
	if($anexo['cobertura'] == 1){
	$r1 = 'X';
	}else if($anexo['cobertura'] == 2){
	$r2 = 'X';
	}else if($anexo['cobertura'] == 3){
	$r3 = 'X';
	}else if($anexo['cobertura'] == 4){
	$r4 = 'X';
	}else if($anexo['cobertura'] == 5){
	$r5 = 'X';
	}else if($anexo['cobertura'] == 6){
	$r6 = 'X';
	}else if($anexo['cobertura'] == 7){
	$r7 = 'X';
	}else if($anexo['cobertura'] == 8){
	$r8 = 'X';
	}
	
?>
		[<?=$r1?>] Regimen contributivo
	<br>[<?=$r2?>] Regimen subsidiado - total

		</td>
		<td>
		[<?=$r3?>] Regimen subsidiado - parcial
		<br>[<?=$r4?>] Población pobre no asegurada con SISBEN
	
		</td>
		<td>
		[<?=$r5?>] Población pobre no asegurada sin SISBEN
	<br>[<?=$r6?>] Desplazado
	
		</td>
		<td>
		[<?=$r7?>] Plan adicional de salud
	<br>[<?=$r8?>] Otro
		</td>
		
	</tr>
	</table>
</td>
</tr>
<tr>
	<td>
     <hr>
	<b><div align='center'><b>INFORMACIÓN DE LA ATENCIÓN Y SERVICIOS SOLICITADOS</b></div></b>
	
	<table width='100%' cellpadding="0" cellspacing="0"> 
	<tr>
    <td colspan="3"><b>Orígen de la atención</b></td>
    <td><b>Tipos de servicios solicitados</b></td>
    <td><b>Prioridad de la atenci&oacute;n</b></td>
    </tr>
     <?php
	$r1 = '&nbsp;&nbsp;&nbsp;';
	$r2 = '&nbsp;&nbsp;&nbsp;';
	$r3 = '&nbsp;&nbsp;&nbsp;';
	$r4 = '&nbsp;&nbsp;&nbsp;';
	$r5 = '&nbsp;&nbsp;&nbsp;';
	$r6 = '&nbsp;&nbsp;&nbsp;';
	$r7 = '&nbsp;&nbsp;&nbsp;';
	
	if($anexo['id_origen'] == 1){
	$r1 = 'X';
	}else if($anexo['id_origen'] == 2){
	$r2 = 'X';
	}else if($anexo['id_origen'] == 3){
	$r3 = 'X';
	}else if($anexo['id_origen'] == 4){
	$r4 = 'X';
	}else if($anexo['id_origen'] == 5){
	$r5 = 'X';
	}else if($anexo['id_origen'] == 6){
	$r6 = 'X';
	}else if($anexo['id_origen'] == 7){
	$r7 = 'X';
	}
?>
<tr valign='top'>
		<td>
			[<?=$r1?>] Enfermedad general
			<br>[<?=$r2?>] Enfermedad profesional 
			
		</td>
		<td>[<?=$r3?>] Accidente de trabajo
		<br>[<?=$r4?>] Accidente de tránsito
		</td>
		<td>[<?=$r5?>] Evento catastrófico
		</td>
		<td>
        <?php
	$r1 = '&nbsp;&nbsp;&nbsp;';
	$r2 = '&nbsp;&nbsp;&nbsp;';
	if($anexo['serv_soli'] == 1){
	$r1 = 'X';
	}else if($anexo['serv_soli'] == 2){
	$r2 = 'X';
	}
?>
        [<?=$r1?>] Posterior a la atención inicial de urgencias<br />
        [<?=$r2?>] Servicios electivos
        </td>
<?php
	$r1 = '&nbsp;&nbsp;&nbsp;';
	$r2 = '&nbsp;&nbsp;&nbsp;';
	if($anexo['prioridad'] == '1'){
	$r1 = 'X';
	}else if($anexo['prioridad'] == 2){
	$r2 = 'X';
	}
?>
		<td>
        [<?=$r1?>] Prioritaria<br />
        [<?=$r2?>] No Prioritaria
        </td>
	</tr>
	
	</table>
    <hr>
     <?php
	$r1 = '&nbsp;&nbsp;&nbsp;';
	$r2 = '&nbsp;&nbsp;&nbsp;';
	$r3 = '&nbsp;&nbsp;&nbsp;';
	if($anexo['ubicacion_paciente'] == 1){
	$r1 = 'X';
	}else if($anexo['ubicacion_paciente'] == 2){
	$r2 = 'X';
	}else if($anexo['ubicacion_paciente'] == 3){
	$r3 = 'X';
	}
?>
	<table width='100%' align='center'  cellpadding='0' cellspacing='0' border="0">
    <tr><td colspan="3">Ubicaci&oacute;n del paciente al momento de la solicitud de autorizaci&oacute;n</td></tr>
    <tr><td>[<?=$r1?>] Consulta externa</td>
    <td>[<?=$r3?>] Hospitalizaci&oacute;n</td>
    <td>Servicio: <strong><?=$anexo['nombre_servicio']?></strong></td></tr>
     <tr><td>[<?=$r2?>] Urgencias</td>
    <td></td>
    <td>Cama: <strong><?=$anexo['cama']?></strong></td></tr>
	</table>
    <hr>
    <div>Manejo integral según guía de: <strong><?=$anexo['guia_manejo']?></strong></div>	
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><strong>C&oacute;digo CUPS</strong></td>
    <td><strong>Cantidad</strong></td>
    <td><strong>Descripci&oacute;n</strong></td>
  </tr>
<?php
if($cups != 0)
{
foreach($cups as $d)
{
	$procedimiento = $this->urgencias_model->obtenerNomCubs($d['cups']);
?>  
  <tr>
    <td><?=$d['cups']?>&nbsp;</td>
    <td><?=$d['cantidadCups']?>&nbsp;</td>
    <td><?=$procedimiento?>&nbsp;</td>
  </tr>
<?php
}
}
?> 
</table>
<Hr>
<strong>Justificaci&oacute;n cl&iacute;nica:</strong><br />
<?=$anexo['justificacion_clinica']?>

	<Hr>
	
	<table width='100%' align='center'  cellpadding='0' cellspacing='0' border="0">
	<tr>
		<td width="15%"><b>Impresión diagnóstica</b></td>
		<td align='center' width="15%">CIE10</td>
		<td><b>Descripción:</b></td>
	</tr>
    <?php
$i = 1;
if(count($dx) > 0)
{
foreach($dx as $d)
{
?>
	<tr>
		<td align='center'><strong>Diagnóstico <?=$i;?></strong>
		</td>
		<td align='center'> <b><?=$d['id_diag']?></b> 
		</td>
		<td valign='top'><?=$d['diagnostico']?></td>
	</tr>
<?php
$i++;
}
}
if(isset($dx_evo)){
if(count($dx_evo) > 0)
{
foreach($dx_evo as $d)
{
?>
	<tr>
		<td align='center'><strong>Diagnóstico <?=$i;?></strong>
		</td>
		<td align='center'> <b><?=$d['id_diag']?></b> 
		</td>
		<td valign='top'><?=$d['diagnostico']?></td>
	</tr>
<?php
$i++;
}
}
}
?>	

	</table>
	
	<hr>

	
	
	</td>
</tr>
<tr>
	<td>
    <div align='center'><b>DATOS DE LA PERSONA QUE SOLICITA</b></div>
    <table width="100%" border="1" cellspacing="0" cellpadding="0" class="tabla">
  <tr>
    <td>Nombre de quien solicita:</td>
    <td rowspan="2">Teléfono</td>
    <td><strong><?=$anexo['indicativo_reporta']?></strong>&nbsp;</td>
    <td><strong><?=$anexo['telefono_reporta']?></strong>&nbsp;</td>
    <td><strong><?=$anexo['ext_reporta']?></strong>&nbsp;</td>
  </tr>
  <tr>
    <td><strong><?=$anexo['nombre_reporta']?></strong>&nbsp;</td>
    <td>indicativo</td>
    <td>número</td>
    <td>extensión</td>
  </tr>
  <tr>
    <td>Cargo o actividad: <strong><?=$anexo['cargo_reporta']?></strong>&nbsp;</td>
    <td colspan="2">Teléfono celular:</td>
    <td colspan="2"><strong><?=$anexo['celular_reporta']?></strong>&nbsp;</td>
  </tr>
</table>
	
	</td>
</tr>
<tr>
	<td>		
		</b>
		</td>
	</tr>
</table>
</body>
</html>
