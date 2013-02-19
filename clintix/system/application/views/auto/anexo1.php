<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Anexo 1</title>

<style>
.tabla_principal{
	border-color:#000000;
	border-style: solid; 
	border-width: 1px;	
}
</style>
</head>

<body style="font:Arial, Helvetica, sans-serif;">
<table width="98%" align="center"  cellpadding="5" cellspacing="0" border="1" class="tabla_principal">
	<tr>
		<td>
		<img src='../images/escudo_colombia.jpg' border='0' alt='' align='left'>
		<div align='center'>
		
		<b>MINISTERIO DE LA PROTECCION SOCIAL<BR>
		INFORME DE POSIBLES INCONSISTENCIAS EN LA BASE DE DATOS DE LA ENTIDAD RESPONSABLE DEL PAGO
		</b>
		<BR><div align='center'>NUMERO DE INFORME: <b><?php printf("%04d",$anexo['numero_informe'])?></b></div> <div align='right'>FECHA:<b> <?=$anexo['fecha_anexo']?> </b> HORA: <b> <?=$anexo['hora_anexo']?> </b></div>
		
		
		</div>
	</td>
</tr>
<tr>
	<td>
		
	
		<b><div align='center'>INFORMACION DEL PRESTADOR:</div></b>
		<br>Nombre: <b><?=$empresa['razon_social']?></b> NIT <b><?=$empresa['nit']?> - <?=$empresa['nit_dv']?></b>
		<br>Código<b> <?=$empresa['codigo']?></b> Dirección <b><?=$empresa['direccion']?></b>
		<br>Teléfono: Indicativo<b> <?=$empresa['indicativo']?></b> Número <b><?=$empresa['telefono1']?></b> Departamento: <?=$empresa['depa']?> <strong><?=$anexo['cod_depa_empresa']?></strong> Municipio: <?=$empresa['muni']?> <strong><?=$anexo['cod_muni_empresa']?></strong>
		 
	</td>
</tr>
<tr>
	<td>
<div align='center'><b>	ENTIDAD A LA QUE SE LE INFORMA (PAGADOR)</b></div> <b> <?=$entidad['razon_social']?> </b> CODIGO:<b> <?=$entidad['codigo_eapb']?></b>
	</td>
</tr>
<tr>
	<td>
	<table border='0'>
		<tr>
			<td>
			Tipo de inconsistencia:
			</td>
			<td><strong>
			<?php 
			if($anexo['tipo_inconsistencia'] == '1'){
				echo "El usuario no existe en la base de datos";	
			}else if($anexo['tipo_inconsistencia'] == '2'){
				echo "Los datos del usuario no corresponden con los del documento de identificación presentados";
			}
			?></strong>
			</td>
		</tr>

</table>
	</td>
</tr>
<tr>
	<td>
	<div align='center'><b>DATOS DEL USUARIO</b> (Como aparece en la base de datos)</div>
	<table border='1' width='100%' align='center'  cellpadding='0' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr align='center'>
    <td><b><?=$anexo['primer_apellido']?></b></td>
    <td><b><?=$anexo['segundo_apellido']?></b></td>
    <td><b><?=$anexo['primer_nombre']?></b></td>
    <td><b><?=$anexo['segundo_nombre']?></b></td></tr>
	<tr align='center'><td><font size='-1'>Primer Apellido</font></td><td><font size='-1'>Segundo Apellido</font></td><td><font size='-1'>Primer Nombre</font></td><td><font size='-1'>Segundo Nombre</font></td></tr>

	</table><b>Tipo documento de Identificación:</b>
	<table border='0'  width='90%'>
	<tr valign='top'>
		<td >
<?php
	$r1 = '';
	$r2 = '';
	$r3 = '';
	$r4 = '';
	$r5 = '';
	$r6 = '';
	$r7 = '';
	
	if($anexo['id_tipo_documento'] == 1){
	$r1 = 'checked="checked"';
	}else if($anexo['id_tipo_documento'] == 2){
	$r2 = 'checked="checked"';
	}else if($anexo['id_tipo_documento'] == 3){
	$r3 = 'checked="checked"';
	}else if($anexo['id_tipo_documento'] == 4){
	$r4 = 'checked="checked"';
	}else if($anexo['id_tipo_documento'] == 5){
	$r5 = 'checked="checked"';
	}else if($anexo['id_tipo_documento'] == 6){
	$r6 = 'checked="checked"';
	}else if($anexo['id_tipo_documento'] == 8){
	$r7 = 'checked="checked"';
	}
?>        
		<input type='checkbox' disabled='true' <?=$r4?> > Registro Civil
	<br><input type='checkbox' disabled='true' <?=$r3?> > Tarjeta de identidad
	<br><input type='checkbox' disabled='true' <?=$r1?> > Cédula de ciudadanía
	<br><input type='checkbox' disabled='true' <?=$r2?> > Cédula de extranjería
		</td>
		<td>
		<input type='checkbox' disabled='true' <?=$r7?> > Pasaporte
	<br><input type='checkbox' disabled='true' <?=$r5?> > Adulto sin identificación
	<br><input type='checkbox' disabled='true' <?=$r6?> > Menor sin identificación
		</td>
		<td valign='bottom'>
		<div align='right'><b><?=$anexo['numero_documento']?></b><br>
		<font size='-2'>Número documento de identificación</font>
		<br><br>Fecha de nacimiento: <b><?=$anexo['numero_documento']?></b></div>
		</td>
	</tr>
	</table>
	<hr>
	Dirección de Residencia Habitual: <b><?=$anexo['direccion']?></b> Telefono: <b><?=$anexo['telefono']?></b>
	<br>Departamento: <?=$anexo['depa']?> <b><?=$anexo['departamento']?></b> Municipio: <?=$anexo['muni']?> <b><?=$anexo['municipio']?></b>
	<hr>
	<b>Cobertura en salud</b>
	<table border='0'  width='90%'>
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
	<b><div align='center'>INFORMACIÓN DE LA POSIBLE INCONSISTENCIA</div></b><hr>
	<TABLE width='100%' border='0'>
	<tr>
		<td><b><font size='-1'>VARABLE PRESUNTAMENTE INCORRECTA</font></b></td>
		<td colspan='2'><div align='center'><b><font size='-1'>DATOS SEGÚN DOCUMENTO DE IDENTIFICACION (Físico)</font></div></b></td>
	</tr>
	<tr  valign='top'>
		<td rowspan='7'><font size='-1' >
        <?php
	$r1 = '';
	$r2 = '';
	$r3 = '';
	$r4 = '';
	$r5 = '';
	$r6 = '';
	$r7 = '';
	if($anexo['primer_apellido_caja'] == 'SI'){
	$r1 = 'checked="checked"';
	}
	
	if($anexo['segundo_apellido_caja'] == 'SI'){
	$r2 = 'checked="checked"';
	}
	
	if($anexo['primer_nombre_caja'] == 'SI'){
	$r3 = 'checked="checked"';
	}
	
	if($anexo['segundo_nombre_caja'] == 'SI'){
	$r4 = 'checked="checked"';
	}
	
	if($anexo['tipo_documento_caja'] == 'SI'){
	$r5 = 'checked="checked"';
	}
	
	if($anexo['numero_documento_caja'] == 'SI'){
	$r6 = 'checked="checked"';
	}
	
	if($anexo['fecha_nacimiento_caja'] == 'SI'){
	$r7 = 'checked="checked"';
	}
	
?>
		<BR><input type='checkbox' disabled='true' <?=$r1?> > Primer Apellido
		<BR><input type='checkbox' disabled='true' <?=$r2?> > Segundo Apellido
		<BR><input type='checkbox' disabled='true' <?=$r3?> > Primer Nombre
		<BR><input type='checkbox' disabled='true' <?=$r4?> > Segundo Nombre
		<BR><input type='checkbox' disabled='true' <?=$r5?> > Tipo documento de identificación
		<BR><input type='checkbox' disabled='true' <?=$r6?> > Número documeto de identificación
		<BR><input type='checkbox' disabled='true' <?=$r8?> > Fecha de nacimiento</font>
		
		</td>
		<td >Primer Apellido:</td><td><div align='right'><b>
        <?php
		if($anexo['primer_apellido_caja'] == 'SI'){
		echo $anexo['primer_apellido_doc'];
		}
        ?>
		</b></div></td></tr>
		<tr  valign='top'><td>Segundo Apellido:</td><td><div align='right'><b>
         <?php
		if($anexo['segundo_apellido_caja'] == 'SI'){
		echo $anexo['segundo_apellido_doc'];
		}
        ?></b></div></td></tr>
		<tr  valign='top'><td>Primer Nombre:</td><td><div align='right'><b>
          <?php
		if($anexo['primer_nombre_caja'] == 'SI'){
		echo $anexo['primer_nombre_doc'];
		}?>
        </b></div></td></tr>
		<tr  valign='top'><td>Segundo Nombre:</td><td><div align='right'><b>
        <?php
		if($anexo['segundo_nombre_caja'] == 'SI'){
		echo $anexo['segundo_nombre_doc'];
		}?>
        </b></div></td></tr>
		<tr  valign='top'><td>Tipo documento de identificacion:</td><td><div align='right'><b>
         <?php
		if($anexo['tipo_documento_caja'] == 'SI'){
		echo $anexo['tipo_documento_doc'];
		}?>
        </b></div></td></tr>
		<tr  valign='top'><td>Número documento identificación:</td><td><div align='right'><b>
         <?php
		if($anexo['numero_documento_caja'] == 'SI'){
		echo $anexo['numero_documento_doc'];
		}?>
        </b></div></td></tr>
		<tr  valign='top'><td>Fecha nacimiento:</td><td><div align=''><b>
          <?php
		if($anexo['fecha_nacimiento_caja'] == 'SI'){
		echo $anexo['fecha_nacimiento_doc'];
		}?>
        </b></div></td></tr>
		
		</font>
		</td>
		
	</tr>
	</table>
	
	</td>
</tr>
<tr>
	<td><b>OBSERVACIONES</b><BR><?=$anexo['observaciones']?>
	</td>
</tr>
<tr>
	<td><div align='center'><b>DATOS DE LA PERSONA QUE REPORTA</b></div>
	<table with='100%'><tr><td>
			Nombre de quien informa: <b><?=$anexo['nombre_reporta']?></b>
	<br>Cargo o actividad: <b><?=$anexo['cargo_reporta']?></b>
	</td><td>
	Teléfono <b><?=$anexo['indicativo_reporta']." ".$anexo['telefono_reporta']." Ext: ".$anexo['ext_reporta']?></b>
	Telefono celular: <b><?=$anexo['celular_reporta']?></b>
	</td></tr></table>
	
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