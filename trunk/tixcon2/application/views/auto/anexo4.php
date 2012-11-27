<font face='arial'>
<table border='1' width='98%' align='center'  cellpadding='5' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr>
		<td>
		<img src='../images/escudo_colombia.jpg' border='0' alt='' align='left'>
		<div align='center'>
		
		<b>MINISTERIO DE LA PROTECCION SOCIAL<BR>
		AUTORIZACION DE SERVICIOS DE SALUD
		</b>
		<BR><div align='center'>NUMERO AUTORIZACION: <b>$id_registro</b></div> <div align='right'>FECHA:<b> $fecha_registro</b> HORA:<b> $hora_registro </b></div>
		
		
		</div>
	</td>
</tr>
<tr>
	<td>
		
	
		<b><div align='center'>INFORMACION DEL PRESTADOR:</div></b>
		<table width='100%' border='0'>
			<tr>
			<td>Nombre:
			</td>
			<td>NIT<input type='checkbox'  readonly disabled='true' checked > 
			</td>
			<td><b>$nit_empresa</b>
			</td>
			</tr>
			<tr>
			<td><b>$razon_social</b>
			</td border='1'>
			<td>CC<input type='checkbox'  readonly disabled='true'> 
			</td>
			<td>Número
			</td>
			</tr>
		</table>
 		<hr>
 		<table  width='100%' align='center'  cellpadding='0' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
 		<tr>
 			<td><font size='-1'>Código</font>
 			</td>
 			<td  colspan='2'>|<b>$codigo_empresa</b>|
 			</td>
 			<td  colspan='2'><font size='-1'>Dirección prestador:</font>
 			</td>
 		</tr>
 		<tr>
 			<td span='2'><div align='center'><font size='-1'>Teléfono</font></div>
 			</td>
 			<td><div align='center'>|<b>$indicativo_empresa</b>|</div>
 			</td>
 			<td><div align='center'>|<b>$telefono_empresa_1</b>|</div>
 			</td>
 			<td  colspan='2'><b>$direccion_empresa</b>
 			</td>
 		</tr>
 		<tr>
 			<td><font size='-2'><div align='center'>Indicativo</div></font>
 			</td>
 			<td><font size='-2'><div align='center'>Teléfono</div></font>
 			</td>
 			<td align='right'><font size='-1'>Departamento: </font>$empresa_nombre_departamento |<b>$departamento_empresa</b>|
 			</td>
 			<td align='right'><font size='-1'>Municipio: </font> $empresa_nombre_ciudad |<b>$ciudad_empresa</b>|
 			</td>
 		</tr>
 		<tr>
 			<td colspan='4'><font size='-2'>Entidad a la que se le informa: </font><b>$cliente_razon_social</b>
 			</td>
 			<td align='right' ><font size='-1'>CODIGO:</font>|<b>$cliente_codigo</b>|
 			</td>
 		</tr>
 		</table>
		
		 
	</td>
</tr>

<tr>
	<td>
	<div align='center'><b>DATOS DEL PACIENTE</b></div>
	<table border='1' width='100%' align='center'  cellpadding='0' cellspacing='0' border='1' style='border-color: #000000; border-style: solid; border-width: 1; '  >
	<tr align='center'><td><b>$primer_apellido</b></td><td><b>$segundo_apellido</b></td><td><b>$primer_nombre</b></td><td><b>$segundo_nombre</b></td></tr>
	<tr align='center'><td><font size='-1'><font size='-2'>Primer Apellido</DIV></font></td><td><font size='-2'>Segundo Apellido</font></td><td><font size='-2'>Primer Nombre</font></td><td><font size='-2'>Segundo Nombre</font></td></tr>

	</table><b>Tipo documento de Identificación:</b>
	<table border='0'  width='90%'>
	<tr valign='top'>
		<td >
		<input type='checkbox' disabled='true' $t4 > Registro Civil
	<br><input type='checkbox' disabled='true' $t5 > Tarjeta de identidad
	<br><input type='checkbox' disabled='true' $t1 > Cédula de ciudadanía
	<br><input type='checkbox' disabled='true' $t2 > Cédula de extranjería
		</td>
		<td>
		<input type='checkbox' disabled='true' $t3 > Pasaporte
	<br><input type='checkbox' disabled='true' $t6 > Adulto sin identificación
	<br><input type='checkbox' disabled='true' $t7 > Menor sin identificación
		</td>
		<td valign='bottom'>
		<div align='right'>|<b>$documento_numero</b>|<br>
		<font size='-2'>Número documento de identificación</font>
		<br><br>Fecha de nacimiento: |<b>$fecha_nacimiento</b>|</div>
		</td>
	</tr>
	</table><hr>
	<table width='100%' border='0'>
	<tr>
		<td>Dirección de Residencia Habitual: <b>$direccion_usuario</b>
		</td>
		<td align='right'>Telefono: |<b>$telefono_usuario</b>|
		</td>
	</tr>
	<tr>
		<td>Departamento: $usuario_nombre_departamento |<b>$departamento_usuario</b>|
		</td>
		<td align='right'>Municipio: $usuario_nombre_ciudad  |<b>$ciudad_usuario</b>|
		</td>
	</tr>
	</table>
	
	<hr>
	<b>Cobertura en salud</b>
	<table border='0'  width='90%'>
	<tr valign='top'>
		<td >
		<input type='checkbox' disabled='true' $cr1 > Regimen contributivo
	<br><input type='checkbox' disabled='true' $cr2 > Regimen subsidiado - total

		</td>
		<td>
		<input type='checkbox' disabled='true' $cr9 > Regimen subsidiado - parcial
		<br><input type='checkbox' disabled='true' $r11 > Población pobre no asegurada con SISBEN
	
		</td>
		<td>
		<input type='checkbox' disabled='true' $cr10 > Población pobre no asegurada sin SISBEN
	<br><input type='checkbox' disabled='true' $cr8 > Desplazado
	
		</td>
		<td>
		<input type='checkbox' disabled='true' $cr12 > Plan adicional de salud
	<br><input type='checkbox' disabled='true' $cr5 > Otro
	
		</td>
		
	</tr>
	</table>
</td>
</tr>
<tr>
	<td>
	<div align='center'><b>SERVICIOS AUTORIZADOS</b></div><hr>
	
	
	<b>Ubicación del Paciente en el momento de la solicitud de autorización:</b><br>
	
	<table border='0' width='100%'>
	<tr valign='top'>
		<td >
		
		<input type='checkbox' disabled='true' $up1 ><font size='-1'> Consulta externa</font> 
		<br><input type='checkbox' disabled='true' $up2 ><font size='-1'> Urgencias</font>
	
		</td>
		<td align='right'> <input type='checkbox' disabled='true' $up3 ><font size='-1'> Hospitalización</font> 
		</td>
		<td align='right'><font size='-1'><b> Servicio </b></font> $ubicacion_servicio <font size='-1'><b> Cama </b></font> |<b>$ubicacion_cama</b>|
		</td>
	</tr>
	
	</table>
	<hr> 
	
	<b><font size='-1'>Manejo Integral según Guía:</font></b> $guia
	
	<Hr>
	<table cellpadding='5' cellspacing='0' border='0'  width='90%' align='center'>
	<tr valign='top'>
		<td><font size='-2'>Código CUPS</font></td>
		<td><font size='-2'>Cantidad</font></td>
		<td width='100%'><font size='-2'>Descripción</font></td>
	</tr>
	$cups
	</table>
	<hr>
	$pagos
	
	</td>
</tr>
<tr>
	<td><div align='center'><b>DATOS DE LA PERSONA QUE INFORMA</b></div>
	<table width='100%' border='0'>
	<tr>
		<td>
			<font size='-1'>Nombre de quien informa:</font>
		</TD>
		<TD align='right'></td>
	</tr>
	<tr>
		<td><b>$nombre_completo_funcionario</b>
		</td>
		<td>Teléfono:  Indicativo |<b>$telefono_indicativo_autoriza</b> Número |<b>$telefono_numero_autoriza</b>| Extención|<b>$telefono_extencion_autoriza</b>|<br>Telefono celular: |<b>$telefono_celular_autoriza </b>|
		</td>
	</tr>
	<tr>
		<td><font size='-1'>Cargo o actividad:</font> <b>$cargo_funcionario</b>
		</td>
		<td align='right'>
		</td>
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
